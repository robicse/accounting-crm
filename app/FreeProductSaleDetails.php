<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeProductSaleDetails extends Model
{
    public function freeProduct(){
        return $this->belongsTo('App\FreeProduct');
    }
}
