<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id', 'reg_no', 'phone_no', 'address_line1' , 
        'address_line2' , 'state', 'town', 'postal_code', 'certificate','country_code'
    ];

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }

}
