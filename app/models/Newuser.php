<?php

class Newuser extends \Eloquent {
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	public $table = "users";

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	/**
	* validation rules
	*
	*/
	public static $rules = [
            'username' => 'required|alpha_dash',
            'email'    => 'required|email',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' => 'required|min:4',
        
    ];


    public static function exists($employee){

    	$exists = DB::table('users')->where('organization_id',Confide::user()->organization_id)->where('username', '=', $employee->personal_file_number)->count();

    	if($exists >= 1){
    		return true;
    	}
    	else{
    		return false;
    	}
    }

    


}
