<p>
Hello, 
</p>

<p>A vacation has been applied as per below: </p>
<br>

<table>

<thead style="background-color:gray; color:white;">
	<th colspan="2">Application Details</th>
</thead>
<tbody>
	<tr>
		<td>Employee</td><td>{{$name}}</td>
	</tr>
	<tr>
		<td>Vacation Type</td><td>{{Leavetype::getName($application->leavetype_id)}}</td>
	</tr>
	<tr>
		<td>Application Date</td><td>{{$application->application_date}}</td>
	</tr>

	<tr>
		<td>Applied Start Date</td><td>{{$application->applied_start_date}}</td>
	</tr>


	<tr>
		<td>Applied End Date</td><td>{{$application->applied_end_date}}</td>
	</tr>


	<tr>
		<td>Days</td><td>{{Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
     </tr>

</tbody>
	
</table>

<br><br>
<!-- <p>Please click here to approve vacation<a href="{{{ URL::to('employeeleaveapplication/approve/'.$application->id.'/'.$application->applied_start_date.'/'.$application->applied_end_date) }}}">Approve Leave</a>&emsp|&emsp<a href="{{{ URL::to('employeeleaveapplication/approve/'.$application->id.'/'.$application->applied_start_date.'/'.$application->applied_end_date) }}}">Reject Leave</a></p>
 -->
 <p>Please click here to approve leave <a href="{{{ URL::to('supervisor/approve/'.$application->id) }}}">Approve Vacation</a>&emsp;|&emsp;<a href="{{{ URL::to('supervisor/reject/'.$application->id) }}}">Reject Vacation</a></p>
 

<br><br>
<p>Regards,</p>
<?php $organization = Organization::find(Confide::user()->organization_id);?>
<p>{{$organization->name}}</p>
