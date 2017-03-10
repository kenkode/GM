@extends('layouts.hr')

<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

{{ HTML::script('media/js/jquery.js') }}


@section('content')

<div class="row">
	<div class="col-lg-12">
  <h3>Update Job Group</h3>

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

		 <form method="POST" action="{{{ URL::to('job_group/update/'.$jobgroup->id) }}}" accept-charset="UTF-8">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Job Group Name <span style="color:red">*</span></label>
            <input class="form-control" placeholder="" type="text" name="name" id="name" value="{{ $jobgroup->job_group_name}}">
        </div>

        <div class="form-group">
            <label for="username">Benefits</label><label for="username" style="margin-left:150px">Amount</label>
             <input type="hidden" name="count" value="{{$count}}" />
             <input type="hidden" name="id" value="{{$jobgroup->id}}" />
            @if($count>0)
            
            <?php $i = 1; ?>
            @foreach($bens as $benefit)

            
            <input type="hidden" name="chbox[]" value="{{$benefit->id}}" />
            <table>
            <tr><td width="200">

            <input type="checkbox" name="benefitid[]"<?= (Benefitsetting::getAmount($benefit->id,$jobgroup->id)>0)?'checked="checked"':''; ?> id="{{'benefitid_'.$i}}" value="{{$benefit->id}}">
                             {{Benefitsetting::getBenefit($benefit->id)}}
            </td>
            <td>
            <input class="form-control" placeholder="" type="text" name="amount[]" id="{{'amount_'.$i}}" value="{{Benefitsetting::getAmount($benefit->id,$jobgroup->id)}}">
          
            </td>
            </tr>
            
            </table>

            <script type="text/javascript">
            $(document).ready(function(){
            if($('#benefitid_'+<?php echo $i;?>).is(":checked")){
            $("#amount_"+<?php echo $i;?>).attr('readonly',false);
            $("#amount_"+<?php echo $i;?>).val("{{asMoney(Benefitsetting::getAmount($benefit->id,$jobgroup->id))}}");
            }else{
            $("#amount_"+<?php echo $i;?>).attr('readonly',true);
            $("#amount_"+<?php echo $i;?>).val("{{asMoney(Benefitsetting::getAmount($benefit->id,$jobgroup->id))}}");
            }
            $('#benefitid_'+<?php echo $i;?>).click(function(){

            if($('#benefitid_'+<?php echo $i;?>).is(":checked")){
            $('#benefitid_'+<?php echo $i;?>+':checked').each(function(){
            $("#amount_"+<?php echo $i;?>).attr('readonly',false);
            $("#amount_"+<?php echo $i;?>).val("{{asMoney(Benefitsetting::getAmount($benefit->id,$jobgroup->id))}}");
            });
            }else{
            $("#amount_"+<?php echo $i;?>).attr('readonly',true);
            $("#amount_"+<?php echo $i;?>).val("0.00");
            }
            });
            $("#amount_"+<?php echo $i;?>).priceFormat();
            });
            </script>

            <?php $i++; ?>
            @endforeach

            @else
            <?php $i = 1; ?>
            @foreach($bens as $benefit)
            <input type="hidden" name="chbox1[]" value="{{$benefit->id}}" />
            <table>
            <tr><td width="200">

            <input type="checkbox" name="benefitid1[]" id="{{'benefitid_'.$i}}" value="{{$benefit->id}}">
                             {{$benefit->benefit_name}}
            </td>
            <td>
            
            <input class="form-control" placeholder="" type="text" name="amount1[]" id="{{'amount_'.$i}}">
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
            @endif

            </div>

        
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Update Job Group</button>
        </div>

    </fieldset>
</form>
		

  </div>

</div>


@stop