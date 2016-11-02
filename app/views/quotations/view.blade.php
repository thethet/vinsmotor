@extends('layouts.main')



@section('header')

    {{ HTML::style('css/jquery.fancybox.css'); }}

@stop

@section('content')

    <div class="row-fluid sortable">

        <div class="box span12">

          <div class="box-header row">

                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> View quotation</h2></div>

            </div>

            <div class="box-content">

            	<table class="table table-striped">

                	<tr>

                    	<td><strong>Quotation No.</strong></td>

                        <td> <?php

				$pid = "QU";

				for ($n = 0; $n < (5 - strlen($quotation->id)); $n++)

				{

					$pid .= "0";

				}

				$pid .= $quotation->id;

				echo $pid;

			  ?></td>

                    </tr>

                      <tr>


                      <td><strong>Client</strong></td>

                        <td> 
                        <?php 

                        if ($quotation->client_id == -1) {
                          echo 'Cash and Carry';
                        }else{
                          echo DB::table('clients')->where('id','=',$quotation->client_id)->pluck('first_name'); 
                          echo ' ';
                          echo DB::table('clients')->where('id','=',$quotation->client_id)->pluck('last_name');
                        }
                       
                        ?>
                        </td>

                    </tr>


                    <tr style="display: none;">

                    	<td class="col-md-2"><strong>Date Created</strong></td>

                        <td> <?php echo date("d-m-Y",strtotime($quotation->date_created)); ?></td>

                    </tr>

                    <tr style="display: none;">

                    	<td><strong>Delivery Date</strong></td>

                        <td> <?php if ($quotation->delivery_date != "0000-00-00")								

										echo date("d-m-Y",strtotime($quotation->delivery_date)); 

									else

										echo "SELF-COLLECT";	

										?></td>

                    </tr>

                    <tr style="display: none;">

                    	<td><strong>Delivery Address</strong></td>

                        <td> <?php if ($quotation->delivery_address != "")								

										echo $quotation->delivery_address; 

									else

										echo "---";	

										?></td>

                    </tr>

                    <tr>

                    	

                    	<td><strong>Sales Staff</strong></td>

                        <td> <?php echo DB::table('staffs')->where('id','=',$quotation->sales_staff)->pluck('name'); ?></td>

                    </tr>

                    

                    <tr>

                    	

                    	<td><strong>Company</strong></td>

                        <td> <?php 

									$cnt = DB::table('middlemen')->where('id','=',$quotation->middleman)->count();

									if ($cnt > 0) 

									{

										$fn =  DB::table('middlemen')->where('id','=',$quotation->middleman)->pluck('first_name'); 

										$ln =  DB::table('middlemen')->where('id','=',$quotation->middleman)->pluck('last_name');  

										echo $fn." ".$ln;

									}

								?>

                        </td>

                    </tr>

                      


                    <tr>

                        <!-- <td colspan="2"> -->

                            <table class="table table-bordered table-striped">
                            <!-- <table border="0" cellpadding="0" cellspacing="0" style="width:100%" class="pro_display">
 -->
                                <tr><!-- <th>Product Item No.</th> --><th>Product Name</th><th>Quantity</th><th>Selling Price</th><th>Final Price</th><th>Amount</th></tr>

                            <?php 

                             $get_quo_item = QuotationItemEntry::where('quotation_id','=',$quotation->id)->get();

                              foreach ($get_quo_item as $key => $value) {

                                 // echo "<tr><td height='50'>".$value->product_itemno."</td><td>".$value->product_name."</td><td>".$value->quantity."</td><td>".$value->unit_price."</td><td>".$value->selling_price."</td><td>".sprintf ("%.2f", $value->quantity*$value->selling_price)."</td></tr>";

                                 echo "<tr><td>".$value->product_name."</td><td>".$value->quantity."</td><td>".$value->unit_price."</td><td>".$value->selling_price."</td><td>".sprintf ("%.2f", $value->quantity*$value->selling_price)."</td></tr>";

				  

                              }

                            ?>
                                <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Service Content</strong></td>
                                    <td> <?php echo $quotation->service_content; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Total Amount</strong></td>
                                    <td> <?php echo $quotation->total_price; ?></td>
                                </tr>
                                
                                <?php
                                  if ($quotation->gst_status == 'no_gst') {
                                    echo '<tr><td colspan="4" style="text-align:right;"><strong>GST</strong></td>';
                                    echo '<td>No GST</td></tr>';
                                  }elseif($quotation->gst_status == 'gst_already'){                                   
                                    echo '<tr><td colspan="4" style="text-align:right;"><strong>GST</strong></td>';
                                    echo '<td>GST already included</td></tr>';
                                  }else{?>

                                  <tr>
                                    <td colspan="4" style="text-align:right;"><strong>7% GST</strong></td>
                                    <td> <?php echo $quotation->gst; ?></td>
                                  </tr>
                                <?php  }
                                ?>

                                 <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Total</strong></td>
                                    <td> <?php echo $quotation->total_price+$quotation->gst; ?></td>
                                </tr>

                                <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Deposit</strong></td>
                                    <td> <?php echo  $quotation->total_paid; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align:right;"><strong>Balance</strong></td>
                                    <td> <?php echo  ($quotation->total_price+$quotation->gst)-$quotation->total_paid; ?></td>
                                </tr>

			                </table>

			

                        <!-- </td> -->

                    </tr>

                    

		</table>

        <div style="width:100%;margin:30px 0px;">
           <b>Remarks </b><hr />
           <p>
             {{$quotation->remarks}}
           </p>
        </div>

                      <div class="form-actions">                        
                        <div style="width:auto;float:left;">
                        <a href="{{ URL::to('quotations') }}"><input type="button" value="Back" class="btn"></a>
                        </div>
                        <div style="width:auto;float:left;margin: -20px 0px 0px !important;">
                         @if($quotation->status == 0)

                         <?php  $getpo = ProductStatusEntry::where('id','=',$quotation->id)->first(); 

                           if(isset($getpo) && $getpo->required_qty == 0){ ?>

                            {{ Form::open(array('action' => 'QuotationsController@confirm_quotation')) }} 

                            {{ Form::hidden('id',$value->id) }}

                              <button type="submit" class="btn btn-info">Confirm</button>  

                            {{ Form::close() }}  

                          

                          <?php }

                         ?>

                            @endif 
                        </div>

                      </div>

            </div>

        </div><!--/span-->

    

    </div><!--/row-->

	

			

    

@stop



