@extends('layouts.main')

@section('content')
       <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> New staff</h2></div>
            </div>
            <div class="box-content">
		<div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'staffs/create','class'=>'form-horizontal','method'=>'post')) }}
                    <fieldset>                   
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required name="name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Contact</label>
                        <div class="controls">
                          <input type="number" required name="contact" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" required name="email" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Address</label>
                        <div class="controls">
			    <textarea required name="address" id="inputSuccess" class="form-control"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>                    
                      
                     <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                           <textarea class="textarea form-control" name="remarks"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                        
                        <a href="{{ URL::to('staffs') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop