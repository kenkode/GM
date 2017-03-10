<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<p>User Registration for username <?php echo $name?> </p>

		<div>
			<table style="padding:1px; border:1px solid; font-size:14px; width:100%">
			<thead>
				<th style="padding:4px;  ">Company</th>
				<th style="padding:4px;  ">Person</th>
				<th style="padding:4px;  ">Phone</th>
				<th style="padding:4px;  ">Email</th>
			    <th style="padding:4px;  ">County</th>
				<th style="padding:4px;  ">Sales Agent</th>
			</thead>
			<tbody>
			<tr style="padding:4px; border:1px dotted ">
				 	<td style="padding:4px;  margin-left:7px;"> {{ strtolower(Organization::getOrg($user->organization_id)->name) }}</td>	
			
				  	<td style="padding:4px;  "> {{ strtolower($user->username)}}</td>
				  	<td style="padding:4px;  "> {{ Organization::getOrg($user->organization_id)->phone}}</td>	
			
				  	<td style="padding:4px;  "> {{ strtolower($user->email) }}</td>	
				  	<td style="padding:4px;  "> {{ strtolower(Organization::getOrg($user->organization_id)->county) }}</td>	
				    <td style="padding:4px;  "> {{ strtolower(Organization::getOrg($user->organization_id)->agent) }}</td>	
			</tr>
			
			</tbody>
			
			</table>
		</div>
	</body>
</html>