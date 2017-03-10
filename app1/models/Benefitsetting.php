<?php

class Benefitsetting extends \Eloquent {
/*
	use \Traits\Encryptable;


	protected $encryptable = [

		'allowance_name',
	];
	*/

public static $rules = [
		'name' => 'required'
	];

	public static $messsages = array(
        'name.required'=>'Please insert benefit name!',
    );

	// Don't forget to fill this array
	protected $fillable = [];


	public function employeebenefits(){

		return $this->hasMany('Employeebenefit');
	}

	public static function getBenefit($id){

		$benefit = Benefitsetting::find($id);
        return $benefit->benefit_name;
	}

	public static function getAmount($id,$jid){
        $count = DB::table('employeebenefits')
		         ->where('benefit_id', $id)
		         ->where('jobgroup_id', $jid)
		         ->count();

		$amount = 0;

		if($count == 0){
        $amount = 0;
		}else{
		$benefit = DB::table('employeebenefits')
		         ->where('benefit_id', $id)
		         ->where('jobgroup_id', $jid)
		         ->first();

		$amount = $benefit->amount;
	    }

		return $amount;
	}

}