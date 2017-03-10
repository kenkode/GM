<?php

class EmployeeAllowancesController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$eallws = DB::table('employee_allowances')
		          ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
		          ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->select('employee_allowances.id','first_name','middle_name','last_name','allowance_amount','allowance_name')
		          ->get();

		Audit::logaudit('Employee Allowances', 'view', 'viewed employee allowances');

		return View::make('employee_allowances.index', compact('eallws'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */

    public function createallowance()
	{
      $postallowance = Input::all();
      $data = array('allowance_name' => $postallowance['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('allowances')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Allowances', 'create', 'created: '.$postallowance['name']);
        return $check;
        }else{
         return 1;
        }
      
	}    

	public function create()
	{
		
		$employees = DB::table('employee')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->get();
		$allowances = Allowance::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('employee_allowances.create',compact('employees','allowances','currency'));
	}


	public function display(){
        
      $allw = Allowance::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->orderBy('id','DESC')->first();
          
      return json_encode(array("id"=>$allw->id,"name"=>$allw->allowance_name));
      exit();

    }

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), EAllowances::$rules, EAllowances::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance = new EAllowances;

		$allowance->employee_id = Input::get('employee');

		$allowance->allowance_id = Input::get('allowance');

        $allowance->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$allowance->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime(Input::get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('adate'))));

        $First  = date('Y-m-01', strtotime(Input::get('adate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }else{
	    $allowance->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime(Input::get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('adate')));
        $Last   = date('Y-m-t', strtotime(Input::get('adate')));
        

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }
        

		$allowance->save();

		

		Audit::logaudit('Employee Allowances', 'create', 'assigned: '.$allowance->allowance_amount.' to'.Employee::getEmployeeName(Input::get('employee')));

		return Redirect::route('employee_allowances.index')->withFlashMessage('Employee Allowance successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$eallw = EAllowances::findOrFail($id);

		return View::make('employee_allowances.show', compact('eallw'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$eallw = EAllowances::find($id);
		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
		$allowances = Allowance::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
                $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('employee_allowances.edit', compact('eallw','allowances','employees','currency'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$allowance = EAllowances::findOrFail($id);

		$validator = Validator::make($data = Input::all(), EAllowances::$rules, EAllowances::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$allowance->allowance_id = Input::get('allowance');

        $allowance->formular = Input::get('formular');

		if(Input::get('formular') == 'Instalments'){
		$allowance->instalments = Input::get('instalments');
        $insts = Input::get('instalments');

		$a = str_replace( ',', '', Input::get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime(Input::get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime(Input::get('adate'))));

        $First  = date('Y-m-01', strtotime(Input::get('adate')));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }else{
	    $allowance->instalments = '1';
        $a = str_replace( ',', '', Input::get('amount') );

        $allowance->allowance_amount = $a;

        $d=strtotime(Input::get('adate'));

        $allowance->allowance_date = date("Y-m-d", $d);

        $First  = date('Y-m-01', strtotime(Input::get('adate')));
        $Last   = date('Y-m-t', strtotime(Input::get('adate')));
        

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

	    }


		$allowance->update();

		Audit::logaudit('Employee Allowances', 'update', 'assigned: '.$allowance->allowance_amount.' to '.Employee::getEmployeeName($allowance->employee_id));

		return Redirect::route('employee_allowances.index')->withFlashMessage('Employee Allowance successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$allowance = EAllowances::findOrFail($id);

		EAllowances::destroy($id);


		Audit::logaudit('Employee Allowances', 'delete', 'deleted: '.$allowance->allowance_amount.' for '.Employee::getEmployeeName($allowance->employee_id));


		return Redirect::route('employee_allowances.index')->withDeleteMessage('Employee Allowance successfully deleted!');
	}

    public function view($id){

		$eallw = DB::table('employee_allowances')
		          ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
		          ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
		          ->where('employee_allowances.id','=',$id)
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->select('employee_allowances.id','first_name','last_name','middle_name','allowance_amount',
		          	'allowance_name','photo','signature','formular','instalments','allowance_date','first_day_month','last_day_month')
		          ->first();

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('employee_allowances.view', compact('eallw'));
		
	}


}
