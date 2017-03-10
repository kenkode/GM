@extends('layouts.main')
@section('content')

<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>
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


<a class="btn btn-info btn-sm "  href="{{ URL::to('NextOfKins/edit/'.$kin->id)}}">update details</a>
<a class="btn btn-danger btn-sm "  href="{{URL::to('NextOfKins/delete/'.$kin->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s kin?'))">Delete</a>
<a class="btn btn-success btn-sm "  href="{{ URL::to('employees/view/'.$kin->employee->id)}}">Go Back</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-2">

<img src="{{asset('/public/uploads/employees/photo/'.$kin->employee->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$kin->employee->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Next Of Kin Information</span></strong></td></tr>
      @if($kin->employee->middle_name != null || $kin->employee->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$kin->employee->last_name.' '.$kin->employee->first_name.' '.$kin->employee->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$kin->employee->last_name.' '.$kin->employee->first_name}}</td>
      @endif
      </tr>
      @if($kin->middle_name == '')
          <td><strong>Kin Name</strong></td><td>{{ $kin->first_name.' '.$kin->last_name }}</td>
          @else
          <td><strong>Kin Name</strong></td><td>{{ $kin->first_name.' '.$kin->middle_name.' '.$kin->last_name }}</td>
          @endif
      <tr><td><strong>Relationship: </strong></td><td>{{$kin->relationship}}</td></tr>
      <tr><td><strong>Contact Info: </strong></td><td><pre style="background:none;border:0;margin-left:-9px;margin-top:-6px;font-family:Sans-serif;font-size:14px;">{{$kin->contact}}</pre></td></tr>
      <tr><td><strong>Kin ID Number: </strong></td><td>{{$kin->id_number}}</td></tr>
</table>
</div>

</div>


	</div>


</div>


@stop