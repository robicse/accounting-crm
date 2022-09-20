<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleServiceDuration extends Model
{
    public function sale_service()
    {
        return $this->belongsTo('App\SaleService','sale_service_id');
    }
}
