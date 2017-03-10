<style type="text/css">
.side {
    margin-left: 160px;
}

</style>

 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="#"><i class="fa fa-credit-card fa-fw"></i>Payroll Management <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('other_earnings') }}"><i class="fa fa-credit-card fa-fw"></i>Earnings</a>
                            <li><a href="{{ URL::to('employee_allowances') }}"><i class="fa fa-credit-card fa-fw"></i>Allowances</a>
                            <li><a href="{{ URL::to('overtimes') }}"><i class="fa fa-credit-card fa-fw"></i>Overtimes</a> 
                            <li><a href="{{ URL::to('employee_deductions') }}"><i class="fa fa-barcode fa-fw"></i>Deductions</a>
                            <li><a href="{{ URL::to('employee_relief') }}"><i class="fa fa-credit-card fa-fw"></i>Relief</a>
                            <li><a href="{{ URL::to('employeenontaxables') }}"><i class="fa fa-credit-card fa-fw"></i>Non-Taxable Income</a></li>
                            <li><a href="{{ URL::to('payrollcalculator') }}"><i class="fa fa-calculator fa-fw"></i>Payroll Calculator</a>
                            <li><a href="{{ URL::to('email/payslip') }}"><i class="fa fa-envelope fa-fw"></i>Email Payslips</a>  
                        </ul>
                    </li> 

                    <li>
                        <a href="#"><i class="fa fa-cogs fa-fw"></i>Process <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li>
                              <a href="{{ URL::to('advance') }}"><i class="fa fa-credit-card fa-fw"></i>Advance Salaries</a>
                            </li>
                            <li>
                              <a href="{{ URL::to('payroll') }}"><i class="fa fa-credit-card fa-fw"></i>Payroll</a>
                            </li>
                        </ul>
                    </li> 

                    <li>
                        <a href="#"><i class="fa fa-folder-open fa-fw"></i>Reports <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li>
                                <a href="{{ URL::to('advanceReports') }}"><i class="fa fa-folder-open fa-fw"></i>Advance Reports</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('payrollReports') }}"><i class="fa fa-folder-open fa-fw"></i>Payroll Reports</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('statutoryReports') }}"><i class="fa fa-folder-open fa-fw"></i>Statutory Reports</a>
                            </li>
                        </ul>
                    </li> 

                    <li>
                      <a href="{{ URL::to('allowances') }}"><i class="glyphicon glyphicon-cog fa-fw"></i>  Payroll Settings</a>
                    </li> 

                    <li>
                        <a href="#"><i class="fa fa-cogs fa-fw"></i>Preferences <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('accounts') }}"><i class="fa fa-cog fa-fw"></i>Accounts Settings</a></li> 
                            <li><a href="{{ URL::to('migrate') }}"><i class="fa fa-random fa-fw"></i>Data Migration</a></li>
                        </ul>
                    </li>
                    
                </ul>

                <br><br>

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
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->
