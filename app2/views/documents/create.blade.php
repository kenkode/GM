@extends('layouts.main')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Employee Document</h3>

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

		 <form method="POST" action="{{{ URL::to('documents') }}}" accept-charset="UTF-8" enctype="multipart/form-data">
   
    <fieldset>

            <input class="form-control" placeholder="" type="hidden" name="employee" id="employee" value="{{$id}}">

       <div class="form-group">
                        <label for="username">Document</label><span style="color:red">*</span><br>
                        <input class="img" placeholder="" type="file" name="path" id="path" value="{{{ Input::old('path') }}}">
                    </div>

        <div class="form-group">
            <label for="username">Document Name <span style="color:red">*</span> </label><br>
            <input class="form-control" placeholder="" type="text" name="type" id="type" value="{{{ Input::old('type') }}}">
        </div>

        <div class="form-group">
            <label for="username">Description </label><br>
            <textarea name="desc" class="form-control" id="desc">{{{ Input::old('desc') }}}</textarea>
        </div>

                <div class="form-group">
                        <label for="username">Date From </label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control expiry" readonly="readonly" placeholder="" required type="text" name="fdate" id="fdate" value="{{{ Input::old('fdate') }}}">
                    </div>
                </div>
        
        <div class="form-group">
                        <label for="username">End Date</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control expiry" readonly="readonly" placeholder="" required type="text" name="edate" id="edate" value="{{{ Input::old('edate') }}}">
                    </div>
                </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Upload Document</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>
























@stop