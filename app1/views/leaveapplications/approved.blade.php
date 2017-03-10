@extends('layouts.leave')
@section('content')

<div class="row">
											
											
											
        						

	<div class="col-lg-12">
	<br>

    <div class="panel panel-default">
      <div class="panel-heading">
          Approved Leaves
        </div>
        <div class="panel-body">

	<table id="mobile" class="table table-condensed table-bordered table-responsive">

  <thead>
    
    <th style="font-size:10px;">PFN</th>
    <th style="font-size:10px;">Employee</th>
    <th style="font-size:10px;">Leave Type</th>
    <th style="font-size:10px;">Approval Date</th>
    <th style="font-size:10px;">Start Date</th>
    <th style="font-size:10px;">End Date</th>
    <th style="font-size:10px;">Leave Days</th>
    <th></th>


  </thead>

  <tfoot>
    
    <th>PFN</th>
    <th>Employee</th>
    <th>Leave Type</th>
    <th>Approval Date</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Leave Days</th>

  </tfoot>

  <tbody>

   

        @foreach($leaveapplications as $leaveapplication)
        @if($leaveapplication->status == 'approved')
         <tr>

          <td>{{$leaveapplication->employee->personal_file_number}}</td>
          <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->middle_name." ".$leaveapplication->employee->last_name}}</td>
          <td>{{$leaveapplication->leavetype->name}}</td>
          <td>{{$leaveapplication->date_approved}}</td>
           <td>{{$leaveapplication->approved_start_date}}</td>
            <td>{{$leaveapplication->approved_end_date}}</td>
            <td>{{Leaveapplication::getDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date,$leaveapplication->is_weekend,$leaveapplication->is_holiday)+1}}</td>


          <td>
           <a href="{{URL::to('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a> &nbsp; |
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