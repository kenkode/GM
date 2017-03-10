@include('includes.headl')

<?php $organization = Organization::find(1);?>

<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <div class="login-panel panel panel-default">
                      
                    <div class="panel-body">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="50%">

                        <br>
                        <hr>
                       @if (Session::has('flash_message'))

                      <div class="alert alert-success">
                      {{ Session::get('flash_message') }}
                      </div>
                      @endif

                      @if (Session::has('delete_message'))

                      <div class="alert alert-danger">
                      {{ Session::get('delete_message') }}
                      </div>
                      @endif

                      @if (Session::get('notice'))
                      <div class="alert alert-danger">
                        <div class="alert">{{ Session::get('notice') }}</div>
                      </div>
                      @endif  

                        {{ Confide::makeLoginForm()->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
