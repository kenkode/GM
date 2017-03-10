@extends('layouts.erp')

<script type="text/javascript">
 function totalBalance() {
      var instals = document.getElementById("instalments").value;
      var amt = document.getElementById("amount").value;
      var total = (instals * amt);
      document.getElementById("balance").value = total;
}

</script>

@section('content')

<div class="row">
  <div class="col-lg-12">
  <h4><font color='green'>Update Payment</font></h4>

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

     <form method="POST" action="{{{ URL::to('payments/update/'.$payment->id) }}}" accept-charset="UTF-8">
   
    <font color="red"><i>All fields marked with * are mandatory</i></font>
    <fieldset>
        
        

        <div class="form-group">
            <label for="username">Amount Paid<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{$payment->amount_paid}}" required>
        </div>

        <div class="form-group">
            <label for="username">Cash Account</label><span style="color:red">*</span> :
           <select name="cash" class="form-control" required>
                          <option></option>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                           @if($account->category == 'ASSET')
                            <option value="{{$account->id}}"<?= ($payment->cash_account_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
                            @endif
                           @endforeach
                        </select>
        </div>  

        <div class="form-group">
            <label for="username">Receivable Account</label><span style="color:red">*</span> :
           <select name="receivable" class="form-control" required>
                          <option></option>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                           @if($account->category == 'ASSET')
                            <option value="{{$account->id}}"<?= ($payment->receivable_acc_id==$account->id)?'selected="selected"':''; ?>>{{$account->name}}</option>
                            @endif
                           @endforeach
                        </select>
        </div>       

       <!--  <div class="form-group">
            <label for="username">Receipt Number :</label>
            <input class="form-control" placeholder="" type="text" name="receipt" id="receipt" value="{{$payment->receipt_no}}">
        </div> -->

        

         <div class="form-group">
                        <label for="username">Date<span style="color:red">*</span> :</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="pay_date" id="pay_date" value="{{date('d-M-Y',strtotime($payment->date))}}" required>
                        </div>
          </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Payment</button>
        </div>

    </fieldset>
</form>
    

  </div>

</div>

@stop