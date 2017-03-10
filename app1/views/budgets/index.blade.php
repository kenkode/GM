@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Budgets</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('budgets/create')}}">new budget</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Budget Type</th>
        <th>Estimated Budget Amount</th>
        <th>Period</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($budgets as $budget)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $budget->expensesetting->name }}</td>
          <td>{{ $budget->amount }}</td>
          <td>{{ $budget->financial_month.'-'.$budget->financial_year }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('budgets/edit/'.$budget->id)}}">Update</a></li>
                   
                    <!-- <li><a href="{{URL::to('budgets/delete/'.$budget->id)}}" onclick="return (confirm('Are you sure you want to delete this bank?'))">Delete</a></li> -->
                    
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