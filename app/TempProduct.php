<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempProduct extends Model
{
    public function product_category(){
    	$this->belongsTo('App\Category','article_no');
    }

}
