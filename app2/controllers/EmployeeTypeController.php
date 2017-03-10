<?php

class EmployeeTypeController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$etypes = EType::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		return View::make('employee_type.index', compact('etypes'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('employee_type.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), EType::$rules,EType::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$etype = new EType;

		$etype->employee_type_name = Input::get('name');

        $etype->organization_id = Confide::user()->organization_id;

		$etype->save();

		Audit::logaudit('Employee Types', 'create', 'created: '.$etype->employee_type_name);

		return Redirect::route('employee_type.index')->withFlashMessage('Employee Type successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$etype = EType::findOrFail($id);

		return View::make('employee_type.show', compact('etype'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$etype = EType::find($id);

		return View::make('employee_type.edit', compact('etype'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$etype = EType::findOrFail($id);

		$validator = Validator::make($data = Input::all(), EType::$rules,EType::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$etype->employee_type_name = Input::get('name');
		$etype->update();

		Audit::logaudit('Employee Types', 'update', 'updated: '.$etype->employee_type_name);

		return Redirect::route('employee_type.index')->withFlashMessage('Employee Type successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$etype = EType::findOrFail($id);
		$type  = DB::table('employee')->where('type_id',$id)->count();
		if($type>0){
			return Redirect::route('employee_type.index')->withDeleteMessage('Cannot delete this employee type because its assigned to an employee(s)!');
		}else{
		
		EType::destroy($id);

		Audit::logaudit('Employee Types', 'delete', 'deleted: '.$etype->employee_type_name);
		return Redirect::route('employee_type.index')->withDeleteMessage('Employee Type successfully deleted!');
	}

}

}
