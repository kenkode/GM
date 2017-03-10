@extends('layouts.payroll')

<?php

function asMoney($value) {
  return number_format($value, 2);
}

?>

{{HTML::script('media/jquery-1.8.0.min.js') }}


<script type="text/javascript">
document.getElementById("edate").value = '';
 function totalBalance() {
      var p = document.getElementById("period").value;
      var instals = document.getElementById("instalments").value;
      var amt = document.getElementById("amount").value.replace(/,/g,'');
      var total = instals * amt * p;
      total=total.toLocaleString('en-US',{minimumFractionDigits: 2});
      document.getElementById("total").value = total;

}

</script>

<script type="text/javascript">
$(document).ready(function(){
$('#insts').hide();
$('#bal').hide();
$('#formular').change(function(){
if($(this).val() == "Instalments"){
    $('#insts').show();
}else{
    $('#insts').hide();
    $('#instalments').val(1);
    totalBalance();
}

});

});
</script>

<script type="text/javascript">
 
function totalB() {
      var p = document.getElementById("period").value;
      var amt = document.getElementById("amount").value.replace(/,/g,'');
      var total = p * amt ;
      total=total.toLocaleString('en-US',{minimumFractionDigits: 2});
      document.getElementById("total").value = total;

}

</script>

<script type="text/javascript">
$(document).ready(function() {

    $('#employee').change(function(){
        $.get("{{ url('api/pay')}}", 
        { option: $(this).val() }, 
        function(data) {
          console.log(data.replace(/,/g, ''));

          if($('#type').val() == '' || $('#period').val() == ''){
                $('#amount').val(0.00);
                $('#total').val(0.00);
          }else if($('#type').val() == 'Hourly' && $('#period').val() != ''){
                  $('#amount').val(((data.replace(/,/g, ''))/24/30).toFixed(2));
                  $('#total').val((((data.replace(/,/g, ''))/24/30).toFixed(2)*($('#period').val())).toFixed(2));
          }else if($('#type').val() == 'Daily' && $('#period').val() != ''){
                $('#amount').val(((data.replace(/,/g, ''))/30).toFixed(2));
                $('#total').val((((data.replace(/,/g, ''))/30).toFixed(2)*($('#period').val())).toFixed(2));
                }
          $('#type').change(function(){
                if($(this).val() == ''){
                $('#amount').val(0.00);
                }else if($(this).val() == 'Hourly'){
                  $('#amount').val(((data.replace(/,/g, ''))/24/30).toFixed(2));
                }else{
                $('#amount').val(((data.replace(/,/g, ''))/30).toFixed(2));
                }
              
                if($('#period').val() != '' && $(this).val() == 'Hourly'){
                $('#total').val((((data.replace(/,/g, ''))/24/30).toFixed(2)*($('#period').val())).toFixed(2));
                }else if($('#period').val() != '' && $(this).val() == 'Daily'){
                $('#total').val((((data.replace(/,/g, ''))/30).toFixed(2)*($('#period').val())).toFixed(2));
                }
                else{
                $('#total').val(0.00);
                } 
              });
            });
        });
   });
</script>

@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>New Employee Overtime</h3>

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

         <form method="POST" action="{{{ URL::to('overtimes') }}}" accept-charset="UTF-8">
   
    <fieldset>

       <div class="form-group">
                        <label for="username">Employee <span style="color:red">*</span></label>
                        <select name="employee" id="employee" class="form-control">
                           <option></option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"> {{ $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name }}</option>
                            @endforeach
                        </select>
                
                    </div>                    

                    
        <div class="form-group">
                        <label for="username">Type <span style="color:red">*</span></label>
                        <select name="type" id="type" class="form-control">
                            <option></option>
                            <option value="Hourly"> Hourly</option>
                            <option value="Daily"> Daily</option>
                        </select>
                
                    </div>
                    

          <div class="form-group">
            <label for="username">Period Worked <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="period" onkeypress="totalB()" onkeyup="totalB()" id="period" value="{{{ Input::old('period') }}}">
            
        </div>

        <div class="form-group">
                        <label for="username">Formular <span style="color:red">*</span></label>
                        <select name="formular" id="formular" class="form-control forml">
                            <option></option>
                            <option value="One Time">One Time</option>
                            <option value="Recurring">Recurring</option>
                            <option value="Instalments">Instalments</option>
                        </select>
                
                    </div>

        <div class="form-group insts" id="insts">
            <label for="username">Instalments </label>
            <input class="form-control" placeholder="" onkeypress="totalBalance()" onkeyup="totalBalance()" type="text" name="instalments" id="instalments" value="{{{ Input::old('instalments') }}}">
        </div>

        <div class="form-group">
            <label for="username">Amount </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" readonly placeholder="" type="text" name="amount" id="amount" onkeypress="totalBalance()" onkeyup="totalBalance()">
           </div>
        </div>
        
        <div class="form-group">
            <label for="username">Total amount </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" readonly type="text" name="total" id="total" value="{{{ Input::old('total') }}}">
            </div>
        </div>

        <div class="form-group">
                        <label for="username">Overtime Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="odate" id="odate" value="{{{ Input::old('odate') }}}">
                        </div>
        </div>
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Overtime</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>

@stop