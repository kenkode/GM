@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Employee Appraisals</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('Appraisals/create')}}">new appraisal</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Employee</th>
        <th>Appraisal Question</th>
        <th>Performance</th>
        <th>Score</th>
        <th></th>

      </thead>
      <tfoot>

        <th>#</th>
        <th>Employee</th>
        <th>Appraisal Question</th>
        <th>Performance</th>
        <th>Score</th>

      </tfoot>
      <tbody>

        <?php $i = 1; ?>
        @foreach($appraisals as $appraisal)

        <tr>
          

          <td> {{ $i }}</td>
          @if($appraisal->middle_name == null || $appraisal->middle_name == '')
          <td>{{ $appraisal->first_name.' '.$appraisal->last_name }}</td>
          @else
          <td>{{ $appraisal->first_name.' '.$appraisal->middle_name.' '.$appraisal->last_name }}</td>
          @endif
          <td>{{ Appraisalquestion::getQuestion($appraisal->appraisalquestion_id) }}</td>
          <td>{{ $appraisal->performance }}</td>
          <td>{{ $appraisal->rate.' / '. Appraisalquestion::getScore($appraisal->appraisalquestion_id) }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('Appraisals/view/'.$appraisal->id)}}">View</a></li> 

                    <li><a href="{{URL::to('Appraisals/edit/'.$appraisal->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('Appraisals/delete/'.$appraisal->id)}}" onclick="return (confirm('Are you sure you want to delete this employee`s appraisal?'))">Delete</a></li>
                    
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


       
