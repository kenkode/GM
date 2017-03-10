@extends('layouts.leave_ports')
@section('content')
<br/><br/><br/><br/>

<div class="row">

	<div class="col-lg-5">


    <form method="POST" action="{{{ URL::to('tasks') }}}" accept-charset="UTF-8">
        
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

    <fieldset>
        <div class="form-group">
            <label for="name">Group</label>
            <select class="form-control" name="group">

              @foreach($groups as $group)
              <option value="{{$group->name}}">{{$group->name}}</option>
              @endforeach

            </select>
        </div>

         <div class="form-group">
            <label for="name">Report</label>
            <select class="form-control" name="report">

              <option value="Individual Leave Balances">Individual Leave Balances</option>
              <option value="Total Leave Balances">Total Leave Balances</option>
              <option value="Leave Applications">Leave Applications</option>
              <option value="Leave Approvals">Leave Approvals</option>

            </select>
        </div>


        <div class="form-group">
            <label for="name">Day of Week</label>
            <select class="form-control" name="day_of_week">

              <option value="Everyday">Everyday</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
              
            </select>
        </div>


        <div class="form-group">
            <label for="name">Month</label>
            <select class="form-control" name="month">

              <option value="Everymonth">Everymonth</option>
              <option value="January">January</option>
              <option value="February">February</option>
              <option value="March">March</option>
              <option value="April">April</option>
              <option value="May">May</option>
              <option value="June">June</option>
              <option value="July">July</option>
              <option value="August">August</option>
              <option value="October">October</option>
              <option value="November">November</option>
              <option value="December">December</option>
              
            </select>
        </div>


        <div class="form-group">
            <label for="name">Hour</label>
            <select class="form-control" name="hour">

              <option value="Everyhour">Everyhour</option>
              <option value="00">00</option>
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">12</option>
              <option value="23">23</option>
              
              
            </select>
        </div>
        


        <div class="form-group">
            <label for="name">Minute</label>
            <input class="form-control" type="number" name="minute" min="0" max="60" >
        </div>
        
        

        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Create</button>
        </div>

       

    </fieldset>

  </form>
		

	</div>	



</div>


@stop