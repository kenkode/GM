<?php

class CitizenshipController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

        
		Audit::logaudit('Citizenships', 'view', 'viewed citizenships');


		return View::make('citizenship.index', compact('citizenships'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('citizenship.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Citizenship::$rules, Citizenship::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$citizenship = new Citizenship;

		$citizenship->name = Input::get('name');

        $citizenship->organization_id = Confide::user()->organization_id;

		$citizenship->save();

		Audit::logaudit('Citizenships', 'create', 'created: '.$citizenship->name);


		return Redirect::route('citizenships.index')->withFlashMessage('Citizenship successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$citizenship = Citizenship::findOrFail($id);

		return View::make('citizenship.show', compact('citizenship'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$citizenship = Citizenship::find($id);

		return View::make('citizenship.edit', compact('citizenship'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$citizenship = Citizenship::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Citizenship::$rules, Citizenship::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$citizenship->name = Input::get('name');
		$citizenship->update();

		Audit::logaudit('Citizenships', 'update', 'updated: '.$citizenship->name);

		return Redirect::route('citizenships.index')->withFlashMessage('Citizenship successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$citizenship = Citizenship::findOrFail($id);
		$citizen  = DB::table('employee')->where('citizenship_id',$id)->count();
		if($citizen > 0){
			return Redirect::route('citizenships.index')->withDeleteMessage('Cannot delete this citizenship because its assigned to an employee(s)!');
		}else{
		Citizenship::destroy($id);

		Audit::logaudit('Citizenships', 'delete', 'deleted: '.$citizenship->name);

		return Redirect::route('citizenships.index')->withDeleteMessage('Citizenship successfully deleted!');
	}
  }

}
