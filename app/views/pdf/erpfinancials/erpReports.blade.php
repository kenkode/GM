@extends('layouts.erp_ports')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Erp Reports</h3>

<hr>
</div>  
</div>

<div class="row">
    <div class="col-lg-12">

    <ul>
      <li>
            <a href="{{ URL::to('pdf/erpfinancials/selectSalesPeriod') }}">Sales</a>
       </li>

       <li>
            <a href="{{ URL::to('pdf/erpfinancials/sales_summary') }}" target="_blank">Sales Summary</a>
       </li> 

       <li>
            <a href="{{ URL::to('pdf/erpfinancials/selectPurchasesPeriod') }}">Purchases</a>
       </li>

       <li>
            <a href="{{ URL::to('pdf/erpfinancials/selectClientsPeriod') }}">Clients</a>
       </li>

       <li>
          <a href="{{ URL::to('pdf/erpfinancials/selectItemsPeriod') }}">Items</a>
       </li>

       <li>
          <a href="{{ URL::to('pdf/erpfinancials/selectExpensesPeriod') }}">Expenses</a>
       </li>
    
       <li>
          <a href="{{ URL::to('pdf/erpfinancials/paymentmethods') }}" target="_blank">Payment Methods</a>
       </li>  

       <li>
         <a href="{{ URL::to('pdf/erpfinancials/selectPaymentsPeriod') }}">Payments</a>     
       </li>

        <li>
         <a href="{{ URL::to('pdf/erpfinancials/locations') }}" target="_blank">Stores</a>     
       </li> 

        <li>
         <a href="{{ URL::to('pdf/erpfinancials/stocks') }}" target="_blank">Stock report </a>      
       </li>

        <li>
         <a href="{{ URL::to('pdf/erpfinancials/pricelist') }}" target="_blank">Price List </a>     
       </li>

        <li>
         <a href="{{ URL::to('pdf/erpfinancials/accounts') }}" target="_blank">Account Balances </a>     
       </li> 

      <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop