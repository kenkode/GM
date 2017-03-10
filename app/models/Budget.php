<?php

class Budget extends \Eloquent {

public static $rules = [
        'name' => 'required',
		'amount' => 'required',
		'period' => 'required'
	];

public static $messages = array(
	    'name.required'=>'Please insert budget type!',
        'amount.required'=>'Please insert estimated budget amount!',
        'period.required'=>'Please insert financial period!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

	public function expensesetting(){
		return $this->belongsTo('Expensesetting');
	}

	public static function sales($id,$month,$year){

	$total = 0.00;

    $total_sales = DB::table('erporders')
                  ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                  ->where(function($query){
                       $query->where('erporders.status', '=', 'new')
                             ->orWhere('erporders.status', '=', 'Delivered');
                       })
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where(DB::raw('MONTH(date)'), '=', $month)
                  ->where(DB::raw('YEAR(date)'),$year)
                  ->select(DB::raw('COALESCE(sum(price * quantity),0.00) as tsales'))
                  ->get();
                      
    foreach($total_sales as $total_sale){
    $total = $total_sale->tsales;
    }
    
    return round($total,2);

    }

    public static function getAmount($id,$month,$year){

      $amount = 0.00;

      $budgetexp = Budget::where('financial_month',$month)->where('organization_id',Confide::user()->organization_id)->where('financial_year',$year)->where('expensesetting_id','=',$id)->first();

      $budgetexpcount = Budget::where('financial_month',$month)->where('organization_id',Confide::user()->organization_id)->where('financial_year',$year)->where('expensesetting_id','=',$id)->count();

      if($budgetexpcount>0){
       $amount = $budgetexp->amount;
      }else{
       $amount = 0.00;
      }

      return $amount;

    }

    public static function getTotalAmount($id,$month,$year){

     $amount = 0.00;
     $budget = DB::table('budgets')
                     ->select(DB::raw('COALESCE(amount,0.00) as amount'))
                     ->where('financial_month',$month)
                     ->where('financial_year',$year)
                     ->where('expensesetting_id','=',$id)
                     ->where('organization_id',Confide::user()->organization_id)
                     ->first();

     $c = DB::table('budgets')
                     ->select(DB::raw('COALESCE(amount,0.00) as amount'))
                     ->where('financial_month',$month)
                     ->where('financial_year',$year)
                     ->where('expensesetting_id','=',$id)
                     ->where('organization_id',Confide::user()->organization_id)
                     ->count(); 

     if($c == 0){
      $amount = 0.00;
     }else{
      $amount = $budget->amount;
     }
                      
      return $amount;

    }

    public static function expenses($id,$month,$year){

	$total = 0.00;

    $total_expenses = DB::table('expenses')
                  ->where('expensesetting_id', '=', $id)
                  ->where(DB::raw('MONTH(date)'), '=', $month)
                  ->where(DB::raw('YEAR(date)'),$year)
                  ->where('organization_id',Confide::user()->organization_id)
                  ->select(DB::raw('COALESCE(sum(amount),0.00) as texp'))
                  ->get();

    $c = DB::table('expenses')
                  ->where('expensesetting_id', '=', $id)
                  ->where(DB::raw('MONTH(date)'), '=', $month)
                  ->where(DB::raw('YEAR(date)'),$year)
                  ->where('organization_id',Confide::user()->organization_id)
                  ->select(DB::raw('COALESCE(sum(amount),0.00) as texp'))
                  ->count();
    if($c == 0){
    $total = 0;
    }else{
    foreach($total_expenses as $total_expense){
    $total = $total_expense->texp;
    }
  }
    
    return round($total,2);

    }

    public static function totalsales($year){

    $total = 0.00;

    $total_sales = DB::table('erporders')
                  ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                  ->where(function($query){
                       $query->where('erporders.status', '=', 'new')
                             ->orWhere('erporders.status', '=', 'Delivered');
                       })
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where(DB::raw('YEAR(date)'),$year)
                  ->select(DB::raw('COALESCE(sum(price * quantity),0.00) as tsales'))
                  ->get();
                      
    foreach($total_sales as $total_sale){
    $total = $total_sale->tsales;
    }
    
    return round($total,2);

    }

    public static function totalexpenses($year){

  $total = 0.00;

    $total_expenses = DB::table('expenses')
                  ->where(DB::raw('YEAR(date)'),$year)
                  ->where('organization_id',Confide::user()->organization_id)
                  ->select(DB::raw('COALESCE(sum(amount),0.00) as texp'))
                  ->get();
                      
    foreach($total_expenses as $total_expense){
    $total = $total_expense->texp;
    }
    
    return round($total,2);

    }

}