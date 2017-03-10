@extends('layouts.organization')
{{HTML::script('media/jquery-1.8.0.min.js') }}
{{HTML::script('js/download.js') }}
<script type="text/javascript">

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

$(document).ready(function() {
$('#generatekey').submit(function(event){
        event.preventDefault();
        $.get("{{ url('generateerplicensekey')}}", 
        { clients: $('#clients').val(),
          items: $('#items').val(),
        }, 
        function(data) {
            $('#key').val(data);
        });
    });
$('#downloaderplicense').click(function(){
   if ($.trim($('#key').val()).length == 0) {
$('#pkey').empty(); 
$('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>You have to generate the license code first!</span><br>');
e.preventDefault();
}else{
  $('#pkey').empty();
        $.get("{{ url('downloaderplicensekey')}}", 
        { clients: $('#clients').val(),
          items: $('#items').val(), }, 
        function(data) {
        download(data, "{{$organization->name}}"+" financial license.license", "text/plain");
        /*if(data == 1){
          alert("Payroll has been successfully saved in public/uploads/license txts!");
         }else{
          alert("File not saved!");
         }*/
        });
      }
    });

$('#numerp').click(function(){
if ($.trim($('#clients').val()).length == 0 || $.trim($('#items').val()).length == 0) {
$('#pcl').empty();
$('#pcl').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>Please insert all fields in *</span><br>');
e.preventDefault();
}else{
  $('#pcl').empty();  
  e.preventDefault();
}
});

$('#emailerplicense').click(function(){
if ($.trim($('#key').val()).length == 0) {
$('#pkey').empty(); 
$('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>You have to generate the license code first!</span><br>');
e.preventDefault();
}
    $('#pkey').empty();
    $('#pkey').append('<span><strong>Sending.......</strong></span><br>');
        $.get("{{ url('emailerplicensekey')}}", 
        { clients: $('#clients').val(),
          items: $('#items').val(), }, 
        function(data) {
        //alert(data);
        /*if(data == 1){
          alert("Payroll has been successfully saved in public/uploads/license txts!");
         }else{
          alert("File not saved!");
         }*/
         if(data == 0){
          $('#pkey').empty();
          $('#pkey').append('<span style="color:green"><i class="glyphicon glyphicon-ok fa-fw"></i>Email Sent Successfully!</span><br>');
         }else if(data == 1){
          $('#pkey').empty();
          $('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>Email not sent! Please check your internet connection or configuration! </span><br>');
         }
         return true;
        });
        return true;
    });
});
</script>

@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Request License Key</h3>

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


<table class="table table-bordered table-hover">

    <tr>

      <td colspan = '2'> <strong>Current License Info</strong></td>

    </tr>

    <tr>

      <td> Module Name </td><td>Financials</td>

    </tr>

    <tr>

      <td> License Type </td><td>{{$organization->erp_license_type}}</td>

    </tr>

    <tr>

      <td> Licensed Clients </td><td>{{$organization->erp_client_licensed}}</td>

    </tr>

    <tr>

      <td> Licensed Items </td><td>{{$organization->erp_item_licensed}}</td>

    </tr>

    
</table>
       

		 <form id="generatekey" accept-charset="UTF-8">
   
    <fieldset>
      <p id="pcl"></p>
        <div class="form-group">
            <label for="username">Number of clients <span style="color:red">*</span></label>
            <input class="form-control" onkeypress="return isNumber(event)" placeholder="" type="text" name="clients" id="clients" value="{{{ Input::old('clients') }}}">
        </div>

        <div class="form-group">
            <label for="username">Number of items <span style="color:red">*</span></label>
            <input class="form-control" onkeypress="return isNumber(event)" placeholder="" type="text" name="items" id="items" value="{{{ Input::old('items') }}}">
        </div>
      
        
        <div class="form-actions form-group">
        
          <button id="numerp" type="submit" class="btn btn-primary btn-sm">Generate Key</button>
        </div>

        <h5 style="color:green;font-weight:bold">You can email the license key directly or download and email it later</h5>
        <h4>Generated Key<button id="emailerplicense" style="margin-left:10px" class="btn btn-success btn-sm process" >Email Lisence Key</button><button id="downloaderplicense" style="margin-left:5px" class="btn btn-warning btn-sm process" >Download Lisence Key</button></h4>
        <p id="pkey"></p>
        <div class="form-group">
            <textarea class="form-control" style="height:280px;font-size:12px" placeholder="" name="key" id="key">{{{ Input::old('key') }}}</textarea>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop