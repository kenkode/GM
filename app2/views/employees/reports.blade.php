@extends('layouts.ports')
@section('content')


<div class="row">
    <div class="col-lg-12">
  <h3>HR Reports</h3>

<hr>
</div>  
</div>


<div class="row">
    <div class="col-lg-12">

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


      <li>

        <a href="reports/blank" target="_blank">Blank report template</a>

      </li>



    </ul>

  </div>

</div>

@stop