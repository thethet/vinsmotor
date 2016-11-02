@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                  <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> View Location Type</h2></div>
            </div>
            <div class="box-content">
            	<table class="table table-striped">
                    <tr>
                        <td class="col-md-2"><strong>Location Type</strong></td><td>{{{ $store_type->store_type }}}</td>
                    </tr>
                </table>
                     
                <div class="form-actions">                
                    <a href="{{ URL::to('store_type') }}"><input type="button" value="Back" class="btn"></a>
                </div>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop