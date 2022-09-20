<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlinePlatForm extends Model
{
    protected $table ='online_platforms';

    public function productSale()
    {
        return $this->belongsTo('App\ProductSale');
    }

}
