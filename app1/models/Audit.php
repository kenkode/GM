<?php

class Audit extends \Eloquent {

	/*use \Traits\Encryptable;


	protected $encryptable = [

		'description',
		'entity',
		'action',
		'user',
	];*/

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public static function logAudit( $entity, $action, $description){

	$audit = new Audit;

    $audit->date = date('Y-m-d');
    $audit->description = $description;
    $audit->user = Confide::user()->username;	
    $audit->organization_id= Confide::user()->organization_id;
    $audit->entity = $entity;
    $audit->action = $action;
    $audit->save();

	}

	public static function loglicenseAudit( $entity, $action, $description,$name){

	$audit = new Audit;

    $audit->date = date('Y-m-d');
    $audit->description = $description;
    $audit->user = 'admin';
    $audit->organization_id= $name;
    $audit->entity = $entity;
    $audit->action = $action;
    $audit->save();

	}


}