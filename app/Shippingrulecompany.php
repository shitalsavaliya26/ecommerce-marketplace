<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippingrulecompany extends Model
{
    protected $table = 'shippingrulecompany';

    protected $fillable = [
        'rule_id', 'shipping_company_id'
    ];

    public function shippingcomapany()
    {
    	return $this->hasOne('App\ShippingCompany','id','shipping_company_id');
    }
}
