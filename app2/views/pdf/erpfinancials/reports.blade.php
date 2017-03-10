@extends('layouts.erp_ports')
{{ HTML::style('bootstrap-select-master/dist/css/bootstrap-select.css') }}
{{ HTML::script('media/jquery-1.12.0.min.js') }}
{{ HTML::script('bootstrap-select-master/dist/js/bootstrap-select.js') }}
@section('content')
<br/>

<script type="text/javascript">
$(document).ready(function(){
$('.per2').hide();
$('#sel').change(function(){
if($(this).val() == "budget"){
    $('.per2').show();
    $('.per1').hide();
}else{
    $('.per1').show();
    $('.per2').hide();
}
});
});
</script>



<div class="row">
  <div class="col-lg-12">
  <h3> Financial Reports</h3>

<hr>
</div>  
</div>


<div class="row">
  <div class="col-lg-5">

   <form target="blank" method="post" action="{{URL::to('reports/financials')}}">


      <div class="form-group">
            <label for="username">Report</label>
             <select id="sel" class="form-control selectpicker" name="report_type" data-live-search="true">
                <option value="">select report</option>
                <option>--------------------------</option>
                <option value="balancesheet">Balance Sheet</option>
                <option value="income">Income Statement</option>
                <option value="trialbalance">Trial Balance</option>
                <!--<option value="cashflowstatement">Cash Flow Statement</option>-->
                <option value="budget">Budget</option>
            </select>
            
        </div>



       <div class="form-group per1">
                        <label for="username">As at Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker43" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ Input::old('date') }}}">
                    </div>
        </div>

        <div class="per2">
        <div class="form-group">
                        <label for="username">Year <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker42" readonly="readonly" placeholder="" type="text" name="period" id="period" value="{{{ Input::old('period') }}}">
                    </div>
        </div>

         <div class="form-group">
                        <label for="username">Download as: <span style="color:red">*</span></label>
                        <select name="format" class="form-control">
                            <option value="excel"> Excel</option>
                            <option selected value="pdf"> PDF</option>
                        </select>
                
            </div>

            </div>

        <div class="form-actions form-group">

          <button type="submit" class="btn btn-primary btn-sm">View Report</button> 
        </div>


   </form>

  </div>

</div>



@stop