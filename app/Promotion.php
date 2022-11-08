<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['title','slug'];
    protected $hidden = ['created_at','updated_at'];

    public function contents()
    {
        return $this->hasMany('App\PromotionContent', 'promotion_id', 'id')->orderBy('order','asc');
    }

    public function products()
    {
        return $this->hasMany('App\PromotionContentProduct', 'promotion_id', 'id');
    }

    public function vouchers()
    {
        return $this->hasMany('App\PromotionContentVoucher', 'promotion_id', 'id');
    }
}
