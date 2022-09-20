<?php

namespace App\Http\Controllers;

use App\SaleService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class   UserDashboardController extends Controller
{
    public function dashboard()
    {
        $productHistory = \App\ProductSale::where('party_id', Auth::User()->party_id)->latest()->get();
        $saleServices = SaleService::where('provider_id', Auth::id())->latest()->get();
            //dd($saleServices);
       return view('backend.user-dashboard.dashboard',compact('productHistory','saleServices'));
    }
    public function status(Request $request)
    {
        //dd($request->all());
        $category = SaleService::findOrFail($request->id);
        $category->status = $request->status;
        if($category->save()){
            return 0;
        }
        return 1;
    }
    public function editProfile(){
       return view('backend.user-dashboard.profile');
    }
    public function productHistory()
    {
        //dd('dd');
        $productHistory = \App\ProductSale::where('party_id', Auth::User()->party_id)->latest()->get();
        //dd($productHistory);

        return view('backend.user-dashboard.product-history', compact('productHistory'));
    }
    public function productDetails($id)
    {
        //dd('h');
        $productHistory = \App\ProductSale::find($id);
        //dd($productHistory);
        return view('backend.user-dashboard.product-history-details', compact('productHistory'));

    }
    public function serviceList($id)
    {
       // dd($id);
       // $serviceDetails = \App\ProductSaleDetail::find($id);

        $saleServiceDurations = DB::table('sale_service_durations')
            ->join('sale_services','sale_service_durations.sale_service_id','sale_services.id')
            ->join('services','sale_services.service_id','services.id')
            ->where('sale_services.product_sale_detail_id','=',$id)
            //->where('service_date','<=',$custom_date_end)
            ->select('sale_service_durations.service_date','sale_services.*','services.name')
            ->orderby('service_date','ASC')
            ->get();
       // dd($saleServiceDurations);
        return view('backend.user-dashboard.service-list', compact('saleServiceDurations'));

    }
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
//            'mobile_number'=> 'required',
        ]);
        $user = \App\User::findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        Toastr::success('Profile Updated Successfully','Success');
        return redirect()->back();
    }
    public function changedPassword()
    {
        return view('backend.user-dashboard.edit-password');
    }

    public function changedPasswordUpdated(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $hashedPassword = Auth::user()->password;
        // dd($hashedPassword);
        if (Hash::check($request->old_password, $hashedPassword)) {
            //dd('okk');
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = \App\User::find(Auth::id());
                //dd($user);
                $user->password = Hash::make($request->password);
                //dd($user);
                $user->save();
                Toastr::success('Password Updated Successfully','Success');
                Auth::logout();
                return redirect()->route('login');
            } else {
                Toastr::error('New password cannot be the same as old password.', 'Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password  match.', 'Success');
            return redirect()->back();
        }

    }
    public function invoice(Request $request)
    {
        return view('backend.user-dashboard.invoice',compact('productSale'));
    }
    public function invoiceDetails(Request $request){
        //dd($request->all());
        //dd('dd');
        $query = $request->input('query');
        $productSales=\App\ProductSale::where('invoice_no','LIKE',"%$query%")->get();
       // dd($productSales);
        return view('backend.user-dashboard.invoice-details',compact('productSales'));
    }
}
