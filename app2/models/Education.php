<?php

class Education extends \Eloquent {

public $table = "education";

public static $rules = [
		'name' => 'required'
	];

public static $messages = array(
        'name.required'=>'Please insert education name!',
    );
	// Don't forget to fill this array
	protected $fillable = [];


	public function employee(){

		return $this->belongsTo('Employee');
	}

}