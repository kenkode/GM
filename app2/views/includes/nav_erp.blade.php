
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                  <li>
                    <a href="{{ URL::to('items') }}"><i class="fa fa-barcode fa-fw"></i>Items</a>
                  </li>

                  <li>
                    <a href="{{ URL::to('clients') }}"><i class="fa fa-user fa-fw"></i>Clients / Supplier</a>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-list fa-fw"></i>Orders <i class="fa fa-caret-down"></i></a>
                    <ul class="nav">
                      <li>
                        <a href="{{ URL::to('purchaseorders') }}"><i class="fa fa-list fa-fw"></i>Purchase Orders</a>
                      </li>
                      <li>
                        <a href="{{ URL::to('salesorders') }}"><i class="fa fa-list fa-fw"></i>Sales Orders</a>
                      </li>
                    </ul>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-list fa-fw"></i>Expenses <i class="fa fa-caret-down"></i></a>
                    <ul class="nav">
                      <li>
                        <a href="{{ URL::to('expenses') }}"><i class="fa fa-list fa-fw"></i>Expenses</a>
                      </li>
                      <li>
                        <a href="{{ URL::to('expensesettings') }}"><i class="fa fa-list fa-fw"></i>Expense types</a>
                      </li> 
                    </ul>
                  </li>

                  <li>
                    <a href="{{ URL::to('quotationorders') }}"><i class="fa fa-list fa-fw"></i>Quotation</a>
                  </li>

                  <li>
                    <a href="{{ URL::to('budgets') }}"><i class="fa fa-credit-card fa-fw"></i>Budget</a>
                  </li> 

                  <li>
                    <a href="{{ URL::to('locations') }}"><i class="fa fa-home fa-fw"></i>Stores</a>
                  </li>  

                  <li>
                    <a href="{{ URL::to('stocks') }}"><i class="fa fa-random fa-fw"></i>Stock</a>
                  </li>

                  <li>
                    <a href="{{ URL::to('taxes') }}"><i class="fa fa-list fa-fw"></i>Taxes</a>
                  </li> 

                  <li>
                    <a href="#"><i class="fa fa-list fa-fw"></i>Payments <i class="fa fa-caret-down"></i></a>
                    <ul class="nav">
                      <li>
                        <a href="{{ URL::to('paymentmethods') }}"><i class="fa fa-tasks fa-fw"></i>Payment Methods</a>
                      </li>
                      <li>
                        <a href="{{ URL::to('payments') }}"><i class="fa fa-list fa-fw"></i>Payments</a>
                      </li> 
                    </ul>
                  </li>

                  <li>
                    <a href="{{ URL::to('erpReports') }}"><i class="fa fa-folder-open fa-fw"></i>Reports</a>
                  </li>   

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
                    
                    
                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->
