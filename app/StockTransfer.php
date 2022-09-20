<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    public function user(){
        return $this->belongsTo('App\User','send_user_id');
    }

    public function from_store()
    {
        return $this->belongsTo('App\Store','from_store_id');
    }

    public function to_store()
    {
        return $this->belongsTo('App\Store','to_store_id');
    }

    public function deliveryService()
    {
        return $this->belongsTo('App\DeliveryService');
    }

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
