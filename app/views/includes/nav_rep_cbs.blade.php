
 <nav class="navbar-default navbar-static-side" role="navigation" id="wrap">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                   <li>
                        <a href="{{ URL::to('reports') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Member Reports</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('savingreports') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Saving Reports</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('loanreports') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Loan Reports</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('financialreports') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Financial Reports</a>
                    </li>
 

                    
                </ul>

                <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pcbs<0 && $organization->cbs_license_key ==1)
                       <h5 style="color:red">
                       Your annual support license for cbs product has expired!!!....
                       Please upgrade your license by clicking on the link below.</h5>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->