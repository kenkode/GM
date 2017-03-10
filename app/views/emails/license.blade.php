<p>
Hello {{$name}}, 
</p>

<p>Your details for license upgrades have been sent to lixnet.net and will soon get an email confirmation from us. </p>
<p>This is your license details: </p>
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
<p><input type="checkbox" checked>CBS</p>
<p>Number of members - {{$members}}</p>
@endif
<br><br>
<p>Regards,</p>
<p>Lixnet Technologies</p>