<?php

class Erporder extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
		   //'location' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function paymentmethod(){

		return $this->belongsTo('Paymentmethod');
	}

	public function client(){

		return $this->belongsTo('Client');
	}

	public function erporderitems(){

		return $this->hasMany('Erporderitem');
	}

	public function payments(){

		return $this->hasMany('Payment');
	}

	public function tax(){

		return $this->belongsTo('TaxOrder');
	}
	public static function getTotalPayments($order){
		$payments = 0;
		$payments = DB::table('payments')->where('organization_id',Confide::user()->organization_id)->where('client_id', '=', $order->client_id)->where('void',0)->sum('amount_paid');

		return $payments;
	}
	public static function getBalance($order){
		//$payments = 0;
		$amount_charged = DB::table('erporders')->$order->total_amount;
		$payments = DB::table('payments')->where('organization_id',Confide::user()->organization_id)->where('erporder_id', '=', $order->id)->sum('amount_paid');

		$balance = $amount_charged - $payments;

		return $balance;
	}

	public static function getOrderBalance($id){
		//$payments = 0;
		$amount_charged = DB::table('erporderitems')
		                ->where('erporder_id','=',$id)
		                ->where('organization_id',Confide::user()->organization_id)
		                ->sum('quantity'*'price');

		$balance = $amount_charged - $payments;

		return $balance;
	}

}