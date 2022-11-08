<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Helpers\Helper;

class Seller extends Model
{
    use SoftDeletes, Notifiable;
    protected $hidden = ['created_at','updated_at'];
    protected $appends = ['is_follow'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function getImageAttribute($value){
    //     if (Storage::disk('s3')->exists('images/profile/'.$value) && $value){           
    //         return Storage::disk('s3')->url('images/profile/' . $value);
    //     };
    //     return '';
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function topBanners()
    {
        return $this->hasMany('App\SellerTopBanner', 'seller_id', 'id');
    }

    public function followers()
    {
        return $this->hasMany('App\SellerFollower', 'seller_id', 'id');
    }
    
    public function lastBanners()
    {
        return $this->hasMany('App\SellerLastBanner', 'seller_id', 'id');
    }

    public function vouchers()
    {
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
        
        return $this->hasMany('App\Voucher', 'seller_id', 'id')
                ->where('from_date', '<=', $currentDateTime)
                ->where('to_date', '>=', $currentDateTime)
                ->where('usage_qty', '>', 0);
    }

    public function getIsFollowAttribute()
    {
        return Helper::isFollowing($this->id);
    }

}
