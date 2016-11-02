@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Manage Product Category</h2></div>
		<div class="col-md-6">
		    <div class="box-icon">
			<a href="{{ URL::to('product_category/create') }}" class="anchorlink"> <i class="halflings-icon white plus"></i> Add</a>
		    </div>
		</div>
            </div>
            <div class="box-content">
                       <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Category name</th>
                         
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($product_category as $key => $value)
                        <tr>
                        <td>{{ $value->cat_name }}</td>              
                        <td class="center">  
			        <a class="edit_btn" href="{{ URL::to('product_category/'.$value->id) }}">
                                    <i class="fa fa-pencil"></i>
                                </a> 
                                <a class="view_btn" href="{{ URL::to('product_category/view/'.$value->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>                              
                                {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'ProductsCategoryController@delete_productcategory')) }} 
                                 {{ Form::hidden('id',$value->id) }}
                                    <?php  
                                        $products = DB::table('products')->where('product_catid',$value->id)->count(); 
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
		Boxy.confirm("Are you sure?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});
		return false;
	}
});
</script>
@stop