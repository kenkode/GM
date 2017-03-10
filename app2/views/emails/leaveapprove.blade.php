<p>
Hello {{$name}}, 
</p>

<p>Your Leave application has been approved: </p>
<br>

<table>

<thead style="background-color:gray; color:white;">
	<th colspan="2">Application Details</th>
</thead>
<tbody>
	<tr>
		<td>Leave Type</td><td>{{Leavetype::getName($application->leavetype_id)}}</td>
	</tr>
	<tr>
		<td>Application Date</td><td>{{$application->application_date}}</td>
	</tr>

	<tr>
		<td>Approved Start Date</td><td>{{$application->approved_start_date}}</td>
	</tr>


	<tr>
		<td>Approved End Date</td><td>{{$application->approved_end_date}}</td>
	</tr>


	<tr>
		<td>Approved Days</td><td>{{Leaveapplication::getLeaveDays($application->approved_start_date, $application->approved_end_date )}}</td>
	</tr>

</tbody>
	
</table>




<br><br>
<p>Regards,</p>
<?php $organization = Organization::find($application->organization_id);?>
<p>{{$organization->name}}</p>
