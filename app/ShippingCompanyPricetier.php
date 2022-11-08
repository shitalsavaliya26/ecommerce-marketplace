<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCompanyPricetier extends Model
{
    public function shippingcompany()
    {
        return $this->belongsTo('App\ShippingCompany', 'shipping_company_id', 'id');
    }
}