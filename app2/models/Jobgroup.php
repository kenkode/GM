<?php

class Jobgroup extends \Eloquent {

public $table = "job_group";

public static $rules = [
		'name' => 'required',
        'amount[]' => 'regex:/^(\$?(?(?=\()(\())\d+(?:,\d+)?(?:\.\d+)?(?(2)\)))$/'
	];

public static $messages = array(
        'name.required'=>'Please insert job group!',
        'amount[].regex'=>'Please insert a valid amount!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employeebenefits(){

		return $this->hasMany('Employeebenefit');
	}

}