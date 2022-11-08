<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function attributevariation()
    {
        return $this->hasMany(AttributeVariation::class);
    }
}
