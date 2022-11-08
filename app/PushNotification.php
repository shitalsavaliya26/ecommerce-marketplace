<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = ['receiver_id','sender_id','message','type','order_id'];
}
