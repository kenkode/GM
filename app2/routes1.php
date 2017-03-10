<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::resource('users', 'UsersController');
Route::post('users/signup','UsersController@dosignup');
Route::get('/forgot_password', 'UsersController@forgotPassword');
Route::post('users/forgot_password', 'UsersController@doForgotPassword');
Route::get('users/reset_password/{token}', 'UsersController@resetPassword');
Route::post('users/reset_password', 'UsersController@doResetPassword');
Route::get('renewlicense/{id}/{user}', 'UsersController@lis');
Route::get('/signupsummary', 'UsersController@summary');

Route::filter('loggedin', function()
{
    if (!Confide::user())
    {
       $sessionTimeout = 1;
       $organization = Organization::find(1);
       return View::make('login',compact('organization'));
     }
});


Route::get('/', function()
{

    if (!Confide::user())
    {
       $sessionTimeout = 1;
       $organization = Organization::find(1);
       return View::make('login',compact('organization'));
     }

    $count = count(User::all());

    /*if($count <= 1 ){
        return View::make('signup');
    }*/


  if (Confide::user()) {
        
        return Redirect::to('/dashboard');
        } else {
            $organization = Organization::find(1);
            return View::make('login',compact('organization'));   
      }
});

Route::get('/signup', function()
{
        return View::make('signup');
});

Route::get('/upgradelicense', array('before' => 'loggedin', function(){
  
        return View::make('upgradelicense');

}));

Route::get('/dashboard', array('before' => 'loggedin', function(){
  
  if (Confide::user()) {
    $organization = Organization::find(Confide::user()->organization_id);
      if($organization->demo_expiry<date('Y-m-d') && $organization->status ==0){
          
          echo "<script>alert('Your trial period is over! Please purchase full product from lixnet.net')</script>";
          echo "<script>window.location = 'renewlicense?$organization=$organization';</script>";
         // return Redirect::to('users/login')->withDeleteMessage('Registration successful! Login');
        }else{
        if(Confide::user()->user_type == 'admin'){
          
          $employees = Employee::getActiveEmployee();
          $members = Member::where('organization_id',Confide::User()->organization_id)->get();
            //Grab all available loans
            $loanaccounts=Loanaccount::where('organization_id',Confide::User()->organization_id)
            ->get();
            foreach ($loanaccounts as $loanaccount) {
              $period=$loanaccount->period;
              $endpoint=30 *$period;
              $end='+$endpoint';
              //Take member ID
              $id=$loanaccount->member_id;
              //Get all the member details
              $member=Member::where('id','=',$id)->get();
              //Take the repayment period
              $startdate=date('Y-m-d',strtotime($loanaccount->repayment_start_date));   
              for($date=$startdate;$date<date('Y-m-d',strtotime($date."+$endpoint days")); $date=date('Y-m-d',strtotime($date."+28 days"))){ 
                //Reset execution limit
                //set_time_limit(60);                
                //Get current month
                $now=date('Y-m-d');
                $today=date('Y-m-d',strtotime($now));  
                $month=date('m');
                //Get payment date
                $paydate=date('Y-m-d',strtotime($date."+30 days"));
                $defaultdate=date('Y-m-d',strtotime($date."+31 days"));
                //Get Payment month
                $pay_month=date('m',strtotime($paydate));
                //When payment month equals current month send an email
                if($month==$pay_month && $today<=$paydate){
                   Mail::send( 'emails.notification', array('name'=>$member->name,
                  'pay_date'=>date('d-F-Y',strtotime($date."+30 days"))), function( $message ) use ($member){
                       $message->to($member->email )->subject( 'Loan Repayment Notification' );
                      });  
                      break;                   
                  } else if($month==$pay_month && $today==$defaultdate){
                      $loanaccount->is_defaulted=TRUE;
                      $loanaccount->save();
                      $defaultrepay=Loanrepayment::where('loanaccount_id','=',$loanaccount->id)
                      ->where('organization_id',Confide::User()->organization_id)
                      ->get();
                      $defaultrepay->loanaccount_id=$loanaccount->id;
                      $defaultrepay->date->$defaultdate;
                      $defaultrepay->principal_paid=0.00;
                      $defaultrepay->interest_paid=0.00;
                      $defaultrepay->default_period=date('m-Y',strtotime($date."+31 days"));
                      $defaultrepay->save();
                  }
                break;                           
              }
            }

          if($organization->is_payroll_active == 1 && $organization->is_erp_active == 1 && $organization->is_cbs_active == 1){
          return View::make('dashboard', compact('employees','organization'));
          }else if($organization->is_payroll_active == 1 && $organization->is_erp_active == 1){
          return View::make('dashboard1', compact('employees','organization'));
          }else if($organization->is_payroll_active == 1 && $organization->is_cbs_active == 1){
          return View::make('dashboard2', compact('employees','organization'));
          }else if($organization->is_erp_active == 1 && $organization->is_cbs_active == 1){
          return View::make('dashboard3', compact('employees','organization'));
          }else if($organization->is_payroll_active == 1){
          
          return View::make('hrdashboard', compact('employees','organization'));
          
          }else if($organization->is_erp_active == 1){
          return View::make('erpmgmt', compact('organization'));
          }else if($organization->is_cbs_active == 1){
          return View::make('cbsmgmt', compact('members','organization'));
          }else{
          return View::make('dashboard', compact('employees','organization'));
          }

        } 
        

        if(Confide::user()->user_type == 'employee'){

          $employee_id = DB::table('employee')->where('personal_file_number', '=', Confide::user()->username)->pluck('id');
          $employee = Employee::findorfail($employee_id);
           return View::make('empdash', compact('employee','organization'));


        } 

        if(Confide::user()->user_type == 'teller'){
            $members = Member::where('organization_id',Confide::User()->organization_id)->get();
            return View::make('tellers.dashboard', compact('members','organization'));

        } 


        if(Confide::user()->user_type == 'member'){
            $loans = Loanproduct::where('organization_id',Confide::User()->organization_id)->get();
            $member = Member::where('membership_no',Confide::user()->username)->first();
            $products = Product::where('organization_id',Confide::User()->organization_id)->get();

            //$rproducts = Product::getRemoteProducts();            
            return View::make('css.memberindex', compact('loans', 'member', 'products','organization'));

        } 
        }
        } else {
            return View::make('login');
        }
}));
//

Route::get('fpassword', function(){

  return View::make(Config::get('confide::forgot_password_form'));

});

Route::get('hrdashboard', array('before' => 'loggedin', function(){
 
  return View::make('hrdashboard');

}));

Route::get('payrolldashboard', array('before' => 'loggedin', function(){
  
  return View::make('payrolldashboard');

}));


// Confide routes
Route::get('users/login', 'UsersController@login');
Route::post('users/login', 'UsersController@doLogin');

Route::group(['before' => 'loggedin'], function() {
Route::get('users/create', 'UsersController@create');
Route::get('users/edit/{user}', 'UsersController@edit');
Route::post('users/update/{user}', 'UsersController@update');
Route::get('users/add', 'UsersController@add');
Route::post('users/newuser', 'UsersController@newuser');
Route::get('users/confirm/{code}', 'UsersController@confirm');
Route::get('users/logout', 'UsersController@logout');
Route::get('users/activate/{user}', 'UsersController@activate');
Route::get('users/deactivate/{user}', 'UsersController@deactivate');
Route::get('users/destroy/{user}', 'UsersController@destroy');
Route::get('users/password/{user}', 'UsersController@Password');
Route::post('users/password/{user}', 'UsersController@changePassword');
Route::get('users/profile/{user}', 'UsersController@profile');
Route::get('users/show/{user}', 'UsersController@show');

Route::get('tellers', 'UsersController@tellers');
Route::get('tellers/create/{id}', 'UsersController@createteller');
Route::get('tellers/activate/{id}', 'UsersController@activateteller');
Route::get('tellers/deactivate/{id}', 'UsersController@deactivateteller');

Route::get('members/profile', 'UsersController@password2');
Route::post('users/pass', 'UsersController@changePassword2');


Route::post('users/pass', 'UsersController@changePassword2');
});

Route::group(['before' => 'manage_roles'], function() {

Route::resource('roles', 'RolesController');
Route::get('roles/create', 'RolesController@create');
Route::get('roles/edit/{id}', 'RolesController@edit');
Route::post('roles/update/{id}', 'RolesController@update');
Route::get('roles/delete/{id}', 'RolesController@destroy');

});

Route::group(['before' => 'loggedin'], function() {
Route::get('import', function(){

    return View::make('import');
});

Route::get('automated/loans', function(){

    
    $loanproducts = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('autoloans', compact('loanproducts'));
});


Route::post('automated/autoloans', function(){

    $data = Input::all();

    $period = array_get($data, 'period');
    $loanproductid = array_get($data, 'loanproduct_id');

    $loanproduct = Loanproduct::findOrFail($loanproductid);

    //check if loan has been processed



    if(Autoprocess::checkProcessed($period, 'loan', $loanproduct)){

        return Redirect::back()->with('notice', 'This period has already been processed');
    }

    

   

    $pr = explode('-', $period);
    $month = $pr[0];
    $year = $pr[1];
    $day = '21';

    $date = $year.'-'.$month.'-'.$day;

    $loanaccounts = DB::table('loanaccounts')->where('organization_id',Confide::user()->organization_id)->where('loanproduct_id', '=', $loanproductid)->get();

    return View::make('autoloan', compact('loanaccounts', 'date', 'period', 'loanproductid'));

});






Route::get('automated/savings', function(){

    
   $savingproducts = Savingproduct::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('automated', compact('savingproducts'));
});



Route::post('automated/savin', function(){

    $data = Input::all();

    $period = array_get($data, 'period');

    $savingproductid = Input::get('savingproduct');

    $savingproduct = Savingproduct::findOrFail(Input::get('savingproduct'));
    //check if loan has been processed



    if(Autoprocess::checkProcessed($period, 'saving', $savingproduct)){

        return Redirect::back()->with('notice', 'This period has already been processed');
    }



    $pr = explode('-', $period);
    $month = $pr[0];
    $year = $pr[1];
    $day = '21';

    $date = $year.'-'.$month.'-'.$day;

    $members = Member::where('organization_id',Confide::user()->organization_id)->get();

    


    return View::make('savin', compact('members', 'date', 'period', 'savingproductid'));


});


Route::post('automated/savins', function(){

    $savingproduct = Savingproduct::findOrFail(Input::get('savingproduct_id'));

    $period = Input::get('period');

    $members = Input::get('member');
    $dates = Input::get('date');
    $amounts = Input::get('amount');

    
   $i=0;

    foreach($members as $member){

      
       
        $date = $dates[$i];
        $amount = $amounts[$i];

        $savingaccount = Member::getMemberAccount($member);
        $type = 'credit';
        $description = 'savings deposit';
        $transacted_by = Confide::user()->username;

        if(Savingtransaction::trasactionExists($date,$savingaccount) == false){

             Savingtransaction::transact($date, $savingaccount, $amount, $type, $description, $transacted_by);

        }
       

        $i++;


    }

    

    Autoprocess::record($period, 'saving', $savingproduct);

   return Redirect::to('automated/savings')->with('notice', 'saving transactions have been successfully saved');



});





Route::post('automated/autoloan', function(){



    $period = Input::get('period');

    $loanaccounts = Input::get('account');
    $dates = Input::get('date');
    $amounts = Input::get('amount');

    $loanproduct = Loanproduct::findOrFail(Input::get('loanproduct_id'));
   $i=0;

    foreach($loanaccounts as $loanaccount){

      
       
        $date = $dates[$i];
        $amount = $amounts[$i];

        $data = array('loanaccount_id' => $loanaccount, 'date' => $date, 'amount' => $amount );

        if(Loantransaction::trasactionExists($date,$loanaccount) == false){
            
            Loanrepayment::repayLoan($data);

        }
       

        $i++;


    }

    

   Autoprocess::record($period, 'loan', $loanproduct);

   return Redirect::to('automated/loans')->with('notice', 'loan repayment transactions have been successfully processed');



});









Route::post('automated', function(){

    $members = DB::table('members')
    ->where('organization_id',Confide::user()->organization_id)
    ->where('is_active', '=', true)->get();


    $category = Input::get('category');


    
    
    if($category == 'savings'){

        $savingproduct_id = Input::get('savingproduct');

        $savingproduct = Savingproduct::findOrFail($savingproduct_id);

        

            foreach($savingproduct->savingaccounts as $savingaccount){

                if(($savingaccount->member->is_active) && (Savingaccount::getLastAmount($savingaccount) > 0)){

                    
                    $data = array(
                        'account_id' => $savingaccount->id,
                        'amount' => Savingaccount::getLastAmount($savingaccount), 
                        'date' => date('Y-m-d'),
                        'type'=>'credit',
                        'organization_id'=>Confide::user()->organization_id
                        );

                    Savingtransaction::creditAccounts($data);
                    

                    

                }
 
                

            

    }

       Autoprocess::record(date('Y-m-d'), 'saving', $savingproduct); 
      

        

    } else {

        $loanproduct_id = Input::get('loanproduct');

        $loanproduct = Loanproduct::findOrFail($loanproduct_id);


        

        

            foreach($loanproduct->loanaccounts as $loanaccount){

                if(($loanaccount->member->is_active) && (Loanaccount::getEMP($loanaccount) > 0)){

                    
                    
                    $data = array(
                        'loanaccount_id' => $loanaccount->id,
                        'amount' => Loanaccount::getEMP($loanaccount), 
                        'date' => date('Y-m-d'),
                        'organization_id'=>Confide::user()->organization_id
                        );


                    Loanrepayment::repayLoan($data);
                    

                    
                   

                    

                }
            }


             Autoprocess::record(date('Y-m-d'), 'loan', $loanproduct);
            

    }


    

    return Redirect::back()->with('notice', 'successfully processed');
    

    
});

});

Route::group(['before' => 'manage_system'], function() {

Route::get('system', function(){


    $organization = Organization::find(Confide::user()->organization_id);

    return View::make('system.index', compact('organization'));
});

});


Route::group(['before' => 'loggedin'], function() {
Route::get('license', function(){


    $organization = Organization::find(Confide::user()->organization_id);

    return View::make('system.license', compact('organization'));
});

Route::get('transaudits', function(){   
    $transactions = Loantransaction::where('organization_id',Confide::user()->organization_id)
    ->get();

    return View::make('transaud', compact('transactions'));



});


Route::post('transaudits', function(){

    $date = Input::get('date');
    $type = Input::get('type');

    if($type == 'loan'){

        $transactions = DB::table('loantransactions')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('date', '=', $date)->get();
        return View::make('transaudit', compact('transactions', 'type', 'date'));

    }



    if($type == 'savings'){

        $transactions = DB::table('savingtransactions')
        ->where('organization_id',Confide::user()->organization_id)
        ->where('date', '=', $date)->get();
        return View::make('transaudit', compact('transactions', 'type', 'date'));
    }

});

});

/**
* Organization routes
*/

Route::group(['before' => 'manage_organization'], function() {

Route::resource('organizations', 'OrganizationsController');

Route::post('organizations/update/{id}', 'OrganizationsController@update');
Route::post('organizations/logo/{id}', 'OrganizationsController@logo');

});

Route::get('language/{lang}', 
           array(
                  'as' => 'language.select', 
                  'uses' => 'OrganizationsController@language'
                 )
          );


Route::group(['before' => 'loggedin'], function() {
Route::resource('currencies', 'CurrenciesController');
Route::get('currencies/edit/{id}', 'CurrenciesController@edit');
Route::post('currencies/update/{id}', 'CurrenciesController@update');
Route::get('currencies/delete/{id}', 'CurrenciesController@destroy');
Route::get('currencies/create', 'CurrenciesController@create');
});


/*
* branches routes
*/

Route::group(['before' => 'manage_branches'], function() {

Route::resource('branches', 'BranchesController');
Route::post('branches/update/{id}', 'BranchesController@update');
Route::get('branches/delete/{id}', 'BranchesController@destroy');
Route::get('branches/edit/{id}', 'BranchesController@edit');
});

/*
* sites routes
*/

Route::group(['before' => 'manage_sites'], function() {

Route::resource('sites', 'SitesController');
Route::post('sites/update/{id}', 'SitesController@update');
Route::get('sites/delete/{id}', 'SitesController@destroy');
Route::get('sites/edit/{id}', 'SitesController@edit');
});

/*
* groups routes
*/
Route::group(['before' => 'manage_groups'], function() {

Route::resource('groups', 'GroupsController');
Route::post('groups/update/{id}', 'GroupsController@update');
Route::get('groups/delete/{id}', 'GroupsController@destroy');
Route::get('groups/edit/{id}', 'GroupsController@edit');
});

/*
* accounts routes
*/

Route::group(['before' => 'process_payroll'], function() {

Route::resource('accounts', 'AccountsController');
Route::post('accounts/update/{id}', 'AccountsController@update');
Route::get('accounts/delete/{id}', 'AccountsController@destroy');
Route::get('accounts/edit/{id}', 'AccountsController@edit');
Route::get('accounts/show/{id}', 'AccountsController@show');
Route::get('accounts/create/{id}', 'AccountsController@create');

});

/*
* Account routes
*/

Route::group(['before' => 'loggedin'], function() {
Route::resource('account', 'AccountController');
Route::get('account/create', 'AccountController@create');
Route::get('account/edit/{id}', 'AccountController@edit');
Route::post('account/update/{id}', 'AccountController@update');
Route::get('account/delete/{id}', 'AccountController@destroy');

Route::get('account/show/{id}', 'AccountController@show');

Route::get('account/bank', 'AccountController@show');
Route::post('account/bank', 'AccountController@recordbanking');


/*
* journals routes
*/
Route::resource('journals', 'JournalsController');
Route::post('journals/update/{id}', 'JournalsController@update');
Route::get('journals/delete/{id}', 'JournalsController@destroy');
Route::get('journals/edit/{id}', 'JournalsController@edit');
Route::get('journals/show/{id}', 'JournalsController@show');



/*
* license routes
*/

Route::post('license/key', 'OrganizationsController@generate_license_key');
Route::post('license/activate', 'OrganizationsController@activate_license');
Route::get('license/activate/{id}', 'OrganizationsController@activate_license_form');
});
/*
* Audits routes
*/
Route::group(['before' => 'manage_audits'], function() {

Route::resource('audits', 'AuditsController');

});

/*
* backups routes
*/
Route::group(['before' => 'loggedin'], function() {
Route::get('backups', function(){

   
    //$backups = Backup::getRestorationFiles('../app/storage/backup/');

    return View::make('backup');

});


Route::get('backups/create', function(){

    echo '<pre>';

    $instance = Backup::getBackupEngineInstance();

    print_r($instance);

    //Backup::setPath(public_path().'/backups/');

   //Backup::export();
    //$backups = Backup::getRestorationFiles('../app/storage/backup/');

    //return View::make('backup');

});

});





/*
* #####################################################################################################################
*/
Route::group(['before' => 'manage_holiday'], function() {

Route::resource('holidays', 'HolidaysController');
Route::get('holidays/edit/{id}', 'HolidaysController@edit');
Route::get('holidays/delete/{id}', 'HolidaysController@destroy');
Route::post('holidays/update/{id}', 'HolidaysController@update');

});

Route::group(['before' => 'manage_leavetype'], function() {

Route::resource('leavetypes', 'LeavetypesController');
Route::get('leavetypes/edit/{id}', 'LeavetypesController@edit');
Route::get('leavetypes/delete/{id}', 'LeavetypesController@destroy');
Route::post('leavetypes/update/{id}', 'LeavetypesController@update');

});

//Route::get('user', array('before' => 'old', 'uses' => 'UserController@showProfile'));

Route::resource('leaveapplications', 'LeaveapplicationsController');
Route::get('leaveapplications/edit/{id}', 'LeaveapplicationsController@edit');
Route::get('leaveapplications/delete/{id}', 'LeaveapplicationsController@destroy');
Route::post('leaveapplications/update/{id}', 'LeaveapplicationsController@update');
Route::get('leaveapplications/approve/{id}', 'LeaveapplicationsController@approve');
Route::post('leaveapplications/approve/{id}', 'LeaveapplicationsController@doapprove');
Route::get('leaveapplications/cancel', 'LeaveapplicationsController@cancel');
Route::get('leaveapplications/reject/{id}', 'LeaveapplicationsController@reject');
Route::get('leaveapplications/show/{id}', 'LeaveapplicationsController@show');
Route::post('createLeave', 'LeaveapplicationsController@createleave');

Route::get('leaveapplications/approvals', array('before' => 'loggedin', 'uses' => 'LeaveapplicationsController@approvals'));
Route::get('leaveapplications/rejects', 'LeaveapplicationsController@rejects');
Route::get('leaveapplications/cancellations', 'LeaveapplicationsController@cancellations');
Route::get('leaveapplications/amends', 'LeaveapplicationsController@amended');


Route::get('leaveapprovals', array('before' => 'loggedin', function(){

  $leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('leaveapplications.approved', compact('leaveapplications'));

} ));

Route::group(['before' => 'amend_application'], function() {

Route::get('leaveamends', function(){

  $leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('leaveapplications.amended', compact('leaveapplications'));

} );

});

Route::group(['before' => 'reject_application'], function() {

Route::get('leaverejects', function(){

  $leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('leaveapplications.rejected', compact('leaveapplications'));

} );

});

Route::group(['before' => 'manage_settings'], function() {

Route::get('migrate', function(){

    return View::make('migration');

});

});


/*
* Template routes and generators 
*/

Route::group(['before' => 'loggedin'], function() {
Route::get('template/employees', function(){

  $bank_data = Bank::where('organization_id',Confide::user()->organization_id)->get();

  $data = Employee::where('organization_id',Confide::user()->organization_id)->get();

  $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

  $bankbranch_data = BBranch::where('organization_id',Confide::user()->organization_id)->get();
 
  $branch_data = Branch::where('organization_id',Confide::user()->organization_id)->get();

  $department_data = Department::where('organization_id',Confide::user()->organization_id)->get();

  $employeetype_data = EType::where('organization_id',Confide::user()->organization_id)->get();

  $jobgroup_data = Jobgroup::where('organization_id',Confide::user()->organization_id)->get();

  Excel::create('Employees', function($excel) use($bank_data, $bankbranch_data, $branch_data, $department_data, $employeetype_data, $jobgroup_data,$employees, $data) {


    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

    

    $excel->sheet('employees', function($sheet) use($bank_data, $bankbranch_data, $branch_data, $department_data, $employeetype_data, $jobgroup_data, $data, $employees){


              $sheet->row(1, array(
     'EMPLOYMENT NUMBER','FIRST NAME', 'SURNAME', 'OTHER NAMES', 'ID NUMBER', 'KRA PIN', 'NSSF NUMBER', 'NHIF NUMBER','EMAIL ADDRESS','BASIC PAY'
));

             
                $empdata = array();

                foreach($employees as $d){

                  $empdata[] = $d->personal_file_number.':'.$d->first_name.' '.$d->last_name.' '.$d->middle_name;
                }

                $emplist = implode(", ", $empdata);

                

                $listdata = array();

                foreach($data as $d){

                  $listdata[] = $d->allowance_name;
                }

                $list = implode(", ", $listdata);
   

    

                

                
        

    });

  })->export('xls');
});


/*
*allowance template
*
*/

Route::get('template/allowances', function(){

  $data = Allowance::where('organization_id',Confide::user()->organization_id)->get();
  $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();


  Excel::create('Allowances', function($excel) use($data, $employees) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

    

    $excel->sheet('allowances', function($sheet) use($data, $employees){


              $sheet->row(1, array(
              'EMPLOYEE', 'ALLOWANCE TYPE', 'FORMULAR', 'INSTALMENTS','AMOUNT','ALLOWANCE DATE',
              ));

              $sheet->setWidth(array(
                    'A'     =>  30,
                    'B'     =>  30,
                    'C'     =>  30,
                    'D'     =>  30,
                    'E'     =>  30,
                    'F'     =>  30,
              ));

             $sheet->getStyle('F2:F1000')
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');



                $row = 2;
                $r = 2;
            
            for($i = 0; $i<count($employees); $i++){
            
             $sheet->SetCellValue("YY".$row, $employees[$i]->personal_file_number." : ".$employees[$i]->first_name.' '.$employees[$i]->last_name);
             $row++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'names', $sheet, 'YY2:YY'.(count($employees)+1)
                        )
                );

                

               for($i = 0; $i<count($data); $i++){
            
             $sheet->SetCellValue("YZ".$r, $data[$i]->allowance_name);
             $r++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'allowances', $sheet, 'YZ2:YZ'.(count($data)+1)
                        )
                );
   

    for($i=2; $i <= 1000; $i++){

                $objValidation = $sheet->getCell('B'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('allowances'); //note this!

                $objValidation = $sheet->getCell('A'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('names'); //note this!

                $objValidation = $sheet->getCell('C'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('"One Time, Recurring, Instalments"'); //note this!
                }

    });

  })->export('xlsx');



});

/*
*earning template
*
*/


Route::get('template/earnings', function(){
   $data = Employee::where('organization_id',Confide::user()->organization_id)->get();

 \Excel::create('Earnings', function($excel) use($data) {
            require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
            require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

              

              $excel->sheet('Earnings', function($sheet) use($data) {

              $sheet->row(1, array(
             'EMPLOYEE', 'EARNING TYPE','NARRATIVE', 'FORMULAR', 'INSTALMENTS','AMOUNT','EARNING DATE',
              ));

              $sheet->setWidth(array(
                    'A'     =>  30,
                    'B'     =>  30,
                    'C'     =>  30,
                    'D'     =>  30,
                    'E'     =>  30,
                    'F'     =>  30,
                    'G'     =>  30,
              ));

             $sheet->getStyle('G2:G1000')
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

            $row = 2;
            
            for($i = 0; $i<count($data); $i++){
            
             $sheet->SetCellValue("ZZ".$row, $data[$i]->personal_file_number." : ".$data[$i]->first_name.' '.$data[$i]->last_name);
             $row++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'names', $sheet, 'ZZ2:ZZ'.(count($data)+1)
                        )
                );

                $objPHPExcel = new PHPExcel;
                $objSheet = $objPHPExcel->getActiveSheet();

               $objSheet->protectCells('ZZ2:ZZ'.(count($data)+1), 'PHP');

                $objSheet->getStyle('G2:G1000')->getNumberFormat()->setFormatCode('yyyy-mm-dd');


                for($i=2; $i <= 1000; $i++){

                $objValidation = $sheet->getCell('A'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('names'); //note this!

                $objValidation = $sheet->getCell('B'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('"Bonus, Commission, Others"'); //note this!

                $objValidation = $sheet->getCell('D'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('"One Time, Recurring, Instalments"'); //note this!
                }
            });

            

        })->download("xlsx");

});
/*
*Relief template
*
*/

Route::get('template/reliefs', function(){

  $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
  
  $data = Relief::where('organization_id',Confide::user()->organization_id)->get();

  Excel::create('Reliefs', function($excel) use($employees, $data) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

    

    $excel->sheet('reliefs', function($sheet) use($employees, $data){


              $sheet->row(1, array(
     'EMPLOYEE', 'RELIEF TYPE', 'AMOUNT'
));

             
                $sheet->setWidth(array(
                    'A'     =>  30,
                    'B'     =>  30,
                    'C'     =>  30,
              ));



                $row = 2;
                $r = 2;
            
            for($i = 0; $i<count($employees); $i++){
            
             $sheet->SetCellValue("YY".$row, $employees[$i]->personal_file_number." : ".$employees[$i]->first_name.' '.$employees[$i]->last_name);
             $row++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'names', $sheet, 'YY2:YY'.(count($employees)+1)
                        )
                );

                

               for($i = 0; $i<count($data); $i++){
            
             $sheet->SetCellValue("YZ".$r, $data[$i]->relief_name);
             $r++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'reliefs', $sheet, 'YZ2:YZ'.(count($data)+1)
                        )
                );
   

    for($i=2; $i <= 1000; $i++){

                $objValidation = $sheet->getCell('B'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('reliefs'); //note this!



                $objValidation = $sheet->getCell('A'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('names'); //note this!

    }

                

                
        

    });

  })->export('xlsx');



});



/*
*deduction template
*
*/

Route::get('template/deductions', function(){

  $data = Deduction::where('organization_id',Confide::user()->organization_id)->get();
  $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();


  Excel::create('Deductions', function($excel) use($data, $employees) {

    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/NamedRange.php");
    require_once(base_path()."/vendor/phpoffice/phpexcel/Classes/PHPExcel/Cell/DataValidation.php");

    

    $excel->sheet('deductions', function($sheet) use($data, $employees){


              $sheet->row(1, array(
     'EMPLOYEE', 'DEDUCTION TYPE', 'FORMULAR','INSTALMENTS','AMOUNT','DATE'
));

             
               $sheet->setWidth(array(
                    'A'     =>  30,
                    'B'     =>  30,
                    'C'     =>  30,
                    'D'     =>  30,
                    'E'     =>  30,
                    'F'     =>  30,
              ));

             $sheet->getStyle('F2:F1000')
            ->getNumberFormat()
            ->setFormatCode('yyyy-mm-dd');

            $row = 2;
                $r = 2;
            
            for($i = 0; $i<count($employees); $i++){
            
             $sheet->SetCellValue("YY".$row, $employees[$i]->personal_file_number." : ".$employees[$i]->first_name.' '.$employees[$i]->last_name);
             $row++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'names', $sheet, 'YY2:YY'.(count($employees)+1)
                        )
                );

                

               for($i = 0; $i<count($data); $i++){
            
             $sheet->SetCellValue("YZ".$r, $data[$i]->deduction_name);
             $r++;
            }  

                $sheet->_parent->addNamedRange(
                        new \PHPExcel_NamedRange(
                        'deductions', $sheet, 'YZ2:YZ'.(count($data)+1)
                        )
                );
   

    for($i=2; $i <= 1000; $i++){

                $objValidation = $sheet->getCell('B'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('deductions'); //note this!



                $objValidation = $sheet->getCell('A'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('names'); //note this!

                $objValidation = $sheet->getCell('C'.$i)->getDataValidation();
                $objValidation->setType(\PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(\PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1('"One Time, Recurring, Instalments"');

    }

                

                
        

    });

  })->export('xlsx');



});



/* #################### IMPORT EMPLOYEES ################################## */

Route::post('import/employees', function(){

  
  if(Input::hasFile('employees')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('employees')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('employees')->move($destination, $file);


  


    Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

          $results = $reader->get();
          $organization = Organization::find(Confide::user()->organization_id); 

          $cres = count($results); 
          $cemp = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->count();   
          $limit = $organization->payroll_licensed;


          if($limit<$cres){
           return Redirect::route('migrate')->withDeleteMessage('The imported employees exceed the licensed limit! Please upgrade your license');
          } else if($limit<($cres+$cemp)){
             return Redirect::route('migrate')->withDeleteMessage('The imported employees exceed the licensed limit! Please upgrade your license');
          }else{
  
    foreach ($results as $result) {

      $employee = new Employee;

      $employee->personal_file_number = $result->employment_number;
      
      $employee->first_name = $result->first_name;
      $employee->last_name = $result->surname;
      $employee->middle_name = $result->other_names;
      $employee->identity_number = $result->id_number;
      $employee->pin = $result->kra_pin;
      $employee->social_security_number = $result->nssf_number;
      $employee->hospital_insurance_number = $result->nhif_number;
      $employee->email_office = $result->email_address;
      $employee->basic_pay = str_replace( ',', '', $result->basic_pay);
      $employee->organization_id = Confide::user()->organization_id;
      $employee->save();
      
    }  
    }  

  });
   
  }



  return Redirect::back()->with('notice', 'Employees have been succeffully imported');



  

});




/* #################### IMPORT EARNINGS ################################## */

Route::post('import/earnings', function(){

  
  if(Input::hasFile('earnings')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('earnings')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;

     
      Input::file('earnings')->move($destination, $file);


    Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

          $results = $reader->get();   
        
  
    foreach ($results as $result) {

      if($result->employee != null){


         $name = explode(' : ', $result->employee);

          
    
    $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', $name[0])->pluck('id');

         
    $earning = new Earnings;

    $earning->employee_id = $employeeid;

    $earning->earnings_name = $result->earning_type;

    $earning->narrative = $result->narrative;

    $earning->formular = $result->formular;

     

     if($result->formular == 'Instalments'){
        $earning->instalments = $result->instalments;
        $insts = $result->instalments;

        $a = str_replace( ',', '',$result->amount);
        $earning->earnings_amount = $a;

        $earning->earning_date = $result->earning_date;

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($result->earning_date)));

        $First  = date('Y-m-01', strtotime($result->earning_date));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $earning->first_day_month = $First;

        $earning->last_day_month = $Last;

      }else{
      $earning->instalments = '1';
        $a = str_replace( ',', '', $result->amount );
        $earning->earnings_amount = $a;

        $earning->earning_date = $result->earning_date;

        $First  = date('Y-m-01', strtotime($result->earning_date));
        $Last   = date('Y-m-t', strtotime($result->earning_date));
        

        $earning->first_day_month = $First;

        $earning->last_day_month = $Last;

      }


    $earning->save();


      }

   

  
    }
    

  });



      
    }



 return Redirect::back()->with('notice', 'earnings have been successfully imported');





  

});


/* #################### IMPORT RELIEFS ################################## */

Route::post('import/reliefs', function(){

  
  if(Input::hasFile('reliefs')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('reliefs')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;

     
      Input::file('reliefs')->move($destination, $file);


    Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

          $results = $reader->get();    
  
    foreach ($results as $result) {
       if($result->employee != null){

    $name = explode(':', $result->employee);

    
    $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', $name[0])->pluck('id');

    $reliefid = DB::table('relief')->where('relief_name', '=', $result->relief_type)->pluck('id');

    $relief = new ERelief;

    $relief->employee_id = $employeeid;

    $relief->relief_id = $reliefid;

    $relief->relief_amount = $result->amount;

    $relief->save();
      
    }
    
   }
    

  });



      
    }



  return Redirect::back()->with('notice', 'reliefs have been succeffully imported');



  

});



/* #################### IMPORT ALLOWANCES ################################## */

Route::post('import/allowances', function(){

  
  if(Input::hasFile('allowances')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('allowances')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('allowances')->move($destination, $file);


  


  Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

    $results = $reader->get();    
  
    foreach ($results as $result) {

      if($result->employee != null){

    $name = explode(':', $result->employee);
    
    $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', $name[0])->pluck('id');

    $allowanceid = DB::table('allowances')->where('allowance_name', '=', $result->allowance_type)->pluck('id');

    $allowance = new EAllowances;

    $allowance->employee_id = $employeeid;

    $allowance->allowance_id = $allowanceid;

    $allowance->formular = $result->formular;

     

     if($result->formular == 'Instalments'){
        $allowance->instalments = $result->instalments;
        $insts = $result->instalments;

        $a = str_replace( ',', '',$result->amount);
        $allowance->allowance_amount = $a;

        $allowance->allowance_date = $result->allowance_date;

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($result->allowance_date)));

        $First  = date('Y-m-01', strtotime($result->allowance_date));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

      }else{
      $allowance->instalments = '1';
        $a = str_replace( ',', '', $result->amount );
        $allowance->allowance_amount = $a;

        $allowance->allowance_date = $result->allowance_date;

        $First  = date('Y-m-01', strtotime($result->allowance_date));
        $Last   = date('Y-m-t', strtotime($result->allowance_date));
        

        $allowance->first_day_month = $First;

        $allowance->last_day_month = $Last;

      }

    $allowance->save();

    }
      
    }
    

    

  });



      
    }



  return Redirect::back()->with('notice', 'allowances have been succefully imported');



  

});


/* #################### IMPORT DEDUCTIONS ################################## */

Route::post('import/deductions', function(){

  
  if(Input::hasFile('deductions')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('deductions')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('deductions')->move($destination, $file);


  


  Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

    $results = $reader->get();    
  
    foreach ($results as $result) {

      if($result->employee != null){


    $name = explode(':', $result->employee);
    
    $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', $name[0])->pluck('id');

    $deductionid = DB::table('deductions')->where('deduction_name', '=', $result->deduction_type)->pluck('id');

    $deduction = new EDeduction;

    $deduction->employee_id = $employeeid;

    $deduction->deduction_id = $deductionid;

    $deduction->formular = $result->formular;

     $a = str_replace( ',', '', $result->amount );
        $deduction->deduction_amount = $a;

    $deduction->deduction_date = $result->date;

    if($result->formular == 'Instalments'){
    $deduction->instalments = $result->instalments;
        $insts = $result->instalments;

        $effectiveDate = date('Y-m-d', strtotime("+".($insts-1)." months", strtotime($result->date)));

        $First  = date('Y-m-01', strtotime($result->date));
        $Last   = date('Y-m-t', strtotime($effectiveDate));

        $deduction->first_day_month = $First;

        $deduction->last_day_month = $Last;

      }else{
      $deduction->instalments = '1';

        $First  = date('Y-m-01', strtotime($result->date));
        $Last   = date('Y-m-t', strtotime($result->date));
        

        $deduction->first_day_month = $First;

        $deduction->last_day_month = $Last;

      }

    $deduction->save();

    }
      
    }
    

  });
      
    }

  return Redirect::back()->with('notice', 'deductions have been succefully imported');
  

});



/* #################### IMPORT BANK BRANCHES ################################## */

Route::post('import/bankBranches', function(){

  
  if(Input::hasFile('bbranches')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('bbranches')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('bbranches')->move($destination, $file);


  


  Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

    $results = $reader->get();    
  
    foreach ($results as $result) {
  

    $bbranch = new BBranch;

    $bbranch->branch_code = $result->branch_code;

    $bbranch->bank_branch_name = $result->branch_name;

    $bbranch->bank_id = $result->bank_id;

    $bbranch->organization_id = $result->organization_id;

    $bbranch->save();
      
    }   

  });
      
    }


  return Redirect::back()->with('notice', 'bank branches have been succefully imported');



  

});

/* #################### IMPORT BANKS ################################## */

Route::post('import/banks', function(){

  
  if(Input::hasFile('banks')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('banks')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('banks')->move($destination, $file);


  


  Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

    $results = $reader->get();    
  
    foreach ($results as $result) {
    $bank = new Bank;

    $bank->bank_name = $result->bank_name;

    $bank->bank_code = $result->bank_code;

    $bank->organization_id = $result->organization_id;

    $bank->save();
      
    }   

  });
      
    }


  return Redirect::back()->with('notice', 'banks have been succefully imported');



  

});

});

/*
* #####################################################################################################################
*/
/*
* banks routes
*/
Route::group(['before' => 'loggedin'], function() {
Route::resource('banks', 'BanksController');
Route::post('banks/update/{id}', 'BanksController@update');
Route::get('banks/delete/{id}', 'BanksController@destroy');
Route::get('banks/edit/{id}', 'BanksController@edit');

/*
* departments routes
*/

Route::resource('departments', 'DepartmentsController');
Route::post('departments/update/{id}', 'DepartmentsController@update');
Route::get('departments/delete/{id}', 'DepartmentsController@destroy');
Route::get('departments/edit/{id}', 'DepartmentsController@edit');


/*
* bank branch routes
*/

Route::resource('bank_branch', 'BankBranchController');
Route::post('bank_branch/update/{id}', 'BankBranchController@update');
Route::get('bank_branch/delete/{id}', 'BankBranchController@destroy');
Route::get('bank_branch/edit/{id}', 'BankBranchController@edit');

/*
* allowances routes
*/

Route::resource('allowances', 'AllowancesController');
Route::post('allowances/update/{id}', 'AllowancesController@update');
Route::get('allowances/delete/{id}', 'AllowancesController@destroy');
Route::get('allowances/edit/{id}', 'AllowancesController@edit');

/*
* earningsettings routes
*/

Route::resource('earningsettings', 'EarningsettingsController');
Route::post('earningsettings/update/{id}', 'EarningsettingsController@update');
Route::get('earningsettings/delete/{id}', 'EarningsettingsController@destroy');
Route::get('earningsettings/edit/{id}', 'EarningsettingsController@edit');

/*
* benefits setting routes
*/

Route::resource('benefitsettings', 'BenefitSettingsController');
Route::post('benefitsettings/update/{id}', 'BenefitSettingsController@update');
Route::get('benefitsettings/delete/{id}', 'BenefitSettingsController@destroy');
Route::get('benefitsettings/edit/{id}', 'BenefitSettingsController@edit');

/*
* reliefs routes
*/

Route::resource('reliefs', 'ReliefsController');
Route::post('reliefs/update/{id}', 'ReliefsController@update');
Route::get('reliefs/delete/{id}', 'ReliefsController@destroy');
Route::get('reliefs/edit/{id}', 'ReliefsController@edit');

/*
* deductions routes
*/

Route::resource('deductions', 'DeductionsController');
Route::post('deductions/update/{id}', 'DeductionsController@update');
Route::get('deductions/delete/{id}', 'DeductionsController@destroy');
Route::get('deductions/edit/{id}', 'DeductionsController@edit');

/*
* nontaxables routes
*/

Route::resource('nontaxables', 'NonTaxablesController');
Route::post('nontaxables/update/{id}', 'NonTaxablesController@update');
Route::get('nontaxables/delete/{id}', 'NonTaxablesController@destroy');
Route::get('nontaxables/edit/{id}', 'NonTaxablesController@edit');

/*
* nssf routes
*/

Route::resource('nssf', 'NssfController');
Route::post('nssf/update/{id}', 'NssfController@update');
Route::get('nssf/delete/{id}', 'NssfController@destroy');
Route::get('nssf/edit/{id}', 'NssfController@edit');

/*
* nhif routes
*/

Route::resource('nhif', 'NhifController');
Route::post('nhif/update/{id}', 'NhifController@update');
Route::get('nhif/delete/{id}', 'NhifController@destroy');
Route::get('nhif/edit/{id}', 'NhifController@edit');

/*
* job group routes
*/

Route::resource('job_group', 'JobGroupController');
Route::post('job_group/update/{id}', 'JobGroupController@update');
Route::get('job_group/delete/{id}', 'JobGroupController@destroy');
Route::get('job_group/edit/{id}', 'JobGroupController@edit');
Route::get('job_group/show/{id}', 'JobGroupController@show');

/*
* employee type routes
*/

Route::resource('employee_type', 'EmployeeTypeController');
Route::post('employee_type/update/{id}', 'EmployeeTypeController@update');
Route::get('employee_type/delete/{id}', 'EmployeeTypeController@destroy');
Route::get('employee_type/edit/{id}', 'EmployeeTypeController@edit');

/*
* occurence settings routes
*/

Route::resource('occurencesettings', 'OccurencesettingsController');
Route::post('occurencesettings/update/{id}', 'OccurencesettingsController@update');
Route::get('occurencesettings/delete/{id}', 'OccurencesettingsController@destroy');
Route::get('occurencesettings/edit/{id}', 'OccurencesettingsController@edit');

/*
* citizenship routes
*/

Route::resource('citizenships', 'CitizenshipController');
Route::post('citizenships/update/{id}', 'CitizenshipController@update');
Route::get('citizenships/delete/{id}', 'CitizenshipController@destroy');
Route::get('citizenships/edit/{id}', 'CitizenshipController@edit');

/*
* employees routes
*/

Route::get('deactives', function(){

  $employees = Employee::getDeactiveEmployee();

  return View::make('employees.activate', compact('employees'));

} );
});
Route::group(['before' => 'loggedin'], function() {
  //dd(Confide::user());
Route::resource('employees', 'EmployeesController');
Route::post('employees/update/{id}', 'EmployeesController@update');
Route::get('employees/deactivate/{id}', 'EmployeesController@deactivate');
Route::get('employees/activate/{id}', 'EmployeesController@activate');
Route::get('employees/edit/{id}', 'EmployeesController@edit');
Route::get('employees/view/{id}', 'EmployeesController@view');
Route::get('employees/viewdeactive/{id}', 'EmployeesController@viewdeactive');

Route::post('createCitizenship', 'EmployeesController@createcitizenship');
Route::post('createEducation', 'EmployeesController@createeducation');
Route::post('createBank', 'EmployeesController@createbank');
Route::post('createBankBranch', 'EmployeesController@createbankbranch');
Route::post('createBranch', 'EmployeesController@createbranch');
Route::post('createDepartment', 'EmployeesController@createdepartment');
Route::post('createType', 'EmployeesController@createtype');
Route::post('createGroup', 'EmployeesController@creategroup');
Route::post('createEmployee', 'EmployeesController@serializeDoc');
Route::get('employeeIndex', 'EmployeesController@getIndex');

Route::get('EmployeeForm', function(){

  $organization = Organization::find(Confide::user()->organization_id);

  $pdf = PDF::loadView('pdf.employee_form', compact('organization'))->setPaper('a4')->setOrientation('potrait');
    
  return $pdf->stream('Employee_Form.pdf');

});
});

/*
* occurences routes
*/
Route::group(['before' => 'loggedin'], function() {
Route::resource('occurences', 'OccurencesController');
Route::post('occurences/update/{id}', 'OccurencesController@update');
Route::get('occurences/delete/{id}', 'OccurencesController@destroy');
Route::get('occurences/edit/{id}', 'OccurencesController@edit');
Route::get('occurences/view/{id}', 'OccurencesController@view');
Route::get('occurences/download/{id}', 'OccurencesController@getDownload');
Route::post('createOccurence', 'OccurencesController@createoccurence');
/*
* employee earnings routes
*/

Route::resource('other_earnings', 'EarningsController');
Route::post('other_earnings/update/{id}', 'EarningsController@update');
Route::get('other_earnings/delete/{id}', 'EarningsController@destroy');
Route::get('other_earnings/edit/{id}', 'EarningsController@edit');
Route::get('other_earnings/view/{id}', 'EarningsController@view');
Route::post('createEarning', 'EarningsController@createearning');

/*
* employee reliefs routes
*/

Route::resource('employee_relief', 'EmployeeReliefController');
Route::post('employee_relief/update/{id}', 'EmployeeReliefController@update');
Route::get('employee_relief/delete/{id}', 'EmployeeReliefController@destroy');
Route::get('employee_relief/edit/{id}', 'EmployeeReliefController@edit');
Route::get('employee_relief/view/{id}', 'EmployeeReliefController@view');
Route::post('createRelief', 'EmployeeReliefController@createrelief');

/*
* employee allowances routes
*/

Route::resource('employee_allowances', 'EmployeeAllowancesController');
Route::post('employee_allowances/update/{id}', 'EmployeeAllowancesController@update');
Route::get('employee_allowances/delete/{id}', 'EmployeeAllowancesController@destroy');
Route::get('employee_allowances/edit/{id}', 'EmployeeAllowancesController@edit');
Route::get('employee_allowances/view/{id}', 'EmployeeAllowancesController@view');
Route::post('createAllowance', 'EmployeeAllowancesController@createallowance');
Route::post('reloaddata', 'EmployeeAllowancesController@display');

/*
* employee nontaxables routes
*/

Route::resource('employeenontaxables', 'EmployeeNonTaxableController');
Route::post('employeenontaxables/update/{id}', 'EmployeeNonTaxableController@update');
Route::get('employeenontaxables/delete/{id}', 'EmployeeNonTaxableController@destroy');
Route::get('employeenontaxables/edit/{id}', 'EmployeeNonTaxableController@edit');
Route::get('employeenontaxables/view/{id}', 'EmployeeNonTaxableController@view');
Route::post('createNontaxable', 'EmployeeNonTaxableController@createnontaxable');

/*
* employee deductions routes
*/

Route::resource('employee_deductions', 'EmployeeDeductionsController');
Route::post('employee_deductions/update/{id}', 'EmployeeDeductionsController@update');
Route::get('employee_deductions/delete/{id}', 'EmployeeDeductionsController@destroy');
Route::get('employee_deductions/edit/{id}', 'EmployeeDeductionsController@edit');
Route::get('employee_deductions/view/{id}', 'EmployeeDeductionsController@view');
Route::post('createDeduction', 'EmployeeDeductionsController@creatededuction');
/*
* payroll routes
*/


Route::resource('payroll', 'PayrollController');
Route::post('deleterow', 'PayrollController@del_exist');
Route::post('showrecord', 'PayrollController@display');
Route::post('shownet', 'PayrollController@disp');
Route::post('showgross', 'PayrollController@dispgross');
Route::post('payroll/preview', 'PayrollController@create');
Route::get('payrollpreviewprint/{period}', 'PayrollController@previewprint');
Route::post('createNewAccount', 'PayrollController@createaccount');

Route::get('payrollcalculator', function(){
  $currency = Currency::find(1);
  return View::make('payroll.payroll_calculator',compact('currency'));

});

/*
* advance routes
*/


Route::resource('advance', 'AdvanceController');
Route::post('deleteadvance', 'AdvanceController@del_exist');
Route::post('advance/preview', 'AdvanceController@create');
Route::post('createAccount', 'AdvanceController@createaccount');
});
/*
* employees routes
*/
Route::group(['before' => 'loggedin'], function() {
Route::resource('employees', 'EmployeesController');
Route::get('employees/show/{id}', 'EmployeesController@show');
Route::group(['before' => 'create_employee'], function() {
Route::get('employees/create', 'EmployeesController@create');
});
Route::get('employees/edit/{id}', 'EmployeesController@edit');
Route::post('employees/update/{id}', 'EmployeesController@update');
Route::get('employees/delete/{id}', 'EmployeesController@destroy');
});

Route::group(['before' => 'loggedin'], function() {
Route::get('advanceReports', function(){

    return View::make('employees.advancereports');
});


Route::get('payrollReports', function(){

    return View::make('employees.payrollreports');
});

Route::get('statutoryReports', function(){

    return View::make('employees.statutoryreports');
});

Route::get('payrollReports/selectYear', function(){
    $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();
    return View::make('pdf.p9Select',compact('employees'));
});

Route::get('email/payslip', 'payslipEmailController@index');
Route::post('email/payslip/employees', 'payslipEmailController@sendEmail');



Route::get('reports/employees', array('before' => 'loggedin', function(){
    
    return View::make('reports');
}));


Route::get('reports/selectEmployeeStatus', 'ReportsController@selstate');
Route::post('reports/employeelist', 'ReportsController@employees');
Route::get('employee/select', 'ReportsController@emp_id');
Route::post('reports/employee', 'ReportsController@individual');
Route::get('payrollReports/selectPeriod', 'ReportsController@period_payslip');
Route::post('payrollReports/payslip', 'ReportsController@payslip');
Route::get('payrollReports/selectAllowance', 'ReportsController@employee_allowances');
Route::post('payrollReports/allowances', 'ReportsController@allowances');
Route::get('payrollReports/selectEarning', 'ReportsController@employee_earnings');
Route::post('payrollReports/earnings', 'ReportsController@earnings');
Route::get('payrollReports/selectOvertime', 'ReportsController@employee_overtimes');
Route::post('payrollReports/overtimes', 'ReportsController@overtimes');
Route::get('payrollReports/selectRelief', 'ReportsController@employee_reliefs');
Route::post('payrollReports/reliefs', 'ReportsController@reliefs');
Route::get('payrollReports/selectDeduction', 'ReportsController@employee_deductions');
Route::post('payrollReports/deductions', 'ReportsController@deductions');
Route::get('payrollReports/selectnontaxableincome', 'ReportsController@employeenontaxableselect');
Route::post('payrollReports/nontaxables', 'ReportsController@employeenontaxables');
Route::get('payrollReports/selectPayePeriod', 'ReportsController@period_paye');
Route::post('payrollReports/payeReturns', 'ReportsController@payeReturns');
Route::post('payrollReports/p9form', 'ReportsController@p9form');
Route::get('payrollReports/selectRemittancePeriod', 'ReportsController@period_rem');
Route::post('payrollReports/payRemittances', 'ReportsController@payeRems');
Route::get('payrollReports/selectSummaryPeriod', 'ReportsController@period_summary');
Route::post('payrollReports/payrollSummary', 'ReportsController@paySummary');
Route::get('payrollReports/selectNssfPeriod', 'ReportsController@period_nssf');
Route::post('payrollReports/nssfReturns', 'ReportsController@nssfReturns');
Route::get('payrollReports/selectNhifPeriod', 'ReportsController@period_nhif');
Route::post('payrollReports/nhifReturns', 'ReportsController@nhifReturns');
Route::get('payrollReports/selectNssfExcelPeriod', 'ReportsController@period_excel');
Route::post('payrollReports/nssfExcel', 'ReportsController@export');
Route::get('reports/selectEmployeeOccurence', 'ReportsController@selEmp');
Route::post('reports/occurence', 'ReportsController@occurence');
Route::get('reports/CompanyProperty/selectPeriod', 'ReportsController@propertyperiod');
Route::post('reports/companyproperty', 'ReportsController@property');
Route::get('reports/Appraisals/selectPeriod', 'ReportsController@appraisalperiod');
Route::post('reports/appraisal', 'ReportsController@appraisal');
Route::get('reports/nextofkin/selectEmployee', 'ReportsController@selempkin');
Route::post('reports/EmployeeKin', 'ReportsController@nextkin');
Route::get('advanceReports/selectRemittancePeriod', 'ReportsController@period_advrem');
Route::post('advanceReports/advanceRemittances', 'ReportsController@payeAdvRems');
Route::get('advanceReports/selectSummaryPeriod', 'ReportsController@period_advsummary');
Route::post('advanceReports/advanceSummary', 'ReportsController@payAdvSummary');


});
/*
*#################################################################
*/
Route::group(['before' => 'process_payroll'], function() {

    


Route::get('payrollmgmt', function(){

     $employees = Employee::getActiveEmployee();

  return View::make('payrollmgmt', compact('employees'));

});

});

Route::group(['before' => 'leave_mgmt'], function() {

Route::get('leavemgmt', function(){
 
  $leaveapplications = Leaveapplication::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('leavemgmt', compact('leaveapplications'));

});

});


Route::get('erpmgmt', array('before' => 'loggedin', function(){

  return View::make('erpmgmt');

}));



Route::get('cbsmgmt', array('before' => 'loggedin', function(){

      if(Confide::user()->user_type == 'admin'){

            $members = Member::where('organization_id',Confide::user()->organization_id)->get();

            //print_r($members);

            return View::make('cbsmgmt', compact('members'));

        } 

        if(Confide::user()->user_type == 'teller'){

            $members = Member::where('organization_id',Confide::user()->organization_id)->get();

            return View::make('tellers.dashboard', compact('members'));

        } 


        if(Confide::user()->user_type == 'member'){

            $loans = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();
            $products = Product::where('organization_id',Confide::user()->organization_id)->get();

            $rproducts = Product::getRemoteProducts();

            
            return View::make('shop.index', compact('loans', 'products', 'rproducts'));

        } 

         
  



}));





/*
* #####################################################################################################################
*/








Route::group(['before' => 'loggedin'], function() {
Route::get('import', function(){

    return View::make('import');
});


Route::get('automated/loans', function(){

    
    $loanproducts = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('autoloans', compact('loanproducts'));
});

Route::get('automated/savings', function(){

    
   $savingproducts = Savingproduct::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('automated', compact('savingproducts'));
});



Route::post('automated', function(){

    $members = DB::table('members')
    ->where('organization_id',Confide::user()->organization_id)
    ->where('is_active', '=', true)->get();
    $category = Input::get('category');


    
    
    if($category == 'savings'){

        $savingproduct_id = Input::get('savingproduct');

        $savingproduct = Savingproduct::findOrFail($savingproduct_id);

        

            foreach($savingproduct->savingaccounts as $savingaccount){

                if(($savingaccount->member->is_active) && (Savingaccount::getLastAmount($savingaccount) > 0)){

                    
                    $data = array(
                        'account_id' => $savingaccount->id,
                        'amount' => Savingaccount::getLastAmount($savingaccount), 
                        'date' => date('Y-m-d'),
                        'type'=>'credit',
                        'organization_id'=>Confide::user()->organization_id
                        );

                    Savingtransaction::creditAccounts($data);
                    

                    

                }
 
                

            

    }

       Autoprocess::record(date('Y-m-d'), 'saving', $savingproduct); 
      

        

    } else {

        $loanproduct_id = Input::get('loanproduct');

        $loanproduct = Loanproduct::findOrFail($loanproduct_id);

            foreach($loanproduct->loanaccounts as $loanaccount){
                if(($loanaccount->member->is_active) && (Loanaccount::getEMP($loanaccount) > 0)){

                    $data = array(
                        'loanaccount_id' => $loanaccount->id,
                        'amount' => Loanaccount::getEMP($loanaccount), 
                        'date' => date('Y-m-d'),
                        'organization_id'=>Confide::user()->organization_id
                        );
                    Loanrepayment::repayLoan($data);                    

                }
            }


             Autoprocess::record(date('Y-m-d'), 'loan', $loanproduct);
            

    }


    

    return Redirect::back()->with('notice', 'successfully processed');
    

    
});






Route::get('loanrepayments/offprint/{id}', 'LoanrepaymentsController@offprint');



Route::resource('members', 'MembersController');
Route::post('members/update/{id}', 'MembersController@update');
Route::post('member/update/{id}', 'MembersController@update');
Route::get('members/delete/{id}', 'MembersController@destroy');
Route::get('members/edit/{id}', 'MembersController@edit');
Route::get('member/edit/{id}', 'MembersController@edit');
Route::get('members/show/{id}', 'MembersController@show');
Route::get('member/show/{id}', 'MembersController@show');
Route::post('deldoc', 'MembersController@deletedoc');
Route::get('members/loanaccounts/{id}', 'MembersController@loanaccounts');
Route::get('memberloans', 'MembersController@loanaccounts2');
Route::group(['before' => 'limit'], function() {

    Route::get('members/create', 'MembersController@create');
});

Route::resource('kins', 'KinsController');
Route::post('kins/update/{id}', 'KinsController@update');
Route::get('kins/delete/{id}', 'KinsController@destroy');
Route::get('kins/edit/{id}', 'KinsController@edit');
Route::get('kins/show/{id}', 'KinsController@show');
Route::get('kins/create/{id}', 'KinsController@create');





Route::resource('charges', 'ChargesController');
Route::post('charges/update/{id}', 'ChargesController@update');
Route::get('charges/delete/{id}', 'ChargesController@destroy');
Route::get('charges/edit/{id}', 'ChargesController@edit');
Route::get('charges/show/{id}', 'ChargesController@show');
Route::get('charges/disable/{id}', 'ChargesController@disable');
Route::get('charges/enable/{id}', 'ChargesController@enable');

Route::resource('savingproducts', 'SavingproductsController');
Route::post('savingproducts/update/{id}', 'SavingproductsController@update');
Route::get('savingproducts/delete/{id}', 'SavingproductsController@destroy');
Route::get('savingproducts/edit/{id}', 'SavingproductsController@edit');
Route::get('savingproducts/show/{id}', 'SavingproductsController@show');




Route::resource('savingaccounts', 'SavingaccountsController');
Route::get('savingaccounts/create/{id}', 'SavingaccountsController@create');
Route::get('member/savingaccounts/{id}', 'SavingaccountsController@memberaccounts');



Route::get('savingtransactions/show/{id}', 'SavingtransactionsController@show');
Route::resource('savingtransactions', 'SavingtransactionsController');
Route::get('savingtransactions/create/{id}', 'SavingtransactionsController@create');
Route::get('savingtransactions/receipt/{id}', 'SavingtransactionsController@receipt');
Route::get('savingtransactions/statement/{id}', 'SavingtransactionsController@statement');

Route::post('savingtransactions/import', 'SavingtransactionsController@import');

//Route::resource('savingpostings', 'SavingpostingsController');



Route::resource('shares', 'SharesController');
Route::post('shares/update/{id}', 'SharesController@update');
Route::get('shares/delete/{id}', 'SharesController@destroy');
Route::get('shares/edit/{id}', 'SharesController@edit');
Route::get('shares/show/{id}', 'SharesController@show');
Route::get('member/shares', 'SharesController@cssshares');


Route::get('sharetransactions/show/{id}', 'SharetransactionsController@show');
Route::resource('sharetransactions', 'SharetransactionsController');
Route::get('sharetransactions/create/{id}', 'SharetransactionsController@create');





Route::post('license/key', 'OrganizationsController@generate_license_key');
Route::post('license/activate', 'OrganizationsController@activate_license');
Route::get('license/activate/{id}', 'OrganizationsController@activate_license_form');



Route::resource('loanproducts', 'LoanproductsController');
Route::post('loanproducts/update/{id}', 'LoanproductsController@update');
Route::get('loanproducts/delete/{id}', 'LoanproductsController@destroy');
Route::get('loanproducts/edit/{id}', 'LoanproductsController@edit');
Route::get('loanproducts/show/{id}', 'LoanproductsController@show');



Route::resource('disbursements','DisbursementController');
Route::get('disbursements/create','DisbursementController@create');
Route::post('disbursements/create','DisbursementController@docreate');
Route::get('disbursements/update/{id}','DisbursementController@update');
Route::post('disbursements/update','DisbursementController@doupdate');
Route::get('disbursements/delete/{id}','DisbursementController@destroy');

Route::resource('matrices','MatrixController');
Route::get('matrices/create','MatrixController@create');
Route::post('matrices/create','MatrixController@docreate');
Route::get('matrices/update/{id}','MatrixController@update');
Route::post('matrices/update','MatrixController@doupdate');
Route::get('matrices/delete/{id}','MatrixController@destroy');

Route::resource('loanguarantors', 'LoanguarantorsController');
Route::post('loanguarantors/update/{id}', 'LoanguarantorsController@update');
Route::get('loanguarantors/delete/{id}', 'LoanguarantorsController@destroy');
Route::get('loanguarantors/edit/{id}', 'LoanguarantorsController@edit');
Route::get('loanguarantors/create/{id}', 'LoanguarantorsController@create');
Route::get('memberloanguarantors/create/{id}', 'LoanguarantorsController@create');
Route::get('loanguarantors/css/{id}', 'LoanguarantorsController@create');

Route::post('loanguarantors/cssupdate/{id}', 'LoanguarantorsController@cssupdate');
Route::get('loanguarantors/cssdelete/{id}', 'LoanguarantorsController@cssdestroy');
Route::get('loanguarantors/cssedit/{id}', 'LoanguarantorsController@cssedit');



Route::resource('loans', 'LoanaccountsController');
Route::get('loans/apply/{id}', 'LoanaccountsController@apply');
Route::get('guarantorapproval', 'LoanaccountsController@guarantor');
Route::post('loans/apply', 'LoanaccountsController@doapply');
Route::post('loans/application', 'LoanaccountsController@doapply2');


Route::get('loantransactions/statement/{id}', 'LoantransactionsController@statement');
Route::get('loantransactions/certificate/{id}', 'LoantransactionsController@certificate');
Route::get('loantransactions/overpayments/{id}', 'LoantransactionsController@overpayments');
Route::get('loantransactions/receipt/{id}', 'LoantransactionsController@receipt');
Route::get('loanapplication/member', 'LoanaccountsController@member');
Route::post('loanapplication/form', 'LoanaccountsController@application');

Route::get('loans/application/{id}', 'LoanaccountsController@apply2');
Route::post('shopapplication', 'LoanaccountsController@shopapplication');

Route::get('loans/edit/{id}', 'LoanaccountsController@edit');
Route::post('loans/update/{id}', 'LoanaccountsController@update');

Route::get('loans/approve/{id}', 'LoanaccountsController@approve');
Route::post('loans/approve/{id}', 'LoanaccountsController@doapprove');
Route::post('gurantorapprove/{id}', 'LoanaccountsController@guarantorapprove');
Route::post('gurantorreject/{id}', 'LoanaccountsController@guarantorreject');

Route::get('loans/reject/{id}', 'LoanaccountsController@reject');
Route::post('rejectapplication', 'LoanaccountsController@rejectapplication');

Route::get('loans/disburse/{id}', 'LoanaccountsController@disburse');
Route::post('loans/disburse/{id}', 'LoanaccountsController@dodisburse');

Route::get('loans/show/{id}', 'LoanaccountsController@show');
Route::get('memberloan/show/{id}', 'LoanaccountsController@show');

Route::post('loans/amend/{id}', 'LoanaccountsController@amend');

Route::get('loans/reject/{id}', 'LoanaccountsController@reject');
Route::post('loans/reject/{id}', 'LoanaccountsController@rejectapplication');


Route::get('loanaccounts/topup/{id}', 'LoanaccountsController@gettopup');
Route::post('loanaccounts/topup/{id}', 'LoanaccountsController@topup');

Route::get('memloans/{id}', 'LoanaccountsController@show2');

Route::resource('loanrepayments', 'LoanrepaymentsController');

Route::get('loanrepayments/create/{id}', 'LoanrepaymentsController@create');
Route::get('memberloanrepayments/create/{id}', 'LoanrepaymentsController@create');
Route::get('loanrepayments/offset/{id}', 'LoanrepaymentsController@offset');
//Converting and recovering loans routes
Route::get('loanrepayments/recover/{id}', 'LoanrepaymentsController@recoverloan');
Route::get('loanrepayments/convert/{id}', 'LoanrepaymentsController@convert');
Route::post('loanrepayments/recover/complete','LoanrepaymentsController@doRecover');
Route::post('loanrepayments/convert/commit','LoanrepaymentsController@doConvert');
//Guarantor Liabilities
Route::resource('loanliabilities', 'LoanliabilitiesController');

Route::get('memberloanrepayments/offset/{id}', 'LoanrepaymentsController@offset');
Route::post('loanrepayments/offsetloan', 'LoanrepaymentsController@offsetloan');

Route::get('loanaccounts/topup/{id}', 'LoanaccountsController@gettopup');
Route::post('loanaccounts/topup/{id}', 'LoanaccountsController@topup');



Route::get('reports', function(){
    return View::make('members.reports');
});

Route::get('reports/combined', function(){
    $members = Member::where('organization_id',Confide::user()->organization_id)->get();
    return View::make('members.combined', compact('members'));
});


Route::get('loanreports', function(){

    $loanproducts = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();
    return View::make('loanaccounts.reports', compact('loanproducts'));
});


Route::get('savingreports', function(){
    $savingproducts = Savingproduct::where('organization_id',Confide::user()->organization_id)
    ->get();
    return View::make('savingaccounts.reports', compact('savingproducts'));
});


Route::get('financialreports', function(){

    return View::make('pdf.financials.reports');
});

Route::get('erpfinancialreports', function(){ 

    return View::make('pdf.erpfinancials.reports');
});



Route::get('reports/listing', 'ReportsController@members');
Route::get('reports/remittance', 'ReportsController@remittance');
Route::get('reports/blank', 'ReportsController@template');
Route::get('reports/loanlisting', 'ReportsController@loanlisting');

Route::get('reports/loanproduct/{id}', 'ReportsController@loanproduct');
Route::get('reports/creditreport/{id}/{loan}', 'ReportsController@creditappraisal');

Route::get('reports/savinglisting', 'ReportsController@savinglisting');

Route::get('reports/savingproduct/{id}', 'ReportsController@savingproduct');

Route::post('reports/financials', 'ReportsController@financials');



Route::get('memberportal', function(){
    $members = DB::table('members')
    ->where('organization_id',Confide::user()->organization_id)->get();
    return View::make('css.members', compact('members'));
});

Route::get('memberportal/activate/{id}', 'MembersController@activateportal');
Route::get('memberportal/deactivate/{id}', 'MembersController@deactivateportal');
Route::get('membercss/reset/{id}', 'MembersController@reset');

Route::get('portal/activate/{id}', 'EmployeesController@activateportal');
Route::get('portal/deactivate/{id}', 'EmployeesController@deactivateportal');
Route::get('css/reset/{id}', 'EmployeesController@reset');


Route::get('saccoinvestments',function(){
    $investment=Investment::where('organization_id',Confide::User()->organization_id)->get();
    $organization=Organization::where('id',Confide::User()->organization_id)->get();
    return View::make('css.saccoinvestments',compact('investment','organization'));
});

Route::get('saccoinvestments/create',function(){
    $vendor=Vendor::where('organization_id',Confide::User()->organization_id)->get();
    $organization=Organization::where('id',Confide::User()->organization_id)->get();
    return View::make('css.createinvestment',compact('vendor','organization'));
});

Route::post('saccoinvestments/create',function(){
    $data=Input::all();
    $invest=new Investment;
    $invest->name=array_get($data,'investment');
    $invest->vendor_id=array_get($data,'vendor');
    $invest->valuation=array_get($data,'valuation');
    $invest->growth_type=array_get($data,'growth_type');
    $invest->growth_rate=array_get($data,'growth_rate');
    $invest->description=array_get($data,'desc');
    $invest->date=date('Y-m-d');
    $invest->organization_id=Confide::User()->organization_id;
    $invest->save();
    $out="The sacco Investment successfully created!!!";
    $investment=Investment::where('organization_id',Confide::User()->organization_id)->get();
    $organization=Organization::where('id',Confide::User()->organization_id)->get();
    return View::make('css.saccoinvestments',compact('out','investment','organization'));
});
/*
* Vendor controllers
*/
Route::resource('vendors', 'VendorsController');
Route::get('vendors/create', 'VendorsController@create');
Route::post('vendors/update/{id}', 'VendorsController@update');
Route::get('vendors/edit/{id}', 'VendorsController@edit');
Route::get('vendors/delete/{id}', 'VendorsController@destroy');
Route::get('vendors/products/{id}', 'VendorsController@products');
Route::get('vendors/orders/{id}', 'VendorsController@orders');

/*
* products controllers
*/
Route::resource('products', 'ProductsController');
Route::post('products/update/{id}', 'ProductsController@update');
Route::get('products/edit/{id}', 'ProductsController@edit');
Route::get('products/create', 'ProductsController@create');
Route::get('products/delete/{id}', 'ProductsController@destroy');
Route::get('products/orders/{id}', 'ProductsController@orders');
Route::get('shop', 'ProductsController@shop');

/*
* orders controllers
*/
Route::resource('orders', 'OrdersController');
Route::post('orders/update/{id}', 'OrdersControler@update');
Route::get('orders/edit/{id}', 'OrdersControler@edit');
Route::get('orders/delete/{id}', 'OrdersControler@destroy');
Route::get('savings', function(){

    $mem = Confide::user()->username;
    $memb = DB::table('members')
    ->where('organization_id',Confide::user()->organization_id)
    ->where('membership_no', '=', $mem)
    ->pluck('id');
    $member = Member::find($memb);
    return View::make('css.savingaccounts', compact('member'));
});

Route::post('loanguarantors', function(){
        $mem_id = Input::get('member_id');       
        $member = Member::where('id',$mem_id)
        ->where('organization_id',Confide::User()->organization_id)
        ->get();
        if(count($member)<1){
          return Redirect::back()->withNull('You have not selected any guarantor! Select one to continue...');
        }
        $loanaccount = Loanaccount::findOrFail(Input::get('loanaccount_id'));
        $check_member=Loanaccount::where('member_id',$mem_id)
        ->where('organization_id',Confide::User()->organization_id)->get();
        if(count($check_member)>1){
          return Redirect::back()->withBang('The selected member already services a loan, hence cannot guarantee the loan.');
        }else{
        $guarantor = new Loanguarantor;
        $guarantor->member()->associate($member);
        $guarantor->loanaccount()->associate($loanaccount);
        $guarantor->organization_id=Confide::User()->organization_id;
        $guarantor->save();
        return Redirect::to('memloans/'.$loanaccount->id);
      }
});



Route::post('cssloanguarantors', function(){

    
       $mem_id = Input::get('member_id');

        $member = Member::findOrFail($mem_id);

        $loanaccount = Loanaccount::findOrFail(Input::get('loanaccount_id'));
        $guarantor = new Loanguarantor;
        $guarantor->member()->associate($member);
        $guarantor->loanaccount()->associate($loanaccount);
        $guarantor->organization_id = Confide::user()->organization_id;
        $guarantor->save();

        return Redirect::to('memloans/'.$loanaccount->id);

});


Route::resource('audits', 'AuditsController');

Route::get('backups', function(){

   
    //$backups = Backup::getRestorationFiles('../app/storage/backup/');

    return View::make('backup');

});


Route::get('backups/create', function(){

    echo '<pre>';

    $instance = Backup::getBackupEngineInstance();

    print_r($instance);

    //Backup::setPath(public_path().'/backups/');

   //Backup::export();
    //$backups = Backup::getRestorationFiles('../app/storage/backup/');

    //return View::make('backup');

});


Route::get('memtransactions/{id}', 'MembersController@savingtransactions');


/*
* This route is for testing how license conversion works. its purely for testing purposes
*/
Route::get('convert', function(){

// get the name of the organization from the database
//$org_id = Confide::user()->organization_id;
$organization = Organization::findorfail(Confide::user()->organization->id);



$string =  $organization->name;

echo "Organization: ". $string."<br>";


$organization = new Organization;
$license_code = $organization->encode($string);

echo "License Code: ".$license_code."<br>";


$name2 = $organization->decode($license_code, 7);

echo "Decoded L code: ".$name2."<br>";

$license_key = $organization->license_key_generator($license_code);

echo "License Key: ".$license_key."<br>";

echo "__________________________________________________<br>";

$name4 = $organization->license_key_validator($license_key,$license_code,$string);

echo "Decoded L code: ".$name4."<br>";



});

Route::get('perms', function(){

    $perm = new Permission;

    $perm->name = 'edit_loan_product';
    $perm->display_name = 'edit loan products';
    $perm->category = 'Loanproduct';
    $perm->save();

    

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



});


Route::get('rproducts', function(){

    Product::getRemoteProducts();


});



Route::get('reports/deduction', function(){

   return View::make('deduction');

});


Route::post('memberdeductions', function(){

    $date = Input::get('date');

    $members = Member::where('organization_id',Confide::user()->organization_id)->get();

    $loanproducts = Loanproduct::where('organization_id',Confide::user()->organization_id)->get();

    $savingproducts = Savingproduct::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('dedreport', compact('members', 'loanproducts', 'savingproducts', 'date'));
});


Route::post('import/savings', function(){

   if(Input::hasFile('savings')){

      $destination = storage_path().'/backup/';

      $filename = str_random(12);

      $ext = Input::file('savings')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;
     
      Input::file('savings')->move($destination, $file);


    Excel::load(storage_path().'/backup/'.$file, function($reader){

          $results = $reader->get();    

        // Getting all results
        foreach($results as $result){

            $date = date('Y-m-d', strtotime($result->date));
            $savingaccount = Member::getMemberAccount($result->id);

            if(Savingtransaction::trasactionExists($date, $savingaccount) == false){


                     $amount = $result->amount;
            if($amount >= 0){
                $type = 'credit';
                $description = 'savings deposit';
            } else {
                $type = 'debit';
                $description = 'savings withdrawal';
                $amount = preg_replace('/[^0-9]+/', '', $amount);
            }
            $transacted_by = $result->member;
            


            Savingtransaction::transact($date, $savingaccount, $amount, $type, $description, $transacted_by);



            }
           
           
        }

    });





    return Redirect::back()->with('notice', 'savings have been imported');

} else {

    return Redirect::back()->with('error', 'You have not uploaded any file');

}



});


Route::post('import/loans', function(){


     if(Input::hasFile('loans')){

      $destination = storage_path().'/backup/';

      $filename = str_random(12);

      $ext = Input::file('loans')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;
     
      Input::file('loans')->move($destination, $file);

      Excel::load(storage_path().'/backup/'.$file, function($reader){

            $results = $reader->get();    

            // Getting all results
            foreach($results as $result){


        $date = date('Y-m-d', strtotime($result->date));

        $member_id = $result->id;
        $loanproduct_id = $result->product;

        $amount = $result->amount;

        $member = Member::findorfail($member_id);

        $loanproduct = Loanproduct::findorfail($loanproduct_id);

        $loanaccount = new Loanaccount;
        $loanaccount->member()->associate($member);
        $loanaccount->loanproduct()->associate($loanproduct);
        $loanaccount->application_date = $date;
        $loanaccount->amount_applied = $amount;
        $loanaccount->repayment_duration = $result->period;

        
        $loanaccount->date_approved = $date;
        $loanaccount->amount_approved = $amount;
        $loanaccount->interest_rate = $result->rate;
        $loanaccount->period = $result->period;
        $loanaccount->is_approved = TRUE;
        $loanaccount->is_new_application = FALSE;

        $loanaccount->date_disbursed = $date;
        $loanaccount->amount_disbursed = $amount;
        $loanaccount->repayment_start_date = $date;
        $loanaccount->account_number = Loanaccount::loanAccountNumber($loanaccount);
        $loanaccount->is_disbursed = TRUE;
        $loanaccount->organization_id = Confide::user()->organization_id;
    
        $loanaccount->save();

        $loanamount = $amount + Loanaccount::getInterestAmount($loanaccount);
        Loantransaction::disburseLoan($loanaccount, $loanamount, $date);

            }

    });

  }


});





/* ########################  ERP ROUTES ################################ */

Route::resource('clients', 'ClientsController');
Route::get('clients/edit/{id}', 'ClientsController@edit');
Route::post('clients/update/{id}', 'ClientsController@update');
Route::get('clients/delete/{id}', 'ClientsController@destroy');
Route::get('clients/show/{id}', 'ClientsController@show');

Route::resource('items', 'ItemsController');
Route::get('items/edit/{id}', 'ItemsController@edit');
Route::post('items/update/{id}', 'ItemsController@update');
Route::get('items/delete/{id}', 'ItemsController@destroy');

Route::resource('expenses', 'ExpensesController');
Route::get('expenses/edit/{id}', 'ExpensesController@edit');
Route::post('expenses/update/{id}', 'ExpensesController@update');
Route::get('expenses/delete/{id}', 'ExpensesController@destroy');

Route::resource('paymentmethods', 'PaymentmethodsController');
Route::get('paymentmethods/edit/{id}', 'PaymentmethodsController@edit');
Route::post('paymentmethods/update/{id}', 'PaymentmethodsController@update');
Route::get('paymentmethods/delete/{id}', 'PaymentmethodsController@destroy');

Route::resource('payments', 'PaymentsController');
Route::get('payments/edit/{id}', 'PaymentsController@edit');
Route::post('payments/update/{id}', 'PaymentsController@update');
Route::get('payments/delete/{id}', 'PaymentsController@destroy');


Route::resource('locations', 'LocationsController');
Route::get('locations/edit/{id}', 'LocationsController@edit');
Route::get('locations/delete/{id}', 'LocationsController@destroy');
Route::post('locations/update/{id}', 'LocationsController@update');

Route::resource('erporders', 'ErpordersController');
Route::resource('erppurchases', 'ErppurchasesController');
Route::resource('erpquotations', 'ErpquotationsController');


Route::resource('erporderitems', 'ErporderitemsController');
Route::resource('erppurchaseitems', 'ErppurchaseitemsController');
Route::resource('erpquotationitems', 'ErpquotationitemsController');




/*
Leave Reports
*/

Route::get('leaveReports', function(){

    return View::make('leavereports.leavereports');
});

Route::get('leaveReports/selectApplicationPeriod', 'ReportsController@appperiod');
Route::post('leaveReports/leaveapplications', 'ReportsController@leaveapplications');

Route::get('leaveReports/selectApprovedPeriod', 'ReportsController@approvedperiod');
Route::post('leaveReports/approvedleaves', 'ReportsController@approvedleaves');

Route::get('leaveReports/selectRejectedPeriod', 'ReportsController@rejectedperiod');
Route::post('leaveReports/rejectedleaves', 'ReportsController@rejectedleaves');

Route::get('leaveReports/selectLeave', 'ReportsController@balanceselect');
Route::post('leaveReports/leaveBalances', 'ReportsController@leavebalances');

Route::get('leaveReports/selectLeaveType', 'ReportsController@leaveselect');
Route::post('leaveReports/Employeesonleave', 'ReportsController@employeesleave');

Route::get('leaveReports/selectEmployee', 'ReportsController@employeeselect');
Route::post('leaveReports/IndividualEmployeeLeave', 'ReportsController@individualleave');

Route::get('api/dropdown', function(){
    $id = Input::get('option');
    $bbranch = Bank::find($id)->bankbranch;
    return $bbranch->lists('bank_branch_name', 'id');
});

Route::get('api/site', function(){
    $sid = Input::get('option');
    $site = array();


    $site = Site::select('id', 'name')
    ->where('organization_id',Confide::user()->organization_id)
    ->where('period',$sid)
    ->lists('name', 'id');
    

    return $site;
});

Route::get('api/branchemployee', function(){
    $bid = Input::get('option');
    $did = Input::get('deptid');
    $employee = array();


    if(($bid == 'All' || $bid == '' || $bid == 0) && ($did == 'All' || $did == '' || $did == 0)){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('organization_id',Confide::user()->organization_id)
    ->lists('full_name', 'id');
    }else if(($bid != 'All' || $bid != '' || $bid != 0) && ($did == 'All' || $did == '' || $did == 0)){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('branch_id',$bid)
    ->where('organization_id',Confide::user()->organization_id)
    ->lists('full_name', 'id');
    }else if(($did != 'All' || $did != '' || $did != 0) && ($bid != 'All' || $bid != '' || $bid != 0) ){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('branch_id',$bid)
    ->where('organization_id',Confide::user()->organization_id)
    ->where('department_id',$did)
    ->lists('full_name', 'id');
    }

    return $employee;
});

Route::get('api/deptemployee', function(){
    $did = Input::get('option');
    $bid = Input::get('bid');
    $employee = array();

    if(($did == 'All' || $did == '' || $did == 0) && ($bid == 'All' || $bid == '' || $bid == 0)){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('organization_id',Confide::user()->organization_id)
    ->lists('full_name', 'id');
    }else if(($did != 'All' || $did != '' || $did != 0) && ($bid == 'All' || $bid == '' || $bid == 0)){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('department_id',$did)
    ->where('organization_id',Confide::user()->organization_id)
    ->lists('full_name', 'id');
    }else if(($did != 'All' || $did != '' || $did != 0) && ($bid != 'All' || $bid != '' || $bid != 0) ){
    $employee = Employee::select('id', DB::raw('CONCAT(personal_file_number, " : ", first_name," ",middle_name," ",last_name) AS full_name'))
    ->where('branch_id',$bid)
    ->where('organization_id',Confide::user()->organization_id)
    ->where('department_id',$did)
    ->lists('full_name', 'id');
    }

    return $employee;
});

Route::get('api/getDays', function(){
    $id = Input::get('employee');
    $lid = Input::get('leave');
    $d = Input::get('option');
    $sdate = Input::get('sdate');
    $weekends = Input::get('weekends');
    $holidays = Input::get('holidays');
    
    Leaveapplication::checkBalance($id, $lid,$d);
    if(Leaveapplication::checkBalance($id, $lid,$d)<0){
     return Leaveapplication::checkBalance($id, $lid,$d);
    }else{

    $enddate = Leaveapplication::getEndDate($sdate,$d,$weekends,$holidays);

    return $enddate;
    //Leaveapplication::checkHoliday($sdate);
    }
    
    //return Leaveapplication::checkBalance($id, $lid,$d);
});


Route::get('api/score', function(){
    $id = Input::get('option');
    $rate = Appraisalquestion::find($id);
    return $rate->rate;
});

Route::get('api/pay', function(){
    $id = Input::get('option');
    $site = Site::find($id);
    return number_format($site->amount,2);
});

Route::get('empedit/{id}', function($id){

  $employee = Employee::find($id);
    $branches = Branch::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $departments = Department::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $jgroups = Jobgroup::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $etypes = EType::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $citizenships = Citizenship::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $contract = DB::table('employee')
              ->join('employee_type','employee.type_id','=','employee_type.id')
              ->where('type_id',2)
              ->first();
    $banks = Bank::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $bbranches = BBranch::where('bank_id',$employee->bank_id)->whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $educations = Education::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->get();
    $kins = Nextofkin::where('employee_id',$id)->get();
    $docs = Document::where('employee_id',$id)->get();
    $countk = Nextofkin::where('employee_id',$id)->count();
    $countd = Document::where('employee_id',$id)->count();
    $currency = Currency::whereNull('organization_id')->orWhere('organization_id',Confide::user()->organization_id)->first();
    
    return View::make('employees.cssedit', compact('currency','countk','countd','docs','kins','citizenships','contract','branches','educations','departments','etypes','jgroups','banks','bbranches','employee'));

});

Route::get('employeeportal', array('before' => 'loggedin', function(){

    //$members = DB::table('members')->where('organization_id',Confide::user()->organization_id)->where('is_active', '=', TRUE)->get();
  
  $employees = Employee::where('organization_id',Confide::user()->organization_id)->get();

    return View::make('css.employees', compact('employees'));
  
}));

Route::get('css/payslips', function(){

  $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

  $employee = Employee::findorfail($employeeid);

  return View::make('css.payslip', compact('employee'));
});


Route::get('css/leave', function(){

  $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', Confide::user()->username)->pluck('id');


  $employee = Employee::findorfail($employeeid);

   $leaveapplications = DB::table('leaveapplications')->where('organization_id',Confide::user()->organization_id)->where('employee_id', '=', $employee->id)->get();

  return View::make('css.leave', compact('employee', 'leaveapplications'));
});


Route::get('css/leaveapply', function(){

  $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

  $employee = Employee::findorfail($employeeid);
  $leavetypes = Leavetype::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('css.leaveapply', compact('employee', 'leavetypes'));
});


Route::get('css/balances', function(){

  $employeeid = DB::table('employee')->where('organization_id',Confide::user()->organization_id)->where('personal_file_number', '=', Confide::user()->username)->pluck('id');

  $employee = Employee::findorfail($employeeid);
  $leavetypes = Leavetype::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('css.balances', compact('employee', 'leavetypes'));
});



/*
*##########################ERP REPORTS#######################################
*/

Route::get('erpReports', function(){

    return View::make('erpreports.erpReports');
});

Route::post('erpReports/clients', 'ErpReportsController@clients');
Route::get('erpReports/selectClientsPeriod', 'ErpReportsController@selectClientsPeriod');




Route::post('erpReports/items', 'ErpReportsController@items');
Route::get('erpReports/selectItemsPeriod', 'ErpReportsController@selectItemsPeriod');

Route::post('erpReports/expenses', 'ErpReportsController@expenses');
Route::get('erpReports/selectExpensesPeriod', 'ErpReportsController@selectExpensesPeriod');


Route::get('erpReports/paymentmethods', 'ErpReportsController@paymentmethods');

Route::post('erpReports/payments', 'ErpReportsController@payments');
Route::get('erpReports/selectPaymentsPeriod', 'ErpReportsController@selectPaymentsPeriod');

Route::get('erpReports/invoice/{id}', 'ErpReportsController@invoice');


Route::post('erpReports/sales', 'ErpReportsController@sales');
Route::get('erpReports/selectSalesPeriod', 'ErpReportsController@selectSalesPeriod');


Route::post('erpReports/purchases', 'ErpReportsController@purchases');
Route::get('erpReports/selectPurchasesPeriod', 'ErpReportsController@selectPurchasesPeriod');



Route::get('erpReports/quotation/{id}', 'ErpReportsController@quotation');
Route::get('erpReports/pricelist', 'ErpReportsController@pricelist');
Route::get('erpReports/receipt/{id}', 'ErpReportsController@receipt');
Route::get('erpReports/PurchaseOrder/{id}', 'ErpReportsController@PurchaseOrder');

Route::get('erpReports/locations', 'ErpReportsController@locations');

Route::post('erpReports/stocks', 'ErpReportsController@stock');
Route::get('erpReports/selectStockPeriod', 'ErpReportsController@selectStockPeriod');


Route::get('erpReports/accounts', 'ErpReportsController@accounts');



Route::resource('taxes', 'TaxController');
Route::post('taxes/update/{id}', 'TaxController@update');
Route::get('taxes/delete/{id}', 'TaxController@destroy');
Route::get('taxes/edit/{id}', 'TaxController@edit');



Route::get('salesorders', function(){

  $orders = Erporder::where('organization_id',Confide::user()->organization_id)->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.index', compact('items', 'locations', 'orders'));
});



Route::get('purchaseorders', function(){

  $purchases = Erporder::where('organization_id',Confide::user()->organization_id)->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();


  return View::make('erppurchases.index', compact('items', 'locations', 'purchases'));
});



Route::get('quotationorders', function(){

  $quotations = Erporder::where('organization_id',Confide::user()->organization_id)->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.index', compact('items', 'locations', 'quotations'));
});


Route::get('salesorders/create', function(){

  $count = DB::table('erporders')->count();
  $order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $accounts = Account::where('active',true)->get();
  $clients = Client::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.create', compact('items', 'accounts', 'locations', 'order_number', 'clients'));
});


Route::get('purchaseorders/create', function(){

  $count = DB::table('erporders')->where('organization_id',Confide::user()->organization_id)->count();
  $order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $accounts = Account::where('active',true)->get();
  $clients = Client::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.create', compact('items', 'accounts', 'locations', 'order_number', 'clients'));
});


Route::get('quotationorders/create', function(){

  $count = DB::table('erporders')->count();
  $order_number = date("Y/m/d/").str_pad($count+1, 4, "0", STR_PAD_LEFT);;
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();

  $clients = Client::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.create', compact('items', 'locations', 'order_number', 'clients'));
});











Route::post('erporders/create', function(){

  $data = Input::all();

  $client = Client::findOrFail(array_get($data, 'client'));

/*
  $erporder = array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date')

    );
  */

  Session::put( 'erporder', array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date'),
    'asset_acc' => array_get($data, 'asset_acc'),
    'income_acc' => array_get($data, 'income_acc')
    )
    );
  Session::put('orderitems', []);

  $orderitems =Session::get('orderitems');

 /*
  $erporder = new Erporder;

  $erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
  $erporder->order_number = array_get($data, 'order_number');
  $erporder->client()->associate($client);
  $erporder->payment_type = array_get($data, 'payment_type');
  $erporder->type = 'sales';
  $erporder->save();

  */

  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.orderitems', compact('erporder', 'items', 'locations', 'taxes','orderitems'));

});
});
Route::get('erpmgmt', function(){
  if (!Confide::user())
          {
          $sessionTimeout = 1;
          $organization = Organization::find(1);
          return View::make('login',compact('organization'));
          }else{
  return View::make('erpmgmt');
}
});

Route::group(['before' => 'loggedin'], function() {

Route::post('erppurchases/create', function(){

  $data = Input::all();

  $client = Client::findOrFail(array_get($data, 'client'));

/*
  $erporder = array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date')

    );
  */

  Session::put( 'erporder', array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date'),
    'purchase_acc' => array_get($data, 'purchase_acc'),
    'payable_acc' => array_get($data, 'payable_acc')
    )
    );
  Session::put('purchaseitems', []);

  $orderitems =Session::get('purchaseitems');

 /*
  $erporder = new Erporder;

  $erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
  $erporder->order_number = array_get($data, 'order_number');
  $erporder->client()->associate($client);
  $erporder->payment_type = array_get($data, 'payment_type');
  $erporder->type = 'sales';
  $erporder->save();

  */

  $items = Item::where('organization_id',Confide::user()->organization_id)->where('type','=','product')->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.purchaseitems', compact('items', 'locations','taxes','orderitems'));

});





Route::post('erpquotations/create', function(){

  $data = Input::all();

  $client = Client::findOrFail(array_get($data, 'client'));

/*
  $erporder = array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date')

    );
  */

  Session::put( 'erporder', array(
    'order_number' => array_get($data, 'order_number'), 
    'client' => $client,
    'date' => array_get($data, 'date')

    )
    );
  Session::put('quotationitems', []);

  $orderitems =Session::get('quotationitems');

 /*
  $erporder = new Erporder;

  $erporder->date = date('Y-m-d', strtotime(array_get($data, 'date')));
  $erporder->order_number = array_get($data, 'order_number');
  $erporder->client()->associate($client);
  $erporder->payment_type = array_get($data, 'payment_type');
  $erporder->type = 'sales';
  $erporder->save();

  */

  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.quotationitems', compact('items', 'locations','taxes','orderitems'));

});







Route::post('orderitems/create', function(){

  $data = Input::all();

  $item = Item::findOrFail(array_get($data, 'item'));

  $item_name = $item->name;
  $price = $item->selling_price;
  $quantity = Input::get('quantity');
  $duration = Input::get('duration');
  $item_id = $item->id;
  $location = Input::get('location');

   Session::push('orderitems', [
      'itemid' => $item_id,
      'item' => $item_name,
      'price' => $price,
      'quantity' => $quantity,
      'duration' => $duration,
      'location' =>$location
    ]);



  $orderitems = Session::get('orderitems');

   $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();
  return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));

});

Route::get('orderitems/edit/{count}', function($count){
  $editItem = Session::get('orderitems')[$count];

  return View::make('erporders.edit', compact('editItem', 'count'));
});

Route::post('orderitems/edit/{count}', function($sesItemID){
  $quantity = Input::get('qty');
  $price = (float) Input::get('price');
  //return $data['qty'].' - '.$data['price'];

  $ses = Session::get('orderitems');
  //unset($ses);
  $ses[$sesItemID]['quantity']=$quantity;
  $ses[$sesItemID]['price']=$price;
  Session::put('orderitems', $ses);

  $orderitems = Session::get('orderitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));
  
});


/**
 * =====================================
 * Deleting an order item session item
 */
Route::get('orderitems/remove/{count}', function($count){
  $items = Session::get('orderitems');
  unset($items[$count]);
  $newItems = array_values($items);
  Session::put('orderitems', $newItems);


  $orderitems = Session::get('orderitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.orderitems', compact('items', 'locations', 'taxes','orderitems'));
});





Route::post('purchaseitems/create', function(){

  $data = Input::all();

  $item = Item::findOrFail(array_get($data, 'item'));

  $item_name = $item->name;
  $price = $item->purchase_price;
  $quantity = Input::get('quantity');
  $duration = Input::get('duration');
  $item_id = $item->id;

   Session::push('purchaseitems', [
      'itemid' => $item_id,
      'item' => $item_name,
      'price' => $price,
      'quantity' => $quantity,
      'duration' => $duration,
      'quantity' => $quantity,
      'duration' => $duration,
    ]);



  $orderitems = Session::get('purchaseitems');

   $items = Item::where('organization_id',Confide::user()->organization_id)->where('type','product')->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));

});


Route::post('quotationitems/create', function(){

  $data = Input::all();

  $item = Item::findOrFail(array_get($data, 'item'));

  $item_name = $item->name;
  $price = $item->selling_price;
  $quantity = Input::get('quantity');
  $duration = Input::get('duration');
  $item_id = $item->id;

   Session::push('quotationitems', [
      'itemid' => $item_id,
      'item' => $item_name,
      'price' => $price,
      'quantity' => $quantity,
      'duration' => $duration
    ]);



  $orderitems = Session::get('quotationitems');

  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.quotationitems', compact('items', 'locations', 'taxes','orderitems'));

});




/*Route::post('quotationitems/create', function(){

  $data = Input::all();

  $item = Item::findOrFail(array_get($data, 'item'));

  $item_name = $item->name;
  $price = $item->selling_price;
  $quantity = Input::get('quantity');
  $duration = Input::get('duration');
  $item_id = $item->id;

   Session::push('quotationitems', [
      'itemid' => $item_id,
      'item' => $item_name,
      'price' => $price,
      'quantity' => $quantity,
      'duration' => $duration
    ]);



  $orderitems = Session::get('quotationitems');

   $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.quotationitems', compact('items', 'locations', 'taxes','orderitems'));

});*/









Route::get('orderitems/remove/{id}', function($id){

 // Session::forget('orderitems', $id);

  

  $orderitems = Session::get('orderitems');


  foreach ($orderitems as $orderitem) {
       if($orderitem['itemid'] == $id){
          Session::forget($orderitem);

          
        
  //Session::forget('orderitems', $id);
       }
     }

     $orderitems = Session::get('orderitems');

  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erporders.orderitems', compact('items', 'locations', 'taxes', 'orderitems'));

});


Route::resource('stocks', 'StocksController');
Route::resource('erporders', 'ErporderssController');






Route::post('erporder/commit', function(){

  $erporder = Session::get('erporder');

  $erporderitems = Session::get('orderitems');
  
   $total = Input::all();

 // $client = Client: :findorfail(array_get($erporder, 'client'));

 // print_r($total);


  $order = new Erporder;
  $order->order_number = array_get($erporder, 'order_number');
  $order->asset_acc_id = array_get($erporder, 'asset_acc');
  $order->income_acc_id = array_get($erporder, 'income_acc');
  $order->client()->associate(array_get($erporder, 'client'));
  $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
  $order->status = 'new';
  $order->discount_amount = array_get($total, 'discount');
  $order->organization_id = Confide::user()->organization_id;
  $order->type = 'sales';  
  $order->save();
  

  foreach($erporderitems as $item){


    $itm = Item::findOrFail($item['itemid']);

    $ord = Erporder::findOrFail($order->id);


    
    $location_id = $item['location'];
  
    //dd($location_id);

     $location = Location::findOrFail($location_id);    
    
    $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

    $orderitem = new Erporderitem;
    $orderitem->erporder()->associate($ord);
    $orderitem->item()->associate($itm);
    $orderitem->price = $item['price'];
    $orderitem->quantity = $item['quantity'];
    $orderitem->duration = $item['duration'];
    $orderitem->organization_id = Confide::user()->organization_id;
    $orderitem->save();




   Stock::removeStock($itm, $location, $item['quantity'], $date);



  }
 

  $tax = Input::get('tax');
  $rate = Input::get('rate');





  for($i=0; $i < count($rate);  $i++){

    $txOrder = new TaxOrder;

    $txOrder->tax_id = $rate[$i];
    $txOrder->order_number = array_get($erporder, 'order_number');
    $txOrder->amount = $tax[$i];
    $txOrder->save();
    
  }
  

  $data = array(
            'credit_account' => array_get($erporder, 'income_acc'),
            'debit_account' => array_get($erporder, 'asset_acc'),
            'organization_id',Confide::user()->organization_id,
            'date' => date('Y-m-d', strtotime(array_get($erporder, 'date'))),
            'amount' => Input::get('grand'),
            'initiated_by' => 'system',
            'description' => 'Sale of Goods'
          );


          $journal = new Journal;


          $journal->journal_entry($data);
 
//Session::flush('orderitems');
//Session::flush('erporder');  
 
    

return Redirect::to('salesorders')->withFlashMessage('Order Successfully Placed!');



});







Route::get('erppurchase/commit', function(){

  //$orderitems = Session::get('erppurchase');

  $erporder = Session::get('erporder');

  $orderitems = Session::get('purchaseitems');
  
   $total = Input::all();

 // $client = Client: :findorfail(array_get($erporder, 'client'));

 // print_r($total);


  $order = new Erporder;
  $order->order_number = array_get($erporder, 'order_number');
  $order->purchase_acc_id = array_get($erporder, 'purchase_acc');
  $order->payable_acc_id = array_get($erporder, 'payable_acc');
  $order->client()->associate(array_get($erporder, 'client'));
  $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
  $order->status = 'new';
  //$order->discount_amount = array_get($total, 'discount');
  $order->organization_id = Confide::user()->organization_id;
  $order->type = 'purchases';
  $order->save();
  
  $amount = 0;
  $i=0;
  foreach($orderitems as $item){


    $itm = Item::findOrFail($item['itemid']);

    $ord = Erporder::findOrFail($order->id);

    $orderitem = new Erporderitem;
    $orderitem->erporder()->associate($ord);
    $orderitem->item()->associate($itm);
    $orderitem->price = $item['price'];
    $orderitem->quantity = $item['quantity'];
    $orderitem->organization_id = Confide::user()->organization_id;
    //s$orderitem->duration = $item['duration'];
    $orderitem->save();

    $amount = $amount + ($item['price'] * $item['quantity']);
    $i++;
  }

  $data = array(
            'credit_account' => array_get($erporder, 'payable_acc'),
            'debit_account' => array_get($erporder, 'purchase_acc'),
            'organization_id',Confide::user()->organization_id,
            'date' => date('Y-m-d', strtotime(array_get($erporder, 'date'))),
            'amount' => $amount,
            'initiated_by' => 'system',
            'description' => 'Purchase of Goods'
          );


          $journal = new Journal;


          $journal->journal_entry($data);
  
 
//Session::flush('orderitems');
//Session::flush('erporder');
return Redirect::to('purchaseorders');



});


Route::post('erpquotation/commit', function(){

  $erporder = Session::get('erporder');

  $erporderitems = Session::get('quotationitems');
  
   $total = Input::all();

 // $client = Client: :findorfail(array_get($erporder, 'client'));

 // print_r($total);


  $order = new Erporder;
  $order->order_number = array_get($erporder, 'order_number');
  $order->client()->associate(array_get($erporder, 'client'));
  $order->date = date('Y-m-d', strtotime(array_get($erporder, 'date')));
  $order->status = 'new';
  $order->discount_amount = array_get($total, 'discount');
  $order->organization_id = Confide::user()->organization_id;
  $order->type = 'quotations';  
  $order->save();
  

  foreach($erporderitems as $item){


    $itm = Item::findOrFail($item['itemid']);

    $ord = Erporder::findOrFail($order->id);


    
    //$location_id = $item['location'];

     //$location = Location::find($location_id);    
    
    $date = date('Y-m-d', strtotime(array_get($erporder, 'date')));

    $orderitem = new Erporderitem;
    $orderitem->erporder()->associate($ord);
    $orderitem->item()->associate($itm);
    $orderitem->price = $item['price'];
    $orderitem->quantity = $item['quantity'];
    $orderitem->duration = $item['duration'];
    $orderitem->organization_id = Confide::user()->organization_id;
    $orderitem->save();




     }
 

  $tax = Input::get('tax');
  $rate = Input::get('rate');





  for($i=0; $i < count($rate);  $i++){

    $txOrder = new TaxOrder;

    $txOrder->tax_id = $rate[$i];
    $txOrder->order_number = array_get($erporder, 'order_number');
    $txOrder->amount = $tax[$i];
    $txOrder->save();
    
  }
  
 
//Session::flush('orderitems');
//Session::flush('erporder');  
 
    

return Redirect::to('quotationorders');



});










Route::get('erporders/cancel/{id}', function($id){

  $order = Erporder::findorfail($id);



  $order->status = 'cancelled';
  $order->update();

  return Redirect::to('salesorders');
  
});


Route::get('erporders/delivered/{id}', function($id){

  $order = Erporder::findorfail($id);



  $order->status = 'delivered';
  $order->update();

  return Redirect::to('salesorders');
  
});




Route::get('erppurchases/cancel/{id}', function($id){

  $order = Erporder::findorfail($id);



  $order->status = 'cancelled';
  $order->update();

  return Redirect::to('purchaseorders');
  
});



Route::get('erppurchases/delivered/{id}', function($id){

  $order = Erporder::findorfail($id);



  $order->status = 'delivered';
  $order->update();

  return Redirect::to('purchaseorders');
  
});




Route::get('erpquotations/cancel/{id}', function($id){

  $order = Erporder::findorfail($id);



  $order->status = 'cancelled';
  $order->update();

  return Redirect::to('quotationorders');
  
});




Route::get('erporders/show/{id}', function($id){

  $order = Erporder::findorfail($id);

  return View::make('erporders.show', compact('order'));
  
});



Route::get('erppurchases/show/{id}', function($id){

  $order = Erporder::findorfail($id);

  return View::make('erppurchases.show', compact('order'));
  
});


Route::get('erppurchases/payment/{id}', function($id){

  $payments = Payment::where('organization_id',Confide::user()->organization_id)->get();

  $purchase = Erporder::findorfail($id);    

  $account = Accounts::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.payment', compact('payments', 'purchase', 'account'));
  
});



Route::get('erpquotations/show/{id}', function($id){


  $order = Erporder::findorfail($id);

  return View::make('erpquotations.show', compact('order'));
  
});

Route::get('api/getrate', function(){
    $id = Input::get('option');
    $tax = Tax::find($id);
    return $tax->rate;
});

Route::get('api/getmax', function(){
    $id = Input::get('option');
    $stock_in = DB::table('stocks')
         ->join('items', 'stocks.item_id', '=', 'items.id')
         ->where('organization_id',Confide::user()->organization_id)
         ->where('item_id',$id)
         ->sum('quantity_in');

    $stock_out = DB::table('stocks')
         ->join('items', 'stocks.item_id', '=', 'items.id')
         ->where('item_id',$id)
         ->where('organization_id',Confide::user()->organization_id)
         ->sum('quantity_out');
    return $stock_in-$stock_out;
});


Route::get('api/total', function(){
    $id = Input::get('option');    
    $client = Client::find($id);
    $order = 0;    

          if($client->type == 'Customer'){
           $order = DB::table('erporders')
           ->join('erporderitems','erporders.id','=','erporderitems.erporder_id')
           ->join('clients','erporders.client_id','=','clients.id')
           ->where('clients.id',$id)
           ->where('erporders.type','sales') 
           ->where('erporders.status','!=','cancelled') 
           ->selectRaw('SUM((price * quantity)) as total')
           ->pluck('total');

           $tax = DB::table('erporders')
           ->join('clients','erporders.client_id','=','clients.id')
           ->join('tax_orders','erporders.order_number','=','tax_orders.order_number')
           ->where('clients.id',$id)
           ->where('erporders.type','sales') 
           ->where('erporders.status','!=','cancelled') 
           ->selectRaw('SUM(COALESCE(amount,0))as total')
           ->pluck('total');

           $discount = DB::table('erporders')
           ->join('erporderitems','erporders.id','=','erporderitems.erporder_id')
           ->join('clients','erporders.client_id','=','clients.id')
           ->where('clients.id',$id)
           ->where('erporders.type','sales') 
           ->where('erporders.status','!=','cancelled') 
           ->selectRaw('COALESCE(SUM(discount_amount),0) as total')
           ->pluck('total');

           $order = $order + $tax-$discount;
           }
            else{
           $order = DB::table('erporders')
           ->join('erporderitems','erporders.id','=','erporderitems.erporder_id')
           ->join('clients','erporders.client_id','=','clients.id')           
           ->where('clients.id',$id)
           ->where('erporders.type','purchases') 
           ->where('erporders.status','!=','cancelled') 
           ->selectRaw('SUM((price * quantity))as total')
           ->pluck('total');
         }

    $paid = DB::table('clients')
           ->join('payments','clients.id','=','payments.client_id')
           ->where('clients.id',$id) 
           ->where('void',0) 
           ->selectRaw('COALESCE(SUM(amount_paid),0) as due')
           ->pluck('due');

    //dd($paid);

    return number_format($order-$paid, 2);
});

/*
*overtimes
*/

Route::resource('overtimes', 'OvertimesController');
Route::get('overtimes/edit/{id}', 'OvertimesController@edit');
Route::post('overtimes/update/{id}', 'OvertimesController@update');
Route::get('overtimes/delete/{id}', 'OvertimesController@destroy');
Route::get('overtimes/view/{id}', 'OvertimesController@view');

/*
* employee documents routes
*/

Route::resource('documents', 'DocumentsController');
Route::post('documents/update/{id}', 'DocumentsController@update');
Route::get('documents/delete/{id}', 'DocumentsController@destroy');
Route::get('documents/edit/{id}', 'DocumentsController@edit');
Route::get('documents/download/{id}', 'DocumentsController@getDownload');
Route::get('documents/create/{id}', 'DocumentsController@create');
Route::post('createDoc', 'DocumentsController@serializecheck');

Route::resource('NextOfKins', 'NextOfKinsController');
Route::post('NextOfKins/update/{id}', 'NextOfKinsController@update');
Route::get('NextOfKins/delete/{id}', 'NextOfKinsController@destroy');
Route::get('NextOfKins/edit/{id}', 'NextOfKinsController@edit');
Route::get('NextOfKins/view/{id}', 'NextOfKinsController@view');
Route::get('NextOfKins/create/{id}', 'NextOfKinsController@create');
Route::post('createKin', 'NextOfKinsController@serializecheck');

Route::resource('Appraisals', 'AppraisalsController');
Route::post('Appraisals/update/{id}', 'AppraisalsController@update');
Route::get('Appraisals/delete/{id}', 'AppraisalsController@destroy');
Route::get('Appraisals/edit/{id}', 'AppraisalsController@edit');
Route::get('Appraisals/view/{id}', 'AppraisalsController@view');
Route::post('createQuestion', 'AppraisalsController@createquestion');

Route::resource('Properties', 'PropertiesController');
Route::post('Properties/update/{id}', 'PropertiesController@update');
Route::get('Properties/delete/{id}', 'PropertiesController@destroy');
Route::get('Properties/edit/{id}', 'PropertiesController@edit');
Route::get('Properties/view/{id}', 'PropertiesController@view');

Route::resource('AppraisalSettings', 'AppraisalSettingsController');
Route::post('AppraisalSettings/update/{id}', 'AppraisalSettingsController@update');
Route::get('AppraisalSettings/delete/{id}', 'AppraisalSettingsController@destroy');
Route::get('AppraisalSettings/edit/{id}', 'AppraisalSettingsController@edit');
Route::post('createCategory', 'AppraisalSettingsController@createcategory');

Route::resource('appraisalcategories', 'AppraisalCategoryController');
Route::post('appraisalcategories/update/{id}', 'AppraisalCategoryController@update');
Route::get('appraisalcategories/delete/{id}', 'AppraisalCategoryController@destroy');
Route::get('appraisalcategories/edit/{id}', 'AppraisalCategoryController@edit');


Route::resource('itemcategories', 'ItemcategoriesController');
Route::get('itemcategories/edit/{id}', 'ItemcategoriesController@edit');
Route::get('itemcategories/delete/{id}', 'ItemcategoriesController@destroy');
Route::post('itemcategories/update/{id}', 'ItemcategoriesController@update');

Route::resource('budgets', 'BudgetsController');
Route::post('budgets/update/{id}', 'BudgetsController@update');
Route::get('budgets/delete/{id}', 'BudgetsController@destroy');
Route::get('budgets/edit/{id}', 'BudgetsController@edit');
Route::get('budgets/view/{id}', 'BudgetsController@view');


Route::resource('expensesettings', 'ExpenseSettingsController');
Route::post('expensesettings/update/{id}', 'ExpenseSettingsController@update');
Route::get('expensesettings/delete/{id}', 'ExpenseSettingsController@destroy');
Route::get('expensesettings/edit/{id}', 'ExpenseSettingsController@edit');
Route::get('expensesettings/view/{id}', 'ExpenseSettingsController@view');


Route::get('erpmigrate', function(){

  return View::make('erpmigrate');

});


Route::post('import/categories', function(){

  
  if(Input::hasFile('category')){

      $destination = public_path().'/migrations/';

      $filename = str_random(12);

      $ext = Input::file('category')->getClientOriginalExtension();
      $file = $filename.'.'.$ext;



      
      
     
      Input::file('category')->move($destination, $file);


  


    Excel::selectSheetsByIndex(0)->load(public_path().'/migrations/'.$file, function($reader){

          $results = $reader->get();    
  
    foreach ($results as $result) {



      $category = new Itemcategory;

      $employee->personal_file_number = $result->employment_number;
      
      $employee->first_name = $result->first_name;
      $employee->last_name = $result->surname;
      $employee->middle_name = $result->other_names;
      $employee->identity_number = $result->id_number;
      $employee->pin = $result->kra_pin;
      $employee->social_security_number = $result->nssf_number;
      $employee->hospital_insurance_number = $result->nhif_number;
      $employee->email_office = $result->email_address;
      $employee->basic_pay = $result->basic_pay;
      $employee->organization_id = Confide::user()->organization_id;
      $employee->save();
      
    }
    

    

  });



      
    }



  return Redirect::back()->with('notice', 'Employees have been succeffully imported');
  

});

Route::get('reports/AllowanceExcel', 'ReportsController@excelAll');

Route::get('itax/download', 'ReportsController@getDownload');

Route::get('reminders', function(){
$employees = Employee::where('type_id',2)->where('organization_id',Confide::user()->organization_id)->where('in_employment','Y')->whereNotNull('start_date')->whereNotNull('end_date')->get();
        Mail::send('reminders.message', compact('employees'), function($message){
        $message->to('ken.wango@lixnet.net', 'Ken Wango')->subject('Contract Reminders');
        });
     echo 'sent';
     //return Redirect::back()->with('success', 'Email Sent!');
});

Route::get('emaildocs', function(){
$employees = DB::table('documents')
             ->join('employee', 'documents.employee_id', '=', 'employee.id')
             ->where('in_employment','Y')
             ->where('organization_id',Confide::user()->organization_id)
             ->whereNotNull('from_date')
             ->whereNotNull('expiry_date')
             ->get();
        Mail::send('reminders.docmessage', compact('employees'), function($message){
        $message->to('ken.wango@lixnet.net', 'Ken Wango')->subject('Employee Document Reminders');
        });
     echo 'sent';
     //return Redirect::back()->with('success', 'Email Sent!');
});

/*
* Organization Products
*/

Route::resource('activatedproducts', 'XproductsController');
Route::post('activatedproducts/create', 'XproductsController@create');
Route::post('activatedproducts/generate/{id}', 'XproductsController@generateKey');
Route::get('activatedproducts/license/{id}', 'XproductsController@license');
Route::post('activatedproducts/updatelicense/{id}', 'XproductsController@update');
//Route::post('activatedproducts/update/{id}', 'XproductsController@update');
Route::get('activatedproducts/remove/{id}', 'XproductsController@destroy');
Route::get('activatedproducts/edit/{id}', 'XproductsController@edit');
Route::get('activatedproducts/editcbs/{id}', 'XproductsController@editcbs');
Route::get('activatedproducts/editfinancials/{id}', 'XproductsController@editerp');
Route::get('activatedproducts/show/{id}', 'XproductsController@show');


Route::resource('reminderview', 'RemindersController');
Route::get('reminderdoc/indexdoc', 'RemindersController@indexdoc');
Route::post('reminderview/update/{id}', 'RemindersController@update');
Route::get('reminderdoc/download/{id}', 'RemindersController@getDownload');
Route::get('reminderview/delete/{id}', 'RemindersController@destroy');
Route::get('reminderview/edit/{id}', 'RemindersController@edit');
Route::get('reminderview/show/{id}', 'RemindersController@show');

Route::post('requestlicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $key = Input::get('key');
 $part = explode("-", Organization::decodeKey($key));
 //print_r(Organization::strToBin('10'));
 return View::make('xproducts.license',compact('part','organization','key'));
});

Route::post('requestalllicensekey', function()
{
 
 $key = Input::get('key');
 $part = explode("-", Organization::decodeKey($key));
 //print_r(Organization::strToBin('10'));
 return View::make('upgradelicense',compact('part','key'));
});

Route::post('requestcbslicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $key = Input::get('key');
 $part = explode("-", Organization::decodeKey($key));
 //print_r(Organization::strToBin('10'));
 return View::make('xproducts.licensecbs',compact('part','organization','key'));
});

Route::post('requesterplicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $key = Input::get('key');
 $part = explode("-", Organization::decodeKey($key));
 //print_r(Organization::strToBin('10'));
 return View::make('xproducts.licenseerp',compact('part','organization','key'));
});

Route::get('generatelicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);
 }else{
   $encoded = '';
 }
 return $encoded;
});

Route::get('getinfo', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);
 }else{
   $encoded = '';
 }
 return $noe;
});


Route::get('downloadlicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/payroll/'.$organization->name.' payroll license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
  
  return $encoded;

 }else{
   $encoded = '';
 }
});

Route::get('downloadcbslicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $nom = Input::get('option');
 $text = '';
 $encoded = '';
 if($nom != null && $nom != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->cbs_code).'-'.Organization::strToBin("'".$organization->cbs_licensed."'").'-'.Organization::strToBin($nom).'-'.Organization::strToBin($organization->cbs_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/cbs/'.$organization->name.' cbs license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
  
  return $encoded;

 }else{
   $encoded = '';
 }
});

Route::get('downloaderplicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noc = Input::get('clients');
 $noi = Input::get('items');
 $text = '';
 $encoded = '';
 if(($noc != null && $noc != '') && ($noi != null && $noi != '')){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->erp_code).'-'.Organization::strToBin("'".$organization->erp_client_licensed."'").'-'.Organization::strToBin("'".$organization->erp_item_licensed."'").'-'.Organization::strToBin($noc).'-'.Organization::strToBin($noi).'-'.Organization::strToBin($organization->erp_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/financial/'.$organization->name.' financial license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
  
  return $encoded;

 }else{
   $encoded = '';
 }
});


Route::get('emaillicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/payroll/'.$organization->name.' payroll license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
   /*$headers = array(
              "Content-type: text/plain",
              
            );
  return Response::download($my_file, $organization->name.' payroll license.txt', $headers);*/

        
        Mail::send('license.message', compact('organization'), function($message) use($organization){
        $message->to('support@lixnet.net', 'Lixnet Technologies')->subject('Payroll license');
        $message->attach(public_path().'/uploads/license txts/payroll/'.$organization->name.' payroll license.license');
        });
  if(count(Mail::failures()) == 0) {
     return count(Mail::failures());
   }else{
      print_r(count(Mail::failures()));
   }

 }else{
   $encoded = '';
 }
});

Route::get('emailcbslicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->cbs_code).'-'.Organization::strToBin("'".$organization->cbs_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->cbs_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/cbs/'.$organization->name.' cbs license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
   /*$headers = array(
              "Content-type: text/plain",
              
            );
  return Response::download($my_file, $organization->name.' payroll license.txt', $headers);*/

        
        Mail::send('license.messagecbs', compact('organization'), function($message) use($organization){
        $message->to('support@lixnet.net', 'Lixnet Technologies')->subject('CBS license');
        $message->attach(public_path().'/uploads/license txts/cbs/'.$organization->name.' cbs license.license');
        });
  if(count(Mail::failures()) == 0) {
     return 0;
   }else{
    return 1;
   }

 }else{
   $encoded = '';
 }
});

Route::get('emailerplicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noc = Input::get('clients');
 $noi = Input::get('items');
 $text = '';
 $encoded = '';
 if(($noc != null && $noc != '') && ($noi != null && $noi != '')){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->erp_code).'-'.Organization::strToBin("'".$organization->erp_client_licensed."'").'-'.Organization::strToBin("'".$organization->erp_item_licensed."'").'-'.Organization::strToBin($noc).'-'.Organization::strToBin($noi).'-'.Organization::strToBin($organization->erp_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);
 
 $my_file = public_path().'/uploads/license txts/financial/'.$organization->name.' financial license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
   /*$headers = array(
              "Content-type: text/plain",
              
            );
  return Response::download($my_file, $organization->name.' payroll license.txt', $headers);*/

        
        Mail::send('license.messageerp', compact('organization'), function($message) use($organization){
        $message->to('support@lixnet.net', 'Lixnet Technologies')->subject('Financial license');
        $message->attach(public_path().'/uploads/license txts/financial/'.$organization->name.' financial license.license');
        });
  if(count(Mail::failures()) == 0) {
     return 0;
   }else{
    return 1;
   }

 }else{
   $encoded = '';
 }
});

Route::get('generatecbslicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noe = Input::get('option');
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->cbs_code).'-'.Organization::strToBin("'".$organization->cbs_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->cbs_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);
 }else{
   $encoded = '';
 }
 return $encoded;
});

Route::get('generateerplicensekey', function()
{
 $organization = Organization::find(Confide::user()->organization_id);
 $noc = Input::get('clients');
 $noi = Input::get('items');
 $text = '';
 $encoded = '';
 if(($noc != null && $noc != '') && ($noi != null && $noi != '')){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->erp_code).'-'.Organization::strToBin("'".$organization->erp_client_licensed."'").'-'.Organization::strToBin("'".$organization->erp_item_licensed."'").'-'.Organization::strToBin($noc).'-'.Organization::strToBin($noi).'-'.Organization::strToBin($organization->erp_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);
 }else{
   $encoded = '';
 }
 return $encoded;
});

Route::get('member', function(){

   
    $member = Member::where('membership_no',Confide::user()->username)->first();

    return View::make('css.memberindex', compact('member'));

});


Route::get('memberloanrepayments', function(){
    $m = Member::where('membership_no',Confide::user()->username)->first();
    $member = Member::findOrFail($m->id);
    /*$loanaccounts = DB::table('loanaccounts')
                       ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanproducts.id')
                       ->join('members', 'loanaccounts.member_id', '=', 'members.id')
                       ->where('loanaccounts.member_id',$member->id)
                       ->where('loanaccounts.is_approved',1)
                       ->select('loanaccounts.id as id','members.name as mname','members.id as mid','loanproducts.name as pname','phone','application_date','amount_applied','repayment_duration','loanaccounts.interest_rate')
                       ->get();*/

    return View::make('css.loanrepayment', compact('member'));

});

Route::post('loanpayment/{id}', function(){
   $name = Input::get('mname');
   $date = Input::get('date');
   $phone = Input::get('phone');
   $mid = Input::get('mid');
   $loanaccount_id = Input::get('loanaccount_id');
   $amount = Input::get('amount');
    View::addLocation(app_path() . '/views/pesapal-php-master');
    View::addNamespace('theme', app_path() .'/views/pesapal-php-master');
   
    return View::make('pesapal-iframe', compact('name','date','phone','amount','mid','loanaccount_id'));

});


Route::post('memberloanrepayments/offsetloan', function(){
   $name = Input::get('mname');
   $date = Input::get('date');
   $phone = Input::get('phone');
   $mid = Input::get('mid');
   $loanaccount_id = Input::get('loanaccount_id');
   $amount = Input::get('amount');
    View::addLocation(app_path() . '/views/pesapal-php-master');
    View::addNamespace('theme', app_path() .'/views/pesapal-php-master');
   
    return View::make('pesapal-iframe-offset', compact('name','date','phone','amount','mid','loanaccount_id'));

});

Route::get('/pesapal_callback', function(){
   $validator = Validator::make($data = Input::all(), Loanrepayment::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    $loanaccount = Input::get('loanaccount_id');
    Loanrepayment::repayLoan($data);
    return Redirect::to('/memberloanrepayments')->withFlashMessage('You have successfully paid this month`s loan instalment!');

});

Route::get('/pesapal_callback_offset', function(){
   $validator = Validator::make($data = Input::all(), Loanrepayment::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    $loanaccount = Input::get('loanaccount_id');
    Loanrepayment::offsetLoan($data);
    return Redirect::to('/memberloanrepayments')->withFlashMessage('You have successfully completed paying your loan!');

});


Route::post('membersavingtransactions/{id}', function(){
  if(Input::get('type') == 'credit'){
   $transacted_by = Input::get('transacted_by');
   $date = Input::get('date');
   $ttype = Input::get('type');
   $phone = Input::get('phone');
   $mid = Input::get('mid');
   $description = Input::get('description');
   $account_id = Input::get('account_id');
   $amount = Input::get('amount');
    View::addLocation(app_path() . '/views/pesapal-php-master');
    View::addNamespace('theme', app_path() .'/views/pesapal-php-master');
   
    return View::make('pesapal-iframe-savings', compact('transacted_by','description','date','phone','amount','mid','account_id','ttype'));
}else{
  $validator = Validator::make($data = Input::all(), Savingtransaction::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    $date = Input::get('date');
    $transAmount = Input::get('amount');
    $currency = Currency::find(1);

    $savingaccount = Savingaccount::findOrFail(Input::get('account_id'));
    $date = Input::get('date');
    $amount = Input::get('amount');
    $type = Input::get('type');
    $description = Input::get('description');
    $transacted_by = Input::get('transacted_by');


    Savingtransaction::transact($date, $savingaccount, $amount, $type, $description, $transacted_by);

    return Redirect::to('memtransactions/'.$savingaccount->id)->withFlashMessage('You have successfully withdrawn '.$currency->shortname.'. '.number_format($transAmount,2).' from your savings account!');
}
});

Route::get('/pesapal_callback_saving', function(){
   $validator = Validator::make($data = Input::all(), Savingtransaction::$rules);

    if ($validator->fails())
    {
      return Redirect::back()->withErrors($validator)->withInput();
    }

    $date = Input::get('date');
    $transAmount = Input::get('amount');
    $currency = Currency::find(1);

    $savingaccount = Savingaccount::findOrFail(Input::get('account_id'));
    $date = Input::get('date');
    $amount = Input::get('amount');
    $type = Input::get('type');
    $description = Input::get('description');
    $transacted_by = Input::get('transacted_by');


    Savingtransaction::transact($date, $savingaccount, $amount, $type, $description, $transacted_by);

    return Redirect::to('memtransactions/'.$savingaccount->id)->withFlashMessage('You have successfully deposited '.$currency->shortname.'. '.number_format($amount,2).' to your savings account!');

});

Route::get('guarantorapproval', 'LoanaccountsController@guarantor');
Route::get('memberloanshow/{id}', 'LoanproductsController@memberloanshow');
Route::post('gurantorapprove/{id}', 'LoanaccountsController@guarantorapprove');
Route::post('gurantorreject/{id}', 'LoanaccountsController@guarantorreject');


Route::get('purchaseitems/edit/{count}', function($count){
  $editItem = Session::get('purchaseitems')[$count];

  return View::make('erppurchases.edit', compact('editItem', 'count'));
});

Route::post('erppurchases/edit/{count}', function($sesItemID){
  $quantity = Input::get('qty');
  $price = (float) Input::get('price');
  //return $data['qty'].' - '.$data['price'];

  $ses = Session::get('purchaseitems');
  //unset($ses);
  $ses[$sesItemID]['quantity']=$quantity;
  $ses[$sesItemID]['price']=$price;
  Session::put('purchaseitems', $ses);

  $orderitems = Session::get('purchaseitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->where('type','product')->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));
  
});



/**
 * =====================================
 * Deleting an order item session item
 */




/**
 * =========================================================================
 * Deleting a purchase order session
 */
Route::get('purchaseitems/remove/{count}', function($count){
  $items = Session::get('purchaseitems');
  unset($items[$count]);
  $newItems = array_values($items);
  Session::put('purchaseitems', $newItems);


  $orderitems = Session::get('purchaseitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->where('type','product')->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erppurchases.purchaseitems', compact('items', 'locations', 'taxes','orderitems'));
});

Route::get('quotationitems/remove/{count}', function($count){
  $items = Session::get('quotationitems');
  unset($items[$count]);
  $newItems = array_values($items);
  Session::put('quotationitems', $newItems);


  $orderitems = Session::get('quotationitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.quotationitems', compact('items', 'locations', 'taxes','orderitems'));
  //return Session::get('quotationitems')[$count];
});


/**
 * EDITING A QUOTATION ITEM
 */
Route::get('quotationitems/edit/{count}', function($count){
  $editItem = Session::get('quotationitems')[$count];

  return View::make('erpquotations.sessionedit', compact('editItem', 'count'));
});


Route::post('erpquotations/sessionedit/{count}', function($sesItemID){
  $quantity = Input::get('qty');
  $price = (float) Input::get('price');

  $ses = Session::get('quotationitems');
  
  $ses[$sesItemID]['quantity']=$quantity;
  $ses[$sesItemID]['price']=$price;
  Session::put('quotationitems', $ses);

  $orderitems = Session::get('quotationitems');
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $locations = Location::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();

  return View::make('erpquotations.quotationitems', compact('items', 'locations', 'taxes','orderitems'));
});

/*=================================================================================*/


Route::post('erpquotations/mail', 'ErpReportsController@sendMail_quotation');


/**
 * EDIT QUOTATION 'X'
 */
Route::get('erpquotations/edit/{id}', function($id){
  $order = Erporder::findorfail($id);
  $items = Item::where('organization_id',Confide::user()->organization_id)->get();
  $taxes = Tax::where('organization_id',Confide::user()->organization_id)->get();
  $tax_orders = TaxOrder::where('order_number', $order->order_number)->where('organization_id',Confide::user()->organization_id)->orderBy('tax_id', 'ASC')->get();

  //return $tax_orders;
  return View::make('erpquotations.editquotation', compact('order', 'items', 'taxes', 'tax_orders'));

});

Route::post('/erpquotations/approve', function(){
  $id = Input::get('order_id');
  $comment = Input::get('comment');

  $order = Erporder::findorfail($id);

  $order->status = 'APPROVED';
  if($comment === ''){
    $order->comment = 'No comment.';
  } else{
    $order->comment = $comment;
  }

  $order->update();

  return Redirect::to('erpquotations/show/'.$id);
});


/**
 * REJECT QUOTATION 'X'
 */
Route::post('/erpquotations/reject', function(){
  $id = Input::get('order_id');
  $comment = Input::get('comment');

  $order = Erporder::findorfail($id);

  $order->status = 'REJECTED';
  if($comment === ''){
    $order->comment = 'No comment.';
  } else{
    $order->comment = $comment;
  }

  $order->update();

  return Redirect::to('erpquotations/show/'.$id);
});

/**
 * ADD ITEMS TO EXISTING ORDER
 */
Route::post('erpquotations/edit/add', function(){
    $order_id = Input::get('order_id');
    $item_id = Input::get('item_id');
    $quantity = Input::get('quantity');
    
    $item = Item::findorfail($item_id);
    $item_price = $item->selling_price;

    $itemId = Erporderitem::where('erporder_id', $order_id)->where('item_id', $item_id)->get();
    
    if(count($itemId) > 0){
        return Redirect::back()->with('error', "Item already exists! You can edit the existing item.");
    } else{
        $order_item = new Erporderitem;
        
        $order_item->item_id = $item_id;
        $order_item->quantity = $quantity;
        $order_item->erporder_id = $order_id;   
        $order_item->price = $item_price;
        $order_item->save();

        return Redirect::back(); 
    }
});


/**
 * COMMIT CHANGES
 */
Route::post('erpquotations/edit/{id}', function($id){
    $order = Erporder::findOrFail($id);

    foreach($order->erporderitems as $orderitem){
        $val = Input::get('newQty'.$orderitem->item_id);
        $orderitem->quantity = $val;
        $orderitem->save();
    }  

    $discount = Input::get('discount');
    $order->discount_amount = $discount;
    //$order->save();

    $tax = Input::get('tax');
    $rate = Input::get('rate');

    
    for($i=0; $i < count($rate);  $i++){
       if(count(TaxOrder::getAmount($rate[$i],$order->order_number)) > 0){
            $txtOrder = TaxOrder::findOrFail($rate[$i]);
            $txtOrder->amount = $tax[$i];
            $txtOrder->update();
        } else{
            $txOrder = new TaxOrder;
            $txOrder->tax_id = $rate[$i];
            $txOrder->order_number = array_get($order, 'order_number');
            $txOrder->amount = $tax[$i];
            $txOrder->save();
        }
    }

    $order->status = 'EDITED';
    $order->update();
    return View::make('erpquotations.show', compact('order'));
});

Route::get('erpquotations/delete/{quote_id}/{id}', function($quote_id, $id){
  
  DB::table('erporderitems')
        ->where('id', $id)
        ->delete();
  DB::update('ALTER TABLE `erporderitems` AUTO_INCREMENT=1');

  return Redirect::to('erpquotations/edit/'.$quote_id);
});

Route::post('licenseconfirm', function(){
  $organization = Organization::find(Input::get('organization_id'));
  $user = User::find(Input::get('user_id'));
  $name = $user->username;
  $orgname = $organization->name;
  $orgmail = $organization->email;
  $orgphone = $organization->phone;

  
 $nom = Input::get('members');
 $noe = Input::get('employees');
 $noc = Input::get('clients');
 $noi = Input::get('items');
 $payroll = Input::get('payroll');
 $cbs = Input::get('cbs');
 $erp = Input::get('erp');

 

 $text = '';
 $encoded = '';
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($organization->erp_code).'-'.Organization::strToBin($organization->cbs_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->erp_client_licensed."'").'-'.Organization::strToBin("'".$organization->erp_item_licensed."'").'-'.Organization::strToBin("'".$organization->cbs_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($nom).'-'.Organization::strToBin($noc).'-'.Organization::strToBin($noi).'-'.Organization::strToBin($payroll).'-'.Organization::strToBin($erp).'-'.Organization::strToBin($cbs).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin($organization->erp_support_period).'-'.Organization::strToBin($organization->cbs_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

 $my_file = public_path().'/uploads/license txts/all/'.$organization->name.' product license.license';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
      fclose($handle);
   /*$headers = array(
              "Content-type: text/plain",
              
            );
  return Response::download($my_file, $organization->name.' payroll license.txt', $headers);*/

  Mail::send('emails.license', array('name'=>$name, 'orgname'=>$orgname,'employees'=>Input::get('employees'),'members'=>Input::get('members'),'clients'=>Input::get('clients'),'items'=>Input::get('items'),'cbs'=>Input::get('cbs'),'payroll'=>Input::get('payroll'),'erp'=>Input::get('erp')), function( $message ) use ($user)
  {
    $message->to($user->email)->subject('License Upgrade');
  });

  Mail::send('emails.support', array('name'=>$name, 'orgname'=>$orgname, 'orgmail'=>$orgmail, 'orgphone'=>$orgphone,'employees'=>Input::get('employees'),'members'=>Input::get('members'),'clients'=>Input::get('clients'),'items'=>Input::get('items'),'cbs'=>Input::get('cbs'),'payroll'=>Input::get('payroll'),'erp'=>Input::get('erp')), function( $message ) use ($organization)
  {
    $message->to('ken.wango@lixnet.net')->subject('License Upgrade for '.$organization->name);
    $message->attach(public_path().'/uploads/license txts/all/'.$organization->name.' product license.license');
  });
 

  //dd(Input::get('payroll'));

  
  
  return Redirect::to('users/login')->with('notice', 'Thank you for applying for license upgrade! Your license information has been sent to lixnet.net and will get back to you');
  
});
});

Route::get('reports/monthlyrepayments', function(){
    $loans=Loanaccount::where('is_disbursed','=',TRUE)
    ->where('organization_id',Confide::User()->organization_id)
    ->groupBy('member_id')
    ->get();
    return View::make('loanaccounts.monthlyrepayments',compact('loans'));
});

Route::post('reports/monthlyrepayments', 'ReportsController@monthlyrepayments');

Route::get('api/loans', function(){
    $id = Input::get('option');
    $loans = DB::table('loanaccounts')
                 ->join('loanproducts', 'loanaccounts.loanproduct_id', '=', 'loanproducts.id')
                 ->where('member_id','=',$id)
                 ->select('loanaccounts.id as id','loanproducts.name as name')
                 ->lists('name','id');
    
    return $loans;
});

/**
 * Bank Account Routes &
 * Bank Reconciliation Routes
 */
Route::resource('bankAccounts', 'BankAccountController');
Route::get('bankAccounts/reconcile/{id}', 'BankAccountController@showReconcile');
Route::post('bankAccounts/uploadStatement', 'BankAccountController@uploadBankStatement');
Route::post('bankAccount/reconcile', 'BankAccountController@reconcileStatement');

Route::get('bankAccount/reconcile/add/{id}/{id2}/{id3}', 'BankAccountController@addStatementTransaction');
Route::post('bankAccount/reconcile/add', 'BankAccountController@saveStatementTransaction');

Route::get('bankReconciliation/report', 'ErpReportsController@displayRecOptions');
Route::post('bankReconciliartion/generateReport', 'ErpReportsController@showRecReport');
