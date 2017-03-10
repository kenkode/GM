<?php

class EmployeeDeductionsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$deds = DB::table('employee')
		          ->join('employee_deductions', 'employee.id', '=', 'employee_deductions.employee_id')
		          ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->select('employee_deductions.id','first_name','middle_name','last_name','deduction_amount','deduction_name')
		          ->get();
		return View::make('employee_deductions.index', compact('deds'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */

   public function create()
	{
		$employees = DB::table('employee')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->get();
		$deductions = Deduction::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('employee_deductions.create',compact('employees','deductions','currency'));
	}

	public function creatededuction()
	{
      $postdeduction = Input::all();
      $data = array('deduction_name' => $postdeduction['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('deductions')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Deductions', 'create', 'created: '.$postdeduction['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), EDeduction::$rules, EDeduction::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$ded = new EDeduction;

		$ded->employee_id = Input::get('employee');

		$ded->deduction_id = Input::get('deduction');

		$ded->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$ded->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );
        $ded->deduction_amount = $a;

        $d=strtotime(Input::get('ddate'));

        $ded->deduction_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('ddate'))));

        $First  = date('Y-m-01', strtotime(Input::get('ddate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $ded->first_day_month = $First;

        $ded->last_day_month = $Last;

	    }else{
	    $ded->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );
        $ded->deduction_amount = $a;

        $d=strtotime(Input::get('ddate'));

        $ded->deduction_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('ddate')));
        $Last   = date('Y-m-t', strtotime(Input::get('ddate')));
        

        $ded->first_day_month = $First;

        $ded->last_day_month = $Last;

	    }

        
		$ded->save();

		Audit::logaudit('Employee Deduction', 'create', 'assigned: '.$ded->deduction_amount.' to '.Employee::getEmployeeName(Input::get('employee')));

		return Redirect::route('employee_deductions.index')->withFlashMessage('Employee Deduction successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$ded = EDeduction::findOrFail($id);

		return View::make('employee_deductions.show', compact('ded'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ded = EDeduction::find($id);
		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
                $deductions = Deduction::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
                $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('employee_deductions.edit', compact('ded','employees','deductions','currency'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$ded = EDeduction::findOrFail($id);

		$validator = Validator::make($data = Input::all(), EDeduction::$rules, EDeduction::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$ded->deduction_id = Input::get('deduction');

		$ded->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$ded->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );
        $ded->deduction_amount = $a;

        $d=strtotime(Input::get('ddate'));

        $ded->deduction_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('ddate'))));

        $First  = date('Y-m-01', strtotime(Input::get('ddate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $ded->first_day_month = $First;

        $ded->last_day_month = $Last;

	    }else{
	    $ded->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );
        $ded->deduction_amount = $a;

        $d=strtotime(Input::get('ddate'));

        $ded->deduction_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('ddate')));
        $Last   = date('Y-m-t', strtotime(Input::get('ddate')));

        $ded->first_day_month = $First;

        $ded->last_day_month = $Last;

	    }

		$ded->update();

		Audit::logaudit('Employee Deduction', 'update', 'assigned: '.$ded->deduction_amount.' for '.Employee::getEmployeeName($ded->employee_id));

		return Redirect::route('employee_deductions.index')->withFlashMessage('Employee Deduction successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$ded = EDeduction::findOrFail($id);
		EDeduction::destroy($id);

		Audit::logaudit('Employee Deduction', 'delete', 'deleted: '.$ded->deduction_amount.' for '.Employee::getEmployeeName($ded->employee_id));

		return Redirect::route('employee_deductions.index')->withDeleteMessage('Employee Deduction successfully deleted!');
	}

	public function view($id){

		$ded = DB::table('employee')
		          ->join('employee_deductions', 'employee.id', '=', 'employee_deductions.employee_id')
		          ->join('deductions', 'employee_deductions.deduction_id', '=', 'deductions.id')
		          ->where('employee_deductions.id','=',$id)
		          ->where('employee.organization_id',Confide::user()->organization_id)
  ->select('employee_deductions.id','first_name','last_name','middle_name','formular','instalments','deduction_amount','deduction_name','deduction_date','last_day_month','photo','signature')
		          ->first();

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('employee_deductions.view', compact('ded'));
		
	}

}
