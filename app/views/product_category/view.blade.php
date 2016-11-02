@extends('layouts.main')

@section('content')

    <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> View Product Category</h2></div>
            </div>
            <div class="box-content">
            	<table class="table table-bordered">
                	<tr>
                    	<td class="col-md-2"><strong>Category Name</strong></td><td>{{{ $product_category->cat_name }}}</td>
                    </tr>
                </table>
                     
                <div class="form-actions">                
                    <a href="{{ URL::to('product_category') }}"><input type="button" value="Back" class="btn"></a>
                </div>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop