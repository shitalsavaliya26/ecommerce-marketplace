<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopDecoration extends Model
{
    public function products()
    {
        return $this->hasMany('App\ShopDecorationProduct', 'shop_decoration_id', 'id');
    }

    public function images()
    {
        return $this->hasMany('App\ShopDecorationImage', 'shop_decoration_id', 'id');
    }
}
