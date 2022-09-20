<?php

namespace App\Http\Controllers;

use App\OnlinePlatForm;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OnlinePlatFormController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:online-platform-list|online-platform-create|online-platform-edit|online-platform-delete', ['only' => ['index','show']]);
        $this->middleware('permission:online-platform-create', ['only' => ['create','store']]);
        $this->middleware('permission:online-platform-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:online-platform-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $online_platforms = OnlinePlatForm::latest()->get();
        return view('backend.online-platform.index', compact('online_platforms'));
    }


    public function create()
    {
        return view('backend.online-platform.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $online_platforms = new OnlinePlatForm;
        $online_platforms->name = $request->name;
        $online_platforms->save();

        Toastr::success('Online Platform Created Successfully');
        return redirect()->route('online_platform.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $online_platforms = OnlinePlatForm::find($id);
        return view('backend.online-platform.edit', compact('online_platforms'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $online_platforms =OnlinePlatForm::find($id);
        $online_platforms->name = $request->name;
        $online_platforms->save();

        Toastr::success('Online Platform Edited Successfully');
        return redirect()->route('online_platform.index');
    }


    public function destroy($id)
    {
        OnlinePlatForm::destroy($id);
        Toastr::success('Online Platform Deleted Successfully');
        return redirect()->route('online_platform.index');
    }
}
