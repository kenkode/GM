
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('users') }}"><i class="fa fa-user fa-fw"></i> System Users</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('roles') }}"><i class="fa fa-bookmark fa-fw"></i> System Roles</a>
                    </li>

                    
<!--
                    <li>
                        <a href="{{ URL::to('import') }}"><i class="fa fa-upload fa-fw"></i> Bulk Import</a>
                    </li>
-->
                    <li>
                        <a href="{{ URL::to('audits') }}"><i class="fa fa-list fa-fw"></i> Audit Trail</a>
                    </li>
<!--
                    <li>
                        <a href="{{ URL::to('backups') }}"><i class="fa fa-download fa-fw"></i> Backup & Restore</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('license') }}"><i class="fa fa-home fa-fw"></i> Licensing</a>
                    </li>

                    -->

                    
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