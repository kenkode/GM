@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Employee Occurences</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('occurences/create')}}">new occurence</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Occurence</th>
        <th>Action</th>

      </thead>
      <tfoot>

        <th>#</th>
        <th>Employee</th>
        <th>Occurence</th>

      </tfoot>
      <tbody>

        <?php $i = 1; ?>
        @foreach($occurences as $occurence)

        <tr>

          <td> {{ $i }}</td>
          @if($occurence->middle_name == null || $occurence->middle_name == '')
          <td>{{ $occurence->first_name.' '.$occurence->last_name }}</td>
          @else
          <td>{{ $occurence->first_name.' '.$occurence->middle_name.' '.$occurence->last_name }}</td>
          @endif
          <td>{{ $occurence->occurence_brief }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('occurences/view/'.$occurence->id)}}">View</a></li>
                     <li><a href="{{URL::to('occurences/download/'.$occurence->id)}}">Download</a></li>
                    <li><a href="{{URL::to('occurences/edit/'.$occurence->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('occurences/delete/'.$occurence->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s occurence?'))">Delete</a></li>
                    
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