<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentRole extends Model
{
    protected $fillable = [
       'document_id','role_id'
    ];


    public function document()
    {
         return $this->hasOne('App\Document', 'id', 'document_id');
    }

    public function role()
    {
         return $this->hasOne('App\Role', 'id', 'role_id');
    }
    
}
