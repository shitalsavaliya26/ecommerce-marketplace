<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionContent extends Model
{
    protected $fillable = ['promotion_id','type','content','order'];

    public function products()
    {   
        // if($this->type == 'product_slider' || $this->type == 'products_grid'){
            return $this->hasMany('App\PromotionContentProduct', 'promotion_content_id');
        // }
    }

    public function vouchers()
    {
        // if($this->type == 'voucher'){
            return $this->hasMany('App\PromotionContentVoucher', 'promotion_content_id', 'id');
        // }
    }
}
