<style type="text/css">
.dropdown-menu {
    //margin-left: 110px;
}
</style>

 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    
                    <li>
                        <a href="{{ URL::to('organizations') }}"><i class="glyphicon glyphicon-home fa-fw"></i> Organization</a>
                    </li>

                     <li>
                        <a href="{{ URL::to('branches') }}"><i class="fa fa-list fa-fw"></i> Organization Branches</a>
                    </li>

                     <li>
                        <a href="{{ URL::to('groups') }}"><i class="fa fa-users fa-fw"></i> Groups</a>
                    </li>


                    <li>
                        <a href="{{ URL::to('currencies') }}"><i class="fa fa-list-alt fa-fw"></i> Currency</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('banks') }}"><i class="fa fa-bank"></i> Banks</a>
                    </li>
                    <li>
                        <a href="{{ URL::to('bank_branch') }}"><i class="fa fa-sliders fa-fw"></i> Bank Branches</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('activatedproducts') }}"><i class="glyphicon glyphicon-inbox"></i>Packages</a>
                    </li>
                    
                    @if(Organization::getActive()->is_payroll_active)

                    <li>
                    <a href="{{ URL::to('deactives') }}"><i class="fa fa-users fa-fw"></i> Activate Employee</a>
                    </li>

                    @else
                    @endif 

                    @if(Organization::getActive()->is_payroll_active)

                    <li>
                    <a href="#">
                        <i class="fa fa-list fa-fw"></i> Reminders <i class="fa fa-caret-right"></i>
                    </a>
                    <ul class="nav">

                    <li>
                        <a href="{{ URL::to('reminderview') }}"><i class="fa fa-list fa-fw"></i> Contract Reminders</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('reminderdoc/indexdoc') }}"><i class="fa fa-file fa-fw"></i>Document Reminders</a>
                    </li>

                    </ul>
                    </li>
                    @else
                    @endif 
                    
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