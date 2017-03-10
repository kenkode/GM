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
  width: 70%;
  margin-bottom: 50px;
}
.t {
  width: 30%;
  margin-bottom: 2px;
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

.emp {
    display: inline-block;
    width:700px;
}
.pic {
    display: inline-block;
    width:200px;
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

<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>

   <div style='width:1000px;'>

<div class="pic">
<table class="t">
<tr>
    @if($employee->photo != null || $employee->photo != '')
    <td><img src="{{ asset('/public/uploads/employees/photo/'.$employee->photo) }}" alt="Photo" width="150px"/></td>
    @else
    <td></td>
    @endif
</tr>
<tr>
    @if($employee->signature != null || $employee->signature != '')
    <td><img src="{{asset('/public/uploads/employees/signature/'.$employee->signature) }}" alt="Signature" width="100px"/></td>
    @else
    <td></td>
    @endif
</tr>
</table>
</div>




	<div class="emp">


    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>
      <tr><td><strong>Payroll Number: </strong></td><td>{{$employee->personal_file_number}}</td></tr>
      @if($employee->middle_name != null || $employee->middle_name != ' ')
      <tr><td><strong>Employee Name: </strong></td><td> {{$employee->last_name.' '.$employee->first_name.' '.$employee->middle_name}}</td>
      @else
      <td><strong>Employee Name: </strong></td><td> {{$employee->last_name.' '.$employee->first_name}}</td>
      @endif
      </tr>
      <tr><td><strong>Identity Number: </strong></td><td>{{$employee->identity_number}}</td></tr>
      <tr><td><strong>Kra Pin: </strong></td>
        @if($employee->pin != null)
        <td>{{$employee->pin}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Nssf Number: </strong></td>
        @if($employee->social_security_number != null)
        <td>{{$employee->social_security_number}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Nhif Number: </strong></td>
        @if($employee->hospital_insurance_number != null)
        <td>{{$employee->hospital_insurance_number}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Work Permit: </strong></td>
        @if($employee->work_permit_number != null)
        <td>{{$employee->work_permit_number}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Job Title: </strong></td>
        @if($employee->job_title != null)
        <td>{{$employee->job_title}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Branch: </strong></td> 
        @if($employee->branch_id != 0)
        <td> {{ $employee->branch->name}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Department: </strong></td>
        @if($employee->department_id != 0)
        <td> {{ $employee->department->department_name}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Job Group: </strong></td>
        @if($employee->job_group_id != 0)
        <td>
            <?php 
            $jgroup = DB::table('job_group')->where('id', '=', $employee->job_group_id)->pluck('job_group_name');            
            ?>

            {{ $jgroup}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td colspan='2' style='height:20px;'></td></tr>
        @if(count($benefits) > 0)
        <tr><td colspan='2' ><strong>Job group benefits: </strong></td></tr>
        <tr><td><strong>Name: </strong></td><td><strong>Amount</strong></td></tr>
      @foreach($benefits as $benefit)
      <tr><td>{{Benefitsetting::getBenefit($benefit->benefit_id)}}</td>
      <td>{{asMoney($benefit->amount)}}</td></tr>
      @endforeach
      <tr><td colspan='2' style='height:20px;'></td></tr>
        @else
        @endif

        <tr><td><strong>Employee Type: </strong></td>
        @if($employee->type_id != 0)
        <td>
            <?php 
            $etype = DB::table('employee_type')->where('id', '=', $employee->type_id)->pluck('employee_type_name');            
            ?>

            {{ $etype}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Gender:</strong></td>
        @if($employee->gender != null)
        <td>{{$employee->gender}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Marital Status:</strong></td>
        @if($employee->marital_status != null)
        <td>{{$employee->marital_status}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Date of Birth:</strong></td>
        @if($employee->yob != null)
        <td>{{$employee->yob}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Citizenship:</strong></td>
        @if($employee->citizenship_id != null || $employee->citizenship_id != '')
        <td>{{$employee->citizenship->name}}</td>
        @else
        <td></td>
        @endif
        </tr>

        <tr><td><strong>Employee Bank: </strong></td>
        @if($employee->bank_id != 0)
        <td>
            <?php 
            $bank = DB::table('banks')->where('id', '=', $employee->bank_id)->pluck('bank_name');            
            ?>

            {{ $bank}}</td>
        @else
        <td></td>
        @endif
        </tr>
 
        <tr><td><strong>Bank Branch: </strong></td>
        @if($employee->bank_id != 0)
        <td>
            <?php 
            $bbranch = DB::table('bank_branches')->where('id', '=', $employee->bank_branch_id)->pluck('bank_branch_name');            
            ?>

            {{ $bbranch}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Mode of Payment: </strong></td>
        @if($employee->mode_of_payment == 'Others')
        <td>{{$employee->custom_field1}}</td>
        @else
        <td>{{$employee->mode_of_payment}}</td>
        @endif
        </tr>
        <tr><td><strong>Bank Account Number:</strong></td>
        @if($employee->bank_account_number != null)
        <td>{{$employee->bank_account_number}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Bank EFT Code:</strong></td>
        @if($employee->bank_eft_code != null)
        <td>{{$employee->bank_eft_code}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Swift Code:</strong></td>
        @if($employee->swift_code != null)
        <td>{{$employee->swift_code}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Office Email:</strong></td>
        @if($employee->email_office != null)
        <td>{{$employee->email_office}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Personal Email:</strong></td>
        @if($employee->email_personal != null)
        <td>{{$employee->email_personal}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Mobile Phone:</strong></td>
        @if($employee->telephone_mobile != null)
        <td>{{$employee->telephone_mobile}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Postal Address:</strong></td>
        @if($employee->postal_address != null)
        <td>{{$employee->postal_address}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Postal Zip:</strong></td>
        @if($employee->postal_zip != null)
        <td>{{$employee->postal_zip}}</td>
        @else
        <td></td>
        @endif
        </tr>
        <tr><td><strong>Date Joined:</strong></td>
        @if($employee->date_joined != null)
        <td>{{$employee->date_joined}}</td>
        @else
        <td></td>
        @endif
        </tr>
         <tr><td><strong>In Employment:</strong></td>
        @if($employee->in_employment == 'Y')
        <td>Yes</td>
        @else
        <td>No</td>
        @endif
         
    </table>

<br><br>

   <div>
</div>


</body>

</html>



