@extends('layouts.organization')
{{HTML::script('media/jquery-1.8.0.min.js') }}


  <script type="text/javascript">
 $(document).ready(function(){
  $('#orgform').submit(function(event){
  /*if($('#name').val().length == 0 && $("#orgform input:checked").length == 0){
    $("html, #organization").animate({ scrollTop: 0 }, "slow");
    $('p').empty();
    $('p').append('<span style="color:red">Please Insert Organization name</span><br>');
    $('p').append('<span style="color:red">Please select one product</span>');
    event.preventDefault();
  }*/if($('#name').val().length == 0){
     $("html, #organization").animate({ scrollTop: 0 }, "slow");
    $('p').empty();
    $('p').append('<span style="color:red">Please Insert Organization name</span><br>');
    event.preventDefault();
  }/*else if($("#orgform input:checked").length == 0){
    $("html, #organization").animate({ scrollTop: 0 }, "slow");
    $('p').empty();
    $('p').append('<span style="color:red">Please select one product</span>');
    event.preventDefault();
  }*/
  });

  $('#bank_id').change(function(){
        $.get("{{ url('api/dropdown')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#bbranch_id').empty(); 
            $('#bbranch_id').append("<option>----------------select Bank Branch--------------------</option>");
            $.each(data, function(key, element) {
            $('#bbranch_id').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });
 });
  </script>

@section('content')

<div class="row">
  <div class="col-lg-12">

<button class="btn btn-info btn-xs " data-toggle="modal" data-target="#logo">update logo</button> 
&nbsp;&nbsp;&nbsp;
<button class="btn btn-info btn-xs " data-toggle="modal" data-target="#organization">update details</button>

<hr>
</div>  
</div>


<div class="row">
  <div class="col-lg-1">



</div>  

<div class="col-lg-3">

<img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="100%">


</div>  


<div class="col-lg-7 ">

  <table class="table table-bordered table-hover">

    <tr>

      <td> Name</td><td>{{Organization::getOrganizationName()}}</td>

    </tr>

    <tr>

      <td> Email </td><td>{{$organization->email}}</td>

    </tr>

    <tr>

      <td> Phone </td><td>{{$organization->phone}}</td>

    </tr>

    <tr>

      <td>  Website</td><td>{{$organization->website}}</td>

    </tr>

    <tr>

      <td> Address </td><td>{{$organization->address}}</td>

    </tr>

    <tr>

      <td> Kra Pin </td><td>{{$organization->kra_pin}}</td>

    </tr>

    <tr>

      <td> Nssf Number </td><td>{{$organization->nssf_no}}</td>

    </tr>
    
    <tr>

      <td> Nhif Number </td><td>{{$organization->nhif_no}}</td>

    </tr>

    <tr>
      <td> Bank </td><td>{{Bank::getName($organization->bank_id)}}</td>
    </tr>

    <tr>
      <td> Bank Branch </td><td>{{BBranch::getName($organization->bank_branch_id)}}</td>
    </tr>

    <tr>

      <td> Bank Account Number </td><td>{{$organization->bank_account_number}}</td>

    </tr>

    <tr>

      <td> Swift Code </td><td>{{$organization->swift_code}}</td>

    </tr>

   <!--  <tr>

      <td colspan='2' style='text-align:center;'> <strong>Activated Products</strong></td>

    </tr>

    @if($organization->is_payroll_active == 1)
    <tr> <td colspan='2'>Payroll </td> </tr>
    @else
    @endif

    @if($organization->is_erp_active == 1)
    <tr> <td colspan='2'>FINANCIALS </td> </tr>
    @else
    @endif

    @if($organization->is_cbs_active == 1)
    <tr> <td colspan='2'>CBS </td> </tr>
    @else
    @endif -->

  </table>


</div>  



</div>

<div class="row">
  <div class="col-lg-12">


<hr>
</div>  
</div>



<!-- organizations Modal -->
<div class="modal fade" id="organization" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Organization Details</h4>
      </div>
      <div class="modal-body">
       <p style="color:red">Please insert all fields in *</p>

        
        <form method="POST" id="orgform" action="{{{ URL::to('organizations/update/'.$organization->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label> Organization Name <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $organization->name }}">
        </div>
        
        <div class="form-group">
            <label > Organization Phone</label>
            <input class="form-control" placeholder="" type="text" name="phone" id="phone" value="{{ $organization->phone }}">
        </div>

        <div class="form-group">
            <label > Organization Email</label>
            <input class="form-control" placeholder="" type="text" name="email" id="email" value="{{ $organization->email }}">
        </div>

        <div class="form-group">
            <label > Organization Website</label>
            <input class="form-control" placeholder="" type="text" name="website" id="website" value="{{ $organization->website }}">
        </div>

        <div class="form-group">
            <label > Organization Address</label>
            <textarea class="form-control" name="address" id="address" >{{ $organization->address }}</textarea>
           
        </div>

        <div class="form-group">
            <label > Organization KRA Pin</label>
           <input class="form-control" placeholder="" type="text" name="pin" id="pin" value="{{ $organization->kra_pin }}">
           
        </div>

        <div class="form-group">
            <label > Organization Nssf Number</label>
           <input class="form-control" placeholder="" type="text" name="nssf" id="nssf" value="{{ $organization->nssf_no }}">
           
        </div>

        <div class="form-group">
            <label > Organization Nhif Number</label>
           <input class="form-control" placeholder="" type="text" name="nhif" id="nhif" value="{{ $organization->nhif_no }}">
           
        </div>

       
                    <div class="form-group">
                        <label>Bank</label>
                        <select name="bank_id" id="bank_id" class="form-control">
                            <option></option>
                            @foreach($banks_db as $bank)
                            <option value="{{ $bank->id }}"<?= ($organization->bank_id==$bank->id)?'selected="selected"':''; ?>> {{ $bank->bank_name }}</option>
                            @endforeach

                        </select>
                
                    </div>

                      
                     <div class="form-group">
                        <label >Bank Branch</label>
                        <select name="bbranch_id" id="bbranch_id" class="form-control">
                            <option></option>
                            @foreach($bbranches_db as $bbranch)
                            <option value="{{$bbranch->id }}"<?= ($organization->bank_branch_id==$bbranch->id)?'selected="selected"':''; ?>> {{ $bbranch->bank_branch_name }}</option>
                            @endforeach

                        </select>
                
                    </div>

        <div class="form-group">
            <label > Bank Account Number</label>
           <input class="form-control" placeholder="" type="text" name="acc" id="acc" value="{{ $organization->bank_account_number }}">
           
        </div>

        <div class="form-group">
            <label > Swift Code</label>
           <input class="form-control" placeholder="" type="text" name="code" id="code" value="{{ $organization->swift_code }}">
           
        </div>

        <!-- <h4>Activate Products</h4>

        <div class="checkbox">
                        <label>
                          @if($organization->is_payroll_active == 1)
                            <input id="ch" type="checkbox" checked name="payroll_activate" >
                            @else
                            <input id="ch" type="checkbox" name="payroll_activate" >
                            @endif
                             PAYROLL
                        </label>
                    </div>

        <div class="checkbox">
                        <label>
                           @if($organization->is_erp_active == 1)
                            <input id="ch" type="checkbox" checked name="erp_activate" >
                            @else
                            <input id="ch" type="checkbox" name="erp_activate" >
                            @endif
                             FINANCIALS
                        </label>
                    </div>

        <div class="checkbox">
                        <label>
                           @if($organization->is_cbs_active == 1)
                            <input id="ch" type="checkbox" checked name="cbs_activate" >
                            @else
                            <input id="ch" type="checkbox" name="cbs_activate" >
                            @endif
                             CBS
                        </label>
                    </div>
 -->
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
          <button type="submit" id="updorg" class="btn btn-primary btn-sm">Update Details</button>
        </div>

    </fieldset>
</form>
      </div>
    </div>
  </div>
</div>




<!-- logo Modal -->
<div class="modal fade" id="logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Organization Logo</h4>
      </div>
      <div class="modal-body">


        
        <form method="POST" action="{{{ URL::to('organizations/logo/'.$organization->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">
   
    <fieldset>
        <div class="form-group">
            <label > Upload Logo</label>
            <input type="file" name="photo">
        </div>
        
        

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
          <button type="submit"  class="btn btn-primary btn-sm">Update Logo</button>
        </div>

    </fieldset>
</form>
      </div>
    </div>
  </div>
</div>











@stop