@extends('layouts.main')
@section('header')

    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
<style>
.download_btn{
  margin-left:100px;
}
</style>
    <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> New product category</h2></div>
            </div>
            <div class="box-content">
		<div class="row">
		    <div class="col-md-4 col-md-offset-4">
		    {{ Form::open(array('url' => 'product_category/create','class'=>'form-horizontal','method'=>'post','id'=>'test')) }}
			<fieldset>     
			  <div class="form-group success">
			    <label class="control-label" for="inputSuccess">Category Name</label>
			     <div class="controls">
				 <input type="text" required name="cat_name" id="inputSuccess" class="form-control" autocomplete="off">
			      <span class="help-inline"><?php echo $errors->first('cat_name'); ?></span>                          
			    </div>
			  </div>                             
			  <div class="form-actions">
			    <button type="submit" class="btn btn-primary">Save</button>                        
			    <a href="{{ URL::to('product_category') }}"><input type="button" value="Cancel" class="btn"></a>
			  </div>
			</fieldset>
		      {{ Form::close() }}
		    </div>
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
	
@stop