@extends('layouts.leave')


{{ HTML::script('media/jquery-1.12.0.min.js') }}
<script type="text/javascript">
    $(function () {

        $(".wmd-view-topscroll").scroll(function () {
            $(".wmd-view")
            .scrollLeft($(".wmd-view-topscroll").scrollLeft());
        });

        $(".wmd-view").scroll(function () {
            $(".wmd-view-topscroll")
            .scrollLeft($(".wmd-view").scrollLeft());
        });

    });

    $(window).load(function () {
        $('.scroll-div').css('width', $('.dynamic-div').outerWidth() );
    });
</script>

        <style type="text/css">
    .wmd-view-topscroll, .wmd-view
{
    overflow-x: auto;
    overflow-y: hidden;
    width: 1040px;
}

.wmd-view-topscroll
{
    height: 16px;
}

.dynamic-div
{
    display: inline-block;
}

        </style>


@section('content')

<br><br>

@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    
                    <div class="row">
                      
                        <div>
                          <h2>Vacation Roster</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row">
  
<h3>{{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name.' Leave Roster'}}</h3>
<br><br>

  <div class="col-lg-12">

   <div class="wmd-view-topscroll" style="width: 100%;">
       <div class="scroll-div">
        &nbsp;
       </div>
      </div>

    <div class="panel panel-default wmd-view" style="width: 100%;">
      
        <div class="panel panel-body dynamic-div" style="margin-left:-10px;">



      <table id="mobile" class="table table-condensed table-bordered table-responsive" style="margin-left:-12px;width:1100px !important;">

         
          <thead>
            <th>#</th>
            <th>Vacation Type</th>
            <th>Application Date</th>
            <th>Applied Start Date</th>
            <th>Applied End Date</th>
            <th>Vacation Days</th>
            <th>Status</th>
            <th></th>


          </thead>
          <tbody>
          <?php $i=1; ?>
          @foreach($leaveapplications as $application)
            <tr>
                <td>{{$i}}</td>
                <td>{{Leavetype::getName($application->leavetype_id)}}</td>
                <td>{{date('d-M-Y', strtotime($application->application_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_start_date))}}</td>
                <td>{{date('d-M-Y', strtotime($application->applied_end_date))}}</td>
                <td>{{Leaveapplication::getDays($application->applied_end_date,$application->applied_start_date,$application->is_weekend,$application->is_holiday)+1}}</td>
                <td>{{$application->status}}</td>
                <td>
           <a href="{{URL::to('leaveapplications/edit/'.$application->id)}}">Amend</a> &nbsp; |
           @if($application->is_supervisor_approved == 1)
           @if(Leaveapplication::getBalanceDays($application->employee, $application->leavetype,$application) >= Leaveapplication::getLeaveDays($application->applied_end_date,$application->applied_start_date))
          <a href="{{URL::to('leaveapplications/approve/'.$application->id)}}">Approve</a> &nbsp;
          @endif
          @endif
          |&nbsp;<a href="{{URL::to('leaveapplications/reject/'.$application->id)}}">Reject</a> &nbsp;|
           <a href="{{URL::to('leaveapplications/cancel/'.$application->id)}}">Cancel</a>
          </td>
              
            </tr>
            <?php $i++; ?>
            @endforeach
          </tbody>
        
      </table>
  
       </div>
      </div>

  </div>  


<div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  

  

  
</div>


@stop