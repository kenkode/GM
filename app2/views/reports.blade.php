@extends('layouts.empports')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3> Reports</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

	<div role="tabpanel">

	<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#hrrep" aria-controls="hrrep" role="tab" data-toggle="tab">HR Reports</a></li>
    <li role="presentation"><a href="#leave" aria-controls="leave" role="tab" data-toggle="tab">Leave Reports</a></li>
    <li role="presentation"><a href="#advance" aria-controls="advance" role="tab" data-toggle="tab">Salary Advance Reports</a></li>
    <li role="presentation"><a href="#payroll" aria-controls="payroll" role="tab" data-toggle="tab">Payroll Reports</a></li>
    <li role="presentation"><a href="#statutory" aria-controls="statutory" role="tab" data-toggle="tab">Statutory Reports</a></li>
    
  </ul>

		<div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="hrrep">

      <br>

    <ul>

       <li>

        <a href="{{ URL::to('employee/select') }}"> Individual Employee report</a>

      </li>

      <li>

        <a href="{{ URL::to('reports/selectEmployeeStatus') }}"> Employee List report</a>

      </li>

      <li>
            <a href="{{ URL::to('reports/nextofkin/selectEmployee') }}" >Next of Kin Report</a>
        </li>

       <li>
            <a href="{{ URL::to('reports/selectEmployeeOccurence') }}" >Employee Occurence report </a>
        </li>

        <li>
            <a href="{{ URL::to('reports/CompanyProperty/selectPeriod') }}" >Company Property report </a>
        </li>

         <li>
            <a href="{{ URL::to('reports/Appraisals/selectPeriod') }}" >Appraisal report </a>
        </li>



    </ul>

</div>

    <div role="tabpanel" class="tab-pane" id="leave">
      <br>

    <ul>

    <li>
            <a href="{{ URL::to('leaveReports/selectApplicationPeriod') }}"> Leave Application</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectApprovedPeriod') }}">Leaves Approved</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectRejectedPeriod') }}">Leaves Rejected</a>
       </li>

       <li>
          <a href="{{ URL::to('leaveReports/selectLeave') }}">Leaves Balances</a>
       </li>
    
       <li>
          <a href="{{ URL::to('leaveReports/selectLeaveType') }}"> Employees on Leave</a>
       </li>  

       <li>
         <a href="{{ URL::to('leaveReports/selectEmployee') }}"> Individual Employee </a>     
       </li>  
     </ul>

     </div>

     <div role="tabpanel" class="tab-pane" id="advance">
     <br>
      <ul>

       <li>
          <a href="{{ URL::to('advanceReports/selectSummaryPeriod') }}">Advance Summary</a>
       </li>

       <li>
          <a href="{{ URL::to('advanceReports/selectRemittancePeriod') }}">Advance Remittance</a>
       </li>
    
    </ul>

    </div>

     <div role="tabpanel" class="tab-pane" id="payroll">
     <br>
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
    <div role="tabpanel" class="tab-pane" id="statutory">
    <br>
    <ul>

       <li>
            <a href="{{ URL::to('payrollReports/selectNssfPeriod') }}"> NSSF Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectNhifPeriod') }}">NHIF Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectPayePeriod') }}">PAYE Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('itax/download') }}">Download Itax Template</a>
       </li>

    </ul>

  </div>

</div>

</div>

</div>

</div>

@stop