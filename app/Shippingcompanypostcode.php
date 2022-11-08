<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippingcompanypostcode extends Model
{
    protected $table = 'shipping_companies_postcode';

    protected $fillable = [
        'shipping_company_id', 'postcode_id'
    ];

    public function postcode()
    {
    	return $this->belongsTo('App\Postalcode');
    }
}
