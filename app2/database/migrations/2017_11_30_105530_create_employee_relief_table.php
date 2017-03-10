<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeReliefTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_relief', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('relief_id')->unsigned();
			$table->foreign('relief_id')->references('id')->on('relief')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->string('relief_amount')->default('0.00');
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
		Schema::drop('employee_relief');
	}


}
