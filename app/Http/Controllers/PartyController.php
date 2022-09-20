<?php

namespace App\Http\Controllers;

use App\Account;
use App\Helpers\UserInfo;
use App\Imports\CustomersImport;
use App\Party;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;


class PartyController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:party-list|party-create|party-edit|party-delete', ['only' => ['index','show']]);
        $this->middleware('permission:party-create', ['only' => ['create','store']]);
        $this->middleware('permission:party-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:party-delete', ['only' => ['destroy']]);
        $this->middleware('permission:supplier-list', ['only' => ['supplier']]);
        $this->middleware('permission:whole-list', ['only' => ['wholeCustomer']]);
    }

    public function index()
    {
        //UserInfo::smsAPI("8801725930131",'Testing');
        $parties = Party::where('type','=','customer')->Orderby('id', 'desc')->get();
        //dd($parties);
        return view('backend.party.index',compact('parties'));
    }

    public function supplier()
    {

        $parties = Party::where('type','=','supplier')->latest()->get();
        return view('backend.party.supplier',compact('parties'));
    }
     public function wholeCustomer()
        {

            $parties = Party::where('type','=','own')->Orderby('id', 'desc')->get();
            //dd($parties);
            return view('backend.party.whole-customer',compact('parties'));
        }


    public function create()
    {
        return view('backend.party.create');
    }
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'type'=> 'required',
            'name' => 'required',
            'phone'=> 'required|unique:parties,phone',
            'email'=> '',
        ]);
        $parties = new Party();
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = $request->status;

        $parties->save();

        $insert_id = $parties->id;
        //dd($insert_id);
        if($insert_id  && $request->type == 2){
            $text_for_customer = "Dear  $parties->name Sir,
Thank you for purchasing from CleanTech Engineering, your Customer ID is  C000$insert_id.
Rate us on www.facebook.com/cleantechbd and order online from www.cleantech.com.bd
For any queries call our support 09638-888 000..";
            UserInfo::smsAPI("88".$parties->phone,$text_for_customer);

            $user_data['name'] = $request->name;
            $user_data['email'] = $request->email;
            $user_data['phone'] = $request->phone;
            $user_data['password'] = Hash::make(123456);
            $user_data['party_id'] = $insert_id;
            //$user_data['role_id'] = 3;
            //dd($user_data);
            $user = User::create($user_data);

            $user->assignRole('Customer');
          // dd($user);
        }
//        $account = DB::table('accounts')->where('HeadLevel',3)->where('HeadCode', 'like', '1010301%')->Orderby('created_at', 'desc')->limit(1)->first();
//        //dd($account);
//        if(!empty($account)){
//            $headcode=$account->HeadCode+1;
//            //$p_acc = $headcode ."-".$request->name;
//        }else{
//            $headcode="1010301";
//            //$p_acc = $headcode ."-".$request->name;
//        }
//        $p_acc = $request->name."-".$request->phone;
//
//        $PHeadName = 'Account Receivable';
//        $HeadLevel = 3;
//        $HeadType = 'A';
//
//
//        $account = new Account();
//        $account->party_id      = $insert_id;
//        $account->HeadCode      = $headcode;
//        $account->HeadName      = $p_acc;
//        $account->PHeadName     = $PHeadName;
//        $account->HeadLevel     = $HeadLevel;
//        $account->IsActive      = '1';
//        $account->IsTransaction = '1';
//        $account->IsGL          = '1';
//        $account->HeadType      = $HeadType;
//        $account->CreateBy      = Auth::User()->id;
//        $account->UpdateBy      = Auth::User()->id;
//        $account->save();


        Toastr::success('Party Created Successfully', 'Success');
        return redirect()->route('party.index');

    }


    public function show($id)
    {
        //
    }
    public function edit($id)
    {

        $parties = Party::find($id);
       // dd($parties);
        return view('backend.party.edit',compact('parties'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'type'=> 'required',
            'name'=> 'required',
            'phone'=> 'required',
            'email'=> '',
            'address'=> '',
        ]);

        $parties = Party::find($id);
        $parties->type = $request->type;
        $parties->name = $request->name;
        $parties->phone = $request->phone;
        $parties->email = $request->email;
        $parties->address = $request->address;
        $parties->status = $request->status;
        // dd($parties);
        $parties->save();
        $insert_id = $parties->id;
        //dd($insert_id);
        if($insert_id  && $request->type == 2){
            $text_for_customer = "Dear  $parties->name Sir,
Thank you for purchasing from CleanTech Engineering, your Customer ID is  C000$insert_id.
Rate us on www.facebook.com/cleantechbd and order online from www.cleantech.com.bd
For any queries call our support 09638-888 000..";
            UserInfo::smsAPI("88".$parties->phone,$text_for_customer);




            // user
            $user = User::where('party_id',$insert_id)->first();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $exist_phone_number = User::where('phone',$request->phone)->get();
            if ( count($exist_phone_number) >0  ){
                Toastr::success(' Mobile number allready Exist', 'Success');
                return back();
            }
            $user->email = $request->email;
            $user->password = Hash::make(123456);
            $user->update();
             //dd($user);
        }
        Toastr::success('Party Updtaed Successfully', 'Success');
        return redirect()->route('party.index');
    }


    public function destroy($id)
    {
        $parties = Party::find($id);
        $parties->delete();
        Toastr::success('Party Deleted Successfully Done!');
        return redirect()->route('party.index');
    }
    public function checkPhoneNumber(Request $request ){
        $phone = $request->phone;
        $exist_phone_number = Party::where('phone',$phone)->get();
        $exist_phone_number_provider = User::where('phone',$phone)->get();
        if (count($exist_phone_number) >0 or count($exist_phone_number_provider) >0)
        {
            $check_number = "Found";
        }
        else{
            $check_number = "Not Found";
        }
        return response()->json(['success'=>true,'data'=>$check_number]);
    }
    public function checkPhoneNumberProvider(Request $request ){
        $phone = $request->phone;
        $exist_phone_number = Party::where('phone',$phone)->get();
        $exist_phone_number_provider = User::where('phone',$phone)->get();
        if (count($exist_phone_number) >0 or count($exist_phone_number_provider) >0)
        {
            $check_number = "Found";
        }
        else{
            $check_number = "Not Found";
        }
        return response()->json(['success'=>true,'data'=>$check_number]);
    }

    public function importExportView()
    {
        return view('backend.party.index');
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');

    }

    public function import()
    {
        if(!request()->file('file')){
            Toastr::success('File input can not left blank');
            return redirect()->back();
        }

        Excel::import(new CustomersImport,request()->file('file'));
        $get_party_id = User::where('party_id','!=','NULL')->latest('id')->pluck('party_id')->first();

        if($get_party_id == null){
            $get_party = Party::all();

            foreach($get_party as $data){
                $user = new User();
                $user->party_id = $data->id;
                $user->name = $data->name;
                $user->phone = $data->phone;
                $user->email = $data->email;
                $user->password = Hash::make(123456);
                $user->save();

                $account = DB::table('accounts')->where('HeadLevel',3)->where('HeadCode', 'like', '1010301%')->Orderby('created_at', 'desc')->limit(1)->first();
                //dd($account);
                if(!empty($account)){
                    $headcode=$account->HeadCode+1;
                    //$p_acc = $headcode ."-".$request->name;
                }else{
                    $headcode="1010301";
                    //$p_acc = $headcode ."-".$request->name;
                }
                $p_acc = $data->name;

                $PHeadName = 'Account Receivable';
                $HeadLevel = 3;
                $HeadType = 'A';

                $account = new Account();
                $account->HeadCode      = $headcode;
                $account->HeadName      = $p_acc;
                $account->PHeadName     = $PHeadName;
                $account->HeadLevel     = $HeadLevel;
                $account->IsActive      = '1';
                $account->IsTransaction = '1';
                $account->IsGL          = '1';
                $account->HeadType      = $HeadType;
                $account->CreateBy      = Auth::User()->id;
                $account->UpdateBy      = Auth::User()->id;
                $account->save();
            }
        }else{
            //dd($get_party_id);
            $get_party = Party::where('id','>',$get_party_id)->get();
            if(count($get_party) > 0){
                foreach($get_party as $data){
                    $user = new User();
                    $user->party_id = $data->id;
                    $user->name = $data->name;
                    $user->phone = $data->phone;
                    $user->email = $data->email;
                    $user->password = Hash::make(123456);
                    $user->save();

                    $account = DB::table('accounts')->where('HeadLevel',3)->where('HeadCode', 'like', '1010301%')->Orderby('created_at', 'desc')->limit(1)->first();
                    //dd($account);
                    if(!empty($account)){
                        $headcode=$account->HeadCode+1;
                        //$p_acc = $headcode ."-".$request->name;
                    }else{
                        $headcode="1010301";
                        //$p_acc = $headcode ."-".$request->name;
                    }
                    $p_acc = $data->name;

                    $PHeadName = 'Account Receivable';
                    $HeadLevel = 3;
                    $HeadType = 'A';

                    $account = new Account();
                    $account->HeadCode      = $headcode;
                    $account->HeadName      = $p_acc;
                    $account->PHeadName     = $PHeadName;
                    $account->HeadLevel     = $HeadLevel;
                    $account->IsActive      = '1';
                    $account->IsTransaction = '1';
                    $account->IsGL          = '1';
                    $account->HeadType      = $HeadType;
                    $account->CreateBy      = Auth::User()->id;
                    $account->UpdateBy      = Auth::User()->id;
                    $account->save();
                }
            }
        }

        //dd($get_party);

        Toastr::success('Uploaded Successfully');
        return redirect()->back();
        //return back();
    }
}
