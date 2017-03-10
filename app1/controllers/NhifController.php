<?php

class NhifController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$nrates = DB::table('hospital_insurance')->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->where('income_from', '!=', 0.00)->get();

		Audit::logaudit('NHIF', 'view', 'viewed nhif rates');
		return View::make('nhif.index', compact('nrates'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('nhif.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), NhifRates::$rules,NhifRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$nrate = new NhifRates;

		$a = str_replace( ',', '', Input::get('i_from') );
        $b = str_replace( ',', '', Input::get('i_to') );
        $c = str_replace( ',', '', Input::get('amount') );

		$nrate->income_from = $a;

		$nrate->income_to = $b;

		$nrate->hi_amount = $c;

        $nrate->organization_id = Confide::user()->organization_id;

		$nrate->save();

		Audit::logaudit('NHIF', 'create', 'created: '.$nrate->hi_amount.' for income from '.$nrate->income_from.' to '.$nrate->income_to);

		return Redirect::route('nhif.index')->withFlashMessage('Nhif successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$nrate = NhifRates::findOrFail($id);

		return View::make('nhif.show', compact('nrate'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$nrate = NhifRates::find($id);

		return View::make('nhif.edit', compact('nrate'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$nrate = NhifRates::findOrFail($id);

		$validator = Validator::make($data = Input::all(), NhifRates::$rules,NhifRates::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$a = str_replace( ',', '', Input::get('i_from') );
        $b = str_replace( ',', '', Input::get('i_to') );
        $c = str_replace( ',', '', Input::get('amount') );

		$nrate->income_from = $a;

		$nrate->income_to = $b;

		$nrate->hi_amount = $c;

		$nrate->update();

		Audit::logaudit('NHIF', 'update', 'updated: '.$nrate->hi_amount.' for income from '.$nrate->income_from.' to '.$nrate->income_to);

		return Redirect::route('nhif.index')->withFlashMessage('Nhif successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$nrate = NhifRates::findOrFail($id);

		NhifRates::destroy($id);

		Audit::logaudit('NHIF', 'delete', 'deleted: '.$nrate->hi_amount.' for income from '.$nrate->income_from.' to '.$nrate->income_to);

		return Redirect::route('nhif.index')->withDeleteMessage('Nhif successfully deleted!');
	}

}
