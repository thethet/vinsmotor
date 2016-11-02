@extends('layouts.fancy')

@section('content')

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Add new middleman</h2>
                
            </div>
            <div class="box-content">
            
				{{ Form::open(array('url' => 'middlemen/fancycreate','class'=>'form-horizontal','method'=>'post')) }}
                     <fieldset>    
                         
                      
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">First Name</label>
                        <div class="controls">
                          <input type="text" required name="first_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Last Name</label>
                        <div class="controls">
                          <input type="text" name="last_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                           <input type="text" required name="mobile_contact" id="mobilecontact">
                          <span class="help-inline" id="mobilehelp"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" name="email" id="email">
                          <span class="help-inline" id="emailhelp"></span>
                        </div>
                      </div>
                     
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Address</label>
                        <div class="controls">
                           <input type="text" name="address" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      
                      
                     <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                           <textarea class="textarea" name="remarks"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add middlemen</button>                        
                        <a href="{{ URL::to('middlemen') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop