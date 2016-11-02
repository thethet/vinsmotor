<?php

class ProductStatusController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function show_productstatus(){	
		$product_status = ProductStatusEntry::get();
		$product = ProductEntry::whereRaw('quantity = min_product_qty')->get();
		$this->layout->content = View::make('product_status.manage')->with('product_status',$product_status)->with('products',$product);
	}
		
}
?>