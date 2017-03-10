<?php

class Expense extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'type' => 'required',
	];

	public static $messages = array(
    	'name.required'=>'Please insert expense name!',
        'type.required'=>'Please select expense type!',
        'amount.required'=>'Please insert amount name!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function expensesetting(){
		return $this->belongsTo('Expensesetting');
	}

	public function account(){
		return $this->belongsTo('Account');
	}

}