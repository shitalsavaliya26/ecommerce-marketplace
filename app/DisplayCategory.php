<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisplayCategory extends Model
{
    use SoftDeletes;
    protected $hidden = ['created_at','updated_at'];

    public function displayCategoryProducts()
    {
        return $this->hasMany('App\DisplayCategoryProduct', 'display_category_id', 'id')->orderBy('sequence', 'asc');
    }

    public function displayCategoryBanners()
    {
        return $this->hasMany('App\DisplayCategoryBanner')->orderBy('sequence', 'asc');
    }
}
