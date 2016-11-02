@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
    
    <div class="row-fluid sortable">
        <div class="box span12">           
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Create new Purchase Order</h2></div>
            </div>

            <div class="box-content">
            
				{{ Form::open(array('url' => 'purchase_orders/create','method'=>'post','id'=>'createPurchaseOrder')) }}
                    <fieldset>    
                        <?php
						$lastid = DB::table('purchase_orders')->orderby('date_created','desc')->pluck('showid');

						$lastid += 1;
			
						$count = DB::table('purchase_orders')->where('invoice_id','=',$iid)->count();
						$alphabet = array( '','a', 'b', 'c', 'd', 'e',
								   'f', 'g', 'h', 'i', 'j',
								   'k', 'l', 'm', 'n', 'o',
								   'p', 'q', 'r', 's', 't',
								   'u', 'v', 'w', 'x', 'y',
								   'z'
								   );
						if ($count >0)
							$firstalpha = DB::table('purchase_orders')->where('invoice_id','=',$iid)->orderBy('date_created')->pluck('showid');
						else
							$firstalpha = $lastid;
						$newid = $firstalpha.$alphabet[$count];
						$aid = "PO";
						 for ($n = 0; $n < (5 - strlen($newid)); $n++)
						 {
							 $aid .= "0";
						 }
						 $aid .= $newid;
						?>
                   
                      <div class="form-group row">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Purchase Order No. </strong></span></div>
                          <div class="col-md-3">
                          <input type="text" readonly value="{{ $aid }}" name="purchase_order_no" class="form-control">                        
                          </div>
                      </div>  


                      	<div class="form-group row">
                      		<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Invoice ID : </strong></span></div>
                            <?php
								 $pid = "PO";
								 for ($n = 0; $n < (5 - strlen($iid)); $n++)
								 {
									 $pid .= "0";
								 }
								 $pid .= $iid;
							   ?>
                     
                        	 <div class="col-md-3">
                        	  <b> {{ $pid }}</b>                       
                              <input type="hidden" value="{{ $iid }}" name="invoiceid">                          
                             <span class="help-inline"></span>
                           </div>
                      </div>  
                      

                   	<div class="form-group row">
                   	 	<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Contact </strong></span></div>
                        <div class="col-md-3">
                        <input type="text" name="del_contact" class="form-control" placeholder="Enter Delivery Contact...">
                        </div> 
                    </div>


                   	<div class="form-group row">
                       	<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Address </strong></span></div>
                        <div class="col-md-3">
                        <input type="text" name="delivery_address" value="{{$deladdress}}" class="form-control" placeholder="Enter Delivery Address...">
                        </div>
                    </div> 


                   	<div class="form-group row">
                       	<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Date </strong></span></div>
                        <div class="col-md-3">
                        <input type="text" name="delivery_date" class="form-control" id="datepicker" placeholder="Enter Delivery Date...">
                        </div>
                    </div>

                     <div class="form-group row">
                   	 	 <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Attn to  </strong></span></div>
                         <div class="col-md-3">
                         <select disabled name="attn_to" id="attn_to" class="form-control">
                         </select>
                     	 </div>
                     </div>


                    <div class="form-group row">
                    	<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Supplier </strong></span></div>
                        <div class="col-md-3">
                          <select name="supplier" required id="supplier" data-rel="chosen" class="form-control">
                          <option value="0">Choose supplier</option>
                             @foreach($suppliers as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                              @endforeach
                          </select>
                          <!-- <a class="fancybox fancybox.iframe btn btn-success squarebutton" href="">
                            +
                       	  </a> -->
                        </div>
                    </div>


                      <div class="clear"></div>
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                          		  <th><input type="checkbox" id="alldelete"></th>
                                  <th>Product</th>
                                  <!-- <th>Measurements</th> -->
                                  <th>Quantity</th>
                                  <th>Unit Price</th> 
                                  <th>Buying Price</th>   
                                  <!-- <th>Remarks</th>   --> 
                                  <th>Amount</th>                       
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          <input type="hidden" name="total_price" id="tp">
                          <?php $cnt = 0;?>
                           @foreach ($inv as $key =>$value) 
                          	<tr id="row0" @if ($value->purchase_order != 0) class="gray" @endif>
                          		<td><input type="hidden" name="id{{ $cnt }}" value="{{ $value->id }}">
                                <input type="hidden" name="pid{{ $cnt }}" value="{{ $value->product_id }}">
                                <input type="hidden" name="pname{{ $cnt }}" value="{{ $value->product_name }}">
                          		<input type="hidden" id="quantity{{ $cnt }}" name="quantity{{ $cnt }}" value="{{ $value->quantity }}">
                                <input type="hidden" name="selling_price{{ $cnt }}" value="{{ $value->selling_price }}">
                                <input type="hidden" name="unitprice{{ $cnt }}" value="{{ $value->unit_price }}">
                                <input type="checkbox" name="delete{{ $cnt }}" value="1" class="delbox" @if ($value->purchase_order != 0) disabled @endif id="delete{{ $cnt }}">
                                <td>
                                 {{ $value->product_name }}
                                </td>
                                <!-- <td class="center" id="description{{ $cnt }}">  -->
                                <?php
									/*$measurem = DB::table('products')->where('id','=',$value->product_id)->pluck('measurements');
									$msr = explode(";",$measurem);
									if (count($msr) == 3)
										echo $msr[0]." x ".$msr[1]." x ".$msr[2]." mm";
									else
										echo "---";*/
								?>
                                 <!-- </td> -->
                                <td class="center">{{ $value->quantity }}</td>
                                
                                
                                <?php 
                                $val = DB::table('products')->where('id','=',$value->product_id)->pluck('unit_price') 
                                ?>
                                <!-- <td class="center" >$<input class="onetwofive" @if ($value->purchase_order != 0) disabled @endif type="number" max="{{ $value->selling_price }}" value="{{ $val }}" name="buyingprice{{ $cnt }}" id="buyingprice{{ $cnt }}"> </td> -->

                                <td class="center">
                                ${{ $val }}
                                <input type="hidden" id="buyingprice{{ $cnt }}" name="buyingprice{{ $cnt }}" value="{{ $val }}" />
                                </td> 

                                <td class="center">${{ $value->selling_price }}</td>  

                                <!--<td class="center"><textarea @if ($value->purchase_order != 0) disabled @endif name="remarks{{ $cnt }}"></textarea></td>  -->

                                <td class="center" >$<?php echo $value->quantity*$value->selling_price?></td>

                            </tr>
                            <?php $cnt++; ?>
                             @endforeach 
                                <input type="hidden" id="cnt" name="cnt" value="{{ $cnt }}"> 

                          </tbody>
                     </table>  
                     
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create Purchase Order</button>
                        
                        <a href="{{ URL::to('purchase_orders') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
            	{{ Form::close() }}
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section('script')
{{ HTML::script('js/bootstrap-datepicker.js') }}
{{ HTML::script('js/jquery.mousewheel-3.0.6.pack.js') }}
<script type="text/javascript">

$(document).ready(function($){
	var unit_price = <?php echo json_encode($unit_price); ?>;
	var desc = <?php echo json_encode($measurements); ?>;
	var template = $("#producttable").html();
	var cnt = 1;
	
	//$("#datepicker").datepicker();

	var date = new Date();
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    });
	
	$("#createPurchaseOrder").submit(function(e){
		cnt = $("#cnt").val();
		var m = 0;
		for (var n = 0; n < $("#cnt").val(); n++)
		{
			if ($("#delete"+n).is(":checked"))
			{
				m++;
			}
		}
		if (m == 0)
		{
			  e.preventDefault(); 
			alert("Please select at least 1 item");
		}
		var total = 0;
		for (var n = 0; n < cnt; n++)
		{
			if ($("#delete"+n).is(':checked'))
			{
				
				var up = $("#buyingprice"+n).val();
				total += parseInt($("#quantity"+n).val()) * parseInt(up);
			}
		}
		$("#tp").val(total);
	});
	$("#alldelete").click(function(){
		if (this.checked)
		{
			$(".delbox").prop("checked",true);
			$.uniform.update(".delbox");
	
		}
		else
		{
			$(".delbox").prop("checked",false);
			$.uniform.update(".delbox");
		}
	});
	$("#bulkdelete").click(function(){

		if($( ".delbox:checked" ).length > 0){  
		
		for (var n = 0; n < cnt; n++)
		{
			if ($("#delete"+n).is(":checked"))
			{
				$("#product_choice"+n).val(-1);
				$("#quantity"+n).val(0);
				//$("#row"+n).fadeOut('fast');
				$("#row"+n).remove();
                //calculateTotal();
			}
		}

		}else{
	      alert("Please check the box that you want to delete!");
	    } 
    
	});
$.ajax({
				type: 'post',
				data: 'id='+$("#supplier").val(),
				url: '{{URL::to("getcontacts")}}',
				 beforeSend: function() { 

							$('#attn_to').prop('disabled',true);
						 $('#attn_to option[value!="-1"]').remove();
				 },
				  success: function(data) {
						if(data.success == false)
						{  
                   			 alert('Something went to wrong.Please Try again later...');	
							$('#attn_to').prop('disabled',true);
						}
						else
						{
							var contacts = data.split(';');					
for (var n = 0; n < (contacts.length - 1); n = n+ 2)
							{
								$('#attn_to').append('<option value="'+contacts[n]+'">'+contacts[n+1]+'</option>');
							$('#attn_to').prop('disabled',false);
							}
						}
				  },
				  error: function(xhr, textStatus, thrownError) {
                    alert('Something went to wrong.Please Try again later...');
							$('#attn_to').prop('disabled',true);
                }
			});
});
  

	$("#supplier").change(function(){
		
		  $.ajax({
				type: 'post',
				data: 'id='+$(this).val(),
				url: '{{URL::to("getcontacts")}}',
				 beforeSend: function() { 
							$('#attn_to').prop('disabled',true);
						 $('#attn_to option[value!="-1"]').remove();
				 },
				  success: function(data) {
						if(data.success == false)
						{  
                   			 alert('Something went to wrong.Please Try again later...');	
							$('#attn_to').prop('disabled',true);
						}
						else
						{
							var contacts = data.split(';');
							for (var n = 0; n < (contacts.length - 1); n = n+ 2)
							{
								$('#attn_to').append('<option value="'+contacts[n]+'">'+contacts[n+1]+'</option>');
							$('#attn_to').prop('disabled',false);
							}
						}
				  },
				  error: function(xhr, textStatus, thrownError) {
                    alert('Something went to wrong.Please Try again later...');
							$('#attn_to').prop('disabled',true);
                }
			});
	});

$('.fancybox').fancybox({
		href : "{{ URL::to ('suppliers/fancycreate') }}",
		type : 'iframe',
		width: 900,
		height: 800,
		'autoScale'     :   false,
		beforeClose: function() {
			// working
			var $iframe = $('.fancybox-iframe');
			var tmp = $('input', $iframe.contents()).val();
			tmp = tmp.split(";");
			$("#selectError").append($("<option></option>")
							 .attr("value",tmp[0])
							 .text(tmp[1])); 
							 $("#selectError").trigger("liszt:updated");
							 
			$("#selectError").val(tmp[0]).trigger("chosen:updated");
		}
});
$("form").submit(function(e) {
	
});

</script>
@stop