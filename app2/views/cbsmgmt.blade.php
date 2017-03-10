@extends('layouts.main3')
@section('content')

<style>

  .main_dashboard{
      background-image: url({{ URL::asset('site/img/slides/bg/001.jpg') }});
      height: 70%;
      text-align: center;
      background-position: center center;
  }

  .main_dashboard img{
      /*width: 50%;*/
      position: relative;
      top: 50%;
      transform: translateY(-50%);
      color: #E7E7E7;
  }

</style>

<div class="row">
    <div class="col-lg-12">
	<div class="main_dashboard">
	    <img src="{{ URL::asset('site/img/xara.jpg') }}" width="50%" alt="Xara Financials">
	    <div class="col-lg-12" style="margin-top:-5%;">
		@if(Session::get('notice'))
            <div class="alert">{{{ Session::get('notice') }}}</div>
        @endif
	<div class="panel panel-success">
      <div class="panel-heading">
          <h4>{{{ Lang::get('messages.members') }}}</h4>
        </div>
      <div class="panel-body">
		<table id="users" class="table table-condensed table-bordered table-responsive table-hover">
      <thead>
        <th>#</th>
        <th>{{{ Lang::get('messages.table.number') }}}</th>
        <th>{{{ Lang::get('messages.table.name') }}}</th>
        <th>{{{ Lang::get('messages.table.branch') }}}</th>
        <th></th>
         <th></th>
         <th></th>
         <th></th>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($members as $member)
        <tr>
          <td> {{ $i }}</td>
          <td>{{ $member->membership_no }}</td>
          <td>{{ $member->name }}</td>
          <td>{{ $member->branch->name }}</td>
          <td>
          	 <a href="{{ URL::to('member/savingaccounts/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.savings') }}}</a>
           </td>
           <td>
              <a href="{{  URL::to('members/loanaccounts/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.loans') }}}</a>
            </td>
			<td>
          	 <a href="{{ URL::to('sharetransactions/show/'.$member->shareaccount->id) }}" class="btn-sm-info btn-info btn-sm">{{{ Lang::get('messages.shares') }}}</a>
          	</td>
          	<td>
          	 <a href="{{ URL::to('members/show/'.$member->id) }}" class="btn btn-info btn-sm">{{{ Lang::get('messages.manage') }}}</a>
			</td>
        </tr>
        <?php $i++; ?>
        @endforeach
      </tbody>
    </table>
</div>
</div>
	</div>
    </div>
</div>

@stop
