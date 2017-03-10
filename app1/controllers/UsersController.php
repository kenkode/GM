<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class UsersController extends Controller
{


    /**
    * display a list of system users
    */
    public function index(){

        $users = User::where('organization_id',Confide::user()->organization_id)->get();

        return View::make('users.index')->with('users', $users);
    }

    public function lis($id,$user){

        $client = User::where('username',$user)->orWhere('email',$user)->first();
        $organization = Organization::find($id);

        return View::make('license',compact('organization','client'));
    }


    /**
    * display the edit page
    */
    public function edit($user){

        $user = User::find($user);

        return View::make('users.edit')->with('user', $user);
    }


     /**
    * updates the user
    */
    public function update($user){

        $user = User::find($user);

        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->update();

        return Redirect::to('users/profile/'.$user->id);
    }




    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('organization_id',Confide::user()->organization_id)->get();
        return View::make('users.create', compact('roles'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function dosignup()
    {

        $input = Input::all();



        
        
        $repo = App::make('UserRepository');
        $user = $repo->signup($input);


       
        if ($user->id) {
            /*if (Config::get('confide::signup_email')) {
                Mail::queueOn(
                    Config::get('confide::email_queue'),
                    Config::get('confide::email_account_confirmation'),
                    compact('user'),
                    function ($message) use ($user) {
                        $message
                            ->to($user->email, $user->username)
                            ->subject(Lang::get('confide::confide.email.account_confirmation.subject'));
                    }
                );
            }*/
            
        $user = User::find($user->id);
        $name = $user->username;
        $key  = $user->confirmation_code;
        Mail::send('signup.message', compact('name','key'), function($message) use ($user){
        $message->to($user->email, $user->first_name.' '.$user->last_name)->subject('CLOUD XARA');
        $message->attach('app/views/temp/Xara CBS Manual.pdf');
        $message->attach('app/views/temp/XARA FINANCIALS Manual.pdf');
        $message->attach('app/views/temp/XARA PAYROLL MANUAL.pdf');
        });

        Mail::send('signup.xara', compact('name','user'), function($message) use ($user){
        $message->to('reports@lixnet.net', 'Lixnet Technologies')->subject('Users Registration Report');
        });

            return Redirect::to('/')->withFlashMessage('Registration successful! Please click on the link sent to your email to activate your account');
                
        } else {
            $error = $user->errors()->all(':message');

            return Redirect::back()
                ->withInput(Input::except('password'))
                ->with('error', $error);
        }

        
    }
    
    public function summary(){
    
        $users = DB::table('users')->where('created_at', '>=', new DateTime('today'))->get(); 
        

        $data = array();
        
        foreach($users as $user){
            
            $data[] = $user;
            
        }
        
        echo '<pre>';

        Mail::send('emails.summary', compact('users'), function($message) {
                
                        $message->to('reports@lixnet.net', 'Lixnet Technologies')->subject('Users Registration Report');
        });

        
        //return View::make('emails.summary', compact('downloads'));
        

    }
    

    /**
     * Displays the login form
     *
     * @return  Illuminate\Http\Response
     */
    public function login()
    {
    

        if (Confide::user()) {
            return Redirect::to('/dashboard');

        } else {
            return View::make('login');
        }
    }

    /**
     * Attempt to do login
     *
     * @return  Illuminate\Http\Response
     */
    public function doLogin()
    {


        $repo = App::make('UserRepository');
        $input = Input::all();

        if ($repo->login($input)) {
        $organization = Organization::find(Confide::user()->organization_id);

        if($organization->demo_expiry<date('Y-m-d') && $organization->status ==0){
          
            Confide::logout();
            return Redirect::to('renewlicense/'.$organization->id.'/'.Input::get('email'))->with('notice', 'Your trial period is over! Please Fill this form to purchase full product');

        }else{
            return Redirect::intended('/dashboard');
        
            Audit::logaudit('System', 'login', 'Logged in: '.Confide::user()->username);
        }
        } else {
            if ($repo->isThrottled($input)) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');

                Audit::logaudit('System', 'login', 'failed log in attempt');
            } elseif ($repo->existsButNotConfirmed($input)) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::action('UsersController@login')
                ->withInput(Input::except('password'))
                ->with('error', $err_msg);
        }
    }

    /**
     * Attempt to confirm account with code
     *
     * @param  string $code
     *
     * @return  Illuminate\Http\Response
     */
    public function confirm($code)
    {
        if (Confide::confirm($code)) {
            $notice_msg = Lang::get('confide::confide.alerts.confirmation');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
            return Redirect::action('UsersController@login')
                ->with('error', $error_msg);
        }
    }

    /**
     * Displays the forgot password form
     *
     * @return  Illuminate\Http\Response
     */
    public function forgotPassword()
    {
        return View::make('users.forgot');
    }

    /**
     * Attempt to send change password link to the given email
     *
     * @return  Illuminate\Http\Response
     */
    public function doForgotPassword()
    {
        if (Confide::forgotPassword(Input::get('email'))) {
            $notice_msg = Lang::get('confide::confide.alerts.password_forgot');
            echo "<script>alert('A link has been sent to your email')</script>";
            echo "<script>window.location = 'login';</script>";
            //return Redirect::action('UsersController@login')->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
            return Redirect::action('UsersController@doForgotPassword')
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Shows the change password form with the given token
     *
     * @param  string $token
     *
     * @return  Illuminate\Http\Response
     */
    public function resetPassword($token)
    {
        return View::make(Config::get('confide::reset_password_form'))
                ->with('token', $token);
    }

    /**
     * Attempt change password of the user
     *
     * @return  Illuminate\Http\Response
     */
    public function doResetPassword()
    {
        //dd(Input::get('token'));
        $repo = App::make('UserRepository');
        $input = array(
            'token'                 =>Input::get('token'),
            'password'              =>Input::get('password'),
            'password_confirmation' =>Input::get('password_confirmation'),
        );



        // By passing an array with the token, password and confirmation
        if ($repo->resetPassword($input)) {
            $notice_msg = Lang::get('confide::confide.alerts.password_reset');
            return Redirect::action('UsersController@login')
                ->with('notice', $notice_msg);
        } else {
            $error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
            return Redirect::action('UsersController@resetPassword', array('token'=>$input['token']))
                ->withInput()
                ->with('error', $error_msg);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @return  Illuminate\Http\Response
     */
    public function logout()
    {

        Audit::logaudit('System', 'logout', 'Logged out: '.Confide::user()->username);

        Confide::logout();



        return Redirect::to('/');
    }


    /**
    * Activate the user
    *
    */

    public function activate($user){

        $user = User::find($user);

        $user->confirmed = 1;
        $user->save();

        return Redirect::to('users');
    }


    /**
    * Deactivate the user
    *
    */

    public function deactivate($user){

        $user = User::find($user);

        $user->confirmed = 0;
        $user->save();

        return Redirect::to('users');
    }


    /**
    * Delete the user
    *
    */

    public function destroy($user){

        $user = User::find($user);

        
        $user->delete();

        return Redirect::to('users');
    }


    /**
    * change user password
    */
    public function changePassword($user){

        $user = User::find($user);

        $password_confirmation = Input::get('password_confirmation');
        $password = Input::get('password');

        if($password != $password_confirmation){

            return Redirect::to('users/password/'.$user->id)->with('error', 'passwords do not match');
        } 
        else
        {

            $pass = Hash::make($password);
            
            DB::table('users')->where('id', $user->id)->update(array('password' => $pass));


           // return Redirect::to('users/profile/'.$user->id);

            return Redirect::to('users/logout');
        }



    }


    public function password($user){

        $user = User::find($user);
        return View::make('users.password', compact('user'));

    }





    public function profile($user){

        $user = User::find($user);

        return View::make('users.profile', compact('user'));
    }


    public function add(){


         $user = new User;

    $user->username = 'admin';
    $user->email = 'admin@rental.com';

    $user->password = Hash::make('password123');
    $user->confirmation_code = 'eoioweq982jwe';
    $user->remember_token = 'jsadksjd928323';
    $user->confirmed = '1';
    $user->organization_id = Confide::user()->organization_id;
    $user->save();


    echo "user created";
    }







    public function changePassword2(){

        $user_id = Confide::user()->id;

        $user = User::find($user_id);

        $password_confirmation = Input::get('password_confirmation');
        $password = Input::get('password');

        if($password != $password_confirmation){

            return Redirect::back()->with('error', 'passwords do not match');
        } 
        else
        {




            
        $user->password = Hash::make($password);
        $user->update();

        //DB::table('users')->where('id', $user_id)->update(array('password' => $pass));

        return Redirect::to('users/logout');



            

            
        }



    }


    public function password2(){

        $user = Confide::user()->id;
        return View::make('css.password', compact('user'));

    }


    public function tellers(){

        $tellers = DB::table('users')->where('user_type', '=', 'teller')->get();

        return View::make('tellers.index', compact('tellers'));
    }

    public function createteller($id){

        $user = User::findorfail($id);

        $user->user_type = 'teller';
        $user->is_active = true;
        $user->update();

        return Redirect::to('tellers');
    }


    public function activateteller($id){

        $user = User::findorfail($id);

        
        $user->is_active = true;
        $user->update();

        return Redirect::to('tellers');
    }


    public function deactivateteller($id){

        $user = User::findorfail($id);

        
        $user->is_active = false;
        $user->update();

        return Redirect::to('tellers');
    }


    public function newuser(){

        $input = Input::all();

        $validator = Validator::make($input = Input::all(), Newuser::$rules);

        $input['password'] = Hash::make($input['password']);
        // THIS does the trick
        $input['password_confirmation'] = Hash::make($input['password_confirmation']);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $roles = Input::get('role');

        /*$repo = App::make('UserRepository');
        $user = $repo->register($input);
         */

        $user = new Newuser;

        $user->username = array_get($input, 'username');
        $user->email    = array_get($input, 'email');
        $user->password = array_get($input, 'password');
        $user->user_type = array_get($input, 'user_type');
        $user->organization_id = Confide::user()->organization_id;

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        //$user->password_confirmation = array_get($input, 'password_confirmation');

        // Generate a random confirmation code
        $user->confirmation_code     = md5(uniqid(mt_rand(), true));
         echo '<pre>';
        $user->save();
     
        if(count($roles)>0){
        foreach ($roles as $rol) {
                
            $role = Role::find($rol);

            $user_id = DB::table('users')->where('username', '=', $user->username)->where('email', '=', $user->email)->pluck('id');
              

            DB::table('assigned_roles')->insert(
                    array('user_id' => $user->id, 'role_id' => $role->id)
                );
                
                
        }
    }
        

       return Redirect::to('users');
    }


    public function show($id){

        

         Confide::logout();

        return Redirect::to('/');
    }


}
