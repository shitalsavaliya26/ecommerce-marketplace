<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Helper;

class Shockingsale extends Model
{
    protected $fillable = ['title','slug','html'];
    public function products()
    {   
        // if($this->type == 'product_slider' || $this->type == 'products_grid'){
        return $this->hasMany('App\ShockingsaleProduct', 'shockingsale_id');
        // }
    }


    public function getHtmlAttribute($value)
    {
        $value = Helper::get_actual_string($value);
        // $products = $this->products;
        // $view = view('frontend.products')->with('products', $products)->render();
        // $value = str_replace('{{PRODUCTS}}', $view, $value);
        return $value;
    }
}
