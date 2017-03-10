<p>
Hello {{$name}}, 
</p>

<p>You are notified to submit your loan repayment amount on {{$pay_date}}. </p>
<p>Please pay up and avoid the additional charges for late loan repayments.</p>
<br><br>
<p>Regards,</p>
<?php $orgname=Organization::where('id','=',Confide::User()->organization_id)->pluck('name'); ?>
<p>{{$orgname}}</p>