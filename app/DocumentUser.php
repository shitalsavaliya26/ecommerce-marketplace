<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUser extends Model
{
    protected $fillable = [
        'document_id','user_id'
    ];


    public function document()
    {
         return $this->hasOne('App\Document', 'id', 'document_id');
    }

    public function user()
    {
         return $this->hasOne('App\User', 'id', 'user_id');
    }
    
}
