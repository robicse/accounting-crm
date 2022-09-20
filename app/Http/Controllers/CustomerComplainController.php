<?php

namespace App\Http\Controllers;

use App\CustomerComplain;
use App\Helpers\UserInfo;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CustomerComplainController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer-complain-list|customer-complain-create|customer-complain-edit|customer-complain-delete', ['only' => ['index','show']]);
        $this->middleware('permission:customer-complain-create', ['only' => ['create','store']]);
        $this->middleware('permission:customer-complain-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:customer-complain-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $customer_complains = CustomerComplain::latest()->get();
        return view('backend.customer-complain.index', compact('customer_complains'));
    }

    public function create()
    {
        return view('backend.customer-complain.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required'
        ]);

        $customer_complains = new CustomerComplain;
        $customer_complains->name = $request->name;
        $customer_complains->phone = $request->phone;
        $customer_complains->address = $request->address;
        $customer_complains->date = $request->date;
        $customer_complains->description = $request->description;

        $customer_complains->save();
        $insert_id = $customer_complains->id;

        if($insert_id) {
            $text_for_customer = "Dear  $customer_complains->name ,
Your service request has been received under Complain ID- COMP$insert_id.
For more info contact 09638-888 000";

            UserInfo::smsAPI("88" . $customer_complains->phone, $text_for_customer);

            Toastr::success('Customer Complain Created Successfully');
            return redirect()->route('customer_complain.index');
            }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $customer_complains = CustomerComplain::find($id);
        return view('backend.customer-complain.edit', compact('customer_complains'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $customer_complains =  CustomerComplain::find($id);
        $customer_complains->name = $request->name;
        $customer_complains->phone = $request->phone;
        $customer_complains->address = $request->address;
        $customer_complains->date = $request->date;
        $customer_complains->status = $request->status;
        $customer_complains->description = $request->description;
        $customer_complains->save();

        Toastr::success('Customer Complain Updated Successfully');
        return redirect()->route('customer_complain.index');
    }
    public function complainDone($id){
        $customer_complains = CustomerComplain::find($id);
        return view('backend.customer-complain.done', compact('customer_complains'));
    }

    public function complainComplete(Request $request, $id){
        $customer_complains =  CustomerComplain::find($id);
        $customer_complains->phone = $request->phone;
        $customer_complains->status = $request->status;
        $customer_complains->save();

        $insert_id = $customer_complains->id;

        if($insert_id) {
            $text_for_customer = "প্রিয় গ্রাহক, আশা করি আপনার সাম্প্রতিক রিপোর্টকৃত  সমস্যাটির  সমাধান হয়েছে। যেকোনো প্রয়োজনে কল করুন ০৯৬৩৮-৮৮৮ ০০০ অথবা ভিসিট করুন www.cleantech.com.bd।";

            UserInfo::smsAPI("88" . $customer_complains->phone, $text_for_customer);

            Toastr::success('Customer Complain Updated Successfully');
            return redirect()->route('customer_complain.index');
        }
    }

    public function destroy($id)
    {
        CustomerComplain::destroy($id);
        Toastr::success('Customer Complain Deleted Successfully');
        return redirect()->route('customer_complain.index');
    }
}
