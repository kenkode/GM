@extends('layouts.payroll')

{{ HTML::script('media/jquery-1.12.0.min.js') }}

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

    .main_dashboard{
        background-image: url({{ URL::asset('site/img/slides/bg/001.jpg') }});
        height: 80%;
        text-align: center;
        background-position: center center;
        background-color: #e5e5e5;
        background-blend-mode: overlay;
        //box-shadow: 0px 0px 3px #999;
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





<div class="row">
  <div class="col-lg-12 ">
    <div class="main_dashboard">
      <img src="{{ URL::asset('site/img/xara.jpg') }}" width="50%" alt="Xara Financials">
    </div>
  </div>
</div>  

<div>

@stop
