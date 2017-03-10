<div class="main_wrapper">
@include('includes.head')
@include('includes.hrheader')
@include('includes.nav_rep')

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