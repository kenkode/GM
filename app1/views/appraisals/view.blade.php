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


<a class="btn btn-info btn-sm "  href="{{ URL::to('Appraisals/edit/'.$appraisal->id)}}">update details</a>

<a class="btn btn-danger btn-sm "  href="{{URL::to('Appraisals/delete/'.$appraisal->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s appraisal?'))">Delete</a>

<a class="btn btn-success btn-sm "  href="{{ URL::to('Appraisals')}}">Go Back</a>

<hr>
</div>	
</div>


<div class="row">

<div class="col-lg-2">


<img src="{{asset('/public/uploads/employees/photo/'.$appraisal->employee->photo) }}" width="150px" height="130px" alt=""><br>
<br>
<img src="{{asset('/public/uploads/employees/signature/'.$appraisal->employee->signature) }}" width="120px" height="50px" alt="">
</div>

<div class="col-lg-6">

<table class="table table-bordered table-hover">
<tr><td colspan="2"><strong><span style="color:green">Appraisal Information</span></strong></td></tr>
      @if($appraisal->employee->middle_name != null || $appraisal->employee->middle_name != ' ')
      <tr><td><strong>Employee: </strong></td><td> {{$appraisal->employee->last_name.' '.$appraisal->employee->first_name.' '.$appraisal->employee->middle_name}}</td>
      @else
      <td><strong>Employee: </strong></td><td> {{$appraisal->employee->last_name.' '.$appraisal->employee->first_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Question: </strong></td><td>{{Appraisalquestion::getQuestion($appraisal->appraisalquestion_id)}}</td></tr>
      <tr><td><strong>Performance: </strong></td><td>{{$appraisal->performance}}</td></tr>
      <tr><td><strong>Score: </strong></td><td>{{$appraisal->rate.' / '.Appraisalquestion::getScore($appraisal->appraisalquestion_id)}}</td></tr>
      <tr><td><strong>Examiner: </strong></td><td>{{$user->username}}</td></tr>
       <?php
       $d=strtotime($appraisal->appraisaldate);
       ?>

      <tr><td><strong>Date: </strong></td><td>{{ date("F j, Y", $d)}}</td></tr>
      <tr><td><strong>Comment: </strong></td><td>{{$appraisal->comment}}</td></tr>
</table>
</div>

</div>


	</div>


</div>


@stop