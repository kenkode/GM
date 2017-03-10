<?php

class OccurencesController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$occurences = DB::table('employee')
		          ->join('occurences', 'employee.id', '=', 'occurences.employee_id')
		          ->where('in_employment','=','Y')
		          ->where('employee.organization_id',Confide::user()->organization_id)
		          ->get();
        Audit::logaudit('Occurences', 'view', 'viewed occurences');

		return View::make('occurences.index', compact('occurences'));
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
		          ->where('organization_id',Confide::user()->organization_id)
		          ->get();
		$occurences = Occurencesetting::all();
		return View::make('occurences.create',compact('employees','occurences'));
	}

	public function createoccurence()
	{
      $postocc = Input::all();
      $data = array('occurence_type' => $postocc['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('occurencesettings')->insertGetId( $data );
     // $id = DB::table('earningsettings')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Occurencesettings', 'create', 'created: '.$postocc['name']);
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
		$validator = Validator::make($data = Input::all(), Occurence::$rules, Occurence::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$occurence = new Occurence;

		$occurence->occurence_brief = Input::get('brief');

		$occurence->employee_id = Input::get('employee');

		$occurence->occurencesetting_id = Input::get('type');

		$occurence->narrative = Input::get('narrative');

		$occurence->occurence_date = Input::get('date');

		if ( Input::hasFile('path')) {

            $file = Input::file('path');
            $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $occurence->doc_path = $name;
        }

        $occurence->organization_id = Confide::user()->organization_id;

		$occurence->save();

		Audit::logaudit('Occurences', 'create', 'created: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName(Input::get('employee')));


		return Redirect::to('occurences/view/'.$occurence->id)->withFlashMessage('Occurence successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$occurence = Occurence::findOrFail($id);

		return View::make('occurences.show', compact('occurence'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$occurence = Occurence::find($id);

		$occurencesettings = Occurencesetting::all();

		$employees = Employee::all();

		return View::make('occurences.edit', compact('occurence','employees','occurencesettings'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$occurence = Occurence::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Occurence::$rules, Occurence::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$occurence->occurence_brief = Input::get('brief');

		$occurence->occurencesetting_id = Input::get('type');

		$occurence->narrative = Input::get('narrative');

		$occurence->occurence_date = Input::get('date');

		if ( Input::hasFile('path')) {

            $file = Input::file('path');
            $name = $file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $occurence->doc_path = $name;
        }

		$occurence->update();

		Audit::logaudit('Occurences', 'update', 'updated: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName(Input::get('employee')));

		return Redirect::to('occurences/view/'.$id)->withFlashMessage('Occurence successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$occurence = Occurence::findOrFail($id);
		Occurence::destroy($id);

		Audit::logaudit('Occurences', 'delete', 'deleted: '.$occurence->occurence_brief.' for '.Employee::getEmployeeName($occurence->employee_id));

		return Redirect::to('employees/view/'.$occurence->employee_id)->withDeleteMessage('Occurence successfully deleted!');
	}

    public function view($id){

		$occurence = Occurence::find($id);

		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('occurences.view', compact('occurence'));
		
	}

	public function getDownload($id){
        //PDF file is stored under project/public/download/info.pdf
        $occurence = Occurence::findOrFail($id);
        $file= public_path(). "/uploads/employees/documents/".$occurence->doc_path;
        
        return Response::download($file, $occurence->doc_path);
}

}
