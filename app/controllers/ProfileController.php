<?php

class ProfileController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function editprofile()
	{
		$profile = DB::table('companyprofile')->first();
		$this->layout->content = View::make('profile/edit')->with('profile',$profile);
	}
	public function store()
	{
		
		$rules = array(
			'name'     => 'required',
			'regno'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('users/create')
				->withErrors($validator);
		} else {
			$ProfileEntry = ProfileEntry::find(0);
			$ProfileEntry->company_name       = Input::get('name');
			$ProfileEntry->registration_no	   = Input::get('regno');
			$ProfileEntry->header	   = Input::get('header');
			$ProfileEntry->remarks       = Input::get('remarks');
			$ProfileEntry->terms       = Input::get('terms');
			$ProfileEntry->remarks2       = Input::get('remarks2');
			$ProfileEntry->terms2       = Input::get('terms2');
			$ProfileEntry->remarks3       = Input::get('remarks3');
			$ProfileEntry->terms3       = Input::get('terms3');
			$ProfileEntry->save();
			if (Input::file('logo') != "")
				Input::file('logo')->move('img/', 'logo.jpg');
		}
			$profile = DB::table('companyprofile')->first();
			$this->layout->content = View::make('profile/edit')->with('profile',$profile);
	}
}
?>