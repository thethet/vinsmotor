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

                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> New quotation</h2></div>

            </div>

            <div class="box-content">

            @if (Session::has('message'))
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
            @endif

		    {{ Form::open(array('url' => 'quotations/create','method'=>'post','id'=>'createQuotation')) }}

                    <fieldset>

			            <div class="form-group row">

			            <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Quotation No. </strong></span></div>


                  @if(Session::has('aldid'))

                  <div class="col-md-3"><input type="text" readonly value="" name="quote_no"  class="form-control" id="quote_no"></div>


                     <button type="button" class="btn btn-primary" id="generate_qno">Generate Quotation No.</button>
                     <?php
                      $latestid = DB::table('quotations')->orderBy('id', 'desc')->first()->id;

                      $latestid += 1;
                      $aid = "QU";
                       for ($n = 0; $n < (5 - strlen($latestid)); $n++)
                       {
                         $aid .= "0";
                       }
                       $aid .= $latestid;

                       $generate_qno = $aid;

                     ?>
                     <input type="hidden" value="{{$generate_qno}}" id="generate_qno_val" />
                  
                  @else

                  <div class="col-md-3"><input type="text" readonly value="{{ $aid }}" name="quote_no"  class="form-control" id="quote_no"></div>

                  @endif

                  </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Client</strong></span></div>

			  <div class="col-md-3">

                          <select name="client" required id="selectError" data-rel="chosen" class="form-control">

                          	<option value="-1">Cash and Carry</option>

                             @foreach($clients as $key => $value)

                                <option value="{{ $value->id }}">{{ $value->first_name." ".$value->last_name." - ".$value->mobile_contact }}</option>

                              @endforeach

                          </select>

                          </div>

                      </div>

                      <div class="form-group row">

                       	  <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Sales Staff</strong></span></div>

                          <div class="col-md-3"><select name="sales_staff" required data-rel="chosen2" class="form-control">

                             @foreach($staffs as $key => $value)

                                <option value="{{ $value->id }}">{{ $value->name." - ".$value->contact }}</option>

                              @endforeach

                          </select>

			  </div>

                      </div>

                      <div class="clear"></div>

                      <div class="form-group row">
			                    <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Company</strong></span></div>
                          <div class="col-md-3"><select name="middlemen" data-rel="chosen3" id="selectError1" class="form-control">
                           <option value="-1">----</option>
                             @foreach($middlemen as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->first_name }}</option>
                              @endforeach
                          </select>
			                  </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service</strong></span></div>
                          <div class="col-md-3">
                            <div class="col-md-2" style="margin-left:10px;"><input type="radio"  name="service" id="service_yes" value="yes" />Yes</div>
                            <div class="col-md-2"><input type="radio" name="service" id="service_no" value="no" checked="checked" />No</div>
                        </div>
                      </div>

                      <div class="form-group row" id="service_content_wrapper" style="display:none;">
                          <div class="col-md-1"><span style="padding-bottom:5px;"><strong>Service Content</strong></span></div>
                          <div class="col-md-3">
                            <input type="text" class="form-control" name='service_content' id="service_content" />
                        </div>
                      </div>

                      <div class="clear"></div>

                      <div class="right"><div class="pull-left lineh30">Add</div><div class="col-md-1 pull-left"><input type="number" class="number form-control" value="1" id="addvalue" min="0"></div> Products <input type="button" id="addproduct" class="btn btn-warning squarebutton" value="+">  <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>

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

                                    <!-- <option value="-2">Enter a category</option> -->

                                     @foreach($products as $key => $value)

                                        <option value="{{ $value->id.";".$value->product_name }}">{{ $value->product_itemno." - ".$value->product_name }}</option>

                                      @endforeach

                                  </select>

                                  <input type="text" name="free0" id="free0" style="display:none;" class="none form-control" placeholder="Enter the category">

                                  <input type="hidden" name="desc0" id="desc0">

                                  <input type="hidden" name="unitprice0" id="up0">

                                  <input type="hidden" name="cnt" id="cnt">

                                  <input type="hidden" name="total_price" id="tp">

                                </td>



                               <!-- <td class="center" id="description0"> --- </td>-->

                                <td class="center"><input type="number" name="quantity0" class="number form-control" value="1" id="quantity0"></td>

                                <td class="center" id="unitprice0">-- </td>

                                <td class="center">

				    <div class="padding20">

                               	 <label class="radio" id="radio3"><input type="radio" checked name="pricetype0" value="0" id="optionsRadios3" onclick="check_total(this)"> <input type="number" style="width:80px" value="0" step="any" min="0" name="sellingprice0" id="sellingprice0" class="form-control"></label><br>

                                 <label class="radio" id="radio4"><input type="radio" name="pricetype0" value="1" id="optionsRadios0"  onclick="check_free(this)"> Free of Charge </label>				</div>

                                </td>

                                <td class="center" id="total0">-- </td>

                            </tr>





                          </tbody>



                     </table>

                     <table class="table table-bordered">

                     <tr>

                     	<td style="width:85%;text-align:right">

                        	<strong>Total Amount</strong>

                        </td>

                        <td style="width:15%;" id="totalamount">

                       		 0

                        </td>

                     </tr>

                     <tr>
                      <td style="width:85%;text-align:right;">
                        <strong>GST</strong>
                      </td>
                      <td style="width:15%;padding-left:30px;padding-top:0px;">
                        <input type="radio" name="gstopt" id="no_gst" value="no_gst" checked> No GST<br>
                        <input type="radio" name="gstopt" id="gst_already" value="gst_already"> GST already included<br>
                        <input type="radio" name="gstopt" id="gstyes" value="gstyes"> GST 7%
                      </td>
                    </tr>

                     <tr id="gst_wrapper" style="display:none;">

                     	<td style="width:85%;text-align:right">

                        	<strong>7% GST</strong>

                        </td>

                        <td style="width:15%;" id="gstval">

                       		 0

                        </td>
                        <input type="hidden" name="get_gstval" id="get_gstval">

                     </tr>

                     <tr>

                     	<td style="width:85%;text-align:right">

                        	<strong>Total</strong>

                        </td>

                        <td style="width:15%;" id="total">

                       		 0

                        </td>

                     </tr>

                     <tr>

                        <td style="width:85%;text-align:right">

                        	<strong>Deposit</strong>

                        </td>

                        <td style="width:15%;">

                        	<input type="number" min="0" step="any" style="width:80px;margin-top:-5px;" name="deposit" id="deposit" placeholder="0" class="form-control" value="0">

                        </td>

                     </tr>

                     <tr>

                        <td style="width:85%;text-align:right">

                        	<strong>Balance</strong>

                        </td>

                        <td style="width:15%;" id="balance">

                        	0

                        </td>

                     </tr>

                     </table>

		      <div class="form-group row">

			  <div class="col-md-1"><strong>Remarks</strong></div>

			  <div class="col-md-10"><textarea class="cleditor" name="remarks" id="textarea2" rows="3"></textarea></div>

		      </div>

                      <div class="form-group row">

                         <div class="col-md-12 text-center"><button type="submit" class="btn btn-primary quo_btn" id="save">Save</button>



                        <a href="{{ URL::to('quotations') }}"><input type="button" value="Cancel" class="btn"></a>

			 </div>

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

			var k = $('input[name="pricetype'+n+'"]:checked').val();

			var sellprice = $("#sellingprice"+n).val();

			if(k == 0){

				ttl = ttl + (sellprice * $("#quantity"+n).val());

			}

		}

	}

  $("#totalamount").html(ttl);

	var gstopt_val = $('input[name="gstopt"]:checked').val();
  if (gstopt_val == 'gstyes') {
    var gst = ttl * 0.07;
    gst = parseFloat(gst).toFixed(2);
  }else{
    var gst = 0;
    gst = parseFloat(gst).toFixed(2);
  }

	var deposit = $("#deposit").val();

  var s_amount = $("#service_content").val();


	if (s_amount == '') {
    //$("#totalamount").html(ttl);
    //alert('null');
    ttl = ttl;
  }else{
    //$("#totalamount").html(ttl+parseInt(s_amount));
    ttl = ttl + parseInt(s_amount);
  }


  $("#totalamount").html(ttl);

	$("#gstval").html(gst);

  $("#get_gstval").val(gst);


    $("#tp").val(ttl);

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


$(document).ready(function(){
  $("#service_content").on("input", function(){
   number_only(this);
  });

  $('body').on('keyup', '#service_content', function(e){

    //var service_amount = document.getElementById("service_content").value;

    //calServiceTotal();

    calculateTotal();

  });

});

var cnt2 = 3;

function calServiceTotal(){

  var ttl = 0;
  var s_amount = $("#service_content").val();

  for (var n2 = 0; n2 < cnt2; n2++)

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


/* For GST calculation */
var cnt2 = 3;

function calGSTTotal(){

  var ttl = 0;
  var s_amount = $("#service_content").val();

  for (var n2 = 0; n2 < cnt2; n2++)

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
      ttl = ttl;
    }else{
      ttl = ttl + parseInt(s_amount);
    }

    ttl = parseFloat(ttl).toFixed(2);

  $("#totalamount").html(ttl);

  $("#gstval").html(gst);

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



$(document).ready(function($){

	var unit_price = <?php echo json_encode($unit_price); ?>;

	var selling_price = <?php echo json_encode($selling_price); ?>;

	var desc = <?php echo json_encode($measurements); ?>;

	var template = $("#producttable").html();

	$('[data-rel="chosen2"],[rel="chosen2"]').chosen();

	$('[data-rel="chosen3"],[rel="chosen3"]').chosen();

	$("#optionsRadios0").click(function(){

		//$("#sellingprice0").val(0);

		$("#total0").html("---");

		calculateTotal();

	});



	$("#product_choice0").change(function(){

		if ($("#product_choice0").val() != -1 && $("#product_choice0").val() != -2)

		{

			var tmp = $("#product_choice0").val().split(";");

			$("#unitprice0").html(selling_price[tmp[0]]);

      $("#up0").val(selling_price[tmp[0]]);

			$("#sellingprice0").attr("min",unit_price[tmp[0]]);

			$("#sellingprice0").val(selling_price[tmp[0]]);

			$("#total0").html(selling_price[tmp[0]]);

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

			//$("#sellingprice0").val("0");

		}

	});

	$("#quantity0").change(function(){

		var amt = $("#quantity0").val() * $("#sellingprice0").val();

		$("#total0").html(amt);

			calculateTotal();

	});

	$("#sellingprice0").change(function(){

		var amt = $("#quantity0").val() * $("#sellingprice0").val();

		$("#total0").html(amt);

		calculateTotal();

	});

	$("#deposit").change(function(){

		calculateTotal();

	});

	var rad = 5;

	$("#addproduct").click(function(){



		for (var n = 0; n < $("#addvalue").val(); n++)

		{

			//var option = $("#product_choice0 > option").clone();

      var option = $("#product_choice_ori > option").clone();

			var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><select name="product_choice'+cnt+'"  id="product_choice'+cnt+'" required data-rel="chosen" class="po_selectbox"></select><input type="text" name="free'+cnt+'" id="free'+cnt+'" style="display:none;" class="none" placeholder="Enter the category"><input type="hidden" id="pn'+cnt+'" name="product_name'+cnt+'"><input type="hidden" id="desc'+cnt+'" name="desc'+cnt+'"><input type="hidden" id="up'+cnt+'" name="unitprice'+cnt+'"></td> <td class="center"><input type="number" name="quantity'+cnt+'" class="number form-control" value="1" id="quantity'+cnt+'"></td><td class="center" id="unitprice'+cnt+'">-- </td><td class="center"><div class="padding20"> <label class="radio" id="radio'+rad+'"><input type="radio" checked name="pricetype'+cnt+'" value="0" id="optionsRadios'+rad+'" onclick="check_total(this)"> <input type="number" class="form-control" style="width:80px" value="0" step="any" min="0" name="sellingprice'+cnt+'" id="sellingprice'+cnt+'"></label><br><label class="radio" id="radio'+(rad+1)+'"><input type="radio" name="pricetype'+cnt+'" value="1" id="optionsRadios'+cnt+'" onclick="check_free(this)" > Free of Charge </label></div></td><td class="center" id="total'+cnt+'">-- </td></tr>';

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

					$("#row"+id[1]).find("input,button,textarea").prop("readonly","true");

					$("#free"+id[1]).removeAttr('readonly');

				}

				else

				{

					$("#free"+id[1]).hide();

					$("#row"+id[1]).find("input,button,textarea").removeAttr("readonly");

					$("#unitprice"+id[1]).html("$---");

					//$("#sellingprice"+id[1]).val("0");

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

				//var id = event.target.id.split('sellingprice');

				var getid= $(this).attr('id');

				var id = getid.replace(/\D/g,'');

				var amt = $("#quantity"+id[1]).val() * $("#sellingprice"+id[1]).val();

				$("#total"+id[1]).html(amt);

				calculateTotal();

			});

			template_functions();

			$("#product_choice"+cnt).chosen();



			$("#optionsRadios"+cnt).click(function(){

				var getid= $(this).attr('id');

				var id = getid.replace(/\D/g,'');

				//$("#sellingprice"+id).val(0);

				$("#total"+id).html("---");

				calculateTotal();

			});

			cnt++;

		}

	});



	$("#createQuotation").submit(function(e){

    var check_company = $( "#selectError1" ).val();
    if(check_company == -1){
      e.preventDefault();
      alert("Please select the company.");
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


		$("#cnt").val(cnt);

		var total = 0;

		for (var n = 0; n <= cnt; n++)

		{

			var up = $("#unitprice"+n).html().split('$');

			$("#up"+n).val(up[1]);

			$("#d"+n).val($("#description"+n).html());

			$("#pn"+n).val($("#product_choice"+n+" option:selected").text());

			total += parseFloat($("#quantity"+n).val()) * parseFloat($("#sellingprice"+n).val());
      //total += parseInt($("#service_content").val());

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

	//$.uniform.update(".optionsRadios3");

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
  //calServiceTotal();
  calculateTotal();
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


  /************************************/
  $("#generate_qno").click(function(){
      var qno = $("#generate_qno_val").val();
      $("#quote_no").val(qno);
  });


</script>
@stop