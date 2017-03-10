<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmployeeBenefitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employeebenefits', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('jobgroup_id')->unsigned();
			$table->foreign('jobgroup_id')->references('id')->on('job_group')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('benefit_id')->unsigned();
			$table->foreign('benefit_id')->references('id')->on('benefitsettings')->onDelete('restrict')->onUpdate('cascade');
			$table->string('amount')->default('0.00');
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
		Schema::drop('employeebenefits');
	}

}
