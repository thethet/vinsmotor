@extends('layouts.main')

@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ URL::to('/main') }}">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/product_category') }}">Product Category</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/product_category/view/'.$product_category->id) }}">View Product Category</a> 
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
                    	<td class="span3"><strong>Category Name</strong></td><td>{{{ $product_category->cat_name }}}</td>
                    </tr>
                </table>
                     
                <div class="form-actions">                
                    <a href="{{ URL::to('product_category') }}"><input type="button" value="Back" class="btn"></a>
                </div>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop