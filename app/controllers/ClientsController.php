<?php

class ClientsController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$this->layout->content =  View::make('clients.create');	
	}
	public function fancy_create_form()
	{
		return  View::make('clients.fancycreate');	
	}
	public function show_clients()
	{
		$clients = DB::table('clients')->orderBy('id','desc')->get();
		$this->layout->content =  View::make('clients.manage')->with('clients',$clients);	
	}
	
	public function getaddress()
	{
		$delivery_address= DB::table('clients')->where('id','=',Input::get('id'))->pluck('delivery_address');
		
		
		return Response::json($delivery_address);
	}
	public function store()
	{
		
		$rules = array(
			'first_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('clients/create')
				->withErrors($validator);
		} else {
			$ClientEntry = new ClientEntry;
			$ClientEntry->salutation       = Input::get('salutation');
			$ClientEntry->first_name       = Input::get('first_name');
			$ClientEntry->last_name	   = "";
			
			$ClientEntry->salutation       = Input::get('salutation');
			$ClientEntry->organization	   = Input::get('organization');
			$ClientEntry->mobile_contact       = Input::get('mobile_contact');
			$ClientEntry->email		   = Input::get('email');
			$ClientEntry->billing_address	   = Input::get('billing_address');
			$ClientEntry->delivery_address       = Input::get('delivery_address');
			$ClientEntry->remarks		   = Input::get('remarks');
			$ClientEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$ClientEntry->created_at		   = $date;
			$ClientEntry->updated_at		   = $date;
			$ClientEntry->save();

			return Redirect::to('clients');
		}
		
	}
	public function fancystore()
	{
		
		$rules = array(
			'first_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('clients/create')
				->withErrors($validator);
		} else {
			$ClientEntry = new ClientEntry;
			$ClientEntry->salutation       = Input::get('salutation');
			$ClientEntry->first_name       = Input::get('first_name');
			$ClientEntry->last_name	   = "";
			$ClientEntry->organization	   = Input::get('organization');
			
			$ClientEntry->mobile_contact       = Input::get('mobile_contact');
			$ClientEntry->email		   = Input::get('email');
			$ClientEntry->billing_address	   = Input::get('billing_address');
			$ClientEntry->delivery_address       = Input::get('delivery_address');
			$ClientEntry->remarks		   = Input::get('remarks');
			$ClientEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$ClientEntry->created_at		   = $date;
			$ClientEntry->save();

			return View::make('utilities.fancy')->with('id',DB::getPdo()->lastInsertId())->with('name',Input::get('first_name'));
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'first_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('clients/create')
				->withErrors($validator);
		} else {
			$ClientEntry = ClientEntry::find(Input::get('id'));
			$ClientEntry->salutation       = Input::get('salutation');
			$ClientEntry->first_name       = Input::get('first_name');
			$ClientEntry->last_name	   = "";
			$ClientEntry->organization	   = Input::get('organization');
			
			$ClientEntry->mobile_contact       = Input::get('mobile_contact');
			$ClientEntry->email		   = Input::get('email');
			$ClientEntry->billing_address	   = Input::get('billing_address');
			$ClientEntry->delivery_address       = Input::get('delivery_address');
			$ClientEntry->remarks		   = Input::get('remarks');
			$ClientEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$ClientEntry->updated_at		   = $date;
			$ClientEntry->save();

			return Redirect::to('clients');
		}
	}
	public function edit_client($id)
	{
		$clients = ClientEntry::find($id);
		 return View::make('clients.edit')
            ->with('client', $clients);
	}
	public function view_client($id)
	{
		$clients = ClientEntry::find($id);
		 return View::make('clients.view')
            ->with('client', $clients);
	}
	
	public function delete_client()
	{
		$id = Input::get('id');
		DB::table('clients')->where('id','=',$id)->delete();
		return Redirect::to('clients');
	}
}
?>