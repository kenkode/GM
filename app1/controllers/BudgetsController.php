<?php

class BudgetsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$budgets = Budget::where('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Budgets', 'view', 'viewed budgets');

		return View::make('budgets.index', compact('budgets'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		$expensesettings = Expensesetting::where('organization_id',Confide::user()->organization_id)->get();
		return View::make('budgets.create',compact('currency','expensesettings'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Budget::$rules,Budget::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$part = explode("-", Input::get('period'));

		$c = DB::table('budgets')
            ->where('financial_month',$part[0])
            ->where('financial_year',$part[1])
            ->where('organization_id',Confide::user()->organization_id)
            ->where('expensesetting_id',Input::get('name'))
            ->count();

		if($c>0){
        return Redirect::route('budgets.index')->withDeleteMessage('The Budget for '.Expensesetting::getName(Input::get('name')).' for '.Input::get('period').' already exists!');
		}else{

		
              
        $month = $part[0];

		$budget = new Budget;

        $budget->expensesetting_id = Input::get('name');

		$budget->amount = Input::get('amount');

		$budget->financial_month = $part[0];

		$budget->financial_year = $part[1];

                $budget->organization_id = Confide::user()->organization_id;

		$budget->save();

		Audit::logaudit('Budgets', 'create', 'created: '.$budget->name.' for '.Input::get('period'));

		return Redirect::route('budgets.index')->withFlashMessage('Estimated budget amount for '.$budget->name.' successfully created!');
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
		$budget = Budget::findOrFail($id);

		return View::make('budgets.show', compact('budget'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$budget = Budget::find($id);
		$expensesettings = Expensesetting::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

		return View::make('budgets.edit', compact('budget','currency','expensesettings'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$budget = Budget::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Budget::$rules, Budget::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        $part = explode("-", Input::get('period'));
              
        $month = $part[0];

        $budget->expensesetting_id = Input::get('name');

		$budget->amount = Input::get('amount');

        $budget->financial_month = $part[0];

		$budget->financial_year = $part[1];

		$budget->update();
        
        Audit::logaudit('Budget', 'update', 'updated: '.$budget->name.' for '.Input::get('period'));

		return Redirect::route('budgets.index')->withFlashMessage('Estimated budget amount for '.$budget->name.' successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	        
		$budget = Budget::findOrFail($id);
		
		Budget::destroy($id);

        Audit::logaudit('Budget', 'delete', 'deleted: '.$budget->amount);
		return Redirect::route('budgets.index')->withDeleteMessage('Estimated Budget amount for '.$budget->name.' successfully deleted!');
    }

}
