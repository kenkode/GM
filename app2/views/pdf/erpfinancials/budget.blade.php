<html>
  <head>
   <style>
     @page { margin: 170px 30px; }
     .header { position: fixed; left: 0px; top: -150px; right: 0px; height: 150px;  text-align: center; }
     .footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 50px;  }
     .footer .page:after { content: counter(page, upper-roman); }
     .content { margin-top: -70px;  }
      
   </style>
  <body style="font-size:10px">
<?php


function asMoney($value) {
  return number_format($value, 2);
}

?>

    
   <div class="header">
     <table >

      <tr>


       
        <td style="width:150px">

            <img src="{{public_path().'/uploads/logo/'.$organization->logo}}" alt="logo" width="80%">
    
        </td>

        <td>
        <strong>
          {{ strtoupper($organization->name)}}<br>
          </strong>
          {{ $organization->phone}} |
          {{ $organization->email}} |
          {{ $organization->website}}<br>
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



   <div class="content">
     <div align="center"><strong><h1>BUDGET FOR YEAR {{$date}}</h1></div>

      <table border="1" cellspacing="0" cellpadding="0" style="width:100%;font-size:16px">

        <tr>
          <td></td>
          <th colspan="3">January</th>
          <th colspan="3">February</th>
          <th colspan="3">March</th>
          <th colspan="3">April</th>
          <th colspan="3">May</th>
          <th colspan="3">June</th>
          <th colspan="3">July</th>
          <th colspan="3">August</th>
          <th colspan="3">September</th>
          <th colspan="3">October</th>
          <th colspan="3">November</th>
          <th colspan="3">December</th>

        </tr>

        <tr>
          <td></td>
          <?php for($i=0;$i<12;$i++){ ?>
          <td><strong>Budgeted </strong></td>
          <td><strong>Actual </strong></td>
          <td><strong>Variance</strong></td>
          <?php } ?>
        </tr>

        <tr>
        
        <?php
        $totaljan = 0.00;
        $totalactjan = 0.00;
        $totalvarjan = 0.00;
        $totalfeb = 0.00;
        $totalactfeb = 0.00;
        $totalvarfeb = 0.00;
        $totalmar = 0.00;
        $totalactmar = 0.00;
        $totalvarmar = 0.00;
        $totalapr = 0.00;
        $totalactapr = 0.00;
        $totalvarapr = 0.00;
        $totalmay = 0.00;
        $totalactmay = 0.00;
        $totalvarmay = 0.00;
        $totaljun = 0.00;
        $totalactjun = 0.00;
        $totalvarjun = 0.00;
        $totaljul = 0.00;
        $totalactjul = 0.00;
        $totalvarjul = 0.00;
        $totalaug = 0.00;
        $totalactaug = 0.00;
        $totalvaraug = 0.00;
        $totalsep = 0.00;
        $totalactsep = 0.00;
        $totalvarsep = 0.00;
        $totaloct = 0.00;
        $totalactoct = 0.00;
        $totalvaroct = 0.00;
        $totalnov = 0.00;
        $totalactnov = 0.00;
        $totalvarnov = 0.00;
        $totaldec = 0.00;
        $totalactdec = 0.00;
        $totalvardec = 0.00;
        ?>

          <td>Sales</td>

          @if($budgetsalescountjan == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesjan as $budgetsalesjan)
          <td align="right">
           {{$budgetsalesjan->amount}}
          </td>
          <?php
            $totaljan = $totaljan + str_replace( ',', '',$budgetsalesjan->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'01',$date)) }}
         </td>
         <?php
            $totalactjan = $totalactjan + Budget::sales(1,'01',$date);
          ?>
         <td align="right">
          @if((Budget::sales(1,'01',$date)-str_replace( ',', '',$budgetsalesjan->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'01',$date)-str_replace( ',', '',$budgetsalesjan->amount)))).')'}}
          <?php
            $totalvarjan = $totalvarjan + (Budget::sales(1,'01',$date)-str_replace( ',', '',$budgetsalesjan->amount));
          ?>
          @else
          {{asMoney((Budget::sales(1,'01',$date)-str_replace( ',', '',$budgetsalesjan->amount)))}}
          <?php
            $totalvarjan = $totalvarjan + (Budget::sales(1,'01',$date)-str_replace( ',', '',$budgetsalesjan->amount));
          ?>
          @endif
         </td>


          @endforeach
          @endif

          @if($budgetsalescountfeb == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesfeb as $budgetsalesfeb)
          <td align="right">
           {{$budgetsalesfeb->amount}}
          </td>
          <?php
            $totalfeb = $totalfeb + str_replace( ',', '',$budgetsalesfeb->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'02',$date)) }}
         </td>

          <?php
            $totalactfeb = $totalactfeb + Budget::sales(1,'02',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'02',$date)-str_replace( ',', '',$budgetsalesfeb->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'02',$date)-str_replace( ',', '',$budgetsalesfeb->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'02',$date)-str_replace( ',', '',$budgetsalesfeb->amount)))}}
          @endif
         </td>

         <?php
            $totalvarfeb = $totalvarfeb + (Budget::sales(1,'02',$date)-str_replace( ',', '',$budgetsalesfeb->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountmar == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesmar as $budgetsalesmar)
          <td align="right">
           {{$budgetsalesmar->amount}}
          </td>
          <?php
            $totalmar = $totalmar + str_replace( ',', '',$budgetsalesmar->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'03',$date)) }}
         </td>
        
          <?php
            $totalactmar = $totalactmar + Budget::sales(1,'03',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'03',$date)-str_replace( ',', '',$budgetsalesmar->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'03',$date)-str_replace( ',', '',$budgetsalesmar->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'03',$date)-str_replace( ',', '',$budgetsalesmar->amount)))}}
          @endif
         </td>
        
         <?php
            $totalvarmar = $totalvarmar + (Budget::sales(1,'03',$date)-str_replace( ',', '',$budgetsalesmar->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountapr == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesapr as $budgetsalesapr)
          <td align="right">
           {{$budgetsalesapr->amount}}
          </td>

          <?php
            $totalapr = $totalapr + str_replace( ',', '',$budgetsalesapr->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'04',$date)) }}
         </td>

         <?php
            $totalactapr = $totalactapr + Budget::sales(1,'04',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'04',$date)-str_replace( ',', '',$budgetsalesapr->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'04',$date)-str_replace( ',', '',$budgetsalesapr->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'04',$date)-str_replace( ',', '',$budgetsalesapr->amount)))}}
          @endif
         </td>
           
          <?php
            $totalvarapr = $totalvarapr + (Budget::sales(1,'04',$date)-str_replace( ',', '',$budgetsalesapr->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountmay == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesmay as $budgetsalesmay)
          <td align="right">
           {{$budgetsalesmay->amount}}
          </td>
          <?php
            $totalmay = $totalmay + str_replace( ',', '',$budgetsalesmay->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'05',$date)) }}
         </td>

         <?php
            $totalactmay = $totalactmay + Budget::sales(1,'05',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'05',$date)-str_replace( ',', '',$budgetsalesmay->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'05',$date)-str_replace( ',', '',$budgetsalesmay->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'05',$date)-str_replace( ',', '',$budgetsalesmay->amount)))}}
          @endif
         </td>

          <?php
            $totalvarmay = $totalvarmay + (Budget::sales(1,'05',$date)-str_replace( ',', '',$budgetsalesmay->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountjun == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesjun as $budgetsalesjun)
          <td align="right">
           {{$budgetsalesjun->amount}}
          </td>
          <?php
            $totaljun = $totaljun + str_replace( ',', '',$budgetsalesjun->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'06',$date)) }}
         </td>

         <?php
            $totalactjun = $totalactjun + Budget::sales(1,'06',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'06',$date)-str_replace( ',', '',$budgetsalesjun->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'06',$date)-str_replace( ',', '',$budgetsalesjun->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'06',$date)-str_replace( ',', '',$budgetsalesjun->amount)))}}
          @endif
         </td>

         <?php
            $totalvarjun = $totalvarjun + (Budget::sales(1,'06',$date)-str_replace( ',', '',$budgetsalesjun->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountjul == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesjul as $budgetsalesjul)
          <td align="right">
           {{$budgetsalesjul->amount}}
          </td>
          <?php
            $totaljul = $totaljul + str_replace( ',', '',$budgetsalesjul->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'07',$date)) }}
         </td>

         <?php
            $totalactjul = $totalactjul + Budget::sales(1,'07',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'07',$date)-str_replace( ',', '',$budgetsalesjul->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'03',$date)-str_replace( ',', '',$budgetsalesjul->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'07',$date)-str_replace( ',', '',$budgetsalesjul->amount)))}}
          @endif
         </td>

         <?php
            $totalvarjul = $totalvarjul + (Budget::sales(1,'07',$date)-str_replace( ',', '',$budgetsalesjul->amount));
          ?>


          @endforeach
          @endif

          @if($budgetsalescountaug == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesaug as $budgetsalesaug)
          <td align="right">
           {{$budgetsalesaug->amount}}
          </td>
          <?php
            $totalaug = $totalaug + str_replace( ',', '',$budgetsalesaug->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'08',$date)) }}
         </td>

         <?php
            $totalactaug = $totalactaug + Budget::sales(1,'08',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'08',$date)-str_replace( ',', '',$budgetsalesaug->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'08',$date)-str_replace( ',', '',$budgetsalesaug->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'08',$date)-str_replace( ',', '',$budgetsalesaug->amount)))}}
          @endif
         </td>

          <?php
            $totalvaraug = $totalvaraug + (Budget::sales(1,'08',$date)-str_replace( ',', '',$budgetsalesaug->amount));
          ?>

          @endforeach
          @endif

         @if($budgetsalescountsep == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalessep as $budgetsalessep)
          <td align="right">
           {{$budgetsalessep->amount}}
          </td>
          <?php
            $totalsep = $totalsep + str_replace( ',', '',$budgetsalessep->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'09',$date)) }}
         </td>

         <?php
            $totalactsep = $totalactsep + Budget::sales(1,'09',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'09',$date)-str_replace( ',', '',$budgetsalessep->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'09',$date)-str_replace( ',', '',$budgetsalessep->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'09',$date)-str_replace( ',', '',$budgetsalessep->amount)))}}
          @endif
         </td>

          <?php
            $totalvarsep = $totalvarsep + (Budget::sales(1,'09',$date)-str_replace( ',', '',$budgetsalessep->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountoct == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesoct as $budgetsalesoct)
          <td align="right">
           {{$budgetsalesoct->amount}}
          </td>
          <?php
            $totaloct = $totaloct + str_replace( ',', '',$budgetsalesoct->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'10',$date)) }}
         </td>

          <?php
            $totalactoct = $totalactoct + Budget::sales(1,'10',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'10',$date)-str_replace( ',', '',$budgetsalesoct->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'10',$date)-str_replace( ',', '',$budgetsalesoct->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'10',$date)-str_replace( ',', '',$budgetsalesoct->amount)))}}
          @endif
         </td>

         <?php
            $totalvaroct = $totalvaroct + (Budget::sales(1,'10',$date)-str_replace( ',', '',$budgetsalesoct->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountnov == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesnov as $budgetsalesnov)
          <td align="right">
           {{$budgetsalesnov->amount}}
          </td>
          <?php
            $totalnov = $totalnov + str_replace( ',', '',$budgetsalesnov->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'11',$date)) }}
         </td>

         <?php
            $totalactnov = $totalactnov + Budget::sales(1,'11',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'11',$date)-str_replace( ',', '',$budgetsalesnov->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'11',$date)-str_replace( ',', '',$budgetsalesnov->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'11',$date)-str_replace( ',', '',$budgetsalesnov->amount)))}}
          @endif
         </td>

         <?php
            $totalvarnov = $totalvarnov + (Budget::sales(1,'11',$date)-str_replace( ',', '',$budgetsalesnov->amount));
          ?>

          @endforeach
          @endif

          @if($budgetsalescountdec == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          @foreach($budgetsalesdec as $budgetsalesdec)
          <td align="right">
           {{$budgetsalesdec->amount}}
          </td>
          <?php
            $totaldec = $totaldec + str_replace( ',', '',$budgetsalesdec->amount);
          ?>
          <td align="right">
          {{ asMoney(Budget::sales(1,'12',$date)) }}
         </td>

         <?php
            $totalactdec = $totalactdec + Budget::sales(1,'12',$date);
          ?>

         <td align="right">
          @if((Budget::sales(1,'12',$date)-str_replace( ',', '',$budgetsalesdec->amount)) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::sales(1,'12',$date)-str_replace( ',', '',$budgetsalesdec->amount)))).')'}}
          @else
          {{asMoney((Budget::sales(1,'12',$date)-str_replace( ',', '',$budgetsalesdec->amount)))}}
          @endif
         </td>

         <?php
            $totalvardec = $totalvardec + (Budget::sales(1,'12',$date)-str_replace( ',', '',$budgetsalesdec->amount));
          ?>

          @endforeach
          @endif
          
        </tr>
        <tr>
          <td><strong>Expenses</strong></td>
          <?php for($i=0;$i<36;$i++){?>
           <td></td>
          <?php } ?>
        </tr>
        
          @foreach($expenses as $expense)
          <tr>
           <td>
           {{$expense->name}}
          </td>

          @if($budgetexpcountjan == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Jan',$date)}}
          </td>
          
          <?php
            $totaljan = $totaljan + str_replace( ',', '',Budget::getAmount($expense->id,'Jan',$date));
          ?>

          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'01',$date)) }}
          </td>

          <?php
            $totalactjan = $totalactjan + str_replace( ',', '',Budget::expenses($expense->id,'01',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'01',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Jan',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'01',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jan',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'01',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jan',$date))))}}
          @endif
          </td>
          @endif

          <?php
            $totalvarjan = $totalvarjan + (Budget::expenses($expense->id,'01',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jan',$date)));
          ?>

          @if($budgetexpcountfeb == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Feb',$date)}}
          </td>
          <?php
            $totalfeb = $totalfeb + str_replace( ',', '',Budget::getAmount($expense->id,'Feb',$date));
          ?>
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'02',$date)) }}
          </td>
          <?php
            $totalactfeb = $totalactfeb + str_replace( ',', '',Budget::expenses($expense->id,'02',$date));
          ?>
          <td align="right">
          @if((Budget::expenses($expense->id,'02',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Feb',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'02',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Feb',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'02',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Feb',$date))))}}
          @endif
          </td>

         <?php
            $totalvarfeb = $totalvarfeb + (Budget::expenses($expense->id,'02',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Feb',$date)));
          ?>

          @endif


          @if($budgetexpcountmar == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Mar',$date)}}
          </td>

          <?php
            $totalmar = $totalmar + str_replace( ',', '',Budget::getAmount($expense->id,'Mar',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'03',$date)) }}
          </td>

          <?php
            $totalactmar = $totalactmar + str_replace( ',', '',Budget::expenses($expense->id,'03',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'03',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Mar',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'03',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Mar',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'03',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Mar',$date))))}}
          @endif
          </td>

          <?php
            $totalvarmar = $totalvarmar + (Budget::expenses($expense->id,'03',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Mar',$date)));
          ?>

          @endif


          @if($budgetexpcountapr == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Apr',$date)}}
          </td>

          <?php
            $totalapr = $totalapr + str_replace( ',', '',Budget::getAmount($expense->id,'Apr',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'04',$date)) }}
          </td>

          <?php
            $totalactapr = $totalactapr + str_replace( ',', '',Budget::expenses($expense->id,'04',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'04',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Apr',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'04',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Apr',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'04',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Apr',$date))))}}
          @endif
          </td>

          <?php
            $totalvarapr = $totalvarapr + (Budget::expenses($expense->id,'04',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Apr',$date)));
          ?>

          @endif


          @if($budgetexpcountmay == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'May',$date)}}
          </td>

          <?php
            $totalmay = $totalmay + str_replace( ',', '',Budget::getAmount($expense->id,'May',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'05',$date)) }}
          </td>

          <?php
            $totalactmay = $totalactmay + str_replace( ',', '',Budget::expenses($expense->id,'05',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'05',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'May',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'05',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'May',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'05',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'May',$date))))}}
          @endif
          </td>

          <?php
            $totalvarmay = $totalvarmay + (Budget::expenses($expense->id,'05',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'May',$date)));
          ?>

          @endif


          @if($budgetexpcountjun == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Jun',$date)}}
          </td>

          <?php
            $totaljun = $totaljun + str_replace( ',', '',Budget::getAmount($expense->id,'Jun',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'06',$date)) }}
          </td>

          <?php
            $totalactjun = $totalactjun + str_replace( ',', '',Budget::expenses($expense->id,'06',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'06',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Jun',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'06',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jun',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'06',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jun',$date))))}}
          @endif
          </td>
               
          <?php
            $totalvarjun = $totalvarjun + (Budget::expenses($expense->id,'06',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jun',$date)));
          ?>

          @endif


          @if($budgetexpcountjul == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Jul',$date)}}
          </td>

          <?php
            $totaljul = $totaljul + str_replace( ',', '',Budget::getAmount($expense->id,'Jul',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'07',$date)) }}
          </td>

          <?php
            $totalactjul = $totalactjul + str_replace( ',', '',Budget::expenses($expense->id,'07',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'07',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Jul',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'07',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jul',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'07',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jul',$date))))}}
          @endif
          </td>

          <?php
            $totalvarjul = $totalvarjul + (Budget::expenses($expense->id,'07',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Jul',$date)));
          ?>

          @endif


          @if($budgetexpcountaug == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Aug',$date)}}
          </td>

          <?php
            $totalaug = $totalaug + str_replace( ',', '',Budget::getAmount($expense->id,'Aug',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'08',$date)) }}
          </td>

          <?php
            $totalactaug = $totalactaug + str_replace( ',', '',Budget::expenses($expense->id,'08',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'08',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Aug',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'08',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Aug',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'08',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Aug',$date))))}}
          @endif
          </td>

          <?php
            $totalvaraug = $totalvaraug + (Budget::expenses($expense->id,'08',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Aug',$date)));
          ?>

          @endif


          @if($budgetexpcountsep == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Sep',$date)}}
          </td>

          <?php
            $totalsep = $totalsep + str_replace( ',', '',Budget::getAmount($expense->id,'Sep',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'09',$date)) }}
          </td>

          <?php
            $totalactsep = $totalactsep + str_replace( ',', '',Budget::expenses($expense->id,'09',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'09',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Sep',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'09',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Sep',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'09',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Sep',$date))))}}
          @endif
          </td>

          <?php
            $totalvarsep = $totalvarsep + (Budget::expenses($expense->id,'09',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Sep',$date)));
          ?>

          @endif


          @if($budgetexpcountoct == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Oct',$date)}}
          </td>

          <?php
            $totaloct = $totaloct + str_replace( ',', '',Budget::getAmount($expense->id,'Oct',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'10',$date)) }}
          </td>

          <?php
            $totalactoct = $totalactoct + str_replace( ',', '',Budget::expenses($expense->id,'10',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'10',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Oct',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'10',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Oct',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'10',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Oct',$date))))}}
          @endif
          </td>

          <?php
            $totalvaroct = $totalvaroct + (Budget::expenses($expense->id,'10',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Oct',$date)));
          ?>

          @endif


          @if($budgetexpcountnov == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Nov',$date)}}
          </td>

          <?php
            $totalnov = $totalnov + str_replace( ',', '',Budget::getAmount($expense->id,'Nov',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'11',$date)) }}
          </td>

          <?php
            $totalactnov = $totalactnov + str_replace( ',', '',Budget::expenses($expense->id,'11',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'11',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Nov',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'11',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Nov',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'11',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Nov',$date))))}}
          @endif
          </td>

          <?php
            $totalvarnov = $totalvarnov + (Budget::expenses($expense->id,'11',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Nov',$date)));
          ?>

          @endif


          @if($budgetexpcountdec == 0)
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          <td align="right">0.00</td>
          @else
          <td align="right">
           {{Budget::getAmount($expense->id,'Dec',$date)}}
          </td>

          <?php
            $totaldec = $totaldec + str_replace( ',', '',Budget::getAmount($expense->id,'Dec',$date));
          ?>
          
          <td align="right">
          {{ asMoney(Budget::expenses($expense->id,'12',$date)) }}
          </td>

          <?php
            $totalactdec = $totalactdec + str_replace( ',', '',Budget::expenses($expense->id,'12',$date));
          ?>
          
          <td align="right">
          @if((Budget::expenses($expense->id,'12',2016)-str_replace( ',', '',Budget::getAmount($expense->id,'Dec',$date))) < 0)
          {{'('.str_replace( '-', '',asMoney((Budget::expenses($expense->id,'12',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Dec',$date))))).')'}}
          @else
          {{asMoney((Budget::expenses($expense->id,'12',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Dec',$date))))}}
          @endif
          </td>

          <?php
            $totalvardec = $totalvardec + (Budget::expenses($expense->id,'12',$date)-str_replace( ',', '',Budget::getAmount($expense->id,'Dec',$date)));
          ?>

          @endif
          </tr>
          @endforeach 


          <?php
            $totalbudgeted = 0.00;
            $totalactual = 0.00;
            $totalvariance = 0.00;
            $totalbudgeted = $totaljan + $totalfeb + $totalmar + $totalapr + $totalmay + $totaljun+ $totaljul + $totalaug + $totalsep + $totaloct + $totalnov + $totaldec;
            $totalactual = $totalactjan + $totalactfeb + $totalactmar + $totalactapr + $totalactmay + $totalactjun+ $totalactjul + $totalactaug + $totalactsep + $totalactoct + $totalactnov + $totalactdec;
            $totalvariance = $totalactual - $totalbudgeted;
          ?>


          <tr>
          <td><strong>Total</strong></td>
          <td align="right"><strong>{{asMoney($totaljan)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactjan)}}</strong></td>
          
          @if($totalvarjan < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarjan)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarjan)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalfeb)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactfeb)}}</strong></td>
          
          @if($totalvarfeb < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarfeb)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarfeb)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalmar)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactmar)}}</strong></td>
          
          @if($totalvarmar < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarmar)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarmar)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalapr)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactapr)}}</strong></td>
          
          @if($totalvarapr < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarapr)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarapr)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalmay)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactmay)}}</strong></td>
          
          @if($totalvarmay < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarmay)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarmay)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totaljun)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactjun)}}</strong></td>
          
          @if($totalvarjun < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarjun)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarjun)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totaljul)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactjul)}}</strong></td>
          
          @if($totalvarjul < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarjul)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarjul)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalaug)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactaug)}}</strong></td>
          
          @if($totalvaraug < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvaraug)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvaraug)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalsep)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactsep)}}</strong></td>
          
          @if($totalvarsep < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarsep)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarsep)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totaloct)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactoct)}}</strong></td>
          
          @if($totalvaroct < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvaroct)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvaroct)}}</strong></td>
          @endif
          <td align="right"><strong>{{asMoney($totalnov)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactnov)}}</strong></td>
          
          @if($totalvarnov < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvarnov)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvarnov)}}</strong></td>
          @endif

          <td align="right"><strong>{{asMoney($totaldec)}}</strong></td>
          <td align="right"><strong>{{asMoney($totalactdec)}}</strong></td>
          
          @if($totalvardec < 0)
          <td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvardec)).')'}}</strong></td>
          @else
          <td align="right"><strong>{{asMoney($totalvardec)}}</strong></td>
          @endif

          
          </tr>

      </table>

      
      <table style="font-size:16px">
      <tr>
          <td height="20"></td>
          </tr>

          <tr>
          <td><strong>BUDGETED INCOME</strong></td><td><strong>:</strong></td><td align="right"><strong>{{asMoney($totalbudgeted)}}</strong></td>
          </tr>
          <tr>
          <td><strong>ACTUAL INCOME</strong></td><td><strong>:</strong></td><td align="right"><strong>{{asMoney($totalactual)}}</strong></td>
          </tr>
          <tr>
          @if($totalvariance < 0)
          <td><strong>VARIANCE</strong></td><td><strong>:</strong></td><td align="right"><strong>{{'('.str_replace( '-', '',asMoney($totalvariance)).')'}}</strong></td>
          @else
          <td><strong>VARIANCE</strong></td><td><strong>:</strong></td><td align="right"><strong>{{asMoney($totalvariance)}}</strong></td>
          @endif
          </tr>
      </table>

   </div>

 </body>
 </html>