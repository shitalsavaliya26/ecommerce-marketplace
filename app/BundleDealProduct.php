<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BundleDealProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class)->where('is_deleted','0')->where('status', 'active');
    }
}
