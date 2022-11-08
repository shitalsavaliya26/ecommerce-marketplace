<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundleDeal extends Model
{
    use SoftDeletes;

    public function BundleDealProducts()
    {
        return $this->hasMany(BundleDealProduct::class);
    }
}
