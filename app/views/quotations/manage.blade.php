@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
	     <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Manage quotation</h2></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('quotations/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
                  </div>
               </div>
            </div>
            <div class="box-content">

              <div style="background:#fff;font-size:13px;color:red;padding:10px;">
                <?php 
                /*$filter_pro = Session::get('filter_pro');$required_qty = Session::get('required_qty'); if(count($filter_pro) > 0){

                        for ($i=0; $i < count($filter_pro) ; $i++) {
                              $get_pro = ProductEntry::where('id','=',$filter_pro[$i])->first();
                              echo "Required product list<br/>";
                              echo "<table border='1' cellpadding='0' cellspacing='1'><tr><td>Product Name</td><td>Product Item No.</td><td>Required Qty</td></tr>";
                              echo "<tr><td>".$get_pro->product_name; echo "</td><td>"; echo $get_pro->product_itemno; echo "</td><td>"; echo $required_qty[$i][1]; echo "</td></tr>";
                              echo "</table>";
                        }

                    } */
                ?>
                </div>
                <div style="background:#fff;font-size:13px;color:red;padding:10px;">
                  <?php
                  /*$keep_pro = Session::get('keep_pro');
                  if(count($keep_pro) > 0){
                    print_r($keep_pro);
                  }*/
                  ?>
                </div>
		<div class="table-responsive">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="ten">Quotation No.</th>
                          <th class="fifteen">Client name</th>
                          <th class="ten">Invoice</th>
                          <th class="fifteen">Date issued</th>
                          <th class="ten">Total Price</th>
                          <th class="ten">Product Status</th>
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php $i = 0;
                     ?>
                    @foreach($quotations as $key => $value)
              <tr>
                        <td>
                        <?php
            /*$id = "QU";
             for ($n = 0; $n < (5 - strlen($value->id)); $n++)
             {
               $id .= "0";
             }
             $id .= $value->id;
             echo $id;*/
             echo $value->quote_no;
						?>
            </td>
            <td><?php
						if ($value->client_id != -1)
						{
						$username = DB::table('clients')->where('id','=',$value->client_id)->count();
            if ($username > 0)
            {
            	$first_name = DB::table('clients')->where('id','=',$value->client_id)->pluck('first_name');
            	$last_name = DB::table('clients')->where('id','=',$value->client_id)->pluck('last_name');
            echo $first_name." ".$last_name;
            }
            else
            echo "---";
						}
						else
							echo "Cash and Carry";
						?></td>
            <td class="center">
            <?php
  						if ($value->invoice > 0)
              {
  							$pid = "INV";
  							 for ($n = 0; $n < (5 - strlen($value->invoice)); $n++)
  							 {
  								 $pid .= "0";
  							 }
  							 $pid .= $value->invoice;
  							?>
  							<a href="{{ URL::to ('invoices/view/'.$value->invoice) }}">
  								<?php echo $pid; ?>

  							</a><br/>
  							 <?php
						}
						else
						{

							?>
              {{ Form::open(array('action' => 'InvoicesController@pass_form','method'=>'put')) }}
                {{Form::hidden('quotation_id',$value->id) }}
                <input type="submit" class="anchorlink" value="+ Create">
              {{ Form::close() }}
            <?php
						}
						?>
            </td>
            <td class="center"><?php echo "<span class='invis'>".date('YmdHis',strtotime($value->date_created))."</span> ".date('d-m-Y H:i:s',strtotime($value->date_created)); ?></td>
            <td class="center">
            <?php
              $all_total_price = $value->total_price + $value->gst;

              echo '$'.$all_total_price;
            ?>
            
            </td>
            <td>
              <?php

                 $get_q_pro_qty = 0;$get_total_pro_qty = 0;$pname_list = ''; $product_status = "";

                 $get_quoitem = DB::table('quotation_items')->where('quotation_id','=',$value->id)->get();
                 $get_qty_status = 0;                 

                 foreach ($get_quoitem as $key => $value1) {
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
              <!-- @if($get_qty_status == 1) 
                {{ 'product is required'}}  
              @else 
                @if($value->status == 1) 
                  {{ 'This quo is confirmed' }} 
                @else 
                  {{ 'product status is okay'}} 
                @endif 
              @endif -->



             <!--  @if($value->status == 1) 
                  {{ 'This quo is confirmed' }} 
              @endif  -->

              </td>
              <td class="center">
		          {{ Form::open(array('action' => 'QuotationsController@download_quotation','id'=>'downloadquotation')) }}
                      {{ Form::hidden('id',$value->id) }}
                      <button type="submit" class="download_btn pull-left"><i class="fa fa-download"></i>  </button>
			        {{ Form::close() }}

                    @if($value->status < 1)
                      <a class="edit_btn" href="{{ URL::to('quotations/'.$value->id) }}">
                          <i class="fa fa-pencil pull edit"></i>
                      </a>
                    @endif
                     <a class="view_btn" href="{{ URL::to('quotations/view/'.$value->id) }}">
                          <i class="fa fa-eye"></i>
                      </a>


                    {{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'QuotationsController@delete_quotation')) }}
                      {{ Form::hidden('id',$value->id) }}
                      <button type="submit" class="del_btn"><i class="fa fa-trash"></i> </button>
                    {{ Form::close() }}


                    @if($value->status == 0)
                    @if($get_qty_status != 1)
                    {{ Form::open(array('action' => 'QuotationsController@confirm_quotation','class'=>'confirm_quo','id'=> 'confirm_quo')) }}

                      {{ Form::hidden('id',$value->id) }}
                        <button type="submit" class="confirm_btn">Confirm</button>
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

function pay(n)
{
	$('#myModal').modal('show');
	$("#payto").val(n);
}

$(".buy_product").click(function(){
   alert("Buy more products");
});

function getBase64FromImageUrl(URL){
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

/*$('.datatable').dataTable({
    // Disable initial sort 
    "aaSorting": [],
});
$.fn.dataTableExt.sErrMode = 'throw';*/


</script>
@stop