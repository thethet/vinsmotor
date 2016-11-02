@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ URL::to('/main') }}">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/invoices') }}">Invoice</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/invoices/view/'.$id) }}">View Invoice</a> 
        </li>
    </ul>
    
   

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>View Invoice</h2>
                
            </div>
            <div class="box-content">
            	<table class="table table-striped">
                	<tr>
                    	<td class="col-md-2"><strong>Invoice No.</strong></td>
                        <td> <?php
								 $pid = "INV";
								 for ($n = 0; $n < (5 - strlen($invoice->id)); $n++)
								 {
									 $pid .= "0";
								 }
								 $pid .= $invoice->id;
								 echo $pid;
							   ?></td>
                    </tr>

                     <tr>


                      <td><strong>Client</strong></td>

                        <td> 
                        <?php 

                        if ($invoice->client_id == -1) {
                          echo 'Cash and Carry';
                        }else{
                          echo DB::table('clients')->where('id','=',$invoice->client_id)->pluck('first_name'); 
                          echo ' ';
                          echo DB::table('clients')->where('id','=',$invoice->client_id)->pluck('last_name');
                        }
                        ?>
                        </td>

                    </tr>


                    <tr style="display: none;">
                    	<td><strong>Date Created</strong></td>
                        <td> <?php echo date("d-m-Y",strtotime($invoice->date_created)); ?></td>
                    </tr>
                    <tr style="display: none;">
                    	<td><strong>Delivery Date</strong></td>
                        <td> <?php if ($invoice->delivery_date != "0000-00-00")								
										echo date("d-m-Y",strtotime($invoice->delivery_date)); 
									else
										echo "SELF-COLLECT";	
										?></td>
                    </tr>
                    <tr style="display: none;">
                    	<td><strong>Delivery Address</strong></td>
                        <td> <?php if ($invoice->delivery_address != "")								
										echo $invoice->delivery_address; 
									else
										echo "---";	
										?></td>
                    </tr>
                    <tr>
                    	
                    	<td><strong>Sales Staff</strong></td>
                        <td> <?php echo DB::table('staffs')->where('id','=',$invoice->sales_staff)->pluck('name'); ?></td>
                    </tr>
                    
                    <tr>
                    	
                    	<td><strong>Company</strong></td>
                        <td> <?php 
									$cnt = DB::table('middlemen')->where('id','=',$invoice->middleman)->count();
									if ($cnt > 0) 
									{
										$fn =  DB::table('middlemen')->where('id','=',$invoice->middleman)->pluck('first_name'); 
										$ln =  DB::table('middlemen')->where('id','=',$invoice->middleman)->pluck('last_name');  
										echo $fn." ".$ln;
									}
								?>
                        </td>
                    </tr>
                <!--      <tr>
                      
                      <td><strong>Installation Required</strong></td>
                        <td> <?php //echo $invoice->installation; ?></td>
                    </tr> -->

                    
                    <tr>
                    	
                    	<td><strong>Payment Mode</strong></td>
                        <td> <?php echo $invoice->payment_mode; ?></td>
                    </tr>
                 
                    
                </table>
				
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Product</th>
                                  <th>Quantity</th>
                                  <th>Retail Price</th>  
                                  <th>Amount</th>                  
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          <input type="hidden" name="total_price" id="tp">
                          <?php $cnt = 0; ?>
                           @foreach ($inv as $key =>$value) 
                           @if ($value->product_id != -1)
                          <tr>
                          		<td>
                                
                                 {{ $value->product_id." ".$value->product_name." ".$value->description }}
                                </td>
                                
                                <td class="center">{{ $value->quantity }}</td>
                                
                                <td class="center">{{ $value->selling_price }}</td> 
                                <td class="center">{{ $value->selling_price * $value->quantity }}</td>   
                                
                           </tr>
                           @else
                           <tr>
                          		<td colspan="4">
                                
                                 {{ $value->product_name }}
                                </td>
                                
                                
                           </tr>
                           @endif
                            <?php $cnt++; ?>
                             @endforeach 
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Service Content</strong></td>
                                    <td> <?php echo $invoice->service_content; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Total Amount</strong></td>
                                    <td> <?php echo $invoice->total_price; ?></td>
                                </tr>

                                <?php
                                  if ($invoice->gst_status == 'no_gst') {
                                    echo '<tr><td colspan="3" style="text-align:right;"><strong>GST</strong></td>';
                                    echo '<td>No GST</td></tr>';
                                  }elseif($invoice->gst_status == 'gst_already'){                                   
                                    echo '<tr><td colspan="3" style="text-align:right;"><strong>GST</strong></td>';
                                    echo '<td>GST already included</td></tr>';
                                  }else{?>

                                  <tr>
                                    <td colspan="3" style="text-align:right;"><strong>7% GST</strong></td>
                                    <td> <?php echo $invoice->gst; ?></td>
                                  </tr>
                                <?php  }
                                ?>
                                
                                
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Total</strong></td>
                                    <td> <?php echo $invoice->total_price+$invoice->gst; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Deposit</strong></td>
                                    <td> <?php echo  $invoice->total_paid; ?></td>
                                </tr>
                               <!-- @if ($invoice->client_id != -1)
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Balance</strong></td>
                                    <td> 
                                    
                                    <?php //$client = DB::table('clients')->where('id','=',$invoice->client_id)->first();
									//echo $client->balance;
									 ?></td>
                                </tr>
                                @endif-->
                                <tr>
                                    <td colspan="3" style="text-align:right;"><strong>Balance</strong></td>
                                    <td> <?php echo  ($invoice->total_price+$invoice->gst)-$invoice->total_paid; ?></td>
                                </tr>
                                
                          </tbody>
                     </table>  

                     <div style="width:100%;margin:30px 0px;">
                       <b>Remarks </b><hr />
                       <p>
                         {{$invoice->remarks}}
                       </p>
                     </div>
                     
                      <div class="form-actions">
                        
                        <a href="{{ URL::to('invoices') }}"><input type="button" value="Back" class="btn"></a>
                      </div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
	
			
    
@stop

