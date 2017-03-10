@extends('layouts.membercss')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Shares Accounts</h3>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">


            <div class="panel panel-default">
              <div class="panel-heading">
              <h5>Share Account</h5>
            </div>
            
            <div class="panel-body">


                <table width="100%" id="users" class="table table-condensed table-bordered table-responsive table-hover">


                  <thead>

                    <th>#</th>
                    
                    <th>Account Number</th>
                    
                    <th></th>

                  </thead>
                  
                  <tbody>

                    
                    
                  

                    <tr>

                      <td> 1</td>
                      
                      
                      <td>{{ $member->shareaccount->account_number }}</td>
                      <td> <a href="{{ URL::to('sharetransactions/show/'.$member->shareaccount->id)}}" class="btn btn-primary btn-sm">View </a></td>
                    </tr>

                 
                 


                  </tbody>


                </table>
            </div>

  </div>

</div>

</div>


@stop