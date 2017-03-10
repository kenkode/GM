<p>
Hello, 
</p>

<p>{{$orgname}} is requesting for a license upgrade. </p>
<p>The following are the details: </p>

@if($payroll == 1)
<p><input type="checkbox" checked>Payroll</p>
<p>Number of employees - {{$employees}}</p>
@endif

@if($erp == 1)
<br>
<p><input type="checkbox" checked>Financials</p>
<p>Number of clients - {{$clients}}</p>
<p>Number of items - {{$items}}</p>
@endif 

@if($cbs == 1)
<br>
<p><input type="checkbox" checked>CBS </p>
<p>Number of members - {{$members}}</p>
@endif
<br><br>
<p>Client details: </p>
<br>
<p><strong>Name:</strong>{{$orgname}}</p>
<p><strong>Email:</strong>{{$orgmail}}</p>
<p><strong>Phone:</strong>{{$orgphone}}</p>
<p>Regards,</p>
<p>Lixnet Technologies</p>