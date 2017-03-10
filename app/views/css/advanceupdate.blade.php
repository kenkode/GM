@extends('layouts.membercss')
@section('content')

<br><div class="row">
	<div class="col-lg-12">
  <h3>New Advance</h3>

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

		 <form method="POST" action="{{{ URL::to('css/advances/update/'.$advance->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
                        <label for="username">Deduction Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker60" readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{$advance->date}}">
                        </div>
        </div>

         
        <div class="form-group">
        	<label for="username">Type</label><span style="color:red">*</span> :
           <select name="type" class="form-control">
                           <option></option>
                            <option value="Full paycheque"<?= ($advance->type=='Full paycheque')?'selected="selected"':''; ?>> Full paycheque</option>
                            <option value="Fixed"<?= ($advance->type=='Fixed')?'selected="selected"':''; ?>> Fixed Ksh</option>
                        </select>
        </div>

        <div class="form-group">
            <label for="username">Amount <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{$advance->amount}}">
            <script type="text/javascript">
           $(document).ready(function() {
           $('#amount').priceFormat();
           });
           </script>  
        </div>
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Apply</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>

@stop