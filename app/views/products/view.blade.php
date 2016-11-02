@extends('layouts.main')

@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ URL::to('/main') }}">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/products') }}">Products</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/products/view/'.$product->id) }}">View Product</a> 
        </li>
    </ul>
    
   

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>View product</h2>
                
            </div>
            <div class="box-content">
            	<table class="table table-striped">
                	<tr>
			<tr><td>Company</td><td>{{{ DB::table('middlemen')->where('id','=',$product->company_id)->pluck('first_name') }}}</td></tr>
                    	<td class="span3 col-md-2"><strong>Product ID</strong></td><td>{{{ $product->product_itemno }}}</td>
                    </tr>
                    <tr>
                        <td class="span3"><strong>Product Category</strong></td><td>{{{ DB::table('products_category')->where('id','=',$product->product_catid)->pluck('cat_name') }}}</td>
                    </tr>
                	<tr>
                    	<td><strong>Product Name</strong></td><td>{{{ $product->product_name }}}</td>
                    </tr>
                	<tr>
                    	<td><strong>Product Description</strong></td><td>{{{ $product->product_description }}}</td>
                    </tr>
                  
                       
                	<tr>
                    	<td><strong>Cost Price</strong></td><td>${{{ $product->unit_price }}}</td>
                    </tr>
                	<tr>
                    	<td><strong>Selling price</strong></td><td>${{{ $product->selling_price }}}</td>
                    </tr>
                    <!--<tr>
                    	<td><strong>Measurements</strong></td><td>
                        <?php
						/*
                        if ($product->measurements != "" && $product->measurements != ";;" )
						{
							$msrm = explode(';',$product->measurements);
							for ($n = 0; $n < count($msrm); $n++)
							{
								if ($n == count($msrm)-1)
									echo $msrm[$n]." mm";
								else
									echo $msrm[$n]." x ";
								
							}
						}
						else
							echo "---";
                            */
						?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Weight</strong></td><td>{{{ $product->weight }}}</td>
                    </tr>-->
                    <tr>
                        <td><strong>Quantity</strong></td><td>{{{ $product->quantity }}}</td>
                    </tr>
                     <tr>
                        <td><strong>Min Product Quantity to inform</strong></td><td>{{{ $product->min_product_qty}}}</td>
                    </tr>
                    <tr>
                        <td><strong>Store</strong></td><td>{{ DB::table('store')->where('id','=',$product->store_id)->pluck('store_name') }}</td>
                    </tr>
                	<tr>
                    	<td><strong>Supplier</strong></td><td>@if ($product->supplier == -1) None  @else {{ DB::table('suppliers')->where('id','=',$product->supplier)->pluck('supplier_name') }}@endif </td>
                    </tr>
                    <tr>
                        <td><strong>Remark</strong></td><td>{{{$product->pro_remark}}}</td>
                    </tr>
                    <tr>
                        <td><strong>Image</strong></td><td><?php if($product->pro_photos == ""){ echo "&nbsp;"; } else{ ?><img src="<?php echo '../../bootstrap/img/'.$product->pro_photos; ?>" style="max-width:300px"/><?php }  ?></td>
                    </tr>
                </table>				
                     
                      <div class="form-actions">
                        
                        <a href="{{ URL::to('products') }}"><input type="button" value="Back" class="btn"></a>
                      </div>
                    </fieldset>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop