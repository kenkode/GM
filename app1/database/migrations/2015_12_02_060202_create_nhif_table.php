<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNhifTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hospital_insurance', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('income_from',20)->default('0.00');
			$table->string('income_to',20)->default('0.00');
			$table->string('hi_amount',20)->default('0.00');
			$table->integer('organization_id')->unsigned();
			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('hospital_insurance');
	}

}
