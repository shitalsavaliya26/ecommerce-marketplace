<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DashboardPopupSlider extends Model
{
    //
    protected $table = 'dashboard_popup_sliders';
    protected $fillable = [
        'id', 'button_name', 'image', 'type', 'category_id', 'product_id', 'is_deleted', 'created_at', 'updated_at',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id')->where('status', 'active')->where('is_deleted','0');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

    // public function getImageAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/dashboardpopupslider/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/dashboardpopupslider/' . $value);
    //     };
    //     return '';
    // }
}
