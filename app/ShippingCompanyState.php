<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCompanyState extends Model
{
    use SoftDeletes;
    
    protected $table = 'shipping_companies_state';

    protected $fillable = [
        'shipping_company_id', 'state','state_id'
    ];

    public function postcode()
    {
    	return $this->belongsTo('App\State');
    }

    public function shipping_company()
    {
        return $this->belongsTo('App\ShippingCompany');
    }

     public function states()
    {
        return $this->belongsTo('App\State','state_id');
    }

    

}