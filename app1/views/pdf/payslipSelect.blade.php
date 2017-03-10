@extends('layouts.portspay')

{{HTML::script('media/jquery-1.8.0.min.js') }}

<script type="text/javascript">
$(document).ready(function() {

    $('#branchid').change(function(){
        $.get("{{ url('api/branchemployee')}}", 
        { option: $(this).val(),
          deptid: $('#departmentid').val()
         }, 
        function(data) {
            $('#employeeid').empty(); 
            $('#employeeid').append("<option value='All'>All</option>");
            $.each(data, function(key, element) {
                
                $('#employeeid').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });

    $('#departmentid').change(function(){
        $.get("{{ url('api/deptemployee')}}", 
        { option: $(this).val(),
          bid: $('#branchid').val()
        }, 
        function(data1) {
            $('#employeeid').empty(); 
            $('#employeeid').append("<option value='All'>All</option>");
            $.each(data1, function(key, element) {
                $('#employeeid').append("<option value='" + key +"'>" + element + "</option>");
            });
        });
    });

  

});
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Select Period</h3>

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
        
        @if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif

		 <form target="_blank" method="POST" action="{{URL::to('payrollReports/payslip')}}" accept-charset="UTF-8">
   
    <fieldset>

        <div class="form-group">
                        <label for="username">Period <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker2" readonly="readonly" placeholder="" type="text" name="period" id="period" value="{{{ Input::old('period') }}}">
                    </div>
       </div>

       <div class="form-group">
                        <label for="username">Select Branch: <span style="color:red">*</span></label>
                        <select required name="branchid" id="branchid" class="form-control">
                            <option></option>
                            <option value="All">All</option>
                            @foreach($branches as $branch)
                            <option value="{{$branch->id }}"> {{ $branch->name }}</option>
                            @endforeach

                        </select>
                
        </div>

        <div class="form-group">
                        <label for="username">Select Department: <span style="color:red">*</span></label>
                        <select required name="departmentid" id="departmentid" class="form-control">
                            <option></option>
                            <option value="All">All</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id }}"> {{ $department->department_name }}</option>
                            @endforeach

                        </select>
                
        </div>

           <div class="form-group">
                        <label for="username">Select Employee: <span style="color:red">*</span></label>
                        <select required name="employeeid" id="employeeid" class="form-control">
                            <option></option>
                            

                        </select>
                
        </div>


        <div class="form-group">
                        <label for="username">Download as: <span style="color:red">*</span></label>
                        <select required name="format" class="form-control">
                            <option></option>
                            <option value="excel"> Excel</option>
                            <option value="pdf"> PDF</option>
                        </select>
                
            </div>

        <!--
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" checked name="sel">
                              Select All
                        </label>
                    </div>
        -->
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Select</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop