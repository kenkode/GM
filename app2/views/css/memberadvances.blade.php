@extends('layouts.membercss')
@section('content')





<br><br>

    
                    <div class="row">

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
                      
                        <div>
                          <h2>Advances</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row">


    <div class="alert alert-info">
     Only 2 advances are permitted per fiscal year
     </div>
   

  
<a href="{{URL::to('css/advances/create')}}" class="btn btn-info">New Advance</a>
<br><br>

  <div class="col-lg-12">



      <table class="table table-condensed table-bordered" id="mobile">

         
          <thead>
            <th>#</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>

          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($advances as $advance)
            <tr>
                <td>{{$i}}</td>
                <td>{{$advance->type}}</td>
                <td>{{number_format($advance->amount,2)}}</td>
                <td>{{$advance->date}}</td>
                <td>{{$advance->status}}</td>
                <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a target="_blank" href="{{URL::to('css/advances/view/'.$advance->id)}}">View</a></li>
                   @if($advance->status == 'Pending')
                    <li><a href="{{URL::to('css/advances/edit/'.$advance->id)}}">Update</a></li>
                   @endif
                   @if($advance->status=='Pending' || $advance->status=='Rejected')
                    <li><a href="{{URL::to('css/advances/delete/'.$advance->id)}}" onclick="return (confirm('Are you sure you want to delete this advance?'))">Delete</a></li>
                   @endif
                  </ul>
              </div>

                    </td>
              
            </tr>
            <?php $i++; ?>
            @endforeach
          </tbody>
        
      </table>
  

  </div>  


<div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  

  

  
</div>


@stop