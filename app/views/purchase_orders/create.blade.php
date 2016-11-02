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
    
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> New purchased order</h2></div>
            </div>
            <div class="box-content">

            @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif
            
				{{ Form::open(array('url' => 'purchase_orders/create','method'=>'post','id'=>'createPurchaseOrder')) }}
                    <fieldset>    
              	      <div class="form-group row">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Purchase Order No. </strong></span></div>                          
                          
                          @if(Session::has('aldid'))

                          <div class="col-md-3"><input type="text" name="purchase_order_no" readonly value="" class="form-control" id="po_no"></div>


		                     <button type="button" class="btn btn-primary" id="generate_pono">Generate Purchase Order No.</button>
		                     <?php
		                      $latestid = DB::table('purchase_orders')->orderBy('id', 'desc')->first()->id;

		                       $latestid += 1;
		                       $aid = "PO";
							   for ($n = 0; $n < (5 - strlen($latestid)); $n++)
							   {
								 $aid .= "0";
							   }
		                       $aid .= $latestid;

		                       $generate_pono = $aid;

		                     ?>
		                     <input type="hidden" value="{{$generate_pono}}" id="generate_pono_val" />
		                  @else

		                  <div class="col-md-3"><input type="text" name="purchase_order_no" readonly value="{{ $aid }}" class="form-control" id="po_no"></div>

		                  @endif

                      </div>
                    
                   	 <div class="form-group row">
			     <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Contact </strong></span></div>
			     <div class="col-md-3"><input type="text" name="del_contact" class="form-control" placeholder=" Enter Delivery Contact..."></div>
                        
                      </div> 
                   	 <div class="form-group row">
			     <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Location </strong></span></div>
			     <div class="col-md-3">
				 
					<select name="delivery_address" required id="delivery_address" data-rel="chosen" class="form-control">
						 @foreach($middlemens as $key => $value)
							<option value="{{ $value->id }}">{{ $value->first_name }}</option>
						  @endforeach
				    </select>
				 </div>
                        
                      </div> 
                <div class="form-group row">
			     <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Delivery Date </strong></span></div>
			     <div class="col-md-3"><input type="text" name="delivery_date" class="form-control date-picker" id="datepicker"  placeholder="Enter Delivery Date..."></div>
                        
                </div>
                   	 <div class="form-group row">
			     <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Attn to </strong></span></div>
                          <div class="col-md-3">
			        <select disabled name="attn_to" id="attn_to" class="form-control">
				</select>
			  </div>
                     </div> 

                    <div class="form-group row">
						<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Invoice ID (optional)</strong></span></div>
						<div class="col-md-3">
							<select name="invoiceid" data-rel="chosen" class="form-control">

									<option value="-1">---</option>

								 @foreach($invoices as $key => $value)

									<option value="{{ $value->id }}">{{ $value->invoice_no }}</option>

								  @endforeach

							 </select>
						</div>
                    </div>


                      <div class="form-group row left">
                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Supplier </strong></span></div>
                          <div class="col-md-3">
			  <select name="supplier" required id="supplier" data-rel="chosen" class="form-control">
                             <option value="0">Choose supplier</option>
                             @foreach($suppliers as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                              @endforeach
                          </select>
			  </div>
                      </div>
                      <div class="right">Add <input type="number" step="any" class="number" value="1" id="addvalue"> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+"> <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                          		  <th><input type="checkbox" id="alldelete"></th>
                                  <th>Product</th>
                                  <!--  <th>Measurements</th> -->
                                  <th>Quantity</th>
                                  <th>Unit Price</th>
                                  <th>Buying Price</th>  
                                  <th>Amount</th>                        
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          <tr id="row0">

                                <div style="display:none;">
                                 <select name="product_choice_ori" id="product_choice_ori" required data-rel="chosen" class="po_selectbox">
                                 	<option value="-1">----</option>
                                     @foreach($products as $key => $value)
                                        <option value="{{ $value->id.";".$value->product_name }}">{{ $value->product_itemno." - ".$value->product_name }}</option>
                                      @endforeach
                                  </select>
                                 </div>


                          		<td><input type="checkbox" class="delbox" id="delete0"></td>
                                <td>

                                 <select name="product_choice0" id="product_choice0" required data-rel="chosen" class="po_selectbox">
                                 	<option value="-1">----</option>
                                     @foreach($products as $key => $value)
                                        <option value="{{ $value->id.";".$value->product_name }}">{{ $value->product_itemno." - ".$value->product_name }}</option>
                                      @endforeach
                                  </select>
                                  <input type="hidden" name="product_name0" id="product_name0" value="{{ $value->product_name }}">
                                  <input type="hidden" name="description0" id="d0">
                                  <input type="hidden" name="unitprice0" id="up0">
                                  <input type="hidden" name="cnt" id="cnt">
                                  <input type="hidden" name="total_price" id="tp">
                                  <input type="hidden" id="pn0" name="product_name0">

                                  <input type="hidden" id="gpoc" name="gpoc" value="1">

                                </td>
                                
                                <!--<td class="center" id="description0"> --- </td>-->
                                <td class="center"><input type="number" step="any" name="quantity0" class="number form-control" value="1" id="quantity0"></td>
                                <td class="center" id="unitprice0"> -- </td>
                                <td class="center"><input type="number" step="any" class="onetwofive form-control" placeholder="0" name="buyingprice0" id="buyingprice0"></td>                               
                            	<td class="center" id="total0">-- </td>           
                            </tr>
                            
                                              
                          </tbody>
                     </table> 

                     <table class="table table-bordered">

                     <tr>

                     	<td style="width:92%;text-align:right">

                        	<strong>Total Amount</strong>

                        </td>

                        <td style="width:15%;" id="totalamount">

                       		 0

                        </td>

                     </tr>

                     

                     </table>


                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                        
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

var cnt = 1;
//var cnt = $("#cnt").val();

function calculateTotal(){

	var ttl = 0;

	

	for (var n = 0; n < cnt; n++)

	{

		if ($("#product_choice"+n).val() != -1)

		{
			var buyingprice = $("#buyingprice"+n).val();

			if (buyingprice != null) {
				ttl = ttl + (buyingprice * $("#quantity"+n).val());
			}

		}
	}

	

	//var gst = ttl * 0.07;

	//gst = parseFloat(gst).toFixed(2);

	//var deposit = $("#deposit").val();



    $("#totalamount").html(parseFloat(ttl).toFixed(2));

	//$("#gstval").html(gst);

    $("#tp").val(ttl);
    var total = parseFloat(ttl);

  $("#total").html((total));

	if(parseFloat(total) < deposit){

		alert("Your deposit is greater than total value");

		$("#deposit").focus();

    $(".quo_btn").hide();

	}

	else{

		var ta = parseFloat(total) - deposit;

		ta = parseFloat(ta).toFixed(2);

		$("#balance").html( (ta));

     $(".quo_btn").show();

	}

}

$(document).ready(function($){
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

	//$("#datepicker").datepicker();
	var date = new Date();
	$('#datepicker').datepicker({
		format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    });

	$("form").submit(function(e){
		var total = 0;
		for (var n = 0; n < cnt; n++)
		{
			if ($("#product_choice"+n).val() != -1 && $("#quantity"+n).val() > 0)
			{
				
				var up = $("#buyingprice"+n).val();
				total += parseInt($("#quantity"+n).val()) * parseInt(up);
			}
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
	var unit_price = <?php echo json_encode($unit_price); ?>;
	var desc = <?php echo json_encode($measurements); ?>;
	var sellprice = <?php echo json_encode($sellingprice); ?>;
	var template = $("#producttable").html();
	//var cnt = 1;
	$("#product_choice0").change(function(){
		if ($("#product_choice0").val() != -1)
		{
			var tmp = $("#product_choice0").val().split(";");
			$("#unitprice0").html("$"+unit_price[tmp[0]]);
			$("#up0").val(unit_price[tmp[0]]);
			$("#buyingprice0").val(sellprice[tmp[0]]);
			$("#total0").html(sellprice[tmp[0]]);
			calculateTotal();

			//var cntval = $("#cnt").val();
			$("#cnt").val(1);
			
			var msr = desc[tmp[0]].split(';');
			if (msr.length == 3)
					$("#description0").html(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
			else
				$("#description0").html("---");
		}
		else
		{
			$("#buyingprice0").val(0);
			$("#unitprice0").html("---");
			$("#description0").html("---");
		}
	});


	$("#quantity0").change(function(){

		var amt = $("#quantity0").val() * $("#buyingprice0").val();

		$("#total0").html(amt);

		calculateTotal();

	});

	$("#buyingprice0").change(function(){

		var amt = $("#quantity0").val() * $("#buyingprice0").val();

		$("#total0").html(amt);

		calculateTotal();

	});

	
  
	$("#addproduct").click(function(){
		
		for (var n = 0; n < $("#addvalue").val(); n++)
		{
		    $('#product_choice'+cnt).addClass("form-control");
			//var option = $("#product_choice0 > option").clone();
			var option = $("#product_choice_ori > option").clone();

			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen" class="po_selectbox"></select><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="d'+cnt+'" name="description'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td> <td class="center"><input type="number" step="any" name="quantity'+cnt+'" class="number form-control" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'"> -- </td><td class="center"><input class="onetwofive form-control" type="number" step="any" name="buyingprice'+cnt+'" placeholder="0" id="buyingprice'+cnt+'"></td><td class="center" id="total'+cnt+'">-- </td></tr>';
			$("#producttable").append(buildHTML);				
			
			$('#product_choice'+cnt).append(option);	

			/*var cntval = $("#cnt").val();
			$("#cnt").val(parseInt(cntval)+1);	*/		
			
			$("#product_choice"+cnt).change(function(event){

				var ids = event.target.id.split('_');
				var id = ids[1].split('choice');
				if ($("#product_choice"+cnt).val() != -1)
				{	
					var tmp = $("#product_choice"+id[1]).val().split(";");
					$("#unitprice"+id[1]).html("$"+unit_price[tmp[0]]);
					$("#up"+id[1]).val(unit_price[tmp[0]]);
					$("#buyingprice"+id[1]).val(sellprice[tmp[0]]);

					$("#total"+id[1]).html(sellprice[tmp[0]]);

					calculateTotal();

					var msr = desc[tmp[0]].split(';');
					if (msr.length == 3)
							$("#description"+id[1]).html(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
					else
						$("#description"+id[1]).html("---");
				}
				else
				{
					$("#unitprice"+id[1]).html("$---");
					$("#description"+id[1]).html("---");
					$("#buyingprice"+id[1]).val(0);
				}

			});

			$("#quantity"+cnt).change(function(){
				var id = event.target.id.split('quantity');

				var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();
			});

			$("#buyingprice"+cnt).change(function(){
				var getid= $(this).attr('id');

				var id = getid.replace(/\D/g,'');

				var amt = $("#quantity"+id[1]).val() * $("#buyingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();
			});

			template_functions();
			$("#product_choice"+cnt).chosen();
			
			cnt++;
		}
	});
		//var cnt = $("#cnt").val();

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
			
		Boxy.confirm("Are you sure?", function() {
			for (var n = 0; n < cnt; n++)
			{
				if ($("#delete"+n).is(":checked"))
				{
					$("#product_choice"+n).val(-1);
				$("#quantity"+n).val(0);
				//$("#row"+n).fadeOut('fast');
				$("#row"+n).remove();
           		calculateTotal();
				}
			}
			 
		}, {title: 'Confirm'});
		return false;
	}else{
      alert("Please check the box that you want to delete!");
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


  /************************************/
  $("#generate_pono").click(function(){
      var qno = $("#generate_pono_val").val();
      $("#po_no").val(qno);
  });



</script>
@stop
