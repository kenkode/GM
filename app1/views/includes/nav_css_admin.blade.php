 <nav class="navbar-default navbar-static-side" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('memberportal') }}"><i class="fa fa-tags fa-fw"></i> Members</a>
                    </li>

                
                    <li>
                        <a href="{{ URL::to('vendors') }}"><i class="fa fa-shopping-cart fa-fw"></i> Vendors</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('products') }}"><i class="fa fa-barcode fa-fw"></i> Products</a>
                    </li>


                     <li>
                        <a href="{{ URL::to('orders') }}"><i class="fa fa-tags fa-fw"></i> Orders</a>
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