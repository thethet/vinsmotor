@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">
	    <div class="box-header row">
		 <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> Manage Location</h2></div>
		    <div class="col-md-6">
			<div class="box-icon">
			    <a href="{{ URL::to('store/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
			</div>
		    </div>
	    </div>
            <div class="box-content">
		<div class="table-responsive">
                  <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Name</th>
                          <th class="fifteen">Type</th>
                          <th class="fifteen">Address</th>
                      <!--    <th class="fifteen">Date Created</th>
                          <th class="fifteen">Date Updated</th>-->
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($store as $key => $value)
                        <tr>
                        <td>{{ $value->store_name }}</td>
                        <td>{{ DB::table('store_type')->where('id',$value->store_type)->pluck('store_type'); }}</td>
                        <td>{{ $value->store_address }}</td>
                    <!--    <td class="center">
                            <?php //echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                        <td class="center">
                            <?php //echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>   -->                     
                        <td class="center"> 
			        <a class="edit_btn" href="{{ URL::to('store/'.$value->id) }}">
                                    <i class="fa fa-pencil"></i> 
                                </a> 
                                <a class="view_btn" href="{{ URL::to('store/view/'.$value->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                              
                                {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'StoreController@delete_store')) }} 
                                 {{ Form::hidden('id',$value->id) }}
                                    <?php  
                                        $products = DB::table('products')->where('store_id',$value->id)->count(); 
                                   ?>
                                   @if($products)
                                   {{"&nbsp;"}}
                                   @else
                                   <button type="submit" class="del_btn formdel"><i class="fa fa-trash"></i> </button>
                                   @endif
                                {{ Form::close() }}                                  
                        </td>                    
                        </tr>                     
                    @endforeach
                  </tbody>
              </table>  
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->

@stop
@section ('script')
<script>
var no = 0;
$("form").submit(function(ev) {
	if (no == 0)
	{
	var id = $(this).attr('id');
	
		Boxy.confirm("Are you sure you want to delete?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});
		return false;
	}
});
</script>
@stop