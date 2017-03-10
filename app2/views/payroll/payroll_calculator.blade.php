@extends('layouts.payroll')

<?php function asMoney($value){

        return number_format($value, 2);

    }

    ?>

{{HTML::script('media/jquery-1.8.0.min.js') }}

<script type="text/javascript">
$(document).ready(function(){

  $('#grossform').submit(function(event){
        event.preventDefault();
       $.ajax({
                      url     : "{{URL::to('shownet')}}",
                      type    : "POST",
                      dataType: "JSON",
                      async   : false,
                      data    : {
                              'formdata'  : $('#grossform').serialize()
                      }      
       }).done(function(data) {
            //alert(data.gross1);
            $('#gross').val(data.gross);
            $('#paye').val(data.paye);
            $('#nssf').val(data.nssf);
            $('#nhif').val(data.nhif);
            $('#net').val(data.net);
        });
     });


  /*$('#gross').keypress(function(event){
     var keycode = (event.keyCode ? event.keyCode : event.which);
      if(keycode == '13'){
      var gross = $(this).val();

       displaydata(); 

      function displaydata(){
       $.ajax({
                      url     : "{{URL::to('shownet')}}",
                      type    : "POST",
                      async   : false,
                      data    : {
                              'gross'  : gross
                      },
                      success : function(s){
                      
                      }        
       });
       }
    }
    });
*/

      var net = $('#net1').val();

      // displaygross(); 

      
       $('#netform').submit(function(event){
        event.preventDefault();
       $.ajax({
                      url     : "{{URL::to('showgross')}}",
                      type    : "POST",
                      dataType: "JSON",
                      async   : false,
                      data    : {
                              'formdata'  : $('#netform').serialize()
                      }      
       }).done(function(data) {
            //alert(data.gross1);
            $('#gross1').val(data.gross1);
            $('#paye1').val(data.paye1);
            $('#nssf1').val(data.nssf1);
            $('#nhif1').val(data.nhif1);
            $('#net1').val(data.netv);
        });
     });
    });

</script>


@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Payroll Calculator</h3>

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

         
   

      <div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#grosstonet" aria-controls="grosstonet" role="tab" data-toggle="tab">Gross to Net</a></li>
    <li role="presentation"><a href="#nettogross" aria-controls="nettogross" role="tab" data-toggle="tab">Net to Gross</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  

  <div role="tabpanel" class="tab-pane active" id="grosstonet" class="displayrecord">
    <form id="grossform" accept-charset="UTF-8">
    <fieldset>

      <?php
       $a = str_replace( ',', '', Input::get('gross'));
      ?>

       <div class="form-group">
        <label for="username">Gross Pay:</label>
        <div class="input-group">
        <span class="input-group-addon">{{$currency->shortname}}</span>
        @if($a == null || $a == '')
        <input class="form-control" placeholder="" type="text" name="gross" id="gross" value="0.00">
        @else
        <input class="form-control" placeholder="" type="text" name="gross" id="gross" value="{{asMoney($a)}}">
        @endif
       </div>
       </div>                    

        <div class="form-group">
        <label for="username">Paye:</label>
        <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
         <input readonly class="form-control" placeholder="" type="text" name="paye" id="paye" value="{{ Payroll::asMoney(Payroll::payecalc($a))}}">
        </div>
      </div>

        <div class="form-group insts" id="insts">
            <label for="username">NSSF: </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input readonly class="form-control" placeholder="" type="text" name="nssf" id="nssf" value="{{Payroll::asMoney(Payroll::nssfcalc($a))}}">
        </div>
      </div>

        <div class="form-group">
            <label for="username">NHIF: <span style="color:red">*</span> </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            <input readonly class="form-control" placeholder="" type="text" name="nhif" id="nhif" value="{{Payroll::asMoney(Payroll::nhifcalc($a))}}">
           </div>
        </div>
        
        <div class="form-group">
        <label for="username">Net:</label>
        <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
         <input readonly class="form-control" placeholder="" type="text" name="net" id="net" value="{{Payroll::asMoney(Payroll::netcalc($a))}}">
        </div>
      </div>

   

    <div align="right"  class="form-actions form-group">
        
          <button class="btn btn-primary btn-sm process" >Get Net</button>
        </div>

         </fieldset>

        </form>


</div>

 

<div role="tabpanel" class="tab-pane" id="nettogross">
  <form method="POST" id="netform" accept-charset="UTF-8">
    <fieldset>

       <?php
       $a = str_replace( ',', '', Input::get('net1'));
      ?>

       <div class="form-group">
        <label for="username">Gross Pay:</label>
        <div class="input-group">
          <span class="input-group-addon">{{$currency->shortname}}</span>
         @if($a == null || $a == '')
        <input class="form-control" readonly placeholder="" type="text" name="gross1" id="gross1" value="0.00">
        @else
        <input class="form-control" readonly placeholder="" type="text" name="gross1" id="gross1" value="{{ asMoney($gross)}}">
        @endif
       </div>
       </div>                    

        <div class="form-group">
        <label for="username">Paye:</label>
        <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
         @if($a == null || $a == '')
        <input readonly class="form-control" placeholder="" type="text" name="paye1" id="paye1" value="0.00">
        @else
         <input readonly class="form-control" placeholder="" type="text" name="paye1" id="paye1" value="{{ asMoney($paye1)}}">
         @endif
        </div>
      </div>

        <div class="form-group insts" id="insts">
            <label for="username">NSSF: </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            @if($a == null || $a == '')
        <input readonly class="form-control" placeholder="" type="text" name="nssf1" id="nssf1" value="0.00">
        @else
            <input readonly class="form-control" placeholder="" type="text" name="nssf1" id="nssf1" value="{{asMoney($nssf1)}}">
             @endif
        </div>
      </div>

        <div class="form-group">
            <label for="username">NHIF: <span style="color:red">*</span> </label>
            <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
            @if($a == null || $a == '')
        <input readonly class="form-control" placeholder="" type="text" name="nhif1" id="nhif1" value="0.00">
        @else
            <input readonly class="form-control" placeholder="" type="text" name="nhif1" id="nhif1" value="{{asMoney($nhif1)}}">
            @endif
        </div>
      </div>
        
        <div class="form-group">
        <label for="username">Net:</label>
        <div class="input-group">
            <span class="input-group-addon">{{$currency->shortname}}</span>
          @if($a == null || $a == '')
        <input class="form-control" placeholder="" type="text" name="net1" id="net1" value="0.00">
        @else
        <input class="form-control" placeholder="" type="text" name="net1" id="net1" value="{{asMoney($a)}}">
        @endif
       </div> 
        </div>

    
    <div align="right"  class="form-actions form-group">
        
          <button class="btn btn-primary btn-sm process" >Get Gross</button>
        </div>
        </fieldset>

        </form>
</div>


  </div>

</div>

</div>

</div>

@stop