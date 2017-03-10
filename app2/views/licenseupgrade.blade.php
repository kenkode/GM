@include('includes.headl')

{{HTML::script('media/jquery-1.8.0.min.js') }}



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

        @if (Session::get('notice'))
        <div class="alert alert-danger">
            <div class="alert">{{ Session::get('notice') }}</div>
        </div>
        @endif  

        <p id="error" style="color:red"></p>

      <form method="POST" id="licenseform" action="{{{ URL::to('licenseconfirm') }}}" accept-charset="UTF-8">

        <input class="form-control" type="hidden" name="organization_id" id="organization_id" value="{{$organization->id}}">
        <input class="form-control" type="hidden" name="user_id" id="user_id" value="{{$client->id}}">
   
    <fieldset>
       <div class="form-group">
                        <label for="username">Photo</label><br>
                        <div id="imagePreview"></div>
                        <input class="img" placeholder="" type="file" name="image" id="uploadFile" value="{{{ Input::old('image') }}}">
                    </div>

    </fieldset>
</form>
		

        </div>
    </div>

  </div>
</div>

</div>










