@extends('layouts.main')
<style type="text/css"></style>
@section('content')

<div class="row" >
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row" >
  


  <div class="col-lg-12" >

@if (Session::has('flash_message'))

      <div class="alert alert-success">
      {{ Session::get('flash_message') }}
     </div>
    @endif

     @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif

   <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('employees/create')}}">new employee</a>
        </div>
        <div class="panel-body">

      <table id="users" class="table table-condensed table-bordered table-responsive table-hover" style="font-size:12px">


      <thead>

        <th>#</th>
        <th style="font-size:11px;">PFN</th>
        <th style="font-size:11px;">Employee Name</th>
        <th style="font-size:11px;">ID</th>
        <th style="font-size:11px;">KRA PIN</th>
        <th style="font-size:11px;">NSSF NO.</th>
        <th style="font-size:11px;">NHIF NO.</th>
        <th style="font-size:11px;">Branch</th>
        <th style="font-size:11px;">Department</th>

        <th style="font-size:11px;">Action</th>

      </thead>

      <tfoot>

        <th>#</th>
        <th>PFN</th>
        <th>Employee Name</th>
        <th>ID</th>
        <th>Kra Pin</th>
        <th>Nssf NO.</th>
        <th>Nhif NO.</th>
        <th>Branch</th>
        <th>Department</th>

      </tfoot>

      <tbody>

        <?php $i = 1; ?>
        @foreach($employees as $employee)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $employee->personal_file_number }}</td>
          @if($employee->middle_name == null || $employee->middle_name == '')
          <td width="150">{{ $employee->first_name.' '.$employee->last_name}}</td>
          @else
          <td width="150">{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>
          @endif
          <td>{{ $employee->identity_number }}</td>
          <td>{{ $employee->pin }}</td>
          <td>{{ $employee->social_security_number }}</td>
          <td>{{ $employee->hospital_insurance_number }}</td>
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
