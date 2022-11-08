<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippingpostcode extends Model
{
    protected $table = 'shipping_postcode';

    protected $fillable = [
        'rule_id', 'shippingcompany_id'
    ];

    public function shippingpostcode()
    {
    	return $this->hasMany('App\Shippingpostcode','rule_id','id');
    }

    public function postcode()
    {
    	return $this->belongsTo('App\Postalcode');
    }
}
