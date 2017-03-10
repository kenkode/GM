@extends('layouts.erp')
{{ HTML::script('media/jquery-1.12.0.min.js') }}
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Budget</h3>

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

		 <form method="POST" action="{{{ URL::to('budgets') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Budget Type<span style="color:red">*</span> </label>
            <select name="name" class="form-control" required>
                           <option></option>
                            @foreach($expensesettings as $expensesetting)
                            <option value="{{ $expensesetting->id }}"> {{ $expensesetting->name }}</option>
                            @endforeach
                        </select>
        </div>

        <div class="form-group">
            <label for="username">Estimated Amount <span style="color:red">*</span> </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}">
            </div>
            <script type="text/javascript">
           $(document).ready(function() {
           $('#amount').priceFormat();
           });
          </script>
        </div>

         <div class="form-group">
                        <label for="username">Period <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker60" readonly="readonly" placeholder="" type="text" name="period" id="period" value="{{{ Input::old('period') }}}">
                    </div>
       </div>
        
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Budget</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop