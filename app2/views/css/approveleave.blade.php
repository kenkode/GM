@extends('layouts.membercss')
@section('content')





<br><br>
    
                    <div class="row">
                      
                        <div>
                          <h2>Subordinates` Leave</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>

@if (Session::get('flash_message'))
            <div class="alert alert-info">{{ Session::get('flash_message') }}</div>
        @endif
<div class="row">
  
<br><br>

  <div class="col-lg-12">



      <table class="table table-condensed table-bordered" id="mobile">

         
          <thead>
            <th>#</th>
            <th>Employee</th>
            <th>Leave Type</th>
            <th>Application Date</th>
            <th>Applied Start Date</th>
            <th>Applied End Date</th>
            <th>Leave Days</th>
            <th>Action</th>


          </thead>
          <tbody>
            @if($c>0)
            <?php $i=1; 
            $employeeid = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');
            $sups = Supervisor::where('supervisor_id',$employeeid)->get();
            
            $ids_array = array();

            foreach ($sups as $sup) {
            $ids_array[] = $sup->employee_id;
            }
            $emps = Employee::whereIn('id',$ids_array)->get();

            $arr=array();
            foreach ($emps as $emp) {
            $arr[]=$emp->id;
            }
            $leaveapplications = DB::table('leaveapplications')
                                ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                                ->whereIn('employee_id',$arr)
                                ->where('status', '=', 'applied')
                                ->where('is_supervisor_approved', '=', 0)
                                ->select('leaveapplications.id as id','leavetype_id','first_name','last_name','application_date','applied_start_date','applied_end_date','is_weekend','is_holiday')
                                ->orderBy('application_date', 'desc')
                                ->get();

            
          ?>
          @foreach($leaveapplications as $application)
            <tr>
                <td>{{$i}}</td>
                <td>{{ $application->first_name.' '.$application->last_name }}</td>
              
                <td>{{Leavetype::getName($application->leavetype_id)}}</td>
                <td>{{date('d-M-Y', strtotime($application->application_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_start_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_end_date))}}</td>
                <td>{{Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
                
                <td>
                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">

                    <li><a href="{{URL::to('employeeleave/view/'.$application->id)}}">View</a></li>

                    
                  </ul>
              </div>

                    </td>
              
            </tr>
            <?php $i++; ?>
            @endforeach
            @else
            @endif
          </tbody>
        
      </table>
  

  </div>  


<div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  

  

  
</div>


@stop