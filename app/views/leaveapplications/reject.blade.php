@extends('layouts.leave')
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
   <td><strong>Employee</strong></td><td>{{$leaveapplication->employee->first_name.' '.$leaveapplication->employee->middle_name.' '.$leaveapplication->employee->last_name}}</td>
     
   </tr> 

   <tr>
   <td><strong>Vacation Type</strong></td><td>{{$leaveapplication->leavetype->name}}</td>
     
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


   

  </table>




  <form method="POST" action="{{{ URL::to('leaveapplications/reject/'.$leaveapplication->id) }}}" accept-charset="UTF-8">
   
    <fieldset>

        
        <div class="form-group">
                        <label for="username">Reason <span style="color:red">*</span></label>
                        <textarea required class="form-control" name="reason"></textarea>
                    
       </div>
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Reject</button>
        </div>

    </fieldset>
</form>
    
		

  </div>

</div>
@stop


