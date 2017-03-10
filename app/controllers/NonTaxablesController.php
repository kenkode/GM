<?php

class NonTaxablesController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$nontaxables = Nontaxable::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Nontaxables', 'view', 'viewed non taxable income list ');

		return View::make('nontaxables.index', compact('nontaxables'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('nontaxables.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Nontaxable::$rules, Nontaxable::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nontaxable = new Nontaxable;

		$nontaxable->name = Input::get('name');

                $nontaxable->organization_id = Confide::user()->organization_id;

		$nontaxable->save();

		Audit::logaudit('Nontaxables', 'create', 'created: '.$nontaxable->name);

		return Redirect::route('nontaxables.index')->withFlashMessage('Non taxable income successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$nontaxable = Nontaxable::findOrFail($id);

		return View::make('nontaxables.show', compact('nontaxable'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nontaxable = Nontaxable::find($id);

		return View::make('nontaxables.edit', compact('nontaxable'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nontaxable = Nontaxable::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Nontaxable::$rules, Nontaxable::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nontaxable->name = Input::get('name');
		$nontaxable->update();

		Audit::logaudit('Nontaxable', 'update', 'updated: '.$nontaxable->name);

		return Redirect::route('nontaxables.index')->withFlashMessage('Non taxable income successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$nontaxable = Nontaxable::findOrFail($id);
		$nontax  = DB::table('employeenontaxables')->where('nontaxable_id',$id)->count();
		if($nontax>0){
			return Redirect::route('nontaxables.index')->withDeleteMessage('Cannot delete this non taxable income because its assigned to an employee(s)!');
		}else{
		
		Nontaxable::destroy($id);

		Audit::logaudit('Nontaxables', 'delete', 'deleted: '.$nontaxable->name);

		return Redirect::route('nontaxables.index')->withDeleteMessage('Non taxable income successfully deleted!');
	}

 }

}
