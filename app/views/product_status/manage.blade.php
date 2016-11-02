@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">	     
            <div class="box-header row">
              <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Manage Product Status</h2></div>
            </div>
            <div class="box-content">
		<h3 class="page_header"><i class="fa fa-cube"></i> Required products list after creating quotation or invoice</h3>
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Product Item No </th>
                          <th class="fifteen">Product Name</th>
                          <th class='fifteen'>Required Quantity</th>
                          <th class="ten">Ordered Quantity</th>
                          <th class="ten">Quotation</th>
                          <th class="ten">Invoice</th>
                          <th class="ten">PO</th>
                          <th class="fifteen">Date Created</th>
                          <th class="fifteen">Date Updated</th>
                          
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0;  ?>
                    @if($product_status)
                    
                    @foreach($product_status as $key => $value)
                        <tr>
                        <td><?php $get_pro = ProductEntry::where('id','=',$value->pro_id)->first(); ?> {{ '<a href="products/'.$get_pro->id.'">'.$get_pro->product_name.'</a>' }}</td>
                        <td>{{  '<a href="products/'.$get_pro->id.'">'.$get_pro->product_itemno.'</a>' }}
                        <td>{{ $value->required_qty }}</td>
                        <td>{{ $value->ordered_qty }}</td>
                        <td>
                          <?php
                          if($value->quo_id != 0){
                            $id = "QU";
                             for ($n = 0; $n < (5 - strlen($value->quo_id)); $n++)
                             {
                               $id .= "0";
                             }
                             $id .= $value->quo_id;
                             ?>
                             <a href="{{ URL::to ('quotations/view/'.$value->quo_id) }}"> 
                             <?php echo $id; ?>
                             </a>
                             <?php
                            }                          
                          ?>
                        </td>
                        <td> <?php
                         if($value->inv_id != 0){
                           $id = "INV";
                         for ($n = 0; $n < (5 - strlen($value->inv_id)); $n++)
                         {
                           $id .= "0";
                         }
                         $id .= $value->inv_id;
                         ?>
                         <a href="{{ URL::to ('invoices/view/'.$value->inv_id) }}">
                          <?php echo $id; ?>
                         </a>
                         <?php
                         }
                       
                        ?></td>
                        <td>
                          <?php if($value->po_id == 0){
                          ?>
                           {{ Form::open(array('action' => 'PurchaseOrdersController@pass_form_fromproduct','method'=>'put')) }}
                          {{Form::hidden('pid',$value->pro_id) }}
                          {{Form::hidden('id',0) }}
                          <input type="submit" class="btn btn-warning" value="+ Create">
                          {{ Form::close() }}
                          <?php } else {   
                            $get_po = explode(',',$value->po_id);
                            for($i=0;$i<count($get_po);$i++){
                               $id = "PO";
                               for ($n = 0; $n < (5 - strlen($get_po[$i])); $n++)
                               {
                                 $id .= "0";
                               }
                               $id .= $get_po[$i];
                            ?>
                            <a href="{{ URL::to ('purchase_orders/view/'.$get_po[$i]) }}">
                              <?php  echo $id;  ?>    
                            </a>                         
                            <?php } 

                            $get_qty_inpo = POItemEntry::where('po_id','=',$value->po_id)->pluck('quantity');
                             if($value->required_qty != 0){ ?>
                                {{ Form::open(array('action' => 'PurchaseOrdersController@pass_form_fromproduct','method'=>'put')) }}
                                {{ Form::hidden('pid',$value->pro_id) }}
                                {{ Form::hidden('id',0) }}
                                <input type="submit" class="btn btn-warning" value="+ Create">
                                {{ Form::close() }}
                             <?php }
                            
                          } ?>
                        </td>
                        <td class="center">
                            <?php echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                        <td class="center">
                            <?php echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>                        
                                        
                        </tr>                     
                    @endforeach
                    @endif
                  </tbody>
              </table>   
              <hr/>
	        <h3 class="page_header"><i class="fa fa-cube"></i> Low stock list</h3>
               <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Product Item No </th>
                          <th class="fifteen">Product Name</th>
                          <th class='fifteen'>Stocked Quantity</th>
                          <th class="ten">Min Quantity</th>
                          <th class="ten">PO</th>
                          <th class="fifteen">Date Created</th>
                          <th class="fifteen">Date Updated</th>
                         
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0;  ?>
                    @if($products)
                    @foreach($products as $key => $value)
                        <tr>
                        <td>{{ '<a href="products/'.$value->id.'">'.$value->product_name.'</a>' }}</td>
                        <td>{{  '<a href="products/'.$value->id.'">'.$value->product_itemno.'</a>' }}
                        <td>{{ $value->quantity }}</td>
                        <td>{{ $value->min_product_qty }}</td>
                        <td><?php $search_countpo = ProductStatusEntry::where('pro_id','=',$value->id)->count(); 
                         if($search_countpo != 1){  ?>
                          {{ Form::open(array('action' => 'PurchaseOrdersController@pass_form_fromproduct','method'=>'put')) }}
                          {{Form::hidden('id',$value->id) }} 
                          {{Form::hidden('pid',0) }} 
                          <input type="submit" class="btn btn-warning" value="+ Create">
                          {{ Form::close() }} <?php }else {echo "po no."; } ?>
                       </td>
                        <td class="center">
                            <?php echo "<span class='invis'>".date('Ymdhis',strtotime($value->created_at))."</span> ".date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                        <td class="center">
                            <?php echo "<span class='invis'>".date('Ymdhis',strtotime($value->updated_at))."</span> ".date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>                        
                                         
                        </tr>                     
                    @endforeach
                    @endif
                  </tbody>
              </table>     
            </div>
        </div><!--/span-->
    
    </div><!--/row-->

@stop