<?php

namespace App\Exports;

use App\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LossProfitExportFilter implements FromView
{
    public function view(): view
    {
        //dd('okk2');
        //dd($_REQUEST);
        return view('backend.transaction.loss-profit-filter-excel',[
            'stores'=> Store::all()
        ]);
    }
}
