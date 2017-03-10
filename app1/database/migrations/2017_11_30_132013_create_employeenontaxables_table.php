<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeNonTaxablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employeenontaxables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('nontaxable_id')->unsigned();
			$table->foreign('nontaxable_id')->references('id')->on('nontaxables')->onDelete('restrict')->onUpdate('cascade');
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('nontaxable_amount')->default('0.00');
			$table->date('nontaxable_date');
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
