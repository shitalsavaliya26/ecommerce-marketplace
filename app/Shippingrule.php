<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shippingrule extends Model
{
    protected $table = 'shippingrules';

    protected $fillable = [
        'amount', 'shipping_type','min_weight','max_weight',
    ];

    public function shippingpostcode()
    {
    	return $this->hasMany('App\Shippingpostcode','rule_id','id');
    }

    public function shippingrulecompanies()
    {
    	return $this->hasMany('App\Shippingrulecompany','rule_id','id');
    }

    public function getshippingcompany()
    {
    	$Shippingrulecompany =  $this->hasMany('App\Shippingrulecompany','rule_id','id')->select('shipping_company_id')->get();

    	$shippingcompany = ShippingCompany::where(function ($query) use ($Shippingrulecompany)
    	{
    		foreach ($Shippingrulecompany as $company) 
    		{
    			$query->where('id',$company->shipping_company_id);
    		}
    	})->select('id','name')->get();

    	return $shippingcompany;
    }
}
