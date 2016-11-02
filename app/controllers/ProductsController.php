<?php



class ProductsController extends BaseController {

	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	protected $layout = "layouts.main";

	public function create_form()
	{
		$layout 				= "layouts.products";
		$suppliers 				= DB::table('suppliers')->get();
		$product_category 		= DB::table('products_category')->get();
		$store 					= DB::table('store')->get();
		$company 				= DB::table('middlemen')->get();
		$this->layout->content 	=  View::make('products.create')->with('suppliers',$suppliers)->with('product_category',$product_category)->with('store',$store)->with('company',$company);
	}

	public function show_products()
	{
		/*$table = Datatable::table()
		  ->addColumn('Company','Product Code', 'Product Name', 'Cost Price', ' Selling Price','Quantity','Actions')
		  ->setUrl(route('api.products'))
		  ->noScript();
		$this->layout->content = View::make('products.manage', array('table' => $table));*/
		$products 				= DB::table('products')->orderBy('id','DESC')->get();
		$this->layout->content 	=  View::make('products.manage')->with('products',$products);
	}

	public function getProductsDataTable()
	{
		$query 	= ProductEntry::select('id','company_id','product_itemno', 'product_name', 'unit_price', 'selling_price','quantity','min_product_qty','created_at','updated_at')->orderBy('id','desc')->get();
		$i 		= 0;
		return Datatable::collection($query)
			->addColumn('company_id', function($model){
				$company =	MiddlemenEntry::where('id','=',$model->company_id)->first();
				return $company->first_name;
			})
			->addColumn('product_itemno', function($model){
				return $model->product_itemno;
			})
			->addColumn('product_name', function($model){
				return $model->product_name;
			})
			->addColumn('unit_price', function($model){
				return $model->unit_price;
			})
			->addColumn('selling_price', function($model){
				return $model->selling_price;
			})
			->addColumn('quantity', function($model){
				$available_qty = $model->quantity;
				return $available_qty;
			})
			->addColumn('actions', function($model){
				$checkinquo = QuotationItemEntry::where('id','=',$model->id)->count();
				$html = '
                        <a class="edit_btn" href="products/'.$model->id.'"> <i class="fa fa-pencil"></i> </a>
						<a class="view_btn" href="products/view/'.$model->id.'"><i class="fa fa-eye"></i></a>
			    		<form action="products/delete_product" method="post" class="formdel" id="formdel"><input type="hidden" name="id" value="'.$model->id.'">
						<button type="submit" class="formdel del_btn"><i class="fa fa-trash"></i> </button></form>';
				return $html;
			})
			->searchColumns('company_id','product_name', 'product_itemno','unit_price','selling_price','created_at','status','updated_at')
			->orderColumns('company_id','product_name', 'product_itemno','unit_price','selling_price','created_at','status','updated_at')
			->make();
	}

	public function store()
	{
		$rules = array(
			'name'     			=> 'required',
			'selling_price' 	=> 'required'
			//'product_itemno' => 'unique:products',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('products/create')
				->withErrors($validator);
		} else {
			function getExtension($str) {
			   $i = strrpos($str,".");
			   if (!$i) { return ""; }
			   $l 	= strlen($str) - $i;
			   $ext = substr($str,$i+1,$l);
			   return $ext;
			}
			$image = $_FILES['photo']['name'];
			if($image)
			{
				$filename 	= stripslashes($image);
				$extension 	= getExtension($filename);
				$extension 	= strtolower($extension);

				if($extension == "jpg" || $extension == "png" || $extension== "gif"){
					$imgname 	= rand().time();
					$image_name = $imgname.'.'.$extension;
					$newpath 	= public_path()."/img/".$image_name;
					$copied 	= copy($_FILES['photo']['tmp_name'], $newpath);

					if (!$copied)
					{
						return Redirect::to('products');
					} else {
						$get_photo = $image_name;
					}
				} else {
					return Redirect::to('products');
				}
			} else{
				$get_photo = "";
			}
			// $itemno 							= preg_replace('/[^\\w]+/', '-', Input::get('product_itemno'));

			$ProductEntry 						= new ProductEntry;
			$ProductEntry->product_itemno  		= Input::get('itemno');
			$ProductEntry->product_name    		= Input::get('name');
			$ProductEntry->product_description 	= Input::get('description');
			$ProductEntry->company_id   		= Input::get('company');
			$ProductEntry->selling_price   		= Input::get('selling_price');
			$ProductEntry->unit_price	   		= Input::get('unit_price');
		    $ProductEntry->measurements    		= Input::get('width').";".Input::get('height').";".Input::get('depth');
			$ProductEntry->supplier		   		= Input::get('supplier');
			$ProductEntry->product_catid   		= Input::get('pro_cat');
			// $ProductEntry->weight         		= Input::get('weight');
			$ProductEntry->weight          		= '120';
			$ProductEntry->quantity        		= Input::get('quantity');
			$ProductEntry->min_product_qty 		= Input::get('min_product_qty');
			$ProductEntry->pro_photos      		= $get_photo;
			$ProductEntry->store_id    	  		= Input::get('store');
			$ProductEntry->pro_remark     		= Input::get('remark');
			$ProductEntry->updated_by	   		= Auth::user()->id;
			date_default_timezone_set('Asia/Singapore');
			$date 								= date('Y-m-d h:i:s', time());
			$ProductEntry->created_at		   	= $date;
			$ProductEntry->updated_at		   	= $date;
			$ProductEntry->save();
			return Redirect::to('products');
		}
	}

	public function import_products()
	{
        $rules = array(
        	'file' => 'required',
        );
	    $validator = Validator::make(Input::all(), $rules);
	    if($validator->fails())
	    {
	       return Redirect::to('/products/create');
	    } else {
	    	$f 					= Input::get('file');
	    	date_default_timezone_set('Asia/Singapore');
			$date 				= date('Y-m-d h:i:s', time());
			$file 				= Input::file('file');
			$file 				= Input::file('file');
		    $destinationPath 	= base_path() .'/images/excel_sheet/';
		    $new_file_name 		= time().".xlsx";
		    $filename   		= str_replace(' ', '_', $new_file_name);
		    $file->move($destinationPath, $filename);
            $aa 				= $destinationPath.$filename;

	    	if (Input::hasFile('file')) {
		        Excel::load($aa, function($reader) {
		        	$results 	= $reader->get();
		        	Session::put('pro_arr', $results);
		        	$sheetTitle = $reader->first();

		        	if(isset($sheetTitle['id']) && isset($sheetTitle['product_name']) && isset($sheetTitle['unit_price']) && isset($sheetTitle['selling_price']) && isset($sheetTitle['measurements'])) {
				    	if($sheetTitle['id'] != "" && $sheetTitle['product_name']  !="" && $sheetTitle['unit_price']  !="" && $sheetTitle['selling_price']  !="" && $sheetTitle['measurements']  !="") {
				    		Session::put('exist_record', 0);
				    	} else {
				    		Session::put('exist_record', 1);
				    	}
				    } else{
				    	Session::put('exist_record', 1);
				    }

				    $keep_proid = array();
				    foreach($results as $sheet) {
				    	if($sheet->id != "" && $sheet->product_name !=""  && $sheet->unit_price  !="" && $sheet->selling_price !=""  && $sheet->measurements  !="") {
				    		Session::put('exist_record', 0);
				    		array_push($keep_proid,$sheet->id);
				    		if (is_numeric($sheet->unit_price) && is_numeric($sheet->selling_price)) {
				    			Session::put('exist_record', 0);
				    		} else {
				    			Session::put('exist_record', 1);
				    		}
				    	} else{
				    		Session::put('exist_record', 1);
				    	}
				    }
				    $getid = Session::get('exist_record');
				    if($getid == 0){
				    	Session::put('proid', $keep_proid);
				    }
				});

				$getid = Session::get('exist_record');
				if($getid == 1) {
					return Redirect::to('/products/create');
				} else {
					$arr 		= Session::get('proid');
					$arr1 		=  array_unique($arr);
					$arr_count 	= count($arr);
					$arr1_count	= count($arr1);
					if($arr_count == $arr1_count) {
						Session::put('exist_record', 0);
						foreach(Session::get('pro_arr') as $sheet) {
							$ProductEntry 					= new ProductEntry;
							$ProductEntry->id       		= $sheet->id;
							$ProductEntry->product_name     = $sheet->product_name;
							$ProductEntry->selling_price	= $sheet->selling_price;
							$ProductEntry->unit_price	    = $sheet->unit_price;
						    $ProductEntry->measurements     = $sheet->measurements;
							$ProductEntry->updated_by		= Auth::user()->id;
							date_default_timezone_set('Asia/Singapore');
							$date 							= date('Y-m-d h:i:s', time());
							$ProductEntry->created_at		= $date;
							$ProductEntry->updated_at		= $date;
							$ProductEntry->save();
							return Redirect::to('/products');
						}
					} else {
						Session::put('exist_record', 1);
					}

					$getid = Session::get('exist_record');
					if($getid == 1){
						return Redirect::to('/products/create');
					}
				}
			} else{
				return Redirect::to('/products/create');
			}
	    	exit();
	    }
	}

	public function save_edit()
	{
		$rules = array(
			'selling_price' 	 => 'required',
			'name' 				 => 'required',
			'itemno' 			 => 'required',
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('/products/'.Input::get('id'))
				->withErrors($validator);
		} else {
			function getExtension($str) {
				$i 		= strrpos($str,".");
				if (!$i) { return ""; }
				$l 		= strlen($str) - $i;
				$ext 	= substr($str,$i+1,$l);
				return $ext;
			}
			$ProductEntry 	= new ProductEntry;
			$image 			= $_FILES['photo']['name'];
			if($image) {
				//$unlink_existing_image = $ProductEntry->pro_photos;
				//unlink(public_path()."/img/".$unlink_existing_image);
				$filename 	= stripslashes($image);
				$extension 	= getExtension($filename);
				$extension 	= strtolower($extension);
				if($extension == "jpg" || $extension == "png" || $extension== "gif") {
					$imgname 	= rand().time();
					$image_name	= $imgname.'.'.$extension;
					$newpath 	= public_path()."/img/".$image_name;
					$copied 	= copy($_FILES['photo']['tmp_name'], $newpath);
					if (!$copied) {
						return Redirect::to('products');
					} else {
						$get_photo = $image_name;
					}
				} else {
					return Redirect::to('products');
				}
			}

			$ProductEntry 		= ProductEntry::find(Input::get('id'));
			$get_status_count 	= ProductStatusEntry::where('pro_id','=',Input::get('id'))->count();
			$new_stocked_qty 	= Input::get('quantity');
			if($get_status_count > 0) {
				$get_status = ProductStatusEntry::where('pro_id','=',Input::get('id'))->get();
				foreach ($get_status as $key => $value) {
					if($new_stocked_qty > $value->required_qty) {
						$new_qty_val 		= $new_stocked_qty - $value->required_qty;
						ProductStatusEntry::where('pro_id', '=', Input::get('id'))->delete();
						$new_stocked_qty 	= $new_qty_val;
					} else if($value->required_qty > $new_stocked_qty) {
						$new_qty_val = $value->required_qty - $new_stocked_qty;
					}
					Session::put('min_qty', $value->min_product_qty);
				}
			}

			if(Session::get('min_qty') > $new_stocked_qty) {
				$require_qty = Session::get('min_qty') - $new_stocked_qty;
				$ProductStatusController 				= new ProductStatusEntry();
				$ProductStatusController->pro_id 		= Input::get('id');
				$ProductStatusController->required_qty 	= $require_qty;
				date_default_timezone_set('Asia/Singapore');
				$date 									= date('Y-m-d H:i:s', time());
				$ProductStatusController->created_at	= $date;
				$ProductStatusController->updated_by	= Auth::user()->id;
				$ProductStatusController->save();
			}
			$ProductEntry->product_itemno 		= Input::get('itemno');
			$ProductEntry->product_name   		= Input::get('name');
			$ProductEntry->product_description 	= Input::get('description');
			$ProductEntry->selling_price  		= Input::get('selling_price');
			$ProductEntry->unit_price	  		= Input::get('unit_price');
			$ProductEntry->measurements   		= Input::get('width').";".Input::get('height').";".Input::get('depth');
			$ProductEntry->supplier		  		= Input::get('supplier');
			$ProductEntry->product_catid  		= Input::get('pro_cat');
			// $ProductEntry->weight         		= Input::get('weight');
			$ProductEntry->weight         		= '120';
			$ProductEntry->quantity       		= Input::get('quantity');
			$ProductEntry->min_product_qty 		= Input::get('min_product_qty');
			$ProductEntry->company_id   		= Input::get('company');
			if($image)
			{
				$ProductEntry->pro_photos      = $get_photo;
			}
			$ProductEntry->store_id    	  	= Input::get('store');
			$ProductEntry->pro_remark     	= Input::get('remark');
			$ProductEntry->updated_by	  	= Auth::user()->id;
			date_default_timezone_set('Asia/Singapore');
			$date 							= date('Y-m-d h:i:s', time());
			$ProductEntry->updated_at		= $date;
			$ProductEntry->save();
			return Redirect::to('products');
		}
	}

	public function edit_product($id)
	{
		$suppliers 			= DB::table('suppliers')->get();
		$product_category 	= DB::table('products_category')->get();
		$store 				= DB::table('store')->get();
		$company 			= DB::table('middlemen')->get();
		$products 			= ProductEntry::find($id);
		return View::make('products.edit')
            ->with('product', $products)
            ->with('suppliers',$suppliers)
            ->with('product_category',$product_category)
            ->with('store',$store)
            ->with('company',$company);
	}

	public function view_product($id)
	{
		$suppliers 	= DB::table('suppliers')->get();
		$products 	= ProductEntry::find($id);
		return View::make('products.view')
            ->with('product', $products)
            ->with('suppliers',$suppliers);
	}

	public function delete_product()
	{
		$id = Input::get('id');
		DB::table('products')->where('id', 'LIKE', '%'.$id.'%')->delete();
		return Redirect::to('products');
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
