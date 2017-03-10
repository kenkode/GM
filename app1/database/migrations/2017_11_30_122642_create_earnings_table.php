<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('earnings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('earning_id')->unsigned();
            $table->foreign('earning_id')->references('id')->on('earningsettings')->onDelete('restrict')->onUpdate('cascade');
            $table->string('narrative');
            $table->string('formular');
            $table->integer('instalments')->default('0')->nullable();
			$table->string('earnings_amount')->default('0.00');
			$table->date('earning_date');
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
		Schema::drop('earnings');
	}

}
