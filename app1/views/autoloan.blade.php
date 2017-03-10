@extends('layouts.system')
@section('content')

<div class="row">
	<div class="col-lg-1">



</div>	

<div class="col-lg-12">

	@if (Session::get('error'))
            <div class="alert alert-danger">{{{ Session::get('error') }}}</div>
        @endif

        @if (Session::get('notice'))
            <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
        @endif

<p>Bulk Process Savings</p>
<hr>

<br>
</div>	


<div class="col-lg-12 ">

	
<form method="POST" action="{{{ URL::to('automated/autoloan') }}}"  enctype="multipart/form-data">
 

<input type="hidden" name="period" value="{{$period}}" >
 <input type="hidden" name="loanproduct_id" value="{{$loanproductid}}">
		
        <table class="table table-bordered table-condensed table-hover" id="auto">

            <thead>
                <th>Member</th>
                <th>Loan No</th>
                <th>Disbursement Date</th>
                <th>Loan Amount</th>
                <th>Installment Date</th>
                <th>Installment</th>
            </thead>

            <tbody>

            @foreach($loanaccounts as $loanaccount)
            @if(Loantransaction::getLoanBalance($loanaccount) > 10)
                <tr>

                    <td>{{$loanaccount->id}}
                       
                    </td>
                    <td>
                        {{$loanaccount->account_number}}
                        <input type="hidden" name="account[]" value="{{$loanaccount->id}}">

                    </td>
                     <td> {{$loanaccount->date_disbursed}}</td>
                    <td> {{$loanaccount->amount_disbursed}}</td>
                    <td>
                        {{$date}}
                        <input type="hidden" name="date[]" value="{{$date}}">
                    </td>
                    <td>
                        <input type="text" name="amount[]" value="{{ round(Loanaccount::getEMPTacsix($loanaccount), 0)}}">
                    </td>

                </tr>
                @endif
            @endforeach

        </tbody>

        </table>
        
        

        <hr>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm pull-right">Process Loan</button>
        </div>


</form>	

</div>	



</div>






@stop