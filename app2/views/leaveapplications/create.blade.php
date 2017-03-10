@extends('layouts.leave')

{{HTML::script('media/jquery-1.8.0.min.js') }}

@section('content')
<div class="row">
	<div class="col-lg-12">
 

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

        {{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}
  {{ HTML::script('jquery-ui-1.11.4.custom/jquery-ui.js') }}

  <style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog 
    {
    position: fixed;
    margin-bottom: 850px;
    }


    .ui-dialog-titlebar-close {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
  border: medium none;
}
.ui-dialog-titlebar-close:hover {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
}
    
  </style>

  <script>
  $(function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      type = $( "#type" ),
      days = $( "#days" ),
      allFields = $( [] ).add( type ).add( days ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o,m) {
      if ( o.val().length == 0 || o.val() == '' ) {
        o.addClass( "ui-state-error" );
        updateTips( m );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );

      valid = valid && checkLength( type,"Please insert leave type!" );
 
      valid = valid && checkLength( days,"Please insert days!" );

      valid = valid && checkRegexp( days, /^[0-9]+$/, "Please insert a valid number of days." );

 
      if ( valid ) {

      /* displaydata(); 

      function displaydata(){
       $.ajax({
                      url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }        
       });
       }*/

        $.ajax({
            url     : "{{URL::to('createLeave')}}",
                      type    : "POST",
                      async   : false,
                      data    : {
                              'type'  : type.val(),
                              'days'  : days.val()
                      },
                      success : function(s){
                         $('#leave').append($('<option>', {
                         value: s,
                         text: type.val(),
                         selected:true
                        }));
                      }        
        });
        
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $('#leave').change(function(){
    if($(this).val() == "cnew"){
    dialog.dialog( "open" );
    }
      
    });
  });
  </script>
 
   {{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}

<div id="dialog-form" title="Create new Account">
  <p class="validateTips">Please insert All fields.</p>
 
  <form>
    <fieldset>
      
      <label for="name">Leave type <span style="color:red">*</span></label>
      <input type="text" name="type" id="type" value="" class="text ui-widget-content ui-corner-all">
      <label for="name">Days <span style="color:red">*</span></label>
      <input type="text" name="days" id="days" value="" class="text ui-widget-content ui-corner-all">
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>

		 <form method="POST" action="{{{ URL::to('leaveapplications') }}}" accept-charset="UTF-8">
   
    <fieldset>

        <div class="form-group">
            <label for="username">Employee</label>
            <select class="form-control" name="employee_id" id="employee">
            <option> select employee</option>
              @foreach($employees as $employee)  
                    <option value="{{$employee->id}}">{{$employee->first_name." ".$employee->middle_name." ".$employee->last_name}}</option>
              @endforeach
            </select>
        </div>


        <div class="form-group">
            <label for="username">Leave type</label>
            <select class="form-control" name="leavetype_id" id="leave">
            <option> select leave</option>
            <option value="cnew">Create New</option>
              @foreach($leavetypes as $leavetype)  
                    <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
              @endforeach
            </select>
        </div>


        <div class="form-group">
                        <label for="username">Start Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control datepicker21" readonly="readonly" placeholder="" type="text" name="applied_start_date" id="appliedstartdate" value="{{{ Input::old('applied_start_date') }}}">
                    </div>
       </div>

      <div class="col-lg-4">
                  <div class="checkbox">
                        <label>
                            <input type="checkbox" name="weekends" id="weekends" value="0">
                                Include Weekends
                        </label>
                    </div>
                 </div>

        <div class="col-lg-4">
                  <div class="checkbox">
                        <label>
                            <input type="checkbox" name="holidays" id="holidays" value="0">
                                Include Holidays
                        </label>
                    </div>
                 </div>


       <div class="form-group col-lg-12">
                        <label for="username">Days <span style="color:red">*</span></label>
                        
                        <input required class="form-control days"  placeholder="" type="text" name="days" id="days" value="">
                   
       </div>



       <div class="form-group col-lg-12">
                        <label for="username">End Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input required class="form-control enddate" readonly="readonly" placeholder="" type="text" name="applied_end_date" id="applied_end_date" value="">
                    </div>
       </div>


        

      
        
        <div class="form-actions form-group col-lg-12">
        
          <button type="submit" class="btn btn-primary btn-sm">Create</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


<script type="text/javascript">


$(document).ready(function(){

    $('#days').keyup(function(){
    //alert($('#weekends').val());
    var weekends = $('#weekends').val();
    var holidays = $('#holidays').val();
      if($('#weekends').is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends').val('1');
      }else{
       weekends = 0;
       $('#weekends').val('0');
      }
      if($('#holidays').is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays').val('1');
      }else{
       holidays = 0;
       $('#holidays').val('0');
      }
       var date = new Date($("#appliedstartdate").val()),
           days = parseInt($("#days").val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date").val(date.toInputFormat());
        } else {
             
        }

         $.get("{{ url('api/getDays')}}", 
         { employee: $('#employee').val(),
           leave: $('#leave').val(),
           option: $('#days').val(),
           sdate:$('#appliedstartdate').val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days").val())+parseInt(data)));
          $('#days').val(0);
          $('#applied_end_date').val('');
         }else{
          $('#applied_end_date').val(data);
         }
         
      });
      
       

    });

    $('#weekends').click(function(){
      var weekends = 1;
      var holidays = $('#holidays').val();
      if($('#weekends').is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends').val('1');
      }else{
       weekends = 0;
       $('#weekends').val('0');
      }
      if($('#holidays').is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays').val('1');
      }else{
       holidays = 0;
       $('#holidays').val('0');
      }
      //alert($('#weekends').val());
       var date = new Date($("#appliedstartdate").val()),
           days = parseInt($("#days").val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date").val(date.toInputFormat());
        } else {
             
        }

         $.get("{{ url('api/getDays')}}", 
         { employee: $('#employee').val(),
           leave: $('#leave').val(),
           option: $('#days').val(),
           sdate:$('#appliedstartdate').val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days").val())+parseInt(data)));
          $('#days').val(0);
          $('#applied_end_date').val('');
         }else{
          $('#applied_end_date').val(data);
         }
         
      });

      
    });

   $('#holidays').click(function(){
    var weekends = $('#weekends').val();
    var holidays = 1;
      if($('#weekends').is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends').val('1');
      }else{
       weekends = 0;
       $('#weekends').val('0');
      }
      if($('#holidays').is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays').val('1');
      }else{
       holidays = 0;
       $('#holidays').val('0');
      }
       var date = new Date($("#appliedstartdate").val()),
           days = parseInt($("#days").val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date").val(date.toInputFormat());
        } else {
             
        }

         $.get("{{ url('api/getDays')}}", 
         { employee: $('#employee').val(),
           leave: $('#leave').val(),
           option: $('#days').val(),
           sdate:$('#appliedstartdate').val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days").val())+parseInt(data)));
          $('#days').val(0);
          $('#applied_end_date').val('');
         }else{
          $('#applied_end_date').val(data);
         }
         
      });
     
    });



    //From: http://stackoverflow.com/questions/3066586/get-string-in-yyyymmdd-format-from-js-date-object
    Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };


});



</script>


@stop


