@extends('layouts.stat_ports')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Statutory Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

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

       <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop