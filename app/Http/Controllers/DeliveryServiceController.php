<?php

namespace App\Http\Controllers;

use App\DeliveryService;
use App\ProductBrand;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliveryServiceController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:product-brand-list|product-brand-create|product-brand-edit|product-brand-delete', ['only' => ['index','show']]);
//        $this->middleware('permission:product-brand-create', ['only' => ['create','store']]);
//        $this->middleware('permission:product-brand-edit', ['only' => ['edit','update']]);
//        $this->middleware('permission:product-brand-delete', ['only' => ['destroy']]);
//    }

    public function index()
    {
        $deliveryServices = DeliveryService::latest()->get();
        return view('backend.deliveryService.index', compact('deliveryServices'));
    }

    public function create()
    {
        return view('backend.deliveryService.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $deliveryService = new DeliveryService;
        $deliveryService->name = $request->name;
        $deliveryService->slug = Str::slug($request->name);
        $deliveryService->save();

        Toastr::success('Delivery Service Created Successfully');
        return redirect()->route('deliveryService.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $deliveryService = DeliveryService::find($id);
        return view('backend.deliveryService.edit', compact('deliveryService'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $deliveryService = DeliveryService::find($id);
        $deliveryService->name = $request->name;
        $deliveryService->slug = Str::slug($request->name);
        $deliveryService->save();

        Toastr::success('Delivery Service Updated Successfully');
        return redirect()->route('deliveryService.index');
    }

    public function destroy($id)
    {
        DeliveryService::destroy($id);
        Toastr::success('Delivery Service Deleted Successfully');
        return redirect()->route('deliveryService.index');
    }
}
