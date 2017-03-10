@extends('layouts.main5')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>EMPLOYEE LEAVE STATUS</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-9">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

        @if($status == 'approve')
        <p><strong><h1 style='color:green'>Leave Successfully Approved!</h1></strong></p>
		    @elseif($status == 'reject')
        <p><strong><h1 style='color:green'>Leave Successfully Rejected!</h1></strong></p>
        @elseif($status == 'checkreject')
        <p><strong><h1 style='color:green'>You have already Rejected Leave!</h1></strong></p>
        @elseif($status == 'checkapprove')
        <p><strong><h1 style='color:green'>You have already Approved Leave!</h1></strong></p>
        @endif
  </div>

</div>
























@stop