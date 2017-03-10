<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmergencyContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emergencycontacts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('relationship')->nullable();
			$table->string('phone1')->nullable();
			$table->string('phone2')->nullable();
			$table->string('id_number')->nullable();
			$table->string('same_address_employee')->nullable();
			$table->string('country')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip')->nullable();
			$table->string('county')->nullable();
			$table->string('home_phone')->nullable();
			$table->string('office_phone')->nullable();
			$table->string('cellular_phone')->nullable();
			$table->string('street_name')->nullable();
			$table->string('main_road')->nullable();
			$table->string('landmark')->nullable();
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
