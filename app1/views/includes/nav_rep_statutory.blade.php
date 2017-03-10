
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('payrollReports/selectNssfPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> NSSF Returns</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('payrollReports/selectNhifPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> NHIF Returns</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('payrollReports/selectPayePeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Paye Returns</a>
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