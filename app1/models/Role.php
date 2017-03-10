<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

	

public static function getRole($user){

	$roleid = DB::table('assigned_roles')->where('organization_id',Confide::user()->organization_id)->where('user_id', '=', $user->id)->pluck('role_id');
 	

	$role = Role::find($roleid);

	return $role->name;

}	

}
