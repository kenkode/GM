@extends('layouts.system')
@section('content')
<br/><br/><br/><br/>

<div class="row">

	<div class="col-lg-12">

		<div class="panel panel-default">
			<div class="panel-heading">
    			<a class="btn btn-info btn-sm" href="{{ URL::to('tasks/create')}}">new automated report</a>
  			</div>
  			<div class="panel-body">

				<table id="users" class="display compact table table-bordered table-striped" cellspacing="0" width="100%">
					<thead>
						
						
						<th>Group</th>
						<th>Report</th>
						<th>Day of Week</th>
						<th>Month </th>
					
						<th>Hour</th>
						<th>Minute</th>
						<th></th>
						
					</thead>
					<tbody>
              			 @foreach($tasks as $task)
              			 <tr>
               			
               			<td>{{ $task->group }}</td>
               			<td>{{ $task->report }}</td>
               			<td>{{ $task->day_of_week }}</td>
               			<td>{{ $task->month_of_year }}</td>
               		
               			<td>{{ $task->hour }}</td>
               			<td>{{ $task->minute }}</td>
               			
               			
               			<td>

               				<div class="btn-group">
  								<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
    								Action <span class="caret"></span>
  								</button>
  				
  								<ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('roles/show/'.$task->id)}}">View</a></li>
    								<li><a href="#">Edit</a></li>

    								
    								<li><a href="{{URL::to('tasks/destroy/'.$task->id)}}">Delete</a></li>
  								</ul>
							</div>

               			</td>
               		</tr>
               			@endforeach

 
					</tbody>
				</table>
			</div>	
		</div>	
	</div>	



</div>


@stop