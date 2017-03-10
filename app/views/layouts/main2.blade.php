<div class="main_wrapper">
@include('includes.head')
@include('includes.navco')

<div id="page-wrapper" style="margin-left:0px">
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