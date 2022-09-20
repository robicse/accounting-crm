<?php

namespace App\Http\Controllers;

use App\Store;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:store-list|store-create|store-edit|store-delete', ['only' => ['index','show']]);
        $this->middleware('permission:store-create', ['only' => ['create','store']]);
        $this->middleware('permission:store-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:store-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $stores = Store::latest()->get();
        return view('backend.store.index', compact('stores'));
    }

    public function create()
    {
        return view('backend.store.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:stores,name',
            'phone' => 'required',
            'address' => 'required',
           // 'logo' => 'required',
        ]);

        $store = new Store;
        $store->name = $request->name;
        $store->slug = Str::slug($request->name);
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->website = $request->website;
        $store->page = $request->page;
        $store->email = $request->email;
        $logo = $request->file('logo');
        if(isset($logo)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $logoName = $currentDate . '-' . uniqid() . '.' . $logo->getClientOriginalExtension();
            //resize image for hospital and upload
            $proLogo =Image::make($logo)->resize(250, 80)->save($logo->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/store/'.$logoName, $proLogo);


        }else {
            $logoName = "default.png";
        }

        $store->logo = $logoName;
        $store->save();

        Toastr::success('Store Created Successfully');
        return redirect()->route('stores.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $store = Store::find($id);
        return view('backend.store.edit', compact('store'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('stores')->ignore($id),
            ],
            'phone' => 'required',
            'address' => 'required',
        ]);

        $store = Store::find($id);
        $store->name = $request->name;
        $store->slug = Str::slug($request->name);
        $store->phone = $request->phone;
        $store->address = $request->address;
        $store->website = $request->website;
        $store->page = $request->page;
        $store->email = $request->email;
        $logo = $request->file('logo');
        if(isset($logo)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $logoName = $currentDate . '-' . uniqid() . '.' . $logo->getClientOriginalExtension();
            //delete old image.....
            if(Storage::disk('public')->exists('uploads/store/'.$store->logo))
            {
                Storage::disk('public')->delete('uploads/store/'.$store->logo);
            }
            //resize image for hospital and upload
            $proLogo =Image::make($logo)->resize(250, 80)->save($logo->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/store/'.$logoName, $proLogo);


        }else {
            $logoName = $store->logo;
        }

        $store->logo = $logoName;
        $store->update();

        Toastr::success('Store Updated Successfully');
        return redirect()->route('stores.index');
    }

    public function destroy($id)
    {
        Store::destroy($id);
        Toastr::success('Store Deleted Successfully');
        return redirect()->route('stores.index');
    }
}
