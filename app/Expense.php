<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function office_costing_category(){
        return $this->belongsTo('App\OfficeCostingCategory');
    }
}
