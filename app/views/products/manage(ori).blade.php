@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Manage Products</h2></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('products/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
                  </div>
               </div>
            </div>
            <div class="box-content">
                      {{ $table->render() }}
                      {{ $table->script() }}   
            </div>
        </div><!--/span-->	
    </div><!--/row-->
    
@stop
