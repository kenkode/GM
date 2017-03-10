<?php

class TasksController extends \BaseController {

	/**
	 * Display a listing of tasks
	 *
	 * @return Response
	 */
	public function index()
	{
		$tasks = Task::all();

		return View::make('tasks.index', compact('tasks'));
	}

	/**
	 * Show the form for creating a new task
	 *
	 * @return Response
	 */
	public function create()
	{
		$groups = Group::where('organization_id',Confide::User()->organization_id)->get();
		return View::make('tasks.create', compact('groups'));
	}

	/**
	 * Store a newly created task in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Task::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$task = new Task;

		$task->day_of_week = Input::get('day_of_week');
		$task->month_of_year = Input::get('month');
		$task->group = Input::get('group');
		$task->report = Input::get('report');
		$task->hour = Input::get('hour');
		$task->minute = Input::get('minute');
		$task->save();

		return Redirect::route('tasks.index');
	}

	/**
	 * Display the specified task.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$task = Task::findOrFail($id);

		return View::make('tasks.show', compact('task'));
	}

	/**
	 * Show the form for editing the specified task.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$task = Task::find($id);

		return View::make('tasks.edit', compact('task'));
	}

	/**
	 * Update the specified task in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$task = Task::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Task::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$task->update($data);

		return Redirect::route('tasks.index');
	}

	/**
	 * Remove the specified task from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Task::destroy($id);

		return Redirect::route('tasks.index');
	}

}
