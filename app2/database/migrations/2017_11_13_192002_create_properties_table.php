<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('properties', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('serial')->nullable();
			$table->string('digitalserial')->nullable();
			$table->float('monetary',15,2)->default('0.00');
			$table->integer('issued_by')->unsigned();
			$table->foreign('issued_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->date('issue_date');
			$table->date('scheduled_return_date');
			$table->integer('state')->default('0');
			$table->integer('received_by')->nullable()->unsigned();
			$table->foreign('received_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
			$table->date('return_date')->nullable();
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
		Schema::drop('properties');
	}

}
