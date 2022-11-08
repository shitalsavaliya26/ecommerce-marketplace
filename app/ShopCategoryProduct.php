<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryProduct extends Model
{
    public function product()
    {
         return $this->hasOne('App\Product', 'id', 'product_id')->where('is_deleted','0')->where('status','active');
    }
}
