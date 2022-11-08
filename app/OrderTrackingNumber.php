<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTrackingNumber extends Model
{
    protected $fillable = ['seller_id','price', 'order_id', 'tracking_number'];
}
