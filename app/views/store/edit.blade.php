@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
	<div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-house"></i> Edit location</h2></div>
            </div>
        <div class="box span12">
            <div class="box-content">
		<div class="row">
		<div class="col-md-4 col-md-offset-4">
	    {{ Form::open(array('url' => 'store/edit','class'=>'form-horizontal','method'=>'post')) }}
               <input type="hidden" value="{{ $store->id }}" name="id"/>
                    <fieldset>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Name</label>
                         <div class="controls">
                          <input type="text" required name="store_name" id="inputSuccess" value="{{{ $store->store_name }}}" class="form-control">{{  $errors->first('store_name');}}                                                  
                        </div>
                      </div> 
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Type</label>
                         <div class="controls">
                          
                            <select data-rel="chosen" name="store_type" required class="form-control">
                              <!-- <option value="---">---</option> -->
                                @foreach($store_type as $key => $value)
                                  <option value={{ $value->id }}<?php if($value->id == $store->store_type){ ?> selected="selected" <?php } ?>>{{ $value->store_type }} </option>
                                @endforeach
                            </select>                                    
                        </div>
                      </div> 
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Description</label>
                         <div class="controls">
                          <textarea name="store_description" id="inputSuccess" class="form-control">{{{ $store->store_description }}}</textarea>                     
                        </div>
                      </div> 
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Address</label>
                         <div class="controls">
                          <textarea required name="store_address" id="inputSuccess" class="form-control">{{{ $store->store_address }}}</textarea>                      
                        </div>
                      </div>   
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remark</label>
                         <div class="controls">
                          <textarea name="remark" id="inputSuccess" class="form-control">{{{ $store->remark }}}</textarea>                     
                        </div>
                      </div>                        
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        
                        <a href="{{ URL::to('store') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		</div>
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop