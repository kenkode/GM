<?php

class BranchesController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$branches = Branch::where('organization_id',Confide::user()->organization_id)->get();
		Audit::logaudit('Branches', 'view', 'viewed branches');

		return View::make('branches.index', compact('branches'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('branches.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Branch::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$branch = new Branch;

		$branch->name = Input::get('name');
		$branch->organization_id = Confide::user()->organization_id;
		$branch->save();

        Audit::logaudit('Branches', 'create', 'created: '.$branch->name);
		return Redirect::route('branches.index')->withFlashMessage('Branch successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$branch = Branch::findOrFail($id);

		return View::make('branches.show', compact('branch'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$branch = Branch::find($id);

		return View::make('branches.edit', compact('branch'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$branch = Branch::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Branch::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$branch->name = Input::get('name');
		$branch->update();

        Audit::logaudit('Branches', 'update', 'updated: '.$branch->name);
		return Redirect::route('branches.index')->withFlashMessage('Branch successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$branch = Branch::findOrFail($id);
		$app  = DB::table('employee')
		->where('organization_id',Confide::User()->organization_id)
		->where('branch_id',$id)
		->count();
		if($app>0){
			return Redirect::route('branches.index')->withDeleteMessage('Cannot delete this branch because its assigned to an employee(s)!');
		}else{
		
		Branch::destroy($id);
        Audit::logaudit('Branches', 'delete', 'deleted: '.$branch->name);
		return Redirect::route('branches.index')->withDeleteMessage('Branch successfully deleted!');
	}
}

}
