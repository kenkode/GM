@extends('layouts.hr')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Occurence Settings</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('occurencesettings/create')}}">new occurence type</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Occurence Type</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($occurences as $occurence)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $occurence->occurence_type }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('occurencesettings/edit/'.$occurence->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('occurencesettings/delete/'.$occurence->id)}}" onclick="return (confirm('Are you sure you want to delete this occurence type?'))">Delete</a></li>
                    
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