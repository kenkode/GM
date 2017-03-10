@extends('layouts.css')
@section('content')
<br/>
<div class="row">
	<div class="col-lg-12">
    <h3>
      {{$organization->name}} Investments
    </h3>
    <hr>
  </div>	
</div>
<div class="row">
	<div class="col-lg-12">
        @if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    <div class="panel panel-default">
      <div class="panel-heading">
          <p>
              <a href="{{ URL::to('saccoinvestments/create') }}" class="btn btn-success">
                New Sacco Investment
              </a>
          </p>
        </div>
        <div class="panel-body">
      <table id="users" class="table table-condensed table-bordered table-responsive table-hover">
      <thead>
        <th>#</th>
        <th>Investment Name</th>
        <th>Vendor Name</th>
        <th>Investment Value</th>
        <th>Growth Type</th>
        <th>Growth Rate</th>
        <th></th>
      </thead>
      <tbody>
      
      </tbody>
    </table>
  </div>
  </div>
</div>
@stop