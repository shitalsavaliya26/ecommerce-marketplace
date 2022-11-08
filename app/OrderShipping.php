<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
        protected $fillable = ['seller_id','price','shipping_company','detail'];

        protected $appends = ['courier_company'];
        
        protected $hidden = [
		'created_at','updated_at'
	    ];

        public function shippingcomapny()
        {
            return $this->belongsTo('App\ShippingCompany','shipping_company','id');
        }


        public function getCourierCompanyAttribute()
        {
            return $this->shippingcomapny->name;
        }
}
