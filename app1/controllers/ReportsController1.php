<?php

class ReportsController extends \BaseController {

  

  public function selstate()
  {

    return View::make('pdf.selectStateEmployee');
  }

  public function employees(){

    if(Input::get('format') == "excel"){
      if(Input::get('status') == 'Active'){
         $data = Employee::where('in_employment','=','Y')->where('organization_id',Confide::user()->organization_id)->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Active Employee Report', function($excel) use($data,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Active Employee Report', function($sheet) use($data,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:H3');
              $sheet->row(3, array(
              'Employee List Report For Active Employees'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NO.', 'EMPLOYEE', 'BRANCH','DEPARTMENT','GENDER','KRA PIN','NSSF NO.','NHIF NO.'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $branch = '';
              $department = '';
              $name = '';

             if($data[$i]->branch_id == 0){
               $branch= '';
             }else{
               $branch=$data[$i]->branch->name;
             }

             if($data[$i]->department_id == 0){
               $department= '';
             }else{
               $department=$data[$i]->department->department_name;
             }

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$branch,$department,$data[$i]->gender,$data[$i]->pin,$data[$i]->social_security_number,$data[$i]->hospital_insurance_number
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else if(Input::get('status') == 'Deactive'){
           $data = Employee::where('in_employment','=','N')->where('organization_id',Confide::user()->organization_id)->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Deactivated Employee Report', function($excel) use($data,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Deactivated Employee Report', function($sheet) use($data,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:H3');
              $sheet->row(3, array(
              'Employee List Report For Deactived Employees'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NO.', 'EMPLOYEE', 'BRANCH','DEPARTMENT','GENDER','KRA PIN','NSSF NO.','NHIF NO.'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $branch= '';
             $department= '';
             $name = '';

             if($data[$i]->branch_id == 0){
               $branch= '';
             }else{
               $branch=$data[$i]->branch->name;
             }

             if($data[$i]->department_id == 0){
               $department= '';
             }else{
               $department=$data[$i]->department->department_name;
             }

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$branch,$department,$data[$i]->gender,$data[$i]->pin,$data[$i]->social_security_number,$data[$i]->hospital_insurance_number
             ));
             $row++;
             }  
             
             
    });

  })->download('xls');
      }else if(Input::get('status') == 'All'){
        $data = Employee::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

        Excel::create('Employee Report', function($excel) use($data,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Employee Report', function($sheet) use($data,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:I3');
              $sheet->row(3, array(
              'Employee List Report For All Employees'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NO.', 'EMPLOYEE', 'BRANCH','DEPARTMENT','GENDER','KRA PIN','NSSF NO.','NHIF NO.','STATUS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $status = '';
             $branch= '';
             $department= '';
             $name = '';

             if($data[$i]->branch_id == 0){
               $branch= '';
             }else{
               $branch=$data[$i]->branch->name;
             }

             if($data[$i]->department_id == 0){
               $department= '';
             }else{
               $department=$data[$i]->department->department_name;
             }


             if($data[$i]->in_employment == 'Y'){
               $status = 'Active';
             }else{
               $status = 'Deactivated';
             }

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$branch,$department,$data[$i]->gender,$data[$i]->pin,$data[$i]->social_security_number,$data[$i]->hospital_insurance_number,$status
             ));
             $row++;
             }         
             
             
    });

  })->download('xls');
      }
    }else{

    if(Input::get('status') == 'Active'){
    $employees = Employee::where('in_employment','=','Y')->where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.activeemployee', compact('employees', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Employee List.pdf');

    }else if(Input::get('status') == 'Deactive'){
    $employees = Employee::where('in_employment','N')->where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.deactiveemployee', compact('employees', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Employee List.pdf');

    }else if(Input::get('status') == 'All'){

    $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.employeelist', compact('employees', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Employee List.pdf');
    }
  }
  }

  public function emp_id()
  {
    $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('pdf.ind_emp', compact('employees'));
  }

    public function individual(){

    $id = Input::get('employeeid');

    $employee = Employee::find($id);

    $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.individualemployee', compact( 'employee','organization','benefits'))->setPaper('a4')->setOrientation('potrait');
  
    //dd($organization);

    return $pdf->stream($employee->first_name.' '.$employee->last_name.'.pdf');
    
  }

    public function selEmp()
    {
        $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

        return View::make('pdf.selectEmployee', compact('employees'));
    }

    public function occurence(){

       if(Input::get('format') == "excel"){
        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $data = DB::table('occurences')
                   ->where('employee_id','=',$id)
                   ->get();

        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Occurence Report', function($excel) use($data,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Occurence Report', function($sheet) use($data,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:E3');

              $name = '';

              if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }

              $sheet->row(3, array(
              'Occurence Report for '.$name
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'OCCURENCE BRIEF', 'OCCURENCE TYPE', 'NARRATIVE','DATE'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $sheet->row($row, array(
             $x,$data[$i]->occurence_brief,Occurencesetting::getOccurenceType($data[$i]->occurencesetting_id),$data[$i]->narrative,$data[$i]->occurence_date
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  
  }else{

        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $occurences = DB::table('occurences')
                   ->where('employee_id','=',$id)
                   ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.employeeoccurence', compact( 'employee','organization','occurences'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream($employee->first_name.' '.$employee->last_name.'.pdf');
        }
    }

    public function propertyperiod()
    {
            
       $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.selectPropertyPeriod',compact('employees'));
    }

    public function property(){

      if(Input::get('format') == "excel"){
        if(Input::get('employeeid') == 'All'){
         $from = Input::get("from");
         $to = Input::get("to");

         $data = DB::table('properties')
            ->join('employee', 'properties.employee_id', '=', 'employee.id')
            ->where('organization_id',Confide::user()->organization_id)
            ->whereBetween('issue_date', array($from, $to))
            ->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Company Property Report', function($excel) use($data,$from,$to,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Company Property Report', function($sheet) use($data,$from,$to,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:L3');
              $sheet->row(3, array(
              'Company Property Report for period between '.$from.' and '.$to
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'EMPLOYEE', 'PROPERTY NAME', 'DESCRIPTION','SERIAL NO.','DIGITAL SNO.','VALUE','ISSUED BY','ISSUE DATE','SCHEDULED RETURN DATE','STATUS','RECEIVED BY'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             
             
             for($i = 0; $i<count($data); $i++){

              $status = '';
              $receiver = '';
              $name = '';
              if($data[$i]->state == 0){
               $status = 'Not Returned';
              }else{
                $status = 'Returned';
              }

              if($data[$i]->received_by == 0){
               $receiver = '';
              }else{
                $receiver = Property::getReceiver($data[$i]->received_by);
              }
            
              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $x,$name,$data[$i]->name,$data[$i]->description,$data[$i]->serial,$data[$i]->digitalserial,$data[$i]->monetary,Property::getIssuer($data[$i]->issued_by),$data[$i]->issue_date,$data[$i]->scheduled_return_date,$status,$receiver
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  
  }else{
        $id = Input::get('employeeid');

        $from = Input::get("from");
        $to = Input::get("to");

        $employee = Employee::find($id);

         $data = DB::table('properties')
            ->join('employee', 'properties.employee_id', '=', 'employee.id')
            ->where('employee_id', $id)
            ->where('organization_id',Confide::user()->organization_id)
            ->whereBetween('issue_date', array($from, $to))
            ->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Company Property Report', function($excel) use($data,$from,$to,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Company Property Report', function($sheet) use($data,$from,$to,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:K3');

              $name = '';

              if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }
              $sheet->row(3, array(
              'Company Property Report for '.$name.' for period between '.$from.' and '.$to
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'PROPERTY NAME', 'DESCRIPTION','SERIAL NO.','DIGITAL SNO.','VALUE','ISSUED BY','ISSUE DATE','SCHEDULED RETURN DATE','STATUS','RECEIVED BY'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             
             
             for($i = 0; $i<count($data); $i++){

              $status = '';
              $receiver = '';
              if($data[$i]->state == 0){
               $status = 'Not Returned';
              }else{
                $status = 'Returned';
              }

              if($data[$i]->received_by == 0){
               $receiver = '';
              }else{
                $receiver = Property::getReceiver($data[$i]->received_by);
              }
            
             $sheet->row($row, array(
             $x,$data[$i]->name,$data[$i]->description,$data[$i]->serial,$data[$i]->digitalserial,$data[$i]->monetary,Property::getIssuer($data[$i]->issued_by),$data[$i]->issue_date,$data[$i]->scheduled_return_date,$status,$receiver
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  }
  
  }else{
     
        if(Input::get('employeeid') == 'All'){

        $from = Input::get("from");
        $to = Input::get("to");

        $properties = DB::table('properties')
            ->join('employee', 'properties.employee_id', '=', 'employee.id')
            ->whereBetween('issue_date', array($from, $to))
            ->where('organization_id',Confide::user()->organization_id)
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.property', compact('from','to','organization','properties'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream('company_property.pdf');
         
        }else{

        $id = Input::get('employeeid');

        $from = Input::get("from");
        $to = Input::get("to");

        $employee = Employee::find($id);

        $properties = DB::table('properties')
            ->join('employee', 'properties.employee_id', '=', 'employee.id')
            ->where('employee_id', $id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->whereBetween('issue_date', array($from, $to))
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.individualproperty', compact( 'from','to','employee','organization','properties'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream($employee->first_name.'_'.$employee->last_name.'_company_property.pdf');
    }
    }
        
    }

    public function appraisalperiod()
    {
       $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.selectAppraisalPeriod',compact('employees'));
    }

    public function appraisal(){

      if(Input::get('format') == "excel"){
        if(Input::get('employeeid') == 'All'){
         $from = Input::get("from");
         $to = Input::get("to");

         $data = DB::table('appraisals')
            ->join('employee', 'appraisals.employee_id', '=', 'employee.id')
            ->join('appraisalquestions', 'appraisals.appraisalquestion_id', '=', 'appraisalquestions.id')
            ->join('users', 'appraisals.examiner', '=', 'users.id')
            ->whereBetween('appraisaldate', array($from, $to))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('first_name','last_name','middle_name','comment','appraisals.rate','username','question','performance','appraisaldate')
            ->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Appraisal Report', function($excel) use($data,$from,$to,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Appraisal Report', function($sheet) use($data,$from,$to,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:H3');
              $sheet->row(3, array(
              'Appraisal Report for period between '.$from.' and '.$to
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'EMPLOYEE', 'QUESTION', 'PERFORMANCE','RATE','EXAMINER','APPRAISAL DATE','COMMENT'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             
             
             for($i = 0; $i<count($data); $i++){
              
              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $x,$name,$data[$i]->question,$data[$i]->performance,$data[$i]->rate,$data[$i]->username,$data[$i]->appraisaldate,$data[$i]->comment
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  
  }else{
        $id = Input::get('employeeid');

        $from = Input::get("from");
        $to = Input::get("to");

        $employee = Employee::find($id);

        $data = DB::table('appraisals')
            ->join('employee', 'appraisals.employee_id', '=', 'employee.id')
            ->join('appraisalquestions', 'appraisals.appraisalquestion_id', '=', 'appraisalquestions.id')
            ->join('users', 'appraisals.examiner', '=', 'users.id')
            ->where('employee_id', $id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->whereBetween('appraisaldate', array($from, $to))
            ->select('first_name','last_name','middle_name','comment','appraisals.rate','username','question','performance','appraisaldate')
            ->get();

         $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Appraisal Report', function($excel) use($data,$from,$to,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Appraisal Report', function($sheet) use($data,$from,$to,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');

              $name = '';
              if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }
              $sheet->row(3, array(
              'Appraisal Report for '.$name.' for period between '.$from.' and '.$to
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#','QUESTION', 'PERFORMANCE','RATE','EXAMINER','APPRAISAL DATE','COMMENT'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $sheet->row($row, array(
             $x,$data[$i]->question,$data[$i]->performance,$data[$i]->rate,$data[$i]->username,$data[$i]->appraisaldate,$data[$i]->comment
             ));
             $x++;
             $row++;
             } 
             
             
    });

  })->download('xls');
  }
  
  }else{
        if(Input::get('employeeid') == 'All'){
        
        $from = Input::get("from");
        $to = Input::get("to");

        $appraisals = DB::table('appraisals')
            ->join('employee', 'appraisals.employee_id', '=', 'employee.id')
            ->join('appraisalquestions', 'appraisals.appraisalquestion_id', '=', 'appraisalquestions.id')
            ->join('users', 'appraisals.examiner', '=', 'users.id')
            ->whereBetween('appraisaldate', array($from, $to))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('first_name','last_name','middle_name','comment','appraisals.rate','username','question','performance','appraisaldate')
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.appraisal', compact('from','to', 'organization','appraisals'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream('appraisal.pdf');

        }else{

        $id = Input::get('employeeid');

        $from = Input::get("from");
        $to = Input::get("to");

        $employee = Employee::find($id);

        $appraisals = DB::table('appraisals')
            ->join('employee', 'appraisals.employee_id', '=', 'employee.id')
            ->join('appraisalquestions', 'appraisals.appraisalquestion_id', '=', 'appraisalquestions.id')
            ->join('users', 'appraisals.examiner', '=', 'users.id')
            ->where('employee_id', $id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->whereBetween('appraisaldate', array($from, $to))
            ->select('first_name','last_name','middle_name','comment','appraisals.rate','username','question','performance','appraisaldate')
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.individualappraisal', compact( 'from','to','employee','organization','appraisals'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream($employee->first_name.'_'.$employee->last_name.'_appraisal.pdf');
    }
  }
        
    }

    public function selempkin()
    {
       $employees = Employee::where('employee.organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.selectKinEmployee',compact('employees'));
    }

    public function kin(){

      if(Input::get('format') == "excel"){
        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $data = DB::table('nextofkins')
            ->join('employee', 'nextofkins.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('employee_id', '=', $id)
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Employee Kin Report', function($excel) use($data,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Employee Kin Report', function($sheet) use($data,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:F3');

              $name = '';
              if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }
              $sheet->row(3, array(
              'Kin`s Report for '.$name
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'KIN NAME', 'RELATIONSHIP', 'kIN`S IDENTITY NUMBER','KIN`S CONTACT','GOOD WILL(%)'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             

             
             for($i = 0; $i<count($data); $i++){
            $name ='';
             if($data[$i]->middle_name == ''){
               $name = $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name = $data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $x,$name,$data[$i]->relationship,$data[$i]->id_number,$data[$i]->contact,$data[$i]->goodwill
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  
  }else{

        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $kins = DB::table('nextofkins')
            ->join('employee', 'nextofkins.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('employee_id', '=', $id)
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.kin', compact( 'employee','organization','kins'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream('kin.pdf');
        }
    }

    public function nextkin(){

      if(Input::get('format') == "excel"){
        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $data = DB::table('nextofkins')
            ->join('employee', 'nextofkins.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('employee_id', '=', $id)
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Employee Kin Report', function($excel) use($data,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Employee Kin Report', function($sheet) use($data,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:F3');

              $name = '';
              if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }
              $sheet->row(3, array(
              'Kin`s Report for '.$name
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              '#', 'KIN NAME', 'RELATIONSHIP', 'kIN`S IDENTITY NUMBER','KIN`S CONTACT','GOOD WILL(%)'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
            $x = 1;
             

             
             for($i = 0; $i<count($data); $i++){
            $name ='';
             if($data[$i]->middle_name == ''){
               $name = $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name = $data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $x,$name,$data[$i]->relationship,$data[$i]->id_number,$data[$i]->contact,$data[$i]->goodwill
             ));
             $x++;
             $row++;
             }       
             
             
    });

  })->download('xls');
  
  }else{

        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $kins = DB::table('nextofkins')
            ->join('employee', 'nextofkins.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('employee_id', '=', $id)
            ->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('pdf.nextkin', compact( 'employee','organization','kins'))->setPaper('a4')->setOrientation('potrait');
    
        //dd($organization);

        return $pdf->stream('kin.pdf');
        }
    }


    public function period_payslip()
  {
    $employees = DB::table('employee')->where('employee.organization_id',Confide::user()->organization_id)->get();
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

    return View::make('pdf.payslipSelect', compact('employees','branches','departments'));
  }

    public function payslip(){
    /*
        if(Input::get('sel') != null){
        $period = Input::get("period");
        
        $id = Input::get('employeeid');

        $employees = Employee::all();

        foreach ($employees as $employee) {

        $transacts = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->groupBy('transact.id')
            ->get(); 

        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->groupBy('allowance_name')
            ->get(); 

        $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->groupBy('earning_name')
            ->get(); 

        $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->groupBy('deduction_name')
            ->get();    

        $currencies = DB::table('currencies')
            ->select('shortname')
            ->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.monthlySlip', compact('transacts','allws','deds','earnings','period','currencies', 'organization'))->setPaper('a4')->setOrientation('potrait');
    }
    return $pdf->stream('Monthly_Payslip_'.$period.'.pdf');
    }else{*/

      $period = Input::get("period");


         $transactCount = DB::table('transact')->where('organization_id',Confide::user()->organization_id)->where('financial_month_year', '=', $period)->count();

         if($transactCount < 1){

            return Redirect::back()->with('notice', 'payslip for the selected period does not exist');
         }else{

      if(Input::get('format') == "excel"){
        if(Input::get('employeeid') == 'All'){
        $period = Input::get("period");
        $employees = Employee::where('organization_id',Confide::User()->organization_id)->get();
        foreach ($employees as $employee) {
  

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->first(); 

        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('allowance_name')
            ->get(); 

        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('nontaxable_name')
            ->get(); 

        $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('earning_name')
            ->get(); 

        $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('deduction_name')
            ->get(); 

        $overtimes = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('overtime_type')
            ->get();

        $rels = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', $employee->id)
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('relief_name')
            ->get();

          $save = '';

          $name = '';

          $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

              //dd($employee->middle_name);

              if($employee->middle_name == '' || $employee->middle_name == null){
              $save = $employee->personal_file_number.' - '.$employee->first_name.' '.$employee->last_name;
              }else{
              $save = $employee->personal_file_number.' - '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
              }
              
              if($employee->middle_name == '' || $employee->middle_name == null){
              $name = $employee->first_name.' '.$employee->last_name;
              }else{
              $name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
              }
 
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);
     
    
  Excel::create('Payslips', function($excel) use($data,$nontaxables,$name,$period,$employee,$allws,$earnings,$overtimes,$rels,$deds,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payslip', function($sheet) use($data,$nontaxables,$name,$period,$employee,$allws,$earnings,$overtimes,$rels,$deds,$organization,$currency,$objPHPExcel){
              

              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(2, array(
              'Period: ',$period
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A4:B4');

              $sheet->row(4, array(
              'PERSONAL DETAILS'
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Payroll Number: ', $employee->personal_file_number
              ));

              $sheet->row(5, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(6, array(
              'Employee Name: ', $name
              ));

              $sheet->row(7, array(
              'Identity Number: ', $employee->identity_number
              ));

              $sheet->row(7, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(8, array(
              'KRA Pin: ', $employee->pin
              ));

              $sheet->row(8, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(9, array(
              'Nssf Number: ', $employee->social_security_number
              ));

              $sheet->row(9, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(10, array(
              'Nhif Number: ', $employee->hospital_insurance_number
              ));

              $sheet->row(10, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

               $sheet->row(12, array(
              'EARNINGS ','AMOUNT ('.$currency->shortname.')'
              ));

              $sheet->row(12, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
              
              $sheet->row(13, array(
              'Basic Pay: ', $data->basic_pay
              ));

              $sheet->cell('B13', function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
               
            $row = 14;

             for($i = 0; $i<count($earnings); $i++){
            
             $sheet->row($row, array(
             $earnings[$i]->earning_name,$earnings[$i]->earning_amount
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }   

             for($i = 0; $i<count($overtimes); $i++){
            
             $sheet->row($row, array(
             'Overtime Earning - '.$overtimes[$i]->overtime_type,$overtimes[$i]->overtime_amount * $overtimes[$i]->overtime_period
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }        
             
             $sheet->row($row, array(
              'ALLOWANCES'
              ));

              $sheet->row($row, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              for($i = 0; $i<count($allws); $i++){
            
             $sheet->row($row, array(
             $allws[$i]->allowance_name,$allws[$i]->allowance_amount
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }      

            $sheet->row($row, array(
              'GROSS PAY',$data->taxable_income
            ));

              $sheet->row($row, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });  

              $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

               $r = $row+1;

              for($i = 0; $i<count($nontaxables); $i++){
            
             $sheet->row($r, array(
             $nontaxables[$i]->nontaxable_name,$nontaxables[$i]->nontaxable_amount
             ));
             
             $sheet->cell('B'.$r, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $r++;
             
             }  

              for($i = 0; $i<count($rels); $i++){
            
             $sheet->row($r, array(
             $rels[$i]->relief_name,$rels[$i]->relief_amount
             ));
             
             $sheet->cell('B'.$r, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $r++;
             
             }  

             $sheet->row($r, array(
              'DEDUCTIONS'
              ));

              $sheet->row($r, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

             $sheet->row($r+1, array(
              'Paye:',$data->paye
            ));

              $sheet->cell('B'.($r+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->row($r+2, array(
              'Nssf:',$data->nssf_amount
              ));

              $sheet->cell('B'.($r+2), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
              
              $sheet->row($r+3, array(
              'Nhif:',$data->nhif_amount
              ));

              $sheet->cell('B'.($r+3), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $c = $r+4;

              for($i = 0; $i<count($deds); $i++){
            
             $sheet->row($c, array(
             $deds[$i]->deduction_name,$deds[$i]->deduction_amount
             ));
             
             $sheet->cell('B'.$c, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $c++;
             
             }

             $sheet->row($c, array(
              'TOTAL DEDUCTIONS:',$data->total_deductions
              ));

             $sheet->row($c, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->cell('B'.$c, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              }); 

              $sheet->row($c+1, array(
              'NET PAY:',$data->net
              ));

             $sheet->row($c+1, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->cell('B'.($c+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              }); 
             
    });

  })->download('xls');
  }
  }else{
        $period = Input::get("period");
        
        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $data = DB::table('transact')
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

        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('nontaxable_name')
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

          $save = '';

          $name = '';

          $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

              //dd($employee->middle_name);

              if($employee->middle_name == '' || $employee->middle_name == null){
              $save = $employee->personal_file_number.' - '.$employee->first_name.' '.$employee->last_name;
              }else{
              $save = $employee->personal_file_number.' - '.$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
              }
              
              if($employee->middle_name == '' || $employee->middle_name == null){
              $name = $employee->first_name.' '.$employee->last_name;
              }else{
              $name = $employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
              }
 
        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);
     
    
  Excel::create($save.'_'.$month.' Payslip', function($excel) use($data,$nontaxables,$name,$period,$employee,$allws,$earnings,$overtimes,$rels,$deds,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payslip', function($sheet) use($data,$nontaxables,$name,$period,$employee,$allws,$earnings,$overtimes,$rels,$deds,$organization,$currency,$objPHPExcel){
              

              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(2, array(
              'Period: ',$period
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A4:B4');

              $sheet->row(4, array(
              'PERSONAL DETAILS'
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Payroll Number: ', $employee->personal_file_number
              ));

              $sheet->row(5, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(6, array(
              'Employee Name: ', $name
              ));

              $sheet->row(7, array(
              'Identity Number: ', $employee->identity_number
              ));

              $sheet->row(7, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(8, array(
              'KRA Pin: ', $employee->pin
              ));

              $sheet->row(8, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(9, array(
              'Nssf Number: ', $employee->social_security_number
              ));

              $sheet->row(9, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

              $sheet->row(10, array(
              'Nhif Number: ', $employee->hospital_insurance_number
              ));

              $sheet->row(10, function($cell) {

               // manipulate the cell
                $cell->setAlignment('left');

              });

               $sheet->row(12, array(
              'EARNINGS ','AMOUNT ('.$currency->shortname.')'
              ));

              $sheet->row(12, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
              
              $sheet->row(13, array(
              'Basic Pay: ', $data->basic_pay
              ));

              $sheet->cell('B13', function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
               
            $row = 14;

             for($i = 0; $i<count($earnings); $i++){
            
             $sheet->row($row, array(
             $earnings[$i]->earning_name,$earnings[$i]->earning_amount
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }   

             for($i = 0; $i<count($overtimes); $i++){
            
             $sheet->row($row, array(
             'Overtime Earning - '.$overtimes[$i]->overtime_type,$overtimes[$i]->overtime_amount * $overtimes[$i]->overtime_period
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }        
             
             $sheet->row($row, array(
              'ALLOWANCES'
              ));

              $sheet->row($row, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              for($i = 0; $i<count($allws); $i++){
            
             $sheet->row($row, array(
             $allws[$i]->allowance_name,$allws[$i]->allowance_amount
             ));
             
             $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }      

            $sheet->row($row, array(
              'GROSS PAY',$data->taxable_income
            ));

              $sheet->row($row, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });  

              $sheet->cell('B'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

               $r = $row+1;

              for($i = 0; $i<count($nontaxables); $i++){
            
             $sheet->row($r, array(
             $nontaxables[$i]->nontaxable_name,$nontaxables[$i]->nontaxable_amount
             ));
             
             $sheet->cell('B'.$r, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $r++;
             
             }  

              for($i = 0; $i<count($rels); $i++){
            
             $sheet->row($r, array(
             $rels[$i]->relief_name,$rels[$i]->relief_amount
             ));
             
             $sheet->cell('B'.$r, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $r++;
             
             }  

             $sheet->row($r, array(
              'DEDUCTIONS'
              ));

              $sheet->row($r, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

             $sheet->row($r+1, array(
              'Paye:',$data->paye
            ));

              $sheet->cell('B'.($r+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->row($r+2, array(
              'Nssf:',$data->nssf_amount
              ));

              $sheet->cell('B'.($r+2), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
              
              $sheet->row($r+3, array(
              'Nhif:',$data->nhif_amount
              ));

              $sheet->cell('B'.($r+3), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $c = $r+4;

              for($i = 0; $i<count($deds); $i++){
            
             $sheet->row($c, array(
             $deds[$i]->deduction_name,$deds[$i]->deduction_amount
             ));
             
             $sheet->cell('B'.$c, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $c++;
             
             }

             $sheet->row($c, array(
              'TOTAL DEDUCTIONS:',$data->total_deductions
              ));

             $sheet->row($c, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->cell('B'.$c, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              }); 

              $sheet->row($c+1, array(
              'NET PAY:',$data->net
              ));

             $sheet->row($c+1, function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->cell('B'.($c+1), function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              }); 
             
    });

  })->download('xls');
  }
  }else if(Input::get("employeeid") == 'All'){
    
        $period = Input::get("period");

        $select = Input::get("employeeid");
        
        $id = Input::get('employeeid');

        $empall = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->get(); 

        $currency = DB::table('currencies')
                    ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
                    ->select('shortname')
                    ->first();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.monthlySlip', compact('empall','select','period','currency', 'organization'))->setPaper('a5')->setOrientation('potrait');
  
    return $pdf->stream('Payslips.pdf');

  }else{
      
        $period = Input::get("period");

        $select = Input::get("employeeid");
        
        $id = Input::get('employeeid');

        $employee = Employee::find($id);

        $empall = Employee::where('employee.organization_id',Confide::user()->organization_id)->get();

        $name = '';

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];
              
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

         $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.id' ,'=', Input::get('employeeid'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->groupBy('nontaxable_name')
            ->get(); 

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
 
        $currency = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->first();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.monthlySlip', compact('nontaxables','empall','select','name','employee','transact','allws','deds','earnings','overtimes','rels','period','currency', 'organization','id'))->setPaper('a5')->setOrientation('potrait');
  
    return $pdf->stream($employee->personal_file_number.'_'.$employee->first_name.'_'.$employee->last_name.'_'.$month.'.pdf');
    }
    
  }
}

    public function employee_allowances()
  {
    
    $allws = DB::table('transact_allowances')
    ->where('organization_id',Confide::user()->organization_id)
    ->select(DB::raw('DISTINCT(allowance_name) as allowance_name'))
    ->get();

    return View::make('pdf.allowanceSelect', compact('allws'));
  }

    public function allowances(){
       if(Input::get('format') == "excel"){
          if(Input::get('allowance') == 'All'){
     $data = DB::table('transact_allowances')
                  ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_allowances.financial_month_year' ,'=', Input::get('period'))
                  ->get();

      $dataearning = DB::table('transact_earnings')
                  ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_earnings.financial_month_year' ,'=', Input::get('period'))
                  ->get();

      $dataovertime = DB::table('transact_overtimes')
                  ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_overtimes.financial_month_year' ,'=', Input::get('period'))
                  ->get();

     $total = DB::table('transact_allowances')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("allowance_amount");

      $totalearning = DB::table('transact_earnings')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

     $totalovertime = DB::table('transact_overtimes')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

     $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
     
    
  Excel::create('Allowances Report '.$month, function($excel) use($data,$dataearning,$dataovertime,$total,$totalearning,$totalovertime,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Allowances', function($sheet) use($data,$dataearning,$dataovertime,$total,$totalearning,$totalovertime,$organization,$currency,$objPHPExcel){

              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Allowance Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'Allowance Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });


              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'ALLOWANCE TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->allowance_name,$data[$i]->allowance_amount
             ));
             
             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             } 

             /*for($i = 0; $i<count($dataearning); $i++){

              $ename ='';
              
              if($dataearning[$i]->middle_name == '' || $dataearning[$i]->middle_name == null){
               $ename= $dataearning[$i]->first_name.' '.$dataearning[$i]->last_name;
             }else{
               $ename=$dataearning[$i]->first_name.' '.$dataearning[$i]->middle_name.' '.$dataearning[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $dataearning[$i]->personal_file_number,$ename,$dataearning[$i]->earning_name,$dataearning[$i]->earning_amount
             ));
             
             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             } 

             for($i = 0; $i<count($dataovertime); $i++){

              $oname = '';

              if($dataovertime[$i]->middle_name == '' || $dataovertime[$i]->middle_name == null){
               $oname= $dataovertime[$i]->first_name.' '.$dataovertime[$i]->last_name;
             }else{
               $oname=$dataovertime[$i]->first_name.' '.$dataovertime[$i]->middle_name.' '.$dataovertime[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $dataovertime[$i]->personal_file_number,$oname,$dataovertime[$i]->overtime_type,$dataovertime[$i]->overtime_amount
             ));
             
             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

             $row++;
             
             }*/       
             $sheet->row($row, array(
             '','','Total',$total));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('allowance');
    $data = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('transact_allowances.allowance_name' ,'=', Input::get('allowance'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','transact_allowances.allowance_name','transact_allowances.allowance_amount')
            ->get();

    $dataearning = DB::table('transact_earnings')
                  ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_earnings.financial_month_year' ,'=', Input::get('period'))
                  ->get();

    $dataovertime = DB::table('transact_overtimes')
                  ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_overtimes.financial_month_year' ,'=', Input::get('period'))
                  ->get();

     $total = DB::table('transact_allowances')
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('transact_allowances.allowance_name' ,'=', Input::get('allowance'))
                  ->sum("allowance_amount");

      $totalearning = DB::table('transact_earnings')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

     $totalovertime = DB::table('transact_overtimes')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

     $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    
  Excel::create('Allowances Report '.$month, function($excel) use($data,$currency,$total,$type,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Allowances', function($sheet) use($data,$currency,$total,$type,$organization,$objPHPExcel){

              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Allowance Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Allowance Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });


              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->allowance_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{

      if(Input::get('allowance') == 'All'){
        $period = Input::get("period");
        $type = Input::get('allowance');

        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','allowance_name','allowance_amount')
            ->get();    


        $earnings = DB::table('transact_earnings')
                  ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_earnings.financial_month_year' ,'=', Input::get('period'))
                  ->get();

        $overtimes = DB::table('transact_overtimes')
                  ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_overtimes.financial_month_year' ,'=', Input::get('period'))
                  ->get();

        $totalearning = DB::table('transact_earnings')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

        $totalovertime = DB::table('transact_overtimes')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");


        $total = DB::table('transact_allowances')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("allowance_amount");
 
        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.allowanceReport', compact('allws','earnings','overtimes','totalearning','totalovertime','period','type','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Allowance_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get('allowance');
        $allws = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('transact_allowances.allowance_name' ,'=', Input::get('allowance'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','transact_allowances.allowance_name','transact_allowances.allowance_amount')
            ->get();

        $total = DB::table('transact_allowances')
                  ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
                  ->join('allowances', 'transact_allowances.allowance_id', '=', 'allowances.id')
                  ->where('allowances.id' ,'=', Input::get('allowance'))
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("allowance_amount");

        $earnings = DB::table('transact_earnings')
                  ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                  ->join('earnings', 'transact_earnings.earning_id', '=', 'earnings.id')
                  ->where('earnings.id' ,'=', Input::get('allowance'))
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_earnings.financial_month_year' ,'=', Input::get('period'))
                  ->select('personal_file_number','first_name','last_name','middle_name','transact_earnings.earning_name','transact_earnings.earning_amount')
                  ->get();

        $overtimes = DB::table('transact_overtimes')
                  ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
                  ->join('overtimes', 'transact_overtimes.overtime_id', '=', 'overtimes.id')
                  ->where('overtimes.type' ,'=', Input::get('allowance'))
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_overtimes.financial_month_year' ,'=', Input::get('period'))
                  ->select('personal_file_number','first_name','last_name','middle_name','transact_overtimes.overtime_type','transact_overtimes.overtime_amount')
                  ->get();

        $totalearning = DB::table('transact_earnings')
                  ->join('earnings', 'transact_earnings.earning_id', '=', 'earnings.id')
                  ->where('earnings.id' ,'=', Input::get('allowance'))
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

        $totalovertime = DB::table('transact_overtimes')
                  ->join('overtimes', 'transact_overtimes.overtime_id', '=', 'overtimes.id')
                  ->where('overtimes.type' ,'=', Input::get('allowance'))  
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.allowanceReport', compact('allws','earnings','overtimes','totalearning','totalovertime','name','period','type','currencies','total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Allowance_Report_'.$month.'.pdf');
     }
     }
    
  }


  public function employee_earnings()
  {
    $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select(DB::raw('DISTINCT(earning_name) as earning_name'))
            ->get();

    return View::make('pdf.earningSelect', compact('earnings'));
  }

    public function earnings(){
         if(Input::get('format') == "excel"){
          if(Input::get('earning') == 'All'){
     $data = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','transact_earnings.earning_name','transact_earnings.earning_amount')
            ->get();    

     $total = DB::table('transact_earnings')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    
  Excel::create('Earnings Report '.$month, function($excel) use($data,$currency,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Earnings', function($sheet) use($data,$total,$currency,$organization,$objPHPExcel){
              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Earning Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

                 
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'Earning Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'Earning TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->earning_name,$data[$i]->earning_amount
             ));

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('earning');
    $data = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('transact_earnings.earning_name' ,'=', Input::get('earning'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_earnings.earning_name','transact_earnings.earning_amount')
            ->get();

    $total = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('transact_earnings.earning_name' ,'=', Input::get('earning'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->sum("earning_amount");

    $organization = Organization::find(Confide::user()->organization_id);
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];
    
  Excel::create('Earnings Report '.$month, function($excel) use($data,$total,$type,$currency,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Earnings', function($sheet) use($data,$total,$type,$currency,$organization,$objPHPExcel){

    $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Earnings Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Earning Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->earning_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{
      if(Input::get('earning') == 'All'){
        $period = Input::get("period");
        $type = Input::get("earning");
        $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','earning_name','earning_amount')
            ->get();    
 
        $total = DB::table('transact_earnings')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.earningReport', compact('earnings','type','period','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Earning_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get("earning");
      $earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('transact_earnings.earning_name' ,'=', Input::get('earning'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_earnings.earning_name','transact_earnings.earning_amount')
            ->get();

        $total = DB::table('transact_earnings')
                  ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
                  ->where('transact_earnings.earning_name' ,'=', Input::get('earning'))
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("earning_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.earningReport', compact('earnings','name','type','period','currencies', 'total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Earning_Report_'.$month.'.pdf');
    }
    }
    
  }

  public function employee_overtimes()
  {

    return View::make('pdf.overtimeSelect');
  }

    public function overtimes(){
         if(Input::get('format') == "excel"){
          if(Input::get('overtime') == 'All'){
     $data = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','transact_overtimes.overtime_type','transact_overtimes.overtime_amount')
            ->get();    

     $total = DB::table('transact_overtimes')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    
  Excel::create('Overtimes Report '.$month, function($excel) use($data,$currency,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Overtimes', function($sheet) use($data,$total,$currency,$organization,$objPHPExcel){
              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Overtime Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

                 
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'overtime Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'OVERTIME TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->overtime_type,$data[$i]->overtime_amount
             ));

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('overtime');
    $data = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('overtime_type' ,'=', Input::get('overtime'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_overtimes.overtime_type','transact_overtimes.overtime_amount')
            ->get();

    $total = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('overtime_type' ,'=', Input::get('overtime'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->sum("overtime_amount");

    $organization = Organization::find(Confide::user()->organization_id);
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];
    
  Excel::create('Overtimes Report '.$month, function($excel) use($data,$total,$type,$currency,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Overtimes', function($sheet) use($data,$total,$type,$currency,$organization,$objPHPExcel){

    $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Overtimes Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Overtime Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->overtime_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{
      if(Input::get('overtime') == 'All'){
        $period = Input::get("period");
        $type = Input::get("overtime");
        $overtimes = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','overtime_type','overtime_amount')
            ->get();    
 
        $total = DB::table('transact_overtimes')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.overtimeReport', compact('overtimes','type','period','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Overtimes_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get("overtime");
        $name = $type;
      $overtimes = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('overtime_type' ,'=', Input::get('overtime'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_overtimes.overtime_type','transact_overtimes.overtime_amount')
            ->get();

        $total = DB::table('transact_overtimes')
                  ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
                  ->where('overtime_type' ,'=', Input::get('overtime'))
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("overtime_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.overtimeReport', compact('overtimes','name','type','period','currencies', 'total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Overtime_Report_'.$month.'.pdf');
    }
    }
    
  }


  public function employee_reliefs()
  {
    $reliefs = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select(DB::raw('DISTINCT(relief_name) as relief_name'))
            ->get();

    return View::make('pdf.reliefSelect', compact('reliefs'));
  }

    public function reliefs(){
         if(Input::get('format') == "excel"){
          if(Input::get('relief') == 'All'){
     $data = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select('personal_file_number','first_name','last_name','middle_name','transact_reliefs.relief_name','transact_reliefs.relief_amount')
            ->get();    

     $total = DB::table('transact_reliefs')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("relief_amount");

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    
  Excel::create('Reliefs Report '.$month, function($excel) use($data,$currency,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Reliefs', function($sheet) use($data,$total,$currency,$organization,$objPHPExcel){
              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Relief Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

                 
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'Relief Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'RELIEF TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->relief_name,$data[$i]->relief_amount
             ));

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('relief');
    $data = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('transact_reliefs.relief_name' ,'=', Input::get('relief'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_reliefs.relief_name','transact_reliefs.relief_amount')
            ->get();

    $total = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('transact_reliefs.relief_name' ,'=', Input::get('relief'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->sum("relief_amount");

    $organization = Organization::find(Confide::user()->organization_id);
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];
    
  Excel::create('Relief Report '.$month, function($excel) use($data,$total,$type,$currency,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Reliefs', function($sheet) use($data,$total,$type,$currency,$organization,$objPHPExcel){

    $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Relief Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Relief Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->relief_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{
      if(Input::get('relief') == 'All'){
        $period = Input::get("period");
        $type = Input::get("relief");
        $reliefs = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','relief_name','relief_amount')
            ->get();    
 
        $total = DB::table('transact_reliefs')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("relief_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.reliefReport', compact('reliefs','type','period','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Relief_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get("relief");
        $reliefs = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('transact_reliefs.relief_name' ,'=', Input::get('relief'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_reliefs.relief_name','transact_reliefs.relief_amount')
            ->get();

        $total = DB::table('transact_reliefs')
                  ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_reliefs.relief_name' ,'=', Input::get('relief'))
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("relief_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.reliefReport', compact('reliefs','name','type','period','currencies', 'total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Relief_Report_'.$month.'.pdf');
    }
    }
    
  }


  public function employee_deductions()
  {
    $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
            ->get();

    return View::make('pdf.deductionSelect', compact('deds'));
  }

    public function deductions(){
         if(Input::get('format') == "excel"){
          if(Input::get('deduction') == 'All'){
     $data = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_deductions.deduction_name','transact_deductions.deduction_amount')
            ->get();    

     $total = DB::table('transact_deductions')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("deduction_amount");

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    
  Excel::create('Deductions Report '.$month, function($excel) use($data,$currency,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Deductions', function($sheet) use($data,$total,$currency,$organization,$objPHPExcel){
              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Deduction Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

                 
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'Deduction Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'DEDUCTION TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->deduction_name,$data[$i]->deduction_amount
             ));

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('deduction');
    $data = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('transact_deductions.deduction_name' ,'=', Input::get('deduction'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_deductions.deduction_name','transact_deductions.deduction_amount')
            ->get();

    $total = DB::table('transact_deductions')
                  ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_deductions.deduction_name' ,'=', Input::get('deduction'))
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("deduction_amount");

    $organization = Organization::find(Confide::user()->organization_id);
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];
    
  Excel::create('Deductions Report '.$month, function($excel) use($data,$total,$type,$currency,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Deductions', function($sheet) use($data,$total,$type,$currency,$organization,$objPHPExcel){

    $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Deduction Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Deduction Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->deduction_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{
      if(Input::get('deduction') == 'All'){
        $period = Input::get("period");
        $type = Input::get("deduction");
        $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','deduction_name','deduction_amount')
            ->get();    
 
        $total = DB::table('transact_deductions')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("deduction_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.deductionReport', compact('deds','type','period','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Deduction_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get("deduction");
      $deds = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('transact_deductions.deduction_name' ,'=', Input::get('deduction'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_deductions.deduction_name','transact_deductions.deduction_amount')
            ->get();

        $total = DB::table('transact_deductions')
                  ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_deductions.deduction_name' ,'=', Input::get('deduction'))
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("deduction_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.deductionReport', compact('deds','name','type','period','currencies', 'total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Deduction_Report_'.$month.'.pdf');
    }
    }
    
  }


  public function employeenontaxableselect()
  {
    $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->select(DB::raw('DISTINCT(nontaxable_name) as nontaxable_name'))
            ->get();

    return View::make('pdf.nontaxableSelect', compact('nontaxables'));
  }

    public function employeenontaxables(){
         if(Input::get('format') == "excel"){
          if(Input::get('income') == 'All'){
     $data = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_nontaxables.nontaxable_name','transact_nontaxables.nontaxable_amount')
            ->get();    

     $total = DB::table('transact_nontaxables')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("nontaxable_amount");

    $organization = Organization::find(Confide::user()->organization_id);

    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];

    
  Excel::create('Non Taxable Income Report '.$month, function($excel) use($data,$currency,$total,$organization) {
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Non taxable Income', function($sheet) use($data,$total,$currency,$organization,$objPHPExcel){
              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Non Taxable Income Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

                 
              $sheet->mergeCells('A6:D6');
              $sheet->row(6, array(
              'Non Taxable Income Report'
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'Income TYPE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->nontaxable_name,$data[$i]->nontaxable_amount
             ));

             $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('D'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else{
    $type = Input::get('income');
    $data = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('transact_nontaxables.nontaxable_name' ,'=', Input::get('income'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_nontaxables.nontaxable_name','transact_nontaxables.nontaxable_amount')
            ->get();

    $total = DB::table('transact_nontaxables')
                  ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_nontaxables.nontaxable_name' ,'=', Input::get('income'))
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("nontaxable_amount");

    $organization = Organization::find(Confide::user()->organization_id);
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."-".$part[1];
    
  Excel::create('Non Taxable Income Report '.$month, function($excel) use($data,$total,$type,$currency,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Non Taxable Income', function($sheet) use($data,$total,$type,$currency,$organization,$objPHPExcel){

    $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Non Taxable Income Report'
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Period: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');
              $sheet->row(6, array(
              'Non Taxable Income Report for '.$type
              ));

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(8, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 9;

             
             
             for($i = 0; $i<count($data); $i++){
             
             $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->nontaxable_amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
  }else{
      if(Input::get('income') == 'All'){
        $period = Input::get("period");
        $type = Input::get("income");
        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','nontaxable_name','nontaxable_amount')
            ->get();    
 
        $total = DB::table('transact_nontaxables')
                  ->where('organization_id',Confide::user()->organization_id)
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("nontaxable_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.nontaxableReport', compact('nontaxables','type','period','currencies','total', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Non_Taxable_Income_Report_'.$month.'.pdf');
    }else{
        $period = Input::get("period");
        $type = Input::get("income");
        $nontaxables = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('transact_nontaxables.nontaxable_name' ,'=', Input::get('income'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select('personal_file_number','first_name','last_name','middle_name','transact_nontaxables.nontaxable_name','transact_nontaxables.nontaxable_amount')
            ->get();

        $total = DB::table('transact_nontaxables')
                  ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->where('transact_nontaxables.nontaxable_name' ,'=', Input::get('income'))
                  ->where('financial_month_year' ,'=', Input::get('period'))
                  ->sum("nontaxable_amount");

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.nontaxableReport', compact('nontaxables','name','type','period','currencies', 'total','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Non_Taxable_Income_Report_'.$month.'.pdf');
    }
    }
    
  }

  public function getDownload()
  {
     
        $file= public_path(). "/templates/P10_Return_version_8.0_21032016093001.xlsm";
        
        return Response::download($file, 'P10_Return_version_8.0_21032016093001.xlsm');
  }
  

     public function period_paye()
  {
    return View::make('pdf.payeSelect');
  }

    public function payeReturns(){
      if(Input::get('format') == "excel"){
       $total_enabled = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->where('income_tax_applicable' ,'=', 1)
        ->sum('paye');

      $total_disabled = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->where('income_tax_applicable' ,'=', 0)
        ->sum('paye');

       $payes_enabled = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('income_tax_applicable' ,'=', 1)
            ->get(); 

        $payes_disabled = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('income_tax_applicable' ,'=', 0)
            ->get(); 

       $organization = Organization::find(Confide::user()->organization_id);

       $period = Input::get('period');

       $type = Input::get('type');

       $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Paye Report '.$month, function($excel) use($type,$period,$total_enabled,$total_disabled,$payes_enabled,$payes_disabled,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Paye Report', function($sheet) use($type,$period,$total_enabled,$total_disabled,$payes_enabled,$payes_disabled,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(2, array(
              'Period: ',$period
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $due = 0;
              $year = 0;
              $per = explode("-", $period);
              if($per[0] == 12){
               $due = 01;
               $year = $per[1]+1;
              }else{
              $due = $per[0]+1;
              if(strlen($due) == 1){
                $due = "0".$due;
              }else{
                $due = $due;
              }
              $year = $per[1];
              }

              $sheet->row(3, array(
              'Due Date: ', '09-'.$due.'-'.$year
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NO.', 'EMPLOYEE NAME', 'ID Number', 'KRA Pin','Gross Pay','Paye'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             if($type == 'enabled'){
             for($i = 0; $i<count($payes_enabled); $i++){

              $name = '';

              if($payes_enabled[$i]->middle_name == '' || $payes_enabled[$i]->middle_name == null){
               $name= $payes_enabled[$i]->first_name.' '.$payes_enabled[$i]->last_name;
             }else{
               $name=$payes_enabled[$i]->first_name.' '.$payes_enabled[$i]->middle_name.' '.$payes_enabled[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $payes_enabled[$i]->personal_file_number,$name,$payes_enabled[$i]->identity_number,$payes_enabled[$i]->pin,$payes_enabled[$i]->taxable_income,$payes_enabled[$i]->paye
             ));
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','Total',$total_enabled
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });

          }else{
           for($i = 0; $i<count($payes_disabled); $i++){
            $name = '';

            if($payes_disabled[$i]->middle_name == '' || $payes_disabled[$i]->middle_name == null){
               $name= $payes_disabled[$i]->first_name.' '.$payes_disabled[$i]->last_name;
             }else{
               $name=$payes_disabled[$i]->first_name.' '.$payes_disabled[$i]->middle_name.' '.$payes_disabled[$i]->last_name;
             }

             $sheet->row($row, array(
             $payes_disabled[$i]->personal_file_number,$name,$payes_disabled[$i]->identity_number,$payes_disabled[$i]->pin,$payes_disabled[$i]->taxable_income,$payes_disabled[$i]->paye
             ));
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','Total',$total_disabled
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });
          }
             
    });

  })->download('xls');
  
  }else if(Input::get('format') == "csv"){

        if(Input::get('type') == "enabled"){

        $period = Input::get('period');

        $data = DB::table('employee')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('income_tax_applicable' ,'=', 1)
            ->get();

        $data_disabled = DB::table('employee')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('income_tax_applicable' ,'=', 0)
            ->get();


         $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];
    
  Excel::create('B_Employee_Dtls_'.$month, function($excel) use($data,$period) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('B_Employee_Dtls', function($sheet) use($data,$period,$objPHPExcel){
                  
            $row = 1;
            
             for($i = 0; $i<count($data); $i++){

              $type = '';
              $name = '';
              $ac = '';
              $mortgage = '';
              $deposit = '';
              $relief = '';

              if($data[$i]->type_id == 1){
                $type = 'Primary Employee';
              }else{
                $type = 'Secondary Employee';
              }

              if($data[$i]->middle_name != '' && $data[$i]->middle_name != null){
                $name = $data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
              }else{
                $name = $data[$i]->first_name.' '.$data[$i]->last_name;
              }

              if($data[$i]->type_id == 1){
                $ac = 0;
              }else{
                $ac = '';
              }

              if($data[$i]->type_id == 1){
                $mortgage = 0;
              }else{
                $mortgage = '';
              }

              if($data[$i]->type_id == 1){
                $deposit = 0;
              }else{
                $deposit = '';
              }

              if($data[$i]->type_id == 1){
                $relief = 1162.00;
              }else{
                $relief = '';
              }
            
             $sheet->row($row, array(
             $data[$i]->pin,$name,'Resident',$type,Payroll::processedsalaries($data[$i]->personal_file_number,$period),
             Payroll::processedhouseallowances($data[$i]->id,$period),Payroll::processedtransportallowances($data[$i]->id,$period),
             0,Payroll::processedovertimes($data[$i]->id,$period),0,0,Payroll::processedotherallowances($data[$i]->id,$period),'',
             0,0,'',0,'Benefit not given','','','','','','',$ac,'',$mortgage,$deposit,'','','',$relief,Payroll::processedreliefs($data[$i]->id,$period),
             '',0
             )); 
             $row++;  
            }        
    });

  })->download('csv');

   }else{

    $period = Input::get('period');

        $data_disabled = DB::table('employee')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('income_tax_applicable' ,'=', 0)
            ->get();

            $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

  Excel::create('C_Disabled_Employee_Dtls_'.$month, function($excel) use($data_disabled,$period) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('C_Disabled_Employee_Dtls', function($sheet) use($data_disabled,$period,$objPHPExcel){
                  
            $row = 1;
            
             for($i = 0; $i<count($data_disabled); $i++){

              $type = '';
              $name = '';
              $ac = '';
              $mortgage = '';
              $deposit = '';
              $relief = '';

              if($data_disabled[$i]->type_id == 1){
                $type = 'Primary Employee';
              }else{
                $type = 'Secondary Employee';
              }

              if($data_disabled[$i]->middle_name != '' && $data_disabled[$i]->middle_name != null){
                $name = $data_disabled[$i]->first_name.' '.$data_disabled[$i]->middle_name.' '.$data_disabled[$i]->last_name;
              }else{
                $name = $data_disabled[$i]->first_name.' '.$data_disabled[$i]->last_name;
              }

              if($data_disabled[$i]->type_id == 1){
                $ac = 0;
              }else{
                $ac = '';
              }

              if($data_disabled[$i]->type_id == 1){
                $mortgage = 0;
              }else{
                $mortgage = '';
              }

              if($data_disabled[$i]->type_id == 1){
                $deposit = 0;
              }else{
                $deposit = '';
              }

              if($data_disabled[$i]->type_id == 1){
                $relief = 1162.00;
              }else{
                $relief = '';
              }
            
             $sheet->row($row, array(
             $data_disabled[$i]->pin,$name,'Resident',$type,0,Payroll::processedsalaries($data_disabled[$i]->personal_file_number,$period),
             Payroll::processedhouseallowances($data_disabled[$i]->id,$period),Payroll::processedtransportallowances($data_disabled[$i]->id,$period),
             0,Payroll::processedovertimes($data_disabled[$i]->id,$period),0,0,Payroll::processedotherallowances($data_disabled[$i]->id,$period),'',
             0,0,'',0,'Benefit not given','','','','','','',$ac,'',$mortgage,$deposit,'','','','',$relief,Payroll::processedreliefs($data_disabled[$i]->id,$period),
             '',0
             )); 
             $row++;  
            }        
    });

  })->download('csv');

}
  
  }else{

    $type = Input::get('type');

    $period = Input::get("period");

    $total_enabled = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->where('income_tax_applicable' ,'=', 1)
        ->sum('paye');

    $total_disabled = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->where('income_tax_applicable' ,'=', 0)
        ->sum('paye');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $payes_enabled = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('income_tax_applicable' ,'=', 1)
            ->get(); 

    $payes_disabled = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('income_tax_applicable' ,'=', 0)
            ->get(); 
    
    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.payeReport', compact('payes_enabled','payes_disabled','type','total_enabled','total_disabled','currencies','period','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Paye_Returns_'.$month.'.pdf');
    }
  }

   public function period_nssf()
  {
    return View::make('pdf.nssfSelect');
  }

    public function nssfReturns(){

        if(Input::get('format') == "excel"){
       $total = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('social_security_applicable' ,'=', 1)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nssf_amount');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('social_security_applicable' ,'=', 1)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

       $organization = Organization::find(Confide::user()->organization_id);

       $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Nssf Report '.$month, function($excel) use($data,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Nssf Report', function($sheet) use($data,$total,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Employer Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(2, array(
              'Employer Code: ',$organization->nssf_no
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Contribution Period: ', Input::get('period')
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PAYROLL NO.', 'EMPLOYEE NAME', 'NSSF NO.', 'STD AMT.','VOL AMT.','TOTAL AMT.','ID NO.','REMARKS'
              ));

              $sheet->row(4, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 5;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';
            
             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->social_security_number,$data[$i]->nssf_amount,'',$data[$i]->nssf_amount*2,$data[$i]->identity_number,''
             ));
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total','',$total,'',$total*2,'',''
             ));
            $sheet->row($row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });
             
    });

  })->download('xls');
  
  }else{
    $period = Input::get("period");

    $total = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('employee.organization_id',Confide::user()->organization_id)
    ->where('social_security_applicable' ,'=', 1)
    ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nssf_amount');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $nssfs = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('social_security_applicable' ,'=', 1)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];


    $pdf = PDF::loadView('pdf.nssfReport', compact('nssfs','total','currencies','period','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('nssf_Report_'.$month.'.pdf');
    
  }
    }
    

    public function period_nhif()
  {
    return View::make('pdf.nhifSelect');
  }

    public function nhifReturns(){
        if(Input::get('format') == "excel"){

       $total = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('hospital_insurance_applicable' ,'=', 1)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nhif_amount');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('hospital_insurance_applicable' ,'=', 1)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

       $organization = Organization::find(Confide::user()->organization_id);

       $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

              $per = $part[1]."-".$m;

    
  Excel::create('Nhif Report '.$month, function($excel) use($per,$data,$total,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Nhif Report', function($sheet) use($per,$data,$total,$organization,$objPHPExcel){

              $sheet->row(1, array(
              'EMPLOYER CODE',$organization->nhif_no
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'EMPLOYER NAME',$organization->name
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'MONTH OF CONTRIBUTION', $per
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NO', 'LAST NAME','FIRST NAME','ID NO', 'NHIF NO','AMOUNT'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';
            
             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$data[$i]->last_name,$data[$i]->first_name,$data[$i]->identity_number,$data[$i]->hospital_insurance_number,$data[$i]->nhif_amount
             ));
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','Total',$total
             ));
            $sheet->cell('E'.$row, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

        });
             
    });

  })->download('xls');
  
  }else{
    $period = Input::get("period");

    $total = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('employee.organization_id',Confide::user()->organization_id)
    ->where('hospital_insurance_applicable' ,'=', 1)
    ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nhif_amount');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $nhifs = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('hospital_insurance_applicable' ,'=', 1)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];


    $pdf = PDF::loadView('pdf.nhifReport', compact('nhifs','total','currencies','period','organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('nhif_Report_'.$month.'.pdf');
    }
  }

    

    public function period_rem()
  {
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $depts = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    return View::make('pdf.remittanceSelect',compact('branches','depts'));
  }

    public function payeRems(){

        if(Input::get('format') == "excel"){
        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
         $total = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('mode_of_payment' ,'=', 'Bank')
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Remittance Report '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Remittance Report', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Currency:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'Period:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'BANK TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->net
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

            $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }else if(Input::get('department') == 'All'){

         $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

         $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];
    
  Excel::create('Remittance Report '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Remittance Report', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Currency:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'Period:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'BANK TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->net
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

            $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }else if(Input::get('branch') == 'All'){
          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('department_id' ,'=', Input::get('department'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];
    
  Excel::create('Remittance Report '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Remittance Report', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Currency:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'Period:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'BANK TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->net
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

            $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');
        
        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('department_id' ,'=', Input::get('department'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

    
  Excel::create('Remittance Report '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Remittance Report', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'Currency:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'Period:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'SALARY ADVANCE TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->net
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

            $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }
  }else{

    $period = Input::get("period");
    

        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){

          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $rems = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];


    $pdf = PDF::loadView('pdf.remittanceReport', compact('rems','branch','bank','total','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Pay_Remittance_'.$month.'.pdf');

        }else if(Input::get('department') == 'All'){
          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $rems = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.remittanceReport', compact('rems','branch','bank','total','emps','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Pay_Remittance_'.$month.'.pdf');

        } else if(Input::get('branch') == 'All'){
          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $rems = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('department_id' ,'=', Input::get('department'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.remittanceReport', compact('rems','total','branch','bank','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Pay_Remittance_'.$month.'.pdf');

        }  else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
          $total = DB::table('transact')
          ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('financial_month_year' ,'=', Input::get('period'))
      ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $rems = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.remittanceReport', compact('rems','branch','bank','total','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Pay_Remittance_'.$month.'.pdf');

        }                       
    
        }
  }


   public function period_summary()
  {
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $depts = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    return View::make('pdf.summarySelect',compact('branches','depts'));
  }

    public function paySummary(){
    
        if(Input::get('format') == "excel"){
        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
         $total_pay = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('transact.basic_pay');

         $total_earning = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('earning_amount');

         $total_gross = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('paye');

         $total_nssf = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nssf_amount');

         $total_nhif = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nhif_amount');

        $total_others = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('other_deductions');

        $total_deds = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('total_deductions');

        $total_net = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_allowance = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
             ->select(DB::raw('DISTINCT(allowance_name) as allowance_name'))
            ->get(); 

        $data_nontax = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(nontaxable_name) as nontaxable_name'))
            ->get();
        
        $data_earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(earning_name) as earning_name'))
            ->get();

        $data_overtime = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_overtime_hourly = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Hourly')
            ->get();

        $data_overtime_daily = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Daily')
            ->get();

        $data_relief = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(relief_name) as relief_name'))
            ->get();

        $data_deduction = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Payroll Summary '.$month, function($excel) use($data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payroll Summary', function($sheet) use($data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency,$objPHPExcel){
            
              $sheet->row(1, array(
              'BRANCH: ','ALL'
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ','ALL'
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(6, array(
              'PAYROLL SUMMARY'
              ));

              
              
              $earnings = DB::table('transact_earnings')->get();
              $allowances = DB::table('transact_allowances')->get();
              $nontax = DB::table('transact_nontaxables')->get();
              $reliefs = DB::table('transact_reliefs')->get();
              $deductions = DB::table('transact_deductions')
              ->where('financial_month_year' ,'=', Input::get('period'))
              ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
              ->get();

              $earns = array();
              $allws = array();
              $rels  = array();
              $deds  = array(); 
        

              
              $sheet->SetCellValue("A7","PAYROLL NO.");
              $sheet->SetCellValue("B7","EMPLOYEE");
              $sheet->SetCellValue("C7","BASIC PAY");

              $row = 7;
              
              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $column = '';
              
              for ($column = 'D',$i=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$i<count($data_earnings); $column++,$i++) {
                $sheet->setCellValue($column.$row, strtoupper($data_earnings[$i]->earning_name));
              }

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$row,"OVERTIME - HOURLY");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$row,"OVERTIME - DAILY");

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

             
              for ($column = $columnLetter,$j=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$j<count($data_allowance); $column++,$j++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_allowance[$j]->allowance_name));
              } 

              
               
              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$row,"GROSS PAY");

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1);          

             
              for ($column = $columnLetter1,$k=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$k<count($data_nontax); $column++,$k++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_nontax[$k]->nontaxable_name));
              } 

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$row,"TOTAL INCOME TAX");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$row,"INCOME TAX RELIEF");


              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 
             
              for ($column = $columnLetter2,$l=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$l<count($data_relief); $column++,$l++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_relief[$l]->relief_name));
              } 
 
              $columnLetter3 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4); 

              $sheet->SetCellValue($columnLetter3.$row,"PAYE");

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5); 

              $sheet->SetCellValue($columnLetter4.$row,"NSSF AMOUNT");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6); 

              $sheet->SetCellValue($columnLetter5.$row,"NHIF AMOUNT");

              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 
             
              for ($column = $columnLetter6,$m=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)),$m<count($deductions); $column++,$m++) {
               
               $sheet->setCellValue($column.$row, strtoupper($deductions[$m]->deduction_name));
              } 

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7); 

              $sheet->SetCellValue($columnLetter4.$row,"TOTAL DEDUCTIONS");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8); 

              $sheet->SetCellValue($columnLetter5.$row,"NET PAY");

              $sheet->mergeCells('A6:'.$columnLetter5.'6');

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(7, function ($r) {

              $r->setFontWeight('bold');
 
              });

              $r = 8;
              $salaries = 0;
              $totalearning = 0;
              $totalhourly = 0;
              $totaldaily = 0;
              $totalgross = 0;
              $totalnontax = 0;
              $totalrelief = 0;
              $totaltax = 0;
              $totaltaxrelief = 0;
              $totalpaye = 0;
              $totalnssf = 0;
              $totalnhif = 0;
              $totaldeduction = 0;
              $totalnet = 0;
              

              for($i = 0; $i<count($data); $i++){
                $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
                 $sheet->SetCellValue("A".$r,$data[$i]->personal_file_number);
                 $sheet->SetCellValue("B".$r,$name);
                 $sheet->SetCellValue("C".$r,$data[$i]->basic_pay);
                 $salaries = $salaries + $data[$i]->basic_pay;
                 $r++;
              }

              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $re = 8;

              $column = '';

              for($i = 0; $i<count($data); $i++){
              for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++) {
                $sheet->setCellValue($column.$re, Payroll::transactearnings($data[$i]->personal_file_number,$data_earnings[$c]->earning_name,Input::get("period")));
              }
              $re++;
              }

              $roh = 8;

             for($e = 0; $e<count($data); $e++){
              
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period")));
               $totalhourly = $totalhourly + Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period"));
               $roh++;
              } 

              $rod = 8;

              for($b = 0; $b<count($data); $b++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period")));
               $totaldaily = $totaldaily + Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period"));
               $rod++;

              } 

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

              $ra = 8;

             for($n = 0; $n<count($data); $n++){
              for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
               $sheet->setCellValue($column.$ra, Payroll::transactallowances($data[$n]->personal_file_number,$data_allowance[$f]->allowance_name,Input::get("period")));
              } 
              $ra++;
            }

            $rg = 8;
              for($i = 0; $i<count($data); $i++){
                $name = '';
                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$rg,$data[$i]->taxable_income);
                 $totalgross = $totalgross + $data[$i]->taxable_income;
                 $rg++;
              }

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1); 

              $rnt = 8;         

             for($g=0;$g<count($data);$g++){
              for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
               $sheet->setCellValue($column.$rnt, Payroll::transactnontaxables($data[$g]->personal_file_number,$data_nontax[$o]->nontaxable_name,Input::get("period")));
              } 

              $rnt++;

            }

              $relieftotal = 0;

              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 

              $rel = 8;         

             for($h=0;$h<count($data);$h++){
             
              for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
               $sheet->setCellValue($column.$rel, Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period")));
               $relieftotal = $relieftotal + Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period"));
              } 

              $rel++;
              }

              $rtax=8;

              for($w = 0; $w<count($data); $w++){

                $incometaxreliefapply = 0;

                $incometax = 0;

                if($data[$w]->income_tax_applicable=='1'){
                $incometax = Payroll::totaltransacttax($data[$w]->id,Input::get("period"));
                }else{
                  $incometax = 0;
                }

                if($data[$w]->income_tax_relief_applicable=='1'){
                $incometaxreliefapply = 1162;
                }else{
                  $incometaxreliefapply = 0;
                }


               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $incometax);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $incometaxreliefapply);
               $totaltax = $totaltax + $incometax;
               $totaltaxrelief = $totaltaxrelief + $incometaxreliefapply;
               $rtax++;

              }

              $rp=8;

              for($q = 0; $q<count($data); $q++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $data[$q]->paye);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $data[$q]->nssf_amount);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $data[$q]->nhif_amount);
               $totalpaye = $totalpaye + $data[$q]->paye;
               $totalnssf = $totalnssf + $data[$q]->nssf_amount;
               $totalnhif = $totalnhif + $data[$q]->nhif_amount;
               $rp++;

              }


              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 

              $rded = 8;

              for($v = 0; $v<count($data); $v++){
             
              for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
               $sheet->setCellValue($column.$rded, Payroll::transactdeductions($data[$v]->personal_file_number,$data_deduction[$s]->deduction_name,Input::get("period")));
              } 

               $rded++;

              }

              $rn = 8;

              for($u = 0; $u<count($data); $u++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $data[$u]->total_deductions);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $data[$u]->net);
               $totaldeduction = $totaldeduction + $data[$u]->total_deductions;
               $totalnet = $totalnet + $data[$u]->net;
               $rn++;

              }
              
                 $sheet->SetCellValue("B".$r,"TOTALS");
                 $sheet->SetCellValue("C".$r, $salaries);
                 for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++){
                 $sheet->setCellValue($column.$r, Payroll::totaltransactearnings($data_earnings[$c]->earning_name,'All','All',Input::get("period")));
                 }
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, $totalhourly);
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, $totaldaily);
                 for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
                 $sheet->setCellValue($column.$r, Payroll::totaltransactallowances($data_allowance[$f]->allowance_name,'All','All',Input::get("period")));
                 } 

                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$r,$totalgross);

                 for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactnontaxables($data_nontax[$o]->nontaxable_name,'All','All',Input::get("period")));
                } 

                 for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactreliefs($data_relief[$p]->relief_name,'All','All',Input::get("period")));
                } 

                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $totaltax);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $totaltaxrelief);
               
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $totalpaye);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $totalnssf);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $totalnhif);
               
                for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactdeductions($data_deduction[$s]->deduction_name,'All','All',Input::get("period")));
                } 

               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $totaldeduction);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $totalnet);
               
               
              $sheet->row($r, function ($rls) {

             // call cell manipulation methods
              $rls->setFontWeight('bold');
 
              });

             
    });

  })->download('xls');
  }else if(Input::get('department') == 'All'){

    $sels = DB::table('branches')->find(Input::get('branch')); 

         $total_pay = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('transact.basic_pay');

         $total_earning = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('earning_amount');

         $total_gross = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('paye');

         $total_nssf = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nssf_amount');

         $total_nhif = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nhif_amount');

        $total_others = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('other_deductions');

        $total_deds = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('total_deductions');

        $total_net = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_allowance = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('financial_month_year' ,'=', Input::get('period'))
             ->select(DB::raw('DISTINCT(allowance_name) as allowance_name'))
            ->get(); 

        $data_nontax = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(nontaxable_name) as nontaxable_name'))
            ->get();
        
        $data_earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(earning_name) as earning_name'))
            ->get();

        $data_overtime = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_overtime_hourly = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Hourly')
            ->get();

        $data_overtime_daily = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Daily')
            ->get();

        $data_relief = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(relief_name) as relief_name'))
            ->get();

        $data_deduction = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Payroll Summary '.$month, function($excel) use($sels,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payroll Summary', function($sheet) use($sels,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency,$objPHPExcel){
            
              $sheet->row(1, array(
              'BRANCH: ',strtoupper($sels->name)
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ','ALL'
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(6, array(
              'PAYROLL SUMMARY'
              ));

              
              
              $earnings = DB::table('transact_earnings')->get();
              $allowances = DB::table('transact_allowances')->get();
              $nontax = DB::table('transact_nontaxables')->get();
              $reliefs = DB::table('transact_reliefs')->get();
              $deductions = DB::table('transact_deductions')
              ->where('financial_month_year' ,'=', Input::get('period'))
              ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
              ->get();

              $earns = array();
              $allws = array();
              $rels  = array();
              $deds  = array(); 
        

              
              $sheet->SetCellValue("A7","PAYROLL NO.");
              $sheet->SetCellValue("B7","EMPLOYEE");
              $sheet->SetCellValue("C7","BASIC PAY");

              $row = 7;
              
              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $column = '';
              
              for ($column = 'D',$i=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$i<count($data_earnings); $column++,$i++) {
                $sheet->setCellValue($column.$row, strtoupper($data_earnings[$i]->earning_name));
              }

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$row,"OVERTIME - HOURLY");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$row,"OVERTIME - DAILY");

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

             
              for ($column = $columnLetter,$j=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$j<count($data_allowance); $column++,$j++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_allowance[$j]->allowance_name));
              } 

              
               
              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$row,"GROSS PAY");

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1);          

             
              for ($column = $columnLetter1,$k=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$k<count($data_nontax); $column++,$k++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_nontax[$k]->nontaxable_name));
              } 

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$row,"TOTAL INCOME TAX");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$row,"INCOME TAX RELIEF");


              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 
             
              for ($column = $columnLetter2,$l=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$l<count($data_relief); $column++,$l++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_relief[$l]->relief_name));
              } 
 
              $columnLetter3 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4); 

              $sheet->SetCellValue($columnLetter3.$row,"PAYE");

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5); 

              $sheet->SetCellValue($columnLetter4.$row,"NSSF AMOUNT");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6); 

              $sheet->SetCellValue($columnLetter5.$row,"NHIF AMOUNT");

              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 
             
              for ($column = $columnLetter6,$m=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)),$m<count($deductions); $column++,$m++) {
               
               $sheet->setCellValue($column.$row, strtoupper($deductions[$m]->deduction_name));
              } 

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7); 

              $sheet->SetCellValue($columnLetter4.$row,"TOTAL DEDUCTIONS");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8); 

              $sheet->SetCellValue($columnLetter5.$row,"NET PAY");

              $sheet->mergeCells('A6:'.$columnLetter5.'6');

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(7, function ($r) {

              $r->setFontWeight('bold');
 
              });

              $r = 8;
              $salaries = 0;
              $totalearning = 0;
              $totalhourly = 0;
              $totaldaily = 0;
              $totalgross = 0;
              $totalnontax = 0;
              $totalrelief = 0;
              $totaltax = 0;
              $totaltaxrelief = 0;
              $totalpaye = 0;
              $totalnssf = 0;
              $totalnhif = 0;
              $totaldeduction = 0;
              $totalnet = 0;
              

              for($i = 0; $i<count($data); $i++){
                $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
                 $sheet->SetCellValue("A".$r,$data[$i]->personal_file_number);
                 $sheet->SetCellValue("B".$r,$name);
                 $sheet->SetCellValue("C".$r,$data[$i]->basic_pay);
                 $salaries = $salaries + $data[$i]->basic_pay;
                 $r++;
              }

              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $re = 8;

              $column = '';

              for($i = 0; $i<count($data); $i++){
              for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++) {
                $sheet->setCellValue($column.$re, Payroll::transactearnings($data[$i]->personal_file_number,$data_earnings[$c]->earning_name,Input::get("period")));
              }
              $re++;
              }

              $roh = 8;

             for($e = 0; $e<count($data); $e++){
              
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period")));
               $totalhourly = $totalhourly + Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period"));
               $roh++;
              } 

              $rod = 8;

              for($b = 0; $b<count($data); $b++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period")));
               $totaldaily = $totaldaily + Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period"));
               $rod++;

              } 

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

              $ra = 8;

             for($n = 0; $n<count($data); $n++){
              for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
               $sheet->setCellValue($column.$ra, Payroll::transactallowances($data[$n]->personal_file_number,$data_allowance[$f]->allowance_name,Input::get("period")));
              } 
              $ra++;
            }

            $rg = 8;
              for($i = 0; $i<count($data); $i++){
                $name = '';
                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$rg,$data[$i]->taxable_income);
                 $totalgross = $totalgross + $data[$i]->taxable_income;
                 $rg++;
              }

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1); 

              $rnt = 8;         

             for($g=0;$g<count($data);$g++){
              for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
               $sheet->setCellValue($column.$rnt, Payroll::transactnontaxables($data[$g]->personal_file_number,$data_nontax[$o]->nontaxable_name,Input::get("period")));
              } 

              $rnt++;

            }

              $relieftotal = 0;

              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 

              $rel = 8;         

             for($h=0;$h<count($data);$h++){
             
              for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
               $sheet->setCellValue($column.$rel, Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period")));
               $relieftotal = $relieftotal + Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period"));
              } 

              $rel++;
              }

              $rtax=8;

              for($w = 0; $w<count($data); $w++){

                $incometaxreliefapply = 0;

                $incometax = 0;

                if($data[$w]->income_tax_applicable=='1'){
                $incometax = Payroll::totaltransacttax($data[$w]->id,Input::get("period"));
                }else{
                  $incometax = 0;
                }

                if($data[$w]->income_tax_relief_applicable=='1'){
                $incometaxreliefapply = 1162;
                }else{
                  $incometaxreliefapply = 0;
                }


               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $incometax);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $incometaxreliefapply);
               $totaltax = $totaltax + $incometax;
               $totaltaxrelief = $totaltaxrelief + $incometaxreliefapply;
               $rtax++;

              }

              $rp=8;

              for($q = 0; $q<count($data); $q++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $data[$q]->paye);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $data[$q]->nssf_amount);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $data[$q]->nhif_amount);
               $totalpaye = $totalpaye + $data[$q]->paye;
               $totalnssf = $totalnssf + $data[$q]->nssf_amount;
               $totalnhif = $totalnhif + $data[$q]->nhif_amount;
               $rp++;

              }


              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 

              $rded = 8;

              for($v = 0; $v<count($data); $v++){
             
              for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
               $sheet->setCellValue($column.$rded, Payroll::transactdeductions($data[$v]->personal_file_number,$data_deduction[$s]->deduction_name,Input::get("period")));
              } 

               $rded++;

              }

              $rn = 8;

              for($u = 0; $u<count($data); $u++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $data[$u]->total_deductions);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $data[$u]->net);
               $totaldeduction = $totaldeduction + $data[$u]->total_deductions;
               $totalnet = $totalnet + $data[$u]->net;
               $rn++;

              }
              
                 $sheet->SetCellValue("B".$r,"TOTALS");
                 $sheet->SetCellValue("C".$r, $salaries);
                 for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++){
                 $sheet->setCellValue($column.$r, Payroll::totaltransactearnings($data_earnings[$c]->earning_name,Input::get('branch'),'All',Input::get("period")));
                 }
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, $totalhourly);
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, $totaldaily);
                 for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
                 $sheet->setCellValue($column.$r, Payroll::totaltransactallowances($data_allowance[$f]->allowance_name,Input::get('branch'),'All',Input::get("period")));
                 } 

                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$r,$totalgross);

                 for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactnontaxables($data_nontax[$o]->nontaxable_name,Input::get('branch'),'All',Input::get("period")));
                } 

                 for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactreliefs($data_relief[$p]->relief_name,Input::get('branch'),'All',Input::get("period")));
                } 

                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $totaltax);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $totaltaxrelief);
               
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $totalpaye);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $totalnssf);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $totalnhif);
               
                for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactdeductions($data_deduction[$s]->deduction_name,Input::get('branch'),'All',Input::get("period")));
                } 

               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $totaldeduction);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $totalnet);
               
               
              $sheet->row($r, function ($rls) {

             // call cell manipulation methods
              $rls->setFontWeight('bold');
 
              });

             
    });

  })->download('xls');
  }else if(Input::get('branch') == 'All'){
          $sels = DB::table('departments')->find(Input::get('department')); 

          $total_pay = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('transact.basic_pay');

         $total_earning = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('earning_amount');

         $total_gross = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('paye');

         $total_nssf = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nssf_amount');

         $total_nhif = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nhif_amount');

        $total_others = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('other_deductions');

        $total_deds = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('total_deductions');

        $total_net = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_allowance = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(allowance_name) as allowance_name'))
            ->get(); 

        $data_nontax = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(nontaxable_name) as nontaxable_name'))
            ->get();
        
        $data_earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(earning_name) as earning_name'))
            ->get();

        $data_overtime = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_overtime_hourly = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Hourly')
            ->get();

        $data_overtime_daily = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Daily')
            ->get();

        $data_relief = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(relief_name) as relief_name'))
            ->get();

        $data_deduction = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Payroll Summary '.$month, function($excel) use($sels,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payroll Summary', function($sheet) use($sels,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency,$objPHPExcel){
            
              $sheet->row(1, array(
              'BRANCH: ','ALL'
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ',strtoupper($sels->department_name)
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(6, array(
              'PAYROLL SUMMARY'
              ));

              
              
              $earnings = DB::table('transact_earnings')->get();
              $allowances = DB::table('transact_allowances')->get();
              $nontax = DB::table('transact_nontaxables')->get();
              $reliefs = DB::table('transact_reliefs')->get();
              $deductions = DB::table('transact_deductions')
              ->where('financial_month_year' ,'=', Input::get('period'))
              ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
              ->get();

              $earns = array();
              $allws = array();
              $rels  = array();
              $deds  = array(); 
        

              
              $sheet->SetCellValue("A7","PAYROLL NO.");
              $sheet->SetCellValue("B7","EMPLOYEE");
              $sheet->SetCellValue("C7","BASIC PAY");

              $row = 7;
              
              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $column = '';
              
              for ($column = 'D',$i=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$i<count($data_earnings); $column++,$i++) {
                $sheet->setCellValue($column.$row, strtoupper($data_earnings[$i]->earning_name));
              }

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$row,"OVERTIME - HOURLY");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$row,"OVERTIME - DAILY");

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

             
              for ($column = $columnLetter,$j=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$j<count($data_allowance); $column++,$j++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_allowance[$j]->allowance_name));
              } 

              
               
              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$row,"GROSS PAY");

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1);          

             
              for ($column = $columnLetter1,$k=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$k<count($data_nontax); $column++,$k++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_nontax[$k]->nontaxable_name));
              } 

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$row,"TOTAL INCOME TAX");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$row,"INCOME TAX RELIEF");


              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 
             
              for ($column = $columnLetter2,$l=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$l<count($data_relief); $column++,$l++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_relief[$l]->relief_name));
              } 
 
              $columnLetter3 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4); 

              $sheet->SetCellValue($columnLetter3.$row,"PAYE");

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5); 

              $sheet->SetCellValue($columnLetter4.$row,"NSSF AMOUNT");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6); 

              $sheet->SetCellValue($columnLetter5.$row,"NHIF AMOUNT");

              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 
             
              for ($column = $columnLetter6,$m=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)),$m<count($deductions); $column++,$m++) {
               
               $sheet->setCellValue($column.$row, strtoupper($deductions[$m]->deduction_name));
              } 

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7); 

              $sheet->SetCellValue($columnLetter4.$row,"TOTAL DEDUCTIONS");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8); 

              $sheet->SetCellValue($columnLetter5.$row,"NET PAY");

              $sheet->mergeCells('A6:'.$columnLetter5.'6');

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(7, function ($r) {

              $r->setFontWeight('bold');
 
              });

              $r = 8;
              $salaries = 0;
              $totalearning = 0;
              $totalhourly = 0;
              $totaldaily = 0;
              $totalgross = 0;
              $totalnontax = 0;
              $totalrelief = 0;
              $totaltax = 0;
              $totaltaxrelief = 0;
              $totalpaye = 0;
              $totalnssf = 0;
              $totalnhif = 0;
              $totaldeduction = 0;
              $totalnet = 0;
              

              for($i = 0; $i<count($data); $i++){
                $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
                 $sheet->SetCellValue("A".$r,$data[$i]->personal_file_number);
                 $sheet->SetCellValue("B".$r,$name);
                 $sheet->SetCellValue("C".$r,$data[$i]->basic_pay);
                 $salaries = $salaries + $data[$i]->basic_pay;
                 $r++;
              }

              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $re = 8;

              $column = '';

              for($i = 0; $i<count($data); $i++){
              for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++) {
                $sheet->setCellValue($column.$re, Payroll::transactearnings($data[$i]->personal_file_number,$data_earnings[$c]->earning_name,Input::get("period")));
              }
              $re++;
              }

              $roh = 8;

             for($e = 0; $e<count($data); $e++){
              
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period")));
               $totalhourly = $totalhourly + Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period"));
               $roh++;
              } 

              $rod = 8;

              for($b = 0; $b<count($data); $b++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period")));
               $totaldaily = $totaldaily + Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period"));
               $rod++;

              } 

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

              $ra = 8;

             for($n = 0; $n<count($data); $n++){
              for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
               $sheet->setCellValue($column.$ra, Payroll::transactallowances($data[$n]->personal_file_number,$data_allowance[$f]->allowance_name,Input::get("period")));
              } 
              $ra++;
            }

            $rg = 8;
              for($i = 0; $i<count($data); $i++){
                $name = '';
                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$rg,$data[$i]->taxable_income);
                 $totalgross = $totalgross + $data[$i]->taxable_income;
                 $rg++;
              }

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1); 

              $rnt = 8;         

             for($g=0;$g<count($data);$g++){
              for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
               $sheet->setCellValue($column.$rnt, Payroll::transactnontaxables($data[$g]->personal_file_number,$data_nontax[$o]->nontaxable_name,Input::get("period")));
              } 

              $rnt++;

            }

              $relieftotal = 0;

              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 

              $rel = 8;         

             for($h=0;$h<count($data);$h++){
             
              for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
               $sheet->setCellValue($column.$rel, Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period")));
               $relieftotal = $relieftotal + Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period"));
              } 

              $rel++;
              }

              $rtax=8;

              for($w = 0; $w<count($data); $w++){

                $incometaxreliefapply = 0;

                $incometax = 0;

                if($data[$w]->income_tax_applicable=='1'){
                $incometax = Payroll::totaltransacttax($data[$w]->id,Input::get("period"));
                }else{
                  $incometax = 0;
                }

                if($data[$w]->income_tax_relief_applicable=='1'){
                $incometaxreliefapply = 1162;
                }else{
                  $incometaxreliefapply = 0;
                }


               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $incometax);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $incometaxreliefapply);
               $totaltax = $totaltax + $incometax;
               $totaltaxrelief = $totaltaxrelief + $incometaxreliefapply;
               $rtax++;

              }

              $rp=8;

              for($q = 0; $q<count($data); $q++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $data[$q]->paye);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $data[$q]->nssf_amount);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $data[$q]->nhif_amount);
               $totalpaye = $totalpaye + $data[$q]->paye;
               $totalnssf = $totalnssf + $data[$q]->nssf_amount;
               $totalnhif = $totalnhif + $data[$q]->nhif_amount;
               $rp++;

              }


              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 

              $rded = 8;

              for($v = 0; $v<count($data); $v++){
             
              for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
               $sheet->setCellValue($column.$rded, Payroll::transactdeductions($data[$v]->personal_file_number,$data_deduction[$s]->deduction_name,Input::get("period")));
              } 

               $rded++;

              }

              $rn = 8;

              for($u = 0; $u<count($data); $u++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $data[$u]->total_deductions);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $data[$u]->net);
               $totaldeduction = $totaldeduction + $data[$u]->total_deductions;
               $totalnet = $totalnet + $data[$u]->net;
               $rn++;

              }
              
                 $sheet->SetCellValue("B".$r,"TOTALS");
                 $sheet->SetCellValue("C".$r, $salaries);
                 for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++){
                 $sheet->setCellValue($column.$r, Payroll::totaltransactearnings($data_earnings[$c]->earning_name,'All',Input::get('department'),Input::get("period")));
                 }
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, $totalhourly);
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, $totaldaily);
                 for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
                 $sheet->setCellValue($column.$r, Payroll::totaltransactallowances($data_allowance[$f]->allowance_name,'All',Input::get('department'),Input::get("period")));
                 } 

                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$r,$totalgross);

                 for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactnontaxables($data_nontax[$o]->nontaxable_name,'All',Input::get('department'),Input::get("period")));
                } 

                 for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactreliefs($data_relief[$p]->relief_name,'All',Input::get('department'),Input::get("period")));
                } 

                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $totaltax);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $totaltaxrelief);
               
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $totalpaye);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $totalnssf);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $totalnhif);
               
                for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactdeductions($data_deduction[$s]->deduction_name,'All',Input::get('department'),Input::get("period")));
                } 

               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $totaldeduction);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $totalnet);
               
               
              $sheet->row($r, function ($rls) {

             // call cell manipulation methods
              $rls->setFontWeight('bold');
 
              });

             
    });

  })->download('xls');
  }else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
             $selBr = DB::table('branches')->find(Input::get('branch')); 
             $selDt = DB::table('departments')->find(Input::get('department')); 

            $total_pay = DB::table('transact')
            ->where('organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->sum('transact.basic_pay');

         $total_earning = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('earning_amount');

         $total_gross = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('paye');

         $total_nssf = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nssf_amount');

         $total_nhif = DB::table('transact')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('nhif_amount');

        $total_others = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('other_deductions');

        $total_deds = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('total_deductions');

        $total_net = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('net');

        $data = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_allowance = DB::table('transact_allowances')
            ->join('employee', 'transact_allowances.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('department_id' ,'=', Input::get('department'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(allowance_name) as allowance_name'))
            ->get(); 

        $data_nontax = DB::table('transact_nontaxables')
            ->join('employee', 'transact_nontaxables.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(nontaxable_name) as nontaxable_name'))
            ->get();
        
        $data_earnings = DB::table('transact_earnings')
            ->join('employee', 'transact_earnings.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(earning_name) as earning_name'))
            ->get();

        $data_overtime = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $data_overtime_hourly = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Hourly')
            ->get();

        $data_overtime_daily = DB::table('transact_overtimes')
            ->join('employee', 'transact_overtimes.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('overtime_type' ,'=', 'Daily')
            ->get();

        $data_relief = DB::table('transact_reliefs')
            ->join('employee', 'transact_reliefs.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(relief_name) as relief_name'))
            ->get();

        $data_deduction = DB::table('transact_deductions')
            ->join('employee', 'transact_deductions.employee_id', '=', 'employee.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Payroll Summary '.$month, function($excel) use($selBr,$selDt,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Payroll Summary', function($sheet) use($selBr,$selDt,$data,$data_nontax,$data_earnings,$data_allowance,$data_overtime,$data_overtime_hourly,$data_overtime_daily,$data_relief,$data_deduction,$total_pay,$total_earning,$total_gross,$total_paye,$total_nssf,$total_nhif,$total_others,$total_deds,$total_net,$organization,$currency,$objPHPExcel){
            
              $sheet->row(1, array(
              'BRANCH: ',strtoupper($selBr->name)
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ',strtoupper($selDt->department_name)
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(6, array(
              'PAYROLL SUMMARY'
              ));

              
              
              $earnings = DB::table('transact_earnings')->get();
              $allowances = DB::table('transact_allowances')->get();
              $nontax = DB::table('transact_nontaxables')->get();
              $reliefs = DB::table('transact_reliefs')->get();
              $deductions = DB::table('transact_deductions')
              ->where('financial_month_year' ,'=', Input::get('period'))
              ->select(DB::raw('DISTINCT(deduction_name) as deduction_name'))
              ->get();

              $earns = array();
              $allws = array();
              $rels  = array();
              $deds  = array(); 
        

              
              $sheet->SetCellValue("A7","PAYROLL NO.");
              $sheet->SetCellValue("B7","EMPLOYEE");
              $sheet->SetCellValue("C7","BASIC PAY");

              $row = 7;
              
              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $column = '';
              
              for ($column = 'D',$i=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$i<count($data_earnings); $column++,$i++) {
                $sheet->setCellValue($column.$row, strtoupper($data_earnings[$i]->earning_name));
              }

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$row,"OVERTIME - HOURLY");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$row,"OVERTIME - DAILY");

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

             
              for ($column = $columnLetter,$j=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$j<count($data_allowance); $column++,$j++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_allowance[$j]->allowance_name));
              } 

              
               
              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$row,"GROSS PAY");

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1);          

             
              for ($column = $columnLetter1,$k=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$k<count($data_nontax); $column++,$k++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_nontax[$k]->nontaxable_name));
              } 

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$row,"TOTAL INCOME TAX");

              $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$row,"INCOME TAX RELIEF");


              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 
             
              for ($column = $columnLetter2,$l=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$l<count($data_relief); $column++,$l++) {
               
               $sheet->setCellValue($column.$row, strtoupper($data_relief[$l]->relief_name));
              } 
 
              $columnLetter3 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4); 

              $sheet->SetCellValue($columnLetter3.$row,"PAYE");

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5); 

              $sheet->SetCellValue($columnLetter4.$row,"NSSF AMOUNT");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6); 

              $sheet->SetCellValue($columnLetter5.$row,"NHIF AMOUNT");

              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 
             
              for ($column = $columnLetter6,$m=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)),$m<count($deductions); $column++,$m++) {
               
               $sheet->setCellValue($column.$row, strtoupper($deductions[$m]->deduction_name));
              } 

              $columnLetter4 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7); 

              $sheet->SetCellValue($columnLetter4.$row,"TOTAL DEDUCTIONS");

              $columnLetter5 = PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8); 

              $sheet->SetCellValue($columnLetter5.$row,"NET PAY");

              $sheet->mergeCells('A6:'.$columnLetter5.'6');

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(7, function ($r) {

              $r->setFontWeight('bold');
 
              });

              $r = 8;
              $salaries = 0;
              $totalearning = 0;
              $totalhourly = 0;
              $totaldaily = 0;
              $totalgross = 0;
              $totalnontax = 0;
              $totalrelief = 0;
              $totaltax = 0;
              $totaltaxrelief = 0;
              $totalpaye = 0;
              $totalnssf = 0;
              $totalnhif = 0;
              $totaldeduction = 0;
              $totalnet = 0;
              

              for($i = 0; $i<count($data); $i++){
                $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
                 $sheet->SetCellValue("A".$r,$data[$i]->personal_file_number);
                 $sheet->SetCellValue("B".$r,$name);
                 $sheet->SetCellValue("C".$r,$data[$i]->basic_pay);
                 $salaries = $salaries + $data[$i]->basic_pay;
                 $r++;
              }

              $colIndex = PHPExcel_Cell::columnIndexFromString('D');
              
              $i=0;

              $re = 8;

              $column = '';

              for($i = 0; $i<count($data); $i++){
              for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++) {
                $sheet->setCellValue($column.$re, Payroll::transactearnings($data[$i]->personal_file_number,$data_earnings[$c]->earning_name,Input::get("period")));
              }
              $re++;
              }

              $roh = 8;

             for($e = 0; $e<count($data); $e++){
              
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period")));
               $totalhourly = $totalhourly + Payroll::transactovertimes($data[$e]->personal_file_number,'Hourly',Input::get("period"));
               $roh++;
              } 

              $rod = 8;

              for($b = 0; $b<count($data); $b++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period")));
               $totaldaily = $totaldaily + Payroll::transactovertimes($data[$b]->personal_file_number,'Daily',Input::get("period"));
               $rod++;

              } 

              $colIndexAllw = $colIndex+count($data_earnings)+1;

              $columnLetter = PHPExcel_Cell::stringFromColumnIndex($colIndexAllw); 

              $ra = 8;

             for($n = 0; $n<count($data); $n++){
              for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
               $sheet->setCellValue($column.$ra, Payroll::transactallowances($data[$n]->personal_file_number,$data_allowance[$f]->allowance_name,Input::get("period")));
              } 
              $ra++;
            }

            $rg = 8;
              for($i = 0; $i<count($data); $i++){
                $name = '';
                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$rg,$data[$i]->taxable_income);
                 $totalgross = $totalgross + $data[$i]->taxable_income;
                 $rg++;
              }

              $colIndexnontax = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)));

              $columnLetter1 = PHPExcel_Cell::stringFromColumnIndex($colIndexnontax+1); 

              $rnt = 8;         

             for($g=0;$g<count($data);$g++){
              for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
               $sheet->setCellValue($column.$rnt, Payroll::transactnontaxables($data[$g]->personal_file_number,$data_nontax[$o]->nontaxable_name,Input::get("period")));
              } 

              $rnt++;

            }

              $relieftotal = 0;

              $colIndexrel = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)));

              $columnLetter2 = PHPExcel_Cell::stringFromColumnIndex($colIndexrel+3); 

              $rel = 8;         

             for($h=0;$h<count($data);$h++){
             
              for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
               $sheet->setCellValue($column.$rel, Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period")));
               $relieftotal = $relieftotal + Payroll::transactreliefs($data[$h]->personal_file_number,$data_relief[$p]->relief_name,Input::get("period"));
              } 

              $rel++;
              }

              $rtax=8;

              for($w = 0; $w<count($data); $w++){

                $incometaxreliefapply = 0;

                $incometax = 0;

                if($data[$w]->income_tax_applicable=='1'){
                $incometax = Payroll::totaltransacttax($data[$w]->id,Input::get("period"));
                }else{
                  $incometax = 0;
                }

                if($data[$w]->income_tax_relief_applicable=='1'){
                $incometaxreliefapply = 1162;
                }else{
                  $incometaxreliefapply = 0;
                }


               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $incometax);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $incometaxreliefapply);
               $totaltax = $totaltax + $incometax;
               $totaltaxrelief = $totaltaxrelief + $incometaxreliefapply;
               $rtax++;

              }

              $rp=8;

              for($q = 0; $q<count($data); $q++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $data[$q]->paye);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $data[$q]->nssf_amount);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $data[$q]->nhif_amount);
               $totalpaye = $totalpaye + $data[$q]->paye;
               $totalnssf = $totalnssf + $data[$q]->nssf_amount;
               $totalnhif = $totalnhif + $data[$q]->nhif_amount;
               $rp++;

              }


              $colIndexded = PHPExcel_Cell::columnIndexFromString(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)));

              $columnLetter6 = PHPExcel_Cell::stringFromColumnIndex($colIndexded+6); 

              $rded = 8;

              for($v = 0; $v<count($data); $v++){
             
              for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
               $sheet->setCellValue($column.$rded, Payroll::transactdeductions($data[$v]->personal_file_number,$data_deduction[$s]->deduction_name,Input::get("period")));
              } 

               $rded++;

              }

              $rn = 8;

              for($u = 0; $u<count($data); $u++){
               
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $data[$u]->total_deductions);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $data[$u]->net);
               $totaldeduction = $totaldeduction + $data[$u]->total_deductions;
               $totalnet = $totalnet + $data[$u]->net;
               $rn++;

              }
              
                 $sheet->SetCellValue("B".$r,"TOTALS");
                 $sheet->SetCellValue("C".$r, $salaries);
                 for ($column = 'D',$c=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)),$c<count($data_earnings); $column++,$c++){
                 $sheet->setCellValue($column.$r, Payroll::totaltransactearnings($data_earnings[$c]->earning_name,Input::get('branch'),Input::get('department'),Input::get("period")));
                 }
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)-1).$roh, $totalhourly);
                 $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)).$rod, $totaldaily);
                 for ($column = $columnLetter,$f=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+1+count($data_earnings)+count($data_allowance)),$f<count($data_allowance); $column++,$f++) {
                 $sheet->setCellValue($column.$r, Payroll::totaltransactallowances($data_allowance[$f]->allowance_name,Input::get('branch'),Input::get('department'),Input::get("period")));
                 } 

                 $sheet->SetCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+1).$r,$totalgross);

                 for ($column = $columnLetter1,$o=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)),$o<count($data_nontax); $column++,$o++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactnontaxables($data_nontax[$o]->nontaxable_name,Input::get('branch'),Input::get('department'),Input::get("period")));
                } 

                 for ($column = $columnLetter2,$p=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)),$p<count($data_relief); $column++,$p++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactreliefs($data_relief[$p]->relief_name,Input::get('branch'),Input::get('department'),Input::get("period")));
                } 

                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+2).$rtax, $totaltax);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+3).$rtax, $totaltaxrelief);
               
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+4).$rp, $totalpaye);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+5).$rp, $totalnssf);
                $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+6).$rp, $totalnhif);
               
                for ($column = $columnLetter6,$s=0; $column != PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($data_deduction)),$s<count($data_deduction); $column++,$s++) {
               
                 $sheet->setCellValue($column.$r, Payroll::totaltransactdeductions($data_deduction[$s]->deduction_name,Input::get('branch'),Input::get('department'),Input::get("period")));
                } 

               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+7).$rn, $totaldeduction);
               $sheet->setCellValue(PHPExcel_Cell::stringFromColumnIndex($colIndex+count($data_earnings)+count($data_allowance)+count($data_nontax)+count($data_relief)+count($deductions)+8).$rn, $totalnet);
               
               
              $sheet->row($r, function ($rls) {

             // call cell manipulation methods
              $rls->setFontWeight('bold');
 
              });

             
    });

  })->download('xls');
  }
  }else{
    $period = Input::get("period");
    $selBranch = Input::get("branch");
    $selDept = Input::get("department");


    if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
     $total_pay = DB::table('transact')
     ->where('organization_id',Confide::user()->organization_id)
    ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('transact.basic_pay');

     $total_earning = DB::table('transact')
     ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('earning_amount');

     $total_gross = DB::table('transact')
     ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('paye');

     $total_nssf = DB::table('transact')
     ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nssf_amount');

     $total_nhif = DB::table('transact')
     ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nhif_amount');

    $total_others = DB::table('transact')
    ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('other_deductions');

    $total_deds = DB::table('transact')
    ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('total_deductions');

    $total_net = DB::table('transact')
    ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('net');

    $currencies = DB::table('currencies')
            ->select('shortname')
            ->get();

    $sums = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.summaryReport', compact('sums','selBranch','selDept','total_pay','total_earning','total_gross','total_paye','total_nssf','total_nhif','total_others','total_deds','total_net','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Payroll_summary_'.$month.'.pdf');

        }else if(Input::get('department') == 'All'){
         $sels = DB::table('branches')->find(Input::get('branch')); 

         $total_pay = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('transact.basic_pay');

     $total_earning = DB::table('transact')
    ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('branch_id' ,'=', Input::get('branch'))
    ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('earning_amount');

     $total_gross = DB::table('transact')
    ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('employee.organization_id',Confide::user()->organization_id)
    ->where('branch_id' ,'=', Input::get('branch'))
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
        ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
        ->where('branch_id' ,'=', Input::get('branch'))
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('paye');

     $total_nssf = DB::table('transact')
    ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('branch_id' ,'=', Input::get('branch'))
    ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nssf_amount');

     $total_nhif = DB::table('transact')
    ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('employee.organization_id',Confide::user()->organization_id)
    ->where('branch_id' ,'=', Input::get('branch'))
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('nhif_amount');

    $total_others = DB::table('transact')
      ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('branch_id' ,'=', Input::get('branch'))
    ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('other_deductions');

    $total_deds = DB::table('transact')
      ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('branch_id' ,'=', Input::get('branch'))
    ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('total_deductions');

    $total_net = DB::table('transact')
    ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
    ->where('branch_id' ,'=', Input::get('branch'))
    ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
    ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $sums = DB::table('transact')
            ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
            ->join('branches', 'employee.branch_id', '=', 'branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.summaryReport', compact('sums','selBranch','selDept','sels','total_pay','total_earning','total_gross','total_paye','total_nssf','total_nhif','total_others','total_deds','total_net','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Payroll_summary_'.$month.'.pdf');

        } else if(Input::get('branch') == 'All'){
          $sels = DB::table('departments')->find(Input::get('department')); 

          $total_pay = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('transact.basic_pay');

     $total_earning = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('earning_amount');

     $total_gross = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('paye');

     $total_nssf = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('nssf_amount');

     $total_nhif = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('nhif_amount');

    $total_others = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('other_deductions');

    $total_deds = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('total_deductions');

    $total_net = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $sums = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.summaryReport', compact('sums','selBranch','selDept','sels','total_pay','total_earning','total_gross','total_paye','total_nssf','total_nhif','total_others','total_deds','total_net','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Payroll_summary_'.$month.'.pdf');


        }   else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
             $selBr = DB::table('branches')->find(Input::get('branch')); 
             $selDt = DB::table('departments')->find(Input::get('department')); 

          $total_pay = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('transact.basic_pay');

     $total_earning = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('earning_amount');

     $total_gross = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('taxable_income');
        
        $total_paye = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('paye');

     $total_nssf = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('nssf_amount');

     $total_nhif = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('nhif_amount');

    $total_others = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('other_deductions');

    $total_deds = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('total_deductions');

    $total_net = DB::table('transact')
     ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
     ->where('branch_id' ,'=', Input::get('branch'))
     ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
     ->sum('net');

    $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

    $sums = DB::table('transact')
         ->join('employee', 'transact.employee_id', '=', 'employee.personal_file_number')
         ->join('branches', 'employee.branch_id', '=', 'branches.id')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

    $organization = Organization::find(Confide::user()->organization_id);

    $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    $pdf = PDF::loadView('pdf.summaryReport', compact('sums','selBranch','selDept','selBr','selDt','total_pay','total_earning','total_gross','total_paye','total_nssf','total_nhif','total_others','total_deds','total_net','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Payroll_summary_'.$month.'.pdf');

        }                       
    
  }

}

public function members(){

    $members = Member::where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.memberlist', compact('members', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('MemberList.pdf');
    
  }


  public function remittance(){

    //$members = DB::table('members')->where('is_active', '=', '1')->get();
    $members = Member::where('organization_id',Confide::user()->organization_id)->get();
    $organization = Organization::find(Confide::user()->organization_id);
    $savingproducts = Savingproduct::where('organization_id',Confide::user()->organization_id)
    ->get();
    $loanproducts = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();

    $pdf = PDF::loadView('pdf.remittance', compact('members', 'organization', 'loanproducts', 'savingproducts'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Remittance.pdf');
    
  }



  public function template(){

    $employees = Employee::where('employee.organization_id',Confide::user()->organization_id)
    ->get();
    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.blank', compact('employees', 'organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Template.pdf');
    
  }



  public function loanlisting(){

    $loans = Loanaccount::where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);
    $pdf = PDF::loadView('pdf.loanreports.loanbalances', compact('loans', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Loan Listing.pdf');
    
  }



  public function loanproduct($id){

    $loans = Loanproduct::find($id);
    $organization = Organization::find(Confide::user()->organization_id);
    $pdf = PDF::loadView('pdf.loanreports.loanproducts', compact('loans', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Loan Product Listing.pdf');
    
  }



  public function savinglisting(){

    $savings = Savingaccount::where('organization_id',Confide::user()->organization_id)->get();

    $organization = Organization::find(Confide::user()->organization_id);
    $pdf = PDF::loadView('pdf.savingreports.savingbalances', compact('savings', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Savings Listing.pdf');
    
  }



  public function savingproduct($id){

    $saving = Savingproduct::find($id);

    $organization = Organization::find(Confide::user()->organization_id);

    $pdf = PDF::loadView('pdf.savingreports.savingproducts', compact('saving', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
    return $pdf->stream('Saving Product Listing.pdf');
    
  }
  


  public function financials(){

    
    $report = Input::get('report_type');
    $date = Input::get('date');
    $accounts = Account::where('active',true)
    ->where('organization_id',Confide::user()->organization_id)
    ->get();
    $organization = Organization::find(Confide::user()->organization_id);

    if($report == 'balancesheet'){
      $pdf = PDF::loadView('pdf.financials.balancesheet', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
      return $pdf->stream('Balance Sheet.pdf');

    }


    if($report == 'income'){

      $pdf = PDF::loadView('pdf.financials.incomestatement', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
      return $pdf->stream('Income Statement.pdf');

    }


    if($report == 'trialbalance'){

      $pdf = PDF::loadView('pdf.financials.trialbalance', compact('accounts', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
      return $pdf->stream('Trial Balance.pdf');

    }

    if($report == 'cashflowstatement'){
      $expenses = Expense::where('employee.organization_id',Confide::user()->organization_id)->where('void',0)->get();
      
      $pdf = PDF::loadView('pdf.erpfinancials.cashflowstatement', compact('accounts','expenses', 'date', 'organization'))->setPaper('a4')->setOrientation('potrait');
  
      return $pdf->stream('Cash Flow Statement.pdf');

    }

    if($report == 'budget'){

     $date = Input::get('period');

     $expenses = Expensesetting::where('id','!=',6)->where('organization_id',Confide::user()->organization_id)->get();

     $budgetsalesjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();    

     $budgetexpmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalessep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpsep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();


     $budgetsalescountjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();    

     $budgetexpcountmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountsep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountsep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     $budgetsalescountdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->count();

     $budgetexpcountdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->count();

     
      if(Input::get('format') == 'pdf'){
      $accounts = Account::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();

      $organization = Organization::find(Confide::user()->organization_id);

      $pdf = PDF::loadView('pdf.erpfinancials.budget', compact('accounts','expenses', 'date', 'organization','budgetsalesjan','budgetexpjan','budgetsalescountjan','budgetexpcountjan','budgetsalesfeb','budgetexpfeb','budgetsalescountfeb','budgetexpcountfeb','budgetsalesmar','budgetsalescountmar','budgetexpmar','budgetexpcountmar','budgetsalesapr','budgetexpapr','budgetsalescountapr','budgetexpcountapr','budgetsalesmay','budgetexpmay','budgetsalescountmay','budgetexpcountmay','budgetsalesjun','budgetexpjun','budgetsalescountjun','budgetexpcountjun','budgetsalesjul','budgetexpjul','budgetsalescountjul','budgetexpcountjul','budgetsalesaug','budgetexpaug','budgetsalescountaug','budgetexpcountaug','budgetsalessep','budgetexpsep','budgetsalescountsep','budgetexpcountsep','budgetsalesoct','budgetexpoct','budgetsalescountoct','budgetexpcountoct','budgetsalesnov','budgetexpnov','budgetsalescountnov','budgetexpcountnov','budgetsalesdec','budgetexpdec','budgetsalescountdec','budgetexpcountdec'))->setPaper('a1')->setOrientation('landscape');
  
      return $pdf->stream('Budget.pdf');
    }else{

     /*$budgetsalesjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjan = Budget::where('financial_month','Jan')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpfeb = Budget::where('financial_month','Feb')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpmar = Budget::where('financial_month','Mar')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpapr = Budget::where('financial_month','Apr')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpmay = Budget::where('financial_month','May')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjun = Budget::where('financial_month','Jun')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpjul = Budget::where('financial_month','Jul')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpaug = Budget::where('financial_month','Aug')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalessep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpsep = Budget::where('financial_month','Sep')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpoct = Budget::where('financial_month','Oct')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpnov = Budget::where('financial_month','Nov')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();

     $budgetsalesdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id',6)->get();

     $budgetexpdec = Budget::where('financial_month','Dec')->where('financial_year',Input::get('period'))->where('organization_id',Confide::user()->organization_id)->where('expensesetting_id','!=',6)->get();
*/
     $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

     $organization = Organization::find(Confide::user()->organization_id);

     $part = explode("-", Input::get('period'));
              
     $month = Input::get('period');

     Excel::create('Budget '.$month, function($excel) use($expenses,$budgetsalesjan,$budgetexpjan,$budgetsalescountjan,$budgetexpcountjan,$budgetsalesfeb,$budgetexpfeb,$budgetsalescountfeb,$budgetexpcountfeb,$budgetsalesmar,$budgetexpmar,$budgetsalescountmar,$budgetexpcountmar,$budgetsalesapr,$budgetexpapr,$budgetsalescountapr,$budgetexpcountapr,$budgetsalesmay,$budgetexpmay,$budgetsalescountmay,$budgetexpcountmay,$budgetsalesjun,$budgetexpjun,$budgetsalescountjun,$budgetexpcountjun,$budgetsalesjul,$budgetexpjul,$budgetsalescountjul,$budgetexpcountjul,$budgetsalesaug,$budgetexpaug,$budgetsalescountaug,$budgetexpcountaug,$budgetsalessep,$budgetexpsep,$budgetsalescountsep,$budgetexpcountsep,$budgetsalesoct,$budgetexpoct,$budgetsalescountoct,$budgetexpcountoct,$budgetsalesnov,$budgetexpnov,$budgetsalescountnov,$budgetexpcountnov,$budgetsalesdec,$budgetexpdec,$budgetsalescountdec,$budgetexpcountdec,$organization,$currency,$month) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Budget '.$month, function($sheet) use($expenses,$budgetsalesjan,$budgetexpjan,$budgetsalescountjan,$budgetexpcountjan,$budgetsalesfeb,$budgetexpfeb,$budgetsalescountfeb,$budgetexpcountfeb,$budgetsalesmar,$budgetexpmar,$budgetsalescountmar,$budgetexpcountmar,$budgetsalesapr,$budgetexpapr,$budgetsalescountapr,$budgetexpcountapr,$budgetsalesmay,$budgetexpmay,$budgetsalescountmay,$budgetexpcountmay,$budgetsalesjun,$budgetexpjun,$budgetsalescountjun,$budgetexpcountjun,$budgetsalesjul,$budgetexpjul,$budgetsalescountjul,$budgetexpcountjul,$budgetsalesaug,$budgetexpaug,$budgetsalescountaug,$budgetexpcountaug,$budgetsalessep,$budgetexpsep,$budgetsalescountsep,$budgetexpcountsep,$budgetsalesoct,$budgetexpoct,$budgetsalescountoct,$budgetexpcountoct,$budgetsalesnov,$budgetexpnov,$budgetsalescountnov,$budgetexpcountnov,$budgetsalesdec,$budgetexpdec,$budgetsalescountdec,$budgetexpcountdec,$organization,$currency,$month,$objPHPExcel){

              $sheet->row(1, array(
              'Organization Name: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              

              $sheet->row(2, array(
              'Report name: ', 'Budget for '.$month
              ));

              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(3, array(
              'Currency: ', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'Year: ', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              
              $sheet->mergeCells('B6:AK6');
              $sheet->SetCellValue("B6","BUDGET FOR YEAR ".$month);
              

              $sheet->row(6, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->SetCellValue("B8","JANUARY");
              $sheet->SetCellValue("E8","FEBRUARY");
              $sheet->SetCellValue("H8","MARCH");
              $sheet->SetCellValue("K8","APRIL");
              $sheet->SetCellValue("N8","MAY");
              $sheet->SetCellValue("Q8","JUNE");
              $sheet->SetCellValue("T8","JULY");
              $sheet->SetCellValue("W8","AUGUST");
              $sheet->SetCellValue("Z8","SEPTEMBER");
              $sheet->SetCellValue("AC8","OCTOBER");
              $sheet->SetCellValue("AF8","NOVEMBER");
              $sheet->SetCellValue("AI8","DECEMBER");
              $sheet->mergeCells('B8:D8');
              $sheet->mergeCells('E8:G8');
              $sheet->mergeCells('H8:J8');
              $sheet->mergeCells('K8:M8');
              $sheet->mergeCells('N8:P8');
              $sheet->mergeCells('Q8:S8');
              $sheet->mergeCells('T8:V8');
              $sheet->mergeCells('W8:Y8');
              $sheet->mergeCells('Z8:AB8');
              $sheet->mergeCells('AC8:AE8');
              $sheet->mergeCells('AF8:AH8');
              $sheet->mergeCells('AI8:AK8');

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
 
              });
               
             $sheet->row(9, array(
              '','Budgeted Income', 'Actual Income', 'Variance', 'Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income','Variance','Budgeted Income', 'Actual Income','Variance','Budgeted Income', 'Actual Income', 'Variance','Budgeted Income', 'Actual Income', 'Variance'
              ));  

            $sheet->row(9, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
              

            $row = 10;

            $rownull = 12;

            $total = 0.00;

            $total_actual = 0.00;

            $total_var = 0.00;

             $sheet->SetCellValue("A".$row,Expensesetting::getName(1));

             if($budgetsalescountjan == 0){
                 
                 $sheet->SetCellValue("B".$row,'0');
                 $sheet->SetCellValue("C".$row,'0');
                 $sheet->SetCellValue("D".$row,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $total = $total;
             $total_actual = $total_actual;
             $total_var = $total_var;
            }else{

             for($i = 0; $i<count($budgetsalesjan); $i++){

                
                 $sheet->SetCellValue("B".$row,str_replace( ',', '',$budgetsalesjan[$i]->amount));
                 $sheet->SetCellValue("C".$row,Budget::sales(1,'01',$month));
                 $sheet->SetCellValue("D".$row,(Budget::sales(1,'01',$month)-str_replace( ',', '',$budgetsalesjan[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $total = $total+str_replace( ',', '',$budgetsalesjan[$i]->amount);
             $total_actual = $total_actual+Budget::sales(1,'01',$month);
             $total_var = $total_var+(Budget::sales(1,'01',$month)-str_replace( ',', '',$budgetsalesjan[$i]->amount));
             $row++;
             
             } 

           }

             $r = 12;
             $rj = 12;

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("A".$r,Expensesetting::getName($expenses[$i]->id));
                     
                 $r++;
             
             } 

             if($budgetexpcountjan == 0){
                
                 for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("B".$rownull,'0');
                 $sheet->SetCellValue("C".$rownull,'0');
                 $sheet->SetCellValue("D".$rownull,'0');
                 $rownull++;
            }
            
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $total = $total;
             $total_actual = $total_actual;
             $total_var = $total_var;
            }else{
             for($i = 0; $i<count($expenses); $i++){
            /*
                 $sheet->SetCellValue("A".$r,Expensesetting::getName($budgetexpjan[$i]->expensesetting_id));
                */    

                 $sheet->SetCellValue("B".$rj,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jan',$month)));
                 $sheet->SetCellValue("C".$rj,Budget::expenses($expenses[$i]->id,'01',$month));
                 $sheet->SetCellValue("D".$rj,(Budget::expenses($expenses[$i]->id,'01',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jan',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $total = $total + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jan',$month));
             $total_actual = $total_actual+Budget::expenses($expenses[$i]->id,'01',$month);
             $total_var = $total_var+(Budget::expenses($expenses[$i]->id,'01',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jan',$month)));
             $rj++;
             
             } 
           }
              
             $sheet->SetCellValue("A11","Expenses");
             $row = $row + 1;

             $sheet->row(11, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });

            $rowfeb = 10;

            $rowfebnull = 12;

            $rfeb = 12;

            $totalfeb = 0.00;

            $total_actual_feb = 0.00;

            $total_var_feb = 0.00;

             if($budgetsalescountfeb == 0){
                
                 $sheet->SetCellValue("E".$rowfeb,'0');
                 $sheet->SetCellValue("F".$rowfeb,'0');
                 $sheet->SetCellValue("G".$rowfeb,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalfeb = $totalfeb;
             $total_actual_feb = $total_actual_feb;
             $total_var_feb = $total_var_feb;
            }else{   

             for($i = 0; $i<count($budgetsalesfeb); $i++){
                 
                 $sheet->SetCellValue("E".$rowfeb,str_replace( ',', '',$budgetsalesfeb[$i]->amount));
                 $sheet->SetCellValue("F".$rowfeb,Budget::sales(1,'02',$month));
                 $sheet->SetCellValue("G".$rowfeb,(Budget::sales(1,'02',$month)-str_replace( ',', '',$budgetsalesfeb[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalfeb = $totalfeb+str_replace( ',', '',$budgetsalesfeb[$i]->amount);
             $total_actual_feb = $total_actual_feb+Budget::sales(1,'02',$month);
             $total_var_feb = $total_var_feb+(Budget::sales(1,'02',$month)-str_replace( ',', '',$budgetsalesfeb[$i]->amount));
             $rowfeb++;
             
             } 
           }

           if($budgetexpcountfeb == 0){
                
                 for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("E".$rowfebnull,'0');
                 $sheet->SetCellValue("F".$rowfebnull,'0');
                 $sheet->SetCellValue("G".$rowfebnull,'0');
                 $rowfebnull++;
            }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalfeb = $totalfeb;
             $total_actual_feb = $total_actual_feb;
             $total_var_feb = $total_var_feb;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("E".$rfeb,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Feb',$month)));
                 $sheet->SetCellValue("F".$rfeb,Budget::expenses($expenses[$i]->id,'02',$month));
                 $sheet->SetCellValue("G".$rfeb,(Budget::expenses($expenses[$i]->id,'02',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Feb',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalfeb = $totalfeb + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Feb',$month));
             $total_actual_feb = $total_actual_feb+Budget::expenses($expenses[$i]->id,'02',$month);
             $total_var_feb = $total_var_feb+(Budget::expenses($expenses[$i]->id,'02',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Feb',$month)));
             $rfeb++;
             
             }
           }

             $rowmar = 10;

             $rowmarnull = 12;

             $rmar = 12;

            $totalmar = 0.00;

            $total_actual_mar = 0.00;

            $total_var_mar = 0.00;

            if($budgetsalescountmar == 0){
                 $sheet->SetCellValue("H".$rowmar,'0');
                 $sheet->SetCellValue("I".$rowmar,'0');
                 $sheet->SetCellValue("J".$rowmar,'0');
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmar = $totalmar;
             $total_actual_mar = $total_actual_mar;
             $total_var_mar = $total_var_mar;
            }else{

             for($i = 0; $i<count($budgetsalesmar); $i++){

                 $sheet->SetCellValue("H".$rowmar,str_replace( ',', '',$budgetsalesmar[$i]->amount));
                 $sheet->SetCellValue("I".$rowmar,Budget::sales(1,'03',$month));
                 $sheet->SetCellValue("J".$rowmar,(Budget::sales(1,'03',$month)-str_replace( ',', '',$budgetsalesmar[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmar = $totalmar+str_replace( ',', '',$budgetsalesmar[$i]->amount);
             $total_actual_mar = $total_actual_mar+Budget::sales(1,'03',$month);
             $total_var_mar = $total_var_mar+(Budget::sales(1,'03',$month)-str_replace( ',', '',$budgetsalesmar[$i]->amount));
             $rowmar++;
             
             } 

           }

           if($budgetexpcountmar == 0){
                
                 for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("H".$rowmarnull,'0');
                 $sheet->SetCellValue("I".$rowmarnull,'0');
                 $sheet->SetCellValue("J".$rowmarnull,'0');
                 $rowmarnull++;
            }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmar = $totalmar;
             $total_actual_mar = $total_actual_mar;
             $total_var_mar = $total_var_mar;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("H".$rmar,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Mar',$month)));
                 $sheet->SetCellValue("I".$rmar,Budget::expenses($expenses[$i]->id,'03',$month));
                 $sheet->SetCellValue("J".$rmar,(Budget::expenses($expenses[$i]->id,'03',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Mar',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalmar = $totalmar + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Mar',$month));
             $total_actual_mar = $total_actual_mar+Budget::expenses($expenses[$i]->id,'03',$month);
             $total_var_mar = $total_var_mar+(Budget::expenses($expenses[$i]->id,'03',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Mar',$month)));
             $rmar++;
             
             }
           }

             $rowapr = 10;

             $rowaprnull = 12;

             $rapr = 12;

            $totalapr = 0.00;

            $total_actual_apr = 0.00;

            $total_var_apr = 0.00;

            if($budgetsalescountapr == 0){
                 $sheet->SetCellValue("K".$rowapr,'0');
                 $sheet->SetCellValue("L".$rowapr,'0');
                 $sheet->SetCellValue("M".$rowapr,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalapr = $totalapr;
             $total_actual_apr = $total_actual_apr;
             $total_var_apr = $total_var_apr;
            }else{

             for($i = 0; $i<count($budgetsalesapr); $i++){

                 $sheet->SetCellValue("K".$rowapr,str_replace( ',', '',$budgetsalesapr[$i]->amount));
                 $sheet->SetCellValue("L".$rowapr,Budget::sales(1,'04',$month));
                 $sheet->SetCellValue("M".$rowapr,(Budget::sales(1,'04',$month)-str_replace( ',', '',$budgetsalesapr[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalapr = $totalapr+str_replace( ',', '',$budgetsalesapr[$i]->amount);
             $total_actual_apr = $total_actual_apr+Budget::sales(1,'04',$month);
             $total_var_apr = $total_var_apr+(Budget::sales(1,'04',$month)-str_replace( ',', '',$budgetsalesapr[$i]->amount));
             $rowapr++;
             
             } 

           }

           if($budgetexpcountapr == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("K".$rowaprnull,'0');
                 $sheet->SetCellValue("L".$rowaprnull,'0');
                 $sheet->SetCellValue("M".$rowaprnull,'0');
                 $rowaprnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalapr = $totalapr;
             $total_actual_apr = $total_actual_apr;
             $total_var_apr = $total_var_apr;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("K".$rapr,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Apr',$month)));
                 $sheet->SetCellValue("L".$rapr,Budget::expenses($expenses[$i]->id,'04',$month));
                 $sheet->SetCellValue("M".$rapr,(Budget::expenses($expenses[$i]->id,'04',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Apr',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalapr = $totalapr + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Apr',$month));
             $total_actual_apr = $total_actual_apr+Budget::expenses($expenses[$i]->id,'04',$month);
             $total_var_apr = $total_var_apr+(Budget::expenses($expenses[$i]->id,'04',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Apr',$month)));
             $rapr++;
             
             }
           }

             $rowmay = 10;

             $rmay = 12;

             $rowmaynull = 12;

            $totalmay = 0.00;

            $total_actual_may = 0.00;

            $total_var_may = 0.00;

            if($budgetsalescountmay == 0){
                 $sheet->SetCellValue("N".$rowmay,'0');
                 $sheet->SetCellValue("O".$rowmay,'0');
                 $sheet->SetCellValue("P".$rowmay,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmay = $totalmay;
             $total_actual_may = $total_actual_may;
             $total_var_may = $total_var_may;
            }else{

             for($i = 0; $i<count($budgetsalesmay); $i++){

                 $sheet->SetCellValue("N".$rowmay,str_replace( ',', '',$budgetsalesmay[$i]->amount));
                 $sheet->SetCellValue("O".$rowmay,Budget::sales(1,'05',$month));
                 $sheet->SetCellValue("P".$rowmay,(Budget::sales(1,'05',$month)-str_replace( ',', '',$budgetsalesmay[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmay = $totalmay+str_replace( ',', '',$budgetsalesmay[$i]->amount);
             $total_actual_may = $total_actual_may+Budget::sales(1,'05',$month);
             $total_var_may = $total_var_may+(Budget::sales(1,'05',$month)-str_replace( ',', '',$budgetsalesmay[$i]->amount));
             $rowmay++;
             
             } 
           }

           if($budgetexpcountmay == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("N".$rowmaynull,'0');
                 $sheet->SetCellValue("O".$rowmaynull,'0');
                 $sheet->SetCellValue("P".$rowmaynull,'0');
                 $rowmaynull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalmay = $totalmay;
             $total_actual_may = $total_actual_may;
             $total_var_may = $total_var_may;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("N".$rmay,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'May',$month)));
                 $sheet->SetCellValue("O".$rmay,Budget::expenses($expenses[$i]->id,'05',$month));
                 $sheet->SetCellValue("P".$rmay,(Budget::expenses($expenses[$i]->id,'05',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'May',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalmay = $totalmay + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'May',$month));
             $total_actual_may = $total_actual_may+Budget::expenses($expenses[$i]->id,'05',$month);
             $total_var_may = $total_var_may+(Budget::expenses($expenses[$i]->id,'05',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'May',$month)));
             $rmay++;
             
             }
           }

             $rowjun = 10;

             $rowjunnull = 12;

             $rjun = 12;

            $totaljun = 0.00;

            $total_actual_jun = 0.00;

            $total_var_jun = 0.00;

            if($budgetsalescountjun == 0){
                 $sheet->SetCellValue("Q".$rowjun,'0');
                 $sheet->SetCellValue("R".$rowjun,'0');
                 $sheet->SetCellValue("S".$rowjun,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljun = $totaljun;
             $total_actual_jun = $total_actual_jun;
             $total_var_jun = $total_var_jun;
            }else{

             for($i = 0; $i<count($budgetsalesjun); $i++){

                 $sheet->SetCellValue("Q".$rowjun,str_replace( ',', '',$budgetsalesjun[$i]->amount));
                 $sheet->SetCellValue("R".$rowjun,Budget::sales(1,'06',$month));
                 $sheet->SetCellValue("S".$rowjun,(Budget::sales(1,'06',$month)-str_replace( ',', '',$budgetsalesjun[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljun = $totaljun+str_replace( ',', '',$budgetsalesjun[$i]->amount);
             $total_actual_jun = $total_actual_jun+Budget::sales(1,'06',$month);
             $total_var_jun = $total_var_jun+(Budget::sales(1,'06',$month)-str_replace( ',', '',$budgetsalesjun[$i]->amount));
             $rowjun++;
             
             } 
           }

           if($budgetexpcountjun == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("Q".$rowjunnull,'0');
                 $sheet->SetCellValue("R".$rowjunnull,'0');
                 $sheet->SetCellValue("S".$rowjunnull,'0');
                 $rowjunnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljun = $totaljun;
             $total_actual_jun = $total_actual_jun;
             $total_var_jun = $total_var_jun;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("Q".$rjun,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jun',$month)));
                 $sheet->SetCellValue("R".$rjun,Budget::expenses($expenses[$i]->id,'06',$month));
                 $sheet->SetCellValue("S".$rjun,(Budget::expenses($expenses[$i]->id,'06',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jun',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totaljun = $totaljun + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jun',$month));
             $total_actual_jun = $total_actual_jun+Budget::expenses($expenses[$i]->id,'06',$month);
             $total_var_jun = $total_var_jun+(Budget::expenses($expenses[$i]->id,'06',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jun',$month)));
             $rjun++;
             
             }
           }

             $rowjul = 10;

             $rowjulnull = 12;

             $rjul = 12;

            $totaljul = 0.00;

            $total_actual_jul = 0.00;

            $total_var_jul = 0.00;

            if($budgetsalescountjul == 0){
                 $sheet->SetCellValue("T".$rowjul,'0');
                 $sheet->SetCellValue("U".$rowjul,'0');
                 $sheet->SetCellValue("V".$rowjul,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljul = $totaljul;
             $total_actual_jul = $total_actual_jul;
             $total_var_jul = $total_var_jul;
            }else{

             for($i = 0; $i<count($budgetsalesjul); $i++){

                 $sheet->SetCellValue("T".$rowjul,str_replace( ',', '',$budgetsalesjul[$i]->amount));
                 $sheet->SetCellValue("U".$rowjul,Budget::sales(1,'07',$month));
                 $sheet->SetCellValue("V".$rowjul,(Budget::sales(1,'06',$month)-str_replace( ',', '',$budgetsalesjul[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljul = $totaljul+str_replace( ',', '',$budgetsalesjul[$i]->amount);
             $total_actual_jul = $total_actual_jul+Budget::sales(1,'07',$month);
             $total_var_jul = $total_var_jul+(Budget::sales(1,'07',$month)-str_replace( ',', '',$budgetsalesjul[$i]->amount));
             $rowjul++;
             
             } 
           }

           if($budgetexpcountjul == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("T".$rowjulnull,'0');
                 $sheet->SetCellValue("U".$rowjulnull,'0');
                 $sheet->SetCellValue("V".$rowjulnull,'0');
                 $rowjulnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaljul = $totaljul;
             $total_actual_jul = $total_actual_jul;
             $total_var_jul = $total_var_jul;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("T".$rjul,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jul',$month)));
                 $sheet->SetCellValue("U".$rjul,Budget::expenses($expenses[$i]->id,'07',$month));
                 $sheet->SetCellValue("V".$rjul,(Budget::expenses($expenses[$i]->id,'07',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jun',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totaljul = $totaljul + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jul',$month));
             $total_actual_jul = $total_actual_jul+Budget::expenses($expenses[$i]->id,'07',$month);
             $total_var_jul = $total_var_jul+(Budget::expenses($expenses[$i]->id,'07',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Jul',$month)));
             $rjul++;
             
             }
           }

             $rowaug = 10;

             $rowaugnull = 12;

             $raug = 12;

            $totalaug = 0.00;

            $total_actual_aug = 0.00;

            $total_var_aug = 0.00;

            if($budgetsalescountaug == 0){
                 $sheet->SetCellValue("W".$rowaug,'0');
                 $sheet->SetCellValue("X".$rowaug,'0');
                 $sheet->SetCellValue("Y".$rowaug,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalaug = $totalaug;
             $total_actual_aug = $total_actual_aug;
             $total_var_aug = $total_var_aug;
            }else{

             for($i = 0; $i<count($budgetsalesaug); $i++){

                 $sheet->SetCellValue("W".$rowaug,str_replace( ',', '',$budgetsalesaug[$i]->amount));
                 $sheet->SetCellValue("X".$rowaug,Budget::sales(1,'08',$month));
                 $sheet->SetCellValue("Y".$rowaug,(Budget::sales(1,'08',$month)-str_replace( ',', '',$budgetsalesaug[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalaug = $totalaug+str_replace( ',', '',$budgetsalesaug[$i]->amount);
             $total_actual_aug = $total_actual_aug+Budget::sales(1,'08',$month);
             $total_var_aug = $total_var_aug+(Budget::sales(1,'08',$month)-str_replace( ',', '',$budgetsalesaug[$i]->amount));
             $rowaug++;
             
             } 
           }

           if($budgetexpcountaug == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("W".$rowaugnull,'0');
                 $sheet->SetCellValue("X".$rowaugnull,'0');
                 $sheet->SetCellValue("Y".$rowaugnull,'0');
                 $rowaugnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalaug = $totalaug;
             $total_actual_aug = $total_actual_aug;
             $total_var_aug = $total_var_aug;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("W".$raug,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Aug',$month)));
                 $sheet->SetCellValue("X".$raug,Budget::expenses($expenses[$i]->id,'08',$month));
                 $sheet->SetCellValue("Y".$raug,(Budget::expenses($expenses[$i]->id,'08',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Aug',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalaug = $totalaug + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Aug',$month));
             $total_actual_aug = $total_actual_aug+Budget::expenses($expenses[$i]->id,'08',$month);
             $total_var_aug = $total_var_aug+(Budget::expenses($expenses[$i]->id,'08',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Aug',$month)));
             $raug++;
             
             }
            
            }

             $rowsep = 10;

             $rowsepnull = 12;

             $rsep = 12;

            $totalsep = 0.00;

            $total_actual_sep = 0.00;

            $total_var_sep = 0.00;

            if($budgetsalescountsep == 0){
                 $sheet->SetCellValue("Z".$rowsep,'0');
                 $sheet->SetCellValue("AA".$rowsep,'0');
                 $sheet->SetCellValue("AB".$rowsep,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalsep = $totalsep;
             $total_actual_sep = $total_actual_sep;
             $total_var_sep = $total_var_sep;
            }else{

             for($i = 0; $i<count($budgetsalessep); $i++){

                 $sheet->SetCellValue("Z".$rowsep,str_replace( ',', '',$budgetsalessep[$i]->amount));
                 $sheet->SetCellValue("AA".$rowsep,Budget::sales(1,'09',$month));
                 $sheet->SetCellValue("AB".$rowsep,(Budget::sales(1,'09',$month)-str_replace( ',', '',$budgetsalessep[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalsep = $totalsep+str_replace( ',', '',$budgetsalessep[$i]->amount);
             $total_actual_sep = $total_actual_sep+Budget::sales(1,'09',$month);
             $total_var_sep = $total_var_sep+(Budget::sales(1,'09',$month)-str_replace( ',', '',$budgetsalessep[$i]->amount));
             $rowsep++;
             
             } 

           }

           if($budgetexpcountsep == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("Z".$rowsepnull,'0');
                 $sheet->SetCellValue("AA".$rowsepnull,'0');
                 $sheet->SetCellValue("AB".$rowsepnull,'0');
                 $rowsepnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalsep = $totalsep;
             $total_actual_sep = $total_actual_sep;
             $total_var_sep = $total_var_sep;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("Z".$rsep,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Sep',$month)));
                 $sheet->SetCellValue("AA".$rsep,Budget::expenses($expenses[$i]->id,'09',$month));
                 $sheet->SetCellValue("AB".$rsep,(Budget::expenses($expenses[$i]->id,'09',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Sep',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalsep = $totalsep + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Sep',$month));
             $total_actual_sep = $total_actual_sep+Budget::expenses($expenses[$i]->id,'09',$month);
             $total_var_sep = $total_var_sep+(Budget::expenses($expenses[$i]->id,'09',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Sep',$month)));
             $rsep++;
             
             }
           }

             $rowoct = 10;

             $rowoctnull = 12;

             $roct = 12;

            $totaloct = 0.00;

            $total_actual_oct = 0.00;

            $total_var_oct = 0.00;

            if($budgetsalescountoct == 0){
                 $sheet->SetCellValue("AC".$rowoct,'0');
                 $sheet->SetCellValue("AD".$rowoct,'0');
                 $sheet->SetCellValue("AE".$rowoct,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaloct = $totaloct;
             $total_actual_oct = $total_actual_oct;
             $total_var_oct = $total_var_oct;
            }else{

             for($i = 0; $i<count($budgetsalesoct); $i++){

                 $sheet->SetCellValue("AC".$rowoct,str_replace( ',', '',$budgetsalesoct[$i]->amount));
                 $sheet->SetCellValue("AD".$rowoct,Budget::sales(1,'10',$month));
                 $sheet->SetCellValue("AE".$rowoct,(Budget::sales(1,'10',$month)-str_replace( ',', '',$budgetsalesoct[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaloct = $totaloct+str_replace( ',', '',$budgetsalesoct[$i]->amount);
             $total_actual_oct = $total_actual_oct+Budget::sales(1,'10',$month);
             $total_var_oct = $total_var_oct+(Budget::sales(1,'10',$month)-str_replace( ',', '',$budgetsalesoct[$i]->amount));
             $rowoct++;
             
             } 
           }

           if($budgetexpcountoct == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("AC".$rowoctnull,'0');
                 $sheet->SetCellValue("AD".$rowoctnull,'0');
                 $sheet->SetCellValue("AE".$rowoctnull,'0');
                 $rowoctnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaloct = $totaloct;
             $total_actual_oct = $total_actual_oct;
             $total_var_oct = $total_var_oct;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("AC".$roct,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Oct',$month)));
                 $sheet->SetCellValue("AD".$roct,Budget::expenses($expenses[$i]->id,'10',$month));
                 $sheet->SetCellValue("AE".$roct,(Budget::expenses($expenses[$i]->id,'10',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Oct',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totaloct = $totaloct + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Oct',$month));
             $total_actual_oct = $total_actual_oct+Budget::expenses($expenses[$i]->id,'10',$month);
             $total_var_oct = $total_var_oct+(Budget::expenses($expenses[$i]->id,'10',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Oct',$month)));
             $roct++;
             
             }
           }


             $rownov = 10;

             $rownovnull = 12;

             $rnov = 12;

            $totalnov = 0.00;

            $total_actual_nov = 0.00;

            $total_var_nov = 0.00;

            if($budgetsalescountnov == 0){
                 $sheet->SetCellValue("AF".$rownov,'0');
                 $sheet->SetCellValue("AG".$rownov,'0');
                 $sheet->SetCellValue("AH".$rownov,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalnov = $totalnov;
             $total_actual_nov = $total_actual_nov;
             $total_var_nov = $total_var_nov;
            }else{

             for($i = 0; $i<count($budgetsalesnov); $i++){

                 $sheet->SetCellValue("AF".$rownov,str_replace( ',', '',$budgetsalesnov[$i]->amount));
                 $sheet->SetCellValue("AG".$rownov,Budget::sales(1,'11',$month));
                 $sheet->SetCellValue("AH".$rownov,(Budget::sales(1,'11',$month)-str_replace( ',', '',$budgetsalesnov[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalnov = $totalnov+str_replace( ',', '',$budgetsalesnov[$i]->amount);
             $total_actual_nov = $total_actual_nov+Budget::sales(1,'11',$month);
             $total_var_nov = $total_var_nov+(Budget::sales(1,'11',$month)-str_replace( ',', '',$budgetsalesnov[$i]->amount));
             $rownov++;
             
             } 

           }

           if($budgetexpcountnov == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("AF".$rownovnull,'0');
                 $sheet->SetCellValue("AG".$rownovnull,'0');
                 $sheet->SetCellValue("AH".$rownovnull,'0');
                 $rownovnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totalnov = $totalnov;
             $total_actual_nov = $total_actual_nov;
             $total_var_nov = $total_var_nov;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("AF".$rnov,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Nov',$month)));
                 $sheet->SetCellValue("AG".$rnov,Budget::expenses($expenses[$i]->id,'11',$month));
                 $sheet->SetCellValue("AH".$rnov,(Budget::expenses($expenses[$i]->id,'11',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Nov',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totalnov = $totalnov + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Nov',$month));
             $total_actual_nov = $total_actual_nov+Budget::expenses($expenses[$i]->id,'11',$month);
             $total_var_nov = $total_var_nov+(Budget::expenses($expenses[$i]->id,'11',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Nov',$month)));
             $rnov++;
             
             }
           }

             $rowdec = 10;

             $rowdecnull = 12;

             $rdec = 12;

            $totaldec = 0.00;

            $total_actual_dec = 0.00;

            $total_var_dec = 0.00;

            if($budgetsalescountdec == 0){
                 $sheet->SetCellValue("AI".$rowdec,'0');
                 $sheet->SetCellValue("AJ".$rowdec,'0');
                 $sheet->SetCellValue("AK".$rowdec,'0');
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaldec = $totaldec;
             $total_actual_dec = $total_actual_dec;
             $total_var_dec = $total_var_dec;
            }else{

             for($i = 0; $i<count($budgetsalesdec); $i++){

                 $sheet->SetCellValue("AI".$rowdec,str_replace( ',', '',$budgetsalesdec[$i]->amount));
                 $sheet->SetCellValue("AJ".$rowdec,Budget::sales(1,'12',$month));
                 $sheet->SetCellValue("AK".$rowdec,(Budget::sales(1,'12',$month)-str_replace( ',', '',$budgetsalesdec[$i]->amount)));
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaldec = $totaldec+str_replace( ',', '',$budgetsalesdec[$i]->amount);
             $total_actual_dec = $total_actual_dec+Budget::sales(1,'12',$month);
             $total_var_dec = $total_var_dec+(Budget::sales(1,'12',$month)-str_replace( ',', '',$budgetsalesdec[$i]->amount));
             $rowdec++;
             
             } 
           }

           if($budgetexpcountdec == 0){
                for($i = 0; $i<count($expenses); $i++){
                 $sheet->SetCellValue("AI".$rowdecnull,'0');
                 $sheet->SetCellValue("AJ".$rowdecnull,'0');
                 $sheet->SetCellValue("AK".$rowdecnull,'0');
                 $rowdecnull++;
               }
            
             /*$sheet->row($row, array(
             Expensesetting::getName($budgetsalesjan[$i]->expensesetting_id),str_replace( ',', '',$budgetsalesjan[$i]->amount),Budget::sales(1,'01',$month),(str_replace( ',', '',$budgetsalesjan[$i]->amount)-Budget::sales(1,'01',$month))
             ));*/
             $totaldec = $totaldec;
             $total_actual_dec = $total_actual_dec;
             $total_var_dec = $total_var_dec;
            }else{

             for($i = 0; $i<count($expenses); $i++){
            
                 $sheet->SetCellValue("AI".$rdec,str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Dec',$month)));
                 $sheet->SetCellValue("AJ".$rdec,Budget::expenses($expenses[$i]->id,'12',$month));
                 $sheet->SetCellValue("AK".$rdec,(Budget::expenses($expenses[$i]->id,'12',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Dec',$month))));

            /* $sheet->row($row, array(
             Expensesetting::getName($budgetexpjan[$i]->expensesetting_id),str_replace( ',', '',$budgetexpjan[$i]->amount),Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month),(str_replace( ',', '',$budgetexpjan[$i]->amount)-Budget::expenses($budgetexpjan[$i]->expensesetting_id,'01',$month))
             ));*/
             $totaldec = $totaldec + str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Dec',$month));
             $total_actual_dec = $total_actual_dec+Budget::expenses($expenses[$i]->id,'12',$month);
             $total_var_dec = $total_var_dec+(Budget::expenses($expenses[$i]->id,'12',$month)-str_replace( ',', '',Budget::getTotalAmount($expenses[$i]->id,'Dec',$month)));
             $rdec++;
             
             }
           }
       
             $sheet->row($r, array(
             'Total',$total,$total_actual,$total_var,$totalfeb,$total_actual_feb,$total_var_feb,$totalmar,$total_actual_mar,$total_var_mar,$totalapr,$total_actual_apr,$total_var_apr,$totalmay,$total_actual_may,$total_var_may,$totaljun,$total_actual_jun,$total_var_jun,$totaljul,$total_actual_jul,$total_var_jul,$totalaug,$total_actual_aug,$total_var_aug,$totalsep,$total_actual_sep,$total_var_sep,$totaloct,$total_actual_oct,$total_var_oct,$totalnov,$total_actual_nov,$total_var_nov,$totaldec,$total_actual_dec,$total_var_dec));
            $sheet->row($r, function ($rw) {

            // call cell manipulation methods
            $rw->setFontWeight('bold');

           });

            $tbs = DB::table('budgets')->where('financial_year',$month)->get();

            $totalbudget = 0.00;

            foreach($tbs as $tb){
              $totalbudget = $totalbudget+str_replace( ',', '',$tb->amount);
            }
            
            $rsum = $r+2;
                
            $totalactualincome = $total_actual+$total_actual_feb+$total_actual_mar+$total_actual_apr+$total_actual_may+$total_actual_jun+$total_actual_jul+$total_actual_aug+$total_actual_sep+$total_actual_oct+$total_actual_nov+$total_actual_dec;

            $sheet->row($rsum, array(
             'BUDGETED INCOME',$totalbudget));
            $sheet->row($rsum, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

           });

            $sheet->row($rsum+1, array(
             'ACTUAL INCOME',$totalactualincome ));
            $sheet->row($rsum+1, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

           });

            $sheet->row($rsum+2, array(
             'VARIANCE',$totalactualincome-$totalbudget));
            $sheet->row($rsum+2, function ($r) {

            // call cell manipulation methods
            $r->setFontWeight('bold');

           });

             
    });

  })->download('xls');

  }

  }

  }


    public function appperiod()
    {
        return View::make('leavereports.applicationSelect');
    }

    public function leaveapplications(){

      if(Input::get('format') == "excel"){
      
        $start = Input::get("period");
        $end = Input::get("period1");

        $data = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->whereBetween('application_date', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Leave Application Report for period between '.$start.' and '.$end, function($excel) use($data,$start,$end,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Leave Application Report', function($sheet) use($data,$start,$end,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'Leave Application Report for period between '.$start.' and '.$end
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NUMBER', 'EMPLOYEE NAME', 'LEAVE TYPE','APPLICATION DATE','START DATE','END DATE','LEAVE DAYS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->name,$data[$i]->application_date,$data[$i]->applied_start_date,$data[$i]->applied_end_date,Leaveapplication::getDays($data[$i]->applied_end_date,$data[$i]->applied_start_date,$data[$i]->is_weekend,$data[$i]->is_holiday)+1
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else{
        
        $start = Input::get("period");
        $end = Input::get("period1");

        $apps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->whereBetween('application_date', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.applicationReport', compact('apps','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Leave_Application_Report.pdf');
        
        }
    }
    public function approvedperiod()
    {
        return View::make('leavereports.approvedSelect');
    }

    public function approvedleaves(){

      if(Input::get('format') == "excel"){
      
        $start = Input::get("period");
        $end = Input::get("period1");

        $data = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->where('date_approved','<=',date('Y-m-d'))
                    ->whereBetween('date_approved', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Leave Approved Report for period between '.$start.' and '.$end, function($excel) use($data,$start,$end,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Leave Approved Report', function($sheet) use($data,$start,$end,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'Leave Approved Report for period between '.$start.' and '.$end
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NUMBER', 'EMPLOYEE NAME', 'LEAVE TYPE','APPROVED DATE','START DATE','END DATE','LEAVE DAYS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->name,$data[$i]->date_approved,$data[$i]->approved_start_date,$data[$i]->approved_end_date,Leaveapplication::getDays($data[$i]->approved_end_date,$data[$i]->approved_start_date,$data[$i]->is_weekend,$data[$i]->is_holiday)+1
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else{
        
        $start = Input::get("period");
        $end = Input::get("period1");

        $apps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->where('date_approved','<=',date('Y-m-d'))
                    ->whereBetween('date_approved', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.approvedReport', compact('apps','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Approved_Leave_Report.pdf');

      }
        
    }

    public function rejectedperiod()
    {
        return View::make('leavereports.rejectedSelect');
    }

    public function rejectedleaves(){

      if(Input::get('format') == "excel"){
      
        $start = Input::get("period");
        $end = Input::get("period1");

        $data = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->whereBetween('date_rejected', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Leave Rejected Report for period between '.$start.' and '.$end, function($excel) use($data,$start,$end,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Leave Rejected Report', function($sheet) use($data,$start,$end,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'Leave Rejected Report for period between '.$start.' and '.$end
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NUMBER', 'EMPLOYEE NAME', 'LEAVE TYPE','REJECTED DATE','START DATE','END DATE','LEAVE DAYS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->name,$data[$i]->date_rejected,$data[$i]->applied_start_date,$data[$i]->applied_end_date,Leaveapplication::getDays($data[$i]->applied_end_date,$data[$i]->applied_start_date,$data[$i]->is_weekend,$data[$i]->is_holiday)+1
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else{
        
        $start = Input::get("period");
        $end = Input::get("period1");

        $rejs = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->whereBetween('date_rejected', array($start, $end))->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.rejectedReport', compact('rejs','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Rejected_Leave_Report.pdf');
      }
        
    }
    public function balanceselect()
    {
        $leaves = Leavetype::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('leavereports.balanceSelect',compact('leaves'));
    }

    public function leavebalances(){

       if(Input::get('format') == "excel"){

        $id = Input::get("balance");

        $start = Input::get("period");
        $end = Input::get("period1");

        $leavetype = Leavetype::find($id);
        
        $data= Employee::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Leave Balance Report ', function($excel) use($data,$leavetype,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Leave Balance Report', function($sheet) use($data,$leavetype,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:C3');
              $sheet->row(3, array(
              'Leave Balance Report'
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NUMBER', 'EMPLOYEE NAME', 'LEAVE DAYS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,Leaveapplication::getTotalBalanceDays($data[$i], $leavetype)
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else{
        
        $id = Input::get("balance");
        $start = Input::get("period");
        $end = Input::get("period1");

        $leavetype = Leavetype::find($id);
        
        $employees= Employee::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.balanceReport', compact('employees','start','end','leavetype','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream($leavetype->name.'_balances_Report.pdf');
      }
        
    }

    public function leaveselect()
    {
        $leaves = Leavetype::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('leavereports.leaveSelect',compact('leaves'));
    }

    public function employeesleave(){
        
         
       if(Input::get('format') == "excel"){
      
        $id = Input::get("balance");

        $start = Input::get("period");
        $end = Input::get("period1");

        $leavetype = Leavetype::find($id);

         $data = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->where('date_approved','<=',date('Y-m-d'))
                    ->where('leavetype_id','=',$id)
                    ->whereBetween('date_approved', array($start, $end))->get();

                    dd($data);

        /*$data = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('leavetype_id','=',$id)
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->where('approved_start_date','<=',date('Y-m-d'))
                    ->where('approved_end_date','>=',date('Y-m-d'))
                    ->where('date_approved','!=','NULL')
                    ->whereBetween('date_approved', array($start, $end))
                    ->get();*/


        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Employees on Leaves Report for '.$leavetype->name, function($excel) use($data,$leavetype,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Employees on Leaves', function($sheet) use($data,$leavetype,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:G3');
              $sheet->row(3, array(
              'Employees on Leaves Report for '.$leavetype->name
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'PAYROLL NUMBER', 'EMPLOYEE NAME', 'LEAVE TYPE','APPROVED DATE','START DATE','END DATE','LEAVE DAYS'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
             
             for($i = 0; $i<count($data); $i++){

              $name = '';

             if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->name,$data[$i]->date_approved,$data[$i]->approved_start_date,$data[$i]->approved_end_date,Leaveapplication::getDays($data[$i]->approved_end_date,$data[$i]->approved_start_date,$data[$i]->is_weekend,$data[$i]->is_holiday)+1
             ));
             $row++;
             }             
             
    });

  })->download('xls');
      }else{

        $id = Input::get("balance");

        $start = Input::get("period");
        $end = Input::get("period1");

        $leavetype = Leavetype::find($id);

        $emps = DB::table('leaveapplications')
                    ->join('employee', 'leaveapplications.employee_id', '=', 'employee.id')
                    ->join('leavetypes', 'leaveapplications.leavetype_id', '=', 'leavetypes.id')
                    ->where('leavetype_id','=',$id)
                    ->where('employee.organization_id',Confide::user()->organization_id)
                    ->where('approved_start_date','<=',date('Y-m-d'))
                    ->where('approved_end_date','>=',date('Y-m-d'))
                    ->where('date_approved','!=','NULL')
                    ->whereBetween('date_approved', array($start, $end))
                    ->get();


        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.employeeReport', compact('emps','leavetype','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream('Employees_on_Leave_Report.pdf');

      }
        
    }

    public function employeeselect()
    {
        $employees = Employee::where('employee.organization_id',Confide::user()->organization_id)->get();
        return View::make('leavereports.employeeSelect',compact('employees'));
    }

    public function individualleave(){
        
        if(Input::get('format') == "excel"){
      
        $id = Input::get("employeeid");

        $employee = Employee::find($id);

        $data = Leavetype::where('organization_id',Confide::user()->organization_id)->get();

         $name = '';

             if($employee->middle_name == '' || $employee->middle_name == null){
               $name= $employee->first_name.' '.$employee->last_name;
             }else{
               $name=$employee->first_name.' '.$employee->middle_name.' '.$employee->last_name;
             }


        $organization = Organization::find(Confide::user()->organization_id);

    
  Excel::create('Leave Report for '.$employee->personal_file_number.' : '.$name, function($excel) use($data,$name,$employee,$organization) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Leave Report', function($sheet) use($data,$name,$employee,$organization,$objPHPExcel){


               $sheet->row(1, array(
              'Organization: ',$organization->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A3:D3');
              $sheet->row(3, array(
              'Leave Report for '.$employee->personal_file_number.' : '.$name
              ));

              $sheet->row(3, function($cell) {

               // manipulate the cell
                $cell->setAlignment('center');
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'LEAVE TYPE', 'BEGINNING BALANCE', 'LEAVE TAKEN','LEAVE BALANCE'
              ));

              $sheet->row(5, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 6;
             
              foreach($employee->leaveapplications as $application){
             if($application->approved_start_date<=date('Y-m-d')){
             $sheet->row($row, array(
             $application->leavetype->name,Leaveapplication::getBegBalanceDays($employee, $application->leavetype,$application),Leaveapplication::getDays($application->approved_end_date,$application->approved_start_date,$application->is_weekend,$application->is_holiday)+1,(Leaveapplication::getBegBalanceDays($employee, $application->leavetype,$application))-(Leaveapplication::getDays($application->approved_end_date,$application->approved_start_date,$application->is_weekend,$application->is_holiday)+1)
             ));
             $row++;
             }  
             }           
             
    });

  })->download('xls');
      }else{

         
        $id = Input::get("employeeid");

        $employee = Employee::find($id);

        $leavetypes = Leavetype::where('organization_id',Confide::user()->organization_id)->get();

        $organization = Organization::find(Confide::user()->organization_id);

        $pdf = PDF::loadView('leavereports.individualReport', compact('leavetypes','employee','organization'))->setPaper('a4')->setOrientation('potrait');
    
        return $pdf->stream($employee->first_name.'_'.$employee->last_name.'_Leave_Report.pdf');
        }
    }

    public function excelAll(){

     $data = DB::table('employee_allowances')
                  ->join('employee', 'employee_allowances.employee_id', '=', 'employee.id')
                  ->join('allowances', 'employee_allowances.allowance_id', '=', 'allowances.id')
                  ->where('employee.organization_id',Confide::user()->organization_id)
                  ->select('personal_file_number','first_name','last_name','allowance_name','allowance_amount')
                  ->get();
     $employees = Employee::all();

    
  Excel::create('Allowances', function($excel) use($data, $employees) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('allowances', function($sheet) use($data, $employees,$objPHPExcel){


              $sheet->row(1, array(
              'PERSONAL FILE NUMBER', 'EMPLOYEE', 'ALLOWANCE TYPE', 'AMOUNT'
              ));

              
            
            $row = 2;
             
             
             for($i = 0; $i<count($data); $i++){
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$data[$i]->first_name.' '.$data[$i]->last_name,$data[$i]->allowance_name,$data[$i]->allowance_amount
             ));
             
             $row++;
             
             }       
             

    });

  })->download('xls');
  
}
  

public function period_advrem()
    {
        $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
        $depts = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.remittanceAdvanceSelect',compact('branches','depts'));
    }

    public function payeAdvRems(){
         if(Input::get('format') == "excel"){
        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
         $total = DB::table('transact_advances')
        ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('mode_of_payment' ,'=', 'Bank')
        ->sum('amount');

        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.bank_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        /*$branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();*/


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Remittances '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Remittances', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
              
              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'SALARY ADVANCE TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->amount
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
            
    });

  })->download('xls');
  }else if(Input::get('department') == 'All'){

         $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');

        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Remittances '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Remittances', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'SALARY ADVANCE TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->amount
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }else if(Input::get('branch') == 'All'){
          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('department_id' ,'=', Input::get('department'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');

        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('department_id' ,'=', Input::get('department'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Remittances '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Remittances', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'SALARY ADVANCE TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }

             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->amount
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }else if(Input::get('branch') != 'All' && Input::get('department') != 'All' ){
          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('department_id' ,'=', Input::get('department'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');
        
        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('department_id' ,'=', Input::get('department'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get();

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Remittances '.$month, function($excel) use($data,$total,$organization,$currency,$branch,$bank) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Remittances', function($sheet) use($data,$total,$organization,$currency,$branch,$bank,$objPHPExcel){
            $orgbankname = '';
            $orgbankbranchname = '';
            
            if($organization->bank_id==0){
            $orgbankname = '';
            }else{
            $orgbankname = Bank::getName($organization->bank_id);
            }
            
            if($organization->bank_branch_id==0){
            $orgbankbranchname = '';
            }else{
            $orgbankbranchname = $branch->bank_branch_name;
            }

              $sheet->row(1, array(
              'BANK NAME: ',$orgbankname 
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'BANK BRANCH: ',$orgbankbranchname
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              $sheet->row(3, array(
              'BANK ACCOUNT:', $organization->bank_account_number
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'BANK ACCOUNT:', $organization->swift_code
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(5, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A5', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(6, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A6', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A8:H8');

              $sheet->row(8, array(
              'SALARY ADVANCE TRANSFER LETTER'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->mergeCells('A10:H10');

              $sheet->row(10, array(
              'Please arrange to transfer funds to the below listed employees` respective bank accounts
'
              ));

              $sheet->row(12, array(
              'PAYROLL NO.', 'EMPLOYEE','ID NO.','BANK', 'BANK BRANCH','BANK ACCOUNT','SWIFT CODE','AMOUNT'
              ));

              $sheet->row(12, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            $row = 13;
             
             
            for($i = 0; $i<count($data); $i++){
            $bankname = '';
            $bankbranchname = '';
            $name = '';
            
            if($data[$i]->bank_id==0){
            $bankname = '';
            }else{
            $bankname = $data[$i]->bank_name;
            }
            
            if($data[$i]->bank_branch_id==0){
            $bankbranchname = '';
            }else{
            $bankbranchname = $data[$i]->bank_branch_name;
            }

            if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->identity_number,$bankname,$bankbranchname,$data[$i]->bank_account_number,$data[$i]->swift_code,$data[$i]->amount
             ));

             $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','','','','','','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('H'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });

              $sheet->mergeCells('A'.($row+2).':H'.($row+2));

             $sheet->row($row+2, array(
             'Please debit our account with your bank charges and confirm once the above transfer has been made.'
             ));
             
    });

  })->download('xls');
  }
  }else{
        $period = Input::get("period");
        

        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){

          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('amount');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $rems = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

         $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.advanceremittanceReport', compact('rems','branch','bank','total','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_Remittance_'.$month.'.pdf');

        }else if(Input::get('department') == 'All'){
          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $rems = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();


        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.advanceremittanceReport', compact('rems','branch','bank','total','emps','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_Remittance_'.$month.'.pdf');

        } else if(Input::get('branch') == 'All'){
          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->join('banks', 'employee.banK_id', '=', 'banks.id')
          ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
          ->where('department_id' ,'=', Input::get('department'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');

        $currencies = DB::table('currencies')
            ->select('shortname')
            ->get();

        $rems = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->where('department_id' ,'=', Input::get('department'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('mode_of_payment' ,'=', 'Bank')
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.advanceremittanceReport', compact('rems','total','branch','bank','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_Remittance_'.$month.'.pdf');

        } else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
          $total = DB::table('transact_advances')
          ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
          ->where('branch_id' ,'=', Input::get('branch'))
          ->where('department_id' ,'=', Input::get('department'))
          ->where('mode_of_payment' ,'=', 'Bank')
          ->where('employee.organization_id',Confide::user()->organization_id)
          ->where('financial_month_year' ,'=', Input::get('period'))
          ->sum('amount');

        $currencies = DB::table('currencies')
        ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $rems = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('department_id' ,'=', Input::get('department'))
            ->where('mode_of_payment' ,'=', 'Bank')
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $branch=DB::table('bank_branches')
            ->join('organizations', 'bank_branches.organization_id', '=', 'organizations.id')
            ->where('bank_branches.id','=',$organization->bank_branch_id)
            ->first();

        $bank=DB::table('banks')
            ->join('organizations', 'banks.organization_id', '=', 'organizations.id')
            ->where('banks.id','=',$organization->bank_id)
            ->first();

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.advanceremittanceReport', compact('rems','branch','bank','total','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_Remittance_'.$month.'.pdf');

        } 

    }                      
        
    }


   public function period_advsummary()
    {
        $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
        $depts = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
        return View::make('pdf.summaryAdvanceSelect',compact('branches','depts'));
    }

    public function payAdvSummary(){
        if(Input::get('format') == "excel"){
        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
         $total = DB::table('transact_advances')
         ->where('employee.organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('amount');

        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('banks', 'employee.banK_id', '=', 'banks.id')
            ->join('bank_branches', 'employee.bank_branch_id', '=', 'bank_branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Summary '.$month, function($excel) use($data,$total,$organization,$currency) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Summary', function($sheet) use($data,$total,$organization,$currency,$objPHPExcel){
            
              $sheet->row(1, array(
              'BRANCH: ','ALL'
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ','ALL'
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');

              $sheet->row(6, array(
              'ADVANCE SALARY SUMMARY'
              ));

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(8, array(
              'PAYROLL NO.', 'EMPLOYEE','AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            
               
            $row = 9;
             
             
            for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else if(Input::get('department') == 'All'){

    $sels = DB::table('branches')->find(Input::get('branch')); 

         $total = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $data = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('branches', 'employee.branch_id', '=', 'branches.id')
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Summary '.$month, function($excel) use($data,$total,$organization,$currency,$sels) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Summary', function($sheet) use($data,$total,$organization,$currency,$sels,$objPHPExcel){
           
              $sheet->row(1, array(
              'BRANCH: ', $sels->name
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ','ALL'
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');

              $sheet->row(6, array(
              'ADVANCE SALARY SUMMARY'
              ));

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(8, array(
              'PAYROLL NO.', 'EMPLOYEE','AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            
               
            $row = 9;
             
             
            for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else if(Input::get('branch') == 'All'){
          $sels = DB::table('departments')->find(Input::get('department')); 

          $total = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');

        $data = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Summary '.$month, function($excel) use($data,$total,$organization,$currency,$sels) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Summary', function($sheet) use($data,$total,$organization,$currency,$sels,$objPHPExcel){
           
              $sheet->row(1, array(
              'BRANCH: ', 'ALL'
              ));
              
              $sheet->cell('A1', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ',$sels->department_name
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');

              $sheet->row(6, array(
              'ADVANCE SALARY SUMMARY'
              ));

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(8, array(
              'PAYROLL NO.', 'EMPLOYEE','AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            
               
            $row = 9;
      
             
            for($i = 0; $i<count($data); $i++){
               
               $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
             $selBr = DB::table('branches')->find(Input::get('branch')); 
             $selDt = DB::table('departments')->find(Input::get('department')); 

          $total = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('department_id' ,'=', Input::get('department'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');
         

        $data = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->join('branches', 'employee.branch_id', '=', 'branches.id')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

        $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

    
  Excel::create('Salary Advance Summary '.$month, function($excel) use($data,$total,$organization,$currency,$selBr,$selDt) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php");


   $objPHPExcel = new PHPExcel(); 
   // Set the active Excel worksheet to sheet 0
   $objPHPExcel->setActiveSheetIndex(0); 
    

    $excel->sheet('Salary Advance Summary', function($sheet) use($data,$total,$organization,$currency,$selBr,$selDt,$objPHPExcel){
           
              $sheet->row(1, array(
              'BRANCH: ', $selBr->name
              ));
               // manipulate the cell
              $sheet->cell('A1', function($cell) {
                $cell->setFontWeight('bold');

              });
               
               $sheet->row(2, array(
              'DEPARTMENT: ',$selDt->department_name
              ));
              
              $sheet->cell('A2', function($cell) {

               // manipulate the cell
              
                $cell->setFontWeight('bold');

              });


              
              $sheet->row(3, array(
              'CURRENCY:', $currency->shortname
              ));

              $sheet->cell('A3', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->row(4, array(
              'PERIOD:', Input::get('period')
              ));

              $sheet->cell('A4', function($cell) {

               // manipulate the cell
                $cell->setFontWeight('bold');

              });

              $sheet->mergeCells('A6:C6');

              $sheet->row(6, array(
              'ADVANCE SALARY SUMMARY'
              ));

              $sheet->row(6, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
              $r->setAlignment('center');
              });

              $sheet->row(8, array(
              'PAYROLL NO.', 'EMPLOYEE','AMOUNT'
              ));

              $sheet->row(8, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
               
            
               
            $row = 9;
             
             
            for($i = 0; $i<count($data); $i++){

              $name = '';

              if($data[$i]->middle_name == '' || $data[$i]->middle_name == null){
               $name= $data[$i]->first_name.' '.$data[$i]->last_name;
             }else{
               $name=$data[$i]->first_name.' '.$data[$i]->middle_name.' '.$data[$i]->last_name;
             }
            
             $sheet->row($row, array(
             $data[$i]->personal_file_number,$name,$data[$i]->amount
             ));

             $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
             $row++;
             
             }       
             $sheet->row($row, array(
             '','Total',$total
             ));
            $sheet->row($row, function ($r) {

             // call cell manipulation methods
              $r->setFontWeight('bold');
 
              });
            $sheet->cell('C'.$row, function($cell) {

               // manipulate the cell
                $cell->setAlignment('right');

              });
             
    });

  })->download('xls');
  }
}else{
        $period = Input::get("period");
        $selBranch = Input::get("branch");
        $selDept = Input::get("department");


        if(Input::get('branch') == 'All' && Input::get('department') == 'All'){
         $total_amount = DB::table('transact_advances')
         ->where('organization_id',Confide::user()->organization_id)
        ->where('financial_month_year' ,'=', Input::get('period'))
        ->sum('amount');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $sums = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.summaryAdvanceReport', compact('sums','selBranch','selDept','total_amount','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_summary_'.$month.'.pdf');

        }else if(Input::get('department') == 'All'){
         $sels = DB::table('branches')->find(Input::get('branch')); 

         $total_amount = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $sums = DB::table('transact_advances')
            ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
            ->join('branches', 'employee.branch_id', '=', 'branches.id')
            ->where('employee.organization_id',Confide::user()->organization_id)
            ->where('branch_id' ,'=', Input::get('branch'))
            ->where('financial_month_year' ,'=', Input::get('period'))
            ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.summaryAdvanceReport', compact('sums','selBranch','selDept','sels','total_amount','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
  
    return $pdf->stream('Advance_summary_'.$month.'.pdf');

        } else if(Input::get('branch') == 'All'){
          $sels = DB::table('departments')->find(Input::get('department')); 

          $total_amount = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $sums = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('department_id' ,'=', Input::get('department'))
          ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.summaryAdvanceReport', compact('sums','selBranch','selDept','sels','total_amount','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_summary_'.$month.'.pdf');


        }   else if(Input::get('branch') != 'All' && Input::get('department') != 'All'){
             $selBr = DB::table('branches')->find(Input::get('branch')); 
             $selDt = DB::table('departments')->find(Input::get('department')); 

          $total_amount = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->sum('amount');
         

        $currencies = DB::table('currencies')
            ->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)
            ->select('shortname')
            ->get();

        $sums = DB::table('transact_advances')
         ->join('employee', 'transact_advances.employee_id', '=', 'employee.personal_file_number')
         ->join('branches', 'employee.branch_id', '=', 'branches.id')
         ->join('departments', 'employee.department_id', '=', 'departments.id')
         ->where('branch_id' ,'=', Input::get('branch'))
         ->where('employee.organization_id',Confide::user()->organization_id)
         ->where('department_id' ,'=', Input::get('department'))
         ->where('financial_month_year' ,'=', Input::get('period'))
         ->get(); 

        $organization = Organization::find(Confide::user()->organization_id);

        $part = explode("-", Input::get('period'));
              
              $m = "";

              if(strlen($part[0]) == 1){
                $m = "0".$part[0];
              }else{
                $m = $part[0];
              }
              
              $month = $m."_".$part[1];

        $pdf = PDF::loadView('pdf.summaryAdvanceReport', compact('sums','selBranch','selDept','selBr','selDt','total_amount','currencies','period','organization'))->setPaper('a4')->setOrientation('landscape');
    
        return $pdf->stream('Advance_summary_'.$month.'.pdf');

        }                       
        
    }

}

public function monthlyrepayments(){

    $date = Input::get('date');
    $loanid=Input::get('member'); 
    if($date!=null && $loanid!=null){
      $scrapdate=Loanrepayment::where('loanaccount_id','=',$loanid)
      ->where('organization_id',Confide::user()->organization_id)
      ->get();       
      $organization = Organization::where('id',Confide::user()->organization_id)
      ->get()->first();
      $pdf = PDF::loadView('pdf.monthlyrepayments', compact('date','scrapdate', 'organization'))
      ->setPaper('a4')->setOrientation('potrait');
      return $pdf->stream('Monthly Repayment Report.pdf');
    }else{
      return Redirect::back()
      ->withAlarm('Please select the repayment duration and the respective member');
    }                   
  }
  
  public function creditappraisal($id,$loanid){
    $member = Member::where('id','=',$id)
          ->where('organization_id',Confide::user()->organization_id)->get()
          ->first();
    $loans= Loanaccount::where('member_id','=',$id)
        ->where('organization_id',Confide::user()->organization_id)
        ->where('is_disbursed','=',1)
        ->get();    
    $currentloan=Loanaccount::where('id','=',$loanid)
          ->where('organization_id',Confide::user()->organization_id)
          ->get()->first();   
    $savingaccount=DB::table('savingaccounts')
          ->where('organization_id',Confide::user()->organization_id)
          ->where('member_id','=',$id)->pluck('account_number');
    $savings=DB::table('savingtransactions')
        ->join('savingaccounts','savingtransactions.savingaccount_id','=','savingaccounts.id')
        ->where('savingaccounts.member_id','=',$id)
        ->where('savingtransactions.type','=','credit')
        ->where('organization_id',Confide::user()->organization_id)
        ->sum('savingtransactions.amount');
    $shareaccount=DB::table('shareaccounts')
          ->where('organization_id',Confide::user()->organization_id)
          ->where('member_id','=',$id)->pluck('account_number');
    $shares=DB::table('sharetransactions')
        ->join('shareaccounts','sharetransactions.shareaccount_id','=','shareaccounts.id')
        ->where('shareaccounts.member_id','=',$id)
        ->where('organization_id',Confide::user()->organization_id)
        ->where('sharetransactions.type','=','credit')
        ->sum('sharetransactions.amount');    
    $pdf = PDF::loadView('pdf.loanreports.creditappraisal', compact('member', 'loans','savings','savingaccount','shares','shareaccount','currentloan'))->setPaper('a4')->setOrientation('portrait');  
    return $pdf->stream('Member Credit Appraisal Report.pdf');
    
  }

}
