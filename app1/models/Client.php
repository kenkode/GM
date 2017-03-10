<?php

class Client extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		
	];

    public static function rolesUpdate($id)
    {
        
    }

    public static $messages = array(
    	
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function erporders(){

		return $this->hasMany('Erporder');
	}

	public function payments(){

		return $this->hasMany('Payment');
	}

}