@extends('layouts.payroll')
@section('content')

<div class="row">
	
	<div class="col-lg-12">
		<hr>

	</div>
</div>


<div class="row">
	


	<div class="col-lg-12">


	<div class="panel panel-success">
      <div class="panel-heading">
          <h4>Employees</h4>
        </div>
        <div class="panel-body">

		  <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Personal File Number</th>
        <th>Employee Name</th>
        <th>Employee Branch</th>
        <th>Employee Department</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($employees as $employee)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $employee->personal_file_number }}</td>
          <td>{{ $employee->first_name.' '.$employee->last_name}}</td>
         <?php if( $employee->branch_id!=0){ ?>
          <td>{{ Branch::getName($employee->branch_id) }}</td>
          <?php }else{?>
          <td></td>
          <?php } ?>
           <?php if( $employee->department_id!= 0){ ?>
          <td>{{ Department::getName($employee->department_id) }}</td>
          <?php }else{?>
          <td></td>
          <?php } ?>

          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">

                    <li><a href="{{URL::to('employees/view/'.$employee->id)}}">View</a></li>

                    <li><a href="{{URL::to('employees/edit/'.$employee->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('employees/deactivate/'.$employee->id)}}" onclick="return (confirm('Are you sure you want to deactivate this employee?'))">Deactivate</a></li>
                    
                  </ul>
              </div>

                    </td>

        </tr>

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
</div>
</div>

	</div>	


<div class="row">

	<div class="col-lg-12">
		<hr>
	</div>	

	

	
</div>
@stop