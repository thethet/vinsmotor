<?php

class InvoicesController extends BaseController {
	/**
	* Display a listing of the resource.
	*
	* @return Response
	*/
	protected $layout = "layouts.main";

	public function create_form()
	{
		$latestid 	= DB::table('invoices')->orderby('date_created','desc')->pluck('id');
		$latestid 	+= 1;
		$aid 		= "INV";
		for ($n = 0; $n < (5 - strlen($latestid)); $n++) {
			$aid .= "0";
		}
		$aid 					.= $latestid;
		$staffs 				= DB::table('staffs')->orderby('name')->get();
		$middlemen 				= DB::table('middlemen')->orderby('first_name')->get();
		$products 				= DB::table('products')->where('status','=',1)->orderby('product_name')->get();
		$unitPrice 				= DB::table('products')->lists('unit_price','id');
		$sellingPrice 			= DB::table('products')->lists('selling_price','id');
		$measurements 			= DB::table('products')->lists('measurements','id');
		$clients 				= DB::table('clients')->orderby('first_name')->get();
		$this->layout->content 	=  View::make('invoices.create')->with('measurements',$measurements)->with('aid',$aid)->with('middlemen',$middlemen)->with('staffs',$staffs)->with('clients',$clients)->with('products',$products)->with('unit_price',$unitPrice)->with('selling_price',$sellingPrice);
	}

	public function pass_form()
	{
		$latestid 	= DB::table('invoices')->orderby('date_created','desc')->pluck('id');
		$latestid 	+= 1;
		$aid 		= "INV";
		for ($n = 0; $n < (5 - strlen($latestid)); $n++) {
			$aid .= "0";
		}
		$aid 					.= $latestid;
		$staffs 				= DB::table('staffs')->orderby('name')->get();
		$middlemen 				= DB::table('middlemen')->orderby('first_name')->get();
		$products 				= DB::table('products')->where('status','=',1)->orderby('product_name')->get();
		$unitPrice 				= DB::table('products')->lists('unit_price','id');
		$sellingPrice 			= DB::table('products')->lists('selling_price','id');
		$measurements 			= DB::table('products')->lists('measurements','id');
		$clients 				= DB::table('clients')->orderby('first_name')->get();
		$quotationid 			= Input::get('quotation_id');
		$quot 					= QuotationEntry::where('id','=',$quotationid)->first();
		$quotationitems 		= QuotationItemEntry::where('quotation_id','=',$quotationid)->get();
		$this->layout->content 	= View::make('invoices.create')->with('measurements',$measurements)->with('aid',$aid)->with('middlemen',$middlemen)->with('staffs',$staffs)->with('clients',$clients)->with('products',$products)->with('unit_price',$unitPrice)->with('selling_price',$sellingPrice)->with('quotationitems',$quotationitems)->with('quot',$quot)->with('quotationid',$quotationid);
	}

	public function confirm_invoice(){

		$id 			= Input::get('id');
		$get_invitem 	= InvoiceItemEntry::where('invoice_id','=',$id)->get();
		$confirm 		= 0;
		$keep_pro 		= array();
		$keep_qty 		= array();
		$i 				= 0;
		foreach ($get_invitem as $key => $value) {
			$productentry 		= ProductEntry::where('id','=',$value->product_id)->first();
			$get_productentry 	= intval($productentry->quantity) - intval($productentry->min_product_qty);

			if($get_productentry >= $value->quantity) {
				$productentry->quantity = intval($productentry->quantity) - intval($value->quantity);
				$confirm++;
				$productentry->save();
			} else {
				if($productentry->quantity > $value->quantity) {
					$required_qty = $productentry->quantity - $value->quantity;
				} else {
					$required_qty = $value->quantity - $productentry->quantity;
				}
				array_push($keep_qty,$value->quantity);
				array_push($keep_pro,$value->product_id);
			}
			$i++;
		}

		$count_invitem = InvoiceItemEntry::where('invoice_id','=',$id)->count();

		

		if($confirm == $count_invitem) {
			$getinv = InvoiceEntry::find($id);
			$getinv->status = 1;
			$getinv->save();
		}
		return Redirect::to('invoices')->with('keep_pro',$keep_pro);
	}

	public function show_invoices()
	{
		$profile 				= DB::table('companyprofile')->first();
		$invoices 				= DB::table('invoices')->orderBy('id', 'desc')->get();
		$this->layout->content 	=  View::make('invoices.manage')->with('invoices',$invoices)->with('profile',$profile);
	}

	public function pay_money()
	{
		$entry 			= InvoiceEntry::find(Input::get('payto'));
		$entry->increment('total_paid', Input::get('payment'));
		$client 		= InvoiceEntry::where('id','=',Input::get('payto'))->pluck('client_id');
		ClientEntry::find($client)->increment('balance',Input::get('payment'));
		return Redirect::to('invoices');
	}

	public function store()
	{
		//print_r(Input::get('total_price'));exit;

		$rules = array(
			'invoice_no'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::to('invoices/create')->withErrors($validator);
		} else if(Input::get('cnt') == null){

			Session::flash('message', 'Please choose at least one product!');
			return Redirect::to('invoices/create');

		}else {

			$get_invoice_no = Input::get('invoice_no');

			$check_invoice_no = DB::table('invoices')->where('invoice_no','=',$get_invoice_no)->get();

			if ($check_invoice_no) {
				Session::flash('aldid','Have');
				Session::flash('message', 'Invoice No. can not be same! ');
			    return Redirect::to('invoices/create');

			}else{		

			$InvoiceEntry 					= new InvoiceEntry;
			$InvoiceEntry->invoice_no	   	= Input::get('invoice_no');
			$InvoiceEntry->client_id	   	= Input::get('client');

			$quotationid = Input::get('quotationid');
			if ($quotationid != -1) {
				if (Input::get('service_content') == "") {
					$InvoiceEntry->total_price	   	= Input::get('q_total_price');
				}else{
					$InvoiceEntry->total_price	   	= Input::get('q_total_price')+Input::get('service_content');
				}
				
			}else{
				$InvoiceEntry->total_price	   	= Input::get('total_price');
			}
			//$InvoiceEntry->total_price	   	= Input::get('total_price');
			$InvoiceEntry->gst	   = Input::get('get_gstval');
			$InvoiceEntry->gst_status	   = Input::get('gstopt');
			$InvoiceEntry->sales_staff	   	= Input::get('sales_staff');
			$InvoiceEntry->payment_mode	   	= Input::get('payment_mode');
			$InvoiceEntry->installation	   	= Input::get('installation');
			$InvoiceEntry->total_paid	   	= Input::get('deposit');
			if (Input::get('service_content') == "") {
				$InvoiceEntry->service_content = 0;
			}else{
				$InvoiceEntry->service_content = Input::get('service_content');
			}
			if(Input::get('middlemen') != "") {
				$InvoiceEntry->middleman	   = Input::get('middlemen');
			} else {
				$InvoiceEntry->middleman	   = 0;
			}

			//$quotationid = Input::get('quotationid');


			if (Input::get('delivery_address') != "")
				$InvoiceEntry->delivery_address	   = Input::get('delivery_address');
			if (Input::get('delivery_type') == 1)
				$dd = "1111-11-11";
			else
				$dd = Input::get('delivery_date');
			$total = Input::get('deposit') - Input::get('total_price');
			if (Input::get('client') != -1)
				ClientEntry::find(Input::get('client'))->increment('balance',$total);
			// $InvoiceEntry->delivery_date	   	= $dd;
			$InvoiceEntry->delivery_date	   	= '2000-10-10';
			$InvoiceEntry->remarks	   			= Input::get('remarks');
			date_default_timezone_set('Asia/Singapore');
			$date 								= date('Y-m-d H:i:s', time());
			$InvoiceEntry->date_created		   	= $date;
			$InvoiceEntry->updated_at		   	= $date;
			$InvoiceEntry->created_by		   	= Auth::user()->id;
			/*if($quotationid != -1){
				$InvoiceEntry->status = 1;
			}*/

			$InvoiceEntry->save();
			$lastid = DB::getPdo()->lastInsertId();

			for ($n = 0; $n < Input::get('cnt'); $n++) {
				if (Input::get('product_choice'.$n) == -2) {
					$InvoiceItemEntry 					= new InvoiceItemEntry;
					$InvoiceItemEntry->invoice_id       = $lastid;
					$InvoiceItemEntry->product_id	   	= -1;
					$InvoiceItemEntry->product_itemno 	= 0;
					$InvoiceItemEntry->product_name	   	= Input::get('free'.$n);
					$InvoiceItemEntry->unit_price       = 0;
					$InvoiceItemEntry->selling_price    = 0;
					$InvoiceItemEntry->quantity       	= 0;
					$InvoiceItemEntry->description      = 0;
					$InvoiceItemEntry->save();
				} else if (Input::get('product_choice'.$n) != -1 && Input::get('quantity'.$n) > 0) {
					$InvoiceItemEntry 					= new InvoiceItemEntry;
					$InvoiceItemEntry->invoice_id       = $lastid;
					$pr 								= explode(';',Input::get('product_choice'.$n));
					$InvoiceItemEntry->product_id	   	= $pr[0];
					$get_itemno 						= ProductEntry::where('id', $pr[0])->pluck('product_itemno');
					$InvoiceItemEntry->product_itemno 	= $get_itemno;
					$InvoiceItemEntry->product_name	   	= $pr[1];
					$InvoiceItemEntry->unit_price       = Input::get('unitprice'.$n);
					$pricef 							= Input::get('sellingprice'.$n);
					if (Input::get('pricetype'.$n) == 1) {
						$InvoiceItemEntry->status = 1;
					} else {
						$InvoiceItemEntry->status = 0;
					}
					$InvoiceItemEntry->selling_price	= $pricef;
					$InvoiceItemEntry->quantity 		= Input::get('quantity'.$n);
					$InvoiceItemEntry->description 		= Input::get('desc'.$n);

					/**********************/
					$get_qty_all1 = DB::table('invoice_items')->where('product_id','=',$pr[0])->sum('quantity');

					$get_qty_all = $get_qty_all1 + Input::get('quantity'.$n);

					$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
			        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

					$get_difqty = $get_pro_qty - $get_pro_minqty;

					if ($get_difqty < $get_qty_all) {
						$InvoiceItemEntry->product_qty_status  = 'required';
					}else{
						$InvoiceItemEntry->product_qty_status  = 'enough';
					}

					$InvoiceItemEntry->save();
					
				}
			}

			if ($quotationid != -1) {
				DB::table('quotations')->where('id','=',$quotationid)->update(array( 'invoice'=>$lastid ));
			}
			return Redirect::to('invoices');

			}//end if
		}
	}

	public function download_invoice()
	{
		$id 	= Input::get('id');
		$pid 	= "INV";
		for ($n = 0; $n < (5 - strlen($id)); $n++) {
			$pid .= "0";
		}
		$pid 			.= $id;
		$invoiceitems 	= DB::table('invoice_items')->where('invoice_id','=',$id)->get();
		$invoicecount 	= DB::table('invoice_items')->where('invoice_id','=',$id)->count();
		$invoices 		= InvoiceEntry::find($id);
		if ($invoices->middleman > 0) {
			$middledet 			= "Contact ";
			$middelmenname 		= ": " . MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('first_name') . " " . MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('last_name');
			$middlemencondet 	= "Mobile ";
			$middlemencontact 	= ": " . MiddlemenEntry::where('id','=',$invoices->middleman)->pluck('mobile_contact');
		} else  {
			$middledet 			= "";
			$middelmenname 		= "";
			$middlemencondet 	= "";
			$middlemencontact 	= "";
		}
		$items 	= "";
		$n 		= 1;
		$m 		= 0;
		if ($invoices->client_id != -1) {
			$extraline = 11;
		} else {
			$extraline = 12;
		}

		$profile = DB::table('companyprofile')->first();

		$middlemen_reg_no = DB::table('middlemen')->where('id','=',$invoices->middleman)->pluck('reg_no');
		$middlemen_photo = DB::table('middlemen')->where('id','=',$invoices->middleman)->pluck('photo');

		if(isset($middlemen_photo) && $middlemen_photo != ""){
			$company_logo_url = $_SERVER["DOCUMENT_ROOT"] . '/bootstrap/img/'.$middlemen_photo;
		}else{
			$company_logo_url = $_SERVER["DOCUMENT_ROOT"] . '/images/no_logo.jpg';
		}	

		$company_name = DB::table('middlemen')->where('id','=',$invoices->middleman)->pluck('first_name');

		foreach ($invoiceitems as $key =>$value) {
			if($extraline == $m || $invoicecount == $n) {
				$addborder = "class='bot_border_style'";
			} else {
				$addborder = "";
			}
			if ($value->status == 1) {
				$pricef = "Free of Charge";
				$sellingprice = 0;
				//$value->selling_price = 0;
			} else {
				$sellingprice = $value->selling_price;
			}

			$pricef = "<table class='nobreak' border='0' cellpadding='0' cellspacing='0' width='80px'><tr><td>$</td><td style'text-align:right'><div style='text-align:right'> ".$sellingprice."</div></td></tr></table>";
			if ($value->product_id != -1){
				$items = $items."<tr><td style='padding:0;margin:0'><table width='720px' border='0' cellpadding='0' cellspacing='0' style='margin-left:1px;'><tr class='border-pro'><td width='40px' class='border-pro' style='height:55px;'><div style='text-align:center;'>".$n++."</div></td><td style='text-align:left;padding-left:10px;width:430px;' class='border-pro'> ".$value->product_name."</td><td width='40px' class='align_center border-pro'>".$value->quantity."</td><td width='80px' style='padding-left:10px;padding-right:10px;' class='border-pro'>".$pricef."</td><td width='104px' class='border-pro'><div style='text-align:left;' class='padd_add'><table style='width:100%' cellspacing='0' cellspacing='0'><tr><td>$</td><td style='width:100%;text-align:right'><div style='float:right;text-align:right;padding-right:10px;'>".sprintf ("%.2f", $value->quantity*$sellingprice)."</div></td></tr></table></td></tr></table></td></tr><tr><td style='margin:0;padding:0;' ".$addborder."></td></tr>";
			}
			$m++;
			if($m > $extraline) {
				$m = 0;
			}
		}

		$pdf = App::make('dompdf');date_default_timezone_set('UTC');
		if ($invoices->delivery_date == "0000-00-00")
			$deldate = "PENDING";
		else if ($invoices->delivery_date == "1111-11-11")
			$deldate = "SELF-COLLECT";
		else
			$deldate = $invoices->delivery_date;

		$date 		=	 date("d/m/Y");

		if ($invoices->service_content != "") {
			$service_content = $invoices->service_content;
		}else{
			$service_content = 0;
		}

		
		/*if ($invoices->gst_status == 'no_gst') {
			$aftGST = $invoices->total_price+($invoices->total_price * 0.00);
		}else if($invoices->gst_status == 'gst_already'){
			$aftGST = $invoices->total_price+($invoices->total_price * 0.00);
		}else{
			$aftGST = $invoices->total_price+($invoices->total_price * 0.07);
		}*/

		$aftGST = $invoices->total_price + $invoices->gst;

		$staffname 	= DB::table('staffs')->where('id','=',$invoices->sales_staff)->pluck('name');
		if ($invoices->client_id != -1) {
			$billedto = DB::table('clients')->where('id','=',$invoices->client_id)->first();
			$buildhTML = '<html>
							<head>
							    <style>
							    body,
							    html {
							        margin: 0px;
							        padding: 0px;
							    }
							    @page {
							        margin: 80px 60px 30px 30px !important;
							    }
							    .footer {
							        width: 720px;
							        height: 300px;
							    }
							    body,
							    table {
							        font-weight: bold;
							        font-size: 12px;
							        padding: 0;
							        margin: 0;
							    }
							    .nobreak {
							        page-break-inside: avoid !important;
							    }
							    .full {
							        width: 100%;
							    }
							    .terms,
							    .Remarks {
							        font-size: 0.8em;
							    }
							    .thirty {
							        width: 30%;
							    }
							    .twenty {
							        width: 20%;
							    }
							    .bold {
							        font-weight: 700;
							    }
							    .right {
							        text-align: right;
							    }
							    h2 {
							        margin: 5px;
							    }
							    .border {
							        border: 1px solid #222;
							        border-collapse: collapse;
							        text-align: center;
							    }
							    .underlines {
							        text-decoration: underline;
							    }
							    .taxinvoiceheader {
							        border: 1px solid #222;
							        background: #AAA;
							        height: 35px;
							        text-align: center;
							        width: 30%;
							        font-size: 25px;
							        font-weight: 700;
							    }
							    .taxinvoicebody {
							        border: 1px solid #222;
							        width: 100%;
							        font-size: 17px;
							        padding-top: 10px;
							    }
							    .border_style {
							        border: 1px solid #000;
							        text-align: center;
							    }
							    .bot_border_style {
							        background: #000;
							        border-bottom: 1px solid #000;
							    }
							    .padd_add {
							        padding-left: 10px;
							    }
							    .padd_add_full {
							        padding: 10px 10px 10px 0;
							    }
							    .align_center {
							        text-align: center;
							    }
							    .align_right {
							        text-align: right;
							    }
							    .border-pro {
							        border-left: 1px solid #000;
							        border-right: 1px solid #000;
							    }
							    thead,
							    tfoot {
							        font-size: 12px;
							    }</style>
							</head>

							<body>
							    <table cellspacing="0" cellspacing="0" border="0" width="720px">
							        
							            <tr>
							                <th>
							                    <table class="full" border="0" cellpadding="0" cellspacing="0">
							                        <tr>
							                            <td class="thirty" style="text-align:center">
							                                <img src="'.$company_logo_url.'" style="max-width:150px">
							                                <br>Co Reg No : '.$middlemen_reg_no.'
							                            </td>
							                            <td>
							                                <div style="width:300px;padding-left:200px !important;">
							                                    <h2 style="margin-left:0px;">'.$company_name.'</h2>
							                                    <br/>
							                                </div>
							                            </td>
							                        </tr>
							                    </table>
							                    <div class="taxinvoiceheader">
							                        Tax Invoice
							                    </div>
							                    <div class="taxinvoicebody">
							                        <table class="full bold" rules="cols" border="0" cellpadding="0" cellspacing="0">
							                            <tr>
							                                <td style="width:80px" class="padd_add">Billed To</td>
							                                <td style="width:300px;">: '.$billedto->first_name." ".$billedto->last_name.'</td>
							                                <td style="width:120px" class="padd_add">Invoice No</td>
							                                <td>: '.$invoices->invoice_no.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">Tel</td>
							                                <td>: '.$billedto->mobile_contact.'
							                                </td>
							                                <td class="padd_add">Date</td>
							                                <td>: '.$date.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">Address</td>
							                                <td>: '.$billedto->delivery_address.'</td>
							                                <td class="padd_add">Sales Staff</td>
							                                <td>: '.$staffname.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">'.$middledet.'</td>
							                                <td>'.$middelmenname.'</td>
							                                <td class="padd_add">Delivery Date</td>
							                                <td>: '.$deldate.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">'.$middlemencondet.'</td>
							                                <td>'.$middlemencontact.'</td>
							                                <td class="padd_add">Payment mode</td>
							                                <td>: '.$invoices->payment_mode.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">Company</td>
							                                <td>: '.$billedto->organization.'</td>
							                            </tr>
							                            <tr>
							                                <td colspan="5">&nbsp;</td>
							                            </tr>
							                            <tr>
							                                <td colspan="5">
							                                    <table border="0" cellpadding="0" cellspacing="0">
							                                        <tr style="background:#AAA;border-top:1px solid #000;" class="nobreak">
							                                            <td style="width:40px;" class="border_style">No</td>                                          
							                                            <td style="width:440px;" class="border_style">Product Name</td>
							                                            <td style="width:40px;" class="border_style">Qty</td>
							                                            <td style="width:100px;" class="border_style">Unit Price</td>
							                                            <td style="width:103px;" class="border_style">Amount</td>
							                                        </tr>
							                                    </table>
							                                </td>
							                            </tr>
							                        </table>
							                    </div>
							                </th>
							            </tr>
							        
							        <tbody width="720px">
							            '.$items.'
							            <tr>
							                <td class="nobreak">
							                    <table cellspacing="0" cellspacing="0" border="0">
							                        
							                    	<tr>
							                            <td width="523px">&nbsp;</td>
							                            <td width="90px;" class="padd_add_full">Service Content :</td>
							                            <td class="border_style align_right padd_add_full" width="94px">$'.$invoices->service_content.'</td>
							                        </tr>
							                        <tr>
							                            <td width="523px">&nbsp;</td>
							                            <td width="90px;" class="padd_add_full">Total Amount :</td>
							                            <td class="border_style align_right padd_add_full" width="94px">$'.number_format($invoices->total_price,2).'</td>
							                        </tr>';

							                        if ($invoices->gst_status == 'no_gst') {
														$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">No GST</td></tr>';
													}else if($invoices->gst_status == 'gst_already'){
															$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">GST already included</td></tr>';
													}else{
														$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">7% GST :</td><td class="border_style align_right padd_add_full">$'.$invoices->gst.'</td></tr>';
													}


							                        $buildhTML .= '
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Total :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($aftGST,2).'</td>
							                        </tr>
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Deposit :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($invoices->total_paid,2).'</td>
							                        </tr>
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Balance :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($aftGST - $invoices->total_paid,2).'</td>
							                        </tr>
							                    </table>
							                </td>
							            </tr>
							            <tr>
							                <td>
							                    <div class="footer">
							                        <table border="0" cellpadding="0" cellspacing="0" width="720px" style="margin-top:200px;">
							                            <tr>
							                                <td>
							                                    <div><span style="padding-right:20px;">Remarks:</span> '.$invoices->remarks.'</div>
							                                   </div>
							                    			</td>
							                    			
							                    		</tr>
							                    		<tr>
							                                <td>
							                                    <div style="margin-top:30px !important;">
							                                        <hr/>Authorised Signature</div>
							                                </td>
							                            </tr>  
							                    	</table>
							                    </div>
							                </td>
							            </tr>
							        </tbody>
							    </table>
							</body>
							</html>';

		} else {
			$buildhTML = '<html>
							<head>
							    <style>
							    body,
							    html {
							        margin: 0px;
							        padding: 0px;
							    }
							    @page {
							        margin: 80px 60px 30px 30px !important;
							    }
							    .footer {
							        width: 720px;
							        height: 300px;
							    }
							    body,
							    table {
							        font-weight: bold;
							        font-size: 12px;
							        padding: 0;
							        margin: 0;
							    }
							    .nobreak {
							        page-break-inside: avoid !important;
							    }
							    .full {
							        width: 100%;
							    }
							    .terms,
							    .Remarks {
							        font-size: 0.8em;
							    }
							    .thirty {
							        width: 30%;
							    }
							    .twenty {
							        width: 20%;
							    }
							    .bold {
							        font-weight: 700;
							    }
							    .right {
							        text-align: right;
							    }
							    h2 {
							        margin: 5px;
							    }
							    .border {
							        border: 1px solid #222;
							        border-collapse: collapse;
							        text-align: center;
							    }
							    .underlines {
							        text-decoration: underline;
							    }
							    .taxinvoiceheader {
							        border: 1px solid #222;
							        background: #AAA;
							        height: 35px;
							        text-align: center;
							        width: 30%;
							        font-size: 25px;
							        font-weight: 700;
							    }
							    .taxinvoicebody {
							        border: 1px solid #222;
							        width: 100%;
							        font-size: 17px;
							        padding-top: 10px;
							    }
							    .border_style {
							        border: 1px solid #000;
							        text-align: center;
							    }
							    .bot_border_style {
							        background: #000;
							        border-bottom: 1px solid #000;
							    }
							    .padd_add {
							        padding-left: 10px;
							    }
							    .padd_add_full {
							        padding: 10px 10px 10px 0;
							    }
							    .align_center {
							        text-align: center;
							    }
							    .align_right {
							        text-align: right;
							    }
							    .border-pro {
							        border-left: 1px solid #000;
							        border-right: 1px solid #000;
							    }
							    thead,
							    tfoot {
							        font-size: 12px;
							    }
							    </style>
							</head>
							<body>
							    <table cellspacing="0" cellspacing="0" border="0" width="720px">
							        
							            <tr>
							                <th>
							                    <table class="full nobreak" border="0" cellpadding="0" cellspacing="0">
							                        <tr>
							                            <td class="thirty" style="text-align:center"> <img src="'.$company_logo_url.'" style="max-width:150px">
							                                <br>Co Reg No : '.$middlemen_reg_no.'</td>
							                            <td>
							                                <div style="width:300px;padding-left:200px !important;">
							                                    <h2 style="margin-left:0px;">'.$company_name.'</h2>
							                                    <br/></div>
							                            </td>
							                        </tr>
							                    </table>
							                    <div class="taxinvoiceheader">Tax Invoice</div>
							                    <div class="taxinvoicebody">
							                        <table class="full bold" rules="cols" border="0" cellpadding="0" cellspacing="0">
							                            <tr>
							                                <td style="width:80px" class="padd_add">Billed To</td>
							                                <td style="width:300px;">: Cash n Carry</td>
							                                <td style="width:120px" class="padd_add">Invoice No</td>
							                                <td>: '.$invoices->invoice_no.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">'.$middledet.'</td>
							                                <td>'.$middelmenname.'</td>
							                               <td class="padd_add">Date</td>
							                                <td>: '.$date.'</td>
							                            </tr>
							                            <tr>
							                                <td class="padd_add">'.$middlemencondet.'</td>
							                                <td>'.$middlemencontact.'</td>
							                                <td class="padd_add">Sales Staff</td>
							                                <td>: '.$staffname.'</td>
							                            </tr>
							                           
							                            <tr>
							                                <td></td>
							                                <td></td>
							                                <td></td>
							                                <td></td>
							                            </tr>
							                            
							                            <tr>
							                                <td>&nbsp;</td>
							                                <td>&nbsp;</td>
							                            </tr>
							                            <tr>
							                                <td colspan="5">
							                                    <table border="0" cellpadding="0" cellspacing="0">
							                                        <tr style="background:#AAA;border-top:1px solid #000;" class="nobreak">
							                                            <td style="width:40px;" class="border_style">No</td>		                                            
							                                            <td style="width:440px;" class="border_style">Product Name</td>
							                                            <td style="width:40px;" class="border_style">Qty</td>
							                                            <td style="width:100px;" class="border_style">Unit Price</td>
							                                            <td style="width:103px;" class="border_style">Amount</td>
							                                        </tr>
							                                    </table>
							                                </td>
							                            </tr>
							                        </table>
							                    </div>
							                </th>
							            </tr>
							        
							        <tbody width="720px" class="nobreak">
							            '.$items.'
							            <tr>
							                <td>
							                    <table cellspacing="0" cellspacing="0" border="0" class="nobreak">
							                        <tr>
							                            <td width="523px">&nbsp;</td>
							                            <td width="90px;" class="padd_add_full">Service Content :</td>
							                            <td class="border_style align_right padd_add_full" width="94px">$'.$invoices->service_content.'</td>
							                        </tr>
							                        <tr>
							                            <td width="523px">&nbsp;</td>
							                            <td width="90px;" class="padd_add_full">Total Amount :</td>
							                            <td class="border_style align_right padd_add_full" width="94px">$'.number_format($invoices->total_price,2).'</td>
							                        </tr>';

							                        if ($invoices->gst_status == 'no_gst') {
														$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">No GST</td></tr>';
													}else if($invoices->gst_status == 'gst_already'){
															$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">GST :</td><td class="border_style align_right padd_add_full">GST already included</td></tr>';
													}else{
														$buildhTML .= '<tr> <td>&nbsp;</td><td class="padd_add_full">7% GST :</td><td class="border_style align_right padd_add_full">$'.$invoices->gst.'</td></tr>';
													}


							                        $buildhTML .=  '
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Total :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($aftGST,2).'</td>
							                        </tr>
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Deposit :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($invoices->total_paid,2).'</td>
							                        </tr>
							                        <tr>
							                            <td>&nbsp;</td>
							                            <td class="padd_add_full">Balance :</td>
							                            <td class="border_style align_right padd_add_full">$'.number_format($aftGST - $invoices->total_paid,2).'</td>
							                        </tr>
							                    </table>
							                </td>
							            </tr>
							            <tr>
							                <td>
							                    <div class="footer nobreak">
							                        <table border="0" cellpadding="0" cellspacing="0" width="720px" style="margin-top:200px;">
							                            <tr>
							                                <td>
							                                    <div><span style="padding-right:20px;">Remarks:</span>
							                                        
							                                        '.$invoices->remarks.'
							                                    </div>
							                                   
							                                    </div>
							                                </td>						                               
							                            </tr>
							                            <tr>
							                                <td>
							                                    <div style="margin-top:30px !important;">
							                                        <hr/>Authorised Signature</div>
							                                </td>
							                            </tr>   
							                        </table>
							                    </div>
							                </td>
							            </tr>
							        </tbody>
							    </table>
							</body>
							</html>';
		}
		$pdf->loadHTML($buildhTML);
		return $pdf->download($invoices->invoice_no.".pdf");
	}

	public function save_edit()
	{
		$rules = array(
			'invoice_no'      => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}
		$n 									= 0;
		$InvoiceItemEntry 					= InvoiceEntry::find(Input::get('invoice_id'));
		$InvoiceItemEntry->invoice_no	   	= Input::get('invoice_no');
		if (Input::get('service_content') == "") {
			$InvoiceItemEntry->service_content = 0;
		}else{
			$InvoiceItemEntry->service_content = Input::get('service_content');
		}
		$InvoiceItemEntry->client_id	   	= Input::get('client');
		$InvoiceItemEntry->total_price	   	= Input::get('total_price');
		$InvoiceItemEntry->total_paid	   	= Input::get('deposit');

		$InvoiceItemEntry->gst	   = Input::get('get_gstval');
		$InvoiceItemEntry->gst_status	   = Input::get('gstopt');

		if (Input::get('delivery_address') != "")
			$InvoiceItemEntry->delivery_address = Input::get('delivery_address');

		if ($InvoiceItemEntry->sales_staff != Input::get('sales_staff'))
			$log[$n++] = Auth::user()->first_name . " " . Auth::user()->last_name . " edited sales staff from " . $InvoiceItemEntry->sales_staff . " to " . Input::get('sales_staff');

		$InvoiceItemEntry->sales_staff	= Input::get('sales_staff');

		if ($InvoiceItemEntry->middleman != Input::get('middlemen'))
			$log[$n++] = Auth::user()->first_name . " " . Auth::user()->last_name . " edited middleman from " . $InvoiceItemEntry->middleman . " to " . Input::get('middlemen');

		$InvoiceItemEntry->middleman	= Input::get('middlemen');

		if ($InvoiceItemEntry->middleman != Input::get('middlemen'))
			$log[$n++] = Auth::user()->first_name . " " . Auth::user()->last_name . " edited payment mode from " . $InvoiceItemEntry->payment_mode . " to " . Input::get('payment_mode');

		if (Input::get('delivery_type') == 1)
			$dt = "SELF-COLLECT";
		else if (Input::get('delivery_date') == "0000-00-00")
			$dt = "PENDING";
		else
			$dt =Input::get('delivery_date');

		if ($InvoiceItemEntry->delivery_date == "1111-11-11")
			$stt = "SELF-COLLECT";
		else if ($InvoiceItemEntry->delivery_date == "0000-00-00")
			$stt = "PENDING";
		else
			$stt =$InvoiceItemEntry->delivery_date;

		if ($InvoiceItemEntry->delivery_date != Input::get('delivery_date'))
			$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited delivery date from ".$stt." to ".$dt;

		if (Input::get('delivery_type') == 1)
			$dd = "1111-11-11";
		else
			$dd = Input::get('delivery_date');

		$total 						= $InvoiceItemEntry->total_paid - Input::get('total_price');
		$InvoiceItemEntry->remarks	= Input::get('remarks');
		date_default_timezone_set('Asia/Singapore');
		$date 							= date('Y-m-d H:i:s', time());
		$InvoiceItemEntry->updated_at	= $date;
		$InvoiceItemEntry->created_by	= Auth::user()->id;
		$InvoiceItemEntry->save();

		$invoice_id_list = rtrim(Input::get('invoice_id_list'), ', ');

		for ($h = 0; $h < Input::get('cnt'); $h++) {
			DB::table('invoice_items')->where('invoice_id','=', Input::get('invoice_id'))->whereIn('id', [$invoice_id_list])->delete();

			if (Input::get('product_choice'.$h) == -2) {
				$InvoiceItemEntry = InvoiceItemEntry::find(Input::get('hid'.$h));
				if ($InvoiceItemEntry->product_id != -1) {
					$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited a product from ".$InvoiceItemEntry->product_name." to ".Input::get('free'.$n);
				}
				$InvoiceItemEntry->product_id	   	= -1;
				$InvoiceItemEntry->product_name		= Input::get('free'.$h);
				$InvoiceItemEntry->unit_price       = 0;
				$InvoiceItemEntry->selling_price    = 0;
				$InvoiceItemEntry->quantity       	= 0;
				$InvoiceItemEntry->description      = 0;
				$InvoiceItemEntry->save();
			} else if (Input::get('product_choice'.$h) != -1 && Input::get('quantity'.$h) > 0) {
				$check_new = Input::get('new'.$h);
				if($check_new == 0) {
					$InvoiceItemEntry 	= InvoiceItemEntry::find(Input::get('hid'.$h));
					$pr 				= explode(';',Input::get('product_choice'.$h));
					if ($pr[0]	  != $InvoiceItemEntry->product_id)
						$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." edited a product from ".$InvoiceItemEntry->product_name." to ".$pr[1];
			        if (count($pr) > 1) {	        	

						$InvoiceItemEntry->product_id	= $pr[0];
						$InvoiceItemEntry->product_name	= $pr[1];
						$InvoiceItemEntry->unit_price	= Input::get('unitprice'.$h);
						$pricef 						= Input::get('sellingprice'.$h);
						if (Input::get('pricetype'.$h) == 1) {
							//$pricef = -1;
							$InvoiceItemEntry->status = 1;
						} else {
							$InvoiceItemEntry->status = 0;
						}
						$InvoiceItemEntry->selling_price	= $pricef;
						$InvoiceItemEntry->quantity       	= Input::get('quantity'.$h);
						$InvoiceItemEntry->description      = Input::get('desc'.$h);

						/**********************/

						$get_qty_all1 = DB::table('invoice_items')->where('id','!=',Input::get('hid'.$h))->where('product_id','=',$pr[0])->sum('quantity');

						$get_qty_all = $get_qty_all1 + Input::get('quantity'.$h);
						
						$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
				        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

						$get_difqty = $get_pro_qty - $get_pro_minqty;

						if ($get_difqty < $get_qty_all) {
							$InvoiceItemEntry->product_qty_status  = 'required';

						}else{
							$InvoiceItemEntry->product_qty_status  = 'enough';
						}

						$InvoiceItemEntry->save();

					}
				} else if($check_new == 1) {
					$pr 								= explode(';',Input::get('product_choice'.$h));
					$InvoiceItemEntry 					= new InvoiceItemEntry;
					$InvoiceItemEntry->invoice_id   	= Input::get('invoice_id');
					$InvoiceItemEntry->product_id		= $pr[0];
					$InvoiceItemEntry->product_name		= $pr[1];
					$InvoiceItemEntry->unit_price   	= Input::get('unitprice'.$h);
					$pricef 							= Input::get('sellingprice'.$h);
					$InvoiceItemEntry->selling_price 	= $pricef;
					$InvoiceItemEntry->quantity      	= Input::get('quantity'.$h);
					$InvoiceItemEntry->quantity      	= Input::get('quantity'.$h);
					$InvoiceItemEntry->description    	= Input::get('desc'.$h);
					if (Input::get('pricetype'.$h) == 1) {
						$InvoiceItemEntry->status = 1;
					} else {
						$InvoiceItemEntry->status = 0;
					}

					/**********************/

					$get_qty_all1 = DB::table('invoice_items')->where('product_id','=',$pr[0])->sum('quantity');

					$get_qty_all = $get_qty_all1 + Input::get('quantity'.$n);

					$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
			        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

					$get_difqty = $get_pro_qty - $get_pro_minqty;

					if ($get_difqty < $get_qty_all) {
						$InvoiceItemEntry->product_qty_status  = 'required';
					}else{
						$InvoiceItemEntry->product_qty_status  = 'enough';
					}

					$InvoiceItemEntry->save();				

				}
			} else if (Input::get('product_choice'.$h) == -1) {
				if(Input::get('edit_quo') == 1) {
					$pr = explode(';',Input::get('product_choice'.$h));
					if ($InvoiceItemEntry->product_id	   != $pr[0])
						$log[$n++] = Auth::user()->first_name." ".Auth::user()->last_name." deleted product ".$InvoiceItemEntry->product_name;
					$InvoiceItemEntry = InvoiceItemEntry::find(Input::get('hid'.$h));
					$InvoiceItemEntry->delete();
				}
			} else{
				$pr 								= explode(';',Input::get('product_choice'.$h));
				//dd(Input::get('product_choice'.$h));
				$InvoiceItemEntry 					= new InvoiceItemEntry;
				$InvoiceItemEntry->invoice_id       = Input::get('invoice_id');
				$InvoiceItemEntry->product_id	   	= $pr[0];
				$InvoiceItemEntry->product_name	   	= $pr[1];
				$InvoiceItemEntry->unit_price       = Input::get('unitprice'.$h);
				$pricef 							= Input::get('sellingprice'.$h);
				$InvoiceItemEntry->selling_price	= $pricef;
				$InvoiceItemEntry->quantity      	= Input::get('quantity'.$h);
				$InvoiceItemEntry->description    	= Input::get('desc'.$h);
				if (Input::get('pricetype'.$h) == 1) {
					$InvoiceItemEntry->status = 1;
				} else {
					$InvoiceItemEntry->status = 0;
				}

				/**********************/

				$get_qty_all1 = DB::table('invoice_items')->where('product_id','=',$pr[0])->sum('quantity');

				$get_qty_all = $get_qty_all1 + Input::get('quantity'.$n);

				$get_pro_qty = DB::table('products')->where('id','=',$pr[0])->pluck('quantity');
		        $get_pro_minqty = DB::table('products')->where('id','=',$pr[0])->pluck('min_product_qty');

				$get_difqty = $get_pro_qty - $get_pro_minqty;

				if ($get_difqty < $get_qty_all) {
					$InvoiceItemEntry->product_qty_status  = 'required';
				}else{
					$InvoiceItemEntry->product_qty_status  = 'enough';
				}

				$InvoiceItemEntry->save();	

			}
		}

		for ($i = 0; $i < $n; $i++) {
			date_default_timezone_set ('Asia/Singapore');
			$date 					= date('Y-m-d H:i:s');
			$logentry 				= new LogEntry;
			$logentry->entity_id 	= Input::get('invoice_id');
			$logentry->log 			= $log[$i];
			$logentry->date 		= $date;
			$logentry->save();
		}
		return Redirect::to('invoices');
	}

	public function edit_invoice($id)
	{
		$products 		= DB::table('products')->where('status','=',1)->get();
		$unitPrice 		= DB::table('products')->lists('unit_price','id');
		$sellingPrice 	= DB::table('products')->lists('selling_price','id');
		$measurements 	= DB::table('products')->lists('measurements','id');
		$staffs 		= DB::table('staffs')->orderby('name')->get();
		$middlemen 		= DB::table('middlemen')->orderby('first_name')->get();
		$logs 			= DB::table('logs')->where('entity_id','=',$id)->get();
		$clients 		= DB::table('clients')->get();
		$aid 			= "INV";
		for ($n = 0; $n < (5 - strlen($id)); $n++) {
			$aid .= "0";
		}
		$aid 			.= $id;
		$invoiceitems 	= DB::table('invoice_items')->where('invoice_id','=',$id)->get();
		$invoices 		= InvoiceEntry::find($id);
		return View::make('invoices.edit')->with('middlemen',$middlemen)->with('staffs',$staffs)->with('logs',$logs)
            ->with('aid',$aid)->with('measurements',$measurements)->with('invoices', $invoices)->with('inv',$invoiceitems)
			->with('clients',$clients)->with('products',$products)->with('unit_price',$unitPrice)->with('selling_price',$sellingPrice);
	}

	public function view_invoice($id)
	{
		$invoiceitems 	= DB::table('invoice_items')->where('invoice_id','=',$id)->get();
		$logs 			= DB::table('logs')->where('entity_id','=',$id)->get();
		$invoices 		= InvoiceEntry::find($id);
		 return View::make('invoices.view')
            ->with('id',$id)->with('logs',$logs)->with('invoice', $invoices)->with('inv',$invoiceitems);
	}

	public function delete_invoice()
	{
		$id = Input::get('id');
		DB::table('invoices')->where('id','=',$id)->delete();
		DB::table('invoice_items')->where('invoice_id','=',$id)->delete();
		return Redirect::to('invoices');
	}

	public function enable_invoice()
	{
		$id = Input::get('id');
		DB::table('invoices')->where('id','=',$id)->update(array('status'=>'1'));
		return Redirect::to('invoices');
	}

	public function disable_invoice()
	{
		$id = Input::get('id');
		DB::table('invoices')->where('id','=',$id)->update(array('status'=>'0'));
		return Redirect::to('invoices');
	}

	public function getprice()
	{
		return Response::json('asd');
		$id 	= Input::get('products');
		$price 	= DB::table('products')->where('id','=',$id)->pluck('selling_price');
		$prices = [$price];
		return Response::json($prices);
	}
}
?>