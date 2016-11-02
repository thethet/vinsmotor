@extends('layouts.main')

@section('content')

    <div class="row-fluid sortable">		
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> Manage clients</h2></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('clients/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
                  </div>
               </div>
            </div>
            <div class="box-content">
		<div class="table-responsive">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Client name</th>
                          <th class="twenty hidden-xs">Organization</th>
                          <th class="ten">Contact</th>
                          <th class="fifteen">Email</th>
                          <th class="fifteen hidden-xs">Address</th>
                       <!--   <th class="fifteen hidden-xs">Date Created</th>
                          <th class="fifteen hidden-xs">Date Updated</th>-->
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($clients as $key => $value)
    					<tr>
                        <td>{{ $value->salutation." ".$value->first_name." ".$value->last_name }}</td>
                        <td class="center hidden-xs">
                              {{ $value->organization }}
                        </td> 
                        <td class="center">{{ $value->mobile_contact }}</td>
                        <td class="center">{{ $value->email }}</td>
                        <td class="center hidden-xs">
                        <i>Delivery address</i> :<br> {{ $value->delivery_address }}<br><br><i>Billing address</i> : <br>{{ $value->billing_address }}
                        
                        </td>
                    <!--    <td class="center hidden-xs">
                        	<?php echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                         <td class="center hidden-xs">
                        	<?php echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>  -->                      
                        <td class="center">
                            {{ Form::open(array('id'=>'delform'.$i++,'class' => 'formdel','action' => 'ClientsController@delete_client')) }}
                                {{ Form::hidden('id',$value->id) }}
                                <a class="edit_btn" href="{{ URL::to('clients/'.$value->id) }}"><i class="fa fa-pencil"></i></a>
                                <a class="view_btn" href="{{ URL::to('clients/view/'.$value->id) }}"><i class="fa fa-eye"></i></a>
                                 <?php  $quotations = DB::table('quotations')->where('client_id',$value->id)->count();
                                        $invoices = DB::table('invoices')->where('client_id',$value->id)->count(); 
                                   ?>
                                   @if($quotations > 0 || $invoices > 0)
                                   {{"&nbsp;"}}
                                   @else
                                   <button type="submit" class="formdel del_btn"><i class="fa fa-trash"></i> </button>
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
$(".formdel").submit(function(ev) {
  if (no == 0)
  {
   var id = $(this).attr('id');  
    Boxy.confirm("Are you sure?", function() { no = 1; $("#"+id).submit(); }, {title: 'Confirm'});
    return false;
  }
});
</script>
@stop