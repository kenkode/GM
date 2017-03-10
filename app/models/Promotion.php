<?php

class Promotion extends \Eloquent {

public static $rules = [
		'employee' => 'required',
		'reason' => 'required',
		'type' => 'required'
	];

public static $messages = array(
        'employee.required'=>'Please select employee!',
        'reason.required'=>'Please insert reason!',
        'type.required'=>'Please select action!',
    );
	// Don't forget to fill this array
	protected $fillable = [];


	public static function getEmployee($id){
        $employee = Employee::find($id);
		return $employee->first_name.' '.$employee->last_name;
	}

	public static function getImage($id){
        $employee = Employee::find($id);
		return $employee;
	}

}
