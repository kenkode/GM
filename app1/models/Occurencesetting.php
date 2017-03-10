<?php

class Occurencesetting extends \Eloquent {
/*
	use \Traits\Encryptable;


	protected $encryptable = [

		'allowance_name',
	];
	*/

public static $rules = [
		'type' => 'required'
	];

	public static $messsages = array(
        'type.required'=>'Please insert occurence type!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function occurence(){

		return $this->belongsTo('Occurence');
	}

	public static function getOccurenceType($id){

		$type = Occurencesetting::where('id', '=', $id)->firstOrFail();

		return $type->occurence_type;
	}

}