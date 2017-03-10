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

  <div class="header" style="margin-top:-150px">
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

<?php
  $d=strtotime($from);
  $d1=strtotime($to);
?>

<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>


	<div class="content" style='margin-top:-70px;'>
  @if($employee->middle_name != null || $employee->middle_name != '')
  <div align="center"><strong>Appraisal Report for {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }} for period between {{date("F j, Y", $d).' and '.date("F j, Y", $d1)}}</strong></div><br>
  @else
  <div align="center"><strong>Appraisal Report for {{ $employee->first_name.' '.$employee->last_name }} for period between {{date("F j, Y", $d).' and '.date("F j, Y", $d1)}}</strong></div><br>
  @endif
    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        

        <td width='20'><strong># </strong></td>
        <td><strong>Question</strong></td>
        <td><strong>Performance </strong></td>
        <td><strong>Rate</strong></td>
        <td><strong>Examiner</strong></td>  
        <td><strong>appraisal Date</strong></td>
        <td><strong>Comment</strong></td>
      </tr>
      <?php $i =1; ?>
      @foreach($appraisals as $appraisal)
      <tr>


       <td td width='20'>{{$i}}</td>
        <td> {{ $appraisal->question}}</td>
        <td> {{ $appraisal->performance}}</td>
        <td> {{ $appraisal->rate}}</td>
        <td> {{ $appraisal->username}}</td>
        <td> {{ $appraisal->appraisaldate}}</td>
        <td> {{ $appraisal->comment}}</td>
        </tr>
      <?php $i++; ?>
   
    @endforeach

     


    </table>

<br><br>

    





   
</div>


</body>

</html>



