<?php

class DocumentsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$documents = DB::table('employee')
		          ->join('documents', 'employee.id', '=', 'documents.employee_id')
		          ->where('in_employment','=','Y')
		          ->get();
		Audit::logaudit('Documents', 'view', 'viewed documents');

		return View::make('documents.index', compact('documents'));
	}

	public function serializecheck(){
		
        return Input::get('path');
        
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$id = $id;
		$employees = DB::table('employee')
		          ->where('in_employment','=','Y')
		          ->get();

		return View::make('documents.create', compact('employees','id'));
	}

	/**
	 * Store a newly created branch in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Document::$rules, Document::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$document= new Document;
        
        $document->employee_id = Input::get('employee');
        $document->organization_id=Confide::User()->organization_id;

		if ( Input::hasFile('path')) {

            $file = Input::file('path');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('type').'.'.$extension;
        }

        $document->description = Input::get('desc');

        $document->from_date = Input::get('fdate');

        $document->expiry_date = Input::get('edate');

		$document->save();

		Audit::logaudit('Documents', 'create', 'created: '.$document->document_name.' for '.Employee::getEmployeeName(Input::get('employee')));

		return Redirect::to('employees/view/'.Input::get('employee'))->withFlashMessage('Employee document successfully uploaded!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$document = Document::findOrFail($id);

		return View::make('documents.show', compact('document'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$document = Document::find($id);

		return View::make('documents.edit', compact('document'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$document = Document::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Document::rolesUpdate(), Document::$messsages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		
		if ( Input::hasFile('path')) {

            $file = Input::file('path');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('public/uploads/employees/documents/', $name);
            $input['file'] = '/public/uploads/employees/documents/'.$name;
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('type').'.'.$extension;
        }else{
        	$name = Input::get('curpath');
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $document->document_path = $name;
            $document->document_name = Input::get('type').'.'.$extension;

        }

        $document->description = Input::get('desc');

        $document->from_date = Input::get('fdate');

        $document->expiry_date = Input::get('edate');

		$document->update();

		Audit::logaudit('Documents', 'update', 'updated: '.$document->document_name.' for '.Employee::getEmployeeName($document->employee_id));

		return Redirect::to('employees/view/'.Input::get('employee'))->withFlashMessage('Employee Document successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$document = Document::findOrFail($id);
		$file= public_path(). "/uploads/employees/documents/".$document->document_path;
        
		Document::destroy($id);
        
		unlink($file);

		Audit::logaudit('Documents', 'delete', 'deleted: '.$document->document_name.' for '.Employee::getEmployeeName($document->employee_id));

		return Redirect::to('employees/view/'.$document->employee_id)->withDeleteMessage('Employee Document successfully deleted!');
	}

    public function getDownload($id){
        //PDF file is stored under project/public/download/info.pdf
        $document = Document::findOrFail($id);
        $file= public_path(). "/uploads/employees/documents/".$document->document_path;
        
        return Response::download($file, $document->document_name);
}

}
