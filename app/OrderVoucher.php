<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderVoucher extends Model
{
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
