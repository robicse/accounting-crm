<?php

namespace App\Http\Controllers;

use App\ProductBrand;
use App\ProductCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductBrandController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-brand-list|product-brand-create|product-brand-edit|product-brand-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-brand-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-brand-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-brand-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $productBrands = ProductBrand::latest()->get();
        return view('backend.productBrand.index', compact('productBrands'));
    }

    public function create()
    {
        return view('backend.productBrand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productBrand = new ProductBrand;
        $productBrand->name = $request->name;
        $productBrand->slug = Str::slug($request->name);
        $productBrand->save();

        Toastr::success('Product Brand Created Successfully');
        return redirect()->route('productBrands.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productBrand = ProductBrand::find($id);
        return view('backend.productBrand.edit', compact('productBrand'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productBrand = ProductBrand::find($id);
        $productBrand->name = $request->name;
        $productBrand->slug = Str::slug($request->name);
        $productBrand->save();

        Toastr::success('Product Brand Updated Successfully');
        return redirect()->route('productBrands.index');
    }

    public function destroy($id)
    {
        ProductBrand::destroy($id);
        Toastr::success('Product Brand Deleted Successfully');
        return redirect()->route('productBrands.index');
    }
}
