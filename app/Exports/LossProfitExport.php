<?php

namespace App\Exports;

use App\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LossProfitExport implements FromView
{
    public function view(): view
    {
        return view('backend.transaction.loss-profit-excel',[
            'stores'=> Store::all()
        ]);
    }
}
