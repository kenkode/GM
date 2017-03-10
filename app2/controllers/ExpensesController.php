<?php

class ExpensesController extends \BaseController {

	/**
	 * Display a listing of expenses
	 *
	 * @return Response
	 */
	public function index()
	{
		$expenses = Expense::where('organization_id',Confide::user()->organization_id)->where('void',0)->get();

		return View::make('expenses.index', compact('expenses'));
	}

	/**
	 * Show the form for creating a new expense
	 *
	 * @return Response
	 */
	public function create()
	{
		$accounts = Account::where('organization_id',Confide::user()->organization_id)->where('active',true)->get();
		$expensesettings = Expensesetting::where('id','>',1)->where('organization_id',Confide::user()->organization_id)->get();
		return View::make('expenses.create',compact('accounts','expensesettings'));
	}

	/**
	 * Store a newly created expense in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Expense::$rules, Expense::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$expense = new Expense;

		$expense->expensesetting_id = Input::get('name');
		$expense->type = Input::get('type');
		$expense->amount = Input::get('amount');		
		$expense->void = 0;		
		$expense->date = date("Y-m-d",strtotime(Input::get('date')));
		$expense->organization_id = Confide::user()->organization_id;
		$expense->expense_account_id = Input::get('expense_id');
		$expense->asset_account_id = Input::get('asset_id');
		$expense->save();

        DB::table('accounts')
            ->where('id', Input::get('account'))
            ->decrement('balance', Input::get('amount'));

        $data = array(
            'credit_account' => Input::get('asset_id'),
            'debit_account' => Input::get('expense_id'),
            'organization_id',Confide::user()->organization_id,
            'date' => date("Y-m-d",strtotime(Input::get('date'))),
            'amount' => Input::get('amount'),
            'initiated_by' => 'system',
            'description' => 'Company Expenses',
            'id' => $expense->id
          );


          $journal = new Journal;


          $journal->journal_expense($data);

		return Redirect::route('expenses.index')->withFlashMessage('Expense successfully created!');
	}

	/**
	 * Display the specified expense.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$expense = Expense::findOrFail($id);

		return View::make('expenses.show', compact('expense'));
	}

	/**
	 * Show the form for editing the specified expense.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$expense = Expense::find($id);
		$expensesettings = Expensesetting::where('id','>',1)->where('organization_id',Confide::user()->organization_id)->get();
		$accounts = Account::where('organization_id',Confide::user()->organization_id)->where('active',true)->get();

		return View::make('expenses.edit', compact('expense','accounts','expensesettings'));
	}

	/**
	 * Update the specified expense in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$expense = Expense::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Expense::$rules, Expense::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
     
        $expense->expensesetting_id = Input::get('name');
		$expense->type = Input::get('type');
		$expense->amount = Input::get('amount');
		$expense->date = date("Y-m-d",strtotime(Input::get('date')));
        $expense->expense_account_id = Input::get('expense_id');
		$expense->asset_account_id = Input::get('asset_id');
		$expense->update();

		$data = array(
            'credit_account' => Input::get('asset_id'),
            'debit_account' => Input::get('expense_id'),
            'organization_id',Confide::user()->organization_id,
            'date' => date("Y-m-d",strtotime(Input::get('date'))),
            'amount' => Input::get('amount'),
            'initiated_by' => 'system',
            'description' => 'Company Expenses',
            'id' => $expense->id,
            'aid' => $expense->asset_journal_id,
            'eid' => $expense->expense_journal_id
          );


          $journal = new Journal;


          $journal->journal_upde($data);


		return Redirect::route('expenses.index')->withFlashMessage('Expense successfully updated!');;
	}

	/**
	 * Remove the specified expense from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $expense = Expense::find($id);
        $expense->void = 1;
		$expense->update();

		$j = Journal::find($expense->expense_journal_id);
		$j->void=1;
		$j->update();

		$j = Journal::find($expense->asset_journal_id);
		$j->void=1;
		$j->update();

		return Redirect::route('expenses.index')->withDeleteMessage('Expense successfully deleted!');;
	}

}
