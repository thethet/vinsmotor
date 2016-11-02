@extends('layouts.main')

@section('content')
  
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row" data-original-title>
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Edit Location Type</h2></div>
            </div>
	    
            <div class="box-content">   
		<div class='col-md-4 col-md-offset-4'>
		{{ Form::open(array('url' => 'store_type/edit','class'=>'form-horizontal','method'=>'post')) }}
               <input type="hidden" value="{{ $store_type->id }}" name="id"/>
                    <fieldset> 
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Type</label>
                         <div class="controls">
                          <input type="text" required name="store_type" id="inputSuccess" value="{{{ $store_type->store_type }}}" class="form-control">                       
                        </div>
                      </div>                        
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        
                        <a href="{{ URL::to('store_type') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}      
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop