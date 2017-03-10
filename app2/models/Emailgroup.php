<?php

class Emailgroup extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'email' => 'required|email|unique:emailgroups'
	];

public static $messages = array(
        'name.required'=>'Please insert bank name!',
        'email.required'=>'Please insert email address!',
        'email.unique'=>'That email address already exists!',
        
    );

	// Don't forget to fill this array
	protected $fillable = [];

}