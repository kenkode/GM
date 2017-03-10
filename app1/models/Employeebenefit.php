<?php

class Employeebenefit extends \Eloquent {
/*
	use \Traits\Encryptable;


	protected $encryptable = [

		'allowance_name',
	];
	*/


	// Don't forget to fill this array
	protected $fillable = [];


	public function jobgroup(){

		return $this->belongsTo('Jobgroup');
	}

}