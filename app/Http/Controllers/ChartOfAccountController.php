<?php

namespace App\Http\Controllers;

use App\ChartOfAccount;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{

    public function index()
    {
       $chartOfAcc = ChartOfAccount::all();
       return view('backend.chart-of-account.index',compact('chartOfAcc'));
    }


    public function create()
    {
        return view('backend.chart-of-account.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
            $chartOfAcc = new ChartOfAccount();
            $chartOfAcc->group_1 = $request->group_1;
            $chartOfAcc->group_2 = $request->group_2;
            $chartOfAcc->group_3 = $request->group_3;
            $chartOfAcc->group_4 = $request->group_4;
            $chartOfAcc->status = $request->status;
            $chartOfAcc->head_type = $request->head_type;
            $chartOfAcc->save();
            Toastr::success('Chart Of Account Created Successfully', 'Success');
            return redirect()->back();

    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $coa =  ChartOfAccount::find($id);
        return view('backend.chart-of-account.edit',compact('coa'));
    }


    public function update(Request $request, $id)
    {
        $chartOfAcc =  ChartOfAccount::find($id);
        $chartOfAcc->group_1 = $request->group_1;
        $chartOfAcc->group_2 = $request->group_2;
        $chartOfAcc->group_3 = $request->group_3;
        $chartOfAcc->group_4 = $request->group_4;
        $chartOfAcc->status = $request->status;
        $chartOfAcc->head_type = $request->head_type;
        $chartOfAcc->save();

        Toastr::success('Chart Of Account Updated Successfully', 'Success');
        return redirect()->route('ChartOfAccount.index');
    }


    public function destroy($id)
    {
        $chartOfAcc =  ChartOfAccount::find($id);
        $chartOfAcc->delete();

        Toastr::success('Chart Of Account Deleted Successfully', 'Success');
        return redirect()->route('ChartOfAccount.index');
    }
}
