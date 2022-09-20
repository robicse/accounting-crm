<?php

namespace App\Http\Controllers;

use App\Expense;
use App\OfficeCostingCategory;
use App\Store;
use App\Transaction;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpenseController extends Controller

{
    function __construct()
    {
        $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','show']]);
        $this->middleware('permission:expense-create', ['only' => ['create','store']]);
        $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        if($start_date && $end_date){
            if($auth_user == "Admin"){
                $expenses = Expense::where('date','>=',$start_date)->where('date','<=',$end_date)->latest()->get();
            }else{
                $expenses = Expense::where('date','>=',$start_date)->where('date','<=',$end_date)->where('user_id',$auth_user_id)->get();
            }
        }else{
            if($auth_user == "Admin"){
                $expenses = Expense::latest()->get();
            }else{
                $expenses = Expense::where('user_id',$auth_user_id)->get();
            }
        }
        return view('backend.expense.index',compact('expenses'));
    }

    public function create()
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $officeCostingCategories = OfficeCostingCategory::all() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }

        return view('backend.expense.create',compact('officeCostingCategories','stores'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'payment_type'=> 'required',
            'amount'=> 'required',
        ]);

        $expense = new Expense();
        $expense->user_id = Auth::id();
        $expense->store_id = $request->store_id;
        $expense->office_costing_category_id = $request->office_costing_category_id;
        $expense->payment_type = $request->payment_type;
        $expense->check_number = $request->check_number ? $request->check_number : NULL;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->save();

        $insert_id = $expense->id;
        if($insert_id){
            // transaction
            $transaction = new Transaction();
            //$transaction->invoice_no = $product_sale->invoice_no;
            $transaction->user_id = Auth::id();
            $transaction->store_id = $request->store_id;
            //$transaction->party_id = $product_sale->party_id;
            $transaction->ref_id = $insert_id;
            $transaction->transaction_type = 'expense';
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->amount = $request->amount;
            $transaction->date = $request->date;
            $transaction->save();
        }


        Toastr::success('Expense Created Successfully', 'Success');
        return redirect()->route('expenses.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $auth_user_id = Auth::user()->id;
        $auth_user = Auth::user()->roles[0]->name;
        $officeCostingCategories = OfficeCostingCategory::all() ;
        if($auth_user == "Admin"){
            $stores = Store::all();
        }else{
            $stores = Store::where('user_id',$auth_user_id)->get();
        }
        $expense = Expense::find($id);

        return view('backend.expense.edit',compact('expense','officeCostingCategories','stores'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'payment_type'=> 'required',
            'amount'=> 'required',
        ]);

        $expense = Expense::find($id);
        $expense->user_id = Auth::id();
        $expense->store_id = $request->store_id;
        $expense->office_costing_category_id = $request->office_costing_category_id;
        $expense->payment_type = $request->payment_type;
        $expense->check_number = $request->check_number ? $request->check_number : NULL;
        $expense->amount = $request->amount;
        //$expense->date = date('d-m-Y');
        $affectedRows = $expense->save();

        if($affectedRows){
            $transaction = Transaction::where('ref_id',$id)->first();
            $transaction->payment_type = $request->payment_type;
            $transaction->check_number = $request->check_number ? $request->check_number : '';
            $transaction->amount = $request->amount;
            //$transaction->date = $request->date;
            $transaction->save();
        }


        Toastr::success('Expense Updated Successfully', 'Success');
        return redirect()->route('expenses.index');
    }

    public function destroy($id)
    {
        Expense::destroy($id);
        Toastr::success('Expense Updated Successfully', 'Success');
        return redirect()->route('expenses.index');
    }

    public function newOfficeCostingCategory(Request $request){
        //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
        ]);
        $officeCostingCategory = new OfficeCostingCategory();
        $officeCostingCategory->name = $request->name;
        $officeCostingCategory->slug = Str::slug($request->name);
        $officeCostingCategory->save();
        $insert_id = $officeCostingCategory->id;

        if ($insert_id){
            $sdata['id'] = $insert_id;
            $sdata['name'] = $officeCostingCategory->name;
            echo json_encode($sdata);

        }
        else {
            $data['exception'] = 'Some thing mistake !';
            echo json_encode($data);

        }
    }
}
