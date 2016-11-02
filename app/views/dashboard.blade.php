@extends('layouts.main')



@section('content')

            <div class="box span12">

		    <div class="box-header row">

			<div class="col-md-6"><h2 class="page_header"><i class="fa fa-dashboard"></i> Dashboard</h2></div>

		    </div>

		    <div class="box-content">

		    <h3 class="page_header"><i class="fa fa-cube"></i> Products List</h3>

			         <div class="table-responsive">

                  <table class="table table-striped table-bordered bootstrap-datatable datatable">

                  <thead>

                        <tr>

                          <th class="fifteen">Company</th>

                          <th class="fifteen">Product Code</th>

                          <th class="fifteen">Product Name</th>

                          <th class="fifteen">Cost Price</th>

                          <th class="fifteen">Selling Price</th>

                          <th class="fifteen">Quantity</th>

                          <th class="ten">Actions</th>

                        </tr>

                  </thead>   

                  <tbody>

                    <?php $i = 0; ?>

                    @foreach($products as $key => $value)

                        <tr>

                        <td>{{ DB::table('middlemen')->where('id',$value->company_id)->pluck('first_name'); }}</td>

                        <td>{{ $value->product_itemno }}</td>

                        <td>{{ $value->product_name }}</td>

                        <td>{{ $value->unit_price }}</td>

                        <td>{{ $value->selling_price }}</td>

                        <td>{{ $value->quantity }}</td>

                        <td class="center"> 

			        		<a class="edit_btn" href="{{ URL::to('products/'.$value->id) }}">

                                    <i class="fa fa-pencil"></i> 

                                </a> 

                                <a class="view_btn" href="{{ URL::to('products/view/'.$value->id) }}">

                                    <i class="fa fa-eye"></i>

                                </a>


                                {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'ProductsController@delete_product')) }} 

                                 {{ Form::hidden('id',$value->id) }}

                                   <button type="submit" class="del_btn formdel"><i class="fa fa-trash"></i> </button>

                                {{ Form::close() }}                                  

                        </td>                    

                        </tr>                     

                    @endforeach

                  </tbody>

              </table>  

		</div><!-- .table-responsive --> 

            <hr/>

	        <h3 class="page_header"><i class="fa fa-cube"></i> Location</h3>

	        <?php //print_r($store); ?>

	        <div class="table-responsive">

                  <table class="table table-striped table-bordered bootstrap-datatable datatable">

                  <thead>

                      <tr>

                          <th class="fifteen">Name</th>

                          <th class="fifteen">Type</th>

                          <th class="fifteen">Address</th>

                      <!--    <th class="fifteen">Date Created</th>

                          <th class="fifteen">Date Updated</th>-->

                          <th class="ten">Actions</th>

                      </tr>

                  </thead>   

                  <tbody>

                    <?php $i = 0; ?>

                    @foreach($store as $key => $value)

                        <tr>

                        <td>{{ $value->store_name }}</td>

                        <td>{{ DB::table('store_type')->where('id',$value->store_type)->pluck('store_type'); }}</td>

                        <td>{{ $value->store_address }}</td>

                    <!--    <td class="center">

                            <?php //echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>

                        </td>

                        <td class="center">

                            <?php //echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>

                        </td>   -->                     

                        <td class="center"> 

			        <a class="edit_btn" href="{{ URL::to('store/'.$value->id) }}">

                                    <i class="fa fa-pencil"></i> 

                                </a> 

                                <a class="view_btn" href="{{ URL::to('store/view/'.$value->id) }}">

                                    <i class="fa fa-eye"></i>

                                </a>

                              

                                {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'StoreController@delete_store')) }} 

                                 {{ Form::hidden('id',$value->id) }}

                                    <?php  

                                        $products = DB::table('products')->where('store_id',$value->id)->count(); 

                                   ?>

                                   @if($products)

                                   {{"&nbsp;"}}

                                   @else

                                   <button type="submit" class="del_btn formdel"><i class="fa fa-trash"></i> </button>

                                   @endif

                                {{ Form::close() }}                                  

                        </td>                    

                        </tr>                     

                    @endforeach

                  </tbody>

              </table>  

		</div>


		    </div><!-- .box-content -->

		 </div>  

	   	

@stop