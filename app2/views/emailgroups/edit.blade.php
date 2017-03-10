@extends('layouts.organization')
@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Update Email Group</h3>

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

         <form method="POST" action="{{{ URL::to('emailgroups/update/'.$group->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Group <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $group->name }}">
        </div>

        <div class="form-group">
            <label for="username">Email <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="email" id="email" value="{{ $group->email }}">
        </div>

        <div class="form-group col-lg-12">
                      
                      
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_application" id="report_application"<?= ($group->report_applications=='1')?'checked="checked"':''; ?>>
                              Leave Application Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_approved" id="report_approved"<?= ($group->report_approved=='1')?'checked="checked"':''; ?>>
                               Leave Approval Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_rejected" id="report_rejected"<?= ($group->report_rejected=='1')?'checked="checked"':''; ?>>
                               Leave Rejection Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_balance" id="report_balance"<?= ($group->report_balances=='1')?'checked="checked"':''; ?>>
                                Leave Balance Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_employee" id="report_employee"<?= ($group->report_employee_on_leave=='1')?'checked="checked"':''; ?>>
                                Employee on Leave Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_individual" id="report_individual"<?= ($group->report_individual=='1')?'checked="checked"':''; ?>>
                                Individual Employee Leave Report
                        </label>
                    </div>
                   </div>
        
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Email Group</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>

<script type="text/javascript">
$( document ).ready(function() {

  $('#report_application').val("{{$group->report_applications}}");
  $('#report_approved').val("{{$group->report_approved}}");
  $('#report_rejected').val("{{$group->report_rejected}}");
  $('#report_balance').val("{{$group->report_balances}}");
  $('#report_individual').val("{{$group->report_individual}}");
  $('#report_employee').val("{{$group->report_employee_on_leave}}");

});
</script>
























@stop