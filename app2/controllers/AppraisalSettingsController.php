<?php

class AppraisalSettingsController extends \BaseController {

	/**
	 * Display a listing of branches
	 *
	 * @return Response
	 */
	public function index()
	{
		$appraisals = Appraisalquestion::where('organization_id',Confide::user()->organization_id)->get();

		Audit::logaudit('Appraisal Settings', 'view', 'viewed appraisal settings');

		return View::make('appraisalsettings.index', compact('appraisals'));
	}

	/**
	 * Show the form for creating a new branch
	 *
	 * @return Response
	 */
	public function create()
	{
		$categories = Appraisalcategory::all();
		return View::make('appraisalsettings.create',compact('categories'));
	}

	public function createcategory()
	{
      $postallowance = Input::all();
      $data = array('name' => $postallowance['name'], 
      	            'organization_id' => Confide::user()->organization_id,
      	            'created_at' => DB::raw('NOW()'),
      	            'updated_at' => DB::raw('NOW()'));
      $check = DB::table('appraisalcategories')->insertGetId( $data );

		if($check > 0){
         
		Audit::logaudit('Appraisalcategories', 'create', 'created: '.$postallowance['name']);
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
		$validator = Validator::make($data = Input::all(), Appraisalquestion::$rules,Appraisalquestion::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$appraisal = new Appraisalquestion;

		$appraisal->appraisalcategory_id = Input::get('category');

                $appraisal->question = Input::get('question');

                $appraisal->rate = Input::get('rate');

                $appraisal->organization_id = Confide::user()->organization_id;

		$appraisal->save();

		Audit::logaudit('Appraisal Question', 'create', 'created: '.$appraisal->question);


		return Redirect::route('AppraisalSettings.index')->withFlashMessage('Appraisal Settings successfully created!');
	}

	/**
	 * Display the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$appraisal = Appraisalquestion::findOrFail($id);
        $categories = Appraisalcategory::all();
		return View::make('appraisalsettings.show', compact('categories'));
	}

	/**
	 * Show the form for editing the specified branch.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$appraisal = Appraisalquestion::find($id);
        $categories = Appraisalcategory::all();
		return View::make('appraisalsettings.edit', compact('appraisal','categories'));
	}

	/**
	 * Update the specified branch in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$appraisal = Appraisalquestion::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Appraisalquestion::$rules,Appraisalquestion::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$appraisal->appraisalcategory_id = Input::get('category');

                $appraisal->question = Input::get('question');

                $appraisal->rate = Input::get('rate');

		$appraisal->update();

		Audit::logaudit('Appraisal Question', 'update', 'updated: '.$appraisal->question);


		return Redirect::route('AppraisalSettings.index')->withFlashMessage('Appraisal Settings successfully updated!');
	}

	/**
	 * Remove the specified branch from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$appraisal = Appraisalquestion::findOrFail($id);

		$app  = DB::table('Appraisals')->where('Appraisalquestion_id',$id)->count();
		if($app>0){
			return Redirect::route('AppraisalSettings.index')->withDeleteMessage('Cannot delete this appraisal question because its assigned to appraisal(s)!');
		}else{
		
		Appraisalquestion::destroy($id);

		Audit::logaudit('Appraisal Question', 'delete', 'deleted: '.$appraisal->question);

		return Redirect::route('AppraisalSettings.index')->withDeleteMessage('Appraisal Settings successfully deleted!');
	   }
   }

}
