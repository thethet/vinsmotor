<?php



class SuppliersController extends BaseController {

	/**
	*
	* Display a listing of the resource.
	*
	*
	*
	* @return Response
	*
	*/
	protected $layout = "layouts.main";

	public function create_form()
	{
		$user_roles 			= DB::table('user_role')->get();
		$this->layout->content 	=  View::make('suppliers.create')->with('user_roles',$user_roles);
	}

	public function fancy_create_form()
	{
		$user_roles = DB::table('user_role')->get();
		return  View::make('suppliers.fancycreate')->with('user_roles',$user_roles);
	}

	public function show_suppliers()
	{
		$suppliers 				= DB::table('suppliers')->orderBy('id','desc')->get();
		$this->layout->content 	=  View::make('suppliers.manage')->with('suppliers',$suppliers);
	}

	public function getcontacts()
	{
		$supplier_contacts 	= DB::table('supplier_contacts')->where('supplier_id','=',Input::get('id'))->get();
		$json 				= "";
		foreach ($supplier_contacts as $key => $value)
		{
			$json = $json.$value->id.";".$value->name.";";
		}
		return Response::json($json);
	}

	public function store()
	{
		$rules = array(
			'supplier_name'     => 'required',
			'delivery_address' 	=> 'required',
			'billing_address' 	=> 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('suppliers/create')->withErrors($validator);
		} else {
			$db = DB::table('suppliers')->where('supplier_name','=',Input::get('supplier_name'))->count();
			if ($db > 0) {
				return Redirect::to('suppliers/create')->with('error',1);
			}

			$SupplierEntry 						= new SupplierEntry;
			$SupplierEntry->supplier_name       = Input::get('supplier_name');
			$SupplierEntry->delivery_address 	= Input::get('delivery_address');
			$SupplierEntry->billing_address	   	= Input::get('billing_address');
			$SupplierEntry->tel       			= Input::get('tel');
			$SupplierEntry->mobile       		= Input::get('mobile');
			$SupplierEntry->fax       			= Input::get('fax');
			$SupplierEntry->email       		= Input::get('email');
			$SupplierEntry->website       		= Input::get('website');
			$SupplierEntry->remarks		   		= Input::get('remarks');
			$SupplierEntry->updated_by		   	= Auth::user()->id;
			date_default_timezone_set('Asia/Singapore');
			$date 								= date('Y-m-d h:i:s', time());
			$SupplierEntry->created_at		   	= $date;
			$SupplierEntry->updated_at		   	= $date;
			$SupplierEntry->save();
			$lastid = DB::getPdo()->lastInsertId();

			/*for ($n = 0; $n < Input::get('cnt'); $n++) {
				$InvoiceItemEntry 				= new SupplierContactEntry;
				$InvoiceItemEntry->supplier_id 	= $lastid;
				$InvoiceItemEntry->name 		= Input::get('name'.$n);
				$InvoiceItemEntry->email	   	= Input::get('email'.$n);
				$InvoiceItemEntry->contact    	= Input::get('contact'.$n);
				$InvoiceItemEntry->save();
			}*/
			$count =count(Input::get('name'));
			for($i = 0; $i < $count; $i++) {
			if ((Input::get('email')[$i]!="")  || (Input::get('contact')[$i] != "")) {
				$InvoiceItemEntry 				= new SupplierContactEntry;
				$InvoiceItemEntry->supplier_id 	= $lastid;
				$InvoiceItemEntry->name	   		= Input::get('name')[$i];
				$InvoiceItemEntry->email	   	= Input::get('mail')[$i];
				$InvoiceItemEntry->contact    	= Input::get('contact')[$i];
				$InvoiceItemEntry->save();
			}
			}

			return Redirect::to('suppliers');
		}
	}

	public function fancystore()
	{
		$rules = array(
			'supplier_name' 	=> 'required',
			'delivery_address' 	=> 'required',
			'billing_address'	=> 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('suppliers/create')->withErrors($validator);
		} else {
			$SupplierEntry 						= new SupplierEntry;
			$SupplierEntry->supplier_name       = Input::get('supplier_name');
			$SupplierEntry->delivery_address	= Input::get('delivery_address');
			$SupplierEntry->billing_address	   	= Input::get('billing_address');
			$SupplierEntry->tel       			= Input::get('tel');
			$SupplierEntry->fax       			= Input::get('fax');
			$SupplierEntry->email       		= Input::get('email');
			$SupplierEntry->website       		= Input::get('website');
			$SupplierEntry->remarks		   		= Input::get('remarks');
			$SupplierEntry->updated_by		  	= Auth::user()->id;
			date_default_timezone_set('Asia/Singapore');
			$date 								= date('Y-m-d h:i:s', time());
			$SupplierEntry->created_at		   	= $date;
			$SupplierEntry->save();
			$lastid 							= DB::getPdo()->lastInsertId();
			for ($n = 0; $n < Input::get('cnt'); $n++) {
				if (!(Input::get('email'.$n)=="")  || !(Input::get('address'.$n) == "")) {
					$InvoiceItemEntry 				= new SupplierContactEntry;
					$InvoiceItemEntry->supplier_id 	= $lastid;
					$InvoiceItemEntry->name	   		= Input::get('name'.$n);
					$InvoiceItemEntry->email	   	= Input::get('email'.$n);
					$InvoiceItemEntry->contact      = Input::get('contact'.$n);
					$InvoiceItemEntry->save();
				}
			}
			return View::make('utilities.fancy')->with('id',$lastid)->with('name',Input::get('supplier_name'));
		}
	}

	public function save_edit()
	{
		//echo Input::get('cnt');exit();
		$rules = array(
			'supplier_name' 	=> 'required',
			'delivery_address' 	=> 'required',
			'billing_address'  	=> 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('suppliers/create')->withErrors($validator);
		} else {
			$SupplierEntry 						= SupplierEntry::find(Input::get('id'));
			$SupplierEntry->supplier_name       = Input::get('supplier_name');
			$SupplierEntry->delivery_address	= Input::get('delivery_address');
			$SupplierEntry->billing_address		= Input::get('billing_address');
			$SupplierEntry->tel       			= Input::get('tel');
			$SupplierEntry->mobile       		= Input::get('mobile');
			$SupplierEntry->fax       			= Input::get('fax');
			$SupplierEntry->email       		= Input::get('mail');
			$SupplierEntry->website       		= Input::get('website');
			$SupplierEntry->remarks		   		= Input::get('remarks');
			$SupplierEntry->updated_by		   	= Auth::user()->id;
			date_default_timezone_set('Asia/Singapore');
			$date 								= date('Y-m-d h:i:s', time());
			$SupplierEntry->updated_at		   	= $date;
			$SupplierEntry->save();
			
			DB::table('supplier_contacts')->where('supplier_id','=',Input::get('id'))->delete();
			
			/*for ($n = 0; $n <= Input::get('cnt'); $n++) {
				if ((Input::get('email'.$n)!="")  || (Input::get('contact'.$n) != "")) {
					$InvoiceItemEntry 				= new SupplierContactEntry;
					$InvoiceItemEntry->supplier_id 	= Input::get('id');
					$InvoiceItemEntry->name	   		= Input::get('name'.$n);
					$InvoiceItemEntry->email	   	= Input::get('email'.$n);
					$InvoiceItemEntry->contact    	= Input::get('contact'.$n);
					$InvoiceItemEntry->save();
				}
			}*/
			$count =count(Input::get('name'));
			for($i = 0; $i < $count; $i++) {
			if ((Input::get('email')[$i]!="")  || (Input::get('contact')[$i] != "")) {
				$InvoiceItemEntry 				= new SupplierContactEntry;
				$InvoiceItemEntry->supplier_id 	= Input::get('id');
				$InvoiceItemEntry->name	   		= Input::get('name')[$i];
				$InvoiceItemEntry->email	   	= Input::get('email')[$i];
				$InvoiceItemEntry->contact    	= Input::get('contact')[$i];
				$InvoiceItemEntry->save();
			}
			}
			
			
			return Redirect::to('suppliers');
		}
	}

	public function edit_supplier($id)
	{
		$suppliers = SupplierEntry::find($id);
		return View::make('suppliers.edit')
            ->with('supplier', $suppliers)
            ->with('id',$id);
	}

	public function view_supplier($id)
	{
		$suppliers = SupplierEntry::find($id);
		return View::make('suppliers.view')
            ->with('supplier', $suppliers)
            ->with('id',$id);
	}

	public function delete_supplier()
	{
		$id = Input::get('id');
		DB::table('suppliers')->where('id','=',$id)->delete();
		return Redirect::to('suppliers');
	}
}

?>