@extends('layouts.payroll')
@section('content')

<div class="row">
	
	<div class="col-lg-12">
  DATA MIGRATION
		<hr>

    @if (Session::get('notice'))
            <div class="alert alert-success">{{ Session::get('notice') }}</div>
        @endif

    @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif

<div class="col-lg-12">
<p><strong>Migrate Employees</strong></p>

<div class="col-lg-4">

<a href="{{URL::to('template/employees')}}" > <i class="glyphicon glyphicon-file"></i> Download Employees Template</a>
    <p>&nbsp;</p>
  </div>
    
    <form method="post" action="{{URL::to('import/employees')}}" accept-charset="UTF-8" enctype="multipart/form-data">
<div class="col-lg-4">
    <div class="form-group">

        <label>Upload Employees  (excel)</label>
        <input type="file" class="" name="employees" />
            
    </div>
    
      </div>
      <div class="col-lg-4">
      <button type="submit" class="btn btn-primary">Import Employees</button>
    </div>
    </form>

  </div>

<!-- ############################################################  -->
<div class="col-lg-12">
    <hr>
  </div>

  <div class="col-lg-12">
    <div class="col-lg-4">
<p><strong>Migrate Earnings</strong></p>

<a href="{{URL::to('template/earnings')}}" > <i class="glyphicon glyphicon-file"></i> Download Earnings Template</a>
    <p>&nbsp;</p>
  </div>

   <form method="post" action="{{URL::to('import/earnings')}}" accept-charset="UTF-8" enctype="multipart/form-data">
<div class="col-lg-4">
      <div class="form-group">

        <label>Upload Earnings  (excel)</label>
        <input type="file" class="" name="earnings" />
            
    </div>
    </div>
      <div class="col-lg-4">
      <button type="submit" class="btn btn-primary">Import Earnings</button>
       </div>
    </form>
</div>



    <!-- ############################################################  -->
<div class="col-lg-12">
    <hr>
  </div>


  <div class="col-lg-12">
    <div class="col-lg-4">
<p><strong>Migrate Allowances</strong></p>

<a href="{{URL::to('template/allowances')}}" > <i class="glyphicon glyphicon-file"></i> Download Allowances Template</a>
    <p>&nbsp;</p>
  </div>
    <form method="post" action="{{URL::to('import/allowances')}}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-lg-4">
      <div class="form-group">

        <label>Upload Allowances  (excel)</label>
        <input type="file" class="" name="allowances" />
            
    </div>
    
      </div>

      <div class="col-lg-4">
      <button type="submit" class="btn btn-primary">Import Allowances</button>
</div>
    </form>


</div>


    <!-- ############################################################  -->
<div class="col-lg-12">
    <hr>
  </div>


<div class="col-lg-12">
  <div class="col-lg-4">
<p><strong>Migrate Reliefs</strong></p>

<a href="{{URL::to('template/reliefs')}}" > <i class="glyphicon glyphicon-file"></i> Download Relief Template</a>
    <p>&nbsp;</p>
  </div>
    <form method="post" action="{{URL::to('import/reliefs')}}" accept-charset="UTF-8" enctype="multipart/form-data">
   <div class="col-lg-4">
      <div class="form-group">

        <label>Upload Relief  (excel)</label>
        <input type="file" class="" name="reliefs" />
            
    </div>
    </div>

    <div class="col-lg-4">
      
      <button type="submit" class="btn btn-primary">Import Relief</button>
    </div>

    </form>

</div>


    <!-- ############################################################  -->
<div class="col-lg-12">
    <hr>
</div>
<div class="col-lg-12">
<div class="col-lg-4">
<p><strong>Migrate Deductions</strong></p>

<a href="{{URL::to('template/deductions')}}" > <i class="glyphicon glyphicon-file"></i> Download Deduction Template</a>
    <p>&nbsp;</p>
  </div>

    <form method="post" action="{{URL::to('import/deductions')}}" accept-charset="UTF-8" enctype="multipart/form-data">
<div class="col-lg-4">
      <div class="form-group">

        <label>Upload Deductions (excel)</label>
        <input type="file" class="" name="deductions" />
            
    </div>
    </div>

    <div class="col-lg-4">
      
      <button type="submit" class="btn btn-primary">Import Deductions</button>
</div>
    </form>
</div>

 <!-- ############################################################  -->
 <!--
<div class="col-lg-12">
    <hr>
  </div>

<div class="col-lg-12">
  <div class="col-lg-4">
<p><strong>Migrate Bank </strong></p>
  

 <a href="{{asset('/Excel/banks.xls') }}"> <i class="glyphicon glyphicon-file"></i> Download Banks Template</a>
    <p>&nbsp;</p>
  </div>

    <form method="post" action="{{URL::to('import/banks')}}" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="col-lg-4">
      <div class="form-group">

        <label>Upload Banks (excel)</label>
        <input type="file" class="" name="banks" />
            
    </div>
    </div>

      <div class="col-lg-4">
      <button type="submit" class="btn btn-primary">Import Bank</button>
</div>

    </form>
</div>
 -->

<!-- ############################################################  -->
<!-- 
<div class="col-lg-12">
    <hr>
  </div>
<div class="col-lg-12">
  <div class="col-lg-4">
<p><strong>Migrate Bank Branches</strong></p>

  <a href="{{asset('/Excel/bank_branches.xls') }}"> <i class="glyphicon glyphicon-file"></i> Download Bank Branches Template</a>
    <p>&nbsp;</p>
  </div>

    <form method="post" action="{{URL::to('import/bankBranches')}}" accept-charset="UTF-8" enctype="multipart/form-data">
<div class="col-lg-4">
      <div class="form-group">

        <label>Upload Bank Branches (excel)</label>
        <input type="file" class="" name="bbranches" />
            
    </div>
    </div>

      <div class="col-lg-4">
      <button type="submit" class="btn btn-primary">Import Bank Branch</button>
     </div>
    </form>
</div>

   --!>
<div class="col-lg-12">
    <hr>
  </div>

  </div>
</div>
	

@stop