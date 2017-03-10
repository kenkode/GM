<style type="text/css">
.dropdown-menu {
    margin-left: 190px;
}
</style>

 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    

            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="#"><i class="fa fa-folder-open fa-fw"></i>HR Reports <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('employee/select') }}"><i class="fa fa-file fa-fw"></i>Individual Employee report</a></li>
                            <li><a href="{{ URL::to('reports/selectEmployeeStatus') }}"><i class="fa fa-file fa-fw"></i>Employee List report</a></li>
                            <li><a href="{{ URL::to('reports/nextofkin/selectEmployee') }}"><i class="fa fa-file fa-fw"></i>Next of Kin Report</a></li>
                            <li><a href="{{ URL::to('reports/selectEmployeeOccurence') }}"><i class="fa fa-file fa-fw"></i>Employee Occurence</a></li>
                            <li><a href="{{ URL::to('reports/CompanyProperty/selectPeriod') }}"><i class="fa fa-file fa-fw"></i>Company Property</a></li>
                            <li><a href="{{ URL::to('reports/Appraisals/selectPeriod') }}"><i class="fa fa-file fa-fw"></i>Appraisal report </a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->


                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open fa-fw"></i>Leave Reports <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li>
                              <a href="{{ URL::to('leaveReports/selectApplicationPeriod') }}"><i class="fa fa-file fa-fw"></i>Leave Application</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('leaveReports/selectApprovedPeriod') }}"><i class="fa fa-file fa-fw"></i>Leaves Approved</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('leaveReports/selectRejectedPeriod') }}"><i class="fa fa-file fa-fw"></i>Leaves Rejected</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('leaveReports/selectLeave') }}"><i class="fa fa-file fa-fw"></i>Leaves Balances</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('leaveReports/selectLeaveType') }}"><i class="fa fa-file fa-fw"></i>Employees on Leave</a>
                            </li>  
                            <li>
                             <a href="{{ URL::to('leaveReports/selectEmployee') }}"><i class="fa fa-file fa-fw"></i>Individual Employee </a>     
                            </li>  
                       </ul>
                    </li>

                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open fa-fw"></i>Salary Advance Reports <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li>
                              <a href="{{ URL::to('advanceReports/selectSummaryPeriod') }}"><i class="fa fa-file fa-fw"></i>Advance Summary</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('advanceReports/selectRemittancePeriod') }}"><i class="fa fa-file fa-fw"></i>Advance Remittance</a>
                            </li>
                        </ul>
                    </li> 

                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open fa-fw"></i>Payroll Reports <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li>
                                <a href="{{ URL::to('payrollReports/selectPeriod') }}"><i class="fa fa-file fa-fw"></i>Monthly Payslips</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payrollReports/selectSummaryPeriod') }}"><i class="fa fa-file fa-fw"></i>Payroll Summary</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payrollReports/selectRemittancePeriod') }}"><i class="fa fa-file fa-fw"></i>Pay Remittance</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payrollReports/selectEarning') }}"><i class="fa fa-file fa-fw"></i>Earning Report</a>
                            </li> 
                            <li>
                              <a href="{{ URL::to('payrollReports/selectOvertime') }}"><i class="fa fa-file fa-fw"></i>Overtime Report</a>
                            </li>  
                            <li>
                              <a href="{{ URL::to('payrollReports/selectAllowance') }}"><i class="fa fa-file fa-fw"></i>Allowance Report</a>
                            </li>  
                            <li>
                               <a href="{{ URL::to('payrollReports/selectnontaxableincome') }}"><i class="fa fa-file fa-fw"></i>Non Taxable Income</a>
                            </li>  
                            <li>
                              <a href="{{ URL::to('payrollReports/selectRelief') }}"><i class="fa fa-file fa-fw"></i>Relief Report</a>
                            </li>  
                            <li>
                             <a href="{{ URL::to('payrollReports/selectDeduction') }}"><i class="fa fa-file fa-fw"></i>Deduction Report</a>     
                            </li> 
                        </ul>
                    </li> 


                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open fa-fw"></i>Statutory Reports <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li>
                                <a href="{{ URL::to('payrollReports/selectNssfPeriod') }}"><i class="fa fa-file fa-fw"></i>NSSF Returns</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payrollReports/selectNhifPeriod') }}"><i class="fa fa-file fa-fw"></i>NHIF Returns</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payrollReports/selectPayePeriod') }}"><i class="fa fa-file fa-fw"></i>PAYE Returns</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('itax/download') }}"><i class="fa fa-file fa-fw"></i>Download Itax Template</a>
                            </li>
                        </ul>
                    </li>

                    <?php
                      $organization = Organization::find(Confide::user()->organization_id);
                      $pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pdate<0 && $organization->payroll_license_key ==1)
                       <h4 style="color:red">
                       Your annual support license for payroll product has expired!!!....
                       Please upgrade your license by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif     
                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->