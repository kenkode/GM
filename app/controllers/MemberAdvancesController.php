<?php

class MemberAdvancesController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$employeeid = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

        $advances = Memberadvance::where('employee_id',$employeeid)->where('is_visible',1)->get();

        return View::make('css.memberadvances', compact('advances'));
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		$employeeid = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

		$count = Memberadvance::where('employee_id',$employeeid)->where('fiscal_year',date('Y'))->count();
        
		$employee = Employee::find($employeeid);
        if($count>=2){
        return Redirect::to('css/advances')->withDeleteMessage('Only 2 advances are permitted per fiscal year!');
        }else{
        return View::make('css.advancecreate');
    }
	}

	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Memberadvance::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $employeeid = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

        $employee = Employee::find($employeeid);

		$memberadvance = new Memberadvance;

		$memberadvance->employee_id = $employeeid;
		$memberadvance->amount = str_replace(',', '', Input::get('amount'));
		$memberadvance->date = Input::get('date');
		$memberadvance->type = Input::get('type');
		$memberadvance->status = 'Pending';
		$memberadvance->fiscal_year = date('Y');
		$memberadvance->is_visible = 1;
		$memberadvance->is_admin_visible = 1;
		
		$memberadvance->save();


		$name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;


		Mail::send( 'emails.advances', array('advance'=>$memberadvance, 'name'=>$name, 'employee'=>$employee), function( $message ) use ($employee)
		{
    		
    		$message->to('info@xpose.co.ke')->subject( 'Salary Advance Application' );
		});

		Audit::logaudit('Memberadvance', 'applied', 'Applied: '.$employee->personal_file_number.' : '.$employee->last_name.' '.$employee->first_name.' applied advance of KES '.Input::get('amount').' type '.Input::get('type'));

		return Redirect::to('css/advances')->withFlashMessage('Advance successfully created!');
	}

	/**
	 * Display the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$account = Account::findOrFail($id);

		return View::make('accounts.show', compact('account'));
	}

	/**
	 * Show the form for editing the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$advance = Memberadvance::find($id);

		return View::make('css.advanceupdate', compact('advance'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$validator = Validator::make($data = Input::all(), Memberadvance::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $employeeid = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

        $employee = Employee::find($employeeid);

		$memberadvance = Memberadvance::findOrFail($id);

		$memberadvance->employee_id = $employeeid;
		$memberadvance->amount = str_replace(',', '', Input::get('amount'));
		$memberadvance->date = Input::get('date');
		$memberadvance->type = Input::get('type');
		$memberadvance->status = 'Pending';
		$memberadvance->fiscal_year = date('Y');
		
		$memberadvance->update();

        $name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;


		Mail::send( 'emails.advancesupdate', array('advance'=>$memberadvance, 'name'=>$name, 'employee'=>$employee), function( $message ) use ($employee)
		{
    		
    		$message->to('info@xpose.co.ke')->subject( 'Salary Advance Application Update' );
		});

		Audit::logaudit('Memberadvance', 'update', 'Updated: '.$employee->personal_file_number.' : '.$employee->last_name.' '.$employee->first_name.' updated advance');

		return Redirect::to('css/advances')->withFlashMessage('Advance successfully updated!');
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$memberadvance = Memberadvance::findOrFail($id);

		$memberadvance->is_visible = 0;

		$memberadvance->is_admin_visible = 0;
		
		$memberadvance->update();


		Audit::logaudit('Memberadvance', 'delete', 'deleted: advance');


		return Redirect::to('css/advances')->withDeleteMessage('Advance successfully deleted!');
	}

	public function view($id){

		$advance = Memberadvance::find($id);

		$organization = Organization::find(1);

		$employee = Employee::find($advance->employee_id);

		$pdf = PDF::loadView('pdf.advanceform', compact('advance','organization','employee'))->setPaper('a4')->setOrientation('potrait');
  
        return $pdf->stream($employee->personal_file_number.'_'.$employee->last_name.'_'.$employee->first_name.'_member_advance_form.pdf');
		
	}

}
