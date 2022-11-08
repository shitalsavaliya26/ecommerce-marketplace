<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulepermission extends Model
{
    protected $table = "module_permissions";

    public function module()
    {
        return $this->belongsTo('App\Module', 'module_id', 'id');
    }
}