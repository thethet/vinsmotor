@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
             <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> Edit client</h2></div>
            </div>
            <div class="box-content">  
		<div class="row">
		<div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'clients/edit','class'=>'form-horizontal','method'=>'post')) }}
                {{ Form::hidden('id',$client->id) }}
                    <fieldset>                           
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Organization</label>
                        <div class="controls">
                          <input type="text" required value="{{ $client->organization }}" name="organization" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="selectError">Salutation</label>
                        <div class="controls">
                          <select name="salutation" required id="selectError" class="form-control">
                             <option @if ($client->salutation == "Dr.") selected @endif value="Dr.">Dr.</option>
                             <option @if ($client->salutation == "Miss") selected @endif value="Miss">Miss</option>
                             <option @if ($client->salutation == "Ms.") selected @endif value="Ms.">Ms.</option>
                             <option @if ($client->salutation == "Mr.") selected @endif value="Mr.">Mr.</option>
                             <option @if ($client->salutation == "Mrs.") selected @endif value="Mrs.">Mrs.</option>
                             <option @if ($client->salutation == "M/S.") selected @endif value="M/S.">M/S.</option>
                          </select>
                          
                        </div>
                      </div>           
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required value="{{ $client->first_name }}" name="first_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     
                      
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                           <input type="number" value="{{ $client->mobile_contact }}" name="mobile_contact" id="inputSuccess" min="0" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" value="{{ $client->email }}" name="email" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Billing Address</label>
                        <div class="controls">
			    <textarea name="billing_address" id="inputSuccess" class="form-control">{{ $client->billing_address }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Delivery Address</label>
                        <div class="controls">
			    <textarea name="delivery_address" id="inputSuccess" class="form-control">{{ $client->delivery_address }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                           <textarea class="textarea form-control" name="remarks">{{$client->remarks }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                    
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>                        
                        <a href="{{ URL::to('clients') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		</div>
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop