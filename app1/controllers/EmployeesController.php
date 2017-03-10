<?php

class EmployeesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$employees = Employee::getActiveEmployee();

		 Audit::logaudit('Employees', 'view', 'viewed employee list');

		return View::make('employees.index', compact('employees'));
	}

    public function createcitizenship()
	{
      $postcitizen = Input::all();
      $data = array('name' => $postcitizen['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('citizenships')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Citizenships', 'create', 'created: '.$postcitizen['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

	public function createeducation()
	{
      $posteducation = Input::all();
      $data = array('education_name' => $posteducation['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('education')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Educations', 'create', 'created: '.$posteducation['name']);
        return $check;
        }else{
         return 1;
        }
      
	}  

     public function createbank()
	{
      $postbank = Input::all();
      $data = array('bank_name' => $postbank['name'], 
      	            'bank_code' => $postbank['code'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('banks')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Banks', 'create', 'created: '.$postbank['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

	public function createbankbranch()
	{
      $postbankbranch = Input::all();
      $data = array('bank_branch_name' => $postbankbranch['name'], 
      	            'branch_code' => $postbankbranch['code'], 
      	            'bank_id' => $postbankbranch['bid'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('bank_branches')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Bank Branches', 'create', 'created: '.$postbankbranch['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

     public function createbranch()
	{
      $postbranch = Input::all();
      $data = array('name' => $postbranch['name'],
                    'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('branches')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Banks', 'create', 'created: '.$postbranch['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

    
    public function createdepartment()
	{
      $postdept = Input::all();
      $data = array('department_name' => $postdept['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('departments')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Departments', 'create', 'created: '.$postdept['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

    public function createtype()
	{
      $posttype = Input::all();
      $data = array('employee_type_name' => $posttype['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('employee_type')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Employee Types', 'create', 'created: '.$posttype['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

	public function creategroup()
	{
      $postgroup = Input::all();
      $data = array('job_group_name' => $postgroup['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('job_group')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Job Groups', 'create', 'created: '.$postgroup['name']);
        return $check;
        }else{
         return 1;
        }
      
	} 

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
    $organization = Organization::find(Confide::user()->organization_id);

    $employees = count(Employee::where('organization_id',Confide::user()->organization_id)->get());

    if($organization->payroll_licensed <= $employees){
       return View::make('employees.employeelimit');
    }else{
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		$branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$etypes = EType::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$banks = Bank::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$bbranches = BBranch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$educations = Education::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$pfn = 0;
    if(Employee::where('employee.organization_id',Confide::user()->organization_id)->orderBy('id', 'DESC')->count() == 0){
      $pfn = 0;
    }else{
      $pfn = Employee::where('employee.organization_id',Confide::user()->organization_id)->orderBy('id', 'DESC')->pluck('personal_file_number');
      $pfn = preg_replace('/\D/', '', $pfn);
      
    }
		return View::make('employees.create', compact('currency','citizenships','pfn','branches','departments','etypes','jgroups','banks','bbranches','educations'));
	}
  }


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	$validator = Validator::make($data = Input::all(), Employee::$rules,Employee::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
        
        try
        {
        $employee = new Employee;

       if ( Input::hasFile('image')) {

            $file = Input::file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/photo', $name);
            $input['file'] = '/public/uploads/employees/photo'.$name;
            $employee->photo = $name;
        }else{
        	$employee->photo = 'default_photo.png';
        }

        if ( Input::hasFile('signature')) {

            $file = Input::file('signature');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/signature/', $name);
            $input['file'] = '/public/uploads/employees/signature/'.$name;
            $employee->signature = $name;
        }else{
        	$employee->signature = 'sign_av.jpg';
        }

		$employee->personal_file_number = Input::get('personal_file_number');
		$employee->first_name = Input::get('fname');
		$employee->last_name = Input::get('lname');
		$employee->middle_name = Input::get('mname');
		$employee->identity_number = Input::get('identity_number');
		if(Input::get('passport_number') != null){
		$employee->passport_number = Input::get('passport_number');
	    }else{
        $employee->passport_number = null;
	    }
	    if(Input::get('pin') != null){
		$employee->pin = Input::get('pin');
		}else{
        $employee->pin = null;
	    }
	    if(Input::get('social_security_number') != null){
		$employee->social_security_number = Input::get('social_security_number');
	    }else{
        $employee->social_security_number = null;
	    }
	    if(Input::get('hospital_insurance_number') != null){
		$employee->hospital_insurance_number = Input::get('hospital_insurance_number');
	    }else{
        $employee->hospital_insurance_number = null;
	    }
	    if(Input::get('work_permit_number') != null){
		$employee->work_permit_number = Input::get('work_permit_number');
	    }else{
        $employee->work_permit_number = null;
	    }
        $employee->job_title = Input::get('jtitle');
        if(Input::get('education')==''){
        $employee->education_type_id = null;
        }else{
        $employee->education_type_id = Input::get('education');
        }
        $a = str_replace( ',', '', Input::get('pay') );
        $employee->basic_pay = $a;
        $employee->gender = Input::get('gender');
        $employee->marital_status = Input::get('status');
        $employee->yob = Input::get('dob');
        if(Input::get('citizenship')==''){
        $employee->citizenship_id = null;
        }else{
        $employee->citizenship_id = Input::get('citizenship');
        }
        $employee->mode_of_payment = Input::get('modep');
        if(Input::get('bank_account_number') != null ){
        $employee->bank_account_number = Input::get('bank_account_number');
        }else{
        $employee->bank_account_number = null;
	    }
	    if(Input::get('bank_eft_code') != null ){
        $employee->bank_eft_code = Input::get('bank_eft_code');
        }else{
        $employee->bank_eft_code = null;
        }if(Input::get('swift_code') != null ){
        $employee->swift_code = Input::get('swift_code');
        }else{
        $employee->swift_code = null;
        }
        if(Input::get('email_office') != null ){
        $employee->email_office = Input::get('email_office');
        }else{
        $employee->email_office = null;
        }
        if(Input::get('email_personal') != null ){
        $employee->email_personal = Input::get('email_personal');
        }else{
        $employee->email_personal = null;
        }
        if(Input::get('telephone_mobile') != null ){
        $employee->telephone_mobile = Input::get('telephone_mobile');
        }else{
        $employee->telephone_mobile = null;
        }
        $employee->postal_address = Input::get('address');
        $employee->postal_zip = Input::get('zip');
        $employee->date_joined = Input::get('djoined');
        if(Input::get('bank_id')==''){
        $employee->bank_id = null;
        }else{
	      $employee->bank_id = Input::get('bank_id');
        }
       if(Input::get('bbranch_id')==''){
        $employee->bank_branch_id = null;
        }else{
	      $employee->bank_branch_id = Input::get('bbranch_id');
        }
      if(Input::get('branch_id')==''){
       $employee->branch_id = null;
      }else{
	    $employee->branch_id = Input::get('branch_id');
      }
      if(Input::get('department_id')==''){
        $employee->department_id = null;
      }else{
	    $employee->department_id = Input::get('department_id');
      }
      if(Input::get('jgroup_id')==''){
        $employee->job_group_id = null;
      }else{
	    $employee->job_group_id = Input::get('jgroup_id');
    }
    if(Input::get('type_id')==''){
        $employee->type_id = null;
      }else{
		$employee->type_id = Input::get('type_id');
  }
		if(Input::get('i_tax') != null ){
		$employee->income_tax_applicable = '1';
	    }else{
	    $employee->income_tax_applicable = '0';
	    }
	    if(Input::get('i_tax_relief') != null ){
	    $employee->income_tax_relief_applicable = '1';
	    }else{
	    $employee->income_tax_relief_applicable = '0';
	    }
	    if(Input::get('a_nhif') != null ){
	    $employee->hospital_insurance_applicable = '1';
	    }else{
	    $employee->hospital_insurance_applicable = '0';
	    }
	    if(Input::get('a_nssf') != null ){
		$employee->social_security_applicable = '1';
	    }else{
	    $employee->social_security_applicable = '0';
	    }
	    $employee->custom_field1 = Input::get('omode');
		   $employee->organization_id = Confide::user()->organization_id;
        $employee->start_date = Input::get('startdate');
        $employee->end_date = Input::get('enddate');
        if(Input::get('active') != null ){
       $employee->in_employment = 'Y';
      }else{
      $employee->in_employment = 'N';
      }
		$employee->save();

    Audit::logaudit('Employee', 'create', 'created: '.$employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name);

    $insertedId = $employee->id;

    //parse_str(Input::get('kindata'),$output);
     

      //parse_str(Input::get('docinfo'),$data);

    for($i=0;$i<count(Input::get('kin_first_name'));$i++){
        if((Input::get('kin_first_name')[$i] != '' || Input::get('kin_first_name')[$i] != null) && (Input::get('kin_last_name')[$i] != '' || Input::get('kin_last_name')[$i] != null)){
        $kin = new Nextofkin;
        $kin->employee_id=$insertedId;
        $kin->first_name = Input::get('kin_first_name')[$i];
        $kin->last_name = Input::get('kin_last_name')[$i];
        $kin->middle_name = Input::get('kin_middle_name')[$i];
        $kin->relationship = Input::get('relationship')[$i];
        $kin->contact = Input::get('contact')[$i];
        $kin->id_number = Input::get('id_number')[$i];

        $kin->save();

        Audit::logaudit('NextofKins', 'create', 'created: '.Input::get('kin_first_name')[$i].' for '.Employee::getEmployeeName($insertedId));
       }
     }

      $files = Input::file('path');
      $j = 0;

       foreach($files as $file){
       
       if ( Input::hasFile('path') && (Input::get('doc_name')[$j] != null || Input::get('doc_name')[$j] != '')){
       $document= new Document;
        
        $document->employee_id = $insertedId;

            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('doc_name')[$j].'.'.$extension;
        

        $document->description = Input::get('description')[$j];

        $document->from_date = Input::get('fdate')[$j];

        $document->expiry_date = Input::get('edate')[$j];

        $document->save();

       Audit::logaudit('Documents', 'create', 'created: '.Input::get('doc_name')[$j].' for '.Employee::getEmployeeName($insertedId));
       $j=$j+1;
       }
       }

		return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');
		 }
    catch (FormValidationException $e)
    {
        return Redirect::back()->withInput()->withErrors($e->getErrors());
    }
	}

	public function getIndex(){
  
    return Redirect::route('employees.index')->withFlashMessage('Employee successfully created!');
    
        
	}

  public function serializeDoc(){
  
    parse_str(Input::get('docinfo'),$data);

    return $data;
    
        
  }

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$employee = Employee::findOrFail($id);

		return View::make('employees.show', compact('employee'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$employee = Employee::find($id);
		$branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$etypes = EType::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$contract = DB::table('employee')
		          ->join('employee_type','employee.type_id','=','employee_type.id')
		          ->where('type_id',2)
		          ->first();
		$banks = Bank::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$bbranches = BBranch::where('bank_id',$employee->bank_id)->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		$educations = Education::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $kins = Nextofkin::where('employee_id',$id)->get();
    $docs = Document::where('employee_id',$id)->get();
    $countk = Nextofkin::where('employee_id',$id)->count();
    $countd = Document::where('employee_id',$id)->count();
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
		return View::make('employees.edit', compact('currency','countk','countd','docs','kins','citizenships','contract','branches','educations','departments','etypes','jgroups','banks','bbranches','employee'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$employee = Employee::findOrFail($id);

		//$validator = Employee::validateUpdate(Input::all(), $id);

		$validator = Validator::make(Input::all(), Employee::rolesUpdate($employee->id),Employee::$messages);

		//$validator = Validator::make($data = Input::all(), Employee::$rules,Employee::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

        if ( Input::hasFile('image')) {

            $file = Input::file('image');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/photo', $name);
            $input['file'] = '/public/uploads/employees/photo'.$name;
            $employee->photo = $name;
        }else{
        	$employee->photo = Input::get('photo');
        }

        if ( Input::hasFile('signature')) {

            $file = Input::file('signature');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/signature/', $name);
            $input['file'] = '/public/uploads/employees/signature/'.$name;
            $employee->signature = $name;
        }else{
        	$employee->signature = Input::get('sign');
        }

		$employee->personal_file_number = Input::get('personal_file_number');
		$employee->first_name = Input::get('fname');
    $employee->last_name = Input::get('lname');
    $employee->middle_name = Input::get('mname');
    $employee->identity_number = Input::get('identity_number');
    if(Input::get('passport_number') != null){
    $employee->passport_number = Input::get('passport_number');
      }else{
        $employee->passport_number = null;
      }
      if(Input::get('pin') != null){
    $employee->pin = Input::get('pin');
    }else{
        $employee->pin = null;
      }
      if(Input::get('social_security_number') != null){
    $employee->social_security_number = Input::get('social_security_number');
      }else{
        $employee->social_security_number = null;
      }
      if(Input::get('hospital_insurance_number') != null){
    $employee->hospital_insurance_number = Input::get('hospital_insurance_number');
      }else{
        $employee->hospital_insurance_number = null;
      }
      if(Input::get('work_permit_number') != null){
    $employee->work_permit_number = Input::get('work_permit_number');
      }else{
        $employee->work_permit_number = null;
      }
        $employee->job_title = Input::get('jtitle');
        if(Input::get('education')==''){
        $employee->education_type_id = null;
        }else{
        $employee->education_type_id = Input::get('education');
        }
        $a = str_replace( ',', '', Input::get('pay') );
        $employee->basic_pay = $a;
        $employee->gender = Input::get('gender');
        $employee->marital_status = Input::get('status');
        $employee->yob = Input::get('dob');
        if(Input::get('citizenship')==''){
        $employee->citizenship_id = null;
        }else{
        $employee->citizenship_id = Input::get('citizenship');
        }
        $employee->mode_of_payment = Input::get('modep');
        if(Input::get('bank_account_number') != null ){
        $employee->bank_account_number = Input::get('bank_account_number');
        }else{
        $employee->bank_account_number = null;
      }
      if(Input::get('bank_eft_code') != null ){
        $employee->bank_eft_code = Input::get('bank_eft_code');
        }else{
        $employee->bank_eft_code = null;
        }if(Input::get('swift_code') != null ){
        $employee->swift_code = Input::get('swift_code');
        }else{
        $employee->swift_code = null;
        }
        if(Input::get('email_office') != null ){
        $employee->email_office = Input::get('email_office');
        }else{
        $employee->email_office = null;
        }
        if(Input::get('email_personal') != null ){
        $employee->email_personal = Input::get('email_personal');
        }else{
        $employee->email_personal = null;
        }
        if(Input::get('telephone_mobile') != null ){
        $employee->telephone_mobile = Input::get('telephone_mobile');
        }else{
        $employee->telephone_mobile = null;
        }
        $employee->postal_address = Input::get('address');
        $employee->postal_zip = Input::get('zip');
        $employee->date_joined = Input::get('djoined');
        if(Input::get('bank_id')==''){
        $employee->bank_id = null;
        }else{
        $employee->bank_id = Input::get('bank_id');
        }
       if(Input::get('bbranch_id')==''){
        $employee->bank_branch_id = null;
        }else{
        $employee->bank_branch_id = Input::get('bbranch_id');
        }
      if(Input::get('branch_id')==''){
       $employee->branch_id = null;
      }else{
      $employee->branch_id = Input::get('branch_id');
      }
      if(Input::get('department_id')==''){
        $employee->department_id = null;
      }else{
      $employee->department_id = Input::get('department_id');
      }
      if(Input::get('jgroup_id')==''){
        $employee->job_group_id = null;
      }else{
      $employee->job_group_id = Input::get('jgroup_id');
    }
    if(Input::get('type_id')==''){
        $employee->type_id = null;
      }else{
    $employee->type_id = Input::get('type_id');
  }
    if(Input::get('i_tax') != null ){
    $employee->income_tax_applicable = '1';
      }else{
      $employee->income_tax_applicable = '0';
      }
      if(Input::get('i_tax_relief') != null ){
      $employee->income_tax_relief_applicable = '1';
      }else{
      $employee->income_tax_relief_applicable = '0';
      }
      if(Input::get('a_nhif') != null ){
      $employee->hospital_insurance_applicable = '1';
      }else{
      $employee->hospital_insurance_applicable = '0';
      }
      if(Input::get('a_nssf') != null ){
    $employee->social_security_applicable = '1';
      }else{
      $employee->social_security_applicable = '0';
      }
      $employee->custom_field1 = Input::get('omode');
    $employee->organization_id = Confide::user()->organization_id;
        $employee->start_date = Input::get('startdate');
        $employee->end_date = Input::get('enddate');
        if(Input::get('active') != null ){
       $employee->in_employment = 'Y';
      }else{
      $employee->in_employment = 'N';
      }

		$employee->update();

		 Audit::logaudit('Employee', 'update', 'updated: '.$employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name);

    Nextofkin::where('employee_id', $id)->delete();
    for($i=0;$i<count(Input::get('kin_first_name'));$i++){
        if((Input::get('kin_first_name')[$i] != '' || Input::get('kin_first_name')[$i] != null) && (Input::get('kin_last_name')[$i] != '' || Input::get('kin_last_name')[$i] != null)){
        $kin = new Nextofkin;
        $kin->employee_id=$id;
        $kin->first_name = Input::get('kin_first_name')[$i];
        $kin->last_name = Input::get('kin_last_name')[$i];
        $kin->middle_name = Input::get('kin_middle_name')[$i];
        $kin->relationship = Input::get('relationship')[$i];
        $kin->contact = Input::get('contact')[$i];
        $kin->id_number = Input::get('id_number')[$i];

        $kin->save();

        Audit::logaudit('NextofKins', 'create', 'created: '.Input::get('kin_first_name')[$i].' for '.Employee::getEmployeeName($id));
       }
     }

      Document::where('employee_id', $id)->delete();
      $files = Input::file('path');
      $j = 0;

       foreach($files as $file){
       
       if ( Input::get('doc_name')[$j] != null || Input::get('doc_name')[$j] != ''){
       $document= new Document;
       $document->employee_id=$id;
       if ( $file){
       
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('doc_name')[$j].'.'.$extension;
        
        }else{
            $name = Input::get('curpath')[$j];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('doc_name')[$j].'.'.$extension;

        }

        $document->description = Input::get('description')[$j];

        $document->from_date = Input::get('fdate')[$j];

        $document->expiry_date = Input::get('edate')[$j];

        $document->save();

       Audit::logaudit('Documents', 'create', 'created: '.Input::get('doc_name')[$j].' for '.Employee::getEmployeeName($id));
       $j=$j+1;
       }
       }


		 if(Confide::user()->user_type == 'employee'){
		 	return Redirect::to('dashboard');
		 } else {
		 	return Redirect::route('employees.index')->withFlashMessage('Employee successfully updated!');
		 }
		
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$employee = Employee::findOrFail($id);
		
		Employee::destroy($id);

		 Audit::logaudit('Employee', 'delete', 'deleted: '.$employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name);


		return Redirect::route('employees.index')->withDeleteMessage('Employee successfully deleted!');
	}

	public function deactivate($id)
	{

		$employee = Employee::findOrFail($id);
		
		DB::table('employee')->where('id',$id)->update(array('in_employment'=>'N'));

		Audit::logaudit('Employee', 'deactivate', 'deactivated: '.$employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name);


		return Redirect::route('employees.index')->withDeleteMessage('Employee successfully deactivated!');
	}

	public function activate($id)
	{

		$employee = Employee::findOrFail($id);
		
		DB::table('employee')->where('id',$id)->update(array('in_employment'=>'Y'));

		Audit::logaudit('Employee', 'activate', 'activated: '.$employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name);


		return Redirect::to('deactives')->withFlashMessage($employee->personal_file_number.'-'.$employee->first_name.' '.$employee->last_name.' successfully activated!');
	}

	public function view($id){

		$employee = Employee::find($id);

		$appraisals = Appraisal::where('employee_id', $id)->get();

        $kins = Nextofkin::where('employee_id', $id)->get();

        $occurences = Occurence::where('employee_id', $id)->get();

        $properties = Property::where('employee_id', $id)->get();

        $documents = Document::where('employee_id', $id)->get();

        $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

        $count = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->count();

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('employees.view', compact('employee','appraisals','kins','documents','occurences','properties','count','benefits'));
		
	}

	public function viewdeactive($id){

		$employee = Employee::find($id);

		$appraisals = Appraisal::where('employee_id', $id)->get();

        $kins = Nextofkin::where('employee_id', $id)->get();

        $occurences = Occurence::where('employee_id', $id)->get();

        $properties = Property::where('employee_id', $id)->get();

        $documents = Document::where('employee_id', $id)->get();

        $benefits = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->get();

        $count = Employeebenefit::where('jobgroup_id', $employee->job_group_id)->count();

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('employees.viewdeactive', compact('employee','appraisals','kins','documents','occurences','properties','count','benefits'));
		
	}

  public function activateportal($id){

    $employee = Employee::find($id);


    $password = strtoupper(Str::random(8));

    

    $email = $employee->email_office;
    $name = $employee->first_name.' '.$employee->last_name;
    
    if($email != null){


      if(Mailsender::checkConnection() == false){

        return Redirect::back()->with('notice', 'Employee has not been activated. Could not establish interenet connection. kindly check your mail settings');
      }

    DB::table('users')->insert(
  array('email' => $employee->email_office, 
    'username' => $employee->personal_file_number,
    'password' => Hash::make($password),
    'user_type'=>'employee',
    'confirmation_code'=> md5(uniqid(mt_rand(), true)),
    'confirmed'=> 1,
    'organization_id'=> Confide::user()->organization_id
    )
);

    

    $employee->is_css_active = true;
    $employee->update();



  Mail::queue( 'emails.password', array('password'=>$password, 'name'=>$name), function( $message ) use ($employee)
{
    $message->to($employee->email_office )->subject( 'Self Service Portal Credentials' );
});


    


    return Redirect::back()->with('notice', 'Employee has been activated and login credentials emailed');

}

else{

  return Redirect::back()->with('notice', 'Employee has not been activated kindly update email address');

}





    

  }



  public function deactivateportal($id){

    
    $employee = Employee::find($id);

    DB::table('users')->where('username', '=', $employee->personal_file_number)->delete();

    $employee->is_css_active = false;
    $employee->update();


    return Redirect::back()->with('notice', 'Employee has been deactivated');;

    
  }

  public function reset($id){
    
    //$id = DB::table('members')->where('membership_no', '=', $mem)->pluck('id');
    $employee = Employee::findOrFail($id);
    
    $user_id = DB::table('users')->where('organization_id',Confide::user()->organization_id)->where('username', '=', $employee->personal_file_number)->pluck('id');
    
    $user = User::findOrFail($user_id);
    
    $user->password = Hash::make('123456');
    $user->update();
    
    return Redirect::back();
    
  }

	
}
