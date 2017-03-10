@extends('layouts.membercss')

@section('content')
<div class="row">
	<div class="col-lg-12">
 

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

	<table class="table table-responsive table-bordered table-condensed">
   
   <tr>
   <td><strong>Employee</strong></td><td>{{$leaveapplication->employee->first_name.' '.$leaveapplication->employee->last_name.' '.$leaveapplication->employee->middle_name}}</td>
     
   </tr> 

   <tr>
   <td><strong>Leave Type</strong></td><td>{{$leaveapplication->leavetype->name}}</td>
     
   </tr> 

   <tr>
   <td><strong>Application Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->application_date))}}</td>
     
   </tr> 


    <tr>
   <td><strong>Applied Start Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->applied_start_date))}}</td>
     
   </tr>

    <tr>
   <td><strong>Applied End Date</strong></td><td>{{date('d-M-Y', strtotime($leaveapplication->applied_end_date))}}</td>
     
   </tr>
   
    <tr>
   <td><strong>Leave Days</strong></td><td>{{Leaveapplication::getDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date,$leaveapplication->is_weekend,$leaveapplication->is_holiday)+1}}</td>
                
     
   </tr>
   

  </table>


       
        
        <div class="form-actions form-group" align="right">

          <a class="btn btn-primary btn-sm btn-info" href="{{URL::to('supervisorapproval/'.$leaveapplication->id)}}" onclick="return (confirm('Are you sure you want to approve this application?'))">Approve</a> <a class="btn btn-primary btn-sm btn-danger" href="{{URL::to('supervisorreject/'.$leaveapplication->id)}}" onclick="return (confirm('Are you sure you want to reject this application?'))">Reject</a>
        
          
        </div>
    
		

  </div>

</div>
@stop


