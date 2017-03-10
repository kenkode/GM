@extends('layouts.css')
@section('content')
<br/>

<div class="row">
	<div class="col-lg-12">
  <h3>Employees Portal</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    @if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif

    <div class="panel panel-default">
      <div class="panel-heading">
          <p>Active Employees</p>
        </div>
        <div class="panel-body">


  
      <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee Number</th>
        <th>Employee Name</th>
      

        <th></th>
        

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($employees as $employee)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $employee->personal_file_number }}</td>
          <td>{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</td>
     
           <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                      @if(!User::exists($employee))
                    <li><a href="{{URL::to('portal/activate/'.$employee->id)}}">Activate</a></li>
                  
                        @endif
                   
                           @if(User::exists($employee))
                    <li><a href="{{URL::to('portal/deactivate/'.$employee->id)}}">Deactivate</a></li>
 @endif
                    

                    <li><a href="{{URL::to('css/reset/'.$employee->id)}}">Reset Password</a></li>
                    
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
























@stop