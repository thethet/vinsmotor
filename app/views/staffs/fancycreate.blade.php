@extends('layouts.fancy')

@section('content')

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Add new staff</h2>
                
            </div>
            <div class="box-content">
            
				{{ Form::open(array('url' => 'staffs/fancycreate','class'=>'form-horizontal','method'=>'post')) }}
                    <fieldset>    
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
                        <label class="control-label" for="inputSuccess">First Name</label>
                        <div class="controls">
                          <input type="text" required name="first_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Last Name</label>
                        <div class="controls">
                          <input type="text" required name="last_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess" >Home Contact</label>
                        <div class="controls">
                          <input type="text" required name="home_contact" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
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
                           <input type="email" required name="email" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess" >Billing Address</label>
                        <div class="controls">
                           <input type="text" required name="billing_address" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Delivery Address</label>
                        <div class="controls">
                           <input type="text" required name="delivery_address" id="inputSuccess">
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
                        <button type="submit" class="btn btn-primary">Add staff</button>
                        
                        <a href="{{ URL::to('staffs') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop