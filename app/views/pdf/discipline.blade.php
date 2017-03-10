<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>
<html >



<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 50px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;
}



 @page { margin: 170px 30px; }
 .header { position: top; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }



</style>

</head>

<body>

  <div class="header" style='margin-top:-150px;'>
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" width="80%">

    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}
          </strong><br>
          {{ $organization->phone}}<br>
          {{ $organization->email}}<br>
          {{ $organization->website}}<br>
          {{ $organization->address}}
       

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>

<br>

<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>


	<div class="content" style='margin-top:-70px;'>
    @if($id == 'All')
   <div style="margin-bottom:20px">{{'<strong>Period</strong> : '.$from.' to '.$to}}<div align="center"><strong>Compliance Report</strong></div></div>
    @else
    <div style="margin-bottom:20px">{{'<strong>Period</strong> : '.$from.' to '.$to}}<div align="center"><strong>Compliance Report for {{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name}}</strong></div></div>
    @endif
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <td width='20'><strong># </strong></td>
        @if($id == 'All')
        <td><strong>Payroll Number </strong></td>
        <td><strong>Employee Name </strong></td>
         @else
         @endif
        <td><strong>Reason </strong></td>
        <td><strong>Action Taken</strong></td>
        <td><strong>Days</strong></td>
        <td><strong>Date</strong></td>
      </tr>
      <?php $i =1; ?>
      @foreach($disciplines as $discipline)
      <tr>


       <td td width='20'>{{$i}}</td>
        @if($id == 'All')
        <td> {{ Discipline::getImage($discipline->employee_id)->personal_file_number }}</td>
        <td> {{ Discipline::getEmployee($discipline->employee_id) }}</td>
        @else
        @endif
        <td> {{ $discipline->reason }}</td>
        <td> {{ $discipline->action }}</td>
        <td> {{ $discipline->days }}</td>
        <td> {{ $discipline->discipline_date }}</td>
        </tr>
      <?php $i++; ?>
   
    @endforeach
      
    </table>

<br><br>

   
</div>


</body>

</html>



