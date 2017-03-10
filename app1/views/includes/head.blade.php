<!DOCTYPE html>
<html>

<head>

    <title>Lixnet Technologies</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta content="True" name="HandheldFriendly" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="viewport" content="width=device-width" />

    <title>XARA FINANCIALS</title>

    <!-- Core CSS - Include with every page -->
    
	<!-- Google Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	
	<!-- Due to IE8 inabillity to load multiple font weights from Google Fonts, we need to import them separately -->
	<!--[if lte IE 8]>
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300" /> 
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:700" /> 
	    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:800" />
	<![endif]-->
	
	<!-- Font Awesome -->
	
	{{ HTML::style('site/css/font-awesome.min.css') }}

	{{ HTML::style('site/css/skins/blue.css') }}
	
	{{ HTML::style('site/css/animate.min.css') }}
	
	{{ HTML::style('site/css/nivo-lightbox.css') }}
	
	{{ HTML::style('site/css/default.css') }}
	
	{{ HTML::style('site/plugins/rs-plugin/css/settings.css') }}
	
	{{ HTML::style('site/css/responsive.css') }}
	
	{{ HTML::style('site/css/layout.css') }}
	
	{{ HTML::style('bootstrap/css/bootstrap.min.css') }}
	
	{{ HTML::style('media/css/jquery.dataTables.min.css') }}
	
	{{ HTML::style('datepicker/css/bootstrap-datepicker.css') }}

    	{{ HTML::style('css/popup.css') }}

    	{{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}

    {{ HTML::style('css/bootstrap.min.css') }}
    
    {{ HTML::style('css/blue.css') }}
    
   
   {{ HTML::style('font-awesome/css/font-awesome.css') }}
  

    <!-- Page-Level Plugin CSS - Blank -->

    <!-- SB Admin CSS - Include with every page -->
   
    {{ HTML::style('css/sb-admin.css') }}



    <!-- datatables css -->

    {{ HTML::style('media/css/jquery.dataTables.1.10.11.min.css') }}

    {{ HTML::style('datepicker/css/bootstrap-datepicker.css') }}

    {{ HTML::style('css/buttons.dataTables.min.css') }}

    {{ HTML::style('https://fonts.googleapis.com/css?family=Roboto:300,400') }}

    

    <style type="text/css">

   .right-inner-addon {
    position: relative;
   }
   .right-inner-addon input {
    padding-right: 30px;    
   }
   .right-inner-addon i {
    position: absolute;
    right: 0px;
    padding: 10px 12px;
    pointer-events: none;
   }

   .ui-datepicker {
    padding: 0.2em 0.2em 0;
    width: 550px;
   }

   tfoot {
    display: table-header-group;
   }

   tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
    
    
   </style>


    <!-- jquery scripts with datatable scripts -->

<!-- imports modernizr plugin for detecting browser features -->

{{ HTML::script('js/modernizr.custom.js') }}

         
{{ HTML::script('bootstrap/js/bootstra.min.js') }}
<!--[if IE 8]>
	<link href="../css/ie8.css" rel="stylesheet" />
	<script src="../js/respond.js"></script>	
<![endif]-->

	{{ HTML::script('media/js/jquery.js') }}

    {{ HTML::script('media/js/jquery.dataTables.js') }}

    {{ HTML::script('datepicker/js/bootstrap-datepicker.js') }}

    {{HTML::script('js/price_format.js') }}

    

    {{ HTML::script('js/jquery.cookie.js') }}

    <script type="text/javascript">   
    $(document).ready(function(){        

    var date = new Date();
    var minutes = 120;
    date.setTime(date.getTime() + (minutes * 60 * 1000));

    var visited = $.cookie('visited');
    if (visited == 'yes') {
        $('#popup').hide();
        return false;
    } else {
        $('#overlay-back').fadeIn(500,function(){
            $('#popup').show();
         });
 
         $(".close-image").on('click', function() {
            $('#popup').hide();
            $('#overlay-back').fadeOut(500);
         });
    }
    $.cookie('visited', 'yes', { expires: date  });
 
         $('#overlay-back').fadeIn(500,function(){
            $('#popup').show();
         });
 
         $(".close-image").on('click', function() {
            $('#popup').hide();
            $('#overlay-back').fadeOut(500);
         });

         $('#rlater').on('click', function() {
         $.removeCookie('visited',null, {path: '/' });
         $.cookie('visited', 'yes', { expires: 1});
         $('#popup').hide();
         $('#overlay-back').fadeOut(500);
         });
      });
   </script>

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

    $(document).ready(function() {

    $('#datadash').DataTable({
        "bPaginate": false,
        "bInfo": false,
        "bSort": false,
       
    });

     $('#users tfoot th').each(function () {
        var title1 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title1+'" />' );
    });
 
    // DataTable
    var table1 = $('#users').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table1.columns().every(function () {
        var that1 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that1.search( this.value ).draw();
            
        });
    });

    $('#doc tfoot th').each(function () {
        var title2 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title2+'" />' );
    });
 
    // DataTable
    var table2 = $('#doc').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table2.columns().every(function () {
        var that2 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that2.search( this.value ).draw();
            
        });
    });

    $('#appr tfoot th').each(function () {
        var title3 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title3+'" />' );
    });
 
    // DataTable
    var table3 = $('#appr').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table3.columns().every(function () {
        var that3 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that3.search( this.value ).draw();
            
        });
    });

    
    $('#occ tfoot th').each(function () {
        var title4 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title4+'" />' );
    });
 
    // DataTable
    var table4 = $('#occ').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table4.columns().every(function () {
        var that4 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that4.search( this.value ).draw();
            
        });
    });

    $('#prop tfoot th').each(function () {
        var title5 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title5+'" />' );
    });
 
    // DataTable
    var table5 = $('#prop').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table5.columns().every(function () {
        var that5 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that5.search( this.value ).draw();
            
        });
    });

    $('#mobile tfoot th').each(function () {
        var title6 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title6+'" />' );
    });
 
    // DataTable
    var table6 = $('#mobile').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table6.columns().every(function () {
        var that6 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that6.search( this.value ).draw();
            
        });
    });

    $('#rej tfoot th').each(function () {
        var title7 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title7+'" />' );
    });
 
    // DataTable
    var table7 = $('#rej').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table7.columns().every(function () {
        var that7 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that7.search( this.value ).draw();
            
        });
    });

    $('#amended tfoot th').each(function () {
        var title8 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title8+'" />' );
    });
 
    // DataTable
    var table8 = $('#amended').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table8.columns().every(function () {
        var that8 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that8.search( this.value ).draw();
            
        });
    });

     $('#app tfoot th').each(function () {
        var title9 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title9+'" />' );
    });
 
    // DataTable
    var table9 = $('#app').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table9.columns().every(function () {
        var that9 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that9.search( this.value ).draw();
            
        });
    });
    
    
    //$('#disbursed').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
    

    $('#disb tfoot th').each(function () {
        var title10 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title8+'" />' );
    });
 
    // DataTable
    var table10 = $('#disb').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
    // Apply the search
    table10.columns().every(function () {
        var that8 = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that10.search( this.value ).draw();
            
        });
    });

    //alert('idiot');

    // Setup - add a text input to each footer cell
    $('#dash tfoot th').each(function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    });
 
    // DataTable
    var table = $('#dash').DataTable();
 
    // Apply the search
    table.columns().every(function () {
        var that = this;
 
        $(this.footer()).find('input').on( 'keyup change', function () {
                that.search( this.value ).draw();
            
        });
    });
    });

</script>

<script type="text/javascript">

$(function(){
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    endDate: '+0d',
    autoclose: true,
    orientation: 'auto'
});
});

</script>

<script type="text/javascript">

$(function(){
$('.datepicker3').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    autoclose: true
});
});

</script>

<script type="text/javascript">
$(function(){
$('.datepicker1').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    endDate: '-18y',
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker2').datepicker({
    format: "m-yyyy",
    startView: "months", 
    minViewMode: "months",
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker60').datepicker({
    format: "M-yyyy",
    startView: "months", 
    minViewMode: "months",
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker22').datepicker({
    format: "m-yyyy",
    startView: "months", 
    minViewMode: "months",
    Default: true,
    autoclose: true
});
});
</script>



<script type="text/javascript">
$(function(){
$('.datepicker21').datepicker({
    format: "yyyy-mm-dd",
   
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker4').datepicker({
    format: "yyyy-mm-dd",
    startDate: '0y',
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker42').datepicker({
    format: " yyyy",
    startView: "years", 
    minViewMode: "years",
    autoclose: true
});
});
</script>

<script type="text/javascript">
$(function(){
$('.datepicker43').datepicker({
    format: "yyyy-mm-dd",
    startDate: '-60y',
    endDate: '0y',
    autoclose: true
});
});
</script>

<script type="text/javascript">

$(function(){
$('.datepicker40').datepicker({
    format: 'd/m/yyyy',
    startDate: '-60y',
    endDate: '+0d',
    autoclose: true
});
});

</script>

<script type="text/javascript">
$(function(){ 

$('.expiry').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    autoclose: true
});
});

</script>

</head>

<?php
$organization = Organization::find(Confide::user()->organization_id);
$pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
$pfinancial = (strtotime($organization->erp_support_period)-strtotime(date("Y-m-d"))) / 86400;
$pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;

 if(($pdate>=0 && $pdate<=31 && $organization->payroll_license_key ==1) && ($pfinancial>=0 && $pfinancial<=31  && $organization->erp_license_key == 1) && ($pcbs>=0 && $pcbs<=31  && $organization->cbs_license_key == 1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support license for <strong>all xara financial products</strong> are about to expire!!! Payroll product is remaining <strong>{{$pdate}} day(s)</strong> , financials product is remaining <strong>{{$pfinancial}} day(s)</strong> and cbs product <strong>{{$pcbs}} day(s)</strong>.....Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pdate>=0 && $pdate<=31 && $organization->payroll_license_key ==1) && ($pfinancial>=0 && $pfinancial<=31 && $organization->erp_license_key ==1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support licenses for <strong> payroll and financial products </strong> are about to expire!! Payroll product is remaining <strong>{{$pdate}} day(s)</strong> and financials product is remaining <strong>{{$pfinancial}} day(s)</strong>.....Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pdate>=0 && $pdate<=31 && $organization->payroll_license_key ==1) && ($pcbs>=0 && $pcbs<=31 && $organization->cbs_license_key ==1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support licenses for <strong>payroll and cbs products</strong> are about to expire!! Payroll product is remaining <strong>{{$pdate}} day(s)</strong> and cbs product is remaining <strong>{{$pcbs}} day(s)</strong>...Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pfinancial>=0 && $pfinancial<=31 && $organization->erp_license_key ==1) && ($pcbs>=0 && $pcbs<=31 && $organization->cbs_license_key ==1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support licenses for <strong>financial and cbs products</strong> are is about to expire!! !! Financial product is remaining <strong>{{$pfinancial}} day(s)</strong> and cbs product is remaining <strong>{{$pcbs}} day(s)</strong>...Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pdate>=0 && $pdate<=31 && $organization->payroll_license_key ==1)){?>

<div id="overlay-back"></div>
<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support license for payroll product is remaining <strong>{{$pdate}} day(s)</strong> to expire...Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pfinancial>=0 && $pfinancial<=31 && $organization->erp_license_key ==1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support license for financial product is remaining <strong>{{$pfinancial}} day(s)</strong> to expire...Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else if(($pcbs>=0 && $pcbs<=31 && $organization->cbs_license_key ==1)){?>

<div id="overlay-back"></div>

<div id="popup">
<img src="{{asset('/public/uploads/images/1464101507_close_delete.png') }}" class="close-image" />
<h1>License Notification</h1>
<p>
This is a reminder that your annual support license for cbs product is remaining <strong>{{$pcbs}} day(s)</strong> to expire...Please upgrade your license by clicking on the link below.</p>
<a id="rlater" href="">Remind me Later</a><a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
</div>

<?php }else{ ?>

<?php } ?>
