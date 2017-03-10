@extends('layouts.leave_ports')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Leave Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

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

       <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop