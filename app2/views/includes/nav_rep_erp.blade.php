
 <nav class="navbar-default navbar-static-side" role="navigation" id="wrap">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('erpReports/selectClientsPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Customers / Suppliers</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('erpReports/selectSalesPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Sales</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('erpReports/selectPurchasesPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Purchases</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('erpReports/selectItemsPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Items</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('erpReports/selectExpensesPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Expenses</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('erpReports/paymentmethods') }}" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Payment Methods</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('erpReports/selectPaymentsPeriod') }}" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Payments</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('erpReports/locations') }}" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Stores</a>
                    </li>  


                    <li>
                        <a href="{{ URL::to('erpReports/selectStockPeriod') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Stock Report</a>
                    </li>  

                    <li>
                        <a href="{{ URL::to('erpReports/pricelist') }}" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Pricelist</a>
                    </li>    

                    <li>
                        <a href="{{ URL::to('erpReports/accounts') }}" target="_blank"><i class="glyphicon glyphicon-file fa-fw"></i> Account Balances</a>
                    </li>   

                     <li>
                        <a href="{{ URL::to('erpfinancialreports') }}"><i class="glyphicon glyphicon-file fa-fw"></i> Financial Reports</a>
                    </li>  

                    
                </ul>

                <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pfinancial = (strtotime($organization->erp_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pfinancial<0 && $organization->erp_license_key ==1)
                       <h5 style="color:red">
                       Your annual support license for financials product has expired!!!....
                       Please upgrade your license by clicking on the link below.</h5>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->