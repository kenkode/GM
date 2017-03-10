@extends('layouts.membercss')
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

		 <form method="POST" action="{{{ URL::to('leaveapplications') }}}" accept-charset="UTF-8">
   
    <fieldset>

        <input type="hidden" name="employee_id" id="employee" value="{{$employee->id}}">


        <div class="form-group">
            <label for="username">Leave type</label>
            <select class="form-control" name="leavetype_id" id="leave">
            <option> select leave</option>
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
        
          <button type="submit" class="btn btn-primary btn-sm">Submit Application</button>
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


