@extends('layouts.main')



@section('header')

    {{ HTML::style('css/jquery.fancybox.css'); }}

     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

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

                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Edit invoice</h2></div>

            </div>

            <div class="box-content">

		{{ Form::open(array('action' => 'InvoicesController@save_edit','method'=>'post','id'=>'editInvoice')) }}

                <fieldset>

                    <div class="form-group row">

			<div class="col-md-1"><span style="padding-bottom:5px;"><strong>Invoice No. </strong></span></div>

                         <div class="col-md-3"><input type="text" name="invoice_no" readonly  value="{{ $invoices->invoice_no }}" class="form-control">

                         <input type="hidden" name="invoice_id" readonly value="{{ $invoices->id }}">

                         </div>

                      </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Client</strong></span></div>

			  <div class="col-md-3">

                          <select name="client" required id="selectError" data-rel="chosen" class="form-control">

                          	<option value="-1">Cash and Carry</option>

                             @foreach($clients as $key => $value)

                                <option @if ($invoices->client_id == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>

                              @endforeach

                          </select>

                          </div>

                      </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Sales Staff</strong></span></div>

			  <div class="col-md-3">

                          <select name="sales_staff" required data-rel="chosen2" class="form-control">

                              @foreach($staffs as $key => $value)

                                <option @if ($invoices->sales_staff == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name." - ".$value->contact }}</option>

                              @endforeach

                          </select>

			  </div>

                      </div>

                      <div class="clear"></div>



                      <div class="form-group row" style="display:none;">

                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Installation Required</strong></span></div>

                           <div class="col-md-3"><select name="installation" class="form-control" >

                             <option @if ($invoices->installation == "Yes") selected @endif value="Yes">Yes</option>

                             <option @if ($invoices->installation == "No") selected @endif value="No">No</option>

                             <option @if ($invoices->installation == "Already Done") selected @endif value="Not Done">Already Done</option>

                          </select>

			   </div>

                      </div>

                       <div class="form-group row">

			   <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Company</strong></span></div>

			   <div class="col-md-3">

                          <select name="middlemen" data-rel="chosen3" id="selectError1" class="form-control">

                             @foreach($middlemen as $key => $value)

                                <option @if ($invoices->middleman == $value->id) selected @endif value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>

                              @endforeach

                          </select>

                           </div>

                      </div>
					 <div class="form-group row">
					     <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service</strong></span></div>
                          <div class="col-md-3">
                            <div class="col-md-2" style="margin-left:10px;"><input type="radio" name="service" id="service_yes" value="yes" <?php if($invoices->service_content){echo 'checked="checked"';}?> />Yes</div>
                            <div class="col-md-2"><input type="radio" name="service" id="service_no" value="no" <?php if(empty($invoices->service_content)){echo 'checked="checked"';}?> />No</div>
                        </div>
                      </div>

                      <div class="form-group row" id="service_content_wrapper" <?php if($invoices->service_content){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?>>
                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service Content</strong></span></div>
                          <div class="col-md-3">
                           		<input class="form-control" name='service_content' id='service_content' value="{{$invoices->service_content}}">
                        </div>
                      </div>

                      <div class="clear"></div>

                      <div class="form-group row">

                       	  <div class="col-md-1"> <span style="padding-bottom:5px;"><strong>Payment Mode</strong></span></div>

			  <div class="col-md-3">

                          <input type="text" value="{{ $invoices->payment_mode }}" placeholder="Enter Payment Mode" name="payment_mode" class="form-control">

			  </div>

                      </div>



                      <div class="right"><div class="padding20 pull-left">Add</div><div class="col-md-1"><input type="number" class="number form-control " value="1" id="addvalue" min="0"></div> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+">  <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>

                      <table class="table table-bordered table-striped">

                          <thead>

                              <tr>

                          		  <th style="width:5%"><input type="checkbox" id="alldelete"></th>

                                  <th style="width:30%">Product</th>

                                 <!-- <th style="width:10%">Measurements</th>-->

                                  <th style="width:10%">Quantity</th>

                                  <th style="width:10%">Selling Price</th>

                                  <th style="width:20%">Final Price</th>

                                  <th style="width:15%">Amount</th>

                              </tr>

                          </thead>

                          <tbody id="producttable">

                          <?php $cnt = 0; $total_amount = 0;  ?>

                          @foreach ($inv as $key=>$value)

                          <tr id="row{{ $cnt }}">

                              <div style="display:none;">
                              <select name="product_choice_ori" id="product_choice_ori" required data-rel="chosen" class="po_selectbox">

                                  <option value="-1">----</option>

                                     @foreach($products as $key => $v)

                                        <option @if ($value->product_id == $v->id) selected @endif  value="{{ $v->id.";".$v->product_name }}">{{ $v->product_itemno." - ".$v->product_name }}</option>

                                      @endforeach

                                  </select>
                                </div>

                          		<td><input type="checkbox" class="delbox" id="delete{{ $cnt }}" value="{{ $value->id }}"></td>



                                <td>

                                 <select name="product_choice{{ $cnt }}" id="product_choice{{ $cnt }}" required data-rel="chosen" class="po_selectbox">

                                 	<option value="-1">----</option>

                                    <!-- <option @if ($value->product_id == -1) selected @endif value="-2">Enter a category</option> -->

                                     @foreach($products as $key => $v)

                                        <option @if ($value->product_id == $v->id) selected @endif  value="{{ $v->id.";".$v->product_name }}">{{ $v->product_itemno." - ".$v->product_name }}</option>

                                      @endforeach

                                  </select>

                                  <input type="text" name="free{{ $cnt }}" id="free{{ $cnt }}" @if ($value->product_id != -1) style="display:none;" @else value="{{ $value->product_name}} " @endif  class="none" placeholder="Enter the category">

                                  <input type="hidden" name="desc{{ $cnt }}"  value="{{ $value->description }}" id="desc{{ $cnt }}">

                                  <input type="hidden" name="unitprice{{ $cnt }}" value="{{ $value->unit_price }}" id="up{{ $cnt }}">

                                  <input type="hidden" name="hid{{ $cnt }}" value="{{ $value->id }}">

                                   <input type="hidden" name="new{{ $cnt }}" value="0"/>

                                </td>

                             <!--   <td class="center" id="description{{ $cnt }}"> {{ $value->description }} </td>-->

                                <td class="center"><input type="number" name="quantity{{ $cnt }}" value="{{ $value->quantity }}" class="number form-control" value="1" id="quantity{{ $cnt }}"></td>

                                <td class="center" id="unitprice{{ $cnt }}"> {{ $value->unit_price }} </td>

                                <td class="center">

				    <div class="padding20">

                               	 <label class="radio" id="radio3"><input type="radio" @if ($value->status == 0) checked @endif name="pricetype{{ $cnt }}" value="0" id="optionsRadios3"  class="check_total"> <input type="number" class="form-control" style="width:80px" value = "{{ $value->selling_price }}" step="any" min="0" name="sellingprice{{ $cnt }}" id="sellingprice{{ $cnt }}"></label><br>

                                 <label class="radio" id="radio4"><input type="radio" @if ($value->status == 1) checked @endif name="pricetype{{ $cnt }}" value="1" id="optionsRadios4" class="check_free" > Free of Charge </label></div>

                                </td>





                                <td class="center" id="total{{ $cnt }}">

                                  <?php if($value->status == 0){ $total = $value->quantity * $value->selling_price;

                                   }

                                  else{

                                     $total = "--";

                                  }

                                  echo $total;

                                  ?>

                                 </td>

                                <?php //$total_amount += $value->quantity * $value->selling_price; ?>
                                <?php $total_amount += $total; ?>

                            </tr>

                            <?php $cnt++; ?>

                            @endforeach

                            <?php
                                $total_amount += $invoices->service_content; 
                            ?>


                          </tbody>



                     </table>

                     <input type="hidden" name="cnt" id="cnt" value="{{ $cnt }}">

                    <input type="hidden" name="total_price" id="tp" value="{{ $total_amount }}">

                     <table class="table table-bordered">

                     <tr>

                     	<td style="width:85%;text-align:right">

                        	<strong>Total Amount</strong>

                        </td>

                        <td style="width:15%;" id="totalamount">

                       		  {{$total_amount}}

                        </td>

                     </tr>

                     <tr>
                      <td style="width:85%;text-align:right;">
                        <strong>GST</strong>
                      </td>
                      <td style="width:15%;padding-left:30px;padding-top:0px;">
                        <input type="radio" name="gstopt" id="no_gst" value="no_gst" <?php if($invoices->gst_status == 'no_gst' )echo 'checked';?>> No GST<br>
                        <input type="radio" name="gstopt" id="gst_already" value="gst_already" <?php if($invoices->gst_status == 'gst_already' )echo 'checked';?>> GST already included<br>
                        <input type="radio" name="gstopt" id="gstyes" value="gstyes" <?php if($invoices->gst_status == 'gstyes' )echo 'checked';?>> GST 7%
                      </td>
                    </tr>

                     <?php                           
                          $chkgst = $invoices->gst;
                          if ($chkgst != '0.00') {

                            $gst_class = '';
                          }else{
                            $gst_class = 'style="display:none;"';
                          }

                      ?>

                     <tr id="gst_wrapper" <?php echo $gst_class; ?>>

                      <td style="width:85%;text-align:right">

                          <strong>7% GST</strong>

                        </td>

                        <td style="width:15%;" id="gstval">

                          <?php //$gst = round($total_amount * 0.07) ?>

                          <?php 
                          echo $invoices->gst;
                          ?>

                        </td>

                        <input type="hidden" name="get_gstval" id="get_gstval">

                     </tr>

                     <tr>

                      <td style="width:85%;text-align:right">

                          <strong>Total</strong>

                        </td>

                        <td style="width:15%;" id="total">

                          <?php 
                          //$total = $total_amount + $gst;

                          $chkgst = $invoices->gst;
                          if ($chkgst != '0.00') {

                            $total = $total_amount + $chkgst;
                          }else{
                            $total = $total_amount;
                          }

                          echo sprintf ("%.2f", $total);

                          ?>


                        </td>

                     </tr>

                     <tr>

                        <td style="width:85%;text-align:right">

                        	<strong>Deposit</strong>

                        </td>

                        <td style="width:15%;">

                          <input type="number" min="0" step="any" class="form-control" style="width:80px;margin-top:-5px;" name="deposit" id="deposit" placeholder="0" value="{{ $invoices->total_paid }}">



                        </td>

                     </tr>

                     <tr>

                        <td style="width:85%;text-align:right">

                        	<strong>Balance</strong>

                        </td>

                        <td style="width:15%;" id="balance">

                        	<?php
                              echo sprintf ("%.2f", $total - $invoices->total_paid);
                          ?>

                        </td>

                     </tr>

                     </table>

                     <div class="form_group row">

			 <div class="col-md-1"><strong>Remarks</strong></div>

			<div class="col-md-10">

			<textarea class="cleditor" name="remarks" id="textarea2" rows="3">{{ $invoices->remarks }}</textarea>

			</div>

		     </div>

		     <br/>

                      <div class="form-group row">

                        <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary inv_btn">Update</button>



                        <a href="{{ URL::to('invoices') }}"><input type="button" value="Cancel" class="btn"></a>

			</div>

                      </div>

                    </fieldset>

                     <input type="hidden" name="total_price_inv" id="total_price_inv"/>

                      <input type="hidden" name="edit_inv" value="1"/>
                      <input type="hidden" name="invoice_id_list" id="invoice_id_list" value=""/>

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

  $(document).ready(function(){
	  $("#service_content").on("input", function(){
	   number_only(this);
	  });

	  $('body').on('keyup', '#service_content', function(e){

		//var service_amount = document.getElementById("service_content").value;

		calServiceTotal();

	  });

});


function calServiceTotal(){
  var cnt = $("#cnt").val();
	var ttl = 0;
	var s_amount = $("#service_content").val();
	for (var n = 0; n < cnt; n++)
	{
		if ($("#product_choice"+n).val() != -1)
		{
			var k = $('input[name="pricetype'+n+'"]:checked').val();
      var sellprice = $("#sellingprice"+n).val();
      if(k == 0){
        ttl = ttl + (sellprice * $("#quantity"+n).val());
      }
		}
	}
	/*var deposit = $("#deposit").val();
	$("#totalamount").html("$"+ttl);
	$("#balance").html("$"+ (ttl-deposit));*/
  
  var gstopt_val = $('input[name="gstopt"]:checked').val();
  if (gstopt_val == 'gstyes') {
    var gst = ttl * 0.07;
    gst = parseFloat(gst).toFixed(2);
  }else{
    var gst = 0;
    gst = parseFloat(gst).toFixed(2);
  }

  $("#gstval").html(gst);
  $("#get_gstval").val(gst);


  var deposit = $("#deposit").val();

    if (s_amount == '') {
      ttl = ttl;
    }else{
      ttl = ttl + parseInt(s_amount);
    }

  ttl = parseFloat(ttl).toFixed(2);
  $("#totalamount").html(ttl);
  
  var total = parseFloat(ttl) + parseFloat(gst);
  $("#total").html(total);
  if(parseFloat(total) < deposit){
    alert("Your deposit is greater than total value");
    $("#deposit").focus();
    $(".inv_btn").hide();
  }
  else{
    var ta = parseFloat(total) - deposit;
    ta = parseFloat(ta).toFixed(2);
    $("#balance").html(ta);
    $(".inv_btn").show();
  }
}
function calculateTotal(){

  var cnt = $("#cnt").val();

	var ttl = 0;

  for (var nn = 0; nn < cnt; nn++)

  {

    if ($("#product_choice"+nn).val() != -1)

    {

      var k = $('input[name="pricetype'+nn+'"]:checked').val();

      var sellprice = $("#sellingprice"+nn).val();

      if(k == 0){

        ttl = ttl + (sellprice * $("#quantity"+nn).val());

      }

    }

  }

  var gstopt_val = $('input[name="gstopt"]:checked').val();
  if (gstopt_val == 'gstyes') {
    var gst = ttl * 0.07;
    gst = parseFloat(gst).toFixed(2);
  }else{
    var gst = 0;
    gst = parseFloat(gst).toFixed(2);
  }

  $("#gstval").html(gst);
  $("#get_gstval").val(gst);

  var deposit = $("#deposit").val();

 /* var s_amount = $("#service_content").val();

  if (s_amount == '') {
    ttl = ttl;
  }else{
    ttl = ttl + parseInt(s_amount);
  }*/


   //ttl += parseInt($("#service_content").val());

  $("#totalamount").html(ttl);
  $("#tp").val(ttl);

  //$("#gstval").html("$"+gst);

  var total = parseFloat(ttl) + parseFloat(gst);

  $("#total").html(total);

  if(parseFloat(total) < deposit){

    alert("Your deposit is greater than total value");

    $("#deposit").focus();

    $(".inv_btn").hide();

  }

  else{

    var ta = parseFloat(total) - deposit;

    ta = parseFloat(ta).toFixed(2);

    $("#total_price_inv").val(ttl);

    $("#balance").html(ta);

    $(".inv_btn").show();

  }

}

function check_total(c){

   var  sid = c.id;

   var sproid = c.value;

   var valtr = $("#"+sid).closest('tr').attr('id');

   var thenum = valtr.replace(/\D/g,'');

   if(thenum == 0){

      var sp = "sellingprice0";

      var tot = "total0";

      var q = "quantity0";

   }

   else{

    var sp = "sellingprice"+thenum;

    var tot = "total"+thenum;

    var q = "quantity"+thenum;

   }

   var get_sp = $("#"+valtr+" #"+sp).val();

   var get_q = $("#"+valtr+" #"+q).val();

   var get_tot = parseFloat(get_sp) * parseFloat(get_q);

   get_tot = parseFloat(get_tot).toFixed(2);



   $("#"+valtr+" #"+tot).html("$"+get_tot);

   calculateTotal();

}



function check_free(c){

   var  sid = c.id;

   var thenum = sid.replace(/\D/g,'');

   if(thenum == 0){

      var tot = "total0";

   }

   else{

    var tot = "total"+thenum;

   }

   var get_tot = "--";

   $("#"+tot).html("$"+get_tot);

   calculateTotal();

}



$(document).ready(function($){

  $(".check_total").click(function(){

   var valtr = $(this).closest('tr').attr('id');

   var thenum = valtr.replace(/\D/g,'');

   if(thenum == 0){

      var sp = "sellingprice0";

      var tot = "total0";

      var q = "quantity0";

   }

   else{

    var sp = "sellingprice"+thenum;

    var tot = "total"+thenum;

    var q = "quantity"+thenum;

   }

   var get_sp = $("#"+valtr+" #"+sp).val();

   var get_q = $("#"+valtr+" #"+q).val();

   var get_tot = parseFloat(get_sp) * parseFloat(get_q);

   get_tot = parseFloat(get_tot).toFixed(2);



   $("#"+valtr+" #"+tot).html(get_tot);

   calculateTotal();



  });



  $(".check_free").click(function(){

     var valtr = $(this).closest('tr').attr('id');

     var thenum = valtr.replace(/\D/g,'');

     if(thenum == 0){

        var tot = "total0";

     }

     else{

      var tot = "total"+thenum;

     }

     var get_tot = "--";

     $("#"+tot).html(get_tot);

     calculateTotal();

  });

	var unit_price = <?php echo json_encode($unit_price); ?>;

	var selling_price = <?php echo json_encode($selling_price); ?>;

	var desc = <?php echo json_encode($measurements); ?>;

	var template = $("#producttable").html();

	$('[data-rel="chosen2"],[rel="chosen2"]').chosen();

	$('[data-rel="chosen3"],[rel="chosen3"]').chosen();



	$("#deposit").change(function(){

		calculateTotal();

	});



	for (var j = 0; j < $("#cnt").val(); j++)

	{

		$("#product_choice"+j).change(function(event){


			var ids = event.target.id.split('_');

			var id = ids[1].split('choice');

			if ($("#product_choice"+id[1]).val() != -1 && $("#product_choice"+id[1]).val() != -2)

			{

				var tmp = $("#product_choice"+id[1]).val().split(";");

				$("#unitprice"+id[1]).html("$"+selling_price[tmp[0]]);

				$("#sellingprice"+id[1]).attr("min",unit_price[tmp[0]]);

				$("#sellingprice"+id[1]).val(selling_price[tmp[0]]);

				$("#total"+id[1]).html(selling_price[tmp[0]]);

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

				$("#free"+id[1]).removeAttr('disabled');

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

		$("#quantity"+j).change(function(event){

			var id = event.target.id.split('quantity');

			var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();

			$("#total"+id[1]).html(amt);

			calculateTotal();

		});

		$("#sellingprice"+j).change(function(event){

			var id = event.target.id.split('sellingprice');

			var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();

			$("#total"+id[1]).html(amt);

			calculateTotal();

		});

		template_functions();

		$("#product_choice"+j).chosen();



	}

	var rad = 5;

	$("#addproduct").click(function(){

		 var cnt = $("#cnt").val();

    var get_cnt = $("#cnt").val();

    var cnt1 = parseFloat(get_cnt) +1 ;

    $("#cnt").val(cnt1);



		for (var n = 0; n < $("#addvalue").val(); n++)

		{

			//var option = $("#product_choice0 > option").clone();
      var option = $("#product_choice_ori > option").clone();

			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select class="po_selectbox" name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen"></select><input type="text" name="free'+cnt+'" id="free'+cnt+'" style="display:none;" class="none form-control" placeholder="Enter the category"><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="desc'+cnt+'" name="desc'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td><td class="center"><input type="number" name="quantity'+cnt+'" class="number form-control" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'"> -- </td><td class="center"><div class="padding20"> <label class="radio" id="radio'+rad+'"><input type="radio" checked name="pricetype'+cnt+'" value="0" id="optionsRadios'+rad+'"  onclick="check_total(this)"> <input type="number"  style="width:80px" value="0" step="any" class="form-control" min="0" name="sellingprice'+cnt+'" id="sellingprice'+cnt+'"></label><br><label class="radio" id="radio'+(rad+1)+'"><input type="radio" name="pricetype'+cnt+'" value="1" id="optionsRadios'+(rad+1)+'"  onclick="check_free(this)"> Free of Charge </label></div></td><td class="center" id="total'+cnt+'"> -- </td><input type="hidden" name="new'+cnt+'" value="1"/></tr>';

      $("#new"+cnt).val(1);

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



			$("#product_choice"+cnt).change(function(event){

				 var cnt = $("#cnt").val();

				var ids = event.target.id.split('_');

				var id = ids[1].split('choice');

				if ($("#product_choice"+id[1]).val() != -1 && $("#product_choice"+id[1]).val() != -2)

				{



					var tmp = $("#product_choice"+id[1]).val().split(";");

					$("#unitprice"+id[1]).html(selling_price[tmp[0]]);

          $("#up"+id[1]).val(selling_price[tmp[0]]);

					$("#sellingprice"+id[1]).attr("min",unit_price[tmp[0]]);

					$("#sellingprice"+id[1]).val(selling_price[tmp[0]]);

					$("#total"+id[1]).html(selling_price[tmp[0]]);

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

					$("#row"+id[1]).find("input,button,textarea").prop("readonly", "true");

					$("#free"+id[1]).removeAttr('readonly');

				}

				else

				{

					$("#free"+id[1]).hide();

					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");

					$("#unitprice"+id[1]).html("---");

					$("#sellingprice"+id[1]).val("0");

					$("#description"+id[1]).html("---");

				}

			});

			$("#quantity"+cnt).change(function(event){

				var id = event.target.id.split('quantity');

				var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();

			});

			$("#sellingprice"+cnt).change(function(event){

				var id = event.target.id.split('sellingprice');

				var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();

			});

			template_functions();

			$("#product_choice"+cnt).chosen();



			cnt++;

		}

	});



	$("#editInvoice").submit(function(e){

		 var cnt = $("#cnt").val();

		var total = 0;

		for (var n = 0; n < cnt; n++)

		{

			var up = $("#unitprice"+n).html().split('$');

			$("#up"+n).val(up[1]);

			$("#d"+n).val($("#description"+n).html());

			$("#pn"+n).val($("#product_choice"+n+" option:selected").text());

			if ($("#product_choice"+n).val() != -1 && $("#product_choice"+n).val() != -2)

			{

				total += parseFloat($("#quantity"+n).val()) * parseFloat($("#sellingprice"+n).val());
        //total += parseInt($("#service_content").val());
			}

		}

    if ($("#service_content").val() != "") {
        total += parseInt($("#service_content").val());
    }

    total = parseFloat(total).toFixed(2);

		
    $("#total_price_inv").val(total);

    // $("#tp").val(total);

    var gstopt_val = $('input[name="gstopt"]:checked').val();
    if (gstopt_val == 'gstyes') {      
      var gstval = $("#gstval").html();
      $("#get_gstval").val(gstval); 
    }else{
      var gst = 0;
      gstval = parseFloat(gst).toFixed(2);
      $("#get_gstval").val(gstval); 
    }

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

    if($( ".delbox:checked" ).length > 0){  

		 var cnt = $("#cnt").val();

		Boxy.confirm("Are you sure?", function() {

			for (var n = 0; n < cnt; n++)

			{

        var id = $("#invoice_id_list").val();
        if ($("#delete"+n).is(":checked"))

        {

          $("#product_choice"+n).val(-1);
          id += $("#delete"+n).val() + ", ";
          $("#invoice_id_list").val(id);

				$("#quantity"+n).val(0);

        var tt = $("#cnt").val() - 1;

        $("#cnt").val(tt);


				//$("#row"+n).fadeOut('fast');

          $("#row"+n).remove();

          calculateTotal();

				}

			}


    //calculateTotal();

    }, {title: 'Confirm'});

		return false;
    }else{
      alert("Please check the box that you want to delete!");
    } 



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

$('.fancybox1').fancybox({

    href : "{{ URL::to ('middlemen/fancycreate') }}",

    type : 'iframe',

    width: 900,

    height: 800,

    'autoScale' : false,

    beforeClose: function(){

      // working

      var $iframe = $('.fancybox-iframe');

      var tmp = $('input', $iframe.contents()).val();

      tmp = tmp.split(";");

      $("#selectError1").append($("<option></option>")

               .attr("value",tmp[0])

               .text(tmp[1]));

               $("#selectError1").trigger("liszt:updated");



      $("#selectError1").val(tmp[0]).trigger("chosen:updated");

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

$("#service_yes").click(function(){
  $("#service_content_wrapper").fadeIn('300');
});

$("#service_no").click(function(){
  $("#service_content_wrapper").fadeOut('300');
  $("#service_content").val("");
  calServiceTotal();
});

$("#save").click(function(){
  var selected = $("#service_yes").is(":checked");

  if (selected == true) {
    $("#service_content").prop('required',true);
  }else{

  }

});
function number_only($this){
  var numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  var value = $($this).val();
  var total = value.length;
  var ans = numbers.indexOf(value.slice(total-1, total));
  if(ans=="-1"){
    $($this).val(value.slice(0, total-1));
  }
}

/* For GST option choosing */
  $("#gstyes").click(function() {
    $("#gst_wrapper").fadeIn('300');
    calculateTotal();
  });

  $("#no_gst").click(function() {
    $("#gst_wrapper").fadeOut('300');
    calculateTotal();
  });

  $("#gst_already").click(function() {
    $("#gst_wrapper").fadeOut('300');
    calculateTotal();
  });

</script>



@stop