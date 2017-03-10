@extends('layouts.main')

{{HTML::script('media/jquery-1.8.0.min.js') }}

@section('content')

<div class="row">
    <div class="col-lg-12">
  <h3>Update Occurence</h3>

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

         {{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}
  {{ HTML::script('jquery-ui-1.11.4.custom/jquery-ui.js') }}

  <style>
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
    .ui-dialog 
    {
    position: fixed;
    margin-bottom: 950px;
    }


    .ui-dialog-titlebar-close {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_888888_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
  border: medium none;
}
.ui-dialog-titlebar-close:hover {
  background: url("{{ URL::asset('jquery-ui-1.11.4.custom/images/ui-icons_222222_256x240.png'); }}") repeat scroll -93px -128px rgba(0, 0, 0, 0);
}
    
  </style>

  <script>
  $(function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      name = $( "#name" ),
      
      allFields = $( [] ).add( name ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o) {
      if ( o.val().length == 0 ) {
        o.addClass( "ui-state-error" );
        updateTips( "Please insert occurence type!" );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Please insert a valid name for occurence type." );
 
      if ( valid ) {

      /* displaydata(); 

      function displaydata(){
       $.ajax({
                      url     : "{{URL::to('reloaddata')}}",
                      type    : "POST",
                      async   : false,
                      data    : { },
                      success : function(s){
                        var data = JSON.parse(s)
                        //alert(data.id);
                      }        
       });
       }*/

        $.ajax({
            url     : "{{URL::to('createOccurence')}}",
                      type    : "POST",
                      async   : false,
                      data    : {
                              'name'  : name.val()
                      },
                      success : function(s){
                         
                     $('#type').append($('<option>', {
                     value: s,
                     text: name.val(),
                     selected:true
                     }));
                         
                      }        
        });
        
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 250,
      width: 350,
      modal: true,
      buttons: {
        "Create": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $('#type').change(function(){
    if($(this).val() == "cnew"){
    dialog.dialog( "open" );
    }
      
    });
  });
  </script>
 
   {{ HTML::script('datepicker/js/bootstrap-datepicker.min.js') }}

<div id="dialog-form" title="Create new occurence type">
  <p class="validateTips">Please insert Occurence Type.</p>
 
  <form>
    <fieldset>
      <label for="name">Name <span style="color:red">*</span></label>
      <input type="text" name="name" id="name" value="" class="text ui-widget-content ui-corner-all">
 
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>

         <form method="POST" action="{{{ URL::to('occurences/update/'.$occurence->id) }}}" accept-charset="UTF-8" enctype="multipart/form-data">
   
    <fieldset>
        <div class="form-group">
            <label for="username">Occurence Brief <span style="color:red">*</span> </label>
            <input class="form-control" placeholder="" type="text" name="brief" id="brief" value="{{{ $occurence->occurence_brief }}}">
        </div>
       
      <input class="form-control" placeholder="" type="hidden" readonly name="employee" id="employee" value="{{ $occurence->employee->id }}"> 

        <div class="form-group">
                        <label for="username">Occurence Type: <span style="color:red">*</span></label>
                        <select name="type" id="type" class="form-control">
                           <option></option>
                           <option value="cnew">Create New</option>
                            @foreach($occurencesettings as $occurencesetting)
                            <option value="{{ $occurencesetting->id }}"<?= ($occurence->occurencesetting_id==$occurencesetting->id)?'selected="selected"':''; ?>> {{ $occurencesetting->occurence_type }}</option>
                            @endforeach
                        </select>
                
                    </div>     
        
        <div class="form-group">
            <label for="username">Occurence Narrative </label>
            <textarea class="form-control" name="narrative">{{{ $occurence->narrative }}}</textarea>
        </div>

         <div class="form-group">
                        <label for="username">Current Document</label><span style="color:red">*</span><br>
                        <input readonly class="form-control" placeholder="" type="text" name="curpath" value="{{ $occurence->doc_path }}">
                    </div>

        <div class="form-group">
                        <label for="username">Update Document</label><br>
                        <input class="img" placeholder="" type="file" name="path" id="path" value="{{ $occurence->doc_path }}">
                    </div>

        <div class="form-group">
                        <label for="username">Occurence Date <span style="color:red">*</span></label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="date" id="date" value="{{{ $occurence->occurence_date }}}">
                        </div>
                        </div>

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Edit Occurence</button>
        </div>

    </fieldset>
</form>
        

  </div>

</div>
























@stop