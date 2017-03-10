<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.payroll')
@section('content')

<div class="row">
  <div class="col-lg-12">
  <h3>Employee Allowance</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('employee_allowances/create')}}">new employee allowance</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Allowance Type</th>
        <th>Amount</th>
        <th>Action</th>

      </thead>

      <tfoot>

        <th>#</th>
        <th>Employee</th>
        <th>Allowance Type</th>
        <th>Amount</th>

      </tfoot>

      <tbody>

        <?php $i = 1; ?>
        @foreach($eallws as $eallw)

        <tr>

          <td> {{ $i }}</td>
           @if($eallw->middle_name == null || $eallw->middle_name == '')
          <td>{{ $eallw->first_name.' '.$eallw->last_name }}</td>
          @else
          <td>{{ $eallw->first_name.' '.$eallw->middle_name.' '.$eallw->last_name }}</td>
          @endif
          <td>{{ $eallw->allowance_name }}</td>
          <td align="right">{{ asMoney((double)$eallw->allowance_amount) }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('employee_allowances/view/'.$eallw->id)}}">View</a></li>
                    
                    <li><a href="{{URL::to('employee_allowances/edit/'.$eallw->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('employee_allowances/delete/'.$eallw->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s allowance?'))">Delete</a></li>
                    
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