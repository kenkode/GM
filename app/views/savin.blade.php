@extends('layouts.system')
@section('content')

<div class="row">
	<div class="col-lg-1">



</div>	

<div class="col-lg-12">

	@if (Session::get('error'))
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif

<p>Bulk Process Savings</p>
<hr>

<br>
</div>	


<div class="col-lg-12 ">

	
<form method="POST" action="{{{ URL::to('automated/savins') }}}"  enctype="multipart/form-data">
 
 <input type="hidden" name="period" value="{{$period}}">
 <input type="hidden" name="savingproduct_id" value="{{$savingproductid}}">
		
        <table class="table table-bordered table-condensed table-hover" id="auto">

            <thead>
                <th>Member</th>
                <th>Period</th>
                <th>Amount</th>
            </thead>

            <tbody>

            @foreach($members as $member)
                <tr>

                    <td>{{$member->name}}
                        <input type="hidden" name="member[]" value="{{$member->id}}">

                    </td>
                    <td>
                        {{$date}}
                        <input type="hidden" name="date[]" value="{{$date}}">
                    </td>
                    <td>
                        <input type="text" name="amount[]" value="{{Savingaccount::getPeriodAmount($member)}}">
                    </td>

                </tr>
            @endforeach

        </tbody>

        </table>
        
        

        <hr>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm pull-right">Process Savings</button>
        </div>


</form>	

</div>	



</div>






@stop