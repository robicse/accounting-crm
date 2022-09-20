<?php

namespace App\Http\Controllers;

use App\OfficeCostingCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfficeCostingCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:officeCostingCategories-list|officeCostingCategories-create|officeCostingCategories-edit|officeCostingCategories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:officeCostingCategories-create', ['only' => ['create','store']]);
        $this->middleware('permission:officeCostingCategories-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:officeCostingCategories-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $officeCostingCategories = OfficeCostingCategory::latest()->get();
        return view('backend.officeCostingCategory.index', compact('officeCostingCategories'));
    }

    public function create()
    {
        return view('backend.officeCostingCategory.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $officeCostingCategory = new OfficeCostingCategory();
        $officeCostingCategory->name = $request->name;
        $officeCostingCategory->slug = Str::slug($request->name);
        $officeCostingCategory->save();

        Toastr::success('Office Costing Category Created Successfully');
        return redirect()->route('officeCostingCategory.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $officeCostingCategory = OfficeCostingCategory::find($id);
        return view('backend.officeCostingCategory.edit', compact('officeCostingCategory'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $officeCostingCategory = OfficeCostingCategory::find($id);
        $officeCostingCategory->name = $request->name;
        $officeCostingCategory->slug = Str::slug($request->name);
        $officeCostingCategory->save();

        Toastr::success('Office Costing Category Updated Successfully');
        return redirect()->route('officeCostingCategory.index');
    }

    public function destroy($id)
    {
        OfficeCostingCategory::destroy($id);
        Toastr::success('Office Costing Category Deleted Successfully');
        return redirect()->route('officeCostingCategory.index');
    }
}
