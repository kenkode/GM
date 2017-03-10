@extends('layouts.membercss')
@section('content')


@if (Session::get('notice'))
            <div class="alert alert-info">{{ Session::get('notice') }}</div>
        @endif
    
                    <div class="row">
                      
                        <div>
                          <h2>{{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</h2>
                        </div>
                      
                    </div>
                  



<div class="row">
  
  <div class="col-lg-12">
    <hr>

  </div>
</div>


<div class="row">
  
<a href="{{URL::to('empedit/'.$employee->id)}}" class="btn btn-info">Update Details</a>
<br><br>

  <div class="col-lg-4">



      <table class="table table-condensed table-bordered">

          <tr>
            <td>Name</td>
            <td>{{$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name}}</td>
          </tr>

           <tr>
            <td>File Number</td>
            <td>{{$employee->personal_file_number}}</td>
          </tr>

           <tr>
            <td>Identity Number</td>
            <td>{{$employee->identity_number}}</td>
          </tr>

          @if($employee->yob !=  null )
           <tr>
            <td>Date of Birth</td>
            <td>{{$employee->yob}}</td>
          </tr>
          @endif

           @if($employee->citizenship !=  null )
           <tr>
            <td>Citizenship</td>
            <td>{{$employee->citizenship}}</td>
          </tr>
          @endif


          @if($employee->passport_number !=  null )
           <tr>
            <td>Passport Number</td>
            <td>{{$employee->passport_number}}</td>
          </tr>
          @endif

          @if($employee->work_permit_number !=  null )
           <tr>
            <td>Work Permit Number</td>
            <td>{{$employee->work_permit_number}}</td>
          </tr>
          @endif


         
          
          
        
      </table>
  

  </div>  



  <div class="col-lg-4">



      <table class="table table-condensed table-bordered">

        @if($employee->job_title !=  null )
           <tr>
            <td>Job Title</td>
            <td>{{$employee->job_title}}</td>
          </tr>
        @endif

        @if($employee->date_joined !=  null )
           <tr>
            <td>Date Joined</td>
            <td>{{$employee->date_joined}}</td>
          </tr>
        @endif


        <tr>
            <td>KRA PIN</td>
            <td>{{$employee->pin}}</td>
          </tr>


          <tr>
            <td>NSSF Number</td>
            <td>{{$employee->social_security_number}}</td>
          </tr>


           <tr>
            <td>NHIF Number</td>
            <td>{{$employee->hospital_insurance_number}}</td>
          </tr>


      </table>


  </div>


<div class="row">

  <div class="col-lg-12">
    <hr>
  </div>  

  

  
</div>


@stop