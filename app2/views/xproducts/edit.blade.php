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
        $.get("{{ url('generatelicensekey')}}", 
        { option: $('#employees').val() }, 
        function(data) {
            $('#key').val(data);
        });
    });

$('#downloadlicense').click(function(e){
  if ($.trim($('#key').val()).length == 0) {
$('#pkey').empty(); 
$('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>You have to generate the license code first!</span><br>');
e.preventDefault();
}else{
  $('#pkey').empty(); 
  e.preventDefault();
        $.get("{{ url('downloadlicensekey')}}", 
        { option: $('#employees').val() }, 
        function(data) {
        download(data, "{{$organization->name}}"+" payroll license.license", "text/plain");
          //stop the browser from following
        /*if(data == 1){
          alert("Payroll has been successfully saved in public/uploads/license txts!");
         }else{
          alert("File not saved!");
         }*/
         
        });
      }
    });

$('#numemp').click(function(){

if ($.trim($('#employees').val()).length == 0) {
$('#pemp').empty(); 
$('#pemp').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>Please insert number of employees!</span><br>');
e.preventDefault();
}else{
  $('#pemp').empty(); 
  e.preventDefault();
}
});

$('#emaillicense').click(function(){

if ($.trim($('#key').val()).length == 0) {
$('#pkey').empty(); 
$('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>You have to generate the license code first!</span><br>');
e.preventDefault();
}
    $('#pkey').empty();
    $('#pkey').append('<span><strong>Sending.......</strong></span><br>');
        $.get("{{ url('emaillicensekey')}}", 
        { option: $('#employees').val() }, 
        function(data) {
        //alert(data);
        /*if(data == 1){
          alert("Payroll has been successfully saved in public/uploads/license txts!");
         }else{
          alert("File not saved!");
         }*/
         if(data == 0){
          alert(data);
          $('#pkey').empty();
          $('#pkey').append('<span style="color:green"><i class="glyphicon glyphicon-ok fa-fw"></i>Email Sent Successfully!</span><br>');
         }else{
          alert(data);
          $('#pkey').empty();
          $('#pkey').append('<span style="color:red"><i class="glyphicon glyphicon-remove fa-fw"></i>Email not sent! Please check your internet connection or configuration! </span><br>');
         }
        });
    });
});
</script>

@section('content')

<script type="text/javascript">

</script>

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

      <td> Module Name </td><td>Payroll</td>

    </tr>

    <tr>

      <td> License Type </td><td>{{$organization->payroll_license_type}}</td>

    </tr>

    <tr>

      <td> Licensed Employees </td><td>{{$organization->payroll_licensed}}</td>

    </tr>

    
</table>
       

		 <form id="generatekey" accept-charset="UTF-8">
   
    <fieldset>
       <p id="pemp"></p>
        <div class="form-group">
            <label for="username">Number of employees <span style="color:red">*</span></label>
            <input class="form-control" onkeypress="return isNumber(event)" placeholder="" type="text" name="employees" id="employees" value="{{{ Input::old('employees') }}}">
        </div>
      
        
        <div class="form-actions form-group">
        
          <button id="numemp" type="submit" class="btn btn-primary btn-sm">Generate Key</button>
        </div>
        

    </fieldset>
</form>
		
        <h5 style="color:green;font-weight:bold">You can email the license key directly or download and email it later</h5>
        <h4>Generated Key<button id="emaillicense" style="margin-left:10px" class="btn btn-success btn-sm process" >Email Lisence Key</button> <button id="downloadlicense" style="margin-left:5px" class="btn btn-warning btn-sm process" >Download Lisence Key</button></h4>
        <p id="pkey"></p>
        <div class="form-group">
            <textarea class="form-control" style="height:280px;font-size:12px" placeholder="" name="key" id="key">{{{ Input::old('key') }}}</textarea>
        </div>

  </div>

</div>


@stop