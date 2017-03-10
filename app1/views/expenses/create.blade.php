@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Expense</h3>

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

		 <form method="POST" action="{{{ URL::to('expenses') }}}" accept-charset="UTF-8">
   
    <fieldset>
      <font color="red"><i>All fields marked with * are mandatory</i></font>
        <div class="form-group">
            <label for="username">Expense Name <span style="color:red">*</span> :</label>
             <select name="name" class="form-control" required>
                           <option></option>
                            @foreach($expensesettings as $expensesetting)
                            <option value="{{ $expensesetting->id }}"> {{ $expensesetting->name }}</option>
                            @endforeach
                        </select>
        </div>

        <div class="form-group">
            <label for="username">Amount <span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}" required>
        </div>

       <div class="form-group">
            <label for="username">Type</label><span style="color:red">*</span> :
           <select name="type" class="form-control" required>
                           <option>.............................Select Expense Type........................</option>
                            <option value="Bill"> Bill</option>
                            <option value="Expenditure"> Expenditure</option>
                        </select>
        </div>

        <div class="form-group">
            <label for="username">Expense Account</label><span style="color:red">*</span> :
           <select name="expense_id" class="form-control" required>
                          <option></option>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                           @if($account->category == 'EXPENSE')
                            <option value="{{$account->id}}">{{$account->name}}</option>
                            @endif
                           @endforeach
                        </select>
        </div>  

        <div class="form-group">
            <label for="username">Asset Account</label><span style="color:red">*</span> :
           <select name="asset_id" class="form-control" required>
                          <option></option>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                           @if($account->category == 'ASSET')
                            <option value="{{$account->id}}">{{$account->name}}</option>
                            @endif
                           @endforeach
                        </select>
        </div>

       <div class="form-group">
                        <label for="username">Date</label><span style="color:red">*</span> :
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('d-M-Y')}}" required>
                        </div>
          </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Expense</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>

@stop