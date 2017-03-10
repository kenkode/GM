<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('overtimes', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
            $table->string('type');
            $table->float('period',15,2);
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('amount')->default('0.00');
			$table->date('overtime_date');
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
		Schema::drop('overtimes');
	}

}
