<p>
Hello, 
</p>

<p>A vacation roster has been created as per below: </p>
<br>


<table>

         
          <thead style="background-color:gray; color:white;">
            <th>#</th>
            <th>Vacation Type</th>
            <th>Application Date</th>
            <th>Applied Start Date</th>
            <th>Applied End Date</th>
            <th>Vacation Days</th>
            <th>Status</th>
          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($leaveapplications as $application)
            <tr>
                <td>{{$i}}</td>
                <td>{{Leavetype::getName($application->leavetype_id)}}</td>
                <td>{{date('d-M-Y', strtotime($application->application_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_start_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_end_date))}}</td>
                <td>{{Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
                <td>{{$application->status}}</td>
              
            </tr>
            <?php $i++; ?>
            @endforeach
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
