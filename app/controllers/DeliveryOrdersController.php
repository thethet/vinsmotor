<?php

class DeliveryOrdersController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$invoices = DB::table('invoices')->get();
		$this->layout->content =  View::make('delivery_orders.create')->with('invoices',$invoices);	
	}
	public function pass_form()
	{
		$iid = Input::get('invoice_id');
		$po = DB::table('invoices')->find($iid);
		$po_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->lists('product_id');
		$inv_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->get();
		$products = DB::table('products')->whereIn('id',$po_items)->get();
		$unitPrice = DB::table('products')->whereIn('id',$po_items)->lists('unit_price','id');
		$suppliers = DB::table('suppliers')->get();
		$this->layout->content =  View::make('delivery_orders.refercreate')->with('inv',$inv_items)->with('iid',$iid)->with('invoices',$po)->with('suppliers',$suppliers)->with('products',$products)->with('unit_price',$unitPrice);		
	}
	public function show_delivery_orders()
	{
		$delivery_orders = DB::table('delivery_orders')->get();
		$this->layout->content =  View::make('delivery_orders.manage')->with('delivery_orders',$delivery_orders);	
	}
	public function download_do()
	{
		$sid = Input::get('id');
		$aid = "DO";
		 for ($n = 0; $n < (5 - strlen($sid)); $n++)
		 {
			 $aid .= "0";
		 }
		 $aid .= $sid;
		$DO = DB::table('delivery_orders')->where('id','=',$sid)->first();
		$id = $DO->invoice_id;
		
		$pid = "DO";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $pid .= "0";
		 }
		 $pid .= $id;
		$invoiceitems = DB::table('do_items')->where('do_id','=',$sid)->get();
		$invoicecount = DB::table('do_items')->where('do_id','=',$sid)->count();

		$invoices = InvoiceEntry::find($id);
		if ($invoices->middleman > 0)
		{
			$middet = "Contact ";
			$middetcontent =": ". MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('first_name')." ".MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('last_name');
			$midcontact = "Mobile ";
			$midcontactcontent = ": ".MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('mobile_contact');
		}
		else
		{
			$middet = "";
			$middetcontent = "";
			$midcontact = "";
			$midcontactcontent = "";
		}
		$items = "";
		$n = 1;
		$m = 0;
		if ($invoices->client_id != -1)
		{
			$extraline = 11;
		}
		else{
			$extraline = 12;
		}
		$billedto = DB::table('clients')->where('id','=',$invoices->client_id)->first();
		foreach ($invoiceitems as $key =>$value)
		{
			$oriprice = "";
			if($extraline == $m || $invoicecount == $n){
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
				$dec = $value->remarks;
			}
		
			if ($value->product_id != -1){
			$items = $items."<tr><td style='padding:0;margin:0'><table width='720px' border='0' cellpadding='0' cellspacing='0' style='margin-left:1px;'><tr class='border-pro'><td width='40px' class='border-pro' style='height:55px;'><div style='text-align:center;'>".$n++."</div></td><td style='text-align:left;padding-left:10px;width:130px;' class='border-pro'>".$value->product_id."</td><td style='text-align:left;padding-left:10px;width:290px;' class='border-pro'> ".$value->product_name."</td><td width='40px' class='align_center border-pro'>".$value->quantity."</td><td width='184px' style='padding-left:10px;padding-right:10px;' class='border-pro'>".$dec."</td></tr></table></td></tr><tr><td style='margin:0;padding:0;' ".$addborder."></td></tr>";
			}		 
			 $m++;
			 if($m > $extraline){
				$m = 0;
			 }
		}

		$profile = DB::table('companyprofile')->first();
		$pdf = App::make('dompdf');date_default_timezone_set('UTC');
		$cnt = DB::table('delivery_orders')->where('invoice_id','=',$id)->count();
		$saleid = InvoiceEntry::where('id','=',$id)->pluck('sales_staff');
		$sale_staff = StaffEntry::where('id','=',$saleid)->pluck('name');
		if ($cnt > 0)
		{
			$deldate = DB::table('delivery_orders')->where('invoice_id','=',$id)->pluck('date_sent');
		}
		else
			$deldate = "SELF Collect";

		$date =	 date("d/m/Y");
		$aftGST = $invoices->total_price+($invoices->total_price * 0.07);
		
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
							     <table cellspacing="0" cellspacing="0" border="0"  width="720px"><thead><tr><th><table class="full" border="0" cellpadding="0" cellspacing="0"> <tr> <td class="thirty" style="text-align:center"> <img src="../img/logo.jpg"> <br>Co Reg No : '.$profile->registration_no.'</td><td><div style="width:300px;padding-left:200px !important;"><h2 style="margin-left:0px;">'.$profile->company_name.'</h2><br/>'.$profile->header.'</div></td></tr></table>
							    <div class="taxinvoiceheader">Delivery Order</div><div class="taxinvoicebody"> <table class="full bold" rules="cols" width="720px" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="width:80px" class="padd_add">Billed To</td><td style="width:330px;">: '.$billedto->first_name." ".$billedto->last_name.'</td><td style="width:120px" class="padd_add">Delivery Order No</td><td width="160px">: '.$aid.'</td></tr><tr> <td class="padd_add">'.$midcontact.'</td><td>: '.$midcontactcontent.'</td><td class="padd_add">Ref No</td><td>: '.$pid.'</td></tr><tr> <td class="padd_add">Delivery Address</td><td>: '.$billedto->delivery_address.'</td><td class="padd_add">Delivery Date</td><td>: '.$deldate.'</td></tr><tr> <td class="padd_add">Tel</td><td>: '.$billedto->mobile_contact.'</td><td class="padd_add">Balance</td><td>: $'.($billedto->balance * -1).'</td></tr><tr> <td class="padd_add"> '.$middet.'</td> <td> '.$middetcontent.'</td><td class="padd_add">Sales person  </td><td>: '.$sale_staff.'</td></tr><tr><td colspan="5">&nbsp;</td></tr><tr><td colspan="5"><table border="0" cellpadding="0" cellspacing="0"><tr style="background:#AAA;border-top:1px solid #000;" class="nobreak"> <td style="width:40px;" class="border_style">No</td><td style="width:140px;" class="border_style">Item Code</td><td style="width:300px;" class="border_style">Description</td><td style="width:40px;" class="border_style">Qty</td><td style="width:203px;" class="border_style">Remarks</td></tr></table></td></tr></table> </div></th></tr></thead>
							  <tbody  width="720px" >
							  '.$items.'				
				<tr><td class="nobreak"><table cellspacing="0" cellspacing="0" border="0">
				<tr><td> <div class="footer">
							   <table border="0" cellpadding="0" cellspacing="0" width="720px"><tr><td><div>Terms & Conditions</span><br/>'.$profile->terms3.'</div></div></td>
							   <td><div style="margin-top:250px !important;"> <hr/>Authorised Signature</div></td></tr></table>
							  </div>	</td></tr>
				</tbody></table>	
							 				 			  
							</body>
							</html>';
		
		$pdf->loadHTML($buildhTML);
		return $pdf->download($aid.".pdf");
	
		
	}
	public function store()
	{
		
		
			$DeliveryOrderEntry = new DeliveryOrderEntry;
			$DeliveryOrderEntry->invoice_id	   = Input::get('invoiceid');
			$DeliveryOrderEntry->date_sent	   = date("Y-m-d", strtotime(Input::get('delivery_date')));
			$DeliveryOrderEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$DeliveryOrderEntry->date_created = $date;
			$DeliveryOrderEntry->updated_at	= $date;
			$DeliveryOrderEntry->save();
			$lastid = DB::getPdo()->lastInsertId();
			$invoice_id = Input::get('invoiceid');
			$count = DB::table('delivery_orders')->where('invoice_id','=',Input::get('invoiceid'))->count();
			$alphabet = array( '','a', 'b', 'c', 'd', 'e',
                       'f', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
			if ($count >0)
				$firstalpha = DB::table('delivery_orders')->where('invoice_id','=',$invoice_id)->orderBy('date_created')->pluck('showid');
			else
				$firstalpha = $lastid;
			$newid = $firstalpha.$alphabet[$count-1];
			$POEntry =  DB::table('delivery_orders')->where('showid','=',$lastid)->update(array(
					'id' => $newid
			));

			for ($n = 0; $n < Input::get('cnt'); $n++)
			{
				if (Input::get('delete'.$n) === "1")
				{
					$DOItemEntry = new DOItemEntry;
					$DOItemEntry->do_id       = $newid;
					$DOItemEntry->items_id	   = Input::get('id'.$n);
					$DOItemEntry->product_id	   = Input::get('pid'.$n);
					$get_itemno = ProductEntry::where('id', Input::get('pid'.$n))->pluck('product_itemno');
					$DOItemEntry->product_itemno = $get_itemno;
					$productmes = DB::table('products')->where('id','=',Input::get('pid'.$n))->pluck('measurements');
						$meas = explode(';',$productmes);
						if (count ($meas) > 1)
							$measure = $meas[0].' x '.$meas[1].' x '.$meas[2].' mm';
						else
							$measure = "";
					$DOItemEntry->product_name	   = Input::get('pname'.$n)." ".$measure;
					$DOItemEntry->retail_price		   = Input::get('selling_price'.$n);
					$DOItemEntry->quantity       = Input::get('quantity'.$n);
					$DOItemEntry->remarks       = Input::get('remarks'.$n);
					$DOItemEntry->save();
					
					$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
					$InvoiceItemEntry->delivery_order = 1;
					$InvoiceItemEntry->update();
				}
			}
			$invoice_id = Input::get('invoiceid');
			if ($invoice_id != -1)
			{
				$count = DB::table('invoice_items')->where('invoice_id','=',$invoice_id)->where('delivery_order','=',0)->count();
				
					$do = DB::table('invoices')->where('id','=',$invoice_id)->pluck('delivery_order');
					$do = $do.";".$newid;
					if ($count == 0)
						$do[0] = 0;
					DB::table('invoices')->where('id','=',$invoice_id)->update(array(
					'delivery_order'=>$do
					));
				
			}
			return Redirect::to('delivery_orders');
		
		
	}
	public function save_edit()
	{
		$rules = array(
			'invoice_id'     => 'required',
			'date_sent'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('delivery_orders')
				->withErrors($validator);
		} else {
			$DeliveryOrderEntry = DeliveryOrderEntry::find(Input::get('id'));
			$DeliveryOrderEntry->invoice_id	   = Input::get('invoice_id');
			$DeliveryOrderEntry->date_sent	   = Input::get('date_sent');
			$DeliveryOrderEntry->date_received       = Input::get('date_received');
			$DeliveryOrderEntry->remarks       = Input::get('remarks');
			$DeliveryOrderEntry->updated_by		   = Auth::user()->id;
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$DeliveryOrderEntry->updated_at		   = $date;
			$DeliveryOrderEntry->save();
			if (Input::get('invoice_id') > -1)
			{
				DB::table('invoices')->where('id','=',Input::get('invoice_id'))->update(array(
				'delivery_order'=> Input::get('id')
				));
			}

			return Redirect::to('delivery_orders');
		}
	}
	public function edit_delivery_order($id)
	{
		$invoices = DB::table('invoices')->get();
		$delivery_orders = DeliveryOrderEntry::find($id);
		 return View::make('delivery_orders.edit')
            ->with('do', $delivery_orders)->with('id',$id)->with('invoices',$invoices);
	}
	public function view_delivery_order($id)
	{
	
		$delivery_orderitems = DB::table('do_items')->where('do_id','=',$id)->get();
	
		$delivery_orders =DeliveryOrderEntry::find($id);
		 return View::make('delivery_orders.view')
            ->with('id',$id)->with('po', $delivery_orders)->with('inv',$delivery_orderitems);
	}
	public function delete_delivery_order()
	{
		$id = Input::get('id');
		DB::table('delivery_orders')->where('id','=',$id)->delete();
		$items = DB::table('do_items')->where('do_id','=',$id)->get();
		foreach($items as $key=>$value)
		{
			DB::table('invoice_items')->where('id','=',$value->items_id)->update(array(
				'delivery_order'=>0
			));
		}
		DB::table('do_items')->where('do_id','=',$id)->delete();
		$doid = DB::table('invoices')->where('delivery_order','LIKE','%'.$id.'%')->pluck('delivery_order');
		$nid = explode(";",$doid);
		$newid = "";
		for ($n = 0; $n < count($nid); $n++)
		{
			if ($n == 0)
				$newid = "1";
			else if ($nid[$n] != $id)				
				$newid .= ";".$nid[$n];
		}
		DB::table('invoices')->where('delivery_order','LIKE','%'.$id.'%')->update(array('delivery_order'=>$newid));
		return Redirect::to('delivery_orders');
	}
	public function delivered_delivery_order()
	{
		$id = Input::get('id');
		DB::table('delivery_orders')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('delivery_orders');
	}
	public function not_delivered_delivery_order()
	{
		$id = Input::get('id');
		DB::table('delivery_orders')->where('id','=',$id)->update(array('status'=>Input::get('job_status')));
		return Redirect::to('delivery_orders');
	}
	
}
?>