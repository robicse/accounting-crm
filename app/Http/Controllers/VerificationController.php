<?php

namespace App\Http\Controllers;

use App\Helpers\UserInfo;
use App\VerificationCode;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    public function getPhoneNumber(){

        return view('backend.check-phone-number');
    }
    public function checkPhoneNumber(Request $request){

        //dd($request->all());
        $user = User::where('phone',$request->phone)->first();
        //dd($user);
        if (!empty($user)) {
            $verification = VerificationCode::where('phone',$user->phone)->first();
            if (!empty($verification)){
                $verification->delete();
            }
            //dd($verification);
            $verCode = new VerificationCode();
            $verCode->phone = $user->phone;
            $verCode->code = mt_rand(1111,9999);
            $verCode->status = 0;
           // dd($verCode);
            $verCode->save();
            $text = "Dear ".$user->name.", Your Clean Tech Engineering  OTP is ".$verCode->code;
//        echo $text;exit();
            UserInfo::smsAPI("88".$verCode->phone,$text);

            Toastr::success('Thank you for your registration. We send a verification code in your mobile number. please verify your phone number.' ,'Success');
            //$verCode = $verCode->phone;
            //dd($text);
            //dd('gg');
            return view('backend.send_otp',compact('verCode'));
        }else{
            Toastr::error('This phone number does not exist to the system');
            return redirect()->back();
        }
    }
    public function otpStore(Request $request) {
        //dd($request->all());
        if ($request->isMethod('post')){
            $check = VerificationCode::where('code',$request->code)->where('phone',$request->phone)->where('status',0)->first();
            if (!empty($check)) {
                $check->status = 1;
                $check->update();
                $user = User::where('phone',$request->phone)->first();
                $user->verification_code = $request->code;
                $user->save();
                Toastr::success('Your phone number successfully verified.' ,'Success');
                return view('backend.reset_password',compact('user'));
            }else{
                //$verCode = $request->phone;
                $verCode = VerificationCode::where('phone',$request->phone)->where('status',0)->first();
                Toastr::error('Invalid Code' ,'Error');
                return view('backend.send_otp',compact('verCode'));
            }
        }
    }
    public function passwordUpdate(Request $request, $id) {
        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Your Password Updated successfully verified.' ,'Success');
        return redirect()->route('login');
    }
}
