<?php

if (!function_exists('asMoney')){
function asMoney($value) {
  return number_format($value, 2);
}
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

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="{{ $organization->logo }}" width="150px"/>
    
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
<br>

	<div class="content" style='margin-top:-70px;'>
    @if($employee->middle_name != null || $employee->middle_name != '')
     <div align="center"><strong>Leave Report for {{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</strong></div>
    @else
     <div align="center"><strong>Leave Report for {{$employee->personal_file_number.' : '.$employee->first_name.' '.$employee->last_name}}</strong></div>
    @endif
   
<br>
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <td width='20'><strong># </strong></td>
        <td><strong>Leave Type </strong></td>
        <td><strong>Beginning Balance </strong></td>
        <td><strong>Leave Taken </strong></td>
        <td><strong>Leave Balance </strong></td>
      </tr>

    <?php

    $levename = null;
    $i =1;
      foreach($employee->leaveapplications as $application){

         

          if($application->leavetype->name == $levename ){

      ?>
     
      <?php 
          } else if($application->approved_start_date<=date('Y-m-d')){
            ?>
            <tr>


       <td td width='20'>{{$i}}</td>
        <td> {{ $application->leavetype->name }}</td>
        <td> {{ Leaveapplication::getBalanceDays($employee, $application->leavetype)}}</td>
        <td> {{ Leaveapplication::getDaysTaken($employee, $application->leavetype)}}</td>
        <td> {{ (Leaveapplication::getBalanceDays($employee, $application->leavetype))-(Leaveapplication::getDaysTaken($employee, $application->leavetype)) }}</td>
        </tr>
        <?php
         $i++;
          }

           $levename = $application->leavetype->name;
           
       
      }

    ?>

     

    </table>

<br><br>

   
</div>


</body>

</html>



