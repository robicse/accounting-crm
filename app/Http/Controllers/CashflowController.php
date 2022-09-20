<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashflowController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cashflow-form', ['only' => ['cashflowForm']]);

    }

    public function cashflowForm(){
        return view('backend.new-account.cashFlow_form');
    }
    public function viewCashFlow(Request $request ){

        $date_from = date('Y-m-01');
        $date_to = date('Y-m-d');

        if ($request->isMethod('post') && $request->date_from && $request->date_to) {
            $date_from = $request->date_from;
            $date_to = $request->date_to;
        }
        return view('backend.new-account.cash-flow',compact('date_from','date_to'));
    }
}
