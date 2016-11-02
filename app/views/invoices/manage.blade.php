@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
    	<div class="box span12">
    		<div class="box-header row">
    			<div class="col-md-6">
    				<h2 class="page_header"><i class="fa fa-file"></i> Manage invoice</h2>
    			</div>

                <div class="col-md-6">
                	<div class="box-icon">
                		<a href="{{ URL::to('invoices/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add invoice</a>
                	</div>
                </div>
            </div>

            <div class="box-content">
            	<div class="table-responsive">
            		<table class="table table-striped table-bordered bootstrap-datatable datatable">
            			<thead>
            				<tr>
            					<th class="ten">Invoice No.</th>
            					<th class="fifteen">Client name</th>
            					<th class="ten">Purchase Order</th>
            					<th class="fifteen">Date issued</th>
            					<th class="ten">Total Price</th>
            					<th class="ten">Product Status</th>
            					<th class="ten">Actions</th>
            				</tr>
            			</thead>

            			<tbody>
            				<?php $i = 0; ?>
            				@foreach($invoices as $key => $value)
            					<tr>
            						<td>
            							<?php
            							/*$id = "INV";
            							for ($n = 0; $n < (5 - strlen($value->id)); $n++) {
            								$id .= "0";
            							}
            							$id .= $value->id;
            							echo $id;*/
            							echo $value->invoice_no;
            							?>
            						</td>

            						<td>
            							<?php
            							if ($value->client_id != -1) {
            								$username = DB::table('clients')->where('id','=',$value->client_id)->first(); echo $username->first_name." ".$username->last_name;
            							} else
            								echo "Cash and Carry";
            							?>
            						</td>

            						<td class="center">
            							<?php
            								$tmp = explode(";",$value->purchase_order);
            								for ($q = 1; $q < count($tmp); $q++) {
            									$pid = "PO";
            									for ($n = 0; $n < (5 - strlen($tmp[$q])); $n++) {
            										$pid .= "0";
            									}
            									$pid .= $tmp[$q];
            							?>
		            							<a href="{{ URL::to ('purchase_orders/view/'.$tmp[$q]) }}">
		            								<?php echo $pid; ?>
		            							</a>
		            							<br/>
            							<?php
            								}
            								if ($value->purchase_order[0] != 0) {
            							?>
            									{{ Form::open(array('action' => 'PurchaseOrdersController@pass_form','method'=>'put')) }}
            										{{Form::hidden('invoice_id',$value->id) }}
            										<input type="submit" class="anchorlink" value="+ Create">
            									{{ Form::close() }}

	                            		<?php

											}
										?>
                        			</td>

                        			<td class="center">
                        				<?php echo "<span class='invis'>".date('YmdHis',strtotime($value->date_created))."</span> ".date('d-m-Y H:i:s',strtotime($value->date_created)); ?>
                        			</td>

                      				<td class="center">
                                   <?php
                                      $all_total_price = $value->total_price + $value->gst;

                                      echo '$'.$all_total_price;
                                    ?>
                                    </td>

                      				<td>
                      				<?php
                      						
                                        $get_inv_pro_qty = 0;$get_total_pro_qty = 0;$pname_list = ''; $product_status = "";

                                         $get_invitem = DB::table('invoice_items')->where('invoice_id','=',$value->id)->get();
                                         $get_qty_status = 0;                 

                                         foreach ($get_invitem as $key => $value1) {
                                             $get_pro = DB::table('products')->where('id','=',$value1->product_id)->first();
                                            

                                              $pname = DB::table('products')->where('id','=',$value1->product_id)->pluck('product_name');

                                             if($value1->product_qty_status == 'required'){
                                                  $qty_status = 1;
                                                  $product_status .= $pname . "  is required<br>";
                                             }


                                         }//end foreach


                                            if($product_status){
                                              echo $product_status;
                                              $get_qty_status = 1;
                                            }else{ 
                                              echo "All product is okay";                   
                                            }

			               				?>


			               				<!-- @if($value->status == 1)
			               					{{ 'This inv is confirmed' }}
			               				@else
			               					@if($get_qty_status == 1)
			               						{{ 'product is required'}}
			               					@else
			               						{{'product status is okay'}}
			               					@endif
			               				@endif -->


			           				</td>

                        			<td class="center">
                        				{{ Form::open(array('action' => 'InvoicesController@download_invoice','id'=>'downloadinvoice')) }}
                        					{{ Form::hidden('id',$value->id) }}
                        					<button type="submit" class="download_btn pull-left"><i class="fa fa-download"></i>  </button>
                        				{{ Form::close() }}
                        				@if($value->status < 1)
                        					<a class="edit_btn" href="{{ URL::to('invoices/'.$value->id) }}">
                        						<i class="fa fa-pencil"></i>
                        					</a>
                        				@endif
                        				<a class="view_btn" href="{{ URL::to('invoices/view/'.$value->id) }}">
                        					<i class="fa fa-eye"></i>
                        				</a>
				                		{{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'InvoicesController@delete_invoice')) }}
			                      			{{ Form::hidden('id',$value->id) }}
			                      			<button type="submit" class="del_btn"><i class="fa fa-trash"></i> </button>
			                    		{{ Form::close() }}
                                		@if($value->status == 0)
                                			@if($get_qty_status != 1)
                                				{{ Form::open(array('action' => 'InvoicesController@confirm_invoice','class'=>'confirm_inv','id'=> 'confirm_inv')) }}
                                					{{ Form::hidden('id',$value->id) }}
                                					<button type="submit" class="btn btn-info redbtn">Confirm</button>
                                				{{ Form::close() }}
                                			@endif
                                		@endif
                        			</td>
                        		</tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!--/span-->

	   <!-- <input type="hidden" id="dataurl">

	    <input type="hidden" id="header"  value="{{ $profile->header }}">

	    <input type="hidden" id="company_name" value="{{ $profile->company_name }}">

	    <input type="hidden" id="terms" value="{{ $profile->terms }}">-->
    </div><!--/row-->
@stop

@section('script')
	{{ HTML::script('js/jspdf.js'); }}
	{{ HTML::script('js/jspdf.plugin.addimage.js'); }}
	<script>
		getBase64FromImageUrl('{{ URL::to("img/logo.jpg") }}');
		var no = 0;
		$(".formdel").submit(function(ev) {
			if (no == 0) {
				var id = $(this).attr('id');
				Boxy.confirm("Are you sure?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});
				return false;
			}
		});

		function pay(n) {
			$('#myModal').modal('show');
			$("#payto").val(n);
		}

		$(document).ready(function($){
			/*$('form#downloadinvoice').submit(function(){
				$.ajax({
					cache: false,
					data: $('form#downloadinvoice').serialize(),
					beforeSend: function() { },
					success: function(mdata) {
						if(mdata.success == false) {
							alert('Something went to wrong.Please Try again later...');
						} else {
							// Write to PDF
							var sdata = [],  height = 0, doc;
							doc = new jsPDF('p', 'pt', 'a4', true);
							doc.setFont("times", "normal");
							doc.setFontSize(25);
							doc.text(250, 50, $("#company_name").val());
							doc.setFontSize(13);
							//var temp = $("#header").val().replace("(<\/div><div>/g","<br>");
							var temp = $("#header").val().replace(/<div>/g,"<br>");
							temp = temp.replace(/<\/div>/g,"");
							var arrtemp = temp.split("<br>");
							for (var n = 0 ; n < arrtemp.length; n++) {
								doc.text(290 - (arrtemp[n].length / 1.5),68 +(n * 18),arrtemp[n]);
							}
							doc.setFontSize(12);
							var imgData = $("#dataurl").val();
							doc.addImage(imgData, 'JPEG', 20, 20, 180, 140);
							sdata = [];
							//sdata = doc.tableToJson('tbl');
							for (var insert = 0; insert <= 20; insert++) {
								sdata.push({
									"name" : "jspdf plugin",
									"version" : insert,
									"author" : "Prashanth Nelli",
									"Designation" : "jspdf table plugin"
								});
							}

							height = doc.drawTable(sdata, {
								xstart : 20,
								ystart : 180,
								cellWidth : 500,
								tablestart : 180,
								marginright :100,
								xOffset : 20,
								yOffset : 15
							});
							doc.text(50, height + 20, 'hi world');
							doc.save("some-file.pdf");
						}
					},
					error: function(xhr, textStatus, thrownError) {
						alert('Something went to wrong.Please Try again later...');
					}
				});
				return false;
			});*/
		});

		function getBase64FromImageUrl(URL) {
			var img = new Image();
			img.src = URL;
			img.onload = function () {
				var canvas = document.createElement("canvas");
				canvas.width =this.width;
				canvas.height =this.height;
				var ctx = canvas.getContext("2d");
				ctx.drawImage(this, 0, 0);
				var dataURL = canvas.toDataURL("image/jpeg");
				$("#dataurl").val(dataURL);
			}
		}
	</script>
@stop
