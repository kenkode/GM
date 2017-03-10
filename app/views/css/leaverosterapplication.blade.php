@extends('layouts.membercss')
{{HTML::script('media/jquery-1.8.0.min.js') }}




<style>

#ncontainer table{border-collapse:collapse;border-radius:25px;width:500px;}
table, td, th{border:1px solid #00BB64;}
#ncontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
tr,#ncontainer input,#ncontainer textarea,#fdate,#edate{height:30px;width:150px;border:1px solid #fff;}
#ncontainer textarea{height:50px; width:150px;border:1px solid #fff;}
#dcontainer #appliedstartdate,#applied_end_date{height:30px; width:150px;border:1px solid #fff;background: #EEE}
#ncontainer input:focus,#dcontainer input#fdate:focus,#dcontainer input#edate:focus,#ncontainer textarea:focus{border:1px solid yellow;} 
.space{margin-bottom: 2px;}
#ncontainer{margin-left:0px;}
.but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
#dcontainer table{border-collapse:collapse;border-radius:25px;width:450px;}
table, td, th{border:1px solid #00BB64;}
#dcontainer input[type=checkbox]{height:30px;width:10px;border:1px solid #fff;}
#dcontainer select{width:170px;}
#dcontainer #days{width:100px;}
#dcontainer textarea{height:50px; width:100px;border:1px solid #fff;}
#dcontainer input:focus,#dcontainer input:focus{border:1px solid yellow;} 
.space{margin-bottom: 2px;}
#dcontainer{margin-left:0px;}
.but{width:270px;background:#00BB64;border:1px solid #00BB64;height:40px;border-radius:3px;color:white;margin-top:10px;margin:0px 0px 0px 290px;}
</style>
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

		 <form method="POST" action="{{{ URL::to('leaverosters/create') }}}" accept-charset="UTF-8">
   
    <fieldset>

        <input type="hidden" name="employee_id" id="employee" value="{{$employee->id}}">

        <div id='dcontainer'>

<table id="docEmp" width="500" border="1" cellspacing="0">
    <tr>
    <th><input class='dcheck_all' type='checkbox' onclick="dselect_all()"/></th>
    <th>#</th>
    <th>Vacation Type</th>
    <th>Start Date</th>
    <th>Include Weekends</th>
    <th>Include Holidays</th>
    <th>Days</th>
    <th>End Date</th>
    </tr>
    <tr>
    <td><input type='checkbox' class='dcase'/></td>
    <td><span id='dsnum'>1.</span></td>
    <td id="f"><select class="form-control" name="leavetype_id[0]" id="leave">
            <option> select vacation type</option>
              @foreach($leavetypes as $leavetype)  
                    <option value="{{$leavetype->id}}">{{$leavetype->name}}</option>
              @endforeach
            </select></td>
    
    
    <td><div class="right-inner-addon">
        <i class="glyphicon glyphicon-calendar"></i>
        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="applied_start_date[0]" id="appliedstartdate" value="">
        </div>
    </td>

   <td><input type="checkbox" name="weekends[0]" id="weekends" value="0">
    </td>

    <td><input type="checkbox" name="holidays[0]" id="holidays" value="0">
    </td>

    <td><input required class="form-control days"  placeholder="" type="text" name="days[0]" id="days" value="">
    </td>

    <td><div class="right-inner-addon">
        <i class="glyphicon glyphicon-calendar"></i>
        <input class="form-control expiry" readonly="readonly" placeholder="" type="text" name="applied_end_date[0]" id="applied_end_date" value="">
        </div>
    </td>
  </tr>
</table>

<button type="button" class='ddelete'>- Delete</button>
<button type="button" class='daddmore'>+ Add More</button>
 
  
</div>

{{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}

<script type="text/javascript">
$(function(){ 

$('body').on('focus',"input.expiry",function(){
  $(this).datepicker({
    format: 'yyyy-mm-dd',
    startDate: '0y',
    autoclose: true
});
});
});
</script>

<script>
$(".ddelete").on('click', function() {
  if($('.dcase:checkbox:checked').length > 0){
  if (window.confirm("Are you sure you want to delete this application(s)?"))
      {
  $('.dcase:checkbox:checked').parents("#docEmp tr").remove();
    $('.dcheck_all').prop("checked", false); 
  dcheck();
}else{
  $('.dcheck_all').prop("checked", false); 
  $('.dcase').prop("checked", false); 
}
}
});
var j=2;
$(".daddmore").on('click',function(){

 $.get("{{ url('api/leavetypes')}}", 
         
        function(data) {
            $('#leavedyn'+(j-1)).empty(); 
            $('#leavedyn'+(j-1)).append("<option value=''>select vacation type</option>");
            $.each(data, function(key, element) {
                
                $('#leavedyn'+(j-1)).append("<option value='" + key +"'>" + element + "</option>");
            });
        });


  count=$('#docEmp tr').length;
    var data="<tr><td><input type='checkbox' class='dcase'/></td><td><span id='dsnum"+j+"'>"+count+".</span></td>";
    data +="<td id='f'><select class='form-control' name='leavetype_id["+(j-1)+"]' id='leavedyn"+j+"'><option> select vacation type</option></select></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' placeholder='' type='text' name='applied_start_date["+(j-1)+"]' id='appliedstartdate"+j+"' value='{{{ Input::old('applied_start_date["+(j-1)+"]') }}}'></div></td><td><input type='checkbox' name='weekends["+(j-1)+"]' id='weekends"+j+"' value='0'></td><td><input type='checkbox' name='holidays["+(j-1)+"]' id='holidays"+j+"' value='0'></td><td><input required class='form-control days'  placeholder='' type='text' name='days["+(j-1)+"]' id='days"+j+"' value='{{{ Input::old('days["+(j-1)+"]') }}}'></td><td><div class='right-inner-addon'><i class='glyphicon glyphicon-calendar'></i><input class='form-control expiry' readonly='readonly' placeholder='' type='text' name='applied_end_date["+(j-1)+"]' id='applied_end_date"+j+"' value='{{{ Input::old('applied_end_date["+(j-1)+"]') }}}'></div></td>";
  $('#docEmp').append(data);

  $('#days'+j).keyup(function(){
   // console.log(j-1);
    //alert($('#weekends').val());
    //console.log()
    var weekends = $('#weekends'+(j-1)).val();
    var holidays = $('#holidays'+(j-1)).val();
      if($('#weekends'+j-1).is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends'+(j-1)).val('1');
      }else{
       weekends = 0;
       $('#weekends'+(j-1)).val('0');
      }
      if($('#holidays'+(j-1)).is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays'+(j-1)).val('1');
      }else{
       holidays = 0;
       $('#holidays'+(j-1)).val('0');
      }
       var date = new Date($("#appliedstartdate"+(j-1)).val()),
           days = parseInt($("#days"+(j-1)).val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date"+(j-1)).val(date.toInputFormat());
        } else {
             
        }


         $.get("{{ url('api/getDaysDynamic')}}", 
         { employee: $('#employee').val(),
           leave: $('#leavedyn'+(j-1)).val(),
           option: $('#days'+(j-1)).val(),
           sdate:$('#appliedstartdate'+(j-1)).val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days"+(j-1)).val())+parseInt(data)));
          $('#days'+(j-1)).val(0);
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
          $('#applied_end_date'+(j-1)).val('');
         }else{
          $('#applied_end_date'+(j-1)).val(data);
         }
         
      });
      
       

    });

    $('#weekends'+j).click(function(){
      var weekends = 1;
      var holidays = $('#holidays'+(j-1)).val();
      if($('#weekends'+(j-1)).is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends'+(j-1)).val('1');
      }else{
       weekends = 0;
       $('#weekends'+(j-1)).val('0');
      }
      if($('#holidays'+(j-1)).is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays'+(j-1)).val('1');
      }else{
       holidays = 0;
       $('#holidays'+(j-1)).val('0');
      }
      //alert($('#weekends').val());
       var date = new Date($("#appliedstartdate"+(j-1)).val()),
           days = parseInt($("#days"+(j-1)).val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date"+(j-1)).val(date.toInputFormat());
        } else {
             
        }

         $.get("{{ url('api/getDaysDynamic')}}", 
         { employee: $('#employee').val(),
           leave: $('#leavedyn'+(j-1)).val(),
           option: $('#days'+(j-1)).val(),
           sdate:$('#appliedstartdate'+(j-1)).val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days"+(j-1)).val())+parseInt(data)));
          $('#days'+(j-1)).val(0);
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
          $('#applied_end_date'+(j-1)).val('');
         }else{
          $('#applied_end_date'+(j-1)).val(data);
         }
         
      });

      
    });

   $('#holidays'+j).click(function(){
    var weekends = $('#weekends'+(j-1)).val();
    var holidays = 1;
      if($('#weekends'+(j-1)).is(":checked")) // "this" refers to the element that fired the event
      {
       weekends = 1;
       $('#weekends'+(j-1)).val('1');
      }else{
       weekends = 0;
       $('#weekends'+(j-1)).val('0');
      }
      if($('#holidays'+(j-1)).is(":checked")) // "this" refers to the element that fired the event
      {
       holidays = 1;
       $('#holidays'+(j-1)).val('1');
      }else{
       holidays = 0;
       $('#holidays'+(j-1)).val('0');
      }
       var date = new Date($("#appliedstartdate"+(j-1)).val()),
           days = parseInt($("#days"+(j-1)).val(), 10);


        date.setDate(date.getDate() - 1);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#applied_end_date"+(j-1)).val(date.toInputFormat());
        } else {
             
        }

         $.get("{{ url('api/getDaysDynamic')}}", 
         { employee: $('#employee').val(),
           leave: $('#leavedyn'+(j-1)).val(),
           option: $('#days'+(j-1)).val(),
           sdate:$('#appliedstartdate'+(j-1)).val(),
           weekends:weekends,
           holidays:holidays
         }, 
         function(data) {
          //alert(data);
         if(data < 0){
          console.log(data);
          alert("Days given exceed assigned leave days! Current employee balance is "+(parseInt($("#days"+(j-1)).val())+parseInt(data)));
          $('#days'+(j-1)).val(0);
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
          $('#applied_end_date'+(j-1)).val('');
         }else{
          $('#applied_end_date'+(j-1)).val(data);
         }
         
      });
     
    });

  j++;
});

function dselect_all() {
  $('input[class=dcase]:checkbox').each(function(){ 
    if($('input[class=dcheck_all]:checkbox:checked').length == 0){ 
      $(this).prop("checked", false); 
    } else {
      $(this).prop("checked", true); 
    } 
  });
}

function dcheck(){
  obj=$('#docEmp tr').find('span');
  $.each( obj, function( key, value ) {
  id=value.id;
  $('#'+id).html(key+1);
  });
  }

</script>
                      
                    

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
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
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
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
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
          $('#weekends'+(j-1)).val(0);
          $('#holidays'+(j-1)).val(0);
          $('#weekends'+(j-1)).prop('checked', false);
          $('#holidays'+(j-1)).prop('checked', false);
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


