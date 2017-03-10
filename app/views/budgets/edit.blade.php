@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Update Budget</h3>

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

		 <form method="POST" action="{{{ URL::to('budgets/update/'.$budget->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Budget Type<span style="color:red">*</span> </label>
            <select name="name" id="name" class="form-control">
                            <option></option>
                            @foreach($expensesettings as $expensesetting)
                            <option value="{{$expensesetting->id }}"<?= ($budget->expensesetting_id==$expensesetting->id)?'selected="selected"':''; ?>> {{ $expensesetting->name }}</option>
                            @endforeach

                        </select>
        </div>

        <div class="form-group">
            <label for="username">Estimated Amount <span style="color:red">*</span> </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{ $budget->amount}}">
        </div>
        </div>

        <div class="form-group">
            <label for="username">Period <span style="color:red">*</span></label>
            <div class="right-inner-addon ">
            <i class="glyphicon glyphicon-calendar"></i>
            <input required class="form-control datepicker60" readonly="readonly" class="form-control" placeholder="" type="text" name="period" id="period" value="{{ $budget->financial_month.'-'.$budget->financial_year}}">
        </div>
        </div>

        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Budget</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop