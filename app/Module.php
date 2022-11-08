<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{

	public function checkpermission($role_id, $module_id)
	{
		$Modulepermission = Modulepermission::where('role_id', $role_id)->where('module_id', $module_id)->first();
		if (count($Modulepermission) > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function children()
	{
		return $this->hasMany('App\Module', 'parent_id', 'id');
	}
}