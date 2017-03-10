<p>
Hello {{$name}}, 
</p>

<p>Below is your self service login password: </p>
<p><strong>{{$password}}</strong></p>
<br>
<p>Use your Payroll number as your username</p>
<br><br>
<p>Regards,</p>
<?php $organization = Organization::find(Confide::user()->organization_id);?>
<p>{{$organization->name}}</p>