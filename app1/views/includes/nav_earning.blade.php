

 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">

            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('allowances') }}"><i class="glyphicon glyphicon-home fa-fw"></i> Allowances</a>
                    </li>

                     <li>
                        <a href="{{ URL::to('earningsettings') }}"><i class="fa fa-list fa-fw"></i> Earning</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('nontaxables') }}"><i class="fa fa-list fa-fw"></i> Non Taxable Income</a>
                    </li>

                     <li>
                        <a href="{{ URL::to('reliefs') }}"><i class="fa fa-list fa-fw"></i> Relief</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('deductions') }}"><i class="fa fa-list fa-fw"></i> Deductions</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('nssf') }}"><i class="fa fa-list fa-fw"></i> Nssf Rates</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('nhif') }}"><i class="fa fa-list fa-fw"></i> Nhif Rates</a>
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