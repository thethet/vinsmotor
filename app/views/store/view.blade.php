@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                 <div class="col-md-6"><h2 class="page_header"><i class="fa fa-house"></i> View Location</h2></div>
            </div>
            <div class="box-content">
            	<table class="table table-striped">
                	<tr>
                    	<td class="col-md-2"><strong>Name</strong></td><td>{{{ $store->store_name }}}</td>
                    </tr>
                    <tr>
                        <td><strong>Type</strong></td><td>{{{ DB::table('store_type')->where('id',$store->store_type)->pluck('store_type') }}}</td>
                    </tr>
                    <tr>
                        <td><strong>Description</strong></td><td>{{{ $store->store_description }}}</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td><td>{{{ $store->store_address }}}</td>
                    </tr>
                    <tr>
                        <td><strong>Remark</strong></td><td>{{{ $store->remark }}}</td>
                    </tr>
                </table>
                     
                <div class="form-actions">                
                    <a href="{{ URL::to('store') }}"><input type="button" value="Back" class="btn"></a>
                </div>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop