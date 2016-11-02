@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@stop
@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ URL::to('/dashboard') }}">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/invoices') }}">Invoices</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/invoices/create') }}">Create Invoice</a> 
        </li>
    </ul>
    
   

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Create new invoice</h2>
                
            </div>
            <div class="box-content">
            
				{{ Form::open(array('url' => 'invoices/create','method'=>'post','id'=>'createInvoice')) }}
                    <fieldset> 
                    <div class="control-group">
                       	  <span style="padding-bottom:5px;"><strong>Invoice No. </strong></span>
                         <input type="text" readonly value="{{ $aid }}">
                        
                      </div>
                    <div class="control-group">
                       	  <span style="padding-bottom:5px;"><strong>Delivery Address </strong></span>
                         <input type="text" name="delivery_address" class="form-control" value="" placeholder="Enter Delivery Address...">                     
                      </div>
                      <div class="control-group left">
                       	  <span style="padding-bottom:5px;"><strong>Client</strong></span>
                          <select name="client" required id="selectError" data-rel="chosen">
                          	<option value="-1">Cash and Carry</option>
                             @foreach($clients as $key => $value)
                                <option @if (isset ($quot->client_id) && $quot->client_id == $value->id) selected @endif value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>
                              @endforeach
                          </select>
                          <a class="fancybox fancybox.iframe btn btn-success squarebutton" href="">
                            +
                       	  </a>
                          
                      </div>
                      <div class="control-group right">
                       	  <span style="padding-bottom:5px;"><strong>Sales Staff</strong></span>
                          <select name="sales_staff" required data-rel="chosen2">
                             @foreach($staffs as $key => $value)
                                <option @if (isset ($quot->sales_staff) && $quot->sales_staff == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name." - ".$value->contact }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="clear"></div>
                      <div class="control-group left">
                       	  <span style="padding-bottom:5px;"><strong>Delivery Date</strong></span>
                         
                          <label class="radio" id="radio1"><input type="radio" name="delivery_type" value="1"  id="optionsRadios1"  required> Self - Collect</label>
                          <label class="radio" id="radio2"><input type="radio" checked name="delivery_type" value="2"  id="optionsRadios2"  required> <input type="text" id="datepicker" name="delivery_date"></label>
                      </div>
                      
                       <div class="control-group right">
                       	  <span style="padding-bottom:5px;"><strong>Middlemen</strong></span>
                          <select name="middlemen" data-rel="chosen3">
                             @foreach($middlemen as $key => $value)
                                <option @if (isset ($quot->middleman) && $quot->middleman == $value->id) selected @endif value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="clear"></div>
                      <div class="control-group left">
                       	  <span style="padding-bottom:5px;"><strong>Payment Mode</strong></span>
                          <input type="text" placeholder="Enter Payment Mode" name="payment_mode">
                      </div>
                      <div class="clear"></div>
                      <div class="control-group">
                          <span style="padding-bottom:5px;"><strong>Installation Required</strong></span>
                          <select name="installation"  >
                             <option value="Yes">Yes</option>
                             <option value="No">No</option>
                             <option value="Already Done">Already Done</option>
                          </select>
                      </div>
                      
                      <div class="right">Add <input type="number" class="number" value="1" id="addvalue"> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+">  <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                          		  <th style="width:5%"><input type="checkbox" id="alldelete"></th>
                                  <th style="width:30%">Product</th>
                                  <th style="width:10%">Measurements</th>
                                  <th style="width:10%">Quantity</th>
                                  <th style="width:10%">Selling Price</th>
                                  <th style="width:20%">Final Price</th>    
                                  <th style="width:15%">Amount</th>                           
                              </tr>
                          </thead>   
                          <tbody id="producttable">
                          @if (isset($quotationitems))
                          
                          <?php $cnt = 0; $total_amount = 0;  ?>
                          @foreach ($quotationitems as $key=>$value)
                          <tr id="row{{ $cnt }}">
                          		<td><input type="checkbox" class="delbox" id="delete{{ $cnt }}"></td>
                          	
                                <td>
                                 <select name="product_choice{{ $cnt }}" id="product_choice{{ $cnt }}" required data-rel="chosen">
                                 	<option value="-1">----</option>
                                    <option @if ($value->product_id == -1) selected @endif value="-2">Enter a category</option>
                                     @foreach($products as $key => $v)
                                        <option @if ($value->product_id == $v->id) selected @endif  value="{{ $v->id.";".$v->product_name }}">{{ $v->product_itemno." - ".$v->product_name }}</option>
                                      @endforeach
                                  </select>
                                  <input type="text" name="free{{ $cnt }}" id="free{{ $cnt }}" @if ($value->product_id != -1) style="display:none;" @else value="{{ $value->product_name}} " @endif  class="none" placeholder="Enter the category">
                                  <input type="hidden" name="desc{{ $cnt }}"  value="{{ $value->description }}" id="desc{{ $cnt }}">
                                  <input type="hidden" name="unitprice{{ $cnt }}" value="{{ $value->unit_price }}" id="up{{ $cnt }}">
                                  <input type="hidden" name="hid{{ $cnt }}" value="{{ $value->id }}">
                                
                                </td>
                                <td class="center" id="description{{ $cnt }}"> {{ $value->description }} </td>
                                <td class="center"><input type="number" name="quantity{{ $cnt }}" value="{{ $value->quantity }}" class="number" value="1" id="quantity{{ $cnt }}"></td>
                                <td class="center" id="unitprice{{ $cnt }}">$ {{ $value->unit_price }} </td>
                                <td class="center">
                               	 <label class="radio" id="radio3"><input type="radio" @if ($value->selling_price != 0) checked @endif name="pricetype{{ $cnt }}" value="0" id="optionsRadios3"  > $<input type="number" style="width:80px" @if ($value->selling_price != 0) value = "{{ $value->selling_price}}" @endif step="any" min="0" name="sellingprice{{ $cnt }}" id="sellingprice{{ $cnt }}"></label><br>
                                 <label class="radio" id="radio4"><input type="radio" @if ($value->selling_price == 0) checked @endif name="pricetype{{ $cnt }}" value="1" id="optionsRadios4"  > Free of Charge </label>
                                </td>                                   
                            	
                                
                                <td class="center" id="total0">$ {{ $value->quantity * $value->selling_price }} </td>
                                <?php $total_amount += $value->quantity * $value->selling_price; ?>
                            </tr>
                            <?php $cnt++; ?>
                            @endforeach
                          @else
                          <tr id="row0">
                          		<td><input type="checkbox" class="delbox" id="delete0"></td>
                          		
                                <td>
                                 <select name="product_choice0" id="product_choice0" required data-rel="chosen">
                                 	<option value="-1">----</option>
                                    <option value="-2">Enter a category</option>
                                     @foreach($products as $key => $value)
                                        <option value="{{ $value->id.";".$value->product_name }}">{{ $value->id." - ".$value->product_name }}</option>
                                      @endforeach
                                  </select>
                                  <input type="text" name="free0" id="free0" style="display:none;" class="none" placeholder="Enter the category">
                                  <input type="hidden" name="desc0" id="desc0">
                                  <input type="hidden" name="unitprice0" id="up0">
                                  <input type="hidden" name="cnt" id="cnt">
                                  <input type="hidden" name="total_price" id="tp">
                                </td>
                                
                                <td class="center" id="description0"> --- </td>
                                <td class="center"><input type="number" name="quantity0" class="number" value="1" id="quantity0"></td>
                                <td class="center" id="unitprice0">$ -- </td>
                                <td class="center">
                               	 <label class="radio" id="radio3"><input type="radio" checked name="pricetype0" value="0" id="optionsRadios3"  > $<input type="number" style="width:80px" value="0" step="any" min="0" name="sellingprice0" id="sellingprice0"></label><br>
                                 <label class="radio" id="radio4"><input type="radio" name="pricetype0" value="1" id="optionsRadios0"  > Free of Charge </label>
                                </td>                                   
                            	
                                
                                <td class="center" id="total0">$ -- </td>
                            </tr>
                            @endif
                                              
                          </tbody>
                           
                     </table>
                     <table class="table table-bordered">
                     <tr>
                     	<td style="width:85%;text-align:right">
                        	<strong>Total Amount</strong>
                        </td>
                        <td style="width:15%;" id="totalamount">
                       		 
                          @if (isset($quotationitems))
                       		 $ {{$total_amount}}
                          @else
                             $0
                          @endif
                          
                        </td>
                     </tr>
                     <tr>
                        <td style="width:85%;text-align:right">
                        	<strong>Deposit</strong>
                        </td>
                        <td style="width:15%;">
                        	$<input type="number" step="any" style="width:80px;margin-top:-5px;" name="deposit" id="deposit" placeholder="0">
                        </td>
                     </tr>
                     <tr>
                        <td style="width:85%;text-align:right">
                        	<strong>Balance</strong>
                        </td>
                        <td style="width:15%;" id="balance">
                        	$0
                        </td>
                     </tr>
                     </table>  
                     <strong>Remarks</strong>
                     <textarea class="cleditor" name="remarks" id="textarea2" rows="3"></textarea>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                        
                        <a href="{{ URL::to('invoices') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
            	{{ Form::close() }}
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section('script')

{{ HTML::script('js/jquery.mousewheel-3.0.6.pack.js') }} 
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
	var cnt = 1;
function calculateTotal(){
	var ttl = 0;
	for (var n = 0; n < cnt; n++)
	{
		if ($("#product_choice"+n).val() != -1)
		{
			ttl = ttl + ($("#sellingprice"+n).val() * $("#quantity"+n).val());
		}
	}
	var deposit = $("#deposit").val();
	$("#totalamount").html("$"+ttl);
	$("#balance").html("$"+ (ttl-deposit));
}

$(document).ready(function($){
	var unit_price = <?php echo json_encode($unit_price); ?>;
	var selling_price = <?php echo json_encode($selling_price); ?>;
	var desc = <?php echo json_encode($measurements); ?>;
	var template = $("#producttable").html();
	$('[data-rel="chosen2"],[rel="chosen2"]').chosen();
	$('[data-rel="chosen3"],[rel="chosen3"]').chosen();
	$("#optionsRadios0").click(function(){
		$("#sellingprice0").val(0);
		$("#total0").html("$ ---");
		calculateTotal();
	});
	$("#product_choice0").change(function(){
		if ($("#product_choice0").val() != -1 && $("#product_choice0").val() != -2)
		{
			var tmp = $("#product_choice0").val().split(";");
			$("#unitprice0").html("$"+selling_price[tmp[0]]);
			$("#sellingprice0").attr("min",unit_price[tmp[0]]);
			$("#sellingprice0").val(selling_price[tmp[0]]);
			$("#total0").html("$"+selling_price[tmp[0]]);
			calculateTotal();
			$("#free0").hide();
			$("#row0").find("input,button,textarea").removeAttr('readonly');
			var msr = desc[tmp[0]].split(';');
			if (msr.length == 3)
			{
				$("#description0").html(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
				$("#desc0").val(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
			}
			else
				$("#description0").html("---");
		}
		else if ($("#product_choice0").val() == -2)
		{
			$("#free0").show();
			$("#row0").find("input,button,textarea").prop("readonly", "true");
			$("#free0").removeAttr('readonly');
		}
		else
		{
			$("#free0").hide();
			$("#row0").find("input,button,textarea").removeAttr('readonly');
			$("#unitprice0").html("$---");
			$("#sellingprice0").val("0");
		}
	});
	$("#quantity0").change(function(){
		var amt = $("#quantity0").val() * $("#sellingprice0").val();
		$("#total0").html("$"+amt);
			calculateTotal();
	});
	$("#sellingprice0").change(function(){
		var amt = $("#quantity0").val() * $("#sellingprice0").val();
		$("#total0").html("$"+amt);
		calculateTotal();
	});
	$("#deposit").change(function(){
		calculateTotal();
	});
	var rad = 5;
	$("#addproduct").click(function(){
		
		for (var n = 0; n < $("#addvalue").val(); n++)
		{
			var option = $("#product_choice0 > option").clone();
			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen"></select><input type="text" name="free'+cnt+'" id="free'+cnt+'" style="display:none;" class="none" placeholder="Enter the category"><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="desc'+cnt+'" name="desc'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td> <td class="center" id="description'+cnt+'"> --- </td><td class="center"><input type="number" name="quantity'+cnt+'" class="number" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'">$ -- </td><td class="center"> <label class="radio" id="radio'+rad+'"><input type="radio" checked name="pricetype'+cnt+'" value="0" id="optionsRadios'+rad+'"  > $<input type="number"  style="width:80px" value="0" step="any" min="0" name="sellingprice'+cnt+'" id="sellingprice'+cnt+'"></label><br><label class="radio" id="radio'+(rad+1)+'"><input type="radio" name="pricetype'+cnt+'" value="1" id="optionsRadios'+cnt+'"  > Free of Charge </label></td><td class="center" id="total'+cnt+'">$ -- </td></tr>';
			$("#producttable").append(buildHTML);
			$("#radio"+rad).click(function(){
				$("#optionsRadios"+rad).attr('checked', 'checked');
				$.uniform.update(".optionsRadios3");
			});
			rad++;
			$("#radio"+rad).click(function(){
				$("#optionsRadios"+rad).attr('checked', 'checked');
				$.uniform.update(".optionsRadios4");
			});
			rad++;
			$('#product_choice'+cnt).append(option);				
			
			$("#product_choice"+cnt).change(function(){
				
				var ids = event.target.id.split('_');
				var id = ids[1].split('choice');
				if ($("#product_choice"+id[1]).val() != -1 && $("#product_choice"+id[1]).val() != -2)
				{
					
					var tmp = $("#product_choice"+id[1]).val().split(";");
					$("#unitprice"+id[1]).html("$"+selling_price[tmp[0]]);
					$("#sellingprice"+id[1]).attr("min",unit_price[tmp[0]]);
					$("#sellingprice"+id[1]).val(selling_price[tmp[0]]);
					$("#total"+id[1]).html("$"+selling_price[tmp[0]]);
							calculateTotal();
					$("#free"+id[1]).hide();
					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");
					var msr = desc[tmp[0]].split(';');
					if (msr.length == 3)
					{
						$("#description"+id[1]).html(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
						$("#desc"+id[1]).val(msr[0]+" x " +msr[1] +" x "+ msr[2]+" mm");
					}
					else
						$("#description"+id[1]).html("---");
				}
				else if ($("#product_choice"+id[1]).val() == -2)
				{
					$("#free"+id[1]).show();
					$("#row"+id[1]).find("input,button,textarea").prop("readonly","true");
					$("#free"+id[1]).removeAttr('readonly');
				}
				else
				{
					$("#free"+id[1]).hide();
					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");
					$("#unitprice"+id[1]).html("$---");
					$("#sellingprice"+id[1]).val("0");
					$("#description"+id[1]).html("---");
				}
			});
			$("#quantity"+cnt).change(function(){
				var id = event.target.id.split('quantity');
				var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();
				$("#total"+id[1]).html("$"+amt);
				calculateTotal();
			});
			$("#sellingprice"+cnt).change(function(){
				var id = event.target.id.split('sellingprice');
				var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();
				$("#total"+id[1]).html("$"+amt);
				calculateTotal();
			});
			template_functions();
			$("#product_choice"+cnt).chosen();
			
			$("#optionsRadios"+cnt).click(function(){
				alert(id);
				var id = event.target.id.split('sellingprice');
				$("#sellingprice"+id).val(0);
				$("#total"+id).html("$ ---");
				calculateTotal();
			});
			cnt++;
		}
	});
	
	$("#createInvoice").submit(function(e){
		$("#cnt").val(cnt);
		var total = 0;
		for (var n = 0; n < cnt; n++)
		{
			var up = $("#unitprice"+n).html().split('$');
			$("#up"+n).val(up[1]);
			$("#d"+n).val($("#description"+n).html());
			$("#pn"+n).val($("#product_choice"+n+" option:selected").text());
			total += parseFloat($("#quantity"+n).val()) * parseFloat($("#sellingprice"+n).val());
		}
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
		
		Boxy.confirm("Are you sure?", function() {
			for (var n = 0; n < cnt; n++)
			{
				if ($("#delete"+n).is(":checked"))
				{
					$("#product_choice"+n).val(-1);
				$("#quantity"+n).val(0);
				$("#row"+n).fadeOut('fast');
				}
			}
			 
		}, {title: 'Confirm'});
		return false;
 
	});
});

$('.fancybox').fancybox({
		href : "{{ URL::to ('clients/fancycreate') }}",
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
$("#radio1").click(function(){
	$("#optionsRadios1").attr('checked', 'checked');
	$.uniform.update(".optionsRadios1");
});
$("#radio2").click(function(){
	$("#optionsRadios2").attr('checked', 'checked');
	$.uniform.update(".optionsRadios2");
});
$("#radio3").click(function(){
	$("#optionsRadios3").attr('checked', 'checked');
	$.uniform.update(".optionsRadios3");
});
$("#radio4").click(function(){
	$("#optionsRadios4").attr('checked', 'checked');
	$.uniform.update(".optionsRadios4");
});
$("#optionsRadios2").change(function(){
	$("#optionsRadios2").attr('checked', 'checked');
	$.uniform.update(".optionsRadios2");
});
$("#optionsRadios3").change(function(){
	$("#optionsRadios2").attr('checked', 'checked');
	$.uniform.update(".optionsRadios3");
});
$("#optionsRadios4").change(function(){
	$("#optionsRadios4").attr('checked', 'checked');
	$.uniform.update(".optionsRadios4");
});

</script>
@stop