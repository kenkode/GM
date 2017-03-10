<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeDeductionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee_deductions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('deduction_id')->unsigned();
			$table->foreign('deduction_id')->references('id')->on('deductions')->onDelete('restrict')->onUpdate('cascade');
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('deduction_amount')->default('0.00');
			$table->date('deduction_date');
			$table->date('first_day_month');
			$table->date('last_day_month');
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
		Schema::drop('employee_deductions');
	}

}
