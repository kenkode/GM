<?php

class ReliefsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$reliefs = Relief::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Reliefs', 'view', 'viewed reliefs');

		return View::make('reliefs.index', compact('reliefs'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('reliefs.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Relief::$rules,Relief::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$relief = new Relief;

		$relief->relief_name = Input::get('name');

                $relief->organization_id = Confide::user()->organization_id;

		$relief->save();

		Audit::logaudit('Reliefs', 'create', 'created: '.$relief->relief_name);

		return Redirect::route('reliefs.index')->withFlashMessage('Relief successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$relief = Relief::findOrFail($id);

		return View::make('reliefs.show', compact('relief'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$relief = Relief::find($id);

		return View::make('reliefs.edit', compact('relief'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$relief = Relief::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Relief::$rules,Relief::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$relief->relief_name = Input::get('name');
		$relief->update();
        Audit::logaudit('Reliefs', 'update', 'updated: '.$relief->relief_name);

		return Redirect::route('reliefs.index')->withFlashMessage('Relief successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $relief = Relief::findOrFail($id);
		Relief::destroy($id);
        Audit::logaudit('Reliefs', 'delete', 'deleted: '.$relief->relief_name);
		return Redirect::route('reliefs.index')->withDeleteMessage('Relief successfully deleted!');
	}

}
