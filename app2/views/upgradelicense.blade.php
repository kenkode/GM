@include('includes.headl')

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


<div class="container">

<div class="row">

	<div class="col-lg-5 col-md-offset-3">

         <div class="login-panel panel panel-default">
                      
                    <div class="panel-body">


                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{asset('images/xara.png')}}" alt="logo" width="50%">

		<br/><br>

      <form onsubmit="return Validate(this);" method="POST" action="{{ URL::to('requestalllicensekey')}}" id="requestform" accept-charset="UTF-8">
   <hr>
    <fieldset>
      
        <div class="form-group">
            <label > <h3>Upload Lisence File</h3></label>
            <input type="file" name="license" id="license" onchange="onFileSelected(event)">
        </div>

        <div class="form-group">
            <textarea style="display:none" class="form-control" id="editor" style="height:280px;font-size:12px" placeholder="" name="key">{{{ Input::old('key') }}}</textarea>
        </div>
        
        <div class="form-actions form-group">
        
          <button id="getfile" type="submit" class="btn btn-primary btn-sm">Display Contents</button>
        </div>


    </fieldset>
    <hr>
</form>
<?php $key = Input::get('key');?>
@if($key != '' || $key != null)
<?php
$str = Organization::binToStr($part[2]); 
 if($str[0] == 'C'){ ?>
<h3><span style="color:red">This license is meant for cbs product! </span></h3>
<?php } else if($str[0] == 'E'){ ?>
<h3><span style="color:red">This license is meant for financials product! </span></h3>
<?php } else if($str[0] == 'P'){ ?>
<h3><span style="color:red">This license is meant for payroll product! </span></h3>
<?php }else if(Organization::binToStr($part[7]) != 'Approved' || Organization::binToStr($part[19]) == 'Pending'){?>
<h3><span style="color:red">Invalid license key! </span></h3>
<?php }else if(file_exists(public_path().'/uploads/license txts/all/'.Organization::binToStr($part[0]).' license '.str_replace("-", "", Organization::binToStr($part[6])).'.license')){?>
<h3><span style="color:red">This license key has already been used! </span></h3>
<?php }else{ ?>
<table class="table table-bordered table-hover">

    <tr>

      <td colspan = '2'> <strong>Requested License Info </strong></td>

    </tr>

     <tr>
      @if($key == '' || $key == null)
     <td> Organization Name </td><td></td>
     @else
      <td> Organization Name </td><td>{{Organization::binToStr($part[0])}}</td>
     @endif
    </tr>

    <tr>
      @if($key == '' || $key == null)
     <td> Module Name </td><td></td>
     @else
      <td> Module Name </td><td>Xara Financials</td>
     @endif
    </tr>

    <tr>
      @if($key == '' || $key == null)
     <td> Licensed Type </td><td></td>
     @else
      <td> License Type </td><td>Commercial</td>
      @endif
    </tr>

    
     @if($key == '' || $key == null)
     <tr>
     <td> Licensed Employees </td><td></td>
     <td> Licensed Members </td><td></td>
     <td> Licensed Clients </td><td></td>
     <td> Licensed Items </td><td></td>
     </tr>
     @else
     <tr>
     @if(Organization::binToStr($part[2]) != '' || Organization::binToStr($part[2]) != null)
      <td> Licensed Employees </td><td><?php echo Organization::binToStr($part[2]) ?></td>
      @endif
      </tr>

      <tr>
     @if(Organization::binToStr($part[3]) != '' || Organization::binToStr($part[3]) != null)
      <td> Licensed Members </td><td><?php echo Organization::binToStr($part[3]) ?></td>
      @endif
      </tr>

      <tr>
     @if(Organization::binToStr($part[4]) != '' || Organization::binToStr($part[4]) != null)
      <td> Licensed Clients </td><td><?php echo Organization::binToStr($part[4]) ?></td>
      @endif
      </tr>

      <tr>
     @if(Organization::binToStr($part[5]) != '' || Organization::binToStr($part[5]) != null)
      <td> Licensed Items </td><td><?php echo Organization::binToStr($part[5]) ?></td>
      @endif
      </tr>

      @endif
      

      <tr>
     @if($key == '' || $key == null)
     <td> End Support Period </td><td></td>
     @else
      <td> End Support Period </td><td><?php echo Organization::binToStr($part[6]) ?></td>
      @endif

    </tr>
    

    
</table>

<form method="POST" action="{{ URL::to('activatedproducts/updatelicense/all')}}" id="requestform" accept-charset="UTF-8"> 
<input class="form-control" placeholder="" type="hidden" name="employees" id="employees" value="{{Organization::binToStr($part[2])}}">
<input class="form-control" placeholder="" type="hidden" name="members" id="members" value="{{Organization::binToStr($part[3])}}">
<input class="form-control" placeholder="" type="hidden" name="employees" id="employees" value="{{Organization::binToStr($part[4])}}">
<input class="form-control" placeholder="" type="hidden" name="employees" id="employees" value="{{Organization::binToStr($part[5])}}">
<input class="form-control" placeholder="" type="hidden" name="period" id="period" value="{{Organization::binToStr($part[6])}}">
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

  </div>
</div>

</div>










