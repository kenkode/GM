<?php

class DisciplineController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$disciplines = Discipline::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Compliances', 'view', 'viewed disciplines');

		return View::make('discipline.index', compact('disciplines'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('discipline.create',compact('employees'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Discipline::$rules,Discipline::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$discipline = new Discipline;

		$discipline->employee_id = Input::get('employee');

		$discipline->reason = Input::get('reason');

		$discipline->action = Input::get('action');

		$discipline->discipline_date = Input::get('date');

		if(Input::get('action') == 'Suspension'){
          $discipline->days = Input::get('days');
		}else{
          $discipline->days = null;
		}

        $discipline->organization_id = Confide::user()->organization_id;

		$discipline->save();
       
        Audit::logaudit('Compliance', 'create', 'created: '.$discipline->reason);

		return Redirect::route('compliance.index')->withFlashMessage('Compliance successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$discipline = Discipline::findOrFail($id);

		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		return View::make('discipline.show', compact('discipline','employees'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$discipline = Discipline::find($id);

		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		return View::make('discipline.edit', compact('discipline','employees'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$discipline = Discipline::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Discipline::$rules,Discipline::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$discipline->employee_id = Input::get('employee');

		$discipline->reason = Input::get('reason');

		$discipline->action = Input::get('action');

		if(Input::get('action') == 'Suspension'){
          $discipline->days = Input::get('days');
		}else{
          $discipline->days = null;
		}

        $discipline->discipline_date = Input::get('date');

		$discipline->update();

		 Audit::logaudit('Compliance', 'update', 'updated: '.$discipline->reason);

		return Redirect::route('compliance.index')->withFlashMessage('Compliance successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$discipline = Discipline::findOrFail($id);
        
		Discipline::destroy($id);

        Audit::logaudit('Compliance', 'delete', 'deleted: '.$discipline->reason);
		return Redirect::route('compliance.index')->withDeleteMessage('Compliance successfully deleted!');

}

}
