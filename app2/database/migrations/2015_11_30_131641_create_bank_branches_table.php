<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankBranchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_branches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('branch_code',30)->nullable();
			$table->string('bank_branch_name');
			$table->integer('bank_id')->unsigned();
			$table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict')->onUpdate('cascade');
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
		Schema::drop('bank_branches');
	}

}
