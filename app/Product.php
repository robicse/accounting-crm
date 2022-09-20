<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function product_category(){
        return $this->belongsTo('App\ProductCategory');
    }

    public function product_sub_category(){
        return $this->belongsTo('App\ProductSubCategory');
    }

    public function product_brand(){
        return $this->belongsTo('App\ProductBrand');
    }

    public function product_unit(){
        return $this->belongsTo('App\ProductUnit');
    }
}
