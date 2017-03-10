<?php

class AppraisalsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$employees = Appraisal::where('organization_id',Confide::user()->organization_id)->get();

		$appraisals = DB::table('employee')
		          ->join('appraisals', 'employee.id', '=', 'appraisals.employee_id')
		          ->join('appraisalquestions', 'appraisals.appraisalquestion_id', '=', 'appraisalquestions.id')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->select('appraisals.id','appraisalquestion_id','first_name','middle_name','last_name','question','performance','appraisals.rate')
		          ->get();

		Audit::logaudit('Appraisals', 'view', 'viewed appraisals');

		return View::make('appraisals.index', compact('appraisals'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$employees = DB::table('employee')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->get();
		$appraisals = Appraisalquestion::where('organization_id',Confide::user()->organization_id)->get();
		$categories = Appraisalcategory::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		return View::make('appraisals.create',compact('employees','appraisals','categories'));
	}

	public function createquestion()
	{
      $postapp = Input::all();
      $data = array('appraisalcategory_id' => $postapp['category'], 
      	            'rate' => $postapp['rate'], 
      	            'question' => $postapp['question'],
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('appraisalquestions')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Appraisalquestions', 'create', 'created: '.$postapp['question']);
        return $check;
        }else{
         return 1;
        }
      
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Appraisal::$rules,Appraisal::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$appraisal = new Appraisal;

		$appraisal->employee_id = Input::get('employee_id');

		$appraisal->appraisalquestion_id = Input::get('appraisal_id');

                $appraisal->performance = Input::get('performance');

                $appraisal->rate = Input::get('score');

                $appraisal->examiner = Confide::user()->id;

                $appraisal->appraisaldate = Input::get('date');

                $appraisal->comment = Input::get('comment');
                
                $appraisal->organization_id = Confide::user()->organization_id;

		$appraisal->save();

		Audit::logaudit('Employee Appraisal', 'create', 'created: '.$appraisal->question.' for '.Employee::getEmployeeName(Input::get('employee_id')));


		return Redirect::to('Appraisals/view/'.$appraisal->id)->withFlashMessage('Employee Appraisal successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$appraisal = Appraisal::findOrFail($id);

		return View::make('appraisals.show', compact('appraisal'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$appraisal = Appraisal::find($id);
		$appraisalqs = Appraisalquestion::where('organization_id',Confide::user()->organization_id)->get();
		$user = User::find($appraisal->examiner);
                $categories = Appraisalcategory::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
		return View::make('appraisals.edit', compact('appraisal','appraisalqs','user','categories'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$appraisal = Appraisal::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Appraisal::$rules,Appraisal::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$appraisal->appraisalquestion_id = Input::get('appraisal_id');

        $appraisal->performance = Input::get('performance');

        $appraisal->rate = Input::get('score');

        $appraisal->appraisaldate = Input::get('date');

        $appraisal->comment = Input::get('comment');
        
        $appraisal->organization_id= Confide::user()->organization_id;

		$appraisal->update();

		Audit::logaudit('Appraisal Question', 'update', 'updated: '.$appraisal->question.' for '.Employee::getEmployeeName($appraisal->employee_id));


		return Redirect::to('Appraisals/view/'.$id)->withFlashMessage('Employee Appraisal successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$appraisal = Appraisal::findOrFail($id);
		
		Appraisal::destroy($id);

		Audit::logaudit('Employee Appraisal', 'delete', 'deleted: '.$appraisal->question.' for '.Employee::getEmployeeName($appraisal->employee_id));


		return Redirect::to('employees/view/'.$appraisal->employee_id)->withDeleteMessage('Employee Appraisal successfully deleted!');
	}

	public function view($id){

		$appraisal = Appraisal::find($id);

		$user = User::find($appraisal->examiner);

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('appraisals.view', compact('appraisal','user'));
		
	}

}
