<?php

class PaymentsController extends \BaseController {

	/**
	 * Display a listing of payments
	 *
	 * @return Response
	 */
	public function index()
	{
		
		/*
		$payments = DB::table('payments')
		          ->join('erporders', 'payments.erporder_id', '=', 'erporders.id')
		          ->join('erporderitems', 'payments.erporder_id', '=', 'erporderitems.erporder_id')
		          ->join('clients', 'erporders.client_id', '=', 'clients.id')
		          ->join('items', 'erporderitems.item_id', '=', 'items.id')
		          ->select('clients.name as client','items.name as item','payments.amount_paid as amount','payments.date as date','payments.erporder_id as erporder_id','payments.id as id','erporders.order_number as order_number')
		          ->get();
		          */

		$erporders = Erporder::where('organization_id',Confide::user()->organization_id)->get();	
		$erporderitems = Erporderitem::where('organization_id',Confide::user()->organization_id)->get();	
		$paymentmethods = Paymentmethod::where('organization_id',Confide::user()->organization_id)->get();
		$payments = Payment::where('organization_id',Confide::user()->organization_id)->where('void',0)->get();
		

		return View::make('payments.index', compact('erporderitems','erporders','paymentmethods','payments'));
	}

	/**
	 * Show the form for creating a new payment
	 *
	 * @return Response
	 */
	public function create()
	{
		$erporders = Erporder::where('organization_id',Confide::user()->organization_id)->get();
		$accounts = Account::where('organization_id',Confide::user()->organization_id)->where('active',true)->get();
		$erporderitems = Erporderitem::where('organization_id',Confide::user()->organization_id)->get();
		$paymentmethods = Paymentmethod::where('organization_id',Confide::user()->organization_id)->get();
		$clients = DB::table('clients')
		         ->join('erporders','clients.id','=','erporders.client_id')
		         ->where('erporders.organization_id',Confide::user()->organization_id)
		         ->select( DB::raw('DISTINCT(name),clients.id') )
		         ->get();
		
		return View::make('payments.create',compact('erporders','clients','erporderitems','paymentmethods','accounts'));
	}

	/**
	 * Store a newly created payment in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Payment::$rules, Payment::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		//$erporder = Erporder::find(Input::get('order'));

		$payment = new Payment;

		$client = Client::findOrFail(Input::get('order'));
		$payment->client_id = Input::get('order');
        $payment->cash_account_id = Input::get('cash');
		$payment->receivable_acc_id = Input::get('receivable');
		$payment->amount_paid = Input::get('amount');			
		$payment->paymentmethod_id = Input::get('paymentmethod');		
		$payment->received_by = Input::get('received_by');
		$payment->organization_id = Confide::user()->organization_id;
		$payment->void = 0;
		$payment->date = date("Y-m-d",strtotime(Input::get('pay_date')));
		$payment->save();
       
        $data = array(
            'credit_account' => Input::get('receivable'),
            'debit_account' => Input::get('cash'),
            'organization_id',Confide::user()->organization_id,
            'date' => date("Y-m-d",strtotime(Input::get('pay_date'))),
            'amount' => Input::get('amount'),
            'initiated_by' => 'system',
            'description' => 'Sale of Goods',
            'id' => $payment->id
          );


          $journal = new Journal;


          $journal->journal_payment($data);


		return Redirect::route('payments.index')->withFlashMessage('Payment successfully created!');
	}

	/**
	 * Display the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$payment = Payment::findOrFail($id);
		$erporderitem = Erporderitem::findOrFail($id);
		$erporder = Erporder::findOrFail($id);

		return View::make('payments.show', compact('payment','erporderitem','erporder'));
	}

	/**
	 * Show the form for editing the specified payment.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$payment = Payment::find($id);
		$accounts = Account::where('organization_id',Confide::user()->organization_id)->where('active',true)->get();
		$erporders = Erporder::where('organization_id',Confide::user()->organization_id)->get();
		$erporderitems = Erporderitem::where('organization_id',Confide::user()->organization_id)->get();

		return View::make('payments.edit', compact('payment','erporders','erporderitems','accounts'));
	}

	/**
	 * Update the specified payment in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$payment = Payment::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Payment::$rules, Payment::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$payment->amount_paid = Input::get('amount');
		$payment->date = date("Y-m-d",strtotime(Input::get('pay_date')));
		$payment->cash_account_id = Input::get('cash');
		$payment->receivable_acc_id = Input::get('receivable');
		$payment->update();

		$data = array(
            'credit_account' => Input::get('receivable'),
            'debit_account' => Input::get('cash'),
            'organization_id',Confide::user()->organization_id,
            'date' => date("Y-m-d",strtotime(Input::get('pay_date'))),
            'amount' => Input::get('amount'),
            'initiated_by' => 'system',
            'description' => 'Sale of Goods',
            'id' => $payment->id,
            'cid' => $payment->cash_journal_id,
            'rid' => $payment->receivable_journal_id
          );


          $journal = new Journal;


          $journal->journal_updp($data);


		return Redirect::route('payments.index')->withFlashMessage('Payment successfully updated!');
	}

	/**
	 * Remove the specified payment from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$payment = Payment::find($id);
        $payment->void = 1;
		$payment->update();

		$j = Journal::find($payment->cash_journal_id);
		$j->void=1;
		$j->update();

		$j = Journal::find($payment->receivable_journal_id);
		$j->void=1;
		$j->update();

		return Redirect::route('payments.index')->withDeleteMessage('Payment successfully deleted!');
	}

}
