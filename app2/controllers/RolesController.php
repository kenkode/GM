<?php



/**
 * rolesController Class
 *
 * Implements actions regarding role management
 */
class RolesController extends Controller
{


    /**
    * display a list of system roles
    */
    public function index(){

        $roles = Role::where('organization_id',Confide::user()->organization_id)->get();

        return View::make('roles.index')->with('roles', $roles);
    }


    /**
    * display the edit page
    */
    public function edit($id){

        $role = Role::find($id);

        return View::make('roles.edit')->with('role', $role);
    }


     /**
    * updates the role
    */
    public function update($id){

        $role = Role::find($id);

        $role->name = Input::get('name');
       
        $role->update();

        return Redirect::to('roles/profile/'.$role->id);
    }




    /**
     * Displays the form for account creation
     *
     * @return  Illuminate\Http\Response
     */
    public function create()
    {

        $categories = DB::table('permissions')->whereNull('organization_id')->select('category')->distinct()->get();
        $permissions = Permission::whereNull('organization_id')->get();
        
        
        return View::make('roles.create', compact('permissions', 'categories'));
    }

    /**
     * Stores new account
     *
     * @return  Illuminate\Http\Response
     */
    public function store()
    {

        

        $perms = Input::get('permission');

        
        
        $role = new Role;

        $role->name = Input::get('name');
        
        $role->organization_id = Confide::user()->organization_id;

        $role->save();

        $role->perms()->sync($perms);

        return Redirect::route('roles.index');

        

        


    }





    /**
    * Delete the role
    *
    */

    public function destroy($id){

        $role = Role::find($id);

        
        $role->delete();

        return Redirect::to('roles');
    }


  











  



    



 



}
