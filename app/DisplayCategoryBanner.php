<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DisplayCategoryBanner extends Model
{
    // public function getImageAttribute($value)
    // {
    //     if (Storage::disk('s3')->exists('images/displayCategory/' . $value) && $value) {
    //         return Storage::disk('s3')->url('images/displayCategory/' . $value);
    //     };
    //     return '';
    // }
}
