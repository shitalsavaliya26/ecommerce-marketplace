<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title','document','type','doc_type'
    ];

    public function roles()
    {
         return $this->hasMany('App\DocumentRole', 'document_id', 'id')->select('role_id');
    }

    public function users()
    {
         return $this->hasMany('App\DocumentUser', 'document_id', 'id')->select('user_id');
    }

    public function rolelist()
    {
         return $this->hasMany('App\DocumentRole', 'document_id', 'id');
    }
    
    public function userlist()
    {
         return $this->hasMany('App\DocumentUser', 'document_id', 'id');
    }

}
