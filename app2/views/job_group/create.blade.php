@extends('layouts.hr')

{{HTML::script('media/jquery-1.8.0.min.js') }}



@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>New Job Group</h3>

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

		 <form method="POST" action="{{{ URL::to('job_group') }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Job Group Name <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{{ Input::old('name') }}}">
        </div>
        
        <div class="form-group">
            <label for="username">Benefits</label><label for="username" style="margin-left:150px">Amount</label>
            <?php $i = 1; ?>
            @foreach($benefits as $benefit)
            <input type="hidden" name="chbox[]" value="{{$benefit->id}}" />
            <table>
            <tr><td width="200">

            <input type="checkbox" name="benefitid[]" id="{{'benefitid_'.$i}}" value="{{$benefit->id}}">
                             {{$benefit->benefit_name}}
            </td>
            <td>
            
            <input class="form-control" placeholder="" type="text" name="amount[]" id="{{'amount_'.$i}}">
            </td>
            </tr>
            
            </table>

            <script type="text/javascript">
            $(document).ready(function(){
            $("#amount_"+<?php echo $i;?>).attr('readonly',true);
            $("#amount_"+<?php echo $i;?>).val('0.00');
            $('#benefitid_'+<?php echo $i;?>).click(function(){

            if($('#benefitid_'+<?php echo $i;?>).is(":checked")){
            $('#benefitid_'+<?php echo $i;?>+':checked').each(function(){

            $("#amount_"+<?php echo $i;?>).attr('readonly',false);
            $("#amount_"+<?php echo $i;?>).val('0.00');
            });
            }else{
            $("#amount_"+<?php echo $i;?>).attr('readonly',true);
            $("#amount_"+<?php echo $i;?>).val('0.00');
            }
            });
            $("#amount_"+<?php echo $i;?>).priceFormat();
            });
            </script>

            <?php $i++; ?>
            @endforeach
            </div>
        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create Job Group</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>

@stop