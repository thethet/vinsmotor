<?php

class StaffsController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$this->layout->content =  View::make('staffs.create');	
	}
	public function fancy_create_form()
	{
		return  View::make('staffs.fancycreate');	
	}
	public function show_staffs()
	{
		$staffs = DB::table('staffs')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('staffs.manage')->with('staffs',$staffs);	
	}
	public function store()
	{
		
		$rules = array(
			'name'     => 'required',
			'contact'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('staffs/create')
				->withErrors($validator);
		} else {
			$StaffEntry = new StaffEntry;
			$StaffEntry->name       = Input::get('name');
			$StaffEntry->contact       = Input::get('contact');
			$StaffEntry->email		   = Input::get('email');
			$StaffEntry->address	   = Input::get('address');
			$StaffEntry->remarks		   = Input::get('remarks');
			$StaffEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StaffEntry->created_at		   = $date;
			$StaffEntry->updated_at		   = $date;
			$StaffEntry->save();

			return Redirect::to('staffs');
		}
		
	}
	public function fancystore()
	{
		
		$rules = array(
			'name'     => 'required',
			'contact'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('staffs/create')
				->withErrors($validator);
		} else {
			$StaffEntry = new StaffEntry;
			$StaffEntry->name       = Input::get('name');
			$StaffEntry->contact       = Input::get('contact');
			$StaffEntry->email		   = Input::get('email');
			$StaffEntry->address	   = Input::get('address');
			$StaffEntry->remarks		   = Input::get('remarks');
			$StaffEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StaffEntry->created_at		   = $date;
			$StaffEntry->save();

			return View::make('utilities.fancy')->with('id',DB::getPdo()->lastInsertId())->with('name',Input::get('first_name')." ".Input::get('last_name'));
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'name'     => 'required',
			'contact'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('staffs/create')
				->withErrors($validator);
		} else {
			$StaffEntry = StaffEntry::find(Input::get('id'));
			$StaffEntry->name       = Input::get('name');
			$StaffEntry->contact       = Input::get('contact');
			$StaffEntry->email		   = Input::get('email');
			$StaffEntry->address	   = Input::get('address');
			$StaffEntry->remarks		   = Input::get('remarks');
			$StaffEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StaffEntry->updated_at		   = $date;
			$StaffEntry->save();

			return Redirect::to('staffs');
		}
	}
	public function edit_staff($id)
	{
		$staffs = StaffEntry::find($id);
		 return View::make('staffs.edit')
            ->with('staff', $staffs);
	}
	public function view_staff($id)
	{
		$staffs = StaffEntry::find($id);
		 return View::make('staffs.view')
            ->with('staff', $staffs);
	}
	
	public function delete_staff()
	{
		$id = Input::get('id');
		DB::table('staffs')->where('id','=',$id)->delete();
		return Redirect::to('staffs');
	}
}
?>