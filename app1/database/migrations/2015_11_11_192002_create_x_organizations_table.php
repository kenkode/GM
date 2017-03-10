<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateXOrganizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('organizations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->default('XARA FINANCIALS')->nullable();
			$table->string('logo')->nullable();
			$table->string('email')->nullable();
			$table->string('website')->nullable();
			$table->string('address')->nullable();
			$table->string('phone')->nullable();
			$table->string('kra_pin')->nullable();
			$table->string('nssf_no')->nullable();
			$table->string('nhif_no')->nullable();
			$table->integer('bank_id')->unsigned()->default('0')->index('organization_bank_id_foreign');
			$table->integer('bank_branch_id')->unsigned()->default('0')->index('organization_bank_branch_id_foreign');
			$table->string('bank_account_number')->nullable();
			$table->string('swift_code')->nullable();
			$table->string('payroll_license_type')->nullable()->default('evaluation');
			$table->string('erp_license_type')->nullable()->default('evaluation');
			$table->string('cbs_license_type')->nullable()->default('evaluation');
			$table->string('license_code')->nullable();
			$table->integer('payroll_license_key')->default('0');
			$table->integer('erp_license_key')->default('0');
			$table->integer('cbs_license_key')->default('0');
			$table->bigInteger('erp_client_licensed')->nullable()->default(10);
			$table->bigInteger('erp_item_licensed')->nullable()->default(5);
			$table->bigInteger('payroll_licensed')->nullable()->default(10);
			$table->bigInteger('cbs_licensed')->nullable()->default(100);
			$table->string('payroll_code')->nullable()->default('P3110');
			$table->string('erp_code')->nullable()->default('E3110');
			$table->string('cbs_code')->nullable()->default('C3110');
			$table->date('payroll_support_period')->nullable();
			$table->date('erp_support_period')->nullable();
			$table->date('cbs_support_period')->nullable();
			$table->bigInteger('is_payroll_active')->nullable()->default(0);
			$table->bigInteger('is_erp_active')->nullable()->default(0);
			$table->bigInteger('is_cbs_active')->nullable()->default(0);
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
		Schema::drop('organizations');
	}

}
