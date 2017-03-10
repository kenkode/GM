@extends('layouts.organization')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Product Info</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif


<table class="table table-bordered table-hover">

    <tr>

      <td colspan = '2'> <strong>Current License Info</strong></td>

    </tr>

    <tr>

      <td> Module Name </td><td>{{$id}}</td>

    </tr>

    @if($id == 'Payroll')

    <tr>

      <td> License Type </td><td>{{$organization->payroll_license_type}}</td>

    </tr>

    <tr>

      <td> Licensed Employees </td><td>{{$organization->payroll_licensed}}</td>

    </tr>


    @else
    @endif

    @if($id == 'Financials')

    <tr>

      <td> License Type </td><td>{{$organization->erp_license_type}}</td>

    </tr>

    <tr>

      <td> Licensed Clients </td><td>{{$organization->erp_client_licensed}}</td>

    </tr>


    <tr>

      <td> Licensed Items </td><td>{{$organization->erp_item_licensed}}</td>

    </tr>


    @else
    @endif

    @if($id == 'CBS')

    <tr>

      <td> License Type </td><td>{{$organization->cbs_license_type}}</td>

    </tr>

    <tr>

      <td> Licensed Members </td><td>{{$organization->cbs_licensed}}</td>

    </tr>


    @else
    @endif
    
</table>
</div>
</div>
@stop