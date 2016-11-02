<?php

class QuotationsController extends BaseController {
/**
* Display a listing of the resource.
*
* @return Response
*/
	protected $layout = "layouts.main";

	public function create_form()
	{

		$latestid = DB::table('quotations')->orderby('date_created','desc')->pluck('id');
		$latestid += 1;
		$aid = "QU";
		 for ($n = 0; $n < (5 - strlen($latestid)); $n++)
		 {
			 $aid .= "0";
		 }
		 $aid .= $latestid;
		 if(Input::get('quotation_id') != ""){
		 	 $QuotationEntry = QuotationEntry::find($latestid);
			 $deposit = $QuotationEntry->total_paid;
			 Session::put('deposit', $deposit);
		}
		 $staffs = DB::table('staffs')->orderby('name')->get();
		 $middlemen = DB::table('middlemen')->orderby('first_name')->get();
		 $products = DB::table('products')->where('status','=',1)->orderby('product_name')->get();
		 $unitPrice = DB::table('products')->lists('unit_price','id');
		 $sellingPrice = DB::table('products')->lists('selling_price','id');
		 $measurements = DB::table('products')->lists('measurements','id');
		 $clients = DB::table('clients')->orderby('first_name')->get();
		 $this->layout->content =  View::make('quotations.create')->with('measurements',$measurements)->with('aid',$aid)->with('middlemen',$middlemen)->with('staffs',$staffs)->with('clients',$clients)->with('products',$products)->with('unit_price',$unitPrice)->with('selling_price',$sellingPrice);
	}


	public function show_quotations()
	{
		$profile = DB::table('companyprofile')->first();
		$quotations = DB::table('quotations')->orderBy('id', 'DESC')->get();
		$this->layout->content =  View::make('quotations.manage')->with('quotations',$quotations)->with('profile',$profile);
	}


	public function store()
	{

		//print_r(Input::get('total_price'));exit;

		$rules = array(
			'quote_no'      => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('quotations/create')
				->withErrors($validator);
		} else if(Input::get('cnt') == null){

			Session::flash('message', 'Please choose at least one product!');
			return Redirect::to('quotations/create');

		}else {

			$get_quote_no = Input::get('quote_no');

			$check_quote_no = DB::table('quotations')->where('quote_no','=',$get_quote_no)->get();

			if ($check_quote_no) {
				Session::flash('aldid','Have');
				Session::flash('message', 'Quotation No. can not be same! ');
			    return Redirect::to('quotations/create');

			}else{				

			$QuotationEntry = new QuotationEntry;
			$QuotationEntry->quote_no	   = Input::get('quote_no');
			$QuotationEntry->client_id	   = Input::get('client');
			$QuotationEntry->total_price	   = Input::get('total_price');
			$QuotationEntry->sales_staff	   = Input::get('sales_staff');
			$QuotationEntry->total_paid	   = Input::get('deposit');
			$QuotationEntry->gst	   = Input::get('get_gstval');
			$QuotationEntry->gst_status	   = Input::get('gstopt');
			

			{{ (Input::get('middlemen') != '') ? $QuotationEntry->middleman	   = Input::get('middlemen') : $QuotationEntry->middleman= 0;}}
			$total = Input::get('deposit') - Input::get('total_price');
			$QuotationEntry->remarks	   = Input::get('remarks');

			if (Input::get('service_content') == "") {
				$QuotationEntry->service_content = 0;
			}else{
				$QuotationEntry->service_content = Input::get('service_content');
			}
			
			date_default_timezone_set('Asia/Singapore');
			$date = date('Y-m-d H:i:s', time());
			$QuotationEntry->date_created		   = $date;
			$QuotationEntry->updated_at		   = $date;
			$QuotationEntry->created_by		   = Auth::user()->id;
			$QuotationEntry->save();
			$lastid = DB::getPdo()->lastInsertId();

			$filter_pro = array();
			$required_quantity = array();
			for ($n = 0; $n < Input::get('cnt'); $n++)
			{
				if (Input::get('product_choice'.$n) == -2)
				{
					$QuotationItemEntry = new QuotationItemEntry;
					$QuotationItemEntry->quotation_id       = $lastid;
					$QuotationItemEntry->product_id	   = -1;
					$QuotationItemEntry->product_itemno = 0;
					$QuotationItemEntry->product_name	   = Input::get('free'.$n);
					$QuotationItemEntry->unit_price       = 0;
					$QuotationItemEntry->selling_price       = 0;
					$QuotationItemEntry->quantity       = 0;
					$QuotationItemEntry->description       = 0;
					$QuotationItemEntry->save();
				}
				else if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0)
				{
					$QuotationItemEntry = new QuotationItemEntry;
					$QuotationItemEntry->quotation_id       = $lastid;
					$pr = explode(';',Input::get('product_choice'.$n));

					$QuotationItemEntry->product_id	   = $pr[0];
					$get_itemno = ProductEntry::where('id', $pr[0])->pluck('product_itemno');

					$QuotationItemEntry->product_itemno = $get_itemno;
					$QuotationItemEntry->product_name	= $pr[1];

					$QuotationItemEntry->unit_price       = Input::get('unitprice'.$n);
					$pricef = Input::get('sellingprice'.$n);
					if (Input::get('pricetype'.$n) == 1)
					{
						//$pricef = -1;
						$QuotationItemEntry->status = 1;
					}

					$QuotationItemEntry->selling_price		   = $pricef;
					$QuotationItemEntry->quantity       = Input::get('quantity'.$n);
					$QuotationItemEntry->description       = Input::get('desc'.$n);

					/**********************/
					$get_qty_all1 = DB::table('quotation_items')->where('product_id','=',$pr[0])->sum('quantity');

					$get_qty_all = $get_qty_all1 + Input::get('quantity'.$n);

					$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
			        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

					$get_difqty = $get_pro_qty - $get_pro_minqty;

					if ($get_difqty < $get_qty_all) {
						$QuotationItemEntry->product_qty_status  = 'required';
					}else{
						$QuotationItemEntry->product_qty_status  = 'enough';
					}

					$QuotationItemEntry->save();

				}
				$get_pro_qty = ProductEntry::find($pr[0]);
				//$set_pro_status = 0;
				if($get_pro_qty->quantity < Input::get('quantity'.$n)){
					 array_push($filter_pro,$pr[0]);
					 array_push($required_quantity,array($pr[0],Input::get('quantity'.$n)));
					 //$set_pro_status = 1;
				}
				$find_quo_toupdate = QuotationEntry::find($lastid);

				$find_quo_toupdate->save();
			}
			$profile = DB::table('companyprofile')->first();
			$quotations = DB::table('quotations')->get();

			for($j=0;$j<count($required_quantity);$j++){
					$get_stocked_qty = DB::table('products')->where('id','=',$required_quantity[$j][0])->first();

					$searchandcount_proid = ProductStatusEntry::where('pro_id','=',$required_quantity[$j][0])->count();
					if($searchandcount_proid != 0){
						$ProductStatusController = ProductStatusEntry::where('pro_id','=',$required_quantity[$j][0])->first();
						$ProductStatusController->quo_id = $lastid;
						$get_total_qty = $required_quantity[$j][1] + $ProductStatusController->required_qty;
						$ProductStatusController->required_qty = $get_total_qty;
						date_default_timezone_set('Asia/Singapore');
						$date = date('Y-m-d H:i:s', time());
						$ProductStatusController->created_at   = $date;
						$ProductStatusController->updated_by   = Auth::user()->id;
						$ProductStatusController->save();
					}
					else{
						$get_new_stocked_qty = $get_stocked_qty->quantity - $get_stocked_qty->min_product_qty;
						$get_total_qty = $required_quantity[$j][1] - $get_new_stocked_qty;

						$ProductStatusController = new ProductStatusEntry();
						$ProductStatusController->pro_id = $required_quantity[$j][0];
						$ProductStatusController->quo_id = $lastid;

						$ProductStatusController->required_qty = $get_total_qty;
						date_default_timezone_set('Asia/Singapore');
						$date = date('Y-m-d H:i:s', time());
						$ProductStatusController->created_at    = $date;
						$ProductStatusController->updated_by     = Auth::user()->id;
						$ProductStatusController->save();
					}
			}

			return Redirect::to('quotations')->with('filter_pro',$filter_pro)->with('required_qty',$required_quantity);

			}//end if
		}
	}


	public function confirm_quotation(){
		$id = Input::get('id');

		$get_quoitem = QuotationItemEntry::where('quotation_id','=',$id)->get();
		$confirm = 0;
		$keep_pro = array();
		$keep_qty = array();
		$i=0;
		foreach ($get_quoitem as $key => $value) {

			$productentry = ProductEntry::where('id','=',$value->product_id)->first();

			$get_productentry = intval($productentry->quantity) - intval($productentry->min_product_qty);


			if($get_productentry >= $value->quantity){
				$productentry->quantity = intval($productentry->quantity) - intval($value->quantity);
				$confirm++;
				$productentry->save();
			}
			else{
				if($productentry->quantity > $value->quantity){
					$required_qty = $productentry->quantity - $value->quantity;
				}
				else{
					$required_qty = $value->quantity - $productentry->quantity;
				}
				array_push($keep_qty,$required_qty);
				array_push($keep_pro,$value->product_id);
			}
			$i++;
		}

		$count_quoitem= QuotationItemEntry::where('quotation_id','=',$id)->count();


		if($confirm == $count_quoitem){
			$getquo = QuotationEntry::find($id);
			$getquo->status = 1;
			$getquo->save();
		}

		return Redirect::to('quotations')->with('keep_pro',$keep_pro);
	}


	public function download_quotation()
	{
		$id = Input::get('id');
		$pid = "QU";
		for ($n = 0; $n < (5 - strlen($id)); $n++)
		{
		 $pid .= "0";
		}
		$pid .= $id;
		$quotationitems = DB::table('quotation_items')->where('quotation_id','=',$id)->get();
		$quotationcount = DB::table('quotation_items')->where('quotation_id','=',$id)->count();

		$quotations = QuotationEntry::find($id);
		$items = "";
		$n = 1;
		$m = 0;
		if ($quotations->client_id != -1)
		{
			$extraline = 11;
		}
		else{
			$extraline = 12;
		}

		$profile = DB::table('companyprofile')->first();

		$middlemen_reg_no = DB::table('middlemen')->where('id','=',$quotations->middleman)->pluck('reg_no');
		$middlemen_photo = DB::table('middlemen')->where('id','=',$quotations->middleman)->pluck('photo');

		$company_name = DB::table('middlemen')->where('id','=',$quotations->middleman)->pluck('first_name');

		if(isset($middlemen_photo) && $middlemen_photo != ""){
			$company_logo_url = $_SERVER["DOCUMENT_ROOT"] . '/bootstrap/img/'.$middlemen_photo;
		}else{
			$company_logo_url = $_SERVER["DOCUMENT_ROOT"] . '/images/no_logo.jpg';
		}		


		foreach ($quotationitems as $key =>$value)
		{
			if($extraline == $m || $quotationcount == $n){
				$addborder = "class='bot_border_style'";
			}
			else{
				$addborder = "";
			}
			//$itemno = preg_replace('/-/', ' ', $value->product_id);
			if ($value->status == 1)
			{
				$pricef = "Free of Charge";
				$sellingprice = 0;
				//$value->selling_price = 0;
			}
			else
			{
				$sellingprice = $value->selling_price;
			}
				$pricef = "<table style='width:100%'><tr><td></td><td style='width:100%;text-align:right'><div style='float:right;text-align:right'>$".$sellingprice."</div></td></tr></table>";
			if($value->product_id != -1){
				$items = $items."<tr><td style='padding:0;margin:0'><table width='500px' border='0' cellpadding='0' cellspacing='0' style='margin-left:1px;'><tr class='border-pro'><td width='40px' class='border-pro' style='height:55px;'><div style='text-align:center;'>".$n++."</div></td><td style='text-align:left;padding-left:10px;width:430px;' class='border-pro'> ".$value->product_name."</td><td width='40px' class='align_center border-pro'>".$value->quantity."</td><td width='80px' style='padding-left:10px;padding-right:10px;' class='border-pro'>".$pricef."</td><td width='94px' style='padding-left:10px padding-right:10px;' class='border-pro'><div style='text-align:left;' class='padd_add_full'><table style='width:100%' cellspacing='0' cellspacing='0'><tr><td></td><td style='width:100%;text-align:right'><div style='float:right;text-align:right;'>$".sprintf ("%.2f", $value->quantity*$sellingprice)."</div></td></tr></table></td></tr></table></td></tr><tr><td style='margin:0;padding:0;' ".$addborder."></td></tr>";
			}

			$m++;
			if($m > $extraline){
			$m = 0;
			}
		}

		$pdf = App::make('dompdf');date_default_timezone_set('UTC');
		if ($quotations->delivery_date == "0000-00-00")
			$deldate = "PENDING";
		else if ($quotations->delivery_date == "1111-11-11")
			$deldate = "SELF-COLLECT";
		else
			$deldate = $quotations->delivery_date;

		$date =	 date("d/m/Y");

		if ($quotations->service_content != "") {
			$service_content = $quotations->service_content;
		}else{
			$service_content = 0;
		}

		/*if ($quotations->gst_status == 'no_gst') {
			$aftGST = $quotations->total_price+($quotations->total_price * 0.00);
		}else if($quotations->gst_status == 'gst_already'){
			$aftGST = $quotations->total_price+($quotations->total_price * 0.00);
		}else{
			$aftGST = $quotations->total_price+($quotations->total_price * 0.07);
		}*/

		$aftGST = $quotations->total_price + $quotations->gst;
		
		$staffname = DB::table('staffs')->where('id','=',$quotations->sales_staff)->pluck('name');


		if ($quotations->client_id != -1)
		{
			$billedto = DB::table('clients')->where('id','=',$quotations->client_id)->first();
			$buildhTML = '<html><head>
							  <style>
							   body, html {
									margin:0px;
									padding:0px;
								}
								@page {
									margin: 80px 60px 30px 30px !important;
								}
							    .footer { width:720px;height:300px;}
							      body, table,{font-weight: bold; font-size:12px;padding:0;margin:0;}.nobreak{page-break-inside:avoid !important;}.full{width: 100%;}.terms, .Remarks{font-size: 0.8em;}.thirty{width: 30%;}.twenty{width: 20%;}.bold{font-weight: 700;}.right{text-align: right;}h2{margin: 5px;}.border{border: 1px solid #222; border-collapse: collapse; text-align: center;}.underlines{text-decoration: underline;}.taxinvoiceheader{border: 1px solid #222;  background: #AAA; height:35px; text-align: center; width: 30%; font-size: 25px; font-weight: 700;}.taxinvoicebody{border: 1px solid #222; width: 100%; font-size: 17px;padding-top:10px;}
							      .border_style{
							      	border:1px solid #000;
							      	text-align:center;
							      }.bot_border_style{background:#000;border-bottom:1px solid #000;}.padd_add{padding-left:10px;}.padd_add_full{padding:10px 10px 10px 0;}
							      .align_center{text-align:center;}.align_right{text-align:right;}.border-pro{border-left:1px solid #000;border-right:1px solid #000;}
							      thead,tfoot{font-size:12px;}

							  </style>
							</head>
							<body>
							     <table cellspacing="0" cellspacing="0" border="0"  width="720px"><tr><th><table class="full" border="0" cellpadding="0" cellspacing="0"> <tr> <td class="thirty" style="text-align:center"> <img src="'.$company_logo_url.'" style="max-width:150px"> <br>Co Reg No : '.$middlemen_reg_no.'</td><td><div style="width:300px;padding-left:200px !important;"><h2 style="margin-left:0px;">'.$company_name.'</h2><br/></div></td></tr></table>
							    <div class="taxinvoiceheader">Quotation</div><div class="taxinvoicebody"> <table class="full bold" rules="cols" border="0" cellpadding="0" cellspacing="0"><tr> <td style="width:80px" class="padd_add">Billed To </td><td style="width:300px">: '.$billedto->first_name." ".$billedto->last_name.'</td><td style="width:120px" class="padd_add">Quotation No </td><td>: '.$quotations->quote_no.'</td></tr><tr> <td class="padd_add">Tel </td><td>: '.$billedto->mobile_contact.'</td><td class="padd_add">Date </td><td>: '.$date.'</td></tr><tr> <td class="padd_add">Address </td><td>: '.$billedto->delivery_address.'</td><td class="padd_add">Sales Staff </td><td>: '.$staffname.'</td></tr><tr> <td class="padd_add">Company</td><td>: '.$billedto->organization.'</td><td class="padd_add" style="display:none;">Delivery Date</td><td style="display:none;">: '.$deldate.'</td></tr><tr> <td colspan="2"></td><td class="padd_add" style="display:none;">Payment mode</td><td style="display:none;">: '.$quotations->payment_mode.'</td></tr><tr><td colspan="5">&nbsp;</td></tr><tr><td colspan="5"><table border="0" cellpadding="0" cellspacing="0"><tr style="background:#AAA;border-top:1px solid #000;" class="nobreak"> <td style="width:40px;" class="border_style">No</td><td style="width:440px;" class="border_style">Product Name</td><td style="width:40px;" class="border_style">Qty</td><td style="width:100px;" class="border_style">Unit Price</td><td style="width:103px;" class="border_style">Amount</td></tr></table></td></tr></table> </div></th></tr>
							  <tbody  width="720px">
							  '.$items.'
				<tr><td><table cellspacing="0" cellspacing="0" border="0">
				<tr><td width="523px">&nbsp;</td><td width="90px;" class="padd_add_full">Service Content :</td><td class="border_style align_right padd_add_full" width="94px">$'.$quotations->service_content.'</td></tr>
				<tr><td width="523px">&nbsp;</td><td width="90px;" class="padd_add_full">Total Amount :</td><td class="border_style align_right padd_add_full" width="94px">$'.number_format($quotations->total_price,2).'</td></tr>';

				if ($quotations->gst_status == 'no_gst') {
					$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">No GST</td></tr>';
				}else if($quotations->gst_status == 'gst_already'){
						$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">GST already included</td></tr>';
				}else{
					$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">7% GST :</td><td class="border_style align_right padd_add_full">$'.$quotations->gst.'</td></tr>';
				}


				$buildhTML .= '<tr><td>&nbsp;</td> <td class="padd_add_full">Total :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Deposit :</td><td class="border_style align_right padd_add_full">$'.number_format($quotations->total_paid,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Balance :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST - $quotations->total_paid,2).'</td></tr></table>
				</td></tr>
				<tr><td> <div class="footer">
							   <table border="0" cellpadding="0" cellspacing="0" width="720px" style="margin-top:200px;"><tr><td> <div><span style="padding-right:20px;">Remarks:</span>'.$quotations->remarks.'</div><br/> <br/><br/></div></td>
							   </tr><tr><td><div style="margin-top:30px !important;"> <hr/>Authorised Signature</div></td></tr></table>
							  </div>	</td></tr>
				</tbody></table>
							</body>
							</html>';

		}
		else
		{
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
					      body, table{font-weight: bold; font-size: 12px;padding:0;margin:0}.nobreak{page-break-inside:avoid !important;}.full{width: 100%;}.terms, .Remarks{font-size: 0.8em;}.thirty{width: 30%;}.twenty{width: 20%;}.bold{font-weight: 700;}.right{text-align: right;}h2{margin: 5px;}.border{border: 1px solid #222; border-collapse: collapse; text-align: center;}.underlines{text-decoration: underline;}.taxinvoiceheader{border: 1px solid #222;  background: #AAA; height:35px; text-align: center; width: 30%; font-size: 25px; font-weight: 700;}.taxinvoicebody{border: 1px solid #222; width: 100%; font-size: 17px; padding-top:10px; }
					      .border_style{
					      	border:1px solid #000;
					      	text-align:center;
					      }.bot_border_style{background:#000;border-bottom:1px solid #000;}.padd_add{padding-left:10px;}.padd_add_full{padding:10px 10px 10px 0;}
					      .align_center{text-align:center;}.align_right{text-align:right;}.border-pro{border-left:1px solid #000;border-right:1px solid #000;}
					     	thead,tfoot{font-size:12px;}
					  </style>
					</head>
					<body>
					     <table cellspacing="0" cellspacing="0" border="0" width="720px"><tr><th><table class="full" border="0" cellpadding="0" cellspacing="0"> <tr> <td class="thirty" style="text-align:center"> <img src="'.$company_logo_url.'" style="max-width:150px"> <br>Co Reg No : '.$middlemen_reg_no.'</td><td><div style="width:300px;padding-left:200px !important;"><h2 style="margin-left:0px;">'.$company_name.'</h2><br/></div></td></tr></table>
					    <div class="taxinvoiceheader">Quotation</div><div class="taxinvoicebody"> <table class="full bold" rules="cols" border="0" cellpadding="0" cellspacing="0"> <tr> <td style="width:80px" class="padd_add">Billed To </td><td style="width:300px;" >: Cash n Carry</td><td style="width:110px;" class="padd_add">Quotation No </td><td style="width:200px;">: '.$quotations->quote_no.'</td></tr><tr> <td> </td> <td> </td><td class="padd_add">Date </td><td>: '.$date.'</td><td></td></tr><tr> <td> </td> <td> </td><td class="padd_add">Sales Staff </td><td>: '.$staffname.'</td> </tr><tr><td colspan="5">&nbsp;</td></tr><tr><td colspan="5"><table border="0" cellpadding="0" cellspacing="0"><tr style="background:#AAA;border-top:1px solid #000;" class="nobreak"> <td style="width:40px;" class="border_style">No</td><td style="width:440px;" class="border_style">Product Name</td><td style="width:40px;" class="border_style">Qty</td><td style="width:100px;" class="border_style">Unit Price</td><td style="width:103px;" class="border_style">Amount</td></tr></table></td></tr></table> </div></th></tr>
					  <tbody  width="720px">
					  '.$items.'
					<tr><td><table cellspacing="0" cellspacing="0" border="0">
					<tr><td width="523px">&nbsp;</td><td width="90px;" class="padd_add_full">Service Content :</td><td class="border_style align_right padd_add_full" width="94px">$'.$quotations->service_content.'</td></tr>
					<tr><td width="523px">&nbsp;</td><td width="90px;" class="padd_add_full">Total Amount :</td><td class="border_style align_right padd_add_full" width="94px">$'.number_format($quotations->total_price,2).'</td></tr>';

					if ($quotations->gst_status == 'no_gst') {
						$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">No GST</td></tr>';
					}else if($quotations->gst_status == 'gst_already'){
							$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">GST already included</td></tr>';
					}else{
						$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">7% GST :</td><td class="border_style align_right padd_add_full">$'.$quotations->gst.'</td></tr>';
					}



					$buildhTML .= '<tr><td>&nbsp;</td> <td class="padd_add_full">Total :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Deposit :</td><td class="border_style align_right padd_add_full">$'.number_format($quotations->total_paid,2).'</td></tr><tr><td>&nbsp;</td> <td class="padd_add_full">Balance :</td><td class="border_style align_right padd_add_full">$'.number_format($aftGST - $quotations->total_paid,2).'</td></tr></table>
					</td></tr>
					<tr><td> <div class="footer">
								   <table border="0" cellpadding="0" cellspacing="0" width="720px" style="margin-top:200px;"><tr><td> <div><span style="padding-right:20px;">Remarks:</span>'.$quotations->remarks.'</div><br/> <br/><br/></div></td>
								   </tr><tr><td><div style="margin-top:30px !important;"> <hr/>Authorised Signature</div></td></tr></table>
								  </div>	</td></tr>
					</tbody></table>
					</body>
					</html>';


		}
		$pdf->loadHTML($buildhTML);


		return $pdf->download($quotations->quote_no.".pdf");


	}


	public function save_edit()
	{
		//dd(Input::all());
		$n = 0;

		$get_quote_no = Input::get('quote_no');

		$check_quote_no = DB::table('quotations')->where('quote_no','=',$get_quote_no)->count();
		
		if ($check_quote_no > 1) {			
			Session::flash('message', 'Quotation No. can not be same! ');
		    return Redirect::to('quotations/'.Input::get('quotation_id'));
		}else{

			$QuotationEntry = QuotationEntry::find(Input::get('quotation_id'));
			$QuotationEntry->quote_no	   = Input::get('quote_no');

			if (Input::get('service_content') == "") {
				$QuotationEntry->service_content = 0;
			}else{
				$QuotationEntry->service_content = Input::get('service_content');
			}
			
			$QuotationEntry->client_id	   = Input::get('client');
			$QuotationEntry->total_price	   = Input::get('total_price');
			$QuotationEntry->total_paid	   = Input::get('deposit');
			$QuotationEntry->gst	   = Input::get('get_gstval');
			$QuotationEntry->gst_status	   = Input::get('gstopt');

			if (Input::get('delivery_address') != "")
				$QuotationEntry->delivery_address	   = Input::get('delivery_address');
			if ($QuotationEntry->sales_staff	   != Input::get('sales_staff'))
				$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited sales staff from ".$QuotationEntry->sales_staff." to ".Input::get('sales_staff');
			$QuotationEntry->sales_staff	   = Input::get('sales_staff');
			if ($QuotationEntry->middleman	   != Input::get('middlemen'))
				$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited middleman from ".$QuotationEntry->middleman." to ".Input::get('middlemen');
			$QuotationEntry->middleman	   = Input::get('middlemen');
			if ($QuotationEntry->middleman	   != Input::get('middlemen'))
				$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited payment mode from ".$QuotationEntry->payment_mode." to ".Input::get('payment_mode');
			if (Input::get('delivery_type') == 1)
				$dt = "SELF-COLLECT";
			else if (Input::get('delivery_date') == "0000-00-00")
				$dt = "PENDING";
			else
				$dt =Input::get('delivery_date');

			if ($QuotationEntry->delivery_date == "1111-11-11")
				$stt = "SELF-COLLECT";

			else if ($QuotationEntry->delivery_date == "0000-00-00")
				$stt = "PENDING";
			else
				$stt =$QuotationEntry->delivery_date;

			if ($QuotationEntry->delivery_date != Input::get('delivery_date'))
				$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited delivery date from ".$stt." to ".$dt;

			if (Input::get('delivery_type') == 1)
				$dd = "1111-11-11";
			else
				$dd = Input::get('delivery_date');

			$total = $QuotationEntry->total_paid - Input::get('total_price');

			$QuotationEntry->remarks	   = Input::get('remarks');
			date_default_timezone_set('Asia/Singapore');
			$date = date('Y-m-d H:i:s', time());
			$QuotationEntry->updated_at		   = $date;
			$QuotationEntry->created_by		   = Auth::user()->id;
			$QuotationEntry->save();

			DB::table('quotation_items')->where('quotation_id','=',Input::get('quotation_id'))->delete();

			for ($h = 0; $h < Input::get('cnt'); $h++)
			{
				  if (Input::get('product_choice'.$h) == -2)
					{

						$QuotationItemEntry = QuotationItemEntry::find(Input::get('hid'.$h));
						if ($QuotationItemEntry->product_id	   != -1)
						{
								$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited a product from ".$QuotationItemEntry->product_name." to ".Input::get('free'.$n);
						}
						$QuotationItemEntry->product_id	   = -1;
						$QuotationItemEntry->product_name	   = Input::get('free'.$h);
						$QuotationItemEntry->unit_price       = 0;
						$QuotationItemEntry->selling_price       = 0;
						$QuotationItemEntry->quantity       = 0;
						$QuotationItemEntry->description       = 0;
						$QuotationItemEntry->save();
					}
					else if (Input::get('product_choice'.$h) != -1 && Input::get('quantity'.$h) > 0)
					{
						

						$check_new = Input::get('new'.$h);
						if($check_new == 0){

							//$QuotationItemEntry = QuotationItemEntry::find(Input::get('hid'.$h));
							$QuotationItemEntry = new QuotationItemEntry;
							$QuotationItemEntry->quotation_id       = Input::get('quotation_id');
							$pr = explode(';',Input::get('product_choice'.$h));


							if ($pr[0]	  != $QuotationItemEntry->product_id)
								$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited a product from ".$QuotationItemEntry->product_name." to ".$pr[1];
					         if (count($pr) > 1)
							{

								$QuotationItemEntry->product_id	   = $pr[0];
								$QuotationItemEntry->product_name	   = $pr[1];
								$QuotationItemEntry->unit_price       = Input::get('unitprice'.$h);
								$pricef = Input::get('sellingprice'.$h);
								if (Input::get('pricetype'.$h) == 1)
								{
									//$pricef = -1;
									$QuotationItemEntry->status = 1;
								}
								else{
									$QuotationItemEntry->status = 0;
								}
								$QuotationItemEntry->selling_price		   = $pricef;
								$QuotationItemEntry->quantity       = Input::get('quantity'.$h);
								$QuotationItemEntry->description       = Input::get('desc'.$h);

								$QuotationItemEntry->save();

								$quo_lastid = DB::getPdo()->lastInsertId();



								/**********************/
								$get_qty_all = DB::table('quotation_items')->where('product_id','=',$pr[0])->sum('quantity');

								$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
						        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

								$get_difqty = $get_pro_qty - $get_pro_minqty;


								if ($get_difqty < $get_qty_all) {
									$product_qty_status  = 'required';
								}else{
									$product_qty_status  = 'enough';
								}

								DB::table('quotation_items')->where('id','=',$quo_lastid)->update(array('product_qty_status'=>$product_qty_status));

							}
						}
						else if($check_new == 1){
							$pr = explode(';',Input::get('product_choice'.$h));
							$QuotationItemEntry = new QuotationItemEntry;
							$QuotationItemEntry->quotation_id       = Input::get('quotation_id');
							$QuotationItemEntry->product_id	   = $pr[0];
							$QuotationItemEntry->product_name	   = $pr[1];
							$QuotationItemEntry->unit_price       = Input::get('unitprice'.$h);
							$pricef = Input::get('sellingprice'.$h);
							$QuotationItemEntry->selling_price= $pricef;
							$QuotationItemEntry->quantity      = Input::get('quantity'.$h);
							$QuotationItemEntry->description    = Input::get('desc'.$h);
							if (Input::get('pricetype'.$h) == 1)
							{
								$QuotationItemEntry->status = 1;
							}
							else{
								$QuotationItemEntry->status = 0;
							}
							$QuotationItemEntry->save();
						}
					}
					else if (Input::get('product_choice'.$h) == -1)
					{
						if(Input::get('edit_quo') == 1){
							$pr = explode(';',Input::get('product_choice'.$h));
							if ($QuotationEntry->product_id	   != $pr[0])
								$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." deleted product ".$QuotationItemEntry->product_name;

							$QuotationItemEntry = QuotationItemEntry::find(Input::get('hid'.$h));
							$QuotationItemEntry->delete();
						}
					}
					else{
						$pr = explode(';',Input::get('product_choice'.$h));
						$QuotationItemEntry = new QuotationItemEntry;
						$QuotationItemEntry->quotation_id       = Input::get('quotation_id');
						$QuotationItemEntry->product_id	   = $pr[0];
						$QuotationItemEntry->product_name	   = $pr[1];
						$QuotationItemEntry->unit_price       = Input::get('unitprice'.$h);
						$pricef = Input::get('sellingprice'.$h);
						$QuotationItemEntry->selling_price= $pricef;
						$QuotationItemEntry->quantity      = Input::get('quantity'.$h);
						$QuotationItemEntry->description    = Input::get('desc'.$h);
						if (Input::get('pricetype'.$h) == 1)
						{
							$QuotationItemEntry->status = 1;
						}
						else{
							$QuotationItemEntry->status = 0;
						}
						$QuotationItemEntry->save();
					}
			}

			for ($i = 0; $i < $n; $i++)
			{
				date_default_timezone_set ('Asia/Singapore');
				$date = date('Y-m-d H:i:s');
				$logentry = new LogEntry;
				$logentry->entity_id = Input::get('quotation_id');
				$logentry->log = $log[$i];
				$logentry->date = $date;
				$logentry->save();
			}
			return Redirect::to('quotations');

		}//end if
	}


	public function edit_quotation($id)
	{
		$products = DB::table('products')->where('status','=',1)->get();
		$unitPrice = DB::table('products')->lists('unit_price','id');
		$sellingPrice = DB::table('products')->lists('selling_price','id');
		$measurements = DB::table('products')->lists('measurements','id');
		 $staffs = DB::table('staffs')->orderby('name')->get();
		 $middlemen = DB::table('middlemen')->orderby('first_name')->get();
		$logs = DB::table('logs')->where('entity_id','=',$id)->get();
		$clients = DB::table('clients')->get();
		$aid = "QU";
		 for ($n = 0; $n < (5 - strlen($id)); $n++)
		 {
			 $aid .= "0";
		 }
		 $aid .= $id;
		$quotationitems = DB::table('quotation_items')->where('quotation_id','=',$id)->get();
		$quotations = QuotationEntry::find($id);
		 return View::make('quotations.edit')->with('middlemen',$middlemen)->with('staffs',$staffs)->with('logs',$logs)
            ->with('aid',$aid)->with('measurements',$measurements)->with('quotations', $quotations)->with('inv',$quotationitems)
			->with('clients',$clients)->with('products',$products)->with('unit_price',$unitPrice)->with('selling_price',$sellingPrice);
	}


	public function view_quotation($id)
	{
		$quotationitems = DB::table('quotation_items')->where('quotation_id','=',$id)->get();
		$logs = DB::table('logs')->where('entity_id','=',$id)->get();
		$quotations = QuotationEntry::find($id);
		 return View::make('quotations.view')
            ->with('id',$id)->with('logs',$logs)->with('quotation', $quotations)->with('inv',$quotationitems);
	}


	public function delete_quotation()
	{
		$id = Input::get('id');
		DB::table('quotations')->where('id','=',$id)->delete();
		DB::table('quotation_items')->where('quotation_id','=',$id)->delete();
		return Redirect::to('quotations');
	}


	public function enable_quotation()
	{
		$id = Input::get('id');
		DB::table('quotations')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('quotations');
	}
	public function disable_quotation()
	{
		$id = Input::get('id');
		DB::table('quotations')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('quotations');
	}
	public function getprice()
	{
		return Response::json('asd');
		$id = Input::get('products');
		$price = DB::table('products')->where('id','=',$id)->pluck('selling_price');
		$prices = [$price];
		return Response::json($prices);
	}
}
?>