<?php

class RemindersController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$employees = Employee::where('type_id',2)->where('in_employment','Y')->where('employee.organization_id',Confide::user()->organization_id)->whereNotNull('start_date')->whereNotNull('end_date')->get();

        
		Audit::logaudit('Reminders', 'view', 'viewed contract reminders');


		return View::make('reminderview.index', compact('employees'));
	}

	public function indexdoc()
	{
		$employees = DB::table('documents')
             ->join('employee', 'documents.employee_id', '=', 'employee.id')
             ->where('employee.organization_id',Confide::user()->organization_id)
             ->where('in_employment','Y')
             ->whereNotNull('from_date')
             ->whereNotNull('expiry_date')
             ->select('first_name','middle_name','last_name','document_name','documents.id as did','employee.id as eid','from_date','expiry_date')
             ->get();
        
		Audit::logaudit('Reminders', 'view', 'viewed document reminders');


		return View::make('reminderview.indexdoc', compact('employees'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('allowances.create');
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Allowance::$rules, Allowance::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance = new Allowance;

		$allowance->allowance_name = Input::get('name');

        $allowance->organization_id = Confide::user()->organization_id;

		$allowance->save();

		Audit::logaudit('Allowances', 'create', 'created: '.$allowance->allowance_name);


		return Redirect::route('allowances.index')->withFlashMessage('Allowance successfully created!');
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

		return View::make('reminderview.show', compact('employee'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$allowance = Allowance::find($id);

		return View::make('allowances.edit', compact('allowance'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$allowance = Allowance::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Allowance::$rules, Allowance::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$allowance->allowance_name = Input::get('name');
		$allowance->update();

		Audit::logaudit('Allowances', 'update', 'updated: '.$allowance->allowance_name);

		return Redirect::route('allowances.index')->withFlashMessage('Allowance successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$allowance = Allowance::findOrFail($id);

        $allc  = DB::table('employee_allowances')->where('allowance_id',$id)->count();
		if($id == 1 || $id == 2){
			return Redirect::route('allowances.index')->withDeleteMessage('Cannot delete this allowance!');
		}elseif($allc>0){
			return Redirect::route('allowances.index')->withDeleteMessage('Cannot delete this allowance because its assigned to an employee(s)!');
		} else{

		Allowance::destroy($id);

		Audit::logaudit('Allowances', 'delete', 'deleted: '.$allowance->allowance_name);

		return Redirect::route('allowances.index')->withDeleteMessage('Allowance successfully deleted!');
	}
}

public function getDownload($id){
        //PDF file is stored under project/public/download/info.pdf
        $document = Document::findOrFail($id);
        $file= public_path(). "/uploads/employees/documents/".$document->document_path;
        
        return Response::download($file, $document->document_name);
}

}
