<?php
class PurchaseOrdersController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{ 
		$latestid = DB::table('purchase_orders')->orderby('date_created','desc')->pluck('showid');
		$latestid += 1;
		$aid = "PO";
		 for ($n = 0; $n < (5 - strlen($latestid)); $n++)
		 {
			 $aid .= "0";
		 }
		$aid .= $latestid;
		$po = DB::table('invoices')->get();
		$products = DB::table('products')->get();
		$unitPrice = DB::table('products')->lists('unit_price','id');
		$measurements = DB::table('products')->lists('measurements','id');
		$sellingprice = DB::table('products')->lists('selling_price','id');
		$suppliers = DB::table('suppliers')->get();
		$middlemens = DB::table('middlemen')->get();
		$this->layout->content =  View::make('purchase_orders.create')->with('aid',$aid)->with('measurements',$measurements)->with('invoices',$po)->with('suppliers',$suppliers)->with('middlemens',$middlemens)->with('products',$products)->with('unit_price',$unitPrice)->with('sellingprice',$sellingprice);	
	}
	public function pass_form()
	{
		$iid = Input::get('invoice_id');
		$po = DB::table('invoices')->find($iid);
		$po_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->lists('product_id');
		$inv_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->get();
		$products = DB::table('products')->whereIn('id',$po_items)->get();
		$measurements = DB::table('products')->lists('measurements','id');
		$unitPrice = DB::table('products')->whereIn('id',$po_items)->lists('unit_price','id');
		$suppliers = DB::table('suppliers')->get();
		$middlemens = DB::table('middlemen')->get();
		$deladdress = '648 Geylang Rd ,Singapore 389578';
		$this->layout->content =  View::make('purchase_orders.refercreate')->with('deladdress',$deladdress)->with('measurements',$measurements)->with('inv',$inv_items)->with('iid',$iid)->with('invoices',$po)->with('suppliers',$suppliers)->with('products',$products)->with('unit_price',$unitPrice);	
	}

	public function pass_form_fromproduct()
	{
		
		if(Input::get('pid') != 0){
			$iid = Input::get('pid');
			$get_product_status = ProductStatusEntry::where('pro_id','=',$iid)->first();
		}
		if(Input::get('id') != 0){
			$iid = Input::get('id');
			$get_product_status = array();
		}
		$get_product = DB::table('products')->where('id','=',$iid)->get();
		$this->layout->content =  View::make('purchase_orders.refercreatep')->with('products',$get_product)->with('productstatus',$get_product_status);
	}

	public function show_purchase_orders()
	{
		$purchase_orders = DB::table('purchase_orders')->orderBy('showid','DESC')->get();
		$this->layout->content =  View::make('purchase_orders.manage')->with('purchase_orders',$purchase_orders);	
	}
	public function delete_po()
	{
	}
	public function download_po()
	{
		$id = Input::get('id');
		$aid = "PO";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $aid .= "0";
		 }
		 $aid .= $id;
		$poitems = DB::table('po_items')->where('po_id','=',$id)->get();
		$pocount = DB::table('po_items')->where('po_id','=',$id)->count();

		$po = POEntry::find($id);
		$id = $po->invoice_id;
		
		$pid = "PO";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $pid .= "0";
		 }
		 $pid .= $id;
		$items = "";
		$invoiceidet = "";
			$invoiceid = "";$client_address = "---";$client_contact ="---";
		if ($id != -1)
		{
			$invoiceidet = "Invoice No.";
			$invoiceid .= $pid;
			
			$cid = InvoiceEntry::where('id','=',$id)->pluck('client_id');
			/*$client_address = ClientEntry::where('id','=',$cid)->pluck('delivery_address');
			$client_contact = ClientEntry::where('id','=',$cid)->pluck('mobile_contact');*/
			$client_address = MiddlemenEntry::where('id','=',$cid)->pluck('address');
			$client_contact = MiddlemenEntry::where('id','=',$cid)->pluck('mobile_contact');
		}
		else{
		    $cid = 0;
		}

		$n = 1;
		$m = 0;

		if ($cid != -1)
		{
			$extraline = 11;
		}
		else{
			$extraline = 12;
		}
		foreach ($poitems as $key =>$value)
		{
			if($extraline == $m || $pocount == $n){
				$addborder = "class='bot_border_style'";
			}
			else{
				$addborder = "";
			}
			$dec = "";
			if($dec == ""){
				$dec = "&nbsp;";
			}
			else{
				$dec = $value->description;
			}

			if ($value->product_id != -1){
			$items = $items."<tr><td style='padding:0;margin:0'><table width='720px' border='0' cellpadding='0' cellspacing='0' style='margin-left:1px;'><tr class='border-pro'><td width='40px' class='border-pro' style='height:55px;'><div style='text-align:center;'>".$n++."</div></td><td style='text-align:left;padding-left:10px;width:250px;' class='border-pro'>".$value->product_name."</td><td style='text-align:left;padding-left:10px;width:90px;' class='border-pro'> ".$value->quantity."</td><td width='90px' class='align_center border-pro'>".$value->unit_price."</td><td width='90px' class='align_center border-pro'>".$value->buying_price."</td><td style='width:164px;text-align:center' class='align_center border-pro'><div style='float:right;text-align:center;'>".sprintf ("%.2f", $value->quantity*$value->buying_price)."</div></td></tr></table></td></tr></tr><tr><td style='margin:0;padding:0;' ".$addborder."></td></tr>";
			}
			 $m++;
			 if($m > $extraline){
				$m = 0;
			 }
		}
		
		$profile = DB::table('companyprofile')->first();

		$reg_no = DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('reg_no');
		$photo = DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('photo');

		$get_delivery_address =  DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('address');

		if(isset($photo) && $photo != ""){
			$logo_url = $_SERVER["DOCUMENT_ROOT"] . '/bootstrap/img/'.$photo;
		}else{
			$logo_url = $_SERVER["DOCUMENT_ROOT"] . '/images/no_logo.jpg';
		}

		$company_name = DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('first_name');

		$pdf = App::make('dompdf');date_default_timezone_set('UTC');			

		// Prints something like: Monday
		$date =	 date("d/m/Y");
		$aftGST = $po->total_price+($po->total_price * 0.07);
		$contactto = " ---";
		$billedto = DB::table('suppliers')->where('id','=',$po->supplier_id)->first();
		if (isset($billedto))
		{	
			$spacontact = DB::table('supplier_contacts')->where('supplier_id','=',$billedto->id)->count();
			$contactto = $billedto->supplier_name;
		}
		else
			$spacontact = 0;
		if ($spacontact == 0)
		{
			$spcontact = new stdClass();
			$spcontact->name = "N/A";
			$spcontact->contact = "N/A";
			$spcontact->address = "N/A";
		}
		else
			$spcontact = DB::table('supplier_contacts')->where('supplier_id','=',$billedto->id)->first();
		
		if ($po->attn_to != "")
		{
			$attn_to = DB::table('supplier_contacts')->where('id','=',$po->attn_to)->pluck('name');	
		}
		else
			$attn_to = "---";
		$buildhTML = '<html><head>
							  <style>
							  body, html{
									margin:0px;
									padding:0px;
								}
								@page {
									margin: 80px 60px 30px 30px !important;
								}
							    .footer { width:720px;height:300px;}
							      body, table{font-weight: bold; font-size:12px;padding:0;margin:0;}.nobreak{page-break-inside:avoid !important;}.full{width: 100%;}.terms, .Remarks{font-size: 0.8em;}.thirty{width: 30%;}.twenty{width: 20%;}.bold{font-weight: 700;}.right{text-align: right;}h2{margin: 5px;}.border{border: 1px solid #222; border-collapse: collapse; text-align: center;}.underlines{text-decoration: underline;}.taxinvoiceheader{border: 1px solid #222;  background: #AAA; height:35px; text-align: center; width: 30%; font-size: 25px; font-weight: 700;}.taxinvoicebody{border: 1px solid #222; width: 100%; font-size: 17px;padding-top:10px;}
							      .border_style{
							      	border:1px solid #000;
							      	text-align:center;
							      }.bot_border_style{background:#000;border-bottom:1px solid #000;}.padd_add{padding-left:10px;}.padd_add_full{padding:10px 10px 10px 0;}
							      .align_center{text-align:center;}.align_right{text-align:right;}.border-pro{border-left:1px solid #000;border-right:1px solid #000;}
							      thead,tfoot{font-size:12px;}
							  </style>
							</head>
							<body>			  
							     <table cellspacing="0" cellspacing="0" border="0"  width="720px"><tr><th><table class="full" border="0" cellpadding="0" cellspacing="0"> <tr> <td class="thirty" style="text-align:center"> <img src="'.$logo_url.'" style="max-width:150px"> <br>Co Reg No : '.$reg_no.'</td><td><div style="width:300px;padding-left:200px !important;"><h2 style="margin-left:0px;">'.$company_name.'</h2><br/></div></td></tr></table>
							    <div class="taxinvoiceheader">Purchase Order</div><div class="taxinvoicebody"> <table class="full bold" rules="cols" width="720px" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="width:80px" class="padd_add">To</td><td style="width:330px;">: '.$contactto.'</td><td style="width:120px" class="padd_add">Purchase Order No</td><td width="160px">: '.$po->purchase_order_no.'</td></tr><tr> <td class="padd_add">Attn to </td><td>: '.$attn_to.'</td><td class="padd_add">Ref No</td><td>: '.$invoiceid.'</td></tr><tr> <td class="padd_add">Delivery To</td><td>: '.$get_delivery_address.'</td><td class="padd_add">Delivery Date</td><td>: '.$po->delivery_date.'</td></tr><tr> <td class="padd_add">Delivery Contacts</td><td>:'.$po->delivery_contact.'</td><td class="padd_add">Salesperson</td><td>: '.Auth::user()->first_name.' '.Auth::user()->last_name.'</td></tr><tr><td colspan="5">&nbsp;</td></tr><tr><td colspan="5"><table border="0" cellpadding="0" cellspacing="0"><tr style="background:#AAA;border-top:1px solid #000;" class="nobreak"> <td style="width:40px;" class="border_style">No</td><td style="width:260px;" class="border_style">Product Name</td><td style="width:100px;" class="border_style">Qty</td><td style="width:90px;" class="border_style">Unit Price</td><td style="width:90px;" class="border_style">Buying Price</td><td style="width:163px;" class="border_style">Amount</td></tr></table></td></tr></table> </div></th></tr>
							  <tbody width="720px" class="nobreak">
							  '.$items.'

							  <tr><td><table cellspacing="0" cellspacing="0" border="0">
							  <tr><td width="480px">&nbsp;</td><td width="90px;" class="padd_add_full" style="text-align:right">Total :</td><td width="167px" style="text-align:center;">$'.sprintf ("%.2f", $po->total_price).'</td></tr>
							  </tr></table></td></tr>
				
				<tr><td class="nobreak"><table cellspacing="0" cellspacing="0" border="0">
				<tr><td> <div class="footer">
							   <table border="0" cellpadding="0" cellspacing="0" width="720px" style="margin-top:200px;"><tr><td><div>Remarks</span><br/>'.$po->remarks.'</div></div></td>
							   </tr><tr><td><div style="margin-top:30px !important;"> <hr/>Authorised Signature</div></td></tr></table>
							  </div>	</td></tr>
				</tbody></table>	
							 				 			  
							</body>
							</html>';

		$pdf->loadHTML($buildhTML);
		return $pdf->download($po->purchase_order_no.".pdf");
	
		
	}
	public function store()
	{
		
		$rules = array(
			'supplier'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('purchase_orders/create')
				->withErrors($validator);
		} else if(Input::get('cnt') == null){

			Session::flash('message', 'Please choose at least one product!');
			return Redirect::to('purchase_orders/create');

		}else if (Input::get('cnt') > 0){

			$get_po_no = Input::get('purchase_order_no');

			$check_po_no = DB::table('purchase_orders')->where('purchase_order_no','=',$get_po_no)->get();

			if ($check_po_no) {
				Session::flash('aldid','Have');
				Session::flash('message', 'Purchase Order No. can not be same! ');
			    return Redirect::to('purchase_orders/create');

			}else{				

			$POEntry = new POEntry;
			
			if (Input::get('invoiceid') != "")
				$invoice_id = Input::get('invoiceid');
			else
				$invoice_id = -1;
			$POEntry->invoice_id       = $invoice_id;
			$POEntry->purchase_order_no       = Input::get('purchase_order_no');
			$POEntry->supplier_id	   = Input::get('supplier');
			$POEntry->total_price	   = Input::get('total_price');
			$POEntry->attn_to	   = Input::get('attn_to');
			$POEntry->delivery_date	   = date('Y-m-d',strtotime(Input::get('delivery_date')));
			$POEntry->delivery_contact	   = Input::get('del_contact');
			if (Input::get('delivery_address') != "")
				$POEntry->delivery_address	   = Input::get('delivery_address');
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$POEntry->date_created		   = $date;
			$POEntry->updated_at		   = $date;
			$POEntry->created_by		   = Auth::user()->id;
			
			$POEntry->save();
			
			if ($invoice_id != -1)
			{		  

				$lastid = DB::getPdo()->lastInsertId();
				
				$count = DB::table('purchase_orders')->where('invoice_id','=',$invoice_id)->count();
				$alphabet = array( '','a', 'b', 'c', 'd', 'e',
						   'f', 'g', 'h', 'i', 'j',
						   'k', 'l', 'm', 'n', 'o',
						   'p', 'q', 'r', 's', 't',
						   'u', 'v', 'w', 'x', 'y',
						   'z'
						   );
				if ($count >0)
					$firstalpha = DB::table('purchase_orders')->where('invoice_id','=',$invoice_id)->orderBy('date_created')->pluck('showid');
				else
					$firstalpha = $lastid;
				
				$newid = $firstalpha.$alphabet[$count-1];
			}
			else
			{
				$newid = DB::getPdo()->lastInsertId();
				$lastid = $newid;
			}
			$POEntry =  DB::table('purchase_orders')->where('showid','=',$lastid)->update(array(
					'id' => $newid
			));
			//$POEntry->;
			$proid_array = array();
			$proqty_array = array();
			if ($invoice_id != -1)
			{				
				for ($n = 0; $n < Input::get('cnt'); $n++)
				{

					if (Input::get('delete'.$n) === "1" )
					{				
						$POItemEntry = new POItemEntry;
						$POItemEntry->po_id       = $newid;
						$POItemEntry->items_id	   = Input::get('id'.$n);
						$productmes = DB::table('products')->where('id','=',Input::get('pid'.$n))->pluck('measurements');
						$meas = explode(';',$productmes);
						if (count ($meas) > 1)
							$measure = $meas[0].' x '.$meas[1].' x '.$meas[2].' mm';
						else
							$measure = "";
						$POItemEntry->product_id	   = Input::get('pid'.$n);
						$get_itemno = ProductEntry::where('id', Input::get('pid'.$n))->pluck('product_itemno');
						
						$POItemEntry->product_itemno  = $get_itemno;
						$POItemEntry->product_name	   = Input::get('pname'.$n)." ".$measure;
						$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
						$POItemEntry->quantity       = Input::get('quantity'.$n);
						$POItemEntry->unit_price = Input::get('unitprice'.$n);
						$POItemEntry->description		   = Input::get('remarks'.$n);
						$POItemEntry->save();
						
						if ($invoice_id != -1)
						{
							$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
							$InvoiceItemEntry->purchase_order = 1;
							$InvoiceItemEntry->update();
						}
						array_push($proid_array,Input::get('pid'.$n));
						array_push($proqty_array,Input::get('quantity'.$n));
					}

					if (Input::get('gpoc') == 1 && $invoice_id != -1) {
						$POItemEntry = new POItemEntry;
							$POItemEntry->po_id       = $newid;
							$POItemEntry->items_id	   = 0;
							$product = Input::get('product_choice'.$n);
							$pr = explode(';',$product);
							$get_itemno = ProductEntry::where('id', $pr[0])->pluck('product_itemno');						
							$POItemEntry->product_itemno  = $get_itemno;
							$POItemEntry->product_id	   = $pr[0];
							$POItemEntry->product_name	   = $pr[1];
							$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
							$POItemEntry->quantity       = Input::get('quantity'.$n);
							$POItemEntry->unit_price = Input::get('unitprice'.$n);
							$POItemEntry->description		   = Input::get('remarks'.$n);
							$POItemEntry->save();
							
							/*if ($invoice_id != -1)
							{
								$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
								$InvoiceItemEntry->purchase_order = 1;
								$InvoiceItemEntry->update();
							}*/
							array_push($proid_array,$pr[0]);
							array_push($proqty_array,Input::get('quantity'.$n));
					}


				}
				$count = DB::table('invoice_items')->where('invoice_id','=',$invoice_id)->where('purchase_order','=',0)->count();
					
				$po = DB::table('invoices')->where('id','=',$invoice_id)->pluck('purchase_order');
				$po = $po.";".$newid;
				if ($count == 0)
					$po[0] = 0;
				DB::table('invoices')->where('id','=',$invoice_id)->update(array(
				'purchase_order'=>$po
				));
			}
			else
			{

				for ($n = 0; $n < Input::get('cnt'); $n++)
				{
					if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0)
					{
						$POItemEntry = new POItemEntry;
							$POItemEntry->po_id       = $newid;
							$POItemEntry->items_id	   = 0;
							$product = Input::get('product_choice'.$n);
							$pr = explode(';',$product);
							$get_itemno = ProductEntry::where('id', $pr[0])->pluck('product_itemno');						
							$POItemEntry->product_itemno  = $get_itemno;
							$POItemEntry->product_id	   = $pr[0];
							$POItemEntry->product_name	   = $pr[1];
							$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
							$POItemEntry->quantity       = Input::get('quantity'.$n);
							$POItemEntry->unit_price = Input::get('unitprice'.$n);
							$POItemEntry->description		   = Input::get('remarks'.$n);
							$POItemEntry->save();
							
							if ($invoice_id != -1)
							{
								$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
								$InvoiceItemEntry->purchase_order = 1;
								$InvoiceItemEntry->update();
							}
							array_push($proid_array,$pr[0]);
							array_push($proqty_array,Input::get('quantity'.$n));
					}
				}

			}
			for($i=0;$i<count($proid_array);$i++){
				$keepin_productstatus = new ProductStatusEntry;
				$keepin_productstatus->po_id = $newid;
				$keepin_productstatus->pro_id = $proid_array[$i];
				$keepin_productstatus->ordered_qty = $proqty_array[$i];
				$keepin_productstatus->save();
			}
			
			return Redirect::to('purchase_orders');
			}//end if
		}
		
	}
	public function store_frompstatus(){
		 $rules = array(
			'supplier'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('purchase_orders/create')
				->withErrors($validator);
		}
		else{
			$invoice_id = -1;
			$POEntry = new POEntry;
			$POEntry->invoice_id 	= $invoice_id;
			$POEntry->supplier_id  	= Input::get('supplier');
			$POEntry->total_price   = Input::get('total_price');
			$POEntry->delivery_date	   = date('Y-m-d',strtotime(Input::get('delivery_date')));
			$POEntry->delivery_contact	   = Input::get('del_contact');
			if (Input::get('delivery_address') != "")
				$POEntry->delivery_address	   = Input::get('delivery_address');
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$POEntry->date_created		   = $date;
			$POEntry->updated_at		   = $date;
			$POEntry->created_by		   = Auth::user()->id;
			$POEntry->save();

			$lastid = DB::getPdo()->lastInsertId();
				
				$count = DB::table('purchase_orders')->where('invoice_id','=',$invoice_id)->count();
				$alphabet = array( '','a', 'b', 'c', 'd', 'e',
						   'f', 'g', 'h', 'i', 'j',
						   'k', 'l', 'm', 'n', 'o',
						   'p', 'q', 'r', 's', 't',
						   'u', 'v', 'w', 'x', 'y',
						   'z'
						   );
				
				$key = array_search ($alphabet[$count],$alphabet);
				$newid = $key;
				
				$aid = "PO";
				 for ($n = 0; $n < (5 - strlen($newid)); $n++)
				 {
					 $aid .= "0";
				 }
				 $aid .= $newid;
				
		    	$POEntry =  DB::table('purchase_orders')->where('showid','=',$lastid)->update(array('id' => $newid));
				

			for ($n = 0; $n < Input::get('cnt'); $n++)
			{
				
				$POItemEntry = new POItemEntry;
				$POItemEntry->po_id       = $lastid;
				$POItemEntry->items_id	   = Input::get('id'.$n);
				$productmes = DB::table('products')->where('id','=',Input::get('pid'.$n))->pluck('measurements');
				$meas = explode(';',$productmes);
				if (count ($meas) > 1)
					$measure = $meas[0].' x '.$meas[1].' x '.$meas[2].' mm';
				else
					$measure = "";
				$get_itemno = ProductEntry::where('id', Input::get('pid'.$n))->pluck('product_itemno');
				
				$POItemEntry->product_itemno  = $get_itemno;
				$POItemEntry->product_name	   = Input::get('pname'.$n)." ".$measure;
				$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
				$POItemEntry->quantity       = Input::get('quantity'.$n);
				$POItemEntry->unit_price = Input::get('unitprice'.$n);
				$POItemEntry->description		   = Input::get('remarks'.$n);
				$POItemEntry->save();

				$pid = Input::get('id'.$n);
				 if(Input::get('check_status') == 1){
				 	$ProductStatusEntry = new ProductStatusEntry;
				 	$ProductStatusEntry->required_qty = Input::get('quantity'.$n);
				 	if($ProductStatusEntry->po_id == ""){
						$ProductStatusEntry->po_id = $lastid;
					}
					else{
						$ProductStatusEntry->po_id = $ProductStatusEntry->po_id.','.$lastid;
					}	
				 }
				 else{
				 	$ProductStatusEntry = ProductStatusEntry::find($pid);				
					if($ProductStatusEntry->required_qty == Input::get('quantity'.$n)){
						$ProductStatusEntry->ordered_qty = $ProductStatusEntry->required_qty + Input::get('quantity'.$n);
						$ProductStatusEntry->required_qty = 0;
					}
					else if($ProductStatusEntry->required_qty > Input::get('quantity'.$n)){
						$ProductStatusEntry->required_qty = $ProductStatusEntry->required_qty - Input::get('quantity'.$n);
						$ProductStatusEntry->ordered_qty = Input::get('quantity'.$n);
					}
					else if(Input::get('quantity'.$n) > $ProductStatusEntry->required_qty){
						$ProductStatusEntry->required_qty = Input::get('quantity'.$n) - $ProductStatusEntry->required_qty;
						$ProductStatusEntry->ordered_qty = Input::get('quantity'.$n);
					}
					if($ProductStatusEntry->po_id == ""){
						$ProductStatusEntry->po_id = $lastid;
					}
					else{
						$ProductStatusEntry->po_id = $ProductStatusEntry->po_id.','.$lastid;
					}				
				 }
			     $ProductStatusEntry->save();
			}
			return Redirect::to('purchase_orders');
		}
	}

	public function save_edit()
	{ 

		//print_r(Input::get('delivery_date'));exit;

		$rules = array(
			'id'     => 'required',
			'supplier'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('purchase_orders')
				->withErrors($validator);
		}else if(Input::get('cnt') == null || Input::get('cnt') == 0){

			Session::flash('message', 'Please choose at least one product!');
			return Redirect::to('purchase_orders/'.Input::get('originalid'));

		} else { //echo Input::get('remarks');exit();
			
			//dd(Input::get('cnt'));exit;

			DB::table('po_items')->where('po_id','=',Input::get('originalid'))->delete();

			//for ($n = 0; $n <= Input::get('cnt'); $n++)

			for ($n = 0; $n < Input::get('cnt'); $n++)
			{
				if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0)
				{
					
						/*$POItemEntry = new POItemEntry;
						$POItemEntry->po_id       = Input::get('originalid');
						$POItemEntry->product_id	   = Input::get('product_choice'.$n);
						$get_itemno = ProductEntry::where('id', Input::get('product_choice'.$n))->pluck('product_itemno');
						$POItemEntry->product_itemno = $get_itemno;
						$POItemEntry->product_name	   = Input::get('product_name'.$n);
						$POItemEntry->unit_price       = Input::get('unitprice'.$n);
						$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
						$POItemEntry->quantity       = Input::get('quantity'.$n);
						$POItemEntry->description		   = Input::get('remarks'.$n);
						$POItemEntry->save();*/

						$POItemEntry = new POItemEntry;
						$POItemEntry->po_id       = Input::get('originalid');
													
							$product = Input::get('product_choice'.$n);
							$pr = explode(';',$product);
							$get_itemno = ProductEntry::where('id', $pr[0])->pluck('product_itemno');	
							$get_product_name = ProductEntry::where('id', $pr[0])->pluck('product_name');					
							$POItemEntry->product_itemno  = $get_itemno;
							$POItemEntry->product_id	   = $pr[0];
							$POItemEntry->product_name	   = $get_product_name;
							$POItemEntry->buying_price		   = Input::get('buyingprice'.$n);
							$POItemEntry->quantity       = Input::get('quantity'.$n);
							$POItemEntry->unit_price = Input::get('unitprice'.$n);
							$POItemEntry->description		   = Input::get('remarks'.$n);
							$POItemEntry->save();
							
					
				}
			}
			$POEntry = POEntry::find(Input::get('originalid'));
			$POEntry->purchase_order_no       = Input::get('id');
			$POEntry->invoice_id       = Input::get('invoiceid');
			$POEntry->attn_to	   = Input::get('attn_to');
			$POEntry->supplier_id	   = Input::get('supplier');
			$POEntry->delivery_date	   = date('Y-m-d',strtotime(Input::get('delivery_date')));
			$POEntry->delivery_contact	   = Input::get('del_contact');
			$POEntry->delivery_address	   = Input::get('delivery_address');
			$POEntry->total_price	   = Input::get('total_price');
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$POEntry->updated_at		   = $date;
			$POEntry->created_by		   = Auth::user()->id;
			$POEntry->remarks		   = Input::get('remarks');
			$POEntry->save();
			if (Input::get('invoiceid') > -1)
			{
				DB::table('invoices')->where('id','=',Input::get('invoiceid'))->update(array(
				'purchase_order'=> Input::get('id')
				));
			}
			return Redirect::to('purchase_orders');
		}
	}
	public function confirm_po(){
		$id = Input::get('id');	
			$getproducts = ProductStatusEntry::get();
			foreach ($getproducts as $key => $value){
				$pro = explode(",",$value->po_id);			
				if(in_array($id,$pro)){
					for($i=0;$i<count($pro);$i++){
						if($pro[$i] == $id){
							$search_po = DB::table('product_status')->where('po_id','=',$value->po_id)->first();
							
							$count_poid = explode(",",$search_po->po_id);
							
							if($search_po->required_qty == 0){	
								$getpo = POEntry::find($id);
								$getpo->status = 1;
								$getpo->save();	
								//add ordered_qty to qty in product table
								$get_product = ProductEntry::find($search_po->pro_id);
								$get_product->quantity = $get_product->quantity + $search_po->ordered_qty;
								$get_product->save();
								if(count($count_poid) == 1){
									//del pro in product status
									ProductStatusEntry::where('pro_id', '=', $search_po->pro_id)->delete();
								}
							}
							else if($search_po->required_qty == $search_po->ordered_qty){
								$get_product = ProductEntry::find($search_po->pro_id);
								$get_product->quantity = $get_product->quantity + $search_po->ordered_qty;
								$get_product->save();
								$update_prostatus = ProductStatusEntry::where('pro_id','=',$search_po->pro_id)->first();
								$update_prostatus->ordered_qty = 0;
								$update_prostatus->save();
							}
							else if($search_po->required_qty > $search_po->ordered_qty){
								$get_product = ProductEntry::find($search_po->pro_id);
								$get_product->quantity = $get_product->quantity + $search_po->ordered_qty;
								$get_product->save();
								$update_prostatus = ProductStatusEntry::where('pro_id','=',$search_po->pro_id)->first();
								$update_prostatus->ordered_qty = 0;
								$update_prostatus->save();
							}				
							else if($search_po->required_qty < $search_po->ordered_qty){
								$get_product = ProductEntry::find($search_po->pro_id);
								$get_product->quantity = $get_product->quantity + $search_po->ordered_qty;
								$get_product->save();
								$update_prostatus = ProductStatusEntry::where('pro_id','=',$search_po->pro_id)->first();
								$update_prostatus->ordered_qty = 0;
								$update_prostatus->save();
							}			
						}
					}
				}
			}
		//exit();
		return Redirect::to('purchase_orders');
	}
	public function edit_purchase_order($id)
	{
		$po = DB::table('invoices')->get();
		$products = DB::table('products')->get();
		$unitPrice = DB::table('products')->lists('unit_price','id');
		$sellPrice = DB::table('products')->lists('selling_price','id');
		$desc = DB::table('products')->lists('measurements','id');
		$suppliers = DB::table('suppliers')->get();
		$middlemens = DB::table('middlemen')->get();
		$purchase_orderitems = DB::table('po_items')->where('po_id','=',$id)->get();
		$purchase_orders = POEntry::find($id);
		 return View::make('purchase_orders.edit')
            ->with('id',$id)->with('purchase_order', $purchase_orders)->with('invoices',$po)->with('inv',$purchase_orderitems)
			->with('suppliers',$suppliers)->with('middlemens',$middlemens)->with('products',$products)->with('unit_price',$unitPrice)->with('desc',$desc)->with('sellPrice',$sellPrice);
	}
	public function view_purchase_order($id)
	{

		$purchase_orderitems = DB::table('po_items')->where('po_id','=',$id)->get();
	
		$purchase_orders = POEntry::find($id);
		 return View::make('purchase_orders.view')
            ->with('id',$id)->with('po', $purchase_orders)->with('inv',$purchase_orderitems);
	}
	public function delete_purchase_order()
	{
		$id = Input::get('id');
	
		DB::table('purchase_orders')->where('id','=',$id)->delete();
		$items = DB::table('po_items')->where('po_id','=',$id)->get();
		foreach($items as $key=>$value)
		{
			DB::table('invoice_items')->where('id','=',$value->items_id)->update(array(
				'purchase_order'=>0
			));
		}
		DB::table('po_items')->where('po_id','=',$id)->delete();
		$poid = DB::table('invoices')->where('purchase_order','LIKE','%'.$id.'%')->pluck('purchase_order');
		$nid = explode(";",$poid);
		$newid = "";
		for ($n = 0; $n < count($nid); $n++)
		{
			if ($n == 0)
				$newid = "1";
			else if ($nid[$n] != $id)				
				$newid .= ";".$nid[$n];
		}
		DB::table('invoices')->where('purchase_order','LIKE','%'.$id.'%')->update(array('purchase_order'=>$newid));
		return Redirect::to('purchase_orders');
	
	}
	public function enable_purchase_order()
	{
		$id = Input::get('id');
		DB::table('purchase_orders')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('purchase_orders');
	}
	public function disable_purchase_order()
	{
		$id = Input::get('id');
		DB::table('purchase_orders')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('purchase_orders');
	}

}
?>