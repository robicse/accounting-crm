<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductProductionDetail extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
}
