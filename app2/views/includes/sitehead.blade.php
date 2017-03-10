<head>
<title>Lixnet Technologies</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta content="True" name="HandheldFriendly" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="viewport" content="width=device-width" />

<!--*************************
*							*
*         CSS FILES			*
*							*
************************* -->

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

{{ HTML::style('css/sb-admin.css') }}

{{ HTML::style('site/plugins/rs-plugin/css/settings.css') }}

{{ HTML::style('site/css/responsive.css') }}

{{ HTML::style('site/css/layout.css') }}

{{ HTML::style('bootstrap/css/bootstrap.min.css') }}

{{ HTML::style('media/css/jquery.dataTables.min.css') }}

    	{{ HTML::style('css/popup.css') }}

    {{ HTML::style('datepicker/css/bootstrap-datepicker.css') }}


<!--*************************
*							*
*      JAVASCRIPT FILES	 	*
*							*
************************* -->

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

    
   <script type="text/javascript">

    $(document).ready(function() {


    	$('#users').DataTable();
   
    

    } );

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


</head>
