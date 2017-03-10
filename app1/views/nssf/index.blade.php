<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.earning')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Nssf Rates</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

     @if (Session::has('flash_message'))

      <div class="alert alert-success">
      {{ Session::get('flash_message') }}
     </div>
    @endif

     @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('nssf/create')}}">new nssf rate</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Tier</th>
        <th>Income From</th>
        <th>Income To</th>
        <th>Employee Amount</th>
        <th>Employer Amount</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($nrates as $nrate)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $nrate->tier }}</td>
          <td>{{ asMoney((double)$nrate->income_from) }}</td>
          <td>{{ asMoney((double)$nrate->income_to) }}</td>
          <td>{{ asMoney((double)$nrate->ss_amount_employee) }}</td>
          <td>{{ asMoney((double)$nrate->ss_amount_employer) }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('nssf/edit/'.$nrate->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('nssf/delete/'.$nrate->id)}}" onclick="return (confirm('Are you sure you want to delete this nssf rate?'))">Delete</a></li>
                    
                  </ul>
              </div>

                    </td>



        </tr>

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>

@stop