 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('dashboard') }}"><i class="fa fa-home fa-fw"></i> Member</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('css/leave') }}"><i class="fa fa-tasks fa-fw"></i> Leave Applications</a>
                    </li>


                     <li>
                        <a href="{{ URL::to('css/balances') }}"><i class="fa fa-list fa-fw"></i> Leave Balances</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('css/subordinateleave') }}"><i class="glyphicon glyphicon-check fa-fw"></i> Approve Leave</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('css/advances') }}"><i class="fa fa-share-square-o fa-fw"></i> Apply Advance</a>
                    </li>
                
                   <li>
                        <a href="{{ URL::to('css/payslips') }}"><i class="fa fa-money fa-fw"></i> Payslips</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('memberloans') }}"><i class="fa fa-tasks fa-fw"></i> Loans</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('guarantorapproval') }}"><i class="fa fa-user fa-fw"></i> Guarantor Approval</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('savings') }}"><i class="glyphicon glyphicon-folder-close fa-fw"></i> Savings</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('member/shares') }}"><i class="fa fa-money fa-fw"></i> Shares </a>
                    </li>

                    <li>
                        <a href="{{ URL::to('shop') }}"><i class="fa fa-home fa-fw"></i> Shop</a>
                    </li>


                   


                    


                    


                    
                    
                </ul>
                <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pcbs<0 && $organization->cbs_license_key ==1)
                       <h4 style="color:red">
                       Your annual support license for cbs product has expired!!!....
                       Please upgrade your license by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->