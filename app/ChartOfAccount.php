<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function PostingFormDetails(){
        return $this->belongsTo('App\PostingFormDetails');
    }
}
