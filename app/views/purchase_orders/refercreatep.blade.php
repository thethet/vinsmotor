@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Create Purchase Order</h2></div>
            </div>
            <div class="box-content">
            	{{ Form::open(array('url' => 'purchase_orders/createp','method'=>'post','id'=>'createPurchaseOrder')) }}
                    <fieldset>    
                        <?php
                        if(isset($productstatus->quo_id) && $productstatus->quo_id != 0){
                          
                        	$iid = $productstatus->quo_id;
                        	$newid = $iid;
              							$rid = "QUO";
              							 for ($n = 0; $n < (5 - strlen($newid)); $n++)
              							 {
              								 $rid .= "0";
              							 }
              							 $rid .= $newid;
              							 $relatedlabel = 'Quotation No.';
                             $prostatusid = $productstatus->id;
                             $count = DB::table('purchase_orders')->where('invoice_id','=',$iid)->count();
                             $check_status = "";
                        }
                        else if(isset($productstatus->inv_id) && $productstatus->inv_id != 0){
                        	 $iid = $productstatus->inv_id;
                        	 $newid = $iid;
            							 $rid = "INV";
            							 for ($n = 0; $n < (5 - strlen($newid)); $n++)
            							 {
            								 $rid .= "0";
            							 }
            							 $rid .= $newid;
            							  $relatedlabel = 'Invoice No.';
                            $productstatus = $productstatus->id;
                            $count = DB::table('purchase_orders')->where('invoice_id','=',$iid)->count();
                            $check_status = "";
                        }
                        else{
                            $iid = "";
                            $rid = "";
                            $relatedlabel = "";
                            $productstatus = "";
                            $count = 0;
                            $prostatusid = "";
                            $check_status = 1;
                        }
						        $lastid = DB::table('purchase_orders')->orderby('date_created','desc')->pluck('showid');
        						$alphabet = array( '','a', 'b', 'c', 'd', 'e',
        								   'f', 'g', 'h', 'i', 'j',
        								   'k', 'l', 'm', 'n', 'o',
        								   'p', 'q', 'r', 's', 't',
        								   'u', 'v', 'w', 'x', 'y',
        								   'z'
        								   );
      						if ($count >0){
                    $firstalpha = DB::table('purchase_orders')->where('invoice_id','=',$iid)->orderBy('date_created')->pluck('showid');
                  }							
      						else{
                    $firstalpha = $lastid;
                  }              
    							$newid = $firstalpha.$alphabet[$count];
    							$newid = $newid + 1;
  							 $aid = "PO";
  							  for ($n = 0; $n < (5 - strlen($newid)); $n++)
  							  {
  								 $aid .= "0";
  							  }
  							  $aid .= $newid;
						    ?>           
                      <input type="hidden" name="check_status" value="{{ $check_status }}"/>        
                       
                       <div class="form-group row">
                       	   <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Purchase Order No. </strong></span></div>
                           <div class="col-md-3"><input type="text" readonly value="{{ $aid }}" name="pono"></div>
                        </div>                        
                     
			   <div class="form-group row">
                       	    <div class="col-md-1"> <span style="padding-bottom:5px;"><strong>{{ $relatedlabel }}</strong></span></div>
                             <div class="col-md-3"><input type="text" readonly value="{{ $rid }}"></div>                        
                        </div>                        
                      
                   	 <div class="form-group row">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Contact </strong></span></div>
                         <div class="col-md-3"><input type="text" name="del_contact" class="form-control" placeholder="Enter Delivery Contact..."></div>
                        
                      </div> 
                   	 <div class="form-group row">
                       	 <div class="col-md-1"> <span style="padding-bottom:5px;"><strong>Delivery Address </strong></span></div>
                         <div class="col-md-3"><textarea name="delivery_address" class="form-control" placeholder="Enter Delivery Address..."></textarea>
                        </div>
                      </div> 
                   	 <div class="form-group row">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Date </strong></span></div>
                         <div class="col-md-3"><input type="text" name="delivery_date" class="form-control" id="datepicker" placeholder="Enter Delivery Date..."></div>
                        
                      </div>
                      <div class="form-group row left">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Supplier </strong></span></div>
                       	  <?php $suppliers = SupplierEntry::all(); ?>
                          <div class="col-md-3"><select name="supplier" required id="supplier" data-rel="chosen">
                             @foreach($suppliers as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                              @endforeach
                          </select>
                         </div>
                      </div>
                      <div class="clear"></div>
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                               <th><input type="checkbox" id="alldelete"></th>
				<th>Product</th>
				<th>Measurements</th>
				<th>Quantity</th>
				<th>Retail Price</th> 
				<th>Cost Price</th>   
				<th>Remarks</th>                          
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          <input type="hidden" name="total_price" id="tp">
                          <?php $cnt = 0;?>
                           @foreach ($products as $key =>$value) 
                          	<tr id="row0">
                          		<td><input type="hidden" name="id{{ $cnt }}" value="{{ $prostatusid }}">
                                <input type="hidden" name="pid{{ $cnt }}" value="{{ $value->id }}">
                                <input type="hidden" name="pname{{ $cnt }}" value="{{ $value->product_name }}">
                                <?php $get_required_qty = ProductStatusEntry::where('pro_id','=',$value->id)->pluck('required_qty'); ?>
                          		
                                <input type="hidden" name="selling_price{{ $cnt }}" value="{{ $value->selling_price }}">
                                <input type="checkbox" name="delete{{ $cnt }}" value="1" class="delbox" id="delete{{ $cnt }}">
                                <td>
                                 {{ $value->product_name }}
                                </td>
                                <td class="center" id="description{{ $cnt }}"> 
                                <?php
                									$measurem = DB::table('products')->where('id','=',$value->id)->pluck('measurements');
                									$msr = explode(";",$measurem);
                									if (count($msr) == 3)
                										echo $msr[0]." x ".$msr[1]." x ".$msr[2]." mm";
                									else
                										echo "---";
                								?>
                                 </td>
                                <td class="center"><input type="text" id="quantity{{ $cnt }}" name="quantity{{ $cnt }}" class="form-control" value="{{ $get_required_qty }}" required></td>
                                
                                <td class="center">{{ $value->selling_price }}</td>  
                                <?php $val = DB::table('products')->where('id','=',$value->id)->pluck('unit_price') ?>
                                <input type="hidden" name="unitprice{{ $cnt }}" value="{{ $val }}"/>
                                <td class="center" ><input class="onetwofive form-control" type="number" max="{{ $value->selling_price }}" value="{{ $val }}" name="buyingprice{{ $cnt }}" id="buyingprice{{ $cnt }}"> </td>   
                                <td class="center"><textarea name="remarks{{ $cnt }}" class="form-control"></textarea></td>              
                            </tr>
                            <?php $cnt++; ?>
                             @endforeach 
                                <input type="hidden" id="cnt" name="cnt" value="{{ $cnt }}">  
                          </tbody>
                     </table> 
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create Purchase Order</button>
                        
                        <a href="{{ URL::to('product_status') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
            	{{ Form::close() }}
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

