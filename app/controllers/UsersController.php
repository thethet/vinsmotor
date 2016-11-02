<?php

class UsersController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$user_roles = DB::table('user_role')->get();
		$this->layout->content =  View::make('users.create')->with('user_roles',$user_roles);	
	}
	public function show_users()
	{
		$users = DB::table('users')->get();
		$this->layout->content =  View::make('users.manage')->with('users',$users);	
	}
	public function show_user_roles()
	{
		$user_roles = DB::table('user_role')->get();
		$this->layout->content =  View::make('users.roles')->with('user_roles',$user_roles);	
	}
	public function store()
	{
		$password = Input::get('password');
		$cfm_password =Input::get('cfm_password');
		if ($password == $cfm_password)
		{
			$rules = array(
				'first_name'     => 'required',
				'last_name'      => 'required'
			);
			$validator = Validator::make(Input::all(), $rules);
	
			if ($validator->fails()) {
				return Redirect::to('users/create')
					->withErrors($validator);
			} else {
				$UserEntry = new UserEntry;
				$UserEntry->first_name       = Input::get('first_name');
				$UserEntry->last_name	   = Input::get('last_name');
				$UserEntry->password	   = Hash::make($password);
				$UserEntry->dob       = Input::get('dob');
				$UserEntry->email		   = Input::get('email');
				$UserEntry->address	   = Input::get('address');
				$UserEntry->contact       = Input::get('contact');
				$UserEntry->userrole		   = Input::get('user_role');
				date_default_timezone_set('Asia/Singapore');
				$date = date('Y-m-d h:i:s', time());
				$UserEntry->created_at		   = $date;
				$UserEntry->save();
	
				Session::flash('message', 'Successfully created users!');
				return Redirect::to('users');
			}
		}else{
			Session::flash('message', 'Passwords did not match!');
			return Redirect::to('users/create');
		}
	}
	public function save_edit()
	{
		$password = Input::get('password');
		$cfm_password =Input::get('cfm_password');
		if ($password == $cfm_password)
		{
			$rules = array(
				'first_name'     => 'required',
				'last_name'      => 'required'
			);
			$validator = Validator::make(Input::all(), $rules);
	
			if ($validator->fails()) {
				return Redirect::to('users/create')
					->withErrors($validator);
			} else {
				$UserEntry = UserEntry::find(Input::get('id'));
				$UserEntry->first_name       = Input::get('first_name');
				$UserEntry->last_name	   = Input::get('last_name');
				if ($password != ""){
					$UserEntry->password  = Hash::make($password);
				}
				$UserEntry->dob       = Input::get('dob');
				$UserEntry->email		   = Input::get('email');
				$UserEntry->address	   = Input::get('address');
				$UserEntry->contact       = Input::get('contact');
				$UserEntry->userrole		   = Input::get('user_role');
				date_default_timezone_set('Asia/Singapore');
				$date = date('Y-m-d h:i:s', time());
				$UserEntry->updated_at		   = $date;
				$UserEntry->save();
	
				Session::flash('message', 'Successfully created users!');
				return Redirect::to('users');
			}
		}else{
			Session::flash('message', 'Passwords did not match!');
			return Redirect::to('users/'.Input::get('id'));
		}
	}
	public function edit_user($id)
	{
		$user = UserEntry::find($id);
		$user_roles = DB::table('user_role')->get();
		 return View::make('users.edit')
            ->with('user', $user)
            ->with('user_roles', $user_roles);
	}
	
	public function delete_user()
	{
		$id = Input::get('id');
		DB::table('users')->where('id','=',$id)->delete();
		return Redirect::to('users');
	}
	public function delete_user_role()
	{
		$id = Input::get('id');
		DB::table('user_role')->where('id','=',$id)->delete();
		return Redirect::to('users/roles');
	}
}
?>