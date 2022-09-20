<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPurchaseDetail extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function product_brand(){
        return $this->belongsTo('App\ProductBrand');
    }

    public function product_unit(){
        return $this->belongsTo('App\ProductUnit');
    }
}
