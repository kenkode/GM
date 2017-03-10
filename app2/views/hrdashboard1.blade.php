@extends('layouts.main')

{{ HTML::script('media/jquery-1.12.0.min.js') }}

@section('content')

<style type="text/css">
li #general:before,li #company:before,li #prefs:before,li #employee:before,
li #bank:before,li #payroll:before,li #reports:before,li #leaves:before,
li #payrollsettings:before,li #emprep:before,li #leavereport:before,
li #advance:before,li #payrep:before,li #statutory:before{
    background-image: url("{{asset('public/uploads/images/collapsed.png')}}");
    margin-right: 4px;
    margin-left: -10px;
}
ul {
    list-style-type:none
}

</style>

@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    

    <script type="text/javascript">
    $(document).ready(function(){
      $('#companyinfo').hide();
      $('#settings').hide();
      $('#employeeinfo').hide();
      $('#bankinfo').hide();
      $('#payrollinfo').hide();
      $('#repall').hide();
      $('#gensettings').hide();
      $('#leaveinfo').hide();
      $('#payrollset').hide();
      $('#hrrep').hide();
      $('#leaverep').hide();
      $('#payrollrep').hide();
      $('#advancerep').hide();
      $('#statutoryrep').hide();
       
      $('#company').click(function(){
      $('#companyinfo').toggle();
      });
      $('#prefs').click(function(){
      $('#settings').toggle();
      });
      $('#employee').click(function(){
      $('#employeeinfo').toggle();
      });
      $('#bank').click(function(){
      $('#bankinfo').toggle();
      });
      $('#payroll').click(function(){
      $('#payrollinfo').toggle();
      });
      $('#reports').click(function(){
      $('#repall').toggle();
      });
      $('#general').click(function(){
      $('#gensettings').toggle();
      $(this).find('img').toggle();
      });
      $('#leaves').click(function(){
      $('#leaveinfo').toggle();
      $(this).find('img').toggle();
      });
      $('#payrollsettings').click(function(){
      $('#payrollset').toggle();
      $(this).find('img').toggle();
      });
      $('#emprep').click(function(){
      $('#hrrep').toggle();
      $(this).find('img').toggle();
      });
      $('#leavereport').click(function(){
      $('#leaverep').toggle();
      $(this).find('img').toggle();
      });
      $('#advance').click(function(){
      $('#advancerep').toggle();
      $(this).find('img').toggle();
      });
      $('#payrep').click(function(){
      $('#payrollrep').toggle();
      $(this).find('img').toggle();
      });
      $('#statutory').click(function(){
      $('#statutoryrep').toggle();
      $(this).find('img').toggle();
      });
    });
    </script>
                  
{{ HTML::script('js/scripts.js') }}


<div class="row">
  
  <div class="col-lg-12">
    
    <hr>

  </div>
</div>


<div class="row">
  


  <div class="col-lg-12">


    <div class="col-lg-4">
    <a href="#" id="company"><img src="{{asset('public/uploads/images/1462360513_Company.png')}}" alt="logo" width="20%">COMPANY INFORMATION</a>
    <ul id="companyinfo">
    <li><a href="{{ URL::to('organizations') }}">Organization Settings</a></li>
    <li><a href="{{ URL::to('branches') }}"> Branches</a></li>
    <li><a href="{{ URL::to('departments') }}"> Departments</a></li>
    <li><a href="{{ URL::to('portal')}}">Portal</a></li>
    <li><a href="{{ URL::to('nssf') }}">Nssf Rates</a></li> 
    <li><a href="{{ URL::to('nhif') }}"> Nhif Rates</a></li>
    </ul>
    </div>

    <div class="col-lg-4">
    <a href="#" id="prefs"><img src="{{asset('public/uploads/images/cogwheel-145804_1280.png')}}" alt="logo" width="20%">PREFERENCES</a>
    <ul id="settings">
    <li><a href="{{ URL::to('users/profile/'.Confide::user()->id ) }}">  Profile</a></li>
    <li><a href="{{ URL::to('accounts') }}"> Accounts Settings</a></li>
    <li><a href="{{ URL::to('system') }}"> System Settings</a></li>
    <li><a id="general" href="#"><img id="imgen" src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
        <img id="imgen" src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
      General Settings</a></li>
    <ul id="gensettings">
    <li><a href="{{ URL::to('benefitsettings') }}"> Benefit Settings</a></td>
    <li><a href="{{ URL::to('employee_type') }}">Employee Types</a></li>
    <li><a href="{{ URL::to('job_group') }}">Job Groups</a></li>
    <li><a href="{{ URL::to('occurencesettings') }}">Occurence Settings</a></li>
    <li><a href="{{ URL::to('citizenships') }}">  Citizenship</a></li>
    <li><a href="{{ URL::to('appraisalcategories') }}">Appraisal Category</a></li>
    <li><a href="{{ URL::to('AppraisalSettings') }}">Appraisal Setting</a></li>
    </ul>
    <li><a href="{{ URL::to('leavetypes') }}">Leave Types</a></li>
    <li><a href="{{ URL::to('holidays') }}"> Holiday Management</a></li>
    <li><a href="{{ URL::to('deactives') }}">Activate Employee</a></li>
    <li><a href="{{ URL::to('migrate') }}"> Data Migration</a></li> 
    <li><a href="{{ URL::to('activatedproducts') }}"> Upgrade License</a></li> 
  </ul>
    </div>

    <div class="col-lg-4">
    <a href="#" id="employee"><img src="{{asset('public/uploads/images/staff-154689_1280.png')}}" alt="logo" width="20%">EMPLOYEES PORTAL</a>
    <ul id="employeeinfo">
    <li><a href="{{ URL::to('employees') }}">Manage Employees </a></li>
    <li><a href="{{ URL::to('Properties') }}">Company Property </a></li>
    <li><a href="{{ URL::to('Appraisals') }}">Employee Appraisal</a></li>
    <li><a href="{{ URL::to('occurences') }}">Employee Occurence </a></li>
    <li><a id="leaves" href="#"><img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
      <img id="imgen" src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
      Manage Leaves</a></li>
    <ul id="leaveinfo">
    <li><a href="{{ URL::to('leavemgmt') }}">Leave Applications</a></li>
    <li><a href="{{ URL::to('leaveamends') }}">  Leaves Amended</a></li>
    <li><a href="{{ URL::to('leaveapprovals') }}">Leaves Approved</a></li>
    <li><a  href="{{ URL::to('leaverejects') }}">Leaves Rejected</a></li>
    </ul>
    <li><a target="_blank" href="{{ URL::to('EmployeeForm') }}"> Employee Detail Form</a></li>
    <li> <a href="{{ URL::to('payrollReports/selectPeriod') }}">  Payslips</a> </li>
   
  </ul>
    </div>

  </div>

  <div class="col-lg-12">

    <div class="col-lg-4">
    <a href="#" id="bank"><img src="{{asset('public/uploads/images/bank-building.png')}}" alt="logo" width="20%">BANK INFORMATION</a>
    <ul id="bankinfo">
    <li><a href="{{ URL::to('banks') }}"> Banks</a></li>
    <li><a href="{{ URL::to('bank_branch') }}">Bank Branches</a></li>
    </ul>
    </div>

    <div class="col-lg-4">
    <a href="#" id="payroll"><img src="{{asset('public/uploads/images/briefcase-business-tool.png')}}" alt="logo" width="20%">MANAGE PAYROLL</a>
    <ul id="payrollinfo">
         <li><a id="payrollsettings" href="#"> 
          <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
          <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
           Payroll Settings</a></li>
         <ul id="payrollset">
         <li><a href="{{ URL::to('earningsettings') }}">  Earning Settings</a></td>
          <li><a href="{{ URL::to('allowances') }}"> Allowance Settings</a></td>
          <li><a href="{{ URL::to('reliefs') }}"> Relief Settings</a></td>
          <li><a href="{{ URL::to('deductions') }}"> Deductions Settings</a></td>
          <li><a href="{{ URL::to('nontaxables') }}"> Non Taxable Income Settings</a></td>
          </ul>
          <li><a href="{{ URL::to('other_earnings') }}">Manage Earnings</a></td>
          <li><a href="{{ URL::to('employee_allowances') }}">Manage Allowances</a></td>
          <li><a href="{{ URL::to('overtimes') }}">Manage Overtimes</a></td> 
          <li><a href="{{ URL::to('employee_relief') }}">Manage Relief</a></td>
          <li><a href="{{ URL::to('employee_deductions') }}">Manage Deductions</a></td>
          <li><a href="{{ URL::to('employeenontaxables') }}">Manage Non Taxable Income</a></td>
          <li><a href="{{ URL::to('payrollcalculator') }}"> Payroll Calculator</a></td> 
          <li><a href="{{ URL::to('advance') }}"> Process Advance Salaries</a></td>
          <li><a href="{{ URL::to('payroll') }}">  Process Payroll</a></td> 
         <li><a href="{{ URL::to('email/payslip') }}">  Email Payslips</a></td>      
        
    </ul>
    </div>

    <div class="col-lg-4">
    <a id="reports" href="#"><img src="{{asset('public/uploads/images/folder-303891_1280.png')}}" alt="logo" width="20%">REPORTS</a>
    <ul id="repall">
    <li><a href="#" id="emprep">
    <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
    <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
     Employee report</a>
    <ul id="hrrep">
    <li><a href="{{ URL::to('employee/select') }}"> Individual Employee report</a></li>
    <li><a href="{{ URL::to('reports/selectEmployeeStatus') }}"> Employee List report</a></li>
    <li><a href="{{ URL::to('reports/nextofkin/selectEmployee') }}" >Next of Kin Report</a> </li>
    <li><a href="{{ URL::to('reports/selectEmployeeOccurence') }}" >Employee Occurence report </a></li>
    <li><a href="{{ URL::to('reports/CompanyProperty/selectPeriod') }}" >Company Property report </a></li>
    <li><a href="{{ URL::to('reports/Appraisals/selectPeriod') }}" >Appraisal report </a></li>
    </ul>
    <li>
      <a href="#" id="leavereport">
      <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
      <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
     Leave report</a>
    <ul id="leaverep">
    <li><a href="{{ URL::to('leaveReports/selectApplicationPeriod') }}"> Leave Application</a></li>
    <li><a href="{{ URL::to('leaveReports/selectApprovedPeriod') }}">Leaves Approved</a></li>
    <li><a href="{{ URL::to('leaveReports/selectRejectedPeriod') }}">Leaves Rejected</a></li>
    <li><a href="{{ URL::to('leaveReports/selectLeave') }}">Leaves Balances</a></li>
    <li><a href="{{ URL::to('leaveReports/selectLeaveType') }}"> Employees on Leave</a></li>  
    <li><a href="{{ URL::to('leaveReports/selectEmployee') }}"> Individual Employee </a></li>  
     </ul>
    </li>
    <li>
     <a href="#" id="advance">
      <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
      <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
     Advance Salary report</a>
    <ul id="advancerep">
    <li><a href="{{ URL::to('advanceReports/selectSummaryPeriod') }}">Advance Summary</a></li>
    <li><a href="{{ URL::to('advanceReports/selectRemittancePeriod') }}">Advance Remittance</a></li>
    </ul>
    </li>
 
    <li>
      <a href="#" id="payrep">
      <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
      <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
       Payroll report</a>
    <ul id="payrollrep">
    

       <li>
          <a href="{{ URL::to('payrollReports/selectSummaryPeriod') }}">Payroll Summary</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectRemittancePeriod') }}">Pay Remittance</a>
       </li>
    
       <li>
          <a href="{{ URL::to('payrollReports/selectEarning') }}"> Earning Report</a>
       </li> 

       <li>
          <a href="{{ URL::to('payrollReports/selectOvertime') }}"> Overtime Report</a>
       </li> 
    
       <li>
          <a href="{{ URL::to('payrollReports/selectAllowance') }}"> Allowance Report</a>
       </li>  

       <li>
          <a href="{{ URL::to('payrollReports/selectnontaxableincome') }}" >Non Taxable Income Report</a>
       </li> 

       <li>
          <a href="{{ URL::to('payrollReports/selectRelief') }}"> Relief Report</a>
       </li>  

       <li>
         <a href="{{ URL::to('payrollReports/selectDeduction') }}"> Deduction Report</a>     
       </li>  

    </ul>
  </li>


<li>
  <a href="#" id="statutory">
  <img src="{{asset('public/uploads/images/collapsed.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px">
  <img src="{{asset('public/uploads/images/expanded.png')}}" alt="logo" style="margin-right:0px;margin-left:-10px;display:none">
   Statutory report</a>
<ul id="statutoryrep">

       <li>
            <a href="{{ URL::to('payrollReports/selectNssfPeriod') }}"> NSSF Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectNhifPeriod') }}">NHIF Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('payrollReports/selectPayePeriod') }}">PAYE Returns</a>
       </li>

       <li>
          <a href="{{ URL::to('itax/download') }}">Download Itax Template</a>
       </li>

    </ul>
</li>

    </ul>
    </div>

  </div>

  <div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  
  
</div>

  <div class="col-lg-12">

    <div style="margin-left:700px;" class="col-lg-4">
    <a href="{{ URL::to('users/logout') }}"><img src="{{asset('public/uploads/images/logout-153871_1280.png')}}" alt="logo" width="20%">LOG OUT / CHANGE USER</a>
    </div>

    
    


      <!-- <table id="datadash" class="table" style="border-style: none;">


      <thead style="border-style: none;">

        <th></th>
        <th></th>
        <th></th>
        <th></th>

      </thead>

      <tbody style="border-style: none;">

        <tr>

          <td><a href="{{ URL::to('employees') }}"><i class="fa fa-users fa-fw"></i>Manage Employees </a></td>
          <td><a href="{{ URL::to('other_earnings') }}"><i class="glyphicon glyphicon-credit-card fa-fw"></i> Manage Payroll</a></td>
          <td><a href="{{ URL::to('leavemgmt') }}"><i class="fa fa-user fa-fw"></i> Manage Leaves</a></td>
          <td><a href="{{ URL::to('reports')}}"><i class="fa fa-file fa-fw"></i>View Reports</a></td>
          
        </tr>

        <tr>
          <td><a href="{{ URL::to('organizations') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Organization Settings</a></td>
          <td><a href="{{ URL::to('accounts') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Accounts Settings</a></td>
          <td><a href="{{ URL::to('system') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> System Settings</a></td>
          <td><a href="{{ URL::to('departments') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>General Settings</a></td>
         
        </tr>

         <tr>

          <td><a href="{{ URL::to('branches') }}"><i class="fa fa-list fa-fw"></i> Branches</a></td>
          <td><a href="{{ URL::to('departments') }}"><i class="fa fa-list fa-fw"></i> Departments</a></td>
          <td><a href="{{ URL::to('employee_type') }}"><i class="fa fa-users fa-fw"></i> Employee Types</a></td>
          <td><a href="{{ URL::to('job_group') }}"><i class="fa fa-users fa-fw"></i> Job Groups</a></td>
          
        </tr>


        <tr>
          
          <td><a href="{{ URL::to('benefitsettings') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Benefit Settings</a></td>
          <td><a href="{{ URL::to('citizenships') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>  Citizenship</a></td>
          <td><a href="{{ URL::to('AppraisalSettings') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Appraisal Setting</a></td>
          <td><a href="{{ URL::to('appraisalcategories') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>Appraisal Category</a></td>
        </tr>

        <tr>
 
          <td><a href="{{ URL::to('banks') }}"><i class="glyphicon glyphicon-home fa-fw"></i> Banks</a></td>
          <td><a href="{{ URL::to('bank_branch') }}"><i class="glyphicon glyphicon-home fa-fw"></i> Bank Branches</a></td>
          <td><a href="{{ URL::to('nssf') }}"><i class="fa fa-list fa-fw"></i> Nssf Rates</a></td> 
          <td><a href="{{ URL::to('nhif') }}"><i class="fa fa-list fa-fw"></i> Nhif Rates</a></td>
        </tr>

        <tr>
          <td><a href="{{ URL::to('allowances') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>  Payroll Settings</a></td>
          <td><a href="{{ URL::to('occurencesettings') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>  Occurence Settings</a></td>
          <td><a href="{{ URL::to('leavetypes') }}"><i class="fa fa-list fa-fw"></i> Leave Types</a></td>
          <td><a href="{{ URL::to('holidays') }}"><i class="fa fa-random fa-fw"></i> Holiday Management</a></td>
           
          
        </tr>

        <tr>
          <td><a href="{{ URL::to('leavemgmt') }}"><i class="fa fa-file fa-fw"></i> Leave Applications</a></td>
          <td><a href="{{ URL::to('leaveamends') }}"><i class="fa fa-edit fa-fw"></i>  Leaves Amended</a></td>
          <td><a href="{{ URL::to('leaveapprovals') }}"><i class="fa fa-check fa-fw"></i>  Leaves Approved</a></td>
           <td><a  href="{{ URL::to('leaverejects') }}"><i class="fa fa-barcode fa-fw"></i> Leaves Rejected</a></td>
          
        </tr>


       

        <tr>
          <td><a href="{{ URL::to('portal')}}"><i class="fa fa-user fa-fw"></i>Portal</a></td>
          <td><a href="{{ URL::to('deactives') }}"><i class="fa fa-users fa-fw"></i> Activate Employee</a></td>
          <td><a target="_blank" href="{{ URL::to('EmployeeForm') }}"><i class="fa fa-file fa-fw"></i>  Employee Detail Form</a></td>
          <td><a href="{{ URL::to('migrate') }}"><i class="glyphicon glyphicon-random fa-fw"></i>  Data Migration</a></td>     
            
        </tr>

        
      
        <tr>
          <td><a href="{{ URL::to('earningsettings') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>  Earning Settings</a></td>
          <td><a href="{{ URL::to('allowances') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Allowance Settings</a></td>
          <td><a href="{{ URL::to('reliefs') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Relief Settings</a></td>
          <td><a href="{{ URL::to('deductions') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Deductions Settings</a></td>
          
        </tr>

        <tr>
          <td><a href="{{ URL::to('nontaxables') }}"><i class="glyphicon glyphicon-cog fa-fw"></i> Non Taxable Income Settings</a></td>
          <td><a href="{{ URL::to('other_earnings') }}"><i class="glyphicon glyphicon-credit-card fa-fw"></i>Manage Earnings</a></td>
          <td><a href="{{ URL::to('employee_allowances') }}"><i class="glyphicon glyphicon-credit-card fa-fw"></i>Manage Allowances</a></td>
          <td><a href="{{ URL::to('overtimes') }}"><i class="glyphicon glyphicon-credit-card fa-fw"></i>Manage Overtimes</a></td> 
          
        </tr>


        <tr>
          <td><a href="{{ URL::to('employee_relief') }}"><i class="glyphicon glyphicon-credit-card fa-fw"></i>Manage Relief</a></td>
          <td><a href="{{ URL::to('employee_deductions') }}"><i class="glyphicon glyphicon-barcode fa-fw"></i>Manage Deductions</a></td>
          <td><a href="{{ URL::to('employeenontaxables') }}"><i class="glyphicon glyphicon-barcode fa-fw"></i>Manage Non Taxable Income</a></td>
         <td><a href="{{ URL::to('payrollcalculator') }}"><i class="glyphicon glyphicon-calendar"></i> Payroll Calculator</a></td> 
         
          
        </tr>


        <tr> 
          <td><a href="{{ URL::to('advance') }}"><i class="glyphicon glyphicon-circle-arrow-right fa-fw"></i>  Process Advance Salaries</a></td>
          <td><a href="{{ URL::to('payroll') }}"><i class="glyphicon glyphicon-circle-arrow-right fa-fw"></i>  Process Payroll</a></td> 
         <td><a href="{{ URL::to('email/payslip') }}"><i class="glyphicon glyphicon-envelope fa-fw"></i>  Email Payslips</a></td>      
        
        <td><a href="{{ URL::to('users/profile/'.Confide::user()->id ) }}"><i class="fa fa-user fa-fw"></i>  Profile</a></td>
        <td></td>
        </tr>

        <tr>
         <td><a href="{{ URL::to('users/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a></td>
         <td></td><td></td><td></td>
        </tr>
        

      </tbody>


    </table> -->
</div>
</div>

  </div>  



@stop
