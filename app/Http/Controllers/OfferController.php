<?php

namespace App\Http\Controllers;

use App\Offer;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class OfferController extends Controller

{
    function __construct()
    {
        $this->middleware('permission:offer-list|offer-create|offer-edit|offer-delete', ['only' => ['index','show']]);
        $this->middleware('permission:offer-create', ['only' => ['create','store']]);
        $this->middleware('permission:offer-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:offer-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $offers = Offer::latest()->get();
        return view('backend.offers.index',compact('offers'));
    }

    public function create()
    {
        return view('backend.offers.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $offers = new Offer;
        $offers->description = $request->description;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
//            resize image for hospital and upload
            $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/offers/'.$imagename, $proImage);


        }else {
            $imagename = "default.png";
        }

        $offers->image = $imagename;
        //dd($offers);
        $offers->save();

        Toastr::success('Offers Created Successfully');
        return redirect()->route('offers.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $offers = Offer::find($id);
        return view('backend.offers.edit',compact('offers'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $offers = Offer::find($id);
        $offers->description = $request->description;
        $image = $request->file('image');
        if (isset($image)) {
            //make unique name for image
            $currentDate = Carbon::now()->toDateString();
            $imagename = $currentDate . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            //delete old image.....
            if(Storage::disk('public')->exists('uploads/offers/'.$offers->image))
            {
                Storage::disk('public')->delete('uploads/offers/'.$offers->image);
            }
//            resize image for hospital and upload
            $proImage =Image::make($image)->resize(300, 300)->save($image->getClientOriginalExtension());
            Storage::disk('public')->put('uploads/offers/'.$imagename, $proImage);


        }else {
            $imagename =  $offers->image;
        }

        $offers->image = $imagename;
        //dd($offers);
        $offers->save();

        Toastr::success('Offers Created Successfully');
        return redirect()->route('offers.index');
    }

    public function destroy($id)
    {
        $offers = Offer::find($id);
        //delete old image.....
        if(Storage::disk('public')->exists('uploads/offers/'.$offers->image))
        {
            Storage::disk('public')->delete('uploads/offers/'.$offers->image);
        }
        $offers->delete();
        Toastr::success('Offers Created Successfully');
        return redirect()->route('offers.index');
    }
}
