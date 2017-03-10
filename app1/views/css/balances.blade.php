@extends('layouts.membercss')
@section('content')

@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    
                    <div class="row">
                      
                        <div>
                          <h2>Leave</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row">
  


  <div class="col-lg-12">



      <table class="table table-condensed table-bordered" id="users">

         
          <thead>
            <th>#</th>
            <th>Leave Type</th>
            <th>Entitled Days</th>
            <th>Remaining Days</th>
            


          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($leavetypes as $type)
            <tr>
                <td>{{$i}}</td>
                <td>{{$type->name}}</td>
                <td>{{$type->days}}</td>
                <td>{{Leaveapplication::getBalanceDays($employee, $type)}}</td>
              
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