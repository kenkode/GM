<p>
Hello {{$name}}, 
</p>
@if($type == 'Applied')
<p>Below are the applied leaves As At Date for this month</p>
@elseif($type == 'Approved')
<p>Below are the approved leaves As At Date for this month</p>
@elseif($type == 'rejected')
<p>Below are the rejected leaves As At Date for this month</p>
@elseif($type == 'employee')
<p>Below are the employees on leave As At Date for this month</p>
@elseif($type == 'balances')
<p>Below are the employee leave balances As At Date for this month</p>
@elseif($type == 'individual')
<p>Below are the individual employees` leave report As At Date for this month</p>
@endif

<br><br>
<p>Regards,</p>
<?php $orgname=Organization::where('id','=',1)->pluck('name'); ?>
<p>{{$orgname}}</p>