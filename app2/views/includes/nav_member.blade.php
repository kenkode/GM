
<nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                   @if(Confide::user()->user_type != 'teller') 
                    <li>
                        <a href="{{ URL::to('members/create') }}"><i class="glyphicon glyphicon-user fa-fw"></i> New Member</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('members') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>

                    @endif

                    @if(Confide::user()->user_type == 'teller')


                    <li>
                        <a href="{{ URL::to('/') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                    </li>
                    @endif

                    
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