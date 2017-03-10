<?php

class LeaveapplicationsController extends \BaseController {

	/**
	 * Display a listing of leaveapplications
	 *
	 * @return Response
	 */
	public function index()
	{
		$leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->orderBy('application_date', 'desc')->get();

		return Redirect::to('leavemgmt');
	}

	public function roster()
	{
		/*$leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->orderBy('application_date', 'desc')->whereYear('application_date', '=', date('Y'))->get();

		return Redirect::to('leavemgmt');*/

		$employees = Employee::getActiveEmployee();

		$branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
        $departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		 Audit::logaudit('Employees', 'view', 'viewed employee list');

		return View::make('leaveapplications.employees', compact('employees','branches','departments'));
	}

	public function rosterview()
	{
		/*$leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->orderBy('application_date', 'desc')->whereYear('application_date', '=', date('Y'))->get();

		return Redirect::to('leavemgmt');*/

		$employee = Employee::find(Input::get('employeeid'));

        $leaveapplications = DB::table('leaveapplications')->where('employee_id', '=', $employee->id)->where('is_roster', '=', 1)->whereYear('application_date', '=', Input::get('period'))->get();

        return View::make('leaveapplications.leaveroster', compact('employee', 'leaveapplications'));
	}

	public function createleave()
	{
      $postleave = Input::all();
      $data = array('name' => $postleave['type'], 
      	            'days' => $postleave['days'],
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('leavetypes')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Leavetypes', 'create', 'created: '.$postleave['type']);
        return $check;
        }else{
         return 1;
        }
      
	}

	/**
	 * Show the form for creating a new leaveapplication
	 *
	 * @return Response
	 */
	public function create()
	{
		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		$leavetypes = Leavetype::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		return View::make('leaveapplications.create', compact('employees', 'leavetypes'));
	}

	/**
	 * Store a newly created leaveapplication in storage.
	 *
	 * @return Response
	 */


    public function rostercreate(){
    	$validator = Validator::make($data = Input::all(), Leaveapplication::$rules,Leaveapplication::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//dd(count(Input::get('leavetype_id')));
        
		for($i=0;$i<count(Input::get('leavetype_id'));$i++){
        if((Input::get('leavetype_id')[$i] != '' && Input::get('leavetype_id')[$i] != null) && (Input::get('applied_start_date')[$i] != '' && Input::get('applied_start_date')[$i] != null) && (Input::get('days')[$i] != '' && Input::get('days')[$i] != null)){
		$organization = Organization::getUserOrganization();

		$employee = Employee::find(Input::get('employee_id'));

		$leavetype = Leavetype::find(Input::get('leavetype_id')[$i]);

		$application = new Leaveapplication;

		$application->applied_start_date = Input::get('applied_start_date')[$i];
		$application->applied_end_date = Input::get('applied_end_date')[$i];
		$application->status = 'applied';
		$application->is_roster = 1;
		$application->application_date = date('Y-m-d');
		$application->employee_id=Input::get('employee_id');
		$application->leavetype()->associate($leavetype);
		$application->organization()->associate($organization);
		$application->is_supervisor_approved = 0;
		$application->is_supervisor_rejected = 0;
		
		if(Input::get('weekends')[$i] == null){
          $application->is_weekend = 0;
		}else{
		  $application->is_weekend = 1;	
		}
		if(Input::get('holidays')[$i] == null){
          $application->is_holiday = 0;
		}else{
		  $application->is_holiday = 1;	
		}
		
		$application->save();

		
		/*if(count(Supervisor::where('employee_id',$application->employee_id)) > 0){

        $supervisor = Supervisor::where('employee_id',$application->employee_id)->first();

        $employee = Employee::where('id',$supervisor->supervisor_id)->first();

        $emp = Employee::where('id',$supervisor->employee_id)->first();

		$name = $emp->first_name.' '.$emp->middle_name.' '.$emp->last_name;

		Mail::send( 'emails.leavecreate', array('application'=>$application, 'name'=>$name, 'employee'=>$emp, 'supervisor'=>$employee), function( $message ) use ($employee)
		{
    		
    		$message->to($employee->email_office )->subject( 'Vacation Application' );
		});
	}*/
    }
    }


		//Leaveapplication::createLeaveRoster($data);

		if(Confide::user()->user_type == 'employee'){

			return Redirect::to('css/leaveroster');
		} else {
			return Redirect::to('leavemgmt');
		}

    }

	public function store()
	{
		$validator = Validator::make($data = Input::all(), Leaveapplication::$rules,Leaveapplication::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$employee = Employee::find(array_get($data, 'employee_id'));

		$leavetype = Leavetype::find(array_get($data, 'leavetype_id'));

		$start_date = array_get($data, 'applied_start_date');
		$end_date = array_get($data, 'applied_end_date');

		/*$days_applied = Leaveapplication::getLeaveDays($start_date, $end_date);

		$balance_days = Leaveapplication::getBalanceDays($employee, $leavetype);


		if($days_applied > $balance_days){

			return Redirect::back()->with('info', 'The days you have applied are more than your balance. You have '.$balance_days.' days left');
		}*/


		Leaveapplication::createLeaveApplication($data);

		if(Confide::user()->user_type == 'member'){

			return Redirect::to('css/leave');
		} else {
			return Redirect::to('leavemgmt');
		}
		
	}

	/**
	 * Display the specified leaveapplication.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$leaveapplication = Leaveapplication::findOrFail($id);

		return View::make('leaveapplications.show', compact('leaveapplication'));
	}

	/**
	 * Show the form for editing the specified leaveapplication.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$leaveapplication = Leaveapplication::find($id);

		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		$leavetypes = Leavetype::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		return View::make('leaveapplications.edit', compact('leaveapplication', 'employees', 'leavetypes'));
	}

	/**
	 * Update the specified leaveapplication in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$leaveapplication = Leaveapplication::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Leaveapplication::$rules,Leaveapplication::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Leaveapplication::amendLeaveApplication($data, $id);

		return Redirect::to('leavemgmt');
	}

	public function cssleaveapprove($id){

		$leaveapplication = Leaveapplication::find($id);

		

		return View::make('css.employeeleave', compact('leaveapplication'));



	}

    public function supervisorapprove($id){

	    $leaveapplication = Leaveapplication::findOrFail($id);

	    $leaveapplication->is_supervisor_approved = 1;

	    $leaveapplication->update();

		return Redirect::to('css/subordinateleave')->withFlashMessage('Successfully Approved subordinate leave!');


	}

	public function supervisorreject($id){

	    $leaveapplication = Leaveapplication::findOrFail($id);

	    $leaveapplication->is_supervisor_rejected = 1;

	    $leaveapplication->update();

		return Redirect::to('css/subordinateleave')->withFlashMessage('Successfully rejected subordinate leave!');


	}



	/**
	 * Remove the specified leaveapplication from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Leaveapplication::destroy($id);

		return Redirect::to('leavemgmt');
	}


	public function approve($id){

		$leaveapplication = Leaveapplication::find($id);

		

		return View::make('leaveapplications.approve', compact('leaveapplication'));



	}


	public function doApprove($id){



		$data = Input::all();

		Leaveapplication::approveLeaveApplication($data, $id);

		return Redirect::route('leaveapplications.index');

	}

    public function doEmpApprove($id,$startdate,$enddate){

        Leaveapplication::approveEmployeeLeaveApplication($id,$startdate,$enddate);

		return View::make('leaveapplications.appmessage');

	}

	public function doEmpReject($id,$startdate,$enddate){

        Leaveapplication::rejectEmployeeLeaveApplication($id,$startdate,$enddate);

		return View::make('leaveapplications.rejmessage');

	}


	public function reject($id){

		/*Leaveapplication::rejectLeaveApplication($id);
		return Redirect::route('leaveapplications.index');
*/
		$leaveapplication = Leaveapplication::find($id);

		

		return View::make('leaveapplications.reject', compact('leaveapplication'));

	}

	public function doreject($id){
        $data = Input::all();
	    Leaveapplication::rejectLeaveApplication($data,$id);
		return Redirect::route('leaveapplications.index');	
	}


	public function cancel($id){

		Leaveapplication::cancelLeaveApplication($id);
		return Redirect::route('leaveapplications.index');

	}

	public function redeem(){

		$employee = Employee::find(Input::get('employee_id'));
		$leeavetype = Leavetype::find(Input::get('leavetype_id'));

		Leaveapplication::RedeemLeaveDays($employee, $leavetype);

		return Redirect::route('leaveapplications.index');

	}


	public function approvals()
	{
		$leaveapplications = Leaveapplication::all();

		return View::make('leaveapplications.approved', compact('leaveapplications'));
	}


	public function amended()
	{
		$leaveapplications = Leaveapplication::all();

		return View::make('leaveapplications.amended', compact('leaveapplications'));
	}

	public function rejects()
	{
		$leaveapplications = Leaveapplication::all();

		return View::make('leaveapplications.rejected', compact('leaveapplications'));
	}

	public function cancellations()
	{
		$leaveapplications = Leaveapplication::all();

		return View::make('leaveapplications.cancelled', compact('leaveapplications'));
	}

}
