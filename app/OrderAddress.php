<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'contact_number', 'address_line1',
        'address_line2', 'country', 'state',
        'town', 'postal_code', 'order_id', 'country_code', 'self_pickup_address'
    ];

    public function user()
    {
        return $this->hasOne('App\Order', 'id', 'order_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Order', 'order_id', 'id');
    }
}