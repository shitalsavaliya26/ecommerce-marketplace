<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingSellerAdditionalRule extends Model
{

    protected $fillable = ['shipping_company_seller_id','additional_weight','additional_weight_price'];
}
