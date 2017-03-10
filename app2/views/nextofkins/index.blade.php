@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Next of Kin</h3>

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

    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('NextOfKins/create')}}">new kin</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Kin Name</th>
         <th>ID Number</th>
         <th>Relationship</th>
        <th></th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($kins as $kin)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $kin->first_name.' '.$kin->last_name }}</td>
          <td>{{ $kin->name }}</td>
          @if($kin->id_number!=' ' || $kin->id_number!=null)
          <td>{{ $kin->id_number }}</td>
          @else
          <td></td>
          @endif
          @if($kin->id_number!=' ' || $kin->id_number!=null)
          <td>{{ $kin->relationship }}</td>
           @else
          <td></td>
          @endif
          
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('NextOfKins/view/'.$kin->id)}}">View</a></li>   

                    <li><a href="{{URL::to('NextOfKins/edit/'.$kin->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('NextOfKins/delete/'.$kin->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s kin?'))">Delete</a></li>
                     

                 
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


       
