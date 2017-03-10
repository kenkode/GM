@extends('layouts.hr')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Appraisal Settings</h3>

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
          <a class="btn btn-info btn-sm" href="{{ URL::to('AppraisalSettings/create')}}">new appraisal setting</a>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Question</th>
        <th>Category</th>
        <th>Rate</th>
        <th>Action</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($appraisals as $appraisal)

        <tr>

          <td>{{ $i }}</td>
          <td>{{ $appraisal->question }}</td>
          <td>{{ Appraisalcategory::getCategory($appraisal->appraisalcategory_id) }}</td>
          <td>{{ $appraisal->rate }}</td>
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('AppraisalSettings/edit/'.$appraisal->id)}}">Update</a></li>
                   
                    <li><a href="{{URL::to('AppraisalSettings/delete/'.$appraisal->id)}}" onclick="return (confirm('Are you sure you want to delete this appraisal question?'))">Delete</a></li>
                    
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