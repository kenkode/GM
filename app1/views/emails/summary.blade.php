<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>User Registration Summary - <?php $date = date('d-M-Y'); echo $date; ?> </p>

		<div>
			<table style="padding:1px; border:1px solid; font-size:14px; width:100%">
			<thead>
				<th></th>
				<th style="padding:4px;  ">Company</th>
				<th style="padding:4px;  ">Person</th>
				<th style="padding:4px;  ">Phone</th>
				<th style="padding:4px;  ">Email</th>
			
				
			</thead>
			<tbody>
			<td> <?php $i=1; ?> </td> 
			@foreach($users as $user)
			<tr style="padding:1px; border:1px dotted ">
					<td > <?php echo $i; ?> </td> 
				 	<td style="padding:4px;  "> {{ strtolower(Organization::getName($user->organization_id)) }}</td>	
			
				  	<td style="padding:4px;  "> {{ strtolower($user->username)}}</td>
				  	<td style="padding:4px;  "> {{ $user->phone}}</td>	
			
				  	<td style="padding:4px;  "> {{ strtolower($user->email) }}</td>	
				     
			</tr>
			
			 <?php $i++; ?> 
			@endforeach
			</tbody>
			
			</table>
		</div>
	</body>
</html>