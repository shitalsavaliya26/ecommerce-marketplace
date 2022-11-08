<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id','price','tier_id'
    ];

    public function tier()
    {
        return $this->hasOne('App\ProductPriceTier','id','tier_id');
    }

}
