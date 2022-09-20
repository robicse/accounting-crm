<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\ProductSubCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductSubCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-sub-category-list|product-sub-category-create|product-sub-category-edit|product-sub-category-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-sub-category-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-sub-category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-sub-category-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
//        $productCategories = ProductCategory::all();
        $productSubCategories = ProductSubCategory::latest()->get();
        //dd($productSubCategories);
        return view('backend.productSubCategory.index', compact('productSubCategories','productCategories'));
    }

    public function create()
    {
        $productCategories = ProductCategory::all();
        return view('backend.productSubCategory.create', compact('productCategories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_category_id' => 'required',
            'name' => 'required',
        ]);

        $productSubCategory = new ProductSubCategory;
        $productSubCategory->product_category_id = $request->product_category_id;
        $productSubCategory->name = $request->name;
        $productSubCategory->slug = Str::slug($request->name);
        $productSubCategory->save();

        Toastr::success('Product Sub Category Created Successfully');
        return redirect()->route('productSubCategories.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productCategories = ProductCategory::all();
        $productSubCategory = ProductSubCategory::find($id);
        return view('backend.productSubCategory.edit', compact('productSubCategory','productCategories'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_category_id' => 'required',
            'name' => 'required',
        ]);

        $productSubCategory = ProductSubCategory::find($id);
        $productSubCategory->product_category_id = $request->product_category_id;
        $productSubCategory->name = $request->name;
        $productSubCategory->slug = Str::slug($request->name);
        $productSubCategory->update();

        Toastr::success('Product Sub Category Updated Successfully');
        return redirect()->route('productSubCategories.index');
    }

    public function destroy($id)
    {
        ProductSubCategory::destroy($id);
        Toastr::success('Product Sub Category Deleted Successfully');
        return redirect()->route('productSubCategories.index');
    }
}
