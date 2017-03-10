<?php

class NextOfKinsController extends \BaseController {

	/**
	 * Display a listing of kins
	 *
	 * @return Response
	 */
	public function index()
	{
		$kins = DB::table('employee')
		          ->join('nextofkins', 'employee.id', '=', 'nextofkins.employee_id')
		          ->where('in_employment','=','Y')
		          ->where('organization_id',Confide::user()->organization_id)
		          ->get();

		Audit::logaudit('Next of Kins', 'view', 'viewed employee next of kin');

		return View::make('nextofkins.index', compact('kins'));
	}

	public function serializecheck(){
		
        return Input::get('kin_first_name');
        
	}

	/**
	 * Show the form for creating a new kin
	 *
	 * @return Response
	 */
	public function create($id)
	{  
		$id = $id;

		$employees = DB::table('employee')
		          ->where('in_employment','=','Y')
		          ->where('organization_id',Confide::user()->organization_id)
		          ->get();
		return View::make('nextofkins.create', compact('employees','id'));
	}

	/**
	 * Store a newly created kin in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Nextofkin::$rules,Nextofkin::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}


		$kin = new Nextofkin;

		$kin->employee_id=Input::get('employee_id');
		$kin->name = Input::get('name');
		$kin->relationship = Input::get('rship');
		$kin->contact = Input::get('contact');
		$kin->id_number = Input::get('id_number');
		$kin->id_number = Input::get('id_number');
		$kin->organization_id = Confide::user()->organization_id;
		$kin->save();

		Audit::logaudit('NextofKins', 'create', 'created: '.$kin->name.' for '.Employee::getEmployeeName(Input::get('employee_id')));


		return Redirect::to('NextOfKins/view/'.$kin->id)->withFlashMessage('Employee`s next of kin successfully created!');
	}

	/**
	 * Display the specified kin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$kin = Nextofkin::findOrFail($id);

		return View::make('nextofkins.show', compact('kin'));
	}

	/**
	 * Show the form for editing the specified kin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$kin = Nextofkin::find($id);

		return View::make('nextofkins.edit', compact('kin'));
	}

	/**
	 * Update the specified kin in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$kin = Nextofkin::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Nextofkin::$rules,Nextofkin::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
        
		$kin->first_name = Input::get('fname');
		$kin->middle_name = Input::get('mname');
		$kin->last_name = Input::get('lname');
		$kin->relationship = Input::get('rship');
		$kin->contact = Input::get('contact');
		$kin->id_number = Input::get('id_number');

		$kin->update();

		Audit::logaudit('NextofKins', 'update', 'updated: '.$kin->name.' for '.Employee::getEmployeeName($kin->employee_id));

		return Redirect::to('NextOfKins/view/'.$id)->withFlashMessage('Employee`s next of kin successfully updated!');
	}

	/**
	 * Remove the specified kin from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$kin = Nextofkin::findOrFail($id);
		Nextofkin::destroy($id);
		Audit::logaudit('NextofKins', 'delete', 'deleted: '.$kin->name.' for '.Employee::getEmployeeName($kin->employee_id));

		return Redirect::to('employees/view/'.$kin->employee_id)->withDeleteMessage('Employee`s next of kin successfully deleted!');
	}

	public function view($id){

		$kin = Nextofkin::find($id);

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('nextofkins.view', compact('kin'));
		
	}


}
