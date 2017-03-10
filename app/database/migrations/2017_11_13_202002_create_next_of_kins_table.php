<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNextOfKinsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nextofkins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name');
			$table->string('middle_name');
			$table->string('last_name');
			$table->string('relationship')->nullable();
			$table->text('contact')->nullable();
			$table->float('goodwill', 10, 0)->nullable();
			$table->string('id_number')->nullable();
			$table->integer('employee_id')->unsigned();
			$table->foreign('employee_id')->references('id')->on('employee')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('nextofkins');
	}

}
