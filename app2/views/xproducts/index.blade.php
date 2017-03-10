@extends('layouts.organization')
{{HTML::script('media/jquery-1.8.0.min.js') }}
<style type="text/css">
.dropdown-menu {
    margin-left: 0px;
}
</style>
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Activated Products</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    @if (Session::has('flash_message'))

      <div class="alert alert-info">
      {{ Session::get('flash_message') }}
     </div>
    @endif

     @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif

    <div class="panel panel-default">
      <div class="panel-heading">
          <button class="btn btn-success btn-xs " style="height:30px" data-toggle="modal" data-target="#organization">Add Product(s)</button>
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
         <th>Product Name</th>
        <th>License Type</th>
         <th>Lisenced</th>
        <th></th>

      </thead>
      <tbody>
    
    @if($organization->is_payroll_active == 1 && $organization->is_erp_active == 1 && $organization->is_cbs_active == 1)
    <tr>
      <td>1</td>
      <td>Payroll</td>
      <td>{{$organization->payroll_license_type}}</td>
      <td>Lisenced for {{$organization->payroll_licensed}} employees</td>
      <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/edit/Payroll')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/Payroll')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Payroll')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/Payroll')}}" onclick="return (confirm('Are you sure you want to remove payroll product?'))">Remove</a></li>
                  </ul>
              </div>

      </td>

    </tr>

    <tr>
       <td>2</td> 
       <td>FINANCIALS</td>
       <td>{{$organization->erp_license_type}}</td>
       <td>Lisenced for {{$organization->erp_client_licensed}} clients and {{$organization->erp_item_licensed}} items</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                   <li><a href="{{URL::to('activatedproducts/editfinancials/Financial')}}">Request License Key</a></li>  
                    <li><a href="{{URL::to('activatedproducts/license/financial')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Financials')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/financial')}}" onclick="return (confirm('Are you sure you want to remove erp product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>

    <tr>
      <td>3</td> 
      <td>CBS </td> 
      <td>{{$organization->cbs_license_type}}</td>
       <td>Lisenced for {{$organization->cbs_licensed}} members</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editcbs/çbs')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/CBS')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/CBS')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/cbs')}}" onclick="return (confirm('Are you sure you want to remove cbs product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif

    @if($organization->is_payroll_active == 1 && $organization->is_erp_active == 1 && $organization->is_cbs_active == 0)
    <tr>
      <td>1</td>
      <td>Payroll</td>
      <td>{{$organization->payroll_license_type}}</td>
      <td>Lisenced for {{$organization->payroll_licensed}} employees</td>
      <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/edit/Payroll')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/Payroll')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Payroll')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/Payroll')}}" onclick="return (confirm('Are you sure you want to remove payroll product?'))">Remove</a></li>
                  </ul>
              </div>

      </td>

    </tr>

    <tr>
       <td>2</td> 
       <td>FINANCIALS</td>
       <td>{{$organization->erp_license_type}}</td>
       <td>Lisenced for {{$organization->erp_client_licensed}} clients and {{$organization->erp_item_licensed}} items</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editfinancials/Financial')}}">Request License Key</a></li>  
                    <li><a href="{{URL::to('activatedproducts/license/financial')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Financials')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/financial')}}" onclick="return (confirm('Are you sure you want to remove erp product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif

    @if($organization->is_payroll_active == 1 && $organization->is_cbs_active == 1 && $organization->is_erp_active == 0)
    <tr>
      <td>1</td>
      <td>Payroll</td>
      <td>{{$organization->payroll_license_type}}</td>
      <td>Lisenced for {{$organization->payroll_licensed}} employees</td>
      <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/edit/Payroll')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/Payroll')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Payroll')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/Payroll')}}" onclick="return (confirm('Are you sure you want to remove payroll product?'))">Remove</a></li>
                  </ul>
              </div>

      </td>

    </tr>

    <tr>
      <td>2</td> 
      <td>CBS </td> 
      <td>{{$organization->cbs_license_type}}</td>
       <td>Lisenced for {{$organization->cbs_licensed}} members</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editcbs/çbs')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/CBS')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/CBS')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/cbs')}}" onclick="return (confirm('Are you sure you want to remove cbs product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif

    @if($organization->is_erp_active == 1 && $organization->is_cbs_active == 1 && $organization->is_payroll_active == 0)

    <tr>
       <td>1</td> 
       <td>FINANCIALS</td>
       <td>{{$organization->erp_license_type}}</td>
       <td>Lisenced for {{$organization->erp_client_licensed}} clients and {{$organization->erp_item_licensed}} items</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editfinancials/Financial')}}">Request License Key</a></li>  
                    <li><a href="{{URL::to('activatedproducts/license/financial')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Financials')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/financial')}}" onclick="return (confirm('Are you sure you want to remove erp product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>

    <tr>
      <td>2</td> 
      <td>CBS </td> 
      <td>{{$organization->cbs_license_type}}</td>
       <td>Lisenced for {{$organization->cbs_licensed}} members</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editcbs/çbs')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/CBS')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/CBS')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/cbs')}}" onclick="return (confirm('Are you sure you want to remove cbs product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif




    @if($organization->is_payroll_active == 1 && $organization->is_erp_active == 0 && $organization->is_cbs_active == 0)
    <tr>
      <td>1</td>
      <td>Payroll</td>
      <td>{{$organization->payroll_license_type}}</td>
      <td>Lisenced for {{$organization->payroll_licensed}} employees</td>
      <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/edit/Payroll')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/Payroll')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Payroll')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/Payroll')}}" onclick="return (confirm('Are you sure you want to remove payroll product?'))">Remove</a></li>
                  </ul>
              </div>

      </td>

    </tr>
    @else
    @endif

    @if($organization->is_payroll_active == 0 && $organization->is_erp_active == 1 && $organization->is_cbs_active == 0)
    <tr>
       <td>1</td> 
       <td>FINANCIALS</td>
       <td>{{$organization->erp_license_type}}</td>
       <td>Lisenced for {{$organization->erp_client_licensed}} clients and {{$organization->erp_item_licensed}} items</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editfinancials/Financial')}}">Request License Key</a></li>  
                    <li><a href="{{URL::to('activatedproducts/license/financial')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/Financials')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/financial')}}" onclick="return (confirm('Are you sure you want to remove erp product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif

    @if($organization->is_cbs_active == 1 && $organization->is_erp_active == 0 && $organization->is_payroll_active == 0)
    <tr>
      <td>1</td> 
      <td>CBS </td> 
      <td>{{$organization->cbs_license_type}}</td>
       <td>Lisenced for {{$organization->cbs_licensed}} members</td>
       <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" style="margin-left: 0px;">
                    <li><a href="{{URL::to('activatedproducts/editcbs/çbs')}}">Request License Key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/license/CBS')}}">Upgrade License key</a></li> 
                    <li><a href="{{URL::to('activatedproducts/show/CBS')}}">View</a></li>
                    <li><a href="{{URL::to('activatedproducts/remove/cbs')}}" onclick="return (confirm('Are you sure you want to remove cbs product?'))">Remove</a></li>
                  </ul>
              </div>

       </td>
    </tr>
    @else
    @endif


      </tbody>


    </table>
  </div>


  </div>

</div>

<div class="modal fade" id="organization" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Organization Details</h4>
      </div>
      <div class="modal-body">

        
        <form method="POST" id="orgform" action="{{{ URL::to('activatedproducts/create') }}}" accept-charset="UTF-8">
   
    
        <h4>Activate Products</h4>

        <div class="checkbox">
                        <label>
                          @if($organization->is_payroll_active == 0)
                            <input id="ch" type="checkbox" name="payroll_activate" >
                            PAYROLL
                            @else
                            <input id="ch" style="display:none" type="checkbox" name="payroll_activate" >
                            @endif
                             
                        </label>
                    </div>

        <div class="checkbox">
                        <label>
                           @if($organization->is_erp_active == 0)
                            <input id="ch" type="checkbox" name="erp_activate" >
                            FINANCIALS
                            @else
                            <input id="ch" style="display:none" type="checkbox" name="erp_activate" >
                            @endif
                             
                        </label>
                    </div>

        <div class="checkbox">
                        <label>
                           @if($organization->is_cbs_active == 0)
                            <input id="ch" type="checkbox" name="cbs_activate" >
                            CBS
                            @else
                            @endif
                             
                        </label>
                    </div>

        @if($organization->is_cbs_active == 1 && $organization->is_payroll_active == 1 && $organization->is_erp_active == 1)
        <label><h4>All Products Are activated!</h4></label>
        @else
        @endif

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif


        
      </div>
      <div class="modal-footer">
        
        <div class="form-actions form-group">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
          @if($organization->is_payroll_active == 0 || $organization->is_erp_active == 0 || $organization->is_cbs_active == 0)
          <button type="submit" id="updorg" class="btn btn-success btn-sm">Add Product</button>
          @else
          @endif
        </div>

    </fieldset>
</form>
      </div>
    </div>
  </div>
</div>


@stop