<?php

class ProductsCategoryController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$layout = "layouts.product_category";
		$this->layout->content =  View::make('product_category.create');	
	}
	public function show_productcategory()
	{
		$product_category = DB::table('products_category')->orderBy('created_at','desc')->get();
		$this->layout->content =  View::make('product_category.manage')->with('product_category',$product_category);	
	}
	public function store()	{
		
		$rules = array(
			'cat_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('product_category/create')
				->withErrors($validator);
		} else {
			$ProductCategoryEntry = new ProductCategoryEntry;
			$ProductCategoryEntry->cat_name      	   = Input::get('cat_name');
			$ProductCategoryEntry->cat_status	   	   = 1;
			$ProductCategoryEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$ProductCategoryEntry->created_at		   = $date;
			$ProductCategoryEntry->updated_at		   = $date;
			$ProductCategoryEntry->save();

			return Redirect::to('product_category');			
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'cat_name'     => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('product_category/edit')
				->withErrors($validator);
		} else {
			$ProductCategoryEntry = ProductCategoryEntry::find(Input::get('id'));
			$ProductCategoryEntry->cat_name      	= Input::get('cat_name');
			$ProductCategoryEntry->updated_by		= Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d h:i:s', time());
			$ProductCategoryEntry->updated_at		 = $date;
			$ProductCategoryEntry->save();

			return Redirect::to('product_category');
		}
	}
	public function edit_productcategory($id)
	{
		$product_category = ProductCategoryEntry::find($id);
		 return View::make('product_category.edit')
            ->with('product_category', $product_category);
	}
	public function view_productcategory($id)
	{
		$product_category = ProductCategoryEntry::find($id);
		 return View::make('product_category.view')
            ->with('product_category', $product_category);
	}
	public function delete_productcategory()
	{
		$id = Input::get('id');
		DB::table('products_category')->where('id','=', $id)->delete();
		return Redirect::to('product_category');
	}
	public function enable_product()
	{
		$id = Input::get('id');
		DB::table('products')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('products');
	}
	public function disable_product()
	{
		$id = Input::get('id');
		DB::table('products')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('products');
	}
	
}
?>