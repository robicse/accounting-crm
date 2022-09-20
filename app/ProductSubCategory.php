<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model
{
    public function product_category(){
        return $this->belongsTo('App\ProductCategory');
    }
}
