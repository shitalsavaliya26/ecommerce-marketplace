<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customerpricetier extends Model
{
	protected $table = "customerpricetier";
    protected $fillable = [
        'product_id','price','qty'
    ];
}
