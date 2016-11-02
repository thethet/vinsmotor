@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
	     <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Edit product category</h2></div>
            </div>
            <div class="box-content">
		<div class="row">
		<div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'product_category/edit','class'=>'form-horizontal','method'=>'post')) }}
               <input type="hidden" value="{{ $product_category->id }}" name="id"/>
                    <fieldset>    
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Category Name</label>
                        <div class="controls">
			    <input type="text" class="form-control" value="{{{ $product_category->cat_name }}}" autocomplete="off" required name="cat_name" id="inputSuccess"> {{  $errors->first('cat_name');}}
                          <span class="help-inline"></span>
                        </div>
                      </div>                  
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        
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