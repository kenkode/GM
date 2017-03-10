@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>New Item</font></h4>

<hr>
</div>	
</div>
<font color="red"><i>All fields marked with * are mandatory</i></font>

<div class="row">
	<div class="col-lg-5">

    
		
		 @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

		 <form method="POST" action="{{{ URL::to('items') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Item Name <span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Input::old('name') }}}" required>
        </div>

         <div class="form-group">
            <label for="username">Description:</label>
            <textarea rows="5" class="form-control" name="description" id="description" >{{ Input::old('email_office') }}</textarea>
        </div>

        <div class="radio">
          <label>
              <input type="radio" name="type" id="product" value="product">
                    Product
              </label>
              <br>
              <p>              

        </div>

        <div class="radio">
          <label>
              <input type="radio" name="type" id="service" value="service">
                    Service
              </label>
              <br>
              <p>              

        </div>


        <div class="form-group" id="purchase_price">
        <div class="form-group">
            <label for="username">Purchase Price:</label>
            <input class="form-control" placeholder="" type="text" name="pprice" id="pprice" value="{{{ Input::old('pprice') }}}">
        </div>
        </div>

        <div class="form-group" id="selling_price">
        <div class="form-group">
            <label for="username">Selling price <span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="sprice" id="sprice" value="{{{ Input::old('sprice') }}}" required>
        </div>
        </div>

         
         <script type="text/javascript">
            $(document).ready(function(){
            /*$("#purchase_price").hide();*/            
            $('#product').click(function(){

            if($('#product').is(":checked")){
            $('#product:checked').each(function(){
            
            $("#purchase_price").show();

            $("#selling_price").show(); 

            $("#reorderlevel").show(); 

            $("#store_unit").show();           

            });
            }else{

              $("#purchase_price").hide();

              $("#selling_price").hide(); 
            }
            });



                        
            $('#service').click(function(){

            if($('#service').is(":checked")){
            $('#service:checked').each(function(){
            $("#purchase_price").hide();
            $("#selling_price").show();
            $("#reorderlevel").hide();
            $("#store_unit").hide();              

            });
            }else{

              $("#selling_price").hide();             
              $("#reorderlevel").show();
              $("#store_unit").show();   
            }
            });
            
            });
          </script>
               
        <div class="form-group" id="store_unit">
        <div class="form-group">
            <label for="username">Store Keeping Unit:</label>
            <input class="form-control" placeholder="" type="text" name="sku" id="sku" value="{{{ Input::old('sku') }}}">
        </div>
        </div>

        <div class="form-group">
            <label for="username">Tag Id:</label>
            <input class="form-control" placeholder="" type="text" name="tag" id="tag" value="{{{ Input::old('tag') }}}">
        </div>
        
        <div class="form-group" id="reorderlevel">
        <div class="form-group">
            <label for="username">Reorder Level:</label>
            <input class="form-control" placeholder="" type="text" name="reorder" id="reorder" value="{{{ Input::old('reorder') }}}">
        </div>
        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Item</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>

@stop