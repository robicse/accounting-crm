<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }

    public function party()
    {
        return $this->belongsTo('App\Party');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function productsaledetails()
    {
        return $this->hasMany('App\ProductSaleDetail');
    }
    public function onlinePlatForm()
    {
        return $this->belongsTo('App\OnlinePlatForm','online_platform_id');
    }
    public function provider()
    {
        return $this->belongsTo('App\User');
    }
}
