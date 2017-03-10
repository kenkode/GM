<?php

class NssfController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$nrates = DB::table('social_security')->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->where('income_from', '!=', 0.00)->get();

		Audit::logaudit('NSSF', 'view', 'viewed nssf rates');

		return View::make('nssf.index', compact('nrates'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('nssf.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), NssfRates::$rules,NssfRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate = new NssfRates;

		$nrate->tier = Input::get('tier');

		$a = str_replace( ',', '', Input::get('i_from') );
        $b = str_replace( ',', '', Input::get('i_to') );
        $c = str_replace( ',', '', Input::get('employee_amount') );
        $d = str_replace( ',', '', Input::get('employer_amount') );

		$nrate->income_from = $a;

		$nrate->income_to = $b;

		$nrate->ss_amount_employee = $c;

		$nrate->ss_amount_employer = $d;

                $nrate->organization_id = Confide::user()->organization_id;

		$nrate->save();

		Audit::logaudit('NSSF', 'create', 'created: '.$nrate->ss_amount_employee.' for income from '.$nrate->income_from.' to '.$nrate->income_to);

		return Redirect::route('nssf.index')->withFlashMessage('Nssf successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$nrate = NssfRates::findOrFail($id);

		return View::make('nssf.show', compact('nrate'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nrate = NssfRates::find($id);

		return View::make('nssf.edit', compact('nrate'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nrate = NssfRates::findOrFail($id);

		$validator = Validator::make($data = Input::all(), NssfRates::$rules,NssfRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate->tier = Input::get('tier');

		$a = str_replace( ',', '', Input::get('i_from') );
        $b = str_replace( ',', '', Input::get('i_to') );
        $c = str_replace( ',', '', Input::get('employee_amount') );
        $d = str_replace( ',', '', Input::get('employer_amount') );

		$nrate->income_from = $a;

		$nrate->income_to = $b;

		$nrate->ss_amount_employee = $c;

		$nrate->ss_amount_employer = $d;

		$nrate->update();

		Audit::logaudit('NSSF', 'update', 'updated: '.$nrate->ss_amount_employee.' for income from '.$nrate->income_from.' to '.$nrate->income_to);

		return Redirect::route('nssf.index')->withFlashMessage('Nssf successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$nrate = NssfRates::findOrFail($id);
		NssfRates::destroy($id);
        Audit::logaudit('NSSF', 'delete', 'deleted: '.$nrate->ss_amount_employee.' for income from '.$nrate->income_from.' to '.$nrate->income_to);
		return Redirect::route('nssf.index')->withDeleteMessage('Nssf successfully deleted!');
	}

}
