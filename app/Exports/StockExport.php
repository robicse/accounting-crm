<?php

namespace App\Exports;

use App\Stock;
use App\Store;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/*class StockExport implements FromCollection
{
    public function collection()
    {
        return Stock::all();
    }
}*/

class StockExport implements FromView
{
    public function view(): view
    {
        return view('backend.stock.stock-excel',[
            'stores'=> Store::all()
        ]);
    }
}
