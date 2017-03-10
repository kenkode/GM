@extends('layouts.organization')
@section('content')

<div class="row">
  <div class="col-lg-12">
  <h3>Document Reminders</h3>

<hr>
</div>  
</div>


<div class="row">
  <div class="col-lg-12">

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

      
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Document name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th></th>

      </thead>
      <tfoot>

        <th>#</th>
        <th>Employee</th>
         <th>Document name</th>
        <th>From Date</th>
        <th>Expiry Date</th>
      </tfoot>
      <tbody>

        <?php $i = 1; ?>
        @foreach($employees as $employee)
        <?php $date = (strtotime(date("Y-m-d")) - strtotime($employee->expiry_date)) / 86400; ?>
        @if($date<=31)
        <tr>

          <td> {{ $i }}</td>
          @if($employee->middle_name == null || $employee->middle_name == '')
          <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
          @else
          <td>{{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</td>
          @endif
          <td>{{ $employee->document_name }}</td>
          <td>{{ $employee->from_date }}</td>
          <td>{{ $employee->expiry_date }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left:0px" role="menu">
                    <li><a href="{{URL::to('reminderdoc/download/'.$employee->did)}}">Download</a></li>
                  </ul>
              </div>

                    </td>



        </tr>
        @else
        @endif

        <?php $i++; ?>
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>

@stop