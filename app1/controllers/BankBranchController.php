<?php

class BankBranchController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$bbranches = BBranch::where('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Bank branches', 'view', 'viewed bank branches');

		return View::make('bank_branch.index', compact('bbranches'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$banks = Bank::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('bank_branch.create',compact('banks'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), BBranch::$rules,BBranch::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bbranch = new BBranch;
		$bbranch->bank_branch_name = Input::get('name');
		$bbranch->branch_code = Input::get('code');
		$bbranch->bank_id = Input::get('bank_id');
        $bbranch->organization_id = Confide::user()->organization_id;
		$bbranch->save();

		Audit::logaudit('Bank Branch', 'create', 'created: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withFlashMessage('Bank Branch successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$bbranch = BBranch::findOrFail($id);

		return View::make('bank_branch.show', compact('bbranch'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$bbranch = BBranch::find($id);
		$banks = Bank::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('bank_branch.edit', compact('bbranch','banks'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$bbranch = BBranch::findOrFail($id);

		$validator = Validator::make($data = Input::all(), BBranch::$rules,BBranch::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$bbranch->bank_branch_name = Input::get('name');
		$bbranch->branch_code = Input::get('code');
		$bbranch->bank_id = Input::get('bank_id');
		$bbranch->update();

		Audit::logaudit('Bank Branch', 'update', 'updated: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withFlashMessage('Bank Branch successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$bbranch = BBranch::findOrFail($id);

		BBranch::destroy($id);

		Audit::logaudit('Bank Branch', 'delete', 'deleted: '.$bbranch->bank_branch_name);

		return Redirect::route('bank_branch.index')->withDeleteMessage('Bank Branch successfully deleted!');

  }

}
