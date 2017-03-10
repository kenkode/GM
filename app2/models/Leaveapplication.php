<?php

class Leaveapplication extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'applied_start_date' => 'required'
	];

    public static $messages = array(
        'applied_start_date.required'=>'Please select start date!',
        'applied_end_date.required'=>'Please select end date!',
    );

	// Don't forget to fill this array
	protected $fillable = [];

	public function organization(){
		
		return $this->belongsTo('Organization');
	}


	public function employee(){
		
		return $this->belongsTo('Employee');
	}


	public function leavetype(){

		return $this->belongsTo('Leavetype');
	}


	public static function createLeaveApplication($data){

		$organization = Organization::getUserOrganization();

		$employee = Employee::find(array_get($data, 'employee_id'));

		$leavetype = Leavetype::find(array_get($data, 'leavetype_id'));

		$application = new Leaveapplication;

		$application->applied_start_date = array_get($data, 'applied_start_date');
		$application->applied_end_date = array_get($data, 'applied_end_date');
		$application->status = 'applied';
		$application->application_date = date('Y-m-d');
		$application->employee_id=array_get($data, 'employee_id');
		$application->leavetype()->associate($leavetype);
		$application->organization()->associate($organization);
		$application->is_supervisor_approved = 0;
		$application->is_supervisor_rejected = 0;
		
		if(array_get($data, 'weekends') == null){
          $application->is_weekend = 0;
		}else{
		  $application->is_weekend = 1;	
		}
		if(array_get($data, 'holidays') == null){
          $application->is_holiday = 0;
		}else{
		  $application->is_holiday = 1;	
		}
		
		$application->save();

		
		if(count(Supervisor::where('employee_id',$application->employee_id)) > 0){

        $supervisor = Supervisor::where('employee_id',$application->employee_id)->first();

        $employee = Employee::where('id',$supervisor->supervisor_id)->first();

        $emp = Employee::where('id',$supervisor->employee_id)->first();

		$name = $emp->first_name.' '.$emp->middle_name.' '.$emp->last_name;

		Mail::send( 'emails.leavecreate', array('application'=>$application, 'name'=>$name, 'employee'=>$emp), function( $message ) use ($employee)
		{
    		
    		$message->to($employee->email_office )->subject( 'Leave Application' );
		});
	}

	}




	public static function amendLeaveApplication($data, $id){

		

		$leavetype = Leavetype::find(array_get($data, 'leavetype_id'));

		$application = Leaveapplication::find($id);

		$application->applied_start_date = array_get($data, 'applied_start_date');
		$application->applied_end_date = array_get($data, 'applied_end_date');
		$application->status = 'amended';
		$application->date_amended = date('Y-m-d');
		$application->leavetype()->associate($leavetype);
		$application->is_weekend = array_get($data, 'weekends');
		$application->is_holiday = array_get($data, 'holidays');
		$application->update();

	}


	public static function approveLeaveApplication($data, $id){

		

		$application = Leaveapplication::find($id);

		$application->approved_start_date = array_get($data, 'approved_start_date');
		$application->approved_end_date = array_get($data, 'approved_end_date');
		$application->status = 'approved';
		$application->date_approved = date('Y-m-d');
		
		$application->update();


		$employeeid = DB::table('leaveapplications')->where('id', '=', $application->id)->pluck('employee_id');

  		$employee = Employee::findorfail($employeeid);

		$name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;

		Mail::send( 'emails.leaveapprove', array('application'=>$application, 'name'=>$name), function( $message ) use ($employee)
		{
    		
    		$message->to($employee->email_office )->subject( 'Leave Approval' );
		});

	}

	public static function approveEmployeeLeaveApplication($id,$startdate,$enddate){

		

		$application = Leaveapplication::find($id);

		$application->approved_start_date = $startdate;
		$application->approved_end_date = $enddate;
		$application->status = 'approved';
		$application->date_approved = date('Y-m-d');
		
		$application->update();


		$employeeid = DB::table('leaveapplications')->where('id', '=', $application->id)->pluck('employee_id');

  		$employee = Employee::findorfail($employeeid);

		$name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;

		Mail::send( 'emails.leaveapprove', array('application'=>$application, 'name'=>$name), function( $message ) use ($employee)
		{
    		
    		$message->to($employee->email_office )->subject( 'Leave Approval' );
		});

	}


	public static function rejectEmployeeLeaveApplication($id){

		

		$application = Leaveapplication::find($id);
	
		$application->status = 'rejected';
		$application->date_rejected = date('Y-m-d');
		
		$application->update();


	}


	public static function cancelLeaveApplication($id){

		

		$application = Leaveapplication::find($id);

	
		$application->status = 'cancelled';
		$application->date_cancelled = date('Y-m-d');
		
		$application->update();

	}


	public static function rejectLeaveApplication($id){

		

		$application = Leaveapplication::find($id);

	
		$application->status = 'rejected';
		$application->date_rejected = date('Y-m-d');
		
		$application->update();

	}




	
	public static function getLeaveDays($start_date, $end_date){

		$start = new DateTime($start_date);
		$end = new DateTime($end_date);

		//$start = strototime($start_date);
		//$end = strototime($end_date);

		//$diff =$end - $start;

		//$diff=date_diff($end, $start);


         $interval = $end->diff($start);

         $interval->format('%m');
         $days = $interval->days;

         return $days;

		//return strtotime($diff);

		
	}

	public static function getDays($start_date, $end_date,$weekends,$holidays){

        $start = new DateTime($start_date);
		$end = new DateTime($end_date);

         $interval = $end->diff($start);

         $interval->format('%m');
         $days = $interval->days;

         if($weekends == 1 && $holidays == 0){
           $weekendcount = Leaveapplication::getHoliday($start_date, $end_date);

           return $days - $weekendcount;
         }
         if($weekends == 0 && $holidays == 1){
           $holidaycount = Leaveapplication::getWeekend($start_date, $end_date);

           return $days - $holidaycount;
         }
         if($weekends == 1 && $holidays == 1){
           return $days;
         }
         if($weekends == 0 && $holidays == 0){
           $weekendholidaycount = Leaveapplication::getHoliday($start_date, $end_date)+ Leaveapplication::getWeekend($start_date, $end_date);

           return $days - $weekendholidaycount;
         }

		
	}


	public static function checkWeekend($date){

    		return (date('N', strtotime($date)) >= 6);
		

	}

		public static function checkHoliday($date){


    		$holiday = DB::table('holidays')->where('date', '=', $date)->count();

    		if($holiday >= 1){

    			return true;
    		} else {

    			return false;
    		}
		

	}


	public static function getDaysTaken($employee, $leavetype){



		$leavestaken = DB::table('leaveapplications')->where('employee_id', '=', $employee->id)->where('leavetype_id', '=', $leavetype->id)->where('status', '=', 'approved')->get();
		
		$daystaken = 0;
		foreach ($leavestaken as $leavetaken) {
			
			

				$taken = Leaveapplication::getLeaveDays($leavetaken->approved_start_date, $leavetaken->approved_end_date);

				$daystaken = $daystaken + $taken;

			
			
			

		}

		return $daystaken;

	}


	public static function getBalanceDays($employee, $leavetype){

		$currentyear = date('Y');

		$joined_year = date('Y', strtotime($employee->date_joined));

		if($currentyear == $joined_year){
			$years = 1;
		} else {

			$years = $currentyear - $joined_year+1;

		}

		
		$entitled = ($years * $leavetype->days);

		$daystaken = Leaveapplication::getDaysTaken($employee, $leavetype);

		$balance = $entitled - $daystaken+$leavetype->days;

		return $balance;
		
	}


	public static function getRedeemLeaveDays($employee, $leavetype){

		$payrate = $employee->basic_pay/ 30;

		$balancedays = Leaveapplication::getBalanceDays($employee, $leavetype);

		$amount = $balancedays * $payrate;

		return $amount;
	}

	public static function checkBalance($id, $lid,$d){

    $total = 0;
    $balance = 0;

    $currentyear = date('Y');

    $employee = DB::table('employee')
                       ->where('id',$id)
                       ->first();

		$joined_year = date('Y', strtotime($employee->date_joined));

		if($currentyear == $joined_year){
			$years = 1;
		} else {

			$years = $currentyear - $joined_year;

		}

		
	//$entitled = ($years * $leavetype->days);

    
    

    $leaveapplications = DB::table('leaveapplications')
                       ->join('leavetypes','leaveapplications.leavetype_id','=','leavetypes.id')
                       ->where('employee_id',$id)
                       ->where('leavetype_id',$lid)
                       ->where('date_approved','<>','')
                       ->get();
    foreach ($leaveapplications as $leaveapplication) {
      $total+=Leaveapplication::getLeaveDays($leaveapplication->applied_start_date, $leaveapplication->applied_end_date);
   
    }
    $balance = 0;
    if($lid == 1){
      $leavedays = DB::table('leavetypes')
                       ->where('id',1)
                       ->first();
      $balance = ($years * $leavedays->days)-$total-$d;
    }else{
      $leavedays = DB::table('leavetypes')
                       ->where('id',$lid)
                       ->first();
      $balance = $leavedays->days-$d;
    }
    

		return $balance;
	}


	public static function RedeemLeaveDays($employee, $leavetype){

		$payrate = $employee->basic_pay/ 30;

		$balancedays = Leaveapplication::getBalanceDays($employee, $leavetype);

		$amount = $balancedays * $payrate;

		Earning::insert($employee->id, 'Leave earning', 'redeemed leave days', $amount);
	}

	public static function getWeekend($startdate, $end_date){



		$count = 0;
		$start = new DateTime($startdate);
		$end = new DateTime($end_date);

		
        $interval = $end->diff($start);

        $interval->format('%m');
		$days = $interval->days;
		
		$chkdate = $end_date;

		do {

			$weekend = Leaveapplication::checkWeekend($chkdate);

			if($weekend == true){
				
				$count = $count +1;
				$add_days = 1;
    			$chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
    			$days = $days - 1;
			} else {
				
				$days = $days - 1;
				$add_days = 1;
    			$chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
			}


		} while($days > 0);

		return $count;

		//print_r($count);
		
	}

    public static function getHoliday($startdate, $end_date){



		$count = 0;
		$start = new DateTime($startdate);
		$end = new DateTime($end_date);

		
        $interval = $end->diff($start);

        $interval->format('%m');
		$days = $interval->days;
		
		$chkdate = $end_date;

		do {

			$hol = Leaveapplication::checkHoliday($chkdate);

			if($hol == true){
				
				$count = $count +1;
				$add_days = 1;
    			$chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
    			$days = $days - 1;
			} else {
				
				$days = $days - 1;
				$add_days = 1;
    			$chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
			}


		} while($days > 0);

		return $count;

		//print_r($count);
		
	}


	public static function getEndDate($startdate,$days,$weekends,$holidays){

		$sdate =$startdate;
		$chkdate = $sdate;
		$i = $days;
		$edate = $sdate;

    if($holidays == 1 && $weekends == 0){
    do{
    $hol = Leaveapplication::checkWeekend($chkdate);
    if($hol == false){
    $edate = $chkdate;
    $add_days = 1;
    $chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
    $i=$i-1;
    }else if($hol == true){
    $add_days = 1;
    $chkdate = date('Y-m-d',strtotime($chkdate.' +'.$add_days.' days'));
    } 
    } while($i > 0);
    }if($weekends == 1 && $holidays == 0){
    do{
    $wk = Leaveapplication::checkHoliday($chkdate);
    if($wk == false){
    $edate = $chkdate;
    $add_days = 1;
    $chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
    $i=$i-1;
    }else if($wk == true){
    $add_days = 1;
    $chkdate = date('Y-m-d',strtotime($chkdate.' +'.$add_days.' days'));
    } 
    } while($i > 0);
    }if($weekends == 1 && $holidays == 1){
    $edate = Leaveapplication::getLeaveDays($leaveapplication->approved_end_date,$leaveapplication->approved_start_date)+1;
    }if($weekends == 0 && $holidays == 0){

    do{
    $wk = Leaveapplication::checkWeekend($chkdate);
    $hol = Leaveapplication::checkHoliday($chkdate);
    if($wk == false && $hol == false){
    $edate = $chkdate;
    $add_days = 1;
    $chkdate = date('Y-m-d', strtotime($chkdate.' +'.$add_days.' days'));
    $i=$i-1;
    }else if($hol == true || $wk == true){
    $add_days = 1;
    $chkdate = date('Y-m-d',strtotime($chkdate.' +'.$add_days.' days'));
    } 
    } while($i > 0);
    }
    return $edate;

	}

	public static function applicationreport($departmentid){
        $end  = date('Y-m-d');
        $start  = date('Y-m-01', strtotime(date('Y-m-d')));

        $apps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',1)
                    ->where('employee.department_id',$departmentid)
                    ->whereBetween('application_date', array($start, $end))->get();

        $organization = Organization::find(1);
        
        $fileApplName = 'Leave_Application_Report_'.$start.'_'.$end.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.applicationReport', compact('apps','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileApplName);

        return $filePath.$fileApplName;
	}

	public static function approvereport($departmentid){
        $end  = date('Y-m-d');
        $start  = date('Y-m-01', strtotime(date('Y-m-d')));

         $apps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',1)
                    ->where('employee.department_id',$departmentid)
                    ->where('date_approved','<=',date('Y-m-d'))
                    ->whereBetween('date_approved', array($start, $end))->get();

        $organization = Organization::find(1);

        $fileApprName = 'Approved_Leave_Report_'.$start.'_'.$end.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.approvedReport', compact('apps','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileApprName);

        return $filePath.$fileApprName;
	}

	public static function rejectreport($departmentid){
        $end  = date('Y-m-d');
        $start  = date('Y-m-01', strtotime(date('Y-m-d')));

         $rejs = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',1)
                    ->where('employee.department_id',$departmentid)
                    ->whereBetween('date_rejected', array($start, $end))->get();

        $organization = Organization::find(1);

        $fileRejName = 'Rejected_Leave_Report_'.$start.'_'.$end.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.rejectedReport', compact('rejs','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileRejName);

        return $filePath.$fileRejName;
	}

	public static function employeereport($departmentid){
        $end  = date('Y-m-d');
        $start  = date('Y-m-01', strtotime(date('Y-m-d')));

         $emps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.department_id',$departmentid)
                    ->where('employee.organization_id',1)
                    ->where('leaveapplications.status','approved')
                    ->where('approved_start_date','<=',date('Y-m-d'))
                    ->where('approved_end_date','>=',date('Y-m-d'))
                    ->get();

        $organization = Organization::find(1);

 
        $fileEmpName = 'Employee_on_Leave_Report_'.$start.'_'.$end.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.employeeLeaveReport', compact('emps','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileEmpName);

        return $filePath.$fileEmpName;
	}

	public static function balancereport($departmentid,$leavetypeid){
        $end  = date('Y-m-d');
        $start  = date('Y-m-01', strtotime(date('Y-m-d')));

        $id = $leavetypeid;

        $leavetype = Leavetype::find($id);
        
        $employees= Employee::all();

        $organization = Organization::find(1);

        $fileBalName = $leavetype->name.'_Balances_Report_'.$start.'_'.$end.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.balanceReport', compact('employees','start','end','leavetype','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileBalName);

        return $filePath.$fileBalName;
	}

	public static function individualreport($departmentid,$employeeid){
        $id = $employeeid;

        $employee = Employee::find($id);

        $leavetypes = Leavetype::all();

        $organization = Organization::find(1);

        $fileIndName = $employee->first_name.'_'.$employee->last_name.'_Leave_Report.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('leavereports.individualReport', compact('leavetypes','employee','organization'))->setPaper('a4')->setOrientation('potrait');
        $pdf->save($filePath.$fileIndName);

        return $filePath.$fileIndName;
	}

}
