@extends('layouts.portspay')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Payroll Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

    <ul>

       <li>
            <a href="{{ URL::to('payrollReports/selectPeriod') }}"> Monthly Payslips</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectSummaryPeriod') }}">Payroll Summary</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectRemittancePeriod') }}">Pay Remittance</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectEarning') }}"> Earning Report</a>
       </li> 

       <li>
          <a href="{{ URL::to('payrollReports/selectOvertime') }}"> Overtime Report</a>
       </li> 
    
       <li>
          <a href="{{ URL::to('payrollReports/selectAllowance') }}"> Allowance Report</a>
       </li>  

       <li>
          <a href="{{ URL::to('payrollReports/selectnontaxableincome') }}" >Non Taxable Income Report</a>
       </li> 

       <li>
          <a href="{{ URL::to('payrollReports/selectRelief') }}"> Relief Report</a>
       </li>  

       <li>
         <a href="{{ URL::to('payrollReports/selectDeduction') }}"> Deduction Report</a>     
       </li>  
    </ul>

  </div>

</div>

@stop