<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $fillable = ['type','name','phone','email','address'];
}
