@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> New Purchase Order</h2></div>
            </div>
            <div class="box-content">
            	<table class="table table-striped">
		    <tr>                    
                    	<td><strong>Purchase Order ID</strong></td>
                        <td> <?php
				$id = $po->id;
				      $aid = "PO";
				       for ($n = 0; $n < (5 - strlen($id)); $n++)
				       {
					       $aid .= "0";
				       }
				       $aid .= $id;
				       echo $aid;
			 ?></td>
                    </tr>
                	@if ($po->invoice_id != -1)
                    <tr>
                    
                    	<td><strong>Invoice ID</strong></td>
                        <td> <?php
				$pid = "PO";
				for ($n = 0; $n < (5 - strlen($po->invoice_id)); $n++)
				{
					$pid .= "0";
				}
				$pid .= $po->invoice_id;
				echo $pid;
			  ?></td>
                    </tr>
                    @endif
                    
                    <tr>
                      <td><strong>Delivery Contact</strong></td>
                        <td> 
                        <?php 
                           echo $po->delivery_contact;
                        ?>
                        </td>
                    </tr>

                    <tr>
                      <td><strong>Delivery Location</strong></td>
                        <td> 
                        <?php 
                            $fn =  DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('first_name'); 

                            $ln =  DB::table('middlemen')->where('id','=',$po->delivery_address)->pluck('last_name');  

                            echo $fn." ".$ln;
                                ?>
                        </td>
                    </tr>

                    <tr>
                      <td><strong>Delivery Date</strong></td>
                        <td> <?php echo date("d-m-Y",strtotime($po->delivery_date)); ?></td>
                    </tr>



                    <tr>
                    	<td><strong>Attn to</strong></td>
                        <td> 
				<?php 
				if ($po->attn_to != "")
					echo DB::table('supplier_contacts')->where('id','=',$po->attn_to)->pluck('name'); 
				else
					echo "---";
				?></td>
                    </tr>
                    <!-- <tr>
                    	<td><strong>Date Created</strong></td>
                        <td> <?php //echo date("d-m-Y",strtotime($po->date_created)); ?></td>
                    </tr> -->
                    <!-- <tr>
                    	<td><strong>Delivery Address</strong></td>
                        <td> <?php //echo $po->delivery_address; ?></td>
                    </tr> -->

                    <tr>
                      <td><strong>Invoice ID (optional)</strong></td>
                        <td> <?php 
                        if ($po->invoice_id != -1) {
                  echo  DB::table('invoices')->where('id','=',$po->invoice_id)->pluck('invoice_no'); 
                        }
                       
                        ?></td>
                    </tr>


                    <tr>
                    	<td><strong>Supplier</strong></td>
                        <td> <?php echo  DB::table('suppliers')->where('id','=',$po->supplier_id)->pluck('supplier_name'); ?></td>
                    </tr>
                    <tr style="display: none;">
                    	<td><strong>Total Price</strong></td>
                        <td> $<?php echo $po->total_price; ?></td>
                    </tr>
                </table>
				
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Quantity</th>
                                  <th>Unit Price</th>  
                                  <th>Buying Price</th>  
                                  <th>Amount</th>     
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          <input type="hidden" name="total_price" id="tp">
                          <?php $cnt = 0; ?>
                           @foreach ($inv as $key =>$value) 
                          <tr id="row0">
                          		<td>
                                 {{ $value->product_id." ".$value->product_name }}
                                </td>
                                
                                <td class="center">{{ $value->quantity }}</td>
                                
                                <td class="center">${{ $value->unit_price }}</td> 
                                <td class="center">${{ $value->buying_price}}</td>
                                <td class="center">${{ $value->buying_price * $value->quantity }}</td>
                                
                           </tr>
                            <?php $cnt++; ?>
                             @endforeach 
                          </tbody>

                                <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Total Amount</strong></td>
                                    <td> <?php echo '$' . $po->total_price; ?></td>
                                </tr>

                     </table>  

                    <div style="width:100%;margin:30px 0px;">
                       <b>Remarks </b><hr />
                       <p>
                         {{$po->remarks}}
                       </p>
                    </div>

                      <div class="form-actions">                        
                        <div style="width:auto;float:left;">
                        <a href="{{ URL::to('purchase_orders') }}"><input type="button" value="Back" class="btn"></a>
                        </div>
                        <div style="width:auto;float:left;margin: -20px 0px 0px !important;">
                         @if($po->status != 1)
                          {{ Form::open(array('action' => 'PurchaseOrdersController@confirm_po')) }} 
                            {{ Form::hidden('id',$value->id) }}
                            <button type="submit" class="btn btn-info">Confirm</button>  
                          {{ Form::close() }} 
                        </div>  
                      </div>
                      @endif
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

