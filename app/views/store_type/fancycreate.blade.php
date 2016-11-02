@extends('layouts.fancy')

@section('content')

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Add Store Type</h2>
                
            </div>
            <div class="box-content">
              {{ Form::open(array('url' => 'store_type/fancycreate','class'=>'form-horizontal','method'=>'post')) }}
                <fieldset>     
                   <div class="control-group success">
                    <label class="control-label" for="inputSuccess">Store Type</label>
                     <div class="controls">
                      <input type="text" required name="store_type" id="inputSuccess" >                       
                    </div>
                  </div>                          
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Store Type</button>                        
                    <a href="{{ URL::to('store_type') }}"><input type="button" value="Cancel" class="btn"></a>
                  </div>
                </fieldset>
              {{ Form::close() }}            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop