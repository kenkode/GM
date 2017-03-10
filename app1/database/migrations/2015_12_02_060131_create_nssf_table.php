<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNssfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_security', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tier',30);
			$table->string('income_from',20)->default('0.00');
			$table->string('income_to',20)->default('0.00');
			$table->string('ss_amount_employee',20)->default('0.00');
			$table->string('ss_amount_employer',20)->default('0.00');
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
		Schema::drop('social_security');
	}

}
