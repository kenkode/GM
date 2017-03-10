<html >

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


<style type="text/css">

table {
  max-width: 100%;
  background-color: transparent;
}
th {
  text-align: left;
}
.table {
  width: 100%;
  margin-bottom: 2px;
}
hr {
  margin-top: 1px;
  margin-bottom: 2px;
  border: 0;
  border-top: 2px dotted #eee;
}

body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 12px;
  line-height: 1.428571429;
  color: #333;
  background-color: #fff;


 @page { margin: 50px 30px; }
 .header { position: top; left: 0px; top: -150px; right: 0px; height: 100px;  text-align: center; }
 .content {margin-top: -100px; margin-bottom: -150px}
 .footer { position: fixed; left: 0px; bottom: -60px; right: 0px; height: 50px;  }
 .footer .page:after { content: counter(page, upper-roman); }





</style>

</head>

<body>

  <div class="header">
       <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{asset('public/uploads/logo/'.$organization->logo)}}" alt="logo" width="150%">
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}
          </strong><br><p>
          {{ $organization->phone}}<br><p> 
          {{ $organization->email}}<br><p> 
          {{ $organization->website}}<br><p>
          {{ $organization->address}}
       

        </td>
        

      </tr>


      <tr>

        <hr>
      </tr>



    </table>
   </div>



<div class="footer">
     <p class="page">Page <?php $PAGE_NUM ?></p>
   </div>


	<div class="content" style='margin-top:70px;'>
   <!-- <div align="center"><strong>Clients Report as at {{date('d-M-Y')}}</strong></div><br> -->
   <div align="center"><strong>Clients Report as from:  {{$from}} To:  {{$to}}</strong></div><br>

   

    <table class="table table-bordered" border='1' cellspacing='0' cellpadding='0'>

      <tr>
        


        <th width='20'><strong># </strong></th>
        <th><strong>Name </strong></th>
        <th><strong>Email </strong></th>
        <th><strong>Phone </strong></th>
        <th><strong>Address </strong></th>
        <th><strong>Contact Person </strong></th>
        <!-- <th><strong>Contact Person Email </strong></th> -->
        <th><strong>Phone </strong></th>        
        <th><strong>Type </strong></th>
        <th><strong>Amount Due </strong></th>
      </tr>
      <?php $i =1; ?>
      @foreach($clients as $client)
      <tr>

       <?php  


    $order = 0;
    

          /*if($client->type == 'Customer'){
           $order = DB::table('erporders')
           ->join('erporderitems','erporders.id','=','erporderitems.erporder_id')
           ->join('clients','erporders.client_id','=','clients.id')
           ->join('tax_orders','erporders.order_number','=','tax_orders.order_number')
           ->where('clients.id',$id) ->selectRaw('SUM((price * quantity)+amount)as total')
           ->pluck('total');
           }
            else{*/
    $order = DB::table('erporders')
           ->join('erporderitems','erporders.id','=','erporderitems.erporder_id')
           ->join('clients','erporders.client_id','=','clients.id')           
           ->where('clients.id',$client->id) ->selectRaw('SUM((price * quantity))as total')
           ->pluck('total');
    
    $tax = DB::table('erporders')
           ->join('clients','erporders.client_id','=','clients.id')
           ->join('tax_orders','erporders.order_number','=','tax_orders.order_number')
           ->where('clients.id',$client->id) ->selectRaw('SUM(COALESCE(amount,0))as total')
           ->pluck('total');

           $order = $order + $tax;
         /*}*/

    $paid = DB::table('clients')
           ->join('payments','clients.id','=','payments.client_id')
           ->where('clients.id',$client->id) ->selectRaw('COALESCE(SUM(amount_paid),0) as due')
           ->pluck('due');

           $due= $order-$paid;

?>


       <td td width='20'>{{$i}}</td>
        <td> {{ $client->name }}</td>
        <td> {{ $client->email }}</td>
        <td> {{ $client->phone }}</td>
        <td> {{ $client->address}}</td>
        <td> {{ $client->contact_person }}</td>
        <!-- <td> {{ $client->contact_person_email }}</td> -->
        <td> {{ $client->contact_person_phone }}</td>
        <td> {{ $client->type}}</td>
        <td> {{ $due}}</td>
        </tr>
      <?php $i++; ?>
   
    @endforeach

     

    </table>

<br><br>

   
</div>


</body>

</html>



