<!DOCTYPE html>
<html>



<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>XARA </title>

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

    
    {{ HTML::script('media/jquery-1.12.0.min.js') }}

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


</script>

    
   <script type="text/javascript">

    $(document).ready(function() {

    // DataTable
  /*$('#prev').DataTable({
      "sDom": '<"H"lfrp>t<"F"ip>',
       dom: 'Bfrtip',
       buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
*/
  var table = $('#example').DataTable( {
        "sDom": '<"H"lfrp>t<"F"ip>',
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        buttons: true,
        buttons: [
             {
                extend: 'excelHtml5',
                title: 'Payroll Preview for financial period {{$period}}'
            },
            {
                extend: 'pdfHtml5',
                title: 'Payroll Preview for financial period {{$period}}',
                orientation: 'landscape',
                pageSize: 'A1'
            },
            {
                extend: 'print',
                title: 'Payroll Preview for financial period {{$period}}'
            }
        ]
    } );
 
    table.buttons().container()
        .insertBefore( '#example_filter' );


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

    $('#rejected tfoot th').each(function () {
        var title7 = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title7+'" />' );
    });
 
    // DataTable
    var table7 = $('#rejected').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
 
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
    
    
    $('#disbursed').DataTable({"sDom": '<"H"lfrp>t<"F"ip>'});
    

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
    autoclose: true
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
    format: "mmm-yyyy",
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