<?php

class StoreTypeController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$layout = "layouts.store";
		$this->layout->content =  View::make('store_type.create');	
	}
	public function fancy_create_form()
	{
		return  View::make('store_type.fancycreate');	
	}
	public function show_store_type()
	{
		$store_type = DB::table('store_type')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('store_type.manage')->with('store_type',$store_type);	
	}
	public function store()	{
		
		$rules = array(
			'store_type'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('store_type/create')
				->withErrors($validator);
		} else {
			$StoreTypeEntry = new StoreTypeEntry;
			$StoreTypeEntry->store_type      	   = Input::get('store_type');
			$StoreTypeEntry->updated_by		       = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StoreTypeEntry->created_at		   = $date;
			$StoreTypeEntry->updated_at		   = $date;
			$StoreTypeEntry->save();

			return Redirect::to('store_type');			
		}
		
	}
	public function fancystore()
	{
		
		$rules = array(
			'store_type'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('store_type/create')
				->withErrors($validator);
		} else {
			$StoreTypeEntry = new StoreTypeEntry;
			$StoreTypeEntry->store_type      	   = Input::get('store_type');
			$StoreTypeEntry->updated_by		       = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StoreTypeEntry->created_at		   = $date;
			$StoreTypeEntry->updated_at		   = $date;
			$StoreTypeEntry->save();

			//return Redirect::to('store_type');	
			return View::make('utilities.fancy')->with('id',DB::getPdo()->lastInsertId())->with('name',Input::get('store_type'));		
		}
	}
	public function save_edit()
	{
		$rules = array(
			'store_type'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('store_type/edit')
				->withErrors($validator);
		} else {
			$StoreTypeEntry = StoreTypeEntry::find(Input::get('id'));
			$StoreTypeEntry->store_type     	   = Input::get('store_type');
			$StoreTypeEntry->updated_by		= Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StoreTypeEntry->updated_at		 = $date;
			$StoreTypeEntry->save();

			return Redirect::to('store_type');
		}
	}
	public function edit_store_type($id)
	{
		$store_type = StoreTypeEntry::find($id);
		 return View::make('store_type.edit')
            ->with('store_type', $store_type);
	}
	public function view_store_type($id)
	{
		$store_type = StoreTypeEntry::find($id);
		 return View::make('store_type.view')
            ->with('store_type', $store_type);
	}
	public function delete_store_type()
	{
		$id = Input::get('id');
		DB::table('store_type')->where('id','=', $id)->delete();
		return Redirect::to('store_type');
	}
	
}
?>