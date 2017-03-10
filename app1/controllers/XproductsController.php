<?php

class XproductsController extends \BaseController {

	/**
	 * Display a listing of accounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('xproducts.index', compact('organization'));


		Audit::logaudit('Xproducts', 'view', 'view activated products');
	}

	/**
	 * Show the form for creating a new account
	 *
	 * @return Response
	 */
	public function create()
	{
		$organization = Organization::find(Confide::user()->organization_id);
		$name = '';
        
        if(Input::get('payroll_activate') != null ){
        $organization->is_payroll_active = 1;
        }
        if(Input::get('erp_activate') != null ){
        $organization->is_erp_active = 1;
        }
        if(Input::get('cbs_activate') != null ){
        $organization->is_cbs_active = 1;
        }
		$organization->update();

		if(Input::get('payroll_activate') != null && Input::get('erp_activate') != null && Input::get('cbs_activate') != null){
        $name = 'Payroll, Financials and CBS products';
		}else if(Input::get('payroll_activate') != null && Input::get('erp_activate') != null){
        $name = 'Payroll and Financials products';
		}else if(Input::get('payroll_activate') != null && Input::get('cbs_activate') != null){
        $name = 'Payroll and CBS products';
		}else if(Input::get('erp_activate') != null && Input::get('cbs_activate') != null){
        $name = 'Financials and CBS products';
		}else if(Input::get('payroll_activate') != null){
        $name = 'Payroll product';
		}else if(Input::get('erp_activate') != null){
        $name = 'Financials product';
		}else if(Input::get('cbs_activate') != null){
        $name = 'CBS product';
		}

		
		Audit::logaudit('Organizations', 'update', 'updated product license for : '.$name);


		return Redirect::route('activatedproducts.index')->withFlashMessage($name.' successfully activated!');

	}

	/**
	 * Store a newly created account in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Xproduct::$rules,Xproduct::$messages);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
         
        $organization = Organization::find(Confide::user()->organization_id);

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
		$organization->update();


		Audit::logaudit('Product', 'activate', 'activated: '.$organization->name);

		return Redirect::route('accounts.index');
	}

	/**
	 * Display the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('xproducts.show', compact('organization','id'));
	}

	public function license($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		if($id == 'Payroll'){
			return View::make('xproducts.license', compact('organization','id'));
		}else if($id == 'CBS'){
			return View::make('xproducts.licensecbs', compact('organization','id'));
		}else{
            return View::make('xproducts.licenseerp', compact('organization','id'));
		}
	}

	/**
	 * Show the form for editing the specified account.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('xproducts.edit', compact('organization'));
	}

	public function editcbs($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('xproducts.editc', compact('organization'));
	}

	public function editerp($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		return View::make('xproducts.edite', compact('organization'));
	}

	public function generateKey($id)
	{
		$organization = Organization::find(Confide::user()->organization_id);

		$organization->license_code;
		$organization->payroll_code;

		return View::make('xproducts.edit', compact('organization'));
	}

	/**
	 * Update the specified account in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$key = Input::get('fname');
        $part = explode("-", Organization::decodeKey($key));
		$organization = Organization::where('name',Organization::binToStr($part[0]))->first();
		$str = Input::get("pcode");

		if($str[0] == 'P'){

			$organization->payroll_license_type = 'Commercial';
			$organization->payroll_licensed = Input::get('employees');
			$organization->payroll_license_key = 1;
			$organization->payroll_support_period = Input::get('period');
			$organization->update();

			$my_file = public_path().'/uploads/license txts/payroll/'.$organization->name.' payroll license '.str_replace("-", "", Input::get('period')).'.license';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
            $data = Input::get('fname');
            fwrite($handle, $data);
            fclose($handle);
		
		Audit::logaudit('Organizations', 'upgraded', 'upgraded payroll product license');
		return Redirect::route('activatedproducts.index', compact('organization'))->withFlashMessage('Your Payroll License has been successfully upgraded for '.Input::get('employees').' employees!');
		}else if($str[0] == 'C'){
         $organization->cbs_license_type = 'Commercial';
			$organization->cbs_licensed = Input::get('members');
			$organization->cbs_license_key = 1;
			$organization->cbs_support_period = Input::get('cperiod');
			$organization->update();

		$my_file = public_path().'/uploads/license txts/cbs/'.$organization->name.' cbs license '.str_replace("-", "", Input::get('cperiod')).'.license';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
            $data = Input::get('fname');
            fwrite($handle, $data);
            fclose($handle);
		
		Audit::logaudit('Organizations', 'upgraded', 'upgraded CBS product license');
		return Redirect::route('activatedproducts.index', compact('organization'))->withFlashMessage('Your CBS License has been successfully upgraded for '.Input::get('members').' members!');
		
		}else if($str[0] == 'E'){
         $organization->erp_license_type = 'Commercial';
			$organization->erp_client_licensed = Input::get('clients');
			$organization->erp_item_licensed = Input::get('items');
			$organization->erp_license_key = 1;
			$organization->erp_support_period = Input::get('eperiod');
			$organization->update();

		$my_file = public_path().'/uploads/license txts/financial/'.$organization->name.' financial license '.str_replace("-", "", Input::get('eperiod')).'.license';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
            $data = Input::get('fname');
            fwrite($handle, $data);
            fclose($handle);
		
		Audit::logaudit('Organizations', 'upgraded', 'upgraded Financials product license');
		return Redirect::route('activatedproducts.index', compact('organization'))->withFlashMessage('Your Financials License has been successfully upgraded for '.Input::get('clients').' clients and '.Input::get('items').' items!');
		
		}else{
		if(Input::get('members') != '' || Input::get('members') != null){
          $organization->cbs_license_type = 'Commercial';
			$organization->cbs_licensed = Input::get('members');
			$organization->cbs_license_key = 1;
			$organization->cbs_support_period = Input::get('period');
			$organization->update();
		}if(Input::get('employees') != '' || Input::get('employees') != null){
          $organization->payroll_license_type = 'Commercial';
			$organization->payroll_licensed = Input::get('employees');
			$organization->payroll_license_key = 1;
			$organization->payroll_support_period = Input::get('period');
			$organization->update();
		}if(Input::get('clients') != '' || Input::get('clients') != null){
          $organization->erp_license_type = 'Commercial';
			$organization->erp_client_licensed = Input::get('clients');
			$organization->erp_license_key = 1;
			$organization->erp_support_period = Input::get('period');
			$organization->update();
		}if(Input::get('items') != '' || Input::get('items') != null){
			$organization->erp_item_licensed = Input::get('items');
			$organization->update();
		}
         
        $organization->status = 1;
	    $organization->update();
		$my_file = public_path().'/uploads/license txts/all/'.$organization->name.' license '.str_replace("-", "", Input::get('period')).'.license';
            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
            $data = Input::get('fname');
            fwrite($handle, $data);
            fclose($handle);

           
		
		Audit::loglicenseAudit('Organizations', 'upgraded', 'upgraded xara financials product license',Organization::binToStr($part[0]));
		//return Redirect::to('users/login', compact('organization'))->withFlashMessage('Your Xara fiancials License has been successfully upgraded...Please login and enjoy the product!');
		//return View::make('login', ["flash_message" => "Your Xara fiancials License has been successfully upgraded...Please login and enjoy the product!"]);
		echo "<script>alert('Your Xara fiancials License has been successfully upgraded...Please login and enjoy the product!')</script>";
        echo "<script>window.location = '".URL::to('/users/login')."';</script>";
		}
        
		
	}

	/**
	 * Remove the specified account from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$organization = Organization::find(1);

		$name = '';
        
        if(($organization->is_payroll_active == 0 && $organization->is_erp_active == 0) || ($organization->is_payroll_active == 0 && $organization->is_cbs_active == 0) || ($organization->is_cbs_active == 0 && $organization->is_erp_active == 0)){
        return Redirect::route('activatedproducts.index')->withDeleteMessage('You should have atleast one product in the system!');
	    }else{
        if($id == 'Payroll' ){
        $organization->is_payroll_active = 0;
        }
        if($id == 'financial' ){
        $organization->is_erp_active = 0;
        }
        if($id == 'cbs' ){
        $organization->is_cbs_active = 0;
        }
		$organization->update();

		if($id == 'Payroll'){
        $name = 'Payroll product';
		}else if($id == 'financial'){
        $name = 'Financials product';
		}else if($id == 'cbs'){
        $name = 'CBS product';
		}
		Audit::logaudit('Organizations', 'remove', 'removed '.$name);
		return Redirect::route('activatedproducts.index')->withDeleteMessage($name.' successfully removed!');
	    }
		
	}

public function getDownload($id){
 $organization = Organization::find(1);
 $noe = $id;
 $text = '';
 $encoded = '';
 if($noe != null && $noe != ''){
 //$string = $organization->name.'-'.$organization->license_code.'-'.$organization->payroll_code.'-100-'.$organization->payroll_support_period;
 $text = Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).'-'.Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin("'".$organization->payroll_licensed."'").'-'.Organization::strToBin($noe).'-'.Organization::strToBin($organization->payroll_support_period).'-'.Organization::strToBin('Pending');
 //print_r(Organization::strToBin($organization->name).'-'.Organization::strToBin($organization->license_code).
//Organization::strToBin($organization->payroll_code).'-'.Organization::strToBin('100').'-'.Organization::strToBin($organization->payroll_support_period).'<br>'.Organization::binToStr('00110010001100000011000100110110001011010011000000110101001011010011000100111000'));
 $encoded = Organization::createKey($text);

$my_file = public_path().'/uploads/license txts/'.$organization->name.' payroll license.txt';
      $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
      $data = $encoded;
      fwrite($handle, $data);
      
      /*if(fwrite($handle, $data) === false){
       return 0;
      }else{
       return 1;
      }*/
    fclose($handle);
    return Response::download($my_file, $organization->name.' payroll license.txt');
 }else{
   $encoded = '';
 }
}
}
