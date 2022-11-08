<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionContentProduct extends Model
{
    protected $fillable = ['promotion_id','product_id'];
    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
   }
}
