@include('includes.headl')

{{HTML::script('media/jquery-1.8.0.min.js') }}

<script type="text/javascript">
$(document).ready(function(){
$('#employees').hide();
$('#members').hide();
$('#Cl').hide();
$('#it').hide();
$('#sub').click(function (e) {
        //check atleat 1 checkbox is checked
        if($(".ch:checked").length == 0){
            alert("Please select atleast one product!");
            //prevent the default form submit if it is not checked
            return false;
        }else if($(".ch:checked").length > 0){
          if($('#payroll').is( ":checked" ) == true && ($('#emp').val() == "" || $('#emp').val() == 0)){
           alert("Please insert number of employees you need for the payroll product!");
           return false;
          }else if($('#cbs').is( ":checked" ) == true && ($('#mem').val() == "" || $('#mem').val() == 0)){
           alert("Please insert number of members you need for the cbs product!");
           return false;
          }else if($('#erp').is( ":checked" ) == true && ($('#clients').val() == "" || $('#clients').val() == 0) && ($('#items').val() == "" || $('#items').val() == 0)){
           alert("Please insert number of clients and items you need for the ERP product!");
           return false;
          }else if($('#erp').is( ":checked" ) == true && ($('#clients').val() == "" || $('#clients').val() == 0)){
           alert("Please insert number of clients you need for the ERP product!");
           return false;
          }else if($('#erp').is( ":checked" ) == true && ($('#items').val() == "" || $('#items').val() == 0)){
           alert("Please insert number of items you need for the ERP product!");
           return false;
          }
        }
    });

$('#payroll').click(function(){
if($(this).is( ":checked" ) == true){
    $('#employees').show();
}else{
    $('#employees').hide();
    $('#emp').val("");
}

});
$('#cbs').click(function(){
if($(this).is( ":checked" ) == true){
    $('#members').show();
}else{
    $('#members').hide();
    $('#mem').val("");
}

});
$('#erp').click(function(){
if($(this).is( ":checked" ) == true){
    $('#Cl').show();
    $('#it').show();
}else{
    $('#Cl').hide();
    $('#clients').val("");
    $('#it').hide();
    $('#items').val("");
}

});
});
</script>


<div class="container" id="organization">

<div class="row">

	<div class="col-lg-5 col-md-offset-3">

         <div class="login-panel panel panel-default">
                      
                    <div class="panel-body">


                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{asset('images/xara.png')}}" alt="logo" width="50%">

		<br/><br>

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        <div class="alert alert-danger">
            <div class="alert">Your trial period is over! Please Fill this form to purchase full product</div>
        </div>
        

        <p id="error" style="color:red"></p>

      <form method="POST" id="licenseform" action="{{{ URL::to('licenseconfirm') }}}" accept-charset="UTF-8">

        <input class="form-control" type="hidden" name="organization_id" id="organization_id" value="{{$organization->id}}">
        <input class="form-control" type="hidden" name="user_id" id="user_id" value="{{$client->id}}">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Organization</label>
            <input class="form-control" placeholder="organization name" type="text" name="organization" id="organization" value="{{$organization->name}}" required>
        </div>

        <hr>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{$client->username}}" required>
        </div>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} </small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="email" name="email" id="email" value="{{$client->email}}" required>
        </div>

        <div class="col-lg-12">
                  <div class="checkbox">
                        <label>
                            <input type="checkbox" class="ch" value="1" name="payroll" id="payroll">
                                Payroll
                        </label>
                    </div>
                  </div>

        <div class="form-group" id="employees">
            <label for="email">Number of Employees</small></label>
            <input class="form-control" placeholder="Number of Employees" type="number" name="employees" id="emp" >
        </div>

        <div class="col-lg-12">
                  <div class="checkbox">
                        <label>
                            <input type="checkbox" class="ch" value="1" name="erp" id="erp" value="1">
                                Financials
                        </label>
                    </div>
                  </div>

        <div class="form-group" id="Cl">
            <label for="email">Number of Clients</small></label>
            <input class="form-control" placeholder="Number of Clients" type="number" name="clients" id="clients" >
        </div>

        <div class="form-group" id="it">
            <label for="email">Number of Items</small></label>
            <input class="form-control" placeholder="Number of Items" type="number" name="items" id="items" >
        </div>

        <div class="col-lg-12">
                  <div class="checkbox">
                        <label>
                            <input type="checkbox" class="ch" value="1" name="cbs" id="cbs">
                                CBS
                        </label>
                    </div>
                  </div>
       
       <div class="form-group" id="members">
            <label for="email">Number of Members </small></label>
            <input class="form-control" placeholder="Number of Members " type="number" name="members" id="mem" value="{{{ Input::old('members') }}}" >
        </div>
        <hr>      
      
        
        <div class="form-actions form-group">
        
          <button id="sub" type="submit" class="btn btn-primary btn-sm">Request License Upgrade</button>
        </div>
       
        <p class="help-block">
            <a href="{{{ URL::to('/upgradelicense') }}}">Renew License (If you have license code)</a>
        </p>

         <div class="form-actions form-group">
        
          <a href="{{{ URL::to('/') }}}">Login</a>
        </div>

    </fieldset>
</form>
		

        </div>
    </div>

  </div>
</div>

</div>










