<?php

class StoreController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$layout = "layouts.store";
		$store_type = DB::table('store_type')->orderBy('id','desc')->get();
		$this->layout->content =  View::make('store.create')->with('store_type',$store_type);	
	}
	public function show_store()
	{
		$store = DB::table('store')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('store.manage')->with('store',$store);	
	}
	public function store()	{
		
		$rules = array(
			'store_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('store/create')
				->withErrors($validator);
		} else {
			$StoreEntry = new StoreEntry;
			$StoreEntry->store_name      	   = Input::get('store_name');
			$StoreEntry->store_type     	   = Input::get('store_type');
			$StoreEntry->store_description     = Input::get('store_description');
			$StoreEntry->store_address     	   = Input::get('store_address');
			$StoreEntry->remark     	   	   = Input::get('remark');
			$StoreEntry->status	   	   		   = 1;
			$StoreEntry->updated_by		       = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StoreEntry->created_at		   = $date;
			$StoreEntry->updated_at		   = $date;
			$StoreEntry->save();

			return Redirect::to('store');			
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'store_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('store/edit')
				->withErrors($validator);
		} else {
			$StoreEntry = StoreEntry::find(Input::get('id'));
			$StoreEntry->store_name      	   = Input::get('store_name');
			$StoreEntry->store_type     	   = Input::get('store_type');
			$StoreEntry->store_description     = Input::get('store_description');
			$StoreEntry->store_address     	   = Input::get('store_address');
			$StoreEntry->remark     	   	   = Input::get('remark');
			$StoreEntry->status	   	   		   = 1;
			$StoreEntry->updated_by		= Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$StoreEntry->updated_at		 = $date;
			$StoreEntry->save();

			return Redirect::to('store');
		}
	}
	public function edit_store($id)
	{
		$store = StoreEntry::find($id);
		$store_type = DB::table('store_type')->orderBy('created_at','desc')->get();
		 return View::make('store.edit')->with('store', $store)->with('store_type',$store_type);
	}
	public function view_store($id)
	{
		$store = StoreEntry::find($id);
		 return View::make('store.view')
            ->with('store', $store);
	}
	public function delete_store()
	{
		$id = Input::get('id');
		DB::table('store')->where('id','=', $id)->delete();
		return Redirect::to('store');
	}
	public function enable_store()
	{
		$id = Input::get('id');
		DB::table('store')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('store');
	}
	public function disable_store()
	{
		$id = Input::get('id');
		DB::table('store')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('store');
	}
	
}
?>