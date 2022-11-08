<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $hidden = ['created_at','updated_at','deleted_at'];
    protected $appends = ['name'];
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function variations()
    {
        return $this->hasMany(AttributeVariation::class);
    }

    public function getNameAttribute($value)
    {
        return $this->attribute->name;
    }
}
