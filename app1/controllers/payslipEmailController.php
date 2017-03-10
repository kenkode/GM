<?php

class payslipEmailController extends \BaseController {

    /**
     * Display a listing of branches
     *
     * @return Response
     */
    public function index()
    {
        $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('payslips.index',compact('employees'));
    }

    public function sendEmail()
    {
        if(!empty(Input::get('sel'))){
        $period = Input::get('period');
        $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
       
        $emps = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->count();

        foreach ($employees as $user) {

        $transact = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->first(); 

        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('allowance_name')
            ->get(); 

        $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('earning_name')
            ->get(); 

        $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('deduction_name')
            ->get();    
 
        $currency = DB::table('currencies')
            ->whereNull('organization_id')
            ->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->first();

        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('nontaxable_name')
            ->get(); 

        $overtimes = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('overtime_type')
            ->get();

        $rels = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $user->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('relief_name')
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $name = '';

        if($user->middle_name == '' || $user->middle_name == null){
              $name = $user->first_name.' '.$user->last_name;
              }else{
              $name = $user->first_name.' '.$user->middle_name.' '.$user->last_name;
              }

        $fyear = '';
        $fperiod = '';

        $part = explode("-", $period);

        if($part[0] == 1){
         $fyear = 'January_'.$part[1];
        }else if($part[0] == 2){
         $fyear = 'Febraury_'.$part[1];
        }else if($part[0] == 3){
         $fyear = 'March_'.$part[1];
        }else if($part[0] == 4){
         $fyear = 'April_'.$part[1];
        }else if($part[0] == 5){
         $fyear = 'May_'.$part[1];
        }else if($part[0] == 6){
         $fyear = 'June_'.$part[1];
        }else if($part[0] == 7){
         $fyear = 'July_'.$part[1];
        }else if($part[0] == 8){
         $fyear = 'August_'.$part[1];
        }else if($part[0] == 9){
         $fyear = 'September_'.$part[1];
        }else if($part[0] == 10){
         $fyear = 'October_'.$part[1];
        }else if($part[0] == 11){
         $fyear = 'November_'.$part[1];
        }else if($part[0] == 12){
         $fyear = 'December_'.$part[1];
        }

        if($part[0] == 1){
         $fperiod = 'January-'.$part[1];
        }else if($part[0] == 2){
         $fperiod = 'Febraury-'.$part[1];
        }else if($part[0] == 3){
         $fperiod = 'March-'.$part[1];
        }else if($part[0] == 4){
         $fperiod = 'April-'.$part[1];
        }else if($part[0] == 5){
         $fperiod = 'May-'.$part[1];
        }else if($part[0] == 6){
         $fperiod = 'June-'.$part[1];
        }else if($part[0] == 7){
         $fperiod = 'July-'.$part[1];
        }else if($part[0] == 8){
         $fperiod = 'August-'.$part[1];
        }else if($part[0] == 9){
         $fperiod = 'September-'.$part[1];
        }else if($part[0] == 10){
         $fperiod = 'October-'.$part[1];
        }else if($part[0] == 11){
         $fperiod = 'November-'.$part[1];
        }else if($part[0] == 12){
         $fperiod = 'December-'.$part[1];
        }

        $select  =  $user->id;
        $fileName = $user->first_name.'_'.$user->last_name.'_'.$fyear.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('pdf.monthlySlip', compact('employee','name','select','rels','overtimes','nontaxables','transact','allws','deds','earnings','period','currency', 'organization'))->setPaper('a4')->setOrientation('potrait');

        $pdf->save($filePath.$fileName);

        Mail::send('payslips.message', compact('fperiod','user'), function($message) use ($user,$filePath,$fileName){
        $message->to($user->email_office, $user->first_name.' '.$user->last_name)->subject('Payslip');
        $message->attach($filePath.$fileName);
        });
         unlink($filePath.$fileName);
     }
     return Redirect::back()->with('success', 'Email Sent!');
    }else if(empty(Input::get('sel')) && !empty(Input::get('employeeid'))){
        $period = Input::get('period');
        $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
       
        $emps = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->count();
        
        $id = Input::get('employeeid');

        $employee = Employee::find($id);
        
        $name = '';

        if($employee->middle_name == '' || $employee->middle_name == null){
              $name = $employee->first_name.' '.$employee->last_name;
              }else{
              $name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
              }

        $transact = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->first(); 

        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('allowance_name')
            ->get(); 

        $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('earning_name')
            ->get(); 

        $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('deduction_name')
            ->get();    
 
        $currency = DB::table('currencies')
            ->whereNull('organization_id')
            ->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->first();

        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('nontaxable_name')
            ->get(); 

        $overtimes = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('overtime_type')
            ->get();

        $rels = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('relief_name')
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $fyear = '';
        $fperiod = '';

        $part = explode("-", $period);

        if($part[0] == 1){
         $fyear = 'January_'.$part[1];
        }else if($part[0] == 2){
         $fyear = 'Febraury_'.$part[1];
        }else if($part[0] == 3){
         $fyear = 'March_'.$part[1];
        }else if($part[0] == 4){
         $fyear = 'April_'.$part[1];
        }else if($part[0] == 5){
         $fyear = 'May_'.$part[1];
        }else if($part[0] == 6){
         $fyear = 'June_'.$part[1];
        }else if($part[0] == 7){
         $fyear = 'July_'.$part[1];
        }else if($part[0] == 8){
         $fyear = 'August_'.$part[1];
        }else if($part[0] == 9){
         $fyear = 'September_'.$part[1];
        }else if($part[0] == 10){
         $fyear = 'October_'.$part[1];
        }else if($part[0] == 11){
         $fyear = 'November_'.$part[1];
        }else if($part[0] == 12){
         $fyear = 'December_'.$part[1];
        }

        if($part[0] == 1){
         $fperiod = 'January-'.$part[1];
        }else if($part[0] == 2){
         $fperiod = 'Febraury-'.$part[1];
        }else if($part[0] == 3){
         $fperiod = 'March-'.$part[1];
        }else if($part[0] == 4){
         $fperiod = 'April-'.$part[1];
        }else if($part[0] == 5){
         $fperiod = 'May-'.$part[1];
        }else if($part[0] == 6){
         $fperiod = 'June-'.$part[1];
        }else if($part[0] == 7){
         $fperiod = 'July-'.$part[1];
        }else if($part[0] == 8){
         $fperiod = 'August-'.$part[1];
        }else if($part[0] == 9){
         $fperiod = 'September-'.$part[1];
        }else if($part[0] == 10){
         $fperiod = 'October-'.$part[1];
        }else if($part[0] == 11){
         $fperiod = 'November-'.$part[1];
        }else if($part[0] == 12){
         $fperiod = 'December-'.$part[1];
        }

        $select  = $employee->id;
        $fileName = $employee->first_name.'_'.$employee->last_name.'_'.$fyear.'.pdf';
        $filePath = 'app/views/temp/';
        $pdf = PDF::loadView('pdf.monthlySlip', compact('employee','rels','overtimes','nontaxables','name','select','transact','allws','deds','earnings','period','currency', 'organization'))->setPaper('a4')->setOrientation('potrait');

        $pdf->save($filePath.$fileName);

        $user=Employee::find($id);
      

        Mail::send('payslips.message', compact('fperiod','user'), function($message) use ($user,$filePath,$fileName){
        $message->to($user->email_office, $user->first_name.' '.$user->last_name)->subject('Payslip');
        $message->attach($filePath.$fileName);
        });
         unlink($filePath.$fileName);
         
      }
      return Redirect::back()->with('success', 'Email Sent!');
    }
}
