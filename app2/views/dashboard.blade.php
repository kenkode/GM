@extends('layouts.front')

{{ HTML::script('media/jquery-1.12.0.min.js') }}
{{ HTML::script('js/jquery.cookie.js') }}

<script type="text/javascript">
 $(document).ready(function(){
 $('.logout').on('click', function() {
    $.removeCookie('visited',null, {path: '/' });
 });
});
</script>

{{ HTML::script('js/jquery.cookie.js') }}

{{ HTML::style('css/popup.css') }}

@section('content')

<style type="text/css">
  li #general:before,li #company:before,li #prefs:before,li #employee:before,
  li #bank:before,li #payroll:before,li #reports:before,li #leaves:before,
  li #payrollsettings:before,li #emprep:before,li #leavereport:before,
  li #advance:before,li #payrep:before,li #statutory:before{
      background-image: url("{{asset('public/uploads/images/collapsed.png')}}");
      margin-right: 4px;
      margin-left: -10px;
  }
  ul {
      list-style-type:none
  }

    div.row.image{
    	padding-top: 80px !important;
    }
  .main_dashboard{
    background-image: url({{ URL::asset('site/img/slides/bg/001.jpg') }});
    height: 70%;
    text-align: center;
    background-position: center;
  }

  .main_dashboard img{
    /*width: 50%;*/
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    color: #E7E7E7;
  }

</style>

   

@if (Session::get('notice'))
    <div class="alert alert-info">{{ Session::get('notice') }}</div>
@endif
                  
{{ HTML::script('js/scripts.js') }}

@if (Session::has('flash_message'))
  <div class="alert alert-success">
    {{ Session::get('flash_message') }}
  </div>
@endif

@if (Session::has('delete_message'))
  <div class="alert alert-danger">
    {{ Session::get('delete_message') }}
  </div>
@endif



<div class="row image">

  <div class="col-lg-12 main_dashboard">
    <!--<div class="main_dashboard">-->
      <img src="{{ URL::asset('site/img/xara.jpg') }}" width="50%" alt="Xara Financials">
    <!--</div>-->
  </div>
</div>

@stop
