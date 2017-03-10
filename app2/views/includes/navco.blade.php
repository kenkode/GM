{{ HTML::script('media/jquery-1.12.0.min.js') }}
{{ HTML::script('js/jquery.cookie.js') }}
{{ HTML::script('media/jquery.dataTables.min.js') }}

    {{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}

    {{HTML::script('js/price_format.js') }}

    {{ HTML::script('js/dataTables.buttons.min.js') }}
    {{ HTML::script('js/buttons.flash.min.js') }}
    {{ HTML::script('js/jszip.min.js') }}
    {{ HTML::script('js/pdfmake.min.js') }}
    {{ HTML::script('js/vfs_fonts.js') }}
    {{ HTML::script('js/buttons.html5.min.js') }}
    {{ HTML::script('js/buttons.print.min.js') }}

<script type="text/javascript">
 $(document).ready(function(){
 $('.logout').on('click', function() {
    $.removeCookie('visited',null, {path: '/' });
 });
});
</script>

<style>
    .lg  {
        position: relative;
        top:40%;
        transform:translateY(-30%); 
    }
</style>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"  >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

		<?php $organization = Organization::find(Confide::user()->organization_id); ?>

                <!--<a class="navbar-brand" href="{{ URL::to('/')}}" > {{Organization::getOrganizationName()}}</a>-->
                <a class="navbar-brand lg"  href="{{ URL::to('/')}}" >
                    <img src="{{ asset('public/uploads/logo/'.$organization->logo) }}" alt="LOGO" height="50px"/>&emsp;
                    <!--<font color='white'><b>{{Organization::getOrganizationName()}}</b></font>-->
                </a>
            </div>
            <!-- /.navbar-header -->

        

            <ul class="nav navbar-top-links navbar-right">

                <li>
                    <a  href="{{ URL::to('dashboard')}}" style="color:blue">{{ Lang::get('messages.nav.home') }}<span>Welcome </span></a>
                </li>

                <!-- SYSTEM DASHBOARD -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-laptop fa-fw"></i> Modules <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                    <?php $organization = Organization::find(Confide::user()->organization_id); ?>
                        @if($organization->is_payroll_active)
                        <li>
                            <a  href="{{ URL::to('hrdashboard')}}">
                                <i class="fa fa-users fa-fw"></i>  {{{ Lang::get('messages.nav.hr') }}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a  href="{{ URL::to('payrolldashboard')}}">
                                <i class="glyphicon glyphicon-credit-card fa-fw"></i>  {{{ Lang::get('messages.nav.payroll') }}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        @endif

                        @if($organization->is_erp_active)
                        <li>
                            <a  href="{{ URL::to('erpmgmt')}}">
                                <i class="fa fa-tasks fa-fw"></i>  {{{ Lang::get('messages.nav.erp') }}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        @endif

                        @if($organization->is_cbs_active)
                        <li>
                            <a  href="{{ URL::to('cbsmgmt')}}">
                                <i class="fa fa-qrcode fa-fw"></i>  {{{ Lang::get('messages.nav.cbs') }}}
                            </a>
                        </li>
                        <li class="divider"></li>
                        @endif
                    </ul>
                </li>

                <!-- ORGANIZATION DROPDOWN -->
                <li class="dropdown" >
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-cogs fa-fw"></i>  {{{ Lang::get('messages.nav.administration') }}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="{{ URL::to('organizations') }}"><i class="fa fa-home fa-fw"></i>  Organization</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ URL::to('accounts')}}"> <i class="fa fa-file fa-fw"></i>  {{{ Lang::get('messages.nav.accounting') }}} </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ URL::to('system') }}"><i class="fa fa-sign-out fa-fw"></i> System</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->


                <!-- /.USER DROPDOWN -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  {{ Confide::user()->username}} <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="{{ URL::to('users/profile/'.Confide::user()->id ) }}"><i class="fa fa-user fa-fw"></i>  Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ URL::to('activatedproducts') }}"><i class="fa fa-tags fa-fw"></i>  Upgrade License</a>
                        </li> 
                        <li class="divider"></li>
                        <li>
                            <a class="logout" href="{{ URL::to('users/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->


            </ul>
            <!-- /.navbar-top-links -->

        </nav>
        <!-- /.navbar-static-top -->
    </div>