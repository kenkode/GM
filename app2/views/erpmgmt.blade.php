@extends('layouts.erp')
@section('content')

<style>

  .main_dashboard{
      background-image: url({{ URL::asset('site/img/slides/bg/001.jpg') }});
      height: 70%;
      text-align: center;
      background-position: center center;
  }

  .main_dashboard img{
      /*width: 50%;*/
      position: relative;
      top: 50%;
      transform: translateY(-50%);
      color: #E7E7E7;
  }

</style>

<div class="row">
    <div class="col-lg-12">
	<div class="main_dashboard">
	    <img src="{{ URL::asset('site/img/xara.jpg') }}" width="50%" alt="Xara Financials">
	</div>
    </div>
</div>

@stop