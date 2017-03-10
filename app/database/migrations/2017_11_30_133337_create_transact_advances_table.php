<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactAdvancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transact_advances', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('employee_id');
			$table->foreign('employee_id')->references('personal_file_number')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('account_id')->unsigned()->default('0')->index('transact_account_id_foreign');
			$table->string('amount')->default('0.00');
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
		Schema::drop('transact_advances');
	}
}
