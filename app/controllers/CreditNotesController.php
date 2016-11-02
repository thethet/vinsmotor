<?php
class CreditNotesController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";	
	public function create_form()
	{
		$latestid = DB::table('credit_notes')->orderby('date_created','desc')->pluck('showid');
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
		$suppliers = DB::table('suppliers')->get();
		$this->layout->content =  View::make('credit_notes.create')->with('aid',$aid)->with('measurements',$measurements)->with('invoices',$po)->with('suppliers',$suppliers)->with('products',$products)->with('unit_price',$unitPrice);	
	}
	public function pass_form($id)
	{
		$iid = $id;
		$po = DB::table('invoices')->find($iid);
		$cn_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->lists('product_id');
		$inv_items = DB::table('invoice_items')->where('invoice_id','=',$iid)->get();
		$products = DB::table('products')->whereIn('id',$cn_items)->get();
		$measurements = DB::table('products')->lists('measurements','id');
		$unitPrice = DB::table('products')->whereIn('id',$cn_items)->lists('unit_price','id');
		$staffs = DB::table('staffs')->get();
		$this->layout->content =  View::make('credit_notes.refercreate')->with('staffs',$staffs)->with('measurements',$measurements)->with('inv',$inv_items)->with('iid',$iid)->with('invoices',$po)->with('products',$products)->with('unit_price',$unitPrice);	
	}
	public function show_credit_notes()
	{
		$credit_notes = DB::table('credit_notes')->get();
		$this->layout->content =  View::make('credit_notes.manage')->with('credit_notes',$credit_notes);	
	}
	public function download_cn()
	{
		$id = Input::get('id');
		$aid = "CN";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $aid .= "0";
		 }
		 $aid .= $id;
		$poitems = DB::table('cn_items')->where('cn_id','=',$id)->get();
		$pocount = DB::table('cn_items')->where('cn_id','=',$id)->count();
		$po = DB::table('credit_notes')->where('cn_id','=',$id)->first();
		$id = $po->invoice_id;
		$pid = "CN";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $pid .= "0";
		 }
		 $pid .= $id;
		$items = "";
		$n = 1;
		$m = 0;
		
		$extraline = 12;
		foreach ($poitems as $key =>$value)
		{
			
			if ($value->items_id != -2)
			{
				$dec = "";
			}
			$dec = $value->refund_price;
			
			if($extraline == $m || $pocount == $n){
				$addborder = "class='bot_border_style'";
			}
			else{
				$addborder = "";
			}
		
			if ($value->product_id != -1){
			$items = $items."<tr><td style='padding:0;margin:0'><table width='720px' border='0' cellpadding='0' cellspacing='0' style='margin-left:1px;'><tr class='border-pro'><td width='40px' class='border-pro' style='height:55px;'><div style='text-align:center;'>".$n++."</div></td><td style='text-align:left;padding-left:10px;width:290px;' class='border-pro'>".$value->product_id.$value->product_name."</td><td width='40px' class='align_center border-pro'>".$value->quantity."</td><td style='text-align:right;padding-left:10px;padding-right:10px;width:120px;' class='border-pro'><table style='width:100%' cellspacing='0' cellspacing='0'><tr><td>$</td><td style='width:100%;text-align:right'><div style='float:right;text-align:right;'>".$value->refund_price."</div></td></tr></table></td><td width='184px' class='border-pro' style='padding-right:10px;padding-left:10px;'><table style='width:100%' cellspacing='0' cellspacing='0'><tr><td>$</td><td style='width:100%;text-align:right'><div style='float:right;text-align:right;'>".$dec."</div></td></tr></table></td></tr></table></td></tr><tr><td style='margin:0;padding:0;' ".$addborder."></td></tr>";
			}
			else{
				
			}			 
			 $m++;
			 if($m > $extraline){
				$m = 0;
			 }

		}
		
		$profile = DB::table('companyprofile')->first();
		$pdf = App::make('dompdf');date_default_timezone_set('UTC');
			

		// Prints something like: Monday
		$date =	 date("d/m/Y");
		$aftGST = $po->total_price+($po->total_price * 0.07);
		$client = DB::table('invoices')->where('id','=',$po->invoice_id)->first();
		$billedto = DB::table('clients')->where('id','=',$client->client_id)->first();
		$sales_staff = DB::table('staffs')->where('id','=',$po->sales_staff)->pluck('name');
		if($client->client_id == "-1"){
			$client_name = "";
			$salutation_name = "";
			$contact = "";
		}
		else{
			$client_name = $billedto->first_name.' '.$billedto->last_name;
			$salutation_name = $billedto->salutation;
			$contact = $billedto->mobile_contact;
		}
		

		if ($po->payment_method != "")
		{	
			$payment_method = 'Payment Method';
			$ppayment_method = ': '.$po->payment_method;
		}
		else
		{
			$payment_method = '';
			$ppayment_method = '';
		}
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
							    <div class="taxinvoiceheader">Credit Note</div><div class="taxinvoicebody"> <table class="full bold" rules="cols" width="720px" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="width:80px" class="padd_add">Refund To </td><td style="width:330px;">: '.$salutation_name.' '.$client_name.'</td><td style="width:120px" class="padd_add">Credit Note No</td><td width="160px">: '.$aid.'</td></tr><tr> <td class="padd_add">Contact</td><td>: '.$contact.'</td><td class="padd_add">Date </td><td>: '.$date.'</td></tr><tr> <td class="padd_add">'.$payment_method.'</td><td>: '.$ppayment_method.'</td><td class="padd_add">Sales Staff</td><td>: '.$sales_staff.'</td></tr><tr><td colspan="5">&nbsp;</td></tr><tr><td colspan="5"><table border="0" cellpadding="0" cellspacing="0"><tr style="background:#AAA;border-top:1px solid #000;" class="nobreak"> <td style="width:40px;" class="border_style">No</td><td style="width:300px;" class="border_style">Product Name</td><td style="width:40px;" class="border_style">Qty</td><td style="width:140px;" class="border_style">Refund</td><td style="width:203px;" class="border_style">Amount</td></tr></table></td></tr></table> </div></th></tr></thead>
							  <tbody  width="720px" >
							  '.$items.'				
				<tr><td><table cellspacing="0" cellspacing="0" border="0" class="nobreak">
		<tr><td width="423px">&nbsp;</td><td width="90px;" class="padd_add_full">Total Amount :</td><td class="border_style align_right padd_add_full" width="194px">$'.number_format($po->total_price,2).'</td></tr><tr> <td>&nbsp;</td><td class="padd_add_full">7% GST :</td><td class="border_style align_right padd_add_full">$'.number_format($po->total_price * 0.07,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Total :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Deposit :</td><td class="border_style align_right padd_add_full">$'.number_format($po->deposit,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Balance :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST - $po->deposit,2).'</td></tr></table>
		</td></tr>
		<tr><td> <div class="footer nobreak" >
					   <table border="0" cellpadding="0" cellspacing="0" width="720px"><tr><td> <div>Remarks:<br>'.$profile->remarks.'</div><br/><br/><br/><div>Terms & Conditions</span> <br/> '.$profile->terms.'</div></div></td>
					   <td><div style="margin-top:250px !important;"> <hr/>Authorised Signature</div></td></tr></table>
					  </div>	</td></tr>
		</tbody> </table>		 			  
							</body>
							</html>';
		
		$pdf->loadHTML($buildhTML);
		return $pdf->download($aid.".pdf");
	
		
	}
	public function store()
	{
		
		$rules = array(
			'cnt'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('credit_notes/create')
				->withErrors($validator);
		} else if (Input::get('cnt') > 0){
			$CNEntry = new CNEntry;
			
			if (Input::get('invoiceid') != "")
				$invoice_id = Input::get('invoiceid');
			else
				$invoice_id = -1;
				
			$CNEntry->invoice_id       = $invoice_id;
			$CNEntry->total_price	   = Input::get('total_price');
			$CNEntry->sales_staff	   = Input::get('sales_staff');
			$CNEntry->payment_method	   = Input::get('payment_method');
			$CNEntry->deposit	   = Input::get('deposit');
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$CNEntry->date_created		   = $date;
			$CNEntry->updated_at		   = $date;
			$CNEntry->created_by		   = Auth::user()->id;
			$CNEntry->save();
			$lastid = DB::getPdo()->lastInsertId();
			$client = DB::table('invoices')->where('id','=',$invoice_id)->first();
			DB::table('clients')->where('id','=',$client->client_id)->increment('balance', Input::get('total_price'));
			if ($invoice_id != -1)
			{
				
				$count = DB::table('credit_notes')->where('invoice_id','=',$invoice_id)->count();
				$alphabet = array( '','a', 'b', 'c', 'd', 'e',
						   'f', 'g', 'h', 'i', 'j',
						   'k', 'l', 'm', 'n', 'o',
						   'p', 'q', 'r', 's', 't',
						   'u', 'v', 'w', 'x', 'y',
						   'z'
						   );
				if ($count >0)
					$firstalpha = DB::table('credit_notes')->where('invoice_id','=',$invoice_id)->orderBy('date_created')->pluck('showid');
				else
					$firstalpha = $lastid;
				
				$newid = $firstalpha.$alphabet[$count-1];
			}
			else
			{
				$newid = DB::getPdo()->lastInsertId();
				$lastid = $newid;
			}
			$CNEntry =  DB::table('credit_notes')->where('showid','=',$lastid)->update(array(
					'cn_id' => $newid
			));
			//$CNEntry->;
			if ($invoice_id != -1)
			{
				for ($n = 0; $n < Input::get('cnt'); $n++)
				{
					if (Input::get('delete'.$n) === "1" )
					{
						$CNItemEntry = new CNItemEntry;
						$CNItemEntry->cn_id       = $newid;
						$CNItemEntry->items_id	   = Input::get('id'.$n);
						$productmes = DB::table('products')->where('id','=',Input::get('pid'.$n))->pluck('measurements');
						$meas = explode(';',$productmes);
						if (count ($meas) > 1)
							$measure = $meas[0].' x '.$meas[1].' x '.$meas[2].' mm';
						else
							$measure = "";
						$CNItemEntry->product_id	   = Input::get('pid'.$n);
						$get_itemno = ProductEntry::where('id', Input::get('pid'.$n))->pluck('product_itemno');
						$CNItemEntry->product_itemno   = $get_itemno;
						$CNItemEntry->product_name	   = Input::get('pname'.$n)." ".$measure;
						$CNItemEntry->refund_price		   = Input::get('buyingprice'.$n);
						$CNItemEntry->quantity       = Input::get('quantity'.$n);
						$CNItemEntry->description		   = Input::get('remarks'.$n);
						$CNItemEntry->save();
						
						if ($invoice_id != -1)
						{
							$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
							$InvoiceItemEntry->credit_note = Input::get('quantity'.$n);
							$InvoiceItemEntry->update();
						}
					}
					
				}
				if (Input::get('rebate') > 0)
				{
						$CNItemEntry = new CNItemEntry;
						$CNItemEntry->cn_id       = $newid;
						$CNItemEntry->items_id	   = "-2";
						$CNItemEntry->product_id	   = "";
						$CNItemEntry->product_name	   = "Rebate";
						$CNItemEntry->refund_price		   = Input::get('rebate');
						$CNItemEntry->quantity       = 0;
						$CNItemEntry->description		   = "";
						$CNItemEntry->save();
				}
				$count = DB::table('invoice_items')->where('invoice_id','=',$invoice_id)->where('credit_note','=',0)->count();
					
				$po = DB::table('invoices')->where('id','=',$invoice_id)->pluck('credit_note');
				$po = $po.";".$newid;
				if ($count == 0)
					$po[0] = 0;
				DB::table('invoices')->where('id','=',$invoice_id)->update(array(
					'credit_note'=>$po
				));
			}
			else
			{
				for ($n = 0; $n < Input::get('cnt'); $n++)
				{
					if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0)
					{
						$CNItemEntry = new CNItemEntry;
							$CNItemEntry->cn_id       = $newid;
							$CNItemEntry->items_id	   = 0;
							$product = Input::get('product_choice'.$n);
							$pr = explode(';',$product);
							
							$CNItemEntry->product_id	   = $pr[0];
							$CNItemEntry->product_name	   = $pr[1];
							$CNItemEntry->refund_price		   = Input::get('buyingprice'.$n);
							$CNItemEntry->quantity       = Input::get('quantity'.$n);
							$CNItemEntry->description		   = Input::get('remarks'.$n);
							$CNItemEntry->save();
							
							if ($invoice_id != -1)
							{
								$InvoiceItemEntry = InvoiceItemEntry::find (Input::get('id'.$n));
								$InvoiceItemEntry->credit_note = 1;
								$InvoiceItemEntry->update();
							}
					}
				}
				
			}
			return Redirect::to('credit_notes');
		}
		
	}
	public function save_edit()
	{
		$rules = array(
			'id'     => 'required',
			'supplier'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('credit_notes')
				->withErrors($validator);
		} else {
			DB::table('cn_items')->where('cn_id','=',Input::get('id'))->delete();
			for ($n = 0; $n < Input::get('cnt'); $n++)
			{
				if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0)
				{
					
						$CNItemEntry = new CNItemEntry;
						$CNItemEntry->cn_id       = Input::get('id');
						$CNItemEntry->product_id	   = Input::get('product_choice'.$n);
						$CNItemEntry->product_name	   = Input::get('product_name'.$n);
						$CNItemEntry->unit_price       = Input::get('unitprice'.$n);
						$CNItemEntry->refund_price		   = Input::get('buyingprice'.$n);
						$CNItemEntry->quantity       = Input::get('quantity'.$n);
						$CNItemEntry->description		   = Input::get('description'.$n);
						$CNItemEntry->save();
					
				}
			}
			$CNEntry = CNEntry::find(Input::get('originalid'));
			$CNEntry->cn_id       = Input::get('id');
			$CNEntry->invoice_id       = Input::get('invoiceid');
			$CNEntry->supplier_id	   = Input::get('supplier');
			$CNEntry->total_price	   = Input::get('total_price');
			$CNEntry->remarks	   = Input::get('remarks');
			date_default_timezone_set('Singapore');
			$date = date('Y-m-d H:i:s', time());
			$CNEntry->updated_at		   = $date;
			$CNEntry->created_by		   = Auth::user()->cn_id;
			$CNEntry->save();
			if (Input::get('invoiceid') > -1)
			{
				DB::table('invoices')->where('id','=',Input::get('invoiceid'))->update(array(
				'credit_note'=> Input::get('id')
				));
			}
			return Redirect::to('credit_notes');
		}
	}
	public function edit_credit_note($id)
	{
		$po = DB::table('invoices')->get();
		$products = DB::table('products')->get();
		$unitPrice = DB::table('products')->lists('unit_price','id');
		$desc = DB::table('products')->lists('description','id');
		$suppliers = DB::table('suppliers')->get();	
	
		$credit_noteitems = DB::table('cn_items')->where('cn_id','=',$id)->get();
		$credit_notes = CNEntry::find($id);
		 return View::make('credit_notes.edit')
            ->with('id',$id)->with('credit_note', $credit_notes)->with('invoices',$po)->with('inv',$credit_noteitems)
			->with('suppliers',$suppliers)->with('products',$products)->with('unit_price',$unitPrice)->with('desc',$desc);
	}
	public function view_credit_note($id)
	{

		$credit_noteitems = DB::table('cn_items')->where('cn_id','=',$id)->get();
	
		$credit_notes = DB::table('credit_notes')->where('cn_id','=',$id)->first();
		 return View::make('credit_notes.view')
            ->with('id',$id)->with('po', $credit_notes)->with('inv',$credit_noteitems);
	}
	public function delete_credit_note()
	{
		$id = Input::get('id');
		$totalrefund = DB::table('credit_notes')->where('cn_id','=',$id)->first();
		$client = DB::table('invoices')->where('id','=',$totalrefund->invoice_id)->first();
		DB::table('clients')->where('id','=',$client->id)->increment('balance', -1 * $totalrefund->total_price);
			
		DB::table('credit_notes')->where('cn_id','=',$id)->delete();
		$items = DB::table('cn_items')->where('cn_id','=',$id)->get();
		foreach($items as $key=>$value)
		{
			DB::table('invoice_items')->where('id','=',$value->items_id)->update(array(
				'credit_note'=>0
			));
		}
		DB::table('cn_items')->where('cn_id','=',$id)->delete();
		$poid = DB::table('invoices')->where('credit_note','LIKE','%'.$id.'%')->pluck('credit_note');
		$nid = explode(";",$poid);
		$newid = "";
		for ($n = 0; $n < count($nid); $n++)
		{
			if ($n == 0)
				$newid = "1";
			else if ($nid[$n] != $id)				
				$newid .= ";".$nid[$n];
		}
		DB::table('invoices')->where('credit_note','LIKE','%'.$id.'%')->update(array('credit_note'=>$newid));
		return Redirect::to('credit_notes');
	
	}
	public function enable_credit_note()
	{
		$id = Input::get('id');
		DB::table('credit_notes')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('credit_notes');
	}
	public function disable_credit_note()
	{
		$id = Input::get('id');
		DB::table('credit_notes')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('credit_notes');
	}

}
?>