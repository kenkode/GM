Dear sir/madam <br><br>This is a reminder on the employees whose contracts are about to expire;

  <?php $name = ''; $i = 1;?>
  <br><br><table><tr style ='font-weight:bold'><td>#</td><td>Employee Name</td><td>Start Date</td><td>End Date</td></tr>
  @foreach ($employees as $employee) 
  <?php
   $date = (strtotime(date("Y-m-d")) - strtotime($employee->end_date)) / 86400;
   ?>
    @if($date<=31 && $employee->from_date != '0000-00-00' && $employee->expiry_date != '0000-00-00')
    @if($employee->middle_name=='' || $employee->middle_name==null)
    <?php $name = $employee->first_name.' '.$employee->last_name;?>
    @else
    <?php $name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name; ?>
    @endif
    <tr><td>{{$i}}</td><td>{{$employee->personal_file_number.' '.$name}}</td><td>{{$employee->start_date}}</td><td>{{$employee->end_date}}</td></tr>
    @else
    @endif
   <?php $i++; ?>
  @endforeach
  </table>

