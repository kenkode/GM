<?php

class Journal extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];



	public function branch(){

		return $this->belongsTo('Branch');
	}


	public function account(){

		return $this->belongsTo('Account');
	}




	/**
	* function fo journal entries
	*/

	public  function journal_entry($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditAccount($data, $trans_no);

		// function for crediting

		$this->debitAccount($data, $trans_no);

		
	}

	public  function journal_payment($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditPaymentAccount($data, $trans_no);

		// function for crediting

		$this->debitPaymentAccount($data, $trans_no);

		
	}

	public  function journal_expense($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditExpenseAccount($data, $trans_no);

		// function for crediting

		$this->debitExpenseAccount($data, $trans_no);

		
	}

	public  function journal_updp($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditUpdatePaymentAccount($data, $trans_no);

		// function for crediting

		$this->debitUpdatePaymentAccount($data, $trans_no);

		
	}

	public  function journal_upde($data){


		$trans_no = $this->getTransactionNumber();


		// function for crediting

		$this->creditUpdateExpenseAccount($data, $trans_no);

		// function for crediting

		$this->debitUpdateExpenseAccount($data, $trans_no);

		
	}



	public function getTransactionNumber(){

		$date = date('Y-m-d H:m:s');

		$trans_no  = strtotime($date);

		return $trans_no;
	}


	public function creditAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);


	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();
	}



	public function debitAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['debit_account']);


	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();
	}


    public function creditPaymentAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);

	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

        $payment = Payment::find($data['id']);
		$payment->receivable_journal_id = $journal->id;
		$payment->update();
		
	}



	public function debitPaymentAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['debit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

		$payment = Payment::find($data['id']);
		$payment->cash_journal_id = $journal->id;
		$payment->update();
	}

	public function creditUpdatePaymentAccount($data, $trans_no){

		$j = Journal::find($data['rid']);
		$j->void=1;
		$j->update();

		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

		$payment = Payment::find($data['id']);
		$payment->receivable_journal_id = $journal->id;
		$payment->update();
	}



	public function debitUpdatePaymentAccount($data, $trans_no){

		$j = Journal::find($data['cid']);
		$j->void=1;
		$j->update();

		$journal = new Journal;

		$account = Account::findOrFail($data['debit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

        $payment = Payment::find($data['id']);
		$payment->cash_journal_id = $journal->id;
		$payment->update();

		
	}

	public function creditExpenseAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);

	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

        $expense = Expense::find($data['id']);
		$expense->asset_journal_id = $journal->id;
		$expense->update();
		
	}



	public function debitExpenseAccount($data, $trans_no){

		$journal = new Journal;


		$account = Account::findOrFail($data['debit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

		$expense = Expense::find($data['id']);
		$expense->expense_journal_id = $journal->id;
		$expense->update();
	}

	public function creditUpdateExpenseAccount($data, $trans_no){

		$j = Journal::find($data['aid']);
		$j->void=1;
		$j->update();

		$journal = new Journal;


		$account = Account::findOrFail($data['credit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'credit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

		$expense = Expense::find($data['id']);
		$expense->asset_journal_id = $journal->id;
		$expense->update();
	}



	public function debitUpdateExpenseAccount($data, $trans_no){

		$j = Journal::find($data['eid']);
		$j->void=1;
		$j->update();

		$journal = new Journal;

		$account = Account::findOrFail($data['debit_account']);
	
		$journal->account()->associate($account);

		$journal->date = $data['date'];
		$journal->trans_no = $trans_no;
		$journal->initiated_by = $data['initiated_by'];
		$journal->amount = $data['amount'];
		$journal->type = 'debit';
		$journal->description = $data['description'];
		$journal->organization_id = Confide::user()->organization_id;
		$journal->save();

        $expense = Expense::find($data['id']);
		$expense->expense_journal_id = $journal->id;
		$expense->update();

		
	}


}