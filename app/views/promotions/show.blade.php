@extends('layouts.main')
@section('content')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<div class="row">
	<div class="col-lg-12">


<a class="btn btn-info btn-sm "  href="{{ URL::to('promotions/edit/'.$promotion->id)}}">update details</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-3">

<img src="{{asset('/public/uploads/employees/photo/'.Promotion::getImage($promotion->employee_id)->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.Promotion::getImage($promotion->employee_id)->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">{{$promotion->type }} Information</span></strong></td></tr>
      <tr><td><strong>Employee: </strong></td><td> {{ Promotion::getEmployee($promotion->employee_id) }}</td>
      </tr>
      <tr><td><strong>Reason: </strong></td><td>{{ $promotion->reason }}</td></tr>
      <tr><td><strong>Type: </strong></td><td>{{ $promotion->type }}</td></tr>
      <tr><td><strong>Date: </strong></td><td>{{ $promotion->promotion_date }}</td></tr>
</table>
</div>

</div>


	</div>


</div>


@stop