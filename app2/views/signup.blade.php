@include('includes.headl')

{{HTML::script('media/jquery-1.8.0.min.js') }}


<div class="container">

<div class="row">

    <div class="col-lg-5 col-md-offset-3">

         <div class="login-panel panel panel-default">
                      
                    <div class="panel-body">


                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{asset('images/xara.png')}}" alt="logo" width="50%">

        <br/><br>

      <form method="POST" id="signupform" action="{{{ URL::to('users/signup') }}}" accept-charset="UTF-8">

        <input class="form-control" type="hidden" name="user_type" id="user_type" value="admin">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Organization</label>
            <input class="form-control" placeholder="organization name" type="text" name="organization" id="organization" value="{{{ Input::old('organization') }}}" required>
        </div>

        <hr>
        
       
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}" required>
        </div> 
      
        <div class="form-group">
            <label for="email">Phone Number: </small></label>
            <input class="form-control" placeholder="Phone Number" type="text" name="phone" id="phone" value="{{{ Input::old('phone') }}}" required>
        </div>
        
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} </small></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="email" name="email" id="email" value="{{{ Input::old('email') }}}" required>
        </div>
        <div class="form-group">
            <label for="email">Country </small></label>
            <input class="form-control" placeholder="Country" type="text" readonly name="country" id="country" value="Kenya" required>
        </div>

        <div class="form-group">
            <label for="email">County </label>
            <select name="county" required class="form-control" >
                <option value="Baringo">Baringo</option>
                <option value="Bomet">Bomet</option>
                <option value="Bungoma">Bungoma</option>
                <option value="Busia">Busia</option>
                <option value="Elgeyo Marakwet">Elgeyo Marakwet</option>
                <option value="Embu">Embu</option>
                <option value="Garissa">Garissa</option>
                <option value="Homa bay">Homa bay</option>
                <option value="Isiolo">Isiolo</option>
                <option value="Kajiado">Kajiado</option>
                <option value="Kakamega">Kakamega</option>
                <option value="Kericho">Kericho</option>
                <option value="Kiambu">Kiambu</option>
                <option value="Kilifi">Kilifi</option>
                <option value="Kirinyaga">Kirinyaga</option>
                <option value="Kisii">Kisii</option>
                <option value="Kisumu">Kisumu</option>
                <option value="Kitui">Kitui</option>
                <option value="Kwale">Kwale</option>
                <option value="Laikipia">Laikipa</option>
                <option value="Lamu">Lamu</option>
                <option value="Machakos">Machakos</option>
                <option value="Makueni">Makueni</option>
                <option value="Mandera">Mandera</option>
                <option value="Meru">Meru</option>
                <option value="Migori">Migori</option>
                <option value="Marsabit">Marsabit</option>
                <option value="Mombasa">Mombasa</option>
                <option value="Muranga">Muranga</option>
                <option value="Nairobi">Nairobi</option>
                <option value="Nakuru">Nakuru</option>
                <option value="Nandi">Nandi</option>
                <option value="Narok">Narok</option>
                <option value="Nyamira">Nyamira</option>
                <option value="Nyandarua">Nyandarua</option>
                <option value="Nyeri">Nyeri</option>
                <option value="Samburu">Samburu</option>
                <option value="Siaya">Siaya</option>
                <option value="Taita Taveta">Taita Taveta</option>
                <option value="Tana River">Tana River</option>
                <option value="Tharaka Nithi">Tharaka Nithi</option>
                <option value="Trans Nzoia">Trans Nzoia</option>
                <option value="Turkana">Turkana</option>
                <option value="Uasin Gishu">Uasin Gishu</option>
                <option value="Vihiga">Vihiga</option>
                <option value="Wajir">Wajir</option>
                <option value="West Pokot">West Pokot</option>
                
            </select>
        </div>

        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <hr>

        

        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif        
      
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Account</button>
        </div>


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










