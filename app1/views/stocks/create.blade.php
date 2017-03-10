@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Receive Stock</font></h4>

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

		 <form method="POST" action="{{{ URL::to('stocks') }}}" accept-charset="UTF-8">
        <font color="red"><i>All fields marked with * are mandatory</i></font>

         <div class="form-group">
                        <label for="username">Date<span style="color:red">*</span> :</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{date('Y-m-d')}}" required>
                        </div>
          </div>

   
    <fieldset>
        <div class="form-group">
            <label for="username">Item <span style="color:red">*</span> :</label>
            <select name="item" class="form-control" required>
            <option> select item ... </option>
                @foreach($items as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
                
            </select>
        </div>

        <div class="form-group">
            <label for="username">Store <span style="color:red">*</span> :</label>
            <select name="location" class="form-control" required>
            <option> select store ... </option>
                @foreach($locations as $location)
                <option value="{{$location->id}}">{{$location->name}}</option>
                @endforeach
                
            </select>
        </div>

        <div class="form-group">
            <label for="username">Quantity <span style="color:red">*</span> :</label>
            <input type="text" name="quantity" class="form-control" required>
        </div>

        

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Receive</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>

@stop