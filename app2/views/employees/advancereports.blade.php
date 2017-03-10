@extends('layouts.adv_ports')
@section('content')


<div class="row">
    <div class="col-lg-12">
  <h3>Advance Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

    <ul>

       <li>
          <a href="{{ URL::to('advanceReports/selectSummaryPeriod') }}">Advance Summary</a>
       </li>

       <li>
          <a href="{{ URL::to('advanceReports/selectRemittancePeriod') }}">Advance Remittance</a>
       </li>
    
       <li>
        <a href="reports/blank" target="_blank">Blank report template</a>
      </li>
    </ul>

  </div>

</div>

@stop