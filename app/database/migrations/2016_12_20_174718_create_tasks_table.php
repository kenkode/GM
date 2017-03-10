<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('group')->nullable();
			$table->string('report')->nullable();
			$table->string('day_of_week')->nullable();
			$table->string('month_of_year')->nullable();
			$table->string('day_of_month')->nullable();
			$table->string('hour')->nullable();
			$table->string('minute')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tasks');
	}

}
