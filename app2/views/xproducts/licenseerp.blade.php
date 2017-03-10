@extends('layouts.organization')
{{HTML::script('media/jquery-1.8.0.min.js') }}

<script>        
  function onFileSelected(event) {
  var selectedFile = event.target.files[0];
  var reader = new FileReader();

  var result = document.getElementById("editor");

  reader.onload = function(event) {
    result.innerHTML = event.target.result;
  };

  reader.readAsText(selectedFile);
}  

var _validFileExtensions = [".license"];    
function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }
                
                if (!blnValid) {
                    alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }
  
    return true;
} 

</script>

<script type="text/javascript">
$(document).ready(function() {

$('#getinfoform').submit(function(event){
        event.preventDefault();
        $.get("{{ url('generatelicensekey')}}", 
        { option: $('#editor').val() }, 
        function(data) {
            $('#key').val(data);
        });
    });

$('#getfile').click(function(){
var filename = $('input[type=file]').val().split('\\').pop();
$('#fname').val(filename);
});

$('#downloadlicense').click(function(){
        $.get("{{ url('downloadlicensekey')}}", 
        { option: $('#employees').val() }, 
        function(data) {
        //alert(data);
        /*if(data == 1){
          alert("Payroll has been successfully saved in public/uploads/license txts!");
         }else{
          alert("File not saved!");
         }*/
         if(data == 0){
          alert("Email successfully sent!");
         }else{
          alert("Error occurred when sending email check your internet connections!");
         }
         return true;
        });
        return true;
    });

$('#emaillicense').click(function(){
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
          alert("Email successfully sent!");
         }else{
          alert("Error occurred when sending email check your internet connections or email settings!");
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
  <h3>Upload License File</h3>

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
       

		 <form onsubmit="return Validate(this);" method="POST" action="{{ URL::to('requesterplicensekey')}}" id="requestform" accept-charset="UTF-8">
   
    <fieldset>
      
        <div class="form-group">
            <label > Upload Lisence File</label>
            <input type="file" name="license" id="license" onchange="onFileSelected(event)">
        </div>

        <div class="form-group">
            <textarea style="display:none" class="form-control" id="editor" style="height:280px;font-size:12px" placeholder="" name="key">{{{ Input::old('key') }}}</textarea>
        </div>
        
        <div class="form-actions form-group">
        
          <button id="getfile" type="submit" class="btn btn-primary btn-sm">Display Contents</button>
        </div>


    </fieldset>
</form>
<?php $key = Input::get('key');?>
@if($key != '' || $key != null)
<?php
$str = Organization::binToStr($part[2]); 
 if($str[0] == 'C'){ ?>
<h3><span style="color:red">This license is meant for cbs product! </span></h3>
<?php } else if($str[0] == 'P'){ ?>
<h3><span style="color:red">This license is meant for payroll product! </span></h3>
<?php }else if(Organization::binToStr($part[0]) != $organization->name || Organization::binToStr($part[6]) != 'Approved' || Organization::binToStr($part[1]) != $organization->license_code){?>
<h3><span style="color:red">Invalid license key! </span></h3>
<?php }else if(file_exists(public_path().'/uploads/license txts/financial/'.Organization::binToStr($part[0]).' financial license '.str_replace("-", "", Organization::binToStr($part[5])).'.license')){?>
<h3><span style="color:red">This license key has already been used! </span></h3>
<?php }else{ ?>
<table class="table table-bordered table-hover">

    <tr>

      <td colspan = '2'> <strong>Requested License Info </strong></td>

    </tr>

    <tr>
      @if($key == '' || $key == null)
     <td> Module Name </td><td></td>
     @else
      <td> Module Name </td><td>Financials</td>
     @endif
    </tr>

    <tr>
      @if($key == '' || $key == null)
     <td> Licensed Type </td><td></td>
     @else
      <td> License Type </td><td>Commercial</td>
      @endif
    </tr>

    <tr>
     @if($key == '' || $key == null)
     <td> Licensed Clients </td><td></td>
     @else
      <td> Licensed Clients </td><td><?php echo Organization::binToStr($part[3]) ?></td>
      @endif

      <tr>
     @if($key == '' || $key == null)
     <td> Licensed Items </td><td></td>
     @else
      <td> Licensed Items </td><td><?php echo Organization::binToStr($part[4]) ?></td>
      @endif

      <tr>
     @if($key == '' || $key == null)
     <td> End Support Period </td><td></td>
     @else
      <td> End Support Period </td><td><?php echo Organization::binToStr($part[5]) ?></td>
      @endif


    </tr>

    
</table>

<form method="POST" action="{{ URL::to('activatedproducts/updatelicense/ERP')}}" id="requestform" accept-charset="UTF-8"> 
<input class="form-control" placeholder="" type="hidden" name="pcode" id="pcode" value="{{Organization::binToStr($part[2])}}">
<input class="form-control" placeholder="" type="hidden" name="clients" id="clients" value="{{Organization::binToStr($part[3])}}">
<input class="form-control" placeholder="" type="hidden" name="items" id="items" value="{{Organization::binToStr($part[4])}}">
<input class="form-control" placeholder="" type="hidden" name="eperiod" id="eperiod" value="{{Organization::binToStr($part[5])}}">
<input class="form-control" placeholder="" type="hidden" name="fname" id="fname" value="{{$key}}">
<div class="form-actions form-group">
        
          <button type="submit" class="btn btn-success btn-sm">Upgrade License</button>
        </div>
</form>  
<?php } ?> 
@else
@endif




  </div>

</div>


@stop