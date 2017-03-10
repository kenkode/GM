
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('accounts') }}"><i class="glyphicon glyphicon-user fa-fw"></i> Chart of Accounts</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('journals') }}"><i class="fa fa-barcode fa-fw"></i> Journal Entries</a>
                    </li>


                    <li>
                        <a href="{{ URL::to('journals/create') }}"><i class="fa fa-check fa-fw"></i> Add Journal Entry</a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-university fa-fw"></i> Banking<i class="fa fa-caret-down fa-fw"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('bankAccounts') }}"><i class="fa fa-university fa-fw"></i> Bank Accounts</a></li>
                            <li><a href="{{ URL::to('bankReconciliation/report') }}"><i class="fa fa-file fa-fw"></i> Reconciliation Report</a></li>
                        </ul>
                        
                    </li>

                    
                </ul>

                    <?php
$organization = Organization::find(Confide::user()->organization_id);
$pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
$pfinancial = (strtotime($organization->erp_support_period)-strtotime(date("Y-m-d"))) / 86400;
$pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;

 if(($pdate<0 && $organization->payroll_license_key ==1) && ($pfinancial<0 && $organization->erp_license_key ==1) && ($pcbs<0 && $organization->cbs_license_key ==1)){?>
<h4 style="color:red">
                       Your annual support licenses for all xara financial products have expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
<?php }else if(($pdate<0 && $organization->payroll_license_key ==1) && ($pfinancial<0 && $organization->erp_license_key ==1)){?>

<h4 style="color:red">
                       Your annual support licenses for payroll and financials products have expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>

<?php }else if(($pdate<0 && $organization->payroll_license_key ==1) && ($pcbs<0 && $organization->cbs_license_key ==1)){?>

<h4 style="color:red">
                       Your annual support licenses for payroll and cbs products have expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>

<?php }else if(($pfinancial<0 && $organization->erp_license_key ==1) && ($pcbs<0 && $organization->cbs_license_key ==1)){?>

<h4 style="color:red">
                       Your annual support licenses for financials and cbs products have expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>

<?php }else if($pdate<0 && $organization->payroll_license_key ==1){?>

<h4 style="color:red">
                       Your annual support license for payroll product has expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>

<?php }else if($pfinancial<0 && $organization->erp_license_key ==1){?>

<h4 style="color:red">
                       Your annual support license for financials product has expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>

<?php }else if($pcbs<0 && $organization->cbs_license_key ==1){?>

<h4 style="color:red">
                       Your annual support license for cbs product has expired!!!....
                       Please upgrade your licenses by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
<?php } ?>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->