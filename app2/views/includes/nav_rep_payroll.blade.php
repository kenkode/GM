
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('payrollReports/selectPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Monthly Payslips</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('payrollReports/selectSummaryPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Payroll Summary</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('payrollReports/selectRemittancePeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Pay Remittance</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('payrollReports/selectEarning') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Earning Report</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('payrollReports/selectAllowance') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Allowance Report</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('payrollReports/selectnontaxableincome') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Non Taxable Income Report</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('payrollReports/selectDeduction') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Deduction Report</a>
                    </li>  

                    
                </ul>
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