<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductProduction extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
