<?php

class OvertimesController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$overtimes = DB::table('employee')
		          ->join('overtimes', 'employee.id', '=', 'overtimes.employee_id')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->select('overtimes.id','type','first_name','middle_name','last_name','amount','period')
		          ->get();

		Audit::logaudit('Overtimes', 'view', 'viewed employee overtime');

		return View::make('overtime.index', compact('overtimes'));
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
                $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('overtime.create', compact('employees','currency'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Overtime::$rules, Overtime::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$overtime= new Overtime;
        
        $overtime->employee_id = Input::get('employee');

        $overtime->type = Input::get('type');

		$overtime->period = Input::get('period');

		$overtime->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$overtime->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );

		$overtime->amount = $a;

        $d=strtotime(Input::get('odate'));

        $overtime->overtime_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('odate'))));

        $First  = date('Y-m-01', strtotime(Input::get('odate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $overtime->first_day_month = $First;

        $overtime->last_day_month = $Last;

	    }else{
	    $overtime->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );

		$overtime->amount = $a;

        $d=strtotime(Input::get('odate'));

        $overtime->overtime_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('odate')));
        $Last   = date('Y-m-t', strtotime(Input::get('odate')));
        

        $overtime->first_day_month = $First;

        $overtime->last_day_month = $Last;

	    }


		$overtime->save();

		Audit::logaudit('Overtimes', 'create', 'created: '.$overtime->type.' for '.Employee::getEmployeeName(Input::get('employee')));


		return Redirect::route('overtimes.index')->withFlashMessage('Employee Overtime successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$overtime = Overtime::findOrFail($id);

		return View::make('overtime.show', compact('overtime'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$overtime = Overtime::find($id);
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

		return View::make('overtime.edit', compact('overtime','currency'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$overtime = Overtime::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Overtime::$rules, Overtime::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $overtime->type = Input::get('type');

		$overtime->period = Input::get('period');

        $overtime->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$overtime->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );

		$overtime->amount = $a;

        $d=strtotime(Input::get('odate'));

        $overtime->overtime_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('odate'))));

        $First  = date('Y-m-01', strtotime(Input::get('odate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $overtime->first_day_month = $First;

        $overtime->last_day_month = $Last;

	    }else{
	    $overtime->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );

		$overtime->amount = $a;

        $d=strtotime(Input::get('odate'));

        $overtime->overtime_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('odate')));
        $Last   = date('Y-m-t', strtotime(Input::get('odate')));
        

        $overtime->first_day_month = $First;

        $overtime->last_day_month = $Last;

	    }

		$overtime->update();

		Audit::logaudit('Overtimes', 'update', 'updated: '.$overtime->type.' for '.Employee::getEmployeeName($overtime->employee_id));

		return Redirect::route('overtimes.index')->withFlashMessage('Employee Overtime successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$overtime = Overtime::findOrFail($id);
		Overtime::destroy($id);

		Audit::logaudit('Overtimes', 'delete', 'deleted: '.$overtime->type.' for '.Employee::getEmployeeName($overtime->employee_id));

		return Redirect::route('overtimes.index')->withDeleteMessage('Employee Overtime successfully deleted!');
	}

	public function view($id){

		$overtime = Overtime::find($id);

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('overtime.view', compact('overtime'));
		
	}

}
