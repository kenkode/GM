@extends('layouts.organization')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Email Group</h3>

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

		 <form method="POST" action="{{{ URL::to('emailgroups') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Group <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Input::old('name') }}}">
        </div>

        <div class="form-group">
            <label for="username">Email <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="email" id="email" value="{{{ Input::old('email') }}}">
        </div>

        <div class="form-group col-lg-12">
                      
                      
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_application" id="report_application">
                              Leave Application Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_approved" id="report_approved">
                               Leave Approval Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_rejected" id="report_rejected">
                               Leave Rejection Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_balance" id="report_balance">
                                Leave Balance Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_employee" id="report_employee">
                                Employee on Leave Report
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="report_individual" id="report_individual">
                                Individual Employee Leave Report
                        </label>
                    </div>
                   </div>
        
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Email Group</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop