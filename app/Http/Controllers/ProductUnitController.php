<?php

namespace App\Http\Controllers;

use App\ProductUnit;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductUnitController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-unit-list|product-unit-create|product-unit-edit|product-unit-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-unit-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-unit-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-unit-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $productUnits = ProductUnit::latest()->get();
        return view('backend.productUnit.index', compact('productUnits'));
    }

    public function create()
    {
        return view('backend.productUnit.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productUnit = new ProductUnit;
        $productUnit->name = $request->name;
        $productUnit->slug = Str::slug($request->name);
        $productUnit->save();

        Toastr::success('Product Capacity Created Successfully');
        return redirect()->route('productUnit.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productBrand = ProductUnit::find($id);
        return view('backend.productUnit.edit', compact('productBrand'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productUnit = ProductUnit::find($id);
        $productUnit->name = $request->name;
        $productUnit->slug = Str::slug($request->name);
        $productUnit->save();

        Toastr::success('Product Capacity Updated Successfully');
        return redirect()->route('productUnit.index');
    }

    public function destroy($id)
    {
        ProductUnit::destroy($id);
        Toastr::success('Product Capacity Deleted Successfully');
        return redirect()->route('productUnit.index');
    }
}
