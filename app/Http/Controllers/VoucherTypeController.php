<?php

namespace App\Http\Controllers;

use App\VoucherType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VoucherTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:voucher-type-list|voucher-type-create|voucher-type-edit|voucher-type-delete', ['only' => ['index','show']]);
        $this->middleware('permission:voucher-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:voucher-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:voucher-type-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $voucherTypes = VoucherType::latest()->get();
        return view('backend.voucherType.index',compact('voucherTypes'));
    }

    public function create()
    {
        return view('backend.voucherType.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $voucherTypes = new VoucherType();
        $check_voucher_name = VoucherType::where('name',$request->name)->latest()->pluck('name')->first();
        if($check_voucher_name){
            Toastr::warning('Voucher Name Already Exists!', 'Warning');
            return redirect()->route('voucherType.create');
        }
        $voucherTypes->name = $request->name;
        $voucherTypes->slug = Str::slug($request->name);
        $voucherTypes->save();
        Toastr::success('Voucher Type Created Successfully', 'Success');
        return redirect()->route('voucherType.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $voucherTypes =  VoucherType::find($id);
        return view('backend.voucherType.edit',compact('voucherTypes'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $voucherTypes =  VoucherType::find($id);
        $check_voucher_name = VoucherType::where('name',$request->name)->latest()->pluck('name')->first();
        if($check_voucher_name){
            Toastr::warning('Voucher Name Already Exists!', 'Warning');
            return redirect()->route('voucherType.update');
        }
        $voucherTypes->name = $request->name;
        $voucherTypes->slug = Str::slug($request->name);
        $voucherTypes->save();
        Toastr::success('Voucher Type Edited Successfully', 'Success');
        return redirect()->route('voucherType.index');
    }


    public function destroy($id)
    {
        $voucherTypes =  VoucherType::find($id);
        $voucherTypes->delete();
        return redirect()->route('voucherType.index');
    }
}
