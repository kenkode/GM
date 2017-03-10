 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('dashboard') }}"><i class="fa fa-home fa-fw"></i> Home</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('css/leave') }}"><i class="fa fa-tasks fa-fw"></i> Leave Applications</a>
                    </li>


                     <li>
                        <a href="{{ URL::to('css/balances') }}"><i class="fa fa-list fa-fw"></i> Leave Balances</a>
                    </li>

                
                   <li>
                        <a href="{{ URL::to('css/payslips') }}"><i class="fa fa-money fa-fw"></i> Payslips</a>
                    </li>


                   


                    


                    


                    
                    
                </ul>
                <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $psup = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($psup<0 && $organization->payroll_license_key ==1)
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