<?php

class EmailGroupsController extends \BaseController {

	/**
	 * Display a listing of currencies
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Emailgroup::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('emailgroups.index', compact('groups'));
	}

	/**
	 * Show the form for creating a new currency
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('emailgroups.create');
	}

	/**
	 * Store a newly created currency in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Emailgroup::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$group = new Emailgroup;
		$group->name = Input::get('name');
		$group->email = Input::get('email');
		if(Input::get('report_application') != null ){
		$group->report_applications = '1';
	    }else{
	    $group->report_applications = '0';
	    }
	    if(Input::get('report_approved') != null ){
		$group->report_approved = '1';
	    }else{
	    $group->report_approved = '0';
	    }
	    if(Input::get('report_rejected') != null ){
		$group->report_rejected = '1';
	    }else{
	    $group->report_rejected = '0';
	    }
	    if(Input::get('report_balance') != null ){
		$group->report_balances = '1';
	    }else{
	    $group->report_balances = '0';
	    }
	    if(Input::get('report_employee') != null ){
		$group->report_employee_on_leave = '1';
	    }else{
	    $group->report_employee_on_leave = '0';
	    }
	    if(Input::get('report_individual') != null ){
		$group->report_individual = '1';
	    }else{
	    $group->report_individual = '0';
	    }
		$group->organization_id = Confide::user()->organization_id;
		$group->save();
		Audit::logaudit('Email Group', 'create', 'created: '.$group->name);

		return Redirect::route('emailgroups.index')->withFlashMessage('Email Group successfully created!');
	}

	/**
	 * Display the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$currency = Currency::where('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Currency', 'view', 'viewed: '.$currency->name);

		return View::make('currencies.show', compact('currency'));

	}

	/**
	 * Show the form for editing the specified currency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$group = Emailgroup::find($id);

		return View::make('emailgroups.edit', compact('group'));
	}

	/**
	 * Update the specified currency in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$group = Emailgroup::find($id);

		$validator = Validator::make($data = Input::all(), Emailgroup::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$group->name = Input::get('name');
		$group->email = Input::get('email');
		if(Input::get('report_application') != null ){
		$group->report_applications = '1';
	    }else{
	    $group->report_applications = '0';
	    }
	    if(Input::get('report_approved') != null ){
		$group->report_approved = '1';
	    }else{
	    $group->report_approved = '0';
	    }
	    if(Input::get('report_rejected') != null ){
		$group->report_rejected = '1';
	    }else{
	    $group->report_rejected = '0';
	    }
	    if(Input::get('report_balance') != null ){
		$group->report_balances = '1';
	    }else{
	    $group->report_balances = '0';
	    }
	    if(Input::get('report_employee') != null ){
		$group->report_employee_on_leave = '1';
	    }else{
	    $group->report_employee_on_leave = '0';
	    }
	    if(Input::get('report_individual') != null ){
		$group->report_individual = '1';
	    }else{
	    $group->report_individual = '0';
	    }
		$group->organization_id = Confide::user()->organization_id;
		
		$group->update();

		Audit::logaudit('Email Group', 'update', 'updated: '.$group->name);

		return Redirect::route('emailgroups.index');
	}

	/**
	 * Remove the specified currency from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$group = Emailgroup::findOrFail($id);
		Emailgroup::destroy($id);

		Audit::logaudit('Email Group', 'delete', 'deleted: '.$group->name);

		return Redirect::route('emailgroups.index');
	}

}
