<?php

namespace App\Exports;

use App\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

//class TransactionExport implements FromCollection
//{
//    public function collection()
//    {
//        return Transaction::all();
//    }
//}

class TransactionExport implements FromView
{
    public function view(): view
    {
        return view('backend.transaction.transaction-excel',[
            'stores'=> Store::all()
        ]);
    }
}
