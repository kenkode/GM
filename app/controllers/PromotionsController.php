<?php

class PromotionsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$promotions = Promotion::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Promotions', 'view', 'viewed promotions');

		return View::make('promotions.index', compact('promotions'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('promotions.create',compact('employees'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Promotion::$rules,Promotion::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$promotion = new Promotion;

		$promotion->employee_id = Input::get('employee');

		$promotion->reason = Input::get('reason');

		$promotion->type = Input::get('type');

		$promotion->promotion_date = Input::get('date');

        $promotion->organization_id = Confide::user()->organization_id;

		$promotion->save();
       
        Audit::logaudit('Promotion', 'create', 'created: '.$promotion->type);

        if(Input::get('type') == 'Promotion'){
		return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully created!');
      	}else if(Input::get('type') == 'Demotion'){
        return Redirect::route('promotions.index')->withFlashMessage('Demotion successfully created!');
      	}
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$promotion = Promotion::findOrFail($id);

		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		return View::make('promotions.show', compact('promotion','employees'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$promotion = Promotion::find($id);

		$employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

		return View::make('promotions.edit', compact('promotion','employees'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$promotion = Promotion::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Promotion::$rules,Promotion::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$promotion->employee_id = Input::get('employee');

		$promotion->reason = Input::get('reason');

		$promotion->type = Input::get('type');

		$promotion->promotion_date = Input::get('date');

		$promotion->update();

		 Audit::logaudit('Promotion', 'update', 'updated: '.$promotion->type);

		if(Input::get('type') == 'Promotion'){
		return Redirect::to('promotions')->withFlashMessage('Promotion successfully updated!');
      	}else if(Input::get('type') == 'Demotion'){
        return Redirect::to('promotions')->withFlashMessage('Demotion successfully updated!');
      	}
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$promotion = Promotion::findOrFail($id);
        
		Promotion::destroy($id);

        Audit::logaudit('promotion', 'delete', 'deleted: '.$promotion->type);

		if($promotion->type == 'Promotion'){
		return Redirect::route('promotions.index')->withFlashMessage('Promotion successfully deleted!');
      	}else if($promotion->type == 'Demotion'){
        return Redirect::route('promotions.index')->withFlashMessage('Demotion successfully deleted!');
      	}

}

}
