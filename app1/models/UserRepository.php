<?php

/**
 * Class UserRepository
 *
 * This service abstracts some interactions that occurs between Confide and
 * the Database.
 */
class UserRepository
{
    /**
     * Signup a new account with the given parameters
     *
     * @param  array $input Array containing 'username', 'email' and 'password'.
     *
     * @return  User User object that may or may not be saved successfully. Check the id to make sure.
     */
    public function signup($input)
    {
       
        $name = array_get($input, 'organization');
        $phone = array_get($input, 'phone');
        $country = array_get($input, 'country');
        $county = array_get($input, 'county');

        $agents = array("Susan Impui", "Sharon Obonyo", "Reyhab Wanjiru", "Jonathan Wachira");
        
        $agentno = array_rand($agents, 1);
       
        $organization = new Organization;
        $lcode = $organization->generateRandomString();

        //$organization =  Organization::find(1);
        $organization->name = $name;
        $organization->phone = $phone;
        $organization->country = $country;
        $organization->county = $county;
        $organization->agent = $agents[$agentno];
        $organization->logo = 'xara.png';
        $organization->cbs_licensed = 100;
        $organization->license_code = $lcode;
        $organization->payroll_code = 'P3110';
        $organization->erp_code = 'E3110';
        $organization->cbs_code = 'C3110';
        $organization->payroll_support_period = date('Y-m-d');
        $organization->erp_support_period = date('Y-m-d');
        $organization->cbs_support_period = date('Y-m-d');
        $organization->erp_item_licensed = 5;
        $organization->erp_client_licensed = 10;
        $organization->payroll_licensed = 10;
        $organization->is_payroll_active = 1;
        $organization->is_erp_active = 1;
        $organization->is_cbs_active = 1;
        $organization->demo_expiry = date('Y-m-d', strtotime("+30 days"));
        $organization->status = 0;
       /*
        if(Input::get('payroll_activate') != null ){
        $organization->is_payroll_active = 1;
        }else{
        $organization->is_payroll_active = 0;
        }
        if(Input::get('erp_activate') != null ){
        $organization->is_erp_active = 1;
        }else{
        $organization->is_erp_active = 0;
        }
        if(Input::get('cbs_activate') != null ){
        $organization->is_cbs_active = 1;
        }else{
        $organization->is_cbs_active = 0;
        }
        */
        $organization->save();


        $user = new User;
        $org =  Organization::orderBy('id','desc')->first();
        $user->username = array_get($input, 'username');
        $user->email    = array_get($input, 'email');
        $user->password = array_get($input, 'password');
        $user->user_type =array_get($input, 'user_type');
        //$user->username = array_get($input, 'username');
        $user->organization_id = $org->id;
        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = array_get($input, 'password_confirmation');

        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));

        // Save if valid. Password field will be hashed before save
        if( $this->save($user)){

        $perms = Permission::all();

        $pers = array();
        $i = 1;

        foreach($perms as $p){

        $pers[] = $p->id;
        }
        
        $r= Role::orderBy('id', 'DESC')->first();
        
        $role = new Role;

        $role->name = 'systemadmin'.$r->id;

        $role->organization_id = $org->id;

        $role->save();

        $role->perms()->sync($pers);

	        DB::table('assigned_roles')->insert(
	        array('user_id' => $user->id, 'role_id' => $role->id)
	        );
	 }
        return $user;

        
    }



    public function register($input)
    {
       

        $org= Organization::orderBy('id', 'DESC')->first();
        $user = new User;

        $user->username = array_get($input, 'username');
        $user->email    = array_get($input, 'email');
        $user->password = array_get($input, 'password');
        $user->user_type = array_get($input, 'user_type');;
        $user->organization_id = $org->id;

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = array_get($input, 'password_confirmation');

        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));

        // Save if valid. Password field will be hashed before save
        $this->save($user);

         

        return $user;

        
    }

    public function userRoles($input)
    {
       
        $user = new User;

        $user->username = array_get($input, 'username');
        $user->email    = array_get($input, 'email');
        $user->password = array_get($input, 'password');
        $user->user_type = array_get($input, 'user_type');
        $user->organization_id = array_get($input, 'organization_id');

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = array_get($input, 'password_confirmation');

        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));

        // Save if valid. Password field will be hashed before save
        $user->save();

         

        return $user;

        
    }




    /**
     * Attempts to login with the given credentials.
     *
     * @param  array $input Array containing the credentials (email/username and password)
     *
     * @return  boolean Success?
     */
    public function login($input)
    {
        if (! isset($input['password'])) {
            $input['password'] = null;
        }

        return Confide::logAttempt($input, Config::get('confide::signup_confirm'));
    }

    /**
     * Checks if the credentials has been throttled by too
     * much failed login attempts
     *
     * @param  array $credentials Array containing the credentials (email/username and password)
     *
     * @return  boolean Is throttled
     */
    public function isThrottled($input)
    {
        return Confide::isThrottled($input);
    }

    /**
     * Checks if the given credentials correponds to a user that exists but
     * is not confirmed
     *
     * @param  array $credentials Array containing the credentials (email/username and password)
     *
     * @return  boolean Exists and is not confirmed?
     */
    public function existsButNotConfirmed($input)
    {
        $user = Confide::getUserByEmailOrUsername($input);

        if ($user) {
            $correctPassword = Hash::check(
                isset($input['password']) ? $input['password'] : false,
                $user->password
            );

            return (! $user->confirmed && $correctPassword);
        }
    }

    /**
     * Resets a password of a user. The $input['token'] will tell which user.
     *
     * @param  array $input Array containing 'token', 'password' and 'password_confirmation' keys.
     *
     * @return  boolean Success
     */
    public function resetPassword($input)
    {
        $result = false;
        $user   = User::where('token',$input['token'])->first();

        if ($user) {
            $user->password              = $input['password'];
            $user->password_confirmation = $input['password_confirmation'];
            $result = $this->save($user);
        }

        // If result is positive, destroy token
        if ($result) {
            Confide::destroyForgotPasswordToken($input['token']);
        }

        return $result;
    }

    /**
     * Simply saves the given instance
     *
     * @param  User $instance
     *
     * @return  boolean Success
     */
    public function save(User $instance)
    {
        return $instance->save();
    }
}
