<?php

class Occurence extends \Eloquent {
/*
	use \Traits\Encryptable;


	protected $encryptable = [

		'allowance_name',
	];
	*/

public static $rules = [
		'brief' => 'required',
		'employee' => 'required',
		'type' => 'required',
		'date' => 'required'
	];

	public static $messsages = array(
        'brief.required'=>'Please insert occurence brief!',
        'employee.required'=>'Please select employee!',
        'type.required'=>'Please select occurence type!',
        'date.required'=>'Please select occurence date!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employee(){
		
		return $this->belongsTo('Employee');
	}
	public function occurencesetting(){
		
		return $this->hasMany('Occurencesetting');
	}
}