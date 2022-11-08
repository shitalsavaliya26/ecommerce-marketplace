<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'id','name', 'description', 'status','is_deleted','displayhomescreen','sequence','slug', 'parent_id'
    ];
    protected $hidden = ['created_at','updated_at'];

    public function products()
    {
         return $this->hasMany('App\Product','category_id')->where('is_deleted','0');
    }

    public function images()
    {
        return $this->hasMany('App\CategoryImage','category_id');
    }

    public function image()
    {
        return (object)$this->hasOne('App\CategoryImage','category_id');
    }

    public function allproducts()
    {
         return $this->hasMany('App\ProductCategory','category_id')->whereHas('product');
    }

    public function productsData()
    {
        return $this->belongsToMany(Product::class, 'product_categories')->where('is_deleted','0');
    }

    public function childrenRecursive()
    {
        return $this->subs()->with('childrenRecursive');
    }

    public function subs()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id')->with('subs');
    }

    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id');
    }
}
