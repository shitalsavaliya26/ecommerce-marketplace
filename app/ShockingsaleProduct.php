<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;


class ShockingsaleProduct extends Model
{
    protected $fillable = ['product_id','shockingsale_id','discount','goal','start_date','end_date'];
    protected $appends = ['percent_archived'];
    protected $hidden = ['created_at','updated_at'];

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function getPercentArchivedAttribute(){
        $percent = 0;
        $sold = Product::where('id',$this->product_id)->first()->soldBetweenDate($this->product_id,$this->start_date,$this->end_date);
        $percent = ($sold * 100) / $this->goal;
        return ['percent' => ($percent > 0) ? 100 : $percent, 'sold' => 10+$sold];
    }
}
