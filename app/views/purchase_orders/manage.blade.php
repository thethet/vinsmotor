@extends('layouts.main')



@section('content')

    <div class="row-fluid sortable">		

        <div class="box span12">

	     <div class="box-header row">

                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Manage purchase orders</h2></div>

                <div class="col-md-6">

                  <div class="box-icon">

                      <a href="{{ URL::to('purchase_orders/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add purchase order</a>

                  </div>

               </div>

            </div>

            <div class="box-content">

                <table class="table table-striped table-bordered bootstrap-datatable datatable">

                  <thead>

                      <tr>

                          <th class="fifteen">Purchase order No.</th>

                          <th class="fifteen">Invoice No.</th>

                          <th class="fifteen">Supplier name</th>

                          <th class="ten">Total Price</th>

                          <th class="fifteen">Issued by</th>

                          <th class="fifteen">Date issued</th>

                          <th class="fifteen">Actions</th>

                      </tr>

                  </thead>   

                  <tbody>

                    

                    <?php $i = 0; ?>

                    @foreach($purchase_orders as $key => $value)

              					<tr>

                                <td><?php

                                /* $id = "PO";

        						 for ($n = 0; $n < (5 - strlen($value->id)); $n++)

        						 {

        							 $id .= "0";

        						 }

        						 $id .= $value->id;

        						 echo $id;*/
								 echo $value->purchase_order_no;

                                 ?></td>

                                   

                                  <td><?php

          						if ($value->invoice_id != "-1")

          						{

          							$gid = "INV";

          							 for ($n = 0; $n < (5 - strlen($value->invoice_id)); $n++)

          							 {

          								 $gid .= "0";

          							 }

          							 $gid .= $value->invoice_id;

          							 echo $gid;

          						}

          						else

          							echo "---";

          						 ?></td>

                        <td><?php $username = DB::table('suppliers')->where('id','=',$value->supplier_id)->first(); if (isset($username)) echo $username->supplier_name; ?></td>

                      

                       <td class="center">${{ $value->total_price }}</td>

                        

                        <td><?php $username = DB::table('users')->where('id','=',$value->created_by)->first(); echo $username->first_name." ".$username->last_name; ?></td>

                      

                       

                        <td class="center"><?php echo "<span class='invis'>".date('YmdHis',strtotime($value->date_created))."</span> ".date('d-m-Y h:i:s',strtotime($value->date_created)); ?></td>

                      <td class="center">

                            {{ Form::open(array('action' => 'PurchaseOrdersController@download_po','id'=>'downloadpo')) }}

                                {{ Form::hidden('id',$value->id) }}

                                  <button type="submit" class="download_btn pull-left"><i class="fa fa-download"></i>  </button>  

                         	  	<a class="view_btn" href="{{ URL::to('purchase_orders/view/'.$value->id) }}">

					<i class="fa fa-eye"></i>

                                </a>                              

                              {{ Form::close() }}

                            @if($value->status != 1)
                            {{ Form::open(array('action' => 'PurchaseOrdersController@delete_purchase_order','id'=>'deletepo')) }}

                                {{ Form::hidden('id',$value->id) }}

                                 <a class="edit_btn" href="{{ URL::to('purchase_orders/'.$value->id) }}" style="float:left;">

                                       <i class="fa fa-pencil"></i>

                                 </a>

                                 {{ Form::close() }}
                            @endif

                            {{ Form::open(array('action' => 'PurchaseOrdersController@delete_purchase_order','id'=>'deletepo')) }}

                                {{ Form::hidden('id',$value->id) }}


                                  <button type="submit" class="del_btn" style="float:left;"><i class="fa fa-trash"></i>  </button>  

                             @if($value->status != 1)

                             {{ Form::close() }}

                             {{ Form::open(array('action' => 'PurchaseOrdersController@confirm_po')) }} 

                              {{ Form::hidden('id',$value->id) }}   

                                <button type="submit" class="confirm_btn">Confirm</button>  

                              {{ Form::close() }} 

                              @endif

                        </td>

                        

                        </tr>                     

	                @endforeach

                  </tbody>

              </table>            

            </div>

        </div><!--/span-->

    

    </div><!--/row-->



@stop



@section ('script')

<script>

var no = 0;

$(".formdel").submit(function(ev) {

	if (no == 0)

	{

	var id = $(this).attr('id');

	

		Boxy.confirm("Are you sure?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});

		return false;

	}

});

</script>

@stop