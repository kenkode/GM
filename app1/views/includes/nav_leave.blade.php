 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                   
                    <li>
                        <a href="{{ URL::to('leavemgmt') }}"><i class="fa fa-file fa-fw"></i> Vacation Applications</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('leaveamends') }}"><i class="fa fa-edit fa-fw"></i>  Vacations Amended</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('leaveapprovals') }}"><i class="fa fa-check fa-fw"></i>  Vacations Approved</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('leaverejects') }}"><i class="fa fa-barcode fa-fw"></i> Vacations Rejected</a>
                    </li>


                     

                   <li>
                        <a href="{{ URL::to('leavetypes') }}"><i class="fa fa-list fa-fw"></i> Vacation Types</a>
                    </li>
                   

                   <li>
                        <a href="{{ URL::to('holidays') }}"><i class="fa fa-random fa-fw"></i> Holiday Management</a>
                    </li>

                    


                     <li>
                        <a href="{{ URL::to('leaveReports') }}"><i class="fa fa-file fa-fw"></i> Reports</a>
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