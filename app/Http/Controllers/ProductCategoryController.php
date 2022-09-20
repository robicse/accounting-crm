<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class ProductCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-category-list|product-category-create|product-category-edit|product-category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $productCategories = ProductCategory::latest()->get();
        //dd($productCategories);
        return view('backend.productCategory.index',compact('productCategories'));
    }

    public function create()
    {
        return view('backend.productCategory.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productCategory = new ProductCategory;
        $productCategory->name = $request->name;
        $productCategory->slug = Str::slug($request->name);
        $productCategory->save();

        Toastr::success('Product Category Created Successfully');
        return redirect()->route('productCategories.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productCategory = ProductCategory::find($id);
        return view('backend.productCategory.edit', compact('productCategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $productCategory = ProductCategory::find($id);
        $productCategory->name = $request->name;
        $productCategory->slug = Str::slug($request->name);
        $productCategory->update();

        Toastr::success('Product Category Updated Successfully');
        return redirect()->route('productCategories.index');
    }

    public function destroy($id)
    {
        ProductCategory::destroy($id);
        Toastr::success('Product Category Deleted Successfully');
        return redirect()->route('productCategories.index');
    }
}
