<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactReliefsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transact_reliefs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('employee_relief_id')->unsigned()->default('0')->index('transact_reliefs_employee_relief_id_foreign');
			$table->integer('relief_id')->unsigned()->default('0')->index('transact_reliefs_relief_id_foreign');
			$table->string('relief_name');
			$table->double('relief_amount',15,2)->default('0.00');
			$table->string('financial_month_year');
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
		Schema::drop('transact_reliefs');
	}


}
