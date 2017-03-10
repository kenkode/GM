<?php

class ErpReportsController extends \BaseController {


	public function clients(){

        $from = Input::get("from");
        $to= Input::get("to");

		/*$clients = Client::all();*/

        $clients = DB::table('clients')
                    ->where('organization_id',Confide::user()->organization_id)
                    ->whereBetween('date', array(Input::get("from"), Input::get("to")))->get();

		$organization = Organization::find(Confide::user()->organization_id);

		$pdf = PDF::loadView('erpreports.clientsReport', compact('clients', 'organization','from','to'))->setPaper('a4')->setOrientation('landscape');
 	
		return $pdf->stream('Client List.pdf');
		
	}

    public function items(){

        $from = Input::get("from");
        $to= Input::get("to");

        /*$items = Item::all();*/

        $items = DB::table('items')
                    ->where('organization_id',Confide::user()->organization_id)
                    ->whereBetween('date', array(Input::get("from"), Input::get("to")))->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.itemsReport', compact('items', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Item List.pdf');
        
    }

    public function expenses(){

        $from = Input::get("from");
        $to= Input::get("to");

        $expenses = Expense::where('organization_id',Confide::user()->organization_id)->where('void',0)->whereBetween('date', array(Input::get("from"), Input::get("to")))->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.expensesReport', compact('expenses', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Expense List.pdf');
        
    }

    public function paymentmethods(){

        $paymentmethods = Paymentmethod::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.paymentmethodsReport', compact('paymentmethods', 'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Payment Method List.pdf');
        
    }

    public function payments(){

        $from = Input::get("from");
        $to= Input::get("to");

        /*$payments = Payment::all();*/

        $payments = Payment::where('organization_id',Confide::user()->organization_id)->where('void',0)->whereBetween('date', array(Input::get("from"), Input::get("to")))->get();


        $erporders = Erporder::where('organization_id',Confide::user()->organization_id)->get();

        $erporderitems = Erporderitem::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.paymentsReport', compact('payments','erporders', 'erporderitems', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Payment List.pdf');
        
    }


    public function invoice($id){

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->get();

        $count = DB::table('tax_orders')->where('organization_id',Confide::user()->organization_id)->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.invoice', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Invoice.pdf');
        
    }


    public function receipt($id){

         $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->where('organization_id',Confide::user()->organization_id)->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.receipt', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Invoice.pdf');
        
    }


    public function locations(){

        $locations = Location::where('organization_id',Confide::user()->organization_id)->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.locationsReport', compact('locations', 'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Stores List.pdf');
        
    }



    public function stock(){

        $items = Item::where('organization_id',Confide::user()->organization_id)->get();      

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.stockReport', compact('items', 'organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Stock Report.pdf');

       /* $items = Item::all();

        $from = Input::get("from");
        $to= Input::get("to");

        $items = DB::table('items')
                    ->whereBetween('date', array(Input::get("from"), Input::get("to")))->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.stockReport', compact('items', 'organization','from','to'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Stock Report.pdf');*/
        
    }

    public function sales(){

    $from = Input::get("from");
    $to= Input::get("to");

    $sales = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.type','=','sales')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->whereBetween('erporders.date', array(Input::get("from"), Input::get("to")))
                ->orderBy('erporders.order_number', 'Desc')
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id','erporders.status',
                  'discount_amount','erporders.date','erporders.order_number as order_number','price','description','erporders.type')
                ->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.salesReport', compact('sales', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Sales List.pdf');

  
}

public function sales_summary(){        
  

    $from = date('Y-m-d');
    $to= date('Y-m-d');

    $sales = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.type','=','sales')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->whereBetween('erporders.date', array($from, $to))
                ->orderBy('erporders.order_number', 'Desc')
                ->select(DB::raw('clients.name as client,items.name as item,quantity,clients.address as address,
                  clients.phone as phone,clients.email as email,erporders.id as id,erporders.status,
                  erporders.date,erporders.order_number as order_number,price,description,erporders.type'))
                
                ->get();
   
     $total_payment= DB::table('payments')
                ->join('clients', 'payments.client_id', '=', 'clients.id')
                ->where('clients.type','=','Customer')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                /*->whereBetween('erporders.date', array(Input::get("from"), Input::get("to")))*/
                ->select(DB::raw('COALESCE(SUM(amount_paid),0) as amount_paid'))
                
                ->first();

    $total_sales_todate = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->where('erporders.type','=','sales')
                ->where('erporders.organization_id',Confide::user()->organization_id)                
                ->select(DB::raw('COALESCE(SUM(quantity*price),0) as total_sales'))               
                ->first();

    $discount_amount = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')   
                ->where('erporders.organization_id',Confide::user()->organization_id)            
                ->whereBetween('erporders.date', array($from, $to))                
                ->select(DB::raw('COALESCE(SUM(discount_amount),0) as discount_amount'))               
                ->first();

    $discount_amount_todate = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')  
                ->where('erporders.organization_id',Confide::user()->organization_id)             
                ->select(DB::raw('COALESCE(SUM(discount_amount),0) as discount_amount'))             
                ->first();

      $items = Item::where('organization_id',Confide::user()->organization_id)->get();
      $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
      $organization = Organization::find(Confide::user()->organization_id);
      $accounts = DB::table('accounts')
                    ->where('organization_id',Confide::user()->organization_id)
                    ->get();


        $pdf = PDF::loadView('erpreports.salesSummaryReport', compact('sales','accounts', 'discount_amount','total_sales_todate','discount_amount_todate','total_payment', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');

    return $pdf->stream('Summary Report.pdf');
    }

public function purchases(){

    $from = Input::get("from");
    $to= Input::get("to");

    $purchases = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.type','=','purchases')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->whereBetween('erporders.date', array(Input::get("from"), Input::get("to")))
                ->orderBy('erporders.order_number', 'Desc')
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id','erporders.status',
                  'discount_amount','erporders.date','erporders.order_number as order_number','price','description','erporders.type')
                ->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.purchasesReport', compact('purchases', 'organization','from','to'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Purchases List.pdf');

  
}

   public function pricelist(){

        $pricelist = $pricelist = DB::table('items')
                    ->where('organization_id',Confide::user()->organization_id)
                    ->select('items.name as item','items.purchase_price','items.selling_price')
                    ->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.pricelist', compact('pricelist', 'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Price List.pdf');
        
    }


    public function quotation($id){

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->where('organization_id',Confide::user()->organization_id)->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.quotation', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('quotation.pdf');
        
    }






    public function PurchaseOrder($id){

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->get();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.organization_id',Confide::user()->organization_id)
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->where('organization_id',Confide::user()->organization_id)->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.PurchaseOrder', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Purchase Order.pdf');
        
    }


    public function selectSalesPeriod()
    {
       $sales = Erporder::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.erpfinancials.selectSalesPeriod',compact('sales'));
    }

    public function selectPurchasesPeriod()
    {
       $purchases = Erporder::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectPurchasesPeriod',compact('purchases'));
    }


    public function selectClientsPeriod()
    {
       $clients = Client::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectClientsPeriod',compact('clients'));
    }

     public function selectItemsPeriod()
    {
       $items = Item::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectItemsPeriod',compact('items'));
    }

    public function selectExpensesPeriod()
    {
       $expenses = Expense::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectExpensesPeriod',compact('expenses'));
    }

     public function selectPaymentsPeriod()
    {
       $payments = Payment::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectPaymentsPeriod',compact('payments'));
    }

    public function selectStockPeriod()
    {
       $stocks = Item::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('erpreports.selectStocksPeriod',compact('stocks'));
    }


    public function accounts(){

        $accounts = Account::where('organization_id',Confide::user()->organization_id)->where('active',true)->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('erpreports.accountsReport', compact('accounts', 'organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Account Balances.pdf');
        
    }


    /**
     * GENERATE BANK RECONCILIATION REPORT
     */
    public function displayRecOptions(){
        $bankAccounts = DB::table('bank_accounts')
                        ->where('organization_id',Confide::user()->organization_id)
                        ->get();

        $bookAccounts = DB::table('accounts')
                        ->where('category', 'ASSET')
                        ->where('organization_id',Confide::user()->organization_id)
                        ->get();

        return View::make('erpreports.recOptions', compact('bankAccounts','bookAccounts'));
    }

    public function showRecReport(){
        $bankAcID = Input::get('bank_account');
        $bookAcID = Input::get('book_account');
        $recMonth = Input::get('rec_month'); 

        //get statement id
        $bnkStmtID = DB::table('bank_statements')
                    ->where('stmt_month', $recMonth)
                    ->where('organization_id',Confide::user()->organization_id)
                    ->pluck('id');

        $bnkStmtBal = DB::table('bank_statements')
                            ->where('bank_account_id', $bankAcID)
                            ->where('stmt_month', $recMonth)
                            ->where('organization_id',Confide::user()->organization_id)
                            ->select('bal_bd')
                            ->first();

        $acTransaction = DB::table('account_transactions')
                            ->where('status', '=', 'RECONCILED')
                            ->where('bank_statement_id', $bnkStmtID)
                            ->where('organization_id',Confide::user()->organization_id)
                            ->whereMonth('transaction_date', '=', substr($recMonth, 0, 2))
                            ->whereYear('transaction_date', '=', substr($recMonth, 3, 6))
                            ->select('id','account_credited','account_debited','transaction_amount')
                            ->get();

        $bkTotal = 0;
        foreach($acTransaction as $acnt){
            if($acnt->account_debited == $bookAcID){
                $bkTotal += $acnt->transaction_amount;
            } else if($acnt->account_credited == $bookAcID){
                $bkTotal -= $acnt->transaction_amount;
            }
        }

        $additions = DB::table('account_transactions')
                            ->where('status', '=', 'RECONCILED')
                            ->where('bank_statement_id', $bnkStmtID)
                            ->where('organization_id',Confide::user()->organization_id)
                            ->whereMonth('transaction_date', '<>', substr($recMonth, 0, 2))
                            ->whereYear('transaction_date', '=', substr($recMonth, 3, 6))
                            ->select('id','description','account_credited','account_debited','transaction_amount')
                            ->get();

        $add = [];
        $less = [];
        foreach($additions as $additions){
            if($additions->account_debited == $bookAcID){
                array_push($add, $additions);
            } else if($additions->account_credited == $bookAcID){
                array_push($less, $additions);
            }
        }

        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.bankReconciliationReport', compact('recMonth','organization','bnkStmtBal','bkTotal','add','less'))->setPaper('a4')->setOrientation('potrait');
        return $pdf->stream('Reconciliation Reports');
        /*if(count($bnkStmtBal) == 0 || $bkTotal == 0 || count($additions) == 0 ){
            return "Error";
            //return View::make('erpreports.bankReconciliationReport')->with('error','Cannot generate report for this Reconciliation! Please check paremeters!');
        } else{
            return "Success";*/
            return View::make('erpreports.bankReconciliationReport', compact('recMonth','organization','bnkStmtBal','bkTotal','add','less'));
        //}
    }


    /**
     * SEND QUOTATION AS AN ATTACHMENT
     */
    public function sendMail_quotation(){

        $id = Input::get('order_id');
        $mail_to = Input::get('mail_to');
        $subject = Input::get('subject');
        $mail_body = Input::get('mail_body');

        $filePath = 'app/views/temp/';
        $fileName = 'Quotation.pdf';

        $orders = DB::table('erporders')
                ->join('erporderitems', 'erporders.id', '=', 'erporderitems.erporder_id')
                ->join('items', 'erporderitems.item_id', '=', 'items.id')
                ->join('clients', 'erporders.client_id', '=', 'clients.id')
                ->where('erporders.id','=',$id)
                ->select('clients.name as client','items.name as item','quantity','clients.address as address',
                  'clients.phone as phone','clients.email as email','erporders.id as id',
                  'discount_amount','erporders.order_number as order_number','price','description')
                ->first();

        $txorders = DB::table('tax_orders')
                ->join('erporders', 'tax_orders.order_number', '=', 'erporders.order_number')
                ->join('taxes', 'tax_orders.tax_id', '=', 'taxes.id')
                ->where('erporders.id','=',$id)
                ->get();

        $count = DB::table('tax_orders')->count();

        $erporder = Erporder::findorfail($id);


        $organization = Organization::find(1);

        $pdf = PDF::loadView('erpreports.quotation', compact('orders','erporder','txorders','count' ,'organization'))->setPaper('a4')->setOrientation('potrait');

        $attach = $pdf->save($filePath.$fileName);
        //unlink($filePath.$fileName);

        // SEND MAIL
        $from_name = 'Lixnet Technologies';
        $from_mail = Mailsender::username();
        $data = array('body'=>$mail_body, 'from'=>$from_name, 'subject'=>$subject);
        Mail::send('mails.mail_quotation', $data, function($message) use($subject, $mail_to, $from_name, $from_mail, $attach, $filePath, $fileName){
            $message->to($mail_to, '');
            $message->from($from_mail, $from_name);
            $message->subject($subject);
            $message->attach($filePath.$fileName);
        });

        unlink($filePath.$fileName);

        if(count(Mail::failures()) > 0){
            $fail = "Email not sent! Please try again later";
            return Redirect::back()->with('fail', $fail);
        } else{
            $success = "Email successfully sent";
            return Redirect::back()->with('success', $success);
        }


    }




}
