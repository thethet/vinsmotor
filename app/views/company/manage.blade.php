@extends('layouts.main')

@section('header')
   
     <style type="text/css">
     .logoview_img img{
        max-width: 200px;
        max-height: 100px;
        overflow: hidden;
     }
    </style>

@stop

@section('content')
    <div class="row-fluid sortable">		
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><!--<h2 class="page_header"><i class="fa fa-user"></i> Manage Middlemen</h2>--></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('company/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add</a>
                  </div>
               </div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
			  <th>Logo</th>
                          <th class="fifteen">Name</th>
                          <th class="ten">Contact</th>
                          <th class="fifteen">Email</th>
                          <th class="fifteen">Address</th>
                          <th class="twenty">Remarks</th>
                     <!--     <th class="fifteen">Date Created</th>
                          <th class="fifteen">Date Updated</th>-->
                          <th class="ten">Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>
                    @foreach($middlemen as $key => $value)
    					<tr>
			<td class="logoview_img"><?php if($value->photo == ""){ ?>
        {{ HTML::image('images/no_logo.jpg', '', array('height' => '100px')) }}
        <?php } else{  ?>{{ HTML::image('bootstrap/img/' . $value->photo, '', array('height' => '100px')) }}<?php }  ?></td>
                        <td>{{ $value->first_name }}</td>
                        <td class="center">{{ $value->mobile_contact }}</td>
                        <td class="center">{{ $value->email }}</td>
                        <td class="center">
                              {{ $value->address }}
                        </td> 
                        <td class="center">
                           {{ $value->remarks }}                     
                        </td>
                     <!--   <td class="center">
                        	<?php echo date('d-m-Y h:i:s',strtotime($value->created_at)); ?>
                        </td>
                         <td class="center">
                        	<?php echo date('d-m-Y h:i:s',strtotime($value->updated_at)); ?>
                        </td>-->
                        
                        <td class="center">
                            <!--
                            {{ Form::open(array('action' => 'MiddlemenController@delete_middlemen')) }}
                                {{ Form::hidden('id',$value->id) }}-->
                            {{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'MiddlemenController@delete_middlemen')) }}
                            {{ Form::hidden('id',$value->id) }}
                                <a class="edit_btn" href="{{ URL::to('company/'.$value->id) }}">
                                    <i class="fa fa-pencil"></i>  
                                </a>
                                <a class="view_btn" href="{{ URL::to('company/view/'.$value->id) }}">
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