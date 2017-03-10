<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder {
public function run()
{
$this->call('TenantsTableSeeder');
$this->command->info('User table seeded!');
}
}


class TenantsTableSeeder extends Seeder {

	public function run()
	{
        $organization = new Organization;

        $organization->name = 'Lixnet Technologies';
        $organization->logo = 'xara.png';
        $organization->save();
		
		$branch = new Branch;

		$branch->name = 'Head Office';
		$branch->save();

        $citizenship = new Citizenship;

        $citizenship->name = 'Kenyan';
        $citizenship->organization_id = 1;
        $citizenship->save();

        $citizenship = new Citizenship;

        $citizenship->name = 'Ugandan';
        $citizenship->organization_id = 1;
        $citizenship->save();

        $citizenship = new Citizenship;

        $citizenship->name = 'Tanzanian';
        $citizenship->organization_id = 1;
        $citizenship->save();

        $earning = new Earningsetting;

        $earning->earning_name = 'Bonus';
        $earning->organization_id = 1;
        $earning->save();

        $earning = new Earningsetting;

        $earning->earning_name = 'Commission';
        $earning->organization_id = 1;
        $earning->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Attendance and Punctuality';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Communication';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Dependability';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Individual Effectiveness';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Initiative';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Job Knowledge';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Judgement and Decision Making';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Ongoing Skill Improvement';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Quality of Work';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Safe Work Practise';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Service Focus';
        $cat->organization_id = 1;
        $cat->save();

        $cat = new Appraisalcategory;

        $cat->name = 'Team Building';
        $cat->organization_id = 1;
        $cat->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Absentism/Abandonment';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Abuse of Office';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Assessment';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Corruption';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Emergency Drill';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Incompetence';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Initiative';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Innovation';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Insubordination';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Intoxication';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Meeting';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Promotion';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Team Building';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Theft';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Training';
        $occ->organization_id = 1;
        $occ->save();

        $occ = new Occurencesetting;

        $occ->occurence_type = 'Violence';
        $occ->organization_id = 1;
        $occ->save();

		$currency = new Currency;

		$currency->name = 'Kenyan Shillings';
		$currency->shortname = 'KES';
		$currency->save();

        $dept = new Department;

        $dept->department_name = 'Finance';
        $dept->organization_id = 1;
        $dept->save();

        $dept = new Department;

        $dept->department_name = 'Human Resource';
        $dept->organization_id = 1;
        $dept->save();

        $dept = new Department;

        $dept->department_name = 'Information Technology';
        $dept->organization_id = 1;
        $dept->save();

        $dept = new Department;

        $dept->department_name = 'Management';
        $dept->organization_id = 1;
        $dept->save();

        $dept = new Department;

        $dept->department_name = 'Marketing';
        $dept->organization_id = 1;
        $dept->save();

        $type = new EType;

        $type->employee_type_name = 'Full Time';
        $type->organization_id = 1;
        $type->save();

        $type = new EType;

        $type->employee_type_name = 'Contract';
        $type->organization_id = 1;
        $type->save();

        $type = new EType;

        $type->employee_type_name = 'Internship';
        $type->organization_id = 1;
        $type->save();

        $allw = new Allowance;

        $allw->allowance_name = 'House Allowance';
        $allw->organization_id = 1;
        $allw->save();

        $allw = new Allowance;

        $allw->allowance_name = 'Transport Allowance';
        $allw->organization_id = 1;
        $allw->save();

        $ded = new Deduction;

        $ded->deduction_name = 'Salary Advance';
        $ded->organization_id = 1;
        $ded->save();

        $ded = new Deduction;

        $ded->deduction_name = 'Loans';
        $ded->organization_id = 1;
        $ded->save();

        $ded = new Deduction;

        $ded->deduction_name = 'Savings';
        $ded->organization_id = 1;
        $ded->save();

        $ded = new Deduction;

        $ded->deduction_name = 'Breakages and spoilages';
        $ded->organization_id = 1;
        $ded->save();

        $rel = new Relief;

        $rel->relief_name = 'Insurance Relief';
        $rel->organization_id = 1;
        $rel->save();

        $nontax = new Nontaxable;

        $nontax->name = 'Refunds';
        $nontax->organization_id = 1;
        $nontax->save();

        DB::table('job_group')->insert(array(
            array('job_group_name' => 'Junior Staff','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('job_group_name' => 'Management','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('job_group_name' => 'Marketing','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
        ));

        DB::table('education')->insert(array(
            array('education_name' => 'Primary School','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'Secondary School','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'College - Certificate','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'College - Diploma','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'Degree','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'Masters Degree','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'PHD','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('education_name' => 'None','organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
        ));

        DB::table('social_security')->insert(array(
            array('tier' => 'Tier I','income_from' => '0.00', 'income_to' => '0.00', 'ss_amount_employee' => '0.00', 'ss_amount_employer' => '0.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('tier' => 'Tier I','income_from' => '1.00', 'income_to' => '99000000.00', 'ss_amount_employee' => '200.00', 'ss_amount_employer' => '200.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
        ));

        DB::table('hospital_insurance')->insert(array(
            array('income_from' => '0.00', 'income_to' => '0.00', 'hi_amount' => '0.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '1.00', 'income_to' => '5999.00', 'hi_amount' => '150.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '6000.00', 'income_to' => '7999.00', 'hi_amount' => '300.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '8000.00', 'income_to' => '11999.00', 'hi_amount' => '400.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '12000.00', 'income_to' => '14999.00', 'hi_amount' => '500.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '15000.00', 'income_to' => '19999.00', 'hi_amount' => '600.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '20000.00', 'income_to' => '24999.00', 'hi_amount' => '750.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '25000.00', 'income_to' => '29999.00', 'hi_amount' => '850.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '30000.00', 'income_to' => '34999.00', 'hi_amount' => '900.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '35000.00', 'income_to' => '39999.00', 'hi_amount' => '950.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '40000.00', 'income_to' => '44999.00', 'hi_amount' => '1000.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '45000.00', 'income_to' => '49999.00', 'hi_amount' => '1100.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '50000.00', 'income_to' => '59999.00', 'hi_amount' => '1200.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '60000.00', 'income_to' => '69999.00', 'hi_amount' => '1300.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '70000.00', 'income_to' => '79999.00', 'hi_amount' => '1400.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '80000.00', 'income_to' => '89999.00', 'hi_amount' => '1500.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '90000.00', 'income_to' => '99999.00', 'hi_amount' => '1600.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
            array('income_from' => '100000.00', 'income_to' => '99000000.00', 'hi_amount' => '1700.00', 'organization_id' => '1','created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')),
        ));

        $share = new Share;


        $share->value = 0;
        $share->transfer_charge = 0;
        $share->charged_on = 'donor';
        $share->save();
    

    $perm = new Permission;

    $perm->name = 'create_employee';
    $perm->display_name = 'Create employee';
    $perm->category = 'Employee';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'update_employee';
    $perm->display_name = 'Update employee';
    $perm->category = 'Employee';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'delete_employee';
    $perm->display_name = 'Deactivate employee';
    $perm->category = 'Employee';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'view_employee';
    $perm->display_name = 'View employee';
    $perm->category = 'Employee';
    $perm->save();



    $perm = new Permission;

    $perm->name = 'manage_earning';
    $perm->display_name = 'Manage earnings';
    $perm->category = 'Payroll';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'manage_deduction';
    $perm->display_name = 'Manage deductions';
    $perm->category = 'Payroll';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'manage_allowance';
    $perm->display_name = 'Manage allowance';
    $perm->category = 'Payroll';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'manage_relief';
    $perm->display_name = 'Manage releif';
    $perm->category = 'Payroll';
    $perm->save();

    
    $perm = new Permission;

    $perm->name = 'manage_benefit';
    $perm->display_name = 'Manage benefits';
    $perm->category = 'Payroll';
    $perm->save();


     $perm = new Permission;

    $perm->name = 'process_payroll';
    $perm->display_name = 'Process payroll';
    $perm->category = 'Payroll';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'view_payroll_report';
    $perm->display_name = 'View reports';
    $perm->category = 'Payroll';
    $perm->save();

     $perm = new Permission;

    $perm->name = 'manage_settings';
    $perm->display_name = 'Manage settings';
    $perm->category = 'Payroll';
    $perm->save();


     $perm = new Permission;

    $perm->name = 'view_application';
    $perm->display_name = 'View applications';
    $perm->category = 'Leave';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'amend_application';
    $perm->display_name = 'Amend applications';
    $perm->category = 'Leave';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'approve_application';
    $perm->display_name = 'Approve applications';
    $perm->category = 'Leave';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'reject_application';
    $perm->display_name = 'Reject applications';
    $perm->category = 'Leave';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'cancel_application';
    $perm->display_name = 'Cancel applications';
    $perm->category = 'Leave';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_type';
    $perm->display_name = 'Manage leave types';
    $perm->category = 'Leave';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_holiday';
    $perm->display_name = 'Manage holidays';
    $perm->category = 'Leave';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'view_leave_report';
    $perm->display_name = 'View reports';
    $perm->category = 'Leave';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_organization';
    $perm->display_name = 'manage organization';
    $perm->category = 'Organization';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_branch';
    $perm->display_name = 'manage branches';
    $perm->category = 'Organization';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_group';
    $perm->display_name = 'manage groups';
    $perm->category = 'Organization';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_organization_settings';
    $perm->display_name = 'manage settings';
    $perm->category = 'Organization';
    $perm->save();



    $perm = new Permission;

    $perm->name = 'manage_user';
    $perm->display_name = 'manage users';
    $perm->category = 'System';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'manage_role';
    $perm->display_name = 'manage roles';
    $perm->category = 'System';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'manage_audit';
    $perm->display_name = 'manage audits';
    $perm->category = 'System';
    $perm->save();



    $perms = Permission::all();

    $pers = array();

    foreach($perms as $p){

        $pers[] = $p->id;
    }

        
    $role = new Role;

    $role->name = 'superadmin';

    $role->save();

    $role->perms()->sync($pers);


         $data = array(
            'username' => 'superadmin',
            'email' => 'superadmin@lixnet.net',
            'password' => 'superadmin',
            'password_confirmation' => 'superadmin',
            'user_type' => 'admin',
            'organization_id' => 1

             );

        $repo = App::make('UserRepository');
        
        $user = $repo->register($data);

        $user->attachRole($role);
            

    
/*
    $perm = new Permission;

    $perm->name = 'view_loan_product';
    $perm->display_name = 'view loan products';
    $perm->category = 'Loanproduct';
    $perm->save();

    $perm = new Permission;

    $perm->name = 'delete_loan_product';
    $perm->display_name = 'delete loan products';
    $perm->category = 'Loanproduct';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'create_loan_account';
    $perm->display_name = 'create loan account';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'view_loan_account';
    $perm->display_name = 'view loan account';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'approve_loan_account';
    $perm->display_name = 'approve loan';
    $perm->category = 'Loanaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'disburse_loan';
    $perm->display_name = 'disburse loan';
    $perm->category = 'Loanaccount';
    $perm->save();



    $perm = new Permission;

    $perm->name = 'view_savings_account';
    $perm->display_name = 'view savings account';
    $perm->category = 'Savingaccount';
    $perm->save();


    $perm = new Permission;

    $perm->name = 'open_saving_account';
    $perm->display_name = 'Open savings account';
    $perm->category = 'Savingaccount';
    $perm->save();

*/

    
	}

}