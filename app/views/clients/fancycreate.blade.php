@extends('layouts.fancy')

@section('content')

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Add new client</h2>
                
            </div>
            <div class="box-content">
            
				{{ Form::open(array('url' => 'clients/fancycreate','class'=>'form-horizontal','method'=>'post')) }}
                    <fieldset>    
                    
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess" >Organization</label>
                        <div class="controls">
                          <input type="text" name="organization" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                    <div class="control-group success">
                        <label class="control-label" for="selectError">Salutation</label>
                        <div class="controls">
                          <select name="salutation" required id="selectError">
                             <option value="Dr.">Dr.</option>
                             <option value="Miss">Miss</option>
                             <option value="Ms.">Ms.</option>
                             <option value="Mr.">Mr.</option>
                             <option value="Mrs.">Mrs.</option>
                          </select>
                          
                        </div>
                      </div>                  
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required name="first_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <!--<div class="control-group success">
                        <label class="control-label" for="inputSuccess">Last Name</label>
                        <div class="controls">
                          <input type="text" required name="last_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>-->
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Mobile Contact</label>
                        <div class="controls">
                           <input type="text" required name="mobile_contact" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" name="email" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess" >Billing Address</label>
                        <div class="controls">
                           <input type="text" name="billing_address" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Delivery Address</label>
                        <div class="controls">
                           <input type="text" name="delivery_address" id="inputSuccess">
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
                        <button type="submit" class="btn btn-primary">Add client</button>
                        
                        <a href="{{ URL::to('clients') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop