@extends('layouts.main')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('compliance/edit/'.$discipline->id)}}">update compliance</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-3">

<img src="{{asset('/public/uploads/employees/photo/'.Discipline::getImage($discipline->employee_id)->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.Discipline::getImage($discipline->employee_id)->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">{{$discipline->type }} Information</span></strong></td></tr>
      <tr><td><strong>Employee: </strong></td><td> {{ Discipline::getEmployee($discipline->employee_id) }}</td>
      </tr>
      <tr><td><strong>Reason: </strong></td><td>{{ $discipline->reason }}</td></tr>
      <tr><td><strong>Action Taken: </strong></td><td>{{ $discipline->action }}</td></tr>
      @if($discipline->action == 'Suspension')
      <tr><td><strong>Days: </strong></td><td>{{ $discipline->days }}</td></tr>
      @endif
      <tr><td><strong>Date: </strong></td><td>{{ $discipline->discipline_date }}</td></tr>
</table>
</div>

</div>


	</div>


</div>


@stop