@extends('layouts.emp_ports')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Select Employee</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form target="_blank" method="POST" action="{{URL::to('reports/employee')}}" accept-charset="UTF-8">
   
    <fieldset>
            <div class="form-group">
                        <label for="username">Select:</label>
                        <select name="employeeid" class="form-control" required>
                            <option></option>
                            @foreach($employees as $employee)
                            @if($employee->middle_name != null || $employee->middle_name != '')
                            <option value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                            @else
                            <option value="{{$employee->id }}"> {{ $employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name }}</option>
                            @endif
                            @endforeach

                        </select>
                
        </div>

        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Select Employee</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop