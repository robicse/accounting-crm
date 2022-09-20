<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function COA(){
        return $this->belongsTo('App\ChartOfAccount','chart_of_account_id');
    }
}
