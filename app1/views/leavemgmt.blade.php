@extends('layouts.leave')
@section('content')

<div class="row">
											
											
											
        		@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif				

	<div class="col-lg-12">
	<br>

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('leaveapplications/create')}}">new application</a>
        </div>
        <div class="panel-body">

	<table id="mobile" class="table table-condensed table-bordered table-responsive" style="margin-left:-12px">

  <thead>
    
    <th style="font-size:10px;">PFN</th>
    <th style="font-size:10px;">Employee</th>
    <th style="font-size:10px;">Vacation Type</th>
    <th style="font-size:10px;">Application Date</th>
    <th style="font-size:10px;">Start Date</th>
    <th style="font-size:10px;">End Date</th>
    <th style="font-size:10px;">Vacation Days</th>
    <th style="font-size:10px;">Balance Days</th>
    <th></th>


  </thead>

  <tfoot>
    
    <th>PFN</th>
    <th>Employee</th>
    <th>Vacation Type</th>
    <th>Application Date</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Vacation Days</th>
    <th>Balance Days</th>


  </tfoot>

  <tbody>

   

        @foreach($leaveapplications as $leaveapplication)
        @if($leaveapplication->status == 'applied')
         <tr>

          <td>{{$leaveapplication->employee->personal_file_number}}</td>
          <td width="150">{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->last_name." ".$leaveapplication->employee->middle_name}}</td>
          <td>{{$leaveapplication->leavetype->name}}</td>
          <td>{{$leaveapplication->application_date}}</td>
           <td>{{$leaveapplication->applied_start_date}}</td>
            <td>{{$leaveapplication->applied_end_date}}</td>
            <td>{{Leaveapplication::getDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date,$leaveapplication->is_weekend,$leaveapplication->is_holiday)+1}}</td>

<td>{{Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype,$leaveapplication)}}</td>
          <td>
           <a href="{{URL::to('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a> &nbsp; |
           @if(Leaveapplication::getBalanceDays($leaveapplication->employee, $leaveapplication->leavetype,$leaveapplication) >= Leaveapplication::getLeaveDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date))
          <a href="{{URL::to('leaveapplications/approve/'.$leaveapplication->id)}}">Approve</a> &nbsp;
          @endif
          |&nbsp;<a href="{{URL::to('leaveapplications/reject/'.$leaveapplication->id)}}">Reject</a> &nbsp;|
          <a href="{{URL::to('leaveapplications/cancel/'.$leaveapplication->id)}}">Cancel</a>
          </td>

           </tr>
           @endif
        @endforeach
      

   
    

  </tbody>

        
  </table>
           
      
        </div>
		<hr>

	</div>
</div>

@stop