
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                     <li>
                        <a href="{{'employees'}}" id="HR"><i class="fa fa-users fa-fw"></i>HR</a>
                    </li>

                    <li>
                        <a href="{{'other_earnings'}}" id="payroll"><i class="glyphicon glyphicon-credit-card fa-fw"></i>MANAGE PAYROLL</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('Properties') }}"><i class="fa fa-users fa-fw"></i> Company Property </a>
                    </li>

                    <li>
                        <a href="{{ URL::to('Appraisals') }}"><i class="fa fa-users fa-fw"></i> Employee Appraisal </a>
                    </li>

                    <li>
                        <a href="{{ URL::to('occurences') }}"><i class="fa fa-users fa-fw"></i> Employee Occurence </a>
                    </li>

                    <li>
                        <a target="_blank" href="{{ URL::to('EmployeeForm') }}"><i class="fa fa-file fa-fw"></i> Employee Detail Form </a>
                    </li>

                    <li  >
                    <a  href="{{ URL::to('leavemgmt')}}">
                        <i class="fa fa-list fa-fw"></i>  {{{ Lang::get('messages.nav.leave') }}}
                    </a>
                    
                </li>

                     <li>
                        <a href="{{ URL::to('reports/employees') }}"><i class="fa fa-folder fa-fw"></i> HR Reports </a>
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