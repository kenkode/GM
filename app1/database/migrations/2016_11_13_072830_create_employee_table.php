<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employee', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('organization_id')->unsigned();
			$table->foreign('organization_id')->references('id')->on('organizations')->onDelete('restrict')->onUpdate('cascade');
			$table->string('personal_file_number',30)->unique();
			$table->string('first_name',50);
			$table->string('last_name',50);
			$table->string('middle_name',50)->nullable();
			$table->string('identity_number',20)->unique();
			$table->string('passport_number',20)->nullable()->unique();
			$table->double('basic_pay',15,2)->default('0.00');
			$table->double('vol_amount',15,2)->default('0.00');
			$table->string('pin',20)->nullable()->unique();
			$table->string('social_security_number',20)->nullable()->unique();
			$table->string('hospital_insurance_number',20)->nullable()->unique();
			$table->string('work_permit_number',30)->nullable()->unique();
			$table->string('job_title',50)->nullable();
			$table->integer('branch_id')->nullable()->unsigned();
			$table->foreign('branch_id')->references('id')->on('branches')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('department_id')->nullable()->unsigned();
			$table->foreign('department_id')->references('id')->on('departments')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('job_group_id')->nullable()->nullable()->unsigned();
			$table->foreign('job_group_id')->references('id')->on('job_group')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('type_id')->nullable()->unsigned();
			$table->foreign('type_id')->references('id')->on('employee_type')->onDelete('restrict')->onUpdate('cascade');
			$table->string('photo')->nullable();
			$table->string('signature')->nullable();
			$table->string('gender',6)->nullable();
			$table->string('marital_status',15)->nullable();
			$table->date('yob')->nullable();
			$table->integer('citizenship_id')->nullable()->unsigned();
			$table->foreign('citizenship_id')->references('id')->on('citizenships')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('education_type_id')->nullable()->unsigned();
			$table->foreign('education_type_id')->references('id')->on('education')->onDelete('restrict')->onUpdate('cascade');
			$table->integer('income_tax_applicable')->default('1');
			$table->integer('income_tax_relief_applicable')->default('1');
			$table->integer('hospital_insurance_applicable')->default('1');
			$table->integer('social_security_applicable')->default('1');
            $table->string('mode_of_payment',15)->nullable();
            $table->integer('bank_id')->nullable()->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('restrict')->onUpdate('cascade');
            $table->integer('bank_branch_id')->nullable()->unsigned();
            $table->foreign('bank_branch_id')->references('id')->on('bank_branches')->onDelete('restrict')->onUpdate('cascade');
            $table->string('bank_account_number',30)->nullable()->unique();
            $table->string('bank_eft_code',30)->nullable()->unique();
            $table->string('swift_code',30)->nullable()->unique();
            $table->double('time_clock_rate_normal',15,2)->default('0.00');
            $table->double('day_clock_rate_normal',15,2)->default('0.00');
            $table->double('time_clock_rate_weekday',15,2)->default('0.00');
            $table->double('day_clock_rate_weekday',15,2)->default('0.00');
            $table->double('time_clock_rate_saturday',15,2)->default('0.00');
            $table->double('day_clock_rate_saturday',15,2)->default('0.00');
            $table->double('time_clock_rate_sunday',15,2)->default('0.00');
            $table->double('day_clock_rate_sunday',15,2)->default('0.00');
            $table->double('time_clock_rate_holiday',15,2)->default('0.00');
            $table->double('day_clock_rate_holiday',15,2)->default('0.00');
            $table->char('medical_smoker',1)->nullable();
            $table->string('medical_blood_group',3)->nullable();
            $table->string('medical_disabilities')->nullable();
            $table->string('medical_conditions')->nullable();
            $table->string('email_office')->unique();
            $table->string('email_personal')->nullable()->unique();
            $table->string('telephone_office',30)->nullable()->unique();
            $table->string('telephone_extension_office',30)->nullable()->unique();
            $table->string('telephone_mobile',30)->nullable()->unique();
            $table->string('postal_address')->nullable();
            $table->string('postal_zip',30)->nullable();
            $table->string('date_joined',30)->nullable();
            $table->integer('bf_leave_days')->default('0');
            $table->integer('annual_leave_days')->default('0');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_css_active')->default('0');
            $table->string('custom_field1',30)->nullable();
            $table->string('custom_field2',30)->nullable();
            $table->string('custom_field3',30)->nullable();
            $table->string('custom_field4',30)->nullable();
            //$table->integer('user_id')->unsigned()->default('0')->index('employee_user_id_foreign');
			$table->char('in_employment',1)->default('Y');
			//$table->unique(['personal_file_number','email_personal','email_office','identity_number','passport_number','pin','social_security_number','hospital_insurance_number','telephone_mobile','telephone_office','telephone_extension_office','work_permit_number','bank_eft_code','bank_account_number','swift_code']);
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
		Schema::drop('employee');
	}

}
