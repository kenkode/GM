<?php

class Payment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
	 'pay_date' => 'required',
	 'amount'   => 'required|regex:/^\d+(\.\d{2})?$/'
	];

	public static $messages = array(
    	'pay_date.required'=>'Please select payment date!',
    	'amount.required'=>'Please Enter the amount paid!',
    	'amount.regex'=>'Please insert a valid amount!'
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function erporder(){

		return $this->belongsTo('Erporder');
	}

	public function client(){

		return $this->belongsTo('Client');
	}

}