<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleService extends Model
{
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
    public function product_sale_details()
    {
        return $this->belongsTo('App\ProductSaleDetail');
    }
    public function provider()
    {
        return $this->belongsTo('App\User');
    }
}
