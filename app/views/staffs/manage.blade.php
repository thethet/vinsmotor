@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">
	     <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> Manage staffs</h2></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('staffs/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
                  </div>
               </div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th class="fifteen">Staff name</th>
                          <th class="ten">Contact</th>
                          <th class="fifteen">Email</th>
                          <th class="fifteen">Address</th>
                          <th class="twenty">Remarks</th>
                        <!--  <th class="fifteen">Date Created</th>
                          <th class="fifteen">Date Updated</th>-->
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>                    
                    @foreach($staffs as $key => $value)
    					<tr>
                        <td>{{ $value->name }}</td>
                        <td class="center">{{ $value->contact }}</td>
                        <td class="center">{{ $value->email }}</td>
                        <td class="center">
                      {{ $value->address }}
                        
                        </td>
                        <td class="center">
                              {{ $value->remarks }}
                        </td> 
                      <!--  <td class="center">
                        	<?php //echo "<span class='invis'>".date('Ymdhis',strtotime($value->created_at))."</span> ".date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                         <td class="center">
                        	<?php //echo "<span class='invis'>".date('Ymdhis',strtotime($value->updated_at))."</span> ".date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>-->
                        
                        <td class="center">
                            
                            {{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'StaffsController@delete_staff')) }}
                                {{ Form::hidden('id',$value->id) }}
                                <a class="edit_btn" href="{{ URL::to('staffs/'.$value->id) }}">
                                    <i class="fa fa-pencil edit"></i>  
                                </a>
                                <a class="view_btn" href="{{ URL::to('staffs/view/'.$value->id) }}">
                                    <i class="fa fa-eye"></i>  
                                </a>
                                <button type="submit" class="del_btn"><i class="fa fa-trash"></i> </button> 
                                    
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