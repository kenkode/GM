<?php

class DepartmentsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Departments', 'view', 'viewed departments');

		return View::make('departments.index', compact('departments'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('departments.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Department::$rules,Department::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$department = new Department;

		$department->department_name = Input::get('name');

                $department->organization_id = Confide::user()->organization_id;

		$department->save();
       
        Audit::logaudit('Department', 'create', 'created: '.$department->department_name);

		return Redirect::route('departments.index')->withFlashMessage('Department successfully updated!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$department = Department::findOrFail($id);

		return View::make('departments.show', compact('department'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$department = Department::find($id);

		return View::make('departments.edit', compact('department'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$department = Department::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Department::$rules,Department::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$department->department_name = Input::get('name');
		$department->update();

		 Audit::logaudit('Department', 'update', 'updated: '.$department->department_name);

		return Redirect::route('departments.index')->withFlashMessage('Department successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$department = Department::findOrFail($id);
        $dept  = DB::table('employee')->where('department_id',$id)->count();
		if($dept>0){
			return Redirect::route('departments.index')->withDeleteMessage('Cannot delete this departments because its assigned to an employee(s)!');
		}else{
		Department::destroy($id);

        Audit::logaudit('Department', 'delete', 'deleted: '.$department->department_name);
		return Redirect::route('departments.index')->withDeleteMessage('Deduction successfully deleted!');
	}

}

}
