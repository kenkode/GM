<div class="main_wrapper">
@include('includes.head')
@include('includes.navcbs')
@include('includes.nav_cbs_side')

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