@extends('layouts.main')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
<script type="text/javascript">
$(document).ready(function(){
$('#d').hide();
$('#action').change(function(){
if($(this).val() == "Suspension"){
    $('#d').show();
}else{
    $('#d').hide();
}

});


$('#action option#sus').each(function() {
if (this.selected){
       $('#d').show();
}else{
    $('#d').hide();
}
});

});
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Update Compliance</h3>

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

		 <form method="POST" action="{{{ URL::to('compliance/update/'.$discipline->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
                        <label for="username">Employee <span style="color:red">*</span></label>
                        <select name="employee" class="form-control">
                           <option></option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"<?= ($discipline->employee_id==$employee->id)?'selected="selected"':''; ?>> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                            @endforeach
                        </select>
                
                    </div>     

        <div class="form-group">
            <label for="username">Reason<span style="color:red">*</span> </label>
            <textarea class="form-control" name="reason" id="reason">{{$discipline->reason}}</textarea>
        </div>

        <div class="form-group">
                        <label for="username">Action <span style="color:red">*</span></label>
                        <select name="action" id="action" class="form-control forml">
                            <option></option>
                            <option id="sus" value="Suspension"<?= ($discipline->action=='Suspension')?'selected="selected"':''; ?>>Suspension</option>
                            <option value="Warning"<?= ($discipline->action=='Warning')?'selected="selected"':''; ?>>Warning</option>
                            <option value="Reprimanding"<?= ($discipline->action=='Reprimand')?'selected="selected"':''; ?>>Reprimanding</option>
                            <option value="Termination"<?= ($discipline->action=='Termination')?'selected="selected"':''; ?>>Termination</option>
                        </select>
                
                    </div>
        
        <div class="form-group" id="d">
            <label for="username">Days <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="days" id="days" value="{{$discipline->days}}">
        </div>

        <div class="form-group">
                        <label for="username">Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control allowancedate" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{ $discipline->discipline_date }}">
                        </div>
        </div>

        <script type="text/javascript">
$(function(){ 

$('.allowancedate').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-60y',
    autoclose: true
});
});

</script>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Compliance</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop