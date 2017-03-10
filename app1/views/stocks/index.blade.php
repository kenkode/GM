@extends('layouts.erp')
@section('content')

<div class="row">
	<div class="col-lg-12">
  <h4><font color='green'>Stock</font></h4>

<hr>
</div>	
</div>


<div class="row">
	<div class="col-lg-12">

    @if (Session::has('flash_message'))

      <div class="alert alert-success">
      {{ Session::get('flash_message') }}
     </div>
    @endif

    @if (Session::has('delete_message'))

      <div class="alert alert-danger">
      {{ Session::get('delete_message') }}
     </div>
    @endif
    
    <div class="panel panel-default">
      <div class="panel-heading">
          <a class="btn btn-info btn-sm" href="{{ URL::to('stocks/create')}}">Receive Stock </a> 
          <!-- <a class="btn btn-info btn-sm" href="{{ URL::to('stocks/transfer')}}">Transfer Stock </a> -->
        </div>
        <div class="panel-body">


    <table id="users" class="table table-condensed table-bordered table-responsive table-hover">


      <thead>

        <th>#</th>
        <th>Item</th>
        <!-- <th>Stock In</th>
        <th>Stock Out</th> -->
        <th>Stock Amount</th>
       <!-- <th></th> -->

      </thead>
      <tbody>

        <?php $i = 1; ?>
        @foreach($items as $item)

        <tr>

          <td> {{ $i }}</td>
          <td>{{ $item->name }}</td>
          <!-- <td>{{ $item->quantity_in }}</td>
          <td>{{ $item->quantity_out }}</td>  -->         
          <td>{{Stock::getStockAmount($item)}}</td>
           
        <!--
          <td>

                  <div class="btn-group">
                  <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
          
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::to('stocks/show/'.$item->id)}}">Show Transactions</a></li>
    
                  </ul>
              </div>

                    </td>

-->

        </tr>

          
        <?php
        $reorder = (Stock::getStockAmount($item) < $item->reorder_level);
        $message = "Running low on "." ". $item->name." ".$item->description." ."."Please reorder" ;
       

        if ($reorder) 
          
        echo "<script type='text/javascript'> alert('$message');</script>";
           
        $i++; 
        ?>
        @endforeach


      </tbody>


    </table>
  </div>


  </div>

</div>

@stop