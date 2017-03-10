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

<div class="row">
											
											
											
        						

	<div class="col-lg-12">
	<br>

    <div class="panel panel-default">
      <div class="panel-heading">
          Approved Leaves
        </div>
        <div class="panel-body">

          <div class="wmd-view-topscroll" style="width: 100%;">
       <div class="scroll-div">
        &nbsp;
       </div>
      </div>

    <div class="panel panel-default wmd-view" style="width: 100%;">
      
        <div class="panel panel-body dynamic-div" style="margin-left:-10px;">
    

	<table style="width:1500px !important;" id="mobile" class="table table-condensed table-bordered table-responsive">

  <thead>
    
    <th style="font-size:10px;">PFN</th>
    <th style="font-size:10px;">Employee</th>
    <th style="font-size:10px;">Branch</th>
    <th style="font-size:10px;">Department</th>
    <th style="font-size:10px;">Vacation Type</th>
    <th style="font-size:10px;">Approval Date</th>
    <th style="font-size:10px;">Start Date</th>
    <th style="font-size:10px;">End Date</th>
    <th style="font-size:10px;">Vacation Days</th>
    <th></th>


  </thead>

  <tfoot>
    
    <th>PFN</th>
    <th>Employee</th>
    <th>Branch</th>
    <th>Department</th>
    <th>Vacation Type</th>
    <th>Approval Date</th>
    <th>Start Date</th>
    <th>End Date</th>
    <th>Vacation Days</th>

  </tfoot>

  <tbody>

   

        @foreach($leaveapplications as $leaveapplication)
        @if($leaveapplication->status == 'approved')
         <tr>

          <td>{{$leaveapplication->employee->personal_file_number}}</td>
          <td>{{$leaveapplication->employee->first_name." ".$leaveapplication->employee->middle_name." ".$leaveapplication->employee->last_name}}</td>
          <td>{{Branch::getName($leaveapplication->employee->branch_id)}}</td>
          <td>{{Department::getName($leaveapplication->employee->department_id)}}</td>
          <td>{{$leaveapplication->leavetype->name}}</td>
          <td>{{$leaveapplication->date_approved}}</td>
           <td>{{$leaveapplication->approved_start_date}}</td>
            <td>{{$leaveapplication->approved_end_date}}</td>
            <td>{{Leaveapplication::getDays($leaveapplication->applied_end_date,$leaveapplication->applied_start_date,$leaveapplication->is_weekend,$leaveapplication->is_holiday)+1}}</td>


          <td>
           <a href="{{URL::to('leaveapplications/edit/'.$leaveapplication->id)}}">Amend</a> &nbsp; |
          <a href="{{URL::to('leaveapplications/cancel/'.$leaveapplication->id)}}">Cancel</a>
          </td>

           </tr>
           @endif
        @endforeach
      

   
    

  </tbody>

        
  </table>
           
      </div>
</div>

        </div>
		<hr>

	</div>
</div>

@stop