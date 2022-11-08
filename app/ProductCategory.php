<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
     protected $fillable = [
       'product_id','category_id'
    ];


    public function product()
    {
         return $this->hasOne('App\Product', 'id', 'product_id')->where('is_deleted','0');
    }

    public function category()
    {
         return $this->hasOne('App\Category', 'id', 'category_id')->where('status', 'active')->where('is_deleted','0');
    }
}
