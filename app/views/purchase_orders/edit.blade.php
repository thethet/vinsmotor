@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}

    <style type="text/css">
    	select.po_selectbox{
    		width: 240px;
    	}
    </style>

@stop
@section('content')
	<?php //echo json_encode($sellPrice); ?>
    <ul class="breadcrumb">

        <li>

            <i class="icon-home"></i>

            <a href="{{ URL::to('/main') }}">Home</a> 

            <i class="icon-angle-right"></i>

        </li>

        <li> 

        	<a href="{{ URL::to('/purchase_orders') }}">Purchase Orders</a> 

            <i class="icon-angle-right"></i>

        </li>

        <li> 

        	<a href="{{ URL::to('/purchase_orders/'.$id) }}">Edit Purchase Order</a> 

        </li>

    </ul>



    <div class="row-fluid sortable">

		  <div class="box-header row">
			<div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Edit purchased order</h2></div>
		</div>
		
		<div class="box-content">    

		@if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
        @endif        

				    {{ Form::open(array('url' => 'purchase_orders/edit','method'=>'post','id'=>'createPurchaseOrder')) }}

                	{{ Form::hidden('originalid',$id) }}


                    <fieldset>           

                    <div class="form-group row">

						<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Purchase Order No. </strong></span></div>
						<div class="col-md-3"><input class="form-control" type="text" readonly name="id" value="{{ $purchase_order->purchase_order_no }}" id="inputSuccess" placeholder="Enter the Purchase Order ID" readonly=""></div>
					  

						<span class="help-inline"></span>					

					</div>
					
					 <div class="form-group row">
						 <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Contact </strong></span></div>
						 <div class="col-md-3"><textarea name="del_contact" class="form-control" placeholder="Enter Delivery Address...">{{ $purchase_order->delivery_contact }}</textarea></div>
                        
                    </div> 
					
                    <div class="form-group row">
						 <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Location </strong></span></div>
						 <div class="col-md-3">
							<!--<textarea name="delivery_address" class="form-control" placeholder="Enter Delivery Address...">{{ $purchase_order->delivery_address }}</textarea>-->
							<select name="delivery_address" required id="delivery_address" data-rel="chosen" class="form-control">
								 @foreach($middlemens as $key => $value)
									<option @if($purchase_order->delivery_address == $value->id) selected @endif value="{{ $value->id }}">{{ $value->first_name }}</option>
								  @endforeach
							</select>
						</div>
                        
                    </div> 

                     <div class="form-group row">
						 <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Date </strong></span></div>
						 <div class="col-md-3">							
							<input type="text" value="{{ $purchase_order->delivery_date }}" name="delivery_date" class="form-control date-picker" id="datepicker"  placeholder="Enter Delivery Date...">
						</div>
                        
                    </div> 



					<div class="form-group row">
						<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Attn to </strong></span></div>
						<div class="col-md-3">						
							
							<!-- <input type="text" name="attn_to" class="form-control" value="{{ $purchase_order->attn_to }}" placeholder="Attention to"> -->
							
							<?php							
							$get_supplier_contacts = DB::table('supplier_contacts')->where('supplier_id','=',$purchase_order->supplier_id)->get();

							echo '<select name="attn_to" id="attn_to" class="form-control">';
							foreach ($get_supplier_contacts as $key => $value) {
								if ($purchase_order->attn_to == $value->id) {

									$class = 'selected';
								}else{
									$class = '';
								}
								echo '<option value="'.$value->id.'" '.$class.'>'.$value->name.'</option>';
							}
							echo '</select>';

							?>

							<!-- <select disabled name="attn_to" id="attn_to" class="form-control">
				            </select> -->
				           
						</div>
                    </div> 
					
					<div class="form-group row">
						<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Invoice ID (optional)</strong></span></div>
						<div class="col-md-3">
							<select name="invoiceid" data-rel="chosen" class="form-control">

									<option value="-1">---</option>

								 @foreach($invoices as $key => $value)

									<option @if($purchase_order->invoice_id == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->invoice_no }}</option>

								  @endforeach

							 </select>
						</div>
                    </div>
					
					 <div class="form-group row left">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Supplier </strong></span></div>
                          <div class="col-md-3">
								<select name="supplier" required id="supplier" data-rel="chosen" class="form-control">
								{{$purchase_order->supplier_id}}
								@if($purchase_order->supplier_id == 0)
								<option value="0">Choose supplier</option>
								@endif
									 @foreach($suppliers as $key => $value)
										<option @if($purchase_order->supplier_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->supplier_name }}</option>
									  @endforeach
								</select>
							</div>
                      </div>
						
                      <div class="right">Add <input type="number" class="number" value="1" id="addvalue"> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+"> <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>
					
                      <table class="table table-bordered table-striped">

                          <thead>

                              <tr>

                          		  <th><input type="checkbox" id="alldelete"></th>

                                  <th>Product</th>

                                  <!--<th>Description</th>-->

                                  <th>Quantity</th>

                                  <th>Unit Price</th>

                                  <th>Buying Price</th>     

                                  <th>Amount</th>                             

                              </tr>

                          </thead>   

                          <tbody id="producttable">

                          <?php $cnt = 0; $total_amount = 0;  ?>

                          @foreach ($inv as $k => $v)

                          

                          <tr id="row{{ $cnt }}">

                         <div style="display:none;">
                         <select name="product_choice_ori" id="product_choice_ori" required data-rel="chosen" class="po_selectbox">
                         	<option value="-1">----</option>
                             @foreach($products as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->product_name }}</option>
                              @endforeach
                          </select>
                         </div>


                          		<td><input type="checkbox" class="delbox" id="delete{{ $cnt }}"></td>

                                <td>

                                 <select name="product_choice{{ $cnt }}" id="product_choice{{ $cnt }}" required data-rel="chosen" class="po_selectbox">

                                 	<option value="-1">----</option>

                                     @foreach($products as $key => $value)

                                        <option  @if($v->product_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->product_name }}</option>

                                      @endforeach

                                  </select>

                                  

                                  <input type="hidden" name="type{{ $cnt }}" value="0">

                                  <input type="hidden" name="description{{ $cnt }}" id="d{{ $cnt }}">

                                  <input type="hidden" name="unitprice{{ $cnt }}" id="up{{ $cnt }}">

                                  <input type="hidden" name="itemid{{ $cnt }}" value="{{ $v->id }}">

                                  <input type="hidden" id="pn0" name="product_name{{ $cnt }}">

                                </td>

                                

                                <!--<td class="center" id="description{{ $cnt }}">{{ $v->description }} </td>-->

                                <td class="center"><input type="number" name="quantity{{ $cnt }}" id="quantity{{ $cnt }}" class="number" value="{{ $v->quantity }}" id="quantity{{ $cnt }}"></td>

                                <td class="center" id="unitprice{{ $cnt }}">$ {{ $v->unit_price }} </td>

                                <td class="center">$<input type="number" value="{{ $v->buying_price }}" name="buyingprice{{ $cnt }}" id="buyingprice{{ $cnt }}"></td>

                                 <td class="center" id="total{{ $cnt }}">

                                  <?php 
                                  $total = $v->quantity * $v->buying_price;
                                  echo sprintf ("%.2f", $total);

                                  ?>

                                 </td>

                                   <?php $total_amount += $total; ?>

                    

                            </tr>

                            <?php $cnt++; ?>

                            @endforeach

                                              

                          </tbody>

                     </table>  


                     <!-- <input type="hidden" name="total_price" value="{{ $purchase_order->total_price }}" id="tp"> -->

                     <input type="hidden" name="cnt" value="{{ $cnt }}" id="cnt">
                     
                     <input type="hidden" name="total_price" id="tp" value="{{ $total_amount }}">
  
                     <table class="table table-bordered">

                     <tr>

                     	<td style="width:89%;text-align:right">

                        	<strong>Total Amount</strong>

                        </td>

                        <td style="width:15%;" id="totalamount">

                       		<?php
                       			echo sprintf ("%.2f", $total_amount);
                       		?>

                        </td>

                     </tr>

                     

                     </table>


                      <!--  <strong>Remarks</strong>

                    <textarea class="cleditor" name="remarks" id="textarea2" rows="3">{{ $purchase_order->remarks }}</textarea>-->
					<div class="form_group row">

						<div class="col-md-1"><strong>Remarks</strong></div>

						<div class="col-md-10">

							<textarea class="cleditor" name="remarks" id="textarea2" rows="3">{{ $purchase_order->remarks }}</textarea>

						</div>

					</div>
                      <div class="form-actions">

                        <button type="submit" class="btn btn-primary">Edit Purchase Order</button>

                        

                        <a href="{{ URL::to('purchase_orders') }}"><input type="button" value="Cancel" class="btn"></a>

                      </div>

                    </fieldset>

            	{{ Form::close() }}

            </div>

    

    </div><!--/row-->

			

			

    

@stop



@section('script')

{{ HTML::script('js/bootstrap-datepicker.js') }}

<script type="text/javascript">



$(document).ready(function($){

	var date = new Date();
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    });

    /********************************/
	
	var unit_price = <?php echo json_encode($unit_price); ?>;
	
	var sell_price = <?php echo json_encode($sellPrice); ?>;

	var desc = <?php echo json_encode($desc); ?>;

	var template = $("#producttable").html();

	var cnt = parseInt($("#cnt").val());

	for (var j =0; j < cnt; j++)

	{

		$("#product_choice"+j).change(function(event){

			var ids = event.target.id.split('_');

			var id = ids[1].split('choice');

			if ($("#product_choice"+j).val() != -1)

			{ 
				var tr = $(this).closest("tr");
				var rowindex = tr.index(); 

				$("#unitprice"+ rowindex).html("$"+unit_price[$(this).val()]);
				$("#up"+ rowindex).val(unit_price[$(this).val()]);
				
				$("#buyingprice"+ rowindex).val(sell_price[$(this).val()]);

				var tmp = $("#product_choice"+id[1]).val().split(";");
				$("#total"+id[1]).html(sell_price[tmp[0]]);

				calculateTotal();

			//	$("#buyingprice"+0).val(unit_price[$("#product_choice0").val()]);

			//	$("#description"+0).html(desc[$("#product_choice0").val()]);

			}

			else

			{

				$("#unitprice"+id[1]).html("$---");

				//$("#buyingprice"+id[1]).val("0");

				//$("#description"+id[1]).html("---");

			}

		});

		$("#quantity"+j).change(function(event){


        //total += parseInt($("#quantity"+n).val()) * parseInt($("#buyingprice"+n).val());
      	
      	var id = event.target.id.split('quantity');

		var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

		$("#total"+id[1]).html(amt);

      calculateTotal();

    });



	$("#buyingprice"+j).change(function(event){
		var id = event.target.id.split('buyingprice');

		var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

		$("#total"+id[1]).html(amt);

		calculateTotal();
	});

	}






	$("#addproduct").click(function(){ 

		   var cnt = $("#cnt").val();

		    var get_cnt = $("#cnt").val();

		    var cnt1 = parseFloat(get_cnt) +1 ;

		    $("#cnt").val(cnt1);

		for (var n = 0; n < $("#addvalue").val(); n++)

		{

			//var option = $("#product_choice0 > option").clone();

			var option = $("#product_choice_ori > option").clone();

			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen" class="po_selectbox"></select><input type="hidden" name="type'+cnt+'" value="1"><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="d'+cnt+'" name="description'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td> <!--<td class="center" id="description'+cnt+'">  </td>--><td class="center"><input type="number" name="quantity'+cnt+'" id="quantity'+cnt+'" class="number" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'">$ -- </td><td class="center">$<input type="number" name="buyingprice'+cnt+'" value="0" id="buyingprice'+cnt+'"></td><td class="center" id="total'+cnt+'"> -- </div></td><input type="hidden" name="new'+cnt+'" value="1"/></tr>';

			$("#producttable").append(buildHTML);

			
			$('#product_choice'+cnt).append(option);
			
			$('#product_choice'+cnt).val(-1);

			
			

			$("#product_choice"+cnt).change(function(event){


				var ids = event.target.id.split('_');

				var id = ids[1].split('choice');

				if ($("#product_choice"+cnt).val() != -1)

				{ 
				
					var tr = $(this).closest("tr");
					
					var rowindex = tr.index(); 

					$("#unitprice"+rowindex).html("$"+unit_price[$(this).val()]);

					$("#up"+ rowindex).val(unit_price[$(this).val()]);
					
					$("#buyingprice"+ rowindex).val(sell_price[$(this).val()]);

					var tmp = $("#product_choice"+id[1]).val().split(";");
				    $("#total"+id[1]).html(sell_price[tmp[0]]);


					calculateTotal();

					//$("#description"+id[1]).html(desc[$("#product_choice"+id[1]).val()]);

					//$("#buyingprice"+id[1]).val(unit_price[$("#product_choice"+id[1]).val()]);

				}

				else

				{

					$("#unitprice"+id[1]).html("$---");

					$("#description"+id[1]).html("---");

				}

        

			});


			$("#quantity"+cnt).change(function(event){


		        //total += parseInt($("#quantity"+n).val()) * parseInt($("#buyingprice"+n).val());
		      	
		      	var id = event.target.id.split('quantity');

				var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

		      calculateTotal();

		    });



			$("#buyingprice"+cnt).change(function(event){
				var id = event.target.id.split('buyingprice');

				var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();
	});

			

			$("#product_choice"+cnt).chosen();

			

			cnt++;

		}

	});

	

	$("#createPurchaseOrder").submit(function(){

		var cnt = $("#cnt").val();

		var total = 0;

		for (var n = 0; n < cnt; n++)

		{

			var up = $("#unitprice"+n).html().split('$');

			$("#up"+n).val(up[1]);

			$("#d"+n).val($("#description"+n).html());

			$("#pn"+n).val($("#product_choice"+n+" option:selected").text());

			total += parseInt($("#quantity"+n).val()) * parseInt($("#buyingprice"+n).val());

		}

		$("#cnt").val(cnt);
		$("#tp").val(total);

		var m = 0;
			for (var n = 0; n < cnt; n++)
			{
				if ($("#product_choice"+n).val() != -1 && $("#product_choice"+n).val() != -2)
				{
					m++;
				}
			}
			if (m == 0)
			{
				e.preventDefault();
				alert("Please select at least 1 product");
			}

	});

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

	for (var n = 0; n < $("#cnt").val(); n++)

	{

		if ($("#delete"+n).is(":checked"))

		{

			$("#product_choice"+n).val(-1);

			$("#quantity"+n).val(0);

			var tt = $("#cnt").val() - 1;

			$("#cnt").val(tt);

			//$("#row"+n).fadeOut('fast');

			$("#row"+n).remove();


            calculateTotal();

		}

	}
	
	}else{
      alert("Please check the box that you want to delete!");
    } 

});


/************************/
function calculateTotal(){


  var ttl = 0;

  var cnt = $("#cnt").val();


	for (var nn = 0; nn < cnt; nn++)

	{		

		if ($("#product_choice"+nn).val() != -1 )

		{

        var buyingprice = $("#buyingprice"+nn).val();

        if (buyingprice != null) {
	        ttl = ttl + (buyingprice * $("#quantity"+nn).val());
	    }

		}

	}


	var deposit = $("#deposit").val();

	$("#totalamount").html(parseFloat(ttl).toFixed(2));

  //var gst = ttl * 0.07;

  //gst = parseFloat(gst).toFixed(2);

  //$("#gstval").html(gst);

  var total1 = parseFloat(ttl);



  $("#total").html((total1));

  $("#tp").val(ttl);

  if(parseFloat(total1) < deposit){

    alert("Your deposit is greater than total value");

    $("#deposit").focus();

    $(".quo_btn").hide();

  }

  else{

    var ta = parseFloat(total1) - deposit;

    ta = parseFloat(ta).toFixed(2);

    $("#balance").html( (ta));

    $(".quo_btn").show();

  }

}

/***************************************************/

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

</script>



@stop
