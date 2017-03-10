
@extends('layouts.payroll')

{{ HTML::script('media/jquery-1.8.0.min.js') }}

<?php
$part = explode("-", $period);
$start_date = $part[1]."-".$part[0]."-01";
$end_date  = date('Y-m-t', strtotime($start_date));
$start  = date('Y-m-01', strtotime($end_date));


     $per = DB::table('transact_advances')
          ->where('financial_month_year','=',$period)
          ->where('organization_id','=',Confide::user()->organization_id)
          ->count();
     if($per>0){?>

      <script type="text/javascript"> 
     
      if (window.confirm("Do you wish to process advance salaries for {{$period}} again?"))
      {

         $(function(){
                  var p1 = <?php echo $part[0]?>;
                  var p2 = "-";
                  var p3 = <?php echo $part[1]?>;

                  console.log(p1+p2+p3);

                  $.ajax({
                      url     : "{{URL::to('deleteadvance')}}",
                      type    : "POST",
                      async   : false,
                      data    : {
                          'period1'  : p1,
                          'period2'  : p2,
                          'period3'  : p3
                      },
                      success : function(d){
                      if(d == 0){
                           
                         }else{
                           
                         }
                      }        
             });
         });
       }else{
      window.location.href = "{{URL::to('advance')}}";
     }
    </script>
    <?php } ?>

    <?php
function asMoney($value) {
  return number_format($value, 2);
}

?>

@section('content')
<br/>

<div class="row">
  <div class="col-lg-12">
  <h3>Advance Salary Preview for {{ $period }}</h3>

<hr>
</div>  
</div>


<div class="row" >
  <div class="col-lg-12">

    
    <form method="POST" action="{{{ URL::to('advance') }}}" accept-charset="UTF-8">

      <input type="hidden" name="period" value="{{ $period }}"> 
       <input type="hidden" name="account" value="{{ $account }}"> 

<div align="right" class="form-actions form-group">
        
          <button class="btn btn-primary btn-sm process" >Process</button>
        </div>

        <div class="panel panel-default">
      <div class="panel panel-success">
      <div class="panel-heading">
          <h4>Advance Salary Preview for {{ $period }}</h4>
        </div>
        <div class="panel-body" style="margin-left:-10px;">

    <table id="users" style="font-size:14px;width:100%" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
         <th>Payroll Number</th>
         <th>Employee</th>
         <th>Amount</th>

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($employees as $employee)

        <tr>

          <td> {{ $i }}</td>
          <td >{{ $employee->personal_file_number }}</td>
          <td>{{ $employee->first_name.' '.$employee->last_name }}</td>
          <td align="right">{{ asMoney((double)$employee->deduction_amount) }}</td>
         
        </tr>
         
        <?php $i++; ?>
        @endforeach

      </tbody>

    </table>
     
     

      </form>
    

  </div>


  </div>

</div>

@stop