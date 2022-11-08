<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postalcode extends Model
{
    protected $fillable = [
        'postalcode'
    ];

    public function shippingpostcode()
    {
    	return $this->hasOne('Shippingpostcode','id','postcode_id');
    }

    public function Shippingcompanypostcode()
    {
    	return $this->hasOne('App\Shippingcompanypostcode','id','postcode_id');
    }
}
