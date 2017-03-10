
<p> Hello {{$name}}! </p>
<p> Member {{$guarantor}} has approved your loan for Ksh. {{$amount_applied}} for loan product {{$pname}} and has agreed to be your guarantor.</p>
<p> Please wait for final approval from the managements of the sacco so as to get the loan.</p>
<br><br>
<p>Regards,</p>
<?php $organization = Organization::find(Confide::user()->organization_id);?>
<p>{{$organization->name}}</p>