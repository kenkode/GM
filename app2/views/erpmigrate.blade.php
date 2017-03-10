@extends('layouts.erp')
@section('content')

<div class="row">
	
	<div class="col-lg-12">
  DATA MIGRATION
		<hr>

    @if (Session::get('notice'))
            <div class="alert alert-success">{{ Session::get('notice') }}</div>
        @endif


<p><strong>Migrate Categories</strong></p>

    <p>&nbsp;</p>
    <form method="post" action="{{URL::to('import/categories')}}" accept-charset="UTF-8" enctype="multipart/form-data">

    <div class="form-group">

        <label>Upload Categories  (excel)</label>
        <input type="file" class="" name="categories" />
            
    </div>
    
      
      <button type="submit" class="btn btn-primary">Import Categories</button>
    </form>

<!-- ############################################################  -->

    <hr>
<p><strong>Migrate Items</strong></p>

<a href="{{URL::to('template/earnings')}}" > <i class="glyphicon glyphicon-file"></i> Download Items Template</a>
    <p>&nbsp;</p>
   <form method="post" action="{{URL::to('import/items')}}" accept-charset="UTF-8" enctype="multipart/form-data">

      <div class="form-group">

        <label>Upload Items  (excel)</label>
        <input type="file" class="" name="items" />
            
    </div>
    
      
      <button type="submit" class="btn btn-primary">Import Items</button>

    </form>








    <!-- ############################################################  -->

    <hr>



	

	

@stop