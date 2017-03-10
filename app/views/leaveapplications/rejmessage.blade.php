@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>EMPLOYEE VACATION STATUS</h3>

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

        <p><strong><h1 style='color:green'>Vacation Application Rejected!</h1></strong></p>
        
  </div>

</div>
























@stop