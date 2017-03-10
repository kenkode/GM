<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Company Properties</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('Properties/create')}}">new property</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Name</th>
         <th>Amount</th>
         
        <th></th>

      </thead>

      <tfoot>

        <th>#</th>
        <th>Employee</th>
        <th>Name</th>
         <th>Amount</th>

      </tfoot>
      <tbody>

        <?php $i = 1; ?>
        @foreach($properties as $property)

        <tr>

          <td> {{ $i }}</td>
          @if($property->middle_name == null || $property->middle_name == '')
          <td>{{ $property->first_name.' '.$property->last_name }}</td>
          @else
          <td>{{ $property->first_name.' '.$property->middle_name.' '.$property->last_name }}</td>
          @endif
          <td>{{ $property->name }}</td>
          <td align="right">{{ asMoney((double)$property->monetary) }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('Properties/view/'.$property->id)}}">View</a></li> 
                    
                    <li><a href="{{URL::to('Properties/edit/'.$property->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('Properties/delete/'.$property->id)}}" onclick="return (confirm('Are you sure you want to delete this property?'))">Delete</a></li>
                    
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


       
