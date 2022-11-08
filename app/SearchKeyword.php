<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SearchKeyword extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at','updated_at'];

    public function getCategory()
    {
        return $this->belongsTo('App\Category', 'category_id')->where('status', 'active')->where('is_deleted','0');
    }
}
