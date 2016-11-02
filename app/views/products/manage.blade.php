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

                <div class="table-responsive">

                  <table class="table table-striped table-bordered bootstrap-datatable datatable">

                  <thead>

                        <tr>

                          <th class="fifteen">Company</th>

                          <th class="fifteen">Product Code</th>

                          <th class="fifteen">Product Name</th>

                          <th class="fifteen">Location</th>

                          <th class="fifteen">Cost Price</th>

                          <th class="fifteen">Selling Price</th>

                          <th class="fifteen">Quantity</th>

                          <th class="ten">Actions</th>

                        </tr>

                  </thead>

                  <tbody>

                    <?php $i = 0; ?>

                    @foreach($products as $key => $value)

                        <tr>

                        <td>{{ DB::table('middlemen')->where('id',$value->company_id)->pluck('first_name'); }}</td>

                        <td>{{ $value->product_itemno }}</td>

                        <td>{{ $value->product_name }}</td>

                        <td>
                        {{ DB::table('store')->where('id',$value->store_id)->pluck('store_name'); }}
                        </td>

                        <td>{{ $value->unit_price }}</td>

                        <td>{{ $value->selling_price }}</td>

                        <td>{{ $value->quantity }}</td>

                        <td class="center">

			        		<a class="edit_btn" href="{{ URL::to('products/'.$value->id) }}">

                                    <i class="fa fa-pencil"></i>

                                </a>

                                <a class="view_btn" href="{{ URL::to('products/view/'.$value->id) }}">

                                    <i class="fa fa-eye"></i>

                                </a>


                                {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'ProductsController@delete_product')) }}

                                 {{ Form::hidden('id',$value->id) }}

                                   <button type="submit" class="del_btn formdel"><i class="fa fa-trash"></i> </button>

                                {{ Form::close() }}

                        </td>

                        </tr>

                    @endforeach

                  </tbody>

              </table>

		</div><!-- .table-responsive -->

            </div>

        </div><!--/span-->

    </div><!--/row-->
@stop

@section('script')
<script>
/*$('.datatable').dataTable({
    // Disable initial sort 
    "aaSorting": [],
});
$.fn.dataTableExt.sErrMode = 'throw';*/

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