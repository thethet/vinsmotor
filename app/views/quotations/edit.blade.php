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

                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Edit quotation</h2></div>

            </div>

            <div class="box-content">

            @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif


		{{ Form::open(array('action' => 'QuotationsController@save_edit','method'=>'post','id'=>'createQuotation')) }}

                    <fieldset>

			<div class="form-group row">

			    <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Quotation No. </strong></span></div>

			    <div class="col-md-3"> <input type="text"  name="quote_no" readonly value="{{ $quotations->quote_no }}" class="form-control">

				<input type="hidden" name="quotation_id" readonly value="{{ $quotations->id }}">

				</div>

			    </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Client</strong></span></div>

                          <div class="col-md-3"><select name="client" required id="selectError" data-rel="chosen" class="form-control">

                          	<option value="-1">Cash and Carry</option>

                             @foreach($clients as $key => $value)

                                <option @if ($quotations->client_id == $value->id) selected @endif  value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>

                              @endforeach

                          </select>

                          </div>

                      </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Sales Staff</strong></span></div>

			  <div class="col-md-3">

                          <select name="sales_staff" required data-rel="chosen2" class="form-control">

                             @foreach($staffs as $key => $value)

                                <option @if ($quotations->sales_staff == $value->id) selected @endif value="{{ $value->id }}">{{ $value->name." - ".$value->contact }}</option>

                              @endforeach

                          </select>

			  </div>

                      </div>

                      <div class="clear"></div>

                       <div class="form-group row">

                       	   <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Company</strong></span></div>

			   <div class="col-md-3">

                          <select name="middlemen" data-rel="chosen3" id="selectError1" class="form-control">

                              @foreach($middlemen as $key => $value)

                                <option @if ($quotations->middleman == $value->id) selected @endif value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>

                              @endforeach

                          </select>

			   </div>

                      </div>

						<div class="form-group row">
                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service</strong></span></div>
                          <div class="col-md-3">
                            <div class="col-md-2" style="margin-left:10px;"><input type="radio" name="service" id="service_yes" value="yes" <?php if($quotations->service_content){echo 'checked="checked"';}?> />Yes</div>
                            <div class="col-md-2"><input type="radio" name="service" id="service_no" value="no" <?php if(empty($quotations->service_content)){echo 'checked="checked"';}?> />No</div>
                        </div>
                      </div>

                      <div class="form-group row" id="service_content_wrapper" <?php if($quotations->service_content){echo 'style="display:block;"';}else{echo 'style="display:none;"';} ?>>
                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service Content</strong></span></div>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name='service_content' id="service_content" value="{{$quotations->service_content}}" />
                        </div>
                      </div>

                      <div class="clear"></div>

                      <div class="form-group row" style="display:none;">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Payment Mode</strong></span></div>

                          <div class="col-md-3"><input type="text" value="{{ $quotations->payment_mode }}" placeholder="Enter Payment Mode" name="payment_mode" class="form-control"></div>

                      </div>



                      <div class="right"><div class="line20 pull-left">Add</div><div class="col-md-1 pull-left"> <input type="number" class="number form-control" value="1" id="addvalue" min="0"></div> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+">  <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>

                      <table class="table table-bordered table-striped">

                          <thead>

                              <tr>

                          		  <th style="width:5%"><input type="checkbox" id="alldelete"></th>

                                  <th style="width:30%">Product</th>

                                <!--  <th style="width:10%">Measurements</th>-->

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

                                    <!-- <option @if ($value->product_id == -1) selected @endif value="-2">Enter a category</option> -->

                                      @foreach($products as $key => $v)

                                        <option @if ($value->product_id == $v->id) selected @endif  value="{{ $v->id.";".$v->product_name }}">{{ $v->id." - ".$v->product_name }}</option>

                                      @endforeach

                                  </select>
                                  </div>


                          		<td><input type="checkbox" class="delbox" id="delete{{ $cnt }}"></td>



                                <td>

                                 <select name="product_choice{{ $cnt }}" id="product_choice{{ $cnt }}" required data-rel="chosen" class="po_selectbox">

                                 	<option value="-1">----</option>

                                    <!-- <option @if ($value->product_id == -1) selected @endif value="-2">Enter a category</option> -->

                                      @foreach($products as $key => $v)

                                        <option @if ($value->product_id == $v->id) selected @endif  value="{{ $v->id.";".$v->product_name }}">{{ $v->id." - ".$v->product_name }}</option>

                                      @endforeach

                                  </select>

                                  <input type="text" class="form-control" name="free{{ $cnt }}" id="free{{ $cnt }}" @if ($value->product_id != -1) style="display:none;" @else value="{{ $value->product_name}} " @endif  class="none" placeholder="Enter the category">

                                  <input type="hidden" name="desc{{ $cnt }}"  value="{{ $value->description }}" id="desc{{ $cnt }}">

                                  <input type="hidden" name="unitprice{{ $cnt }}" value="{{ $value->unit_price }}" id="up{{ $cnt }}">

                                  <input type="hidden" name="hid{{ $cnt }}" value="{{ $value->id }}">

                                  <input type="hidden" name="new{{ $cnt }}" value="0"/>

                                </td>

                              <!--  <td class="center" id="description{{ $cnt }}"> {{ $value->description }} </td>-->

                                <td class="center"><input type="number" name="quantity{{ $cnt }}" value="{{ $value->quantity }}" class="number form-control" value="1" id="quantity{{ $cnt }}"></td>

                                <td class="center" id="unitprice{{ $cnt }}">$ {{ $value->unit_price }} </td>

                                <td class="center">

				    <div class="padding20">

                               	 <label class="radio" id="radio3"><input type="radio" @if ($value->status == 0) checked @endif name="pricetype{{ $cnt }}" value="0" id="optionsRadios{{ $cnt }}"   class="check_total"> <input type="number" style="width:80px" value = "{{ $value->selling_price}}" step="any" min="0" name="sellingprice{{ $cnt }}" id="sellingprice{{ $cnt }}" class="form-control"></label><br>

                                 <label class="radio" id="radio4"><input type="radio" @if ($value->status == 1) checked @endif name="pricetype{{ $cnt }}" value="1" id="optionsRadios{{ $cnt }}"  class="check_free"> Free of Charge </label>

				    </div>

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

                                <?php
                                //$total_amount += $total + $quotations->service_content; 
                                $total_amount += $total; 
                                ?>


                            </tr>

                            <?php $cnt++; ?>

                            @endforeach

                            <?php
                                $total_amount += $quotations->service_content; 
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
                        <input type="radio" name="gstopt" id="no_gst" value="no_gst" <?php if($quotations->gst_status == 'no_gst' )echo 'checked';?>> No GST<br>
                        <input type="radio" name="gstopt" id="gst_already" value="gst_already" <?php if($quotations->gst_status == 'gst_already' )echo 'checked';?>> GST already included<br>
                        <input type="radio" name="gstopt" id="gstyes" value="gstyes" <?php if($quotations->gst_status == 'gstyes' )echo 'checked';?>> GST 7%
                      </td>
                    </tr>

                     <?php                           
                          $chkgst = $quotations->gst;
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

                          echo $quotations->gst;
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

                          $chkgst = $quotations->gst;
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

                          <input type="number" min="0" class="form-control" step="any" style="width:80px;margin-top:-5px;" name="deposit" id="deposit" placeholder="0" value="{{ $quotations->total_paid }}">



                        </td>

                     </tr>

                     <tr>

                        <td style="width:85%;text-align:right">

                        	<strong>Balance</strong>

                        </td>

                        <td style="width:15%;" id="balance">

                          <?php
                              echo sprintf ("%.2f", $total - $quotations->total_paid);
                          ?>

                        </td>

                     </tr>

                     </table>

                     <div class="form-group row">

			 <div class="col-md-1"><strong>Remarks</strong></div>

			 <div class="col-md-10"> <textarea class="cleditor form-control" name="remarks" id="textarea2" rows="3">{{ $quotations->remarks}}</textarea></div>

		     </div>



                      <div class="form-group text-center">

                        <div class="col-md-4 col-md-offset-4"><button type="submit" class="btn btn-primary quo_btn">Update</button>

                        <a href="{{ URL::to('quotations') }}"><input type="button" value="Cancel" class="btn"></a>

			</div>

                      </div>

                    </fieldset>

                    <input type="hidden" name="edit_quo" value="1"/>

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



function calculateTotal(){
  var cnt = $("#cnt").val();
	var ttl = 0;
  var s_amount = $("#service_content").val();

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

  if (s_amount == '') {
      //$("#totalamount").html(ttl);
      //ttl = parseInt($("#totalamount").html());
      ttl = ttl;
    }else{
      ttl = ttl + parseInt(s_amount);
    }

    ttl = parseFloat(ttl).toFixed(2);

  $("#totalamount").html(ttl);


  var total1 = parseFloat(ttl) + parseFloat(gst);

  $("#total").html((total1));

  $("#tp").val(total1);

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



   $("#"+valtr+" #"+tot).html(get_tot);

   calculateTotal();

}

$(document).ready(function(){
  $("#service_content").on("input", function(){
   number_only(this);
  });

  $('body').on('keyup', '#service_content', function(e){

    //var service_amount = document.getElementById("service_content").value;

    calServiceTotal();

  });

});

//var cnt2 = $("#cnt").val();

function calServiceTotal(){

  var cnt = $("#cnt").val();

  var ttl = 0;
  var s_amount = $("#service_content").val();

  for (var n2 = 0; n2 < cnt; n2++)

  {

    if ($("#product_choice"+n2).val() != -1)

    {

      var k = $('input[name="pricetype'+n2+'"]:checked').val();

      var sellprice = $("#sellingprice"+n2).val();

      if(k == 0){

        ttl = ttl + (sellprice * $("#quantity"+n2).val());

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

    //ttl = parseInt($("#totalamount").html()) + parseInt(s_amount);

    if (s_amount == '') {
      //$("#totalamount").html(ttl);
      //ttl = parseInt($("#totalamount").html());
      ttl = ttl;
    }else{
      ttl = ttl + parseInt(s_amount);
    }

    ttl = parseFloat(ttl).toFixed(2);

  $("#totalamount").html(ttl);

  //var total = parseFloat(ttl) + parseFloat(gst) + parse($("#total").val());
  var total = parseFloat(ttl) + parseFloat(gst);

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

}//end fun



function calGSTTotal(){

  var cnt = $("#cnt").val();

  var ttl = 0;
  var s_amount = $("#service_content").val();

  for (var n2 = 0; n2 < cnt; n2++)

  {

    if ($("#product_choice"+n2).val() != -1)

    {

      var k = $('input[name="pricetype'+n2+'"]:checked').val();

      var sellprice = $("#sellingprice"+n2).val();

      if(k == 0){

        ttl = ttl + (sellprice * $("#quantity"+n2).val());

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


  var deposit = $("#deposit").val();

    //ttl = parseInt($("#totalamount").html()) + parseInt(s_amount);

    if (s_amount == '') {
      //$("#totalamount").html(ttl);
      //ttl = parseInt($("#totalamount").html());
      ttl = ttl;
    }else{
      ttl = ttl + parseInt(s_amount);
    }

    ttl = parseFloat(ttl).toFixed(2);

  $("#totalamount").html(ttl);

  $("#gstval").html(gst);
  $("#get_gstval").val(gst);

  //var total = parseFloat(ttl) + parseFloat(gst) + parse($("#total").val());

  var total = parseFloat(ttl) + parseFloat(gst);

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

}//end fun



function number_only($this){
  var numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  var value = $($this).val();
  var total = value.length;
  var ans = numbers.indexOf(value.slice(total-1, total));
  if(ans=="-1"){
    $($this).val(value.slice(0, total-1));
  }
}



function check_free(c){

   var  sid = c.id;

   var sproid = c.value;

   var valtr = $("#"+sid).closest('tr').attr('id');

   var thenum = valtr.replace(/\D/g,'');

   if(thenum == 0){

      var tot = "total0";

   }

   else{

    var tot = "total"+thenum;

   }

   var get_tot = 0;

   get_tot = parseFloat(get_tot).toFixed(2);



   $("#"+valtr+" #"+tot).html(get_tot);

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

     var get_tot = 0;

     get_tot = parseFloat(get_tot).toFixed(2);



     $("#"+valtr+" #"+tot).html(get_tot);

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

				$("#unitprice"+id[1]).html(unit_price[tmp[0]]);

				$("#sellingprice"+id[1]).attr("min",unit_price[tmp[0]]);

				$("#sellingprice"+id[1]).val(selling_price[tmp[0]]);

				$("#total"+id[1]).html(selling_price[tmp[0]]);



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

          calculateTotal();

			}

			else if ($("#product_choice"+id[1]).val() == -2)

			{

				$("#free"+id[1]).show();

				$("#row"+id[1]).find("input,button,textarea").prop("readonly","true");

				$("#free"+id[1]).removeAttr('disabled');

        calculateTotal();

			}

			else

			{

				$("#free"+id[1]).hide();

				$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");

				$("#unitprice"+id[1]).html("---");

				$("#sellingprice"+id[1]).val("0");

				$("#description"+id[1]).html("---");

        calculateTotal();

			}

       calculateTotal();

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

			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen" class="po_selectbox"></select><input type="text" name="free'+cnt+'" id="free'+cnt+'" style="display:none;" class="none form-control" placeholder="Enter the category"><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="desc'+cnt+'" name="desc'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td><td class="center"><input type="number" name="quantity'+cnt+'" class="number form-control" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'"> -- </td><td class="center"> <div class="padding20"><label class="radio" id="radio'+rad+'"><input type="radio" checked name="pricetype'+cnt+'" value="0" id="optionsRadios'+rad+'"  onclick="check_total(this)"> <input type="number"  class="form-control" style="width:80px" value="0" step="any" min="0" name="sellingprice'+cnt+'" id="sellingprice'+cnt+'"></label><br><label class="radio" id="radio'+(rad+1)+'"><input type="radio" name="pricetype'+cnt+'" value="1" id="optionsRadios'+(rad+1)+'"  onclick="check_free(this)"> Free of Charge </label></td><td class="center" id="total'+cnt+'"> -- </div></td><input type="hidden" name="new'+cnt+'" value="1"/></tr>';

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

					$("#unitprice"+id[1]).html(unit_price[tmp[0]]);
          $("#up"+id[1]).val(unit_price[tmp[0]]);

					$("#sellingprice"+id[1]).attr("min",unit_price[tmp[0]]);

					$("#sellingprice"+id[1]).val(selling_price[tmp[0]]);

					$("#total"+id[1]).html(selling_price[tmp[0]]);

							calculateTotal();

					$("#free"+id[1]).hide();

					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");

					var msr = desc[tmp[0]].split(';');

          calculateTotal();

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

          calculateTotal();

				}

				else

				{

					$("#free"+id[1]).hide();

					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");

					$("#unitprice"+id[1]).html("$---");

					$("#sellingprice"+id[1]).val("0");

					$("#description"+id[1]).html("---");

          calculateTotal();

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

		}

     calculateTotal();

	});



	$("#createQuotation").submit(function(e){

    var cnt = $("#cnt").val();

		var total = 0;

		for (var n = 0; n < cnt; n++)

		{

			var up = $("#unitprice"+n).html().split('$');

			$("#up"+n).val(up[1]);

			$("#d"+n).val($("#description"+n).html());

			$("#pn"+n).val($("#product_choice"+n+" option:selected").text());
      if ($("#product_choice"+n).val() != -1 || $("#product_choice"+n).val() != -2)

      {
				total += parseFloat($("#quantity"+n).val()) * parseFloat($("#sellingprice"+n).val());
        
			}      

		}

    if ($("#service_content").val() != "") {
        total += parseInt($("#service_content").val());
    }

    total = parseFloat(total).toFixed(2);
    
		 $("#tp").val(total);

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

		Boxy.confirm("Are you sure?", function(){

  		for (var n = 0; n < cnt; n++)

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

    'autoScale'     :   false,

    beforeClose: function() {

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