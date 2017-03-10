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
            <a href="{{ URL::to('erpReports/selectSalesPeriod') }}">Sales</a>
       </li>

       <li>
            <a href="{{ URL::to('erpReports/selectSalesPeriod') }}">Sales Summary</a>
       </li> 

       <li>
            <a href="{{ URL::to('erpReports/selectPurchasesPeriod') }}">Purchases</a>
       </li>

       <li>
            <a href="{{ URL::to('erpReports/selectClientsPeriod') }}">Clients</a>
       </li>

       <li>
          <a href="{{ URL::to('erpReports/selectItemsPeriod') }}">Items</a>
       </li>

       <li>
          <a href="{{ URL::to('erpReports/selectExpensesPeriod') }}">Expenses</a>
       </li>
    
       <li>
          <a href="{{ URL::to('erpReports/paymentmethods') }}" target="_blank">Payment Methods</a>
       </li>  

       <li>
          <a href="{{ URL::to('erpReports/selectPaymentsPeriod') }}"> Payments</a>
        </li>

        <li>
         <a href="{{ URL::to('erpReports/locations') }}" target="_blank">Stores</a>     
       </li> 

        <li>
         <a href="{{ URL::to('erpReports/selectStockPeriod') }}">Stock report </a>     
       </li>

        <li>
         <a href="{{ URL::to('erpReports/pricelist') }}" target="_blank">Price List </a>     
       </li>

        <li>
         <a href="{{ URL::to('erpReports/accounts') }}" target="_blank">Account Balances </a>     
       </li> 

      <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop