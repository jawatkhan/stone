<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
  public function parent() {
    return $this->belongsTo(static::class, 'parent_id');
  }

  //each category might have multiple children
  public function children() {
    return $this->hasMany(static::class, 'parent_id','id');
  }

  public function temp_product(){
  	return $this->hasMany('App\TempProduct','article_no');
  }

}
