<?php

class Discipline extends \Eloquent {

public static $rules = [
		'employee' => 'required',
		'reason' => 'required',
		'action' => 'required',
		'date' => 'required'
	];

public static $messages = array(
        'employee.required'=>'Please select employee!',
        'reason.required'=>'Please insert reason!',
        'action.required'=>'Please select action!',
        'date.required'=>'Please select date!',
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
