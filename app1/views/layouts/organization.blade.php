<div class="wrapper">


    <?php
      $organization = Organization::find(Confide::user()->organization_id);
      $pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
      $pfinancial = (strtotime($organization->erp_support_period)-strtotime(date("Y-m-d"))) / 86400;
      $pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;

     if(($pdate<0 && $organization->payroll_license_key ==1) && ($pfinancial<0 && $organization->erp_license_key ==1) && ($pcbs<0 && $organization->cbs_license_key ==1)){?>
      <h4 style="color:red">
        Your annual support licenses for all xara financial products have expired!!!....
        Please upgrade your licenses by clicking on the link below.
      </h4>
    <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
    <hr>
    <?php }?>

<script type="text/javascript">
 $(document).ready(function(){
 $('.logout').on('click', function() {
    $.removeCookie('visited',null, {path: '/' });
 });
});
</script>


@include('includes.head')
@include('includes.nav')

@include('includes.nav_organization')

<div id="page-wrapper">


            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
@include('includes.footer')
</div>