<?php

class Memberadvance extends \Eloquent {

public static $rules = [
		'date'   => 'required',
		'type'   => 'required',
		'amount' => 'required'
	];

public static $messages = array(
        'date.required'=>'Please insert date cash is needed!',
        'type.required'=>'Please insert type!',
        'amount.required'=>'Please insert amount!',

    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employees(){

		return $this->hasMany('Employee');
	}

	public function department(){

		return $this->hasMany('Department');
	}

}