@extends('layouts.main')

@section('content')
    
    <div class="row-fluid sortable">		
        <div class="box span12">
            
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-file"></i> Manage Users</h2></div>
                <div class="col-md-6">
                  <div class="box-icon">
                      <a href="{{ URL::to('users/create') }}" class="anchorlink"> <i class="fa fa-plus"></i> Add User</a>
                  </div>
               </div>
            </div><!-- .box-header -->

            <div class="box-content">
            	
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Contact</th>
                          <th>Email</th>
                          <th>Date registered</th>
                          <th>Role</th>
                          <th>Actions</th>
                      </tr>
                  </thead>   
                  <tbody>
                    <?php $i = 0; ?>
                    
                    @foreach($users as $key => $value)
    					<tr>
                        <td>{{ $value->first_name." ".$value->last_name }}</td>
                        <td class="center">{{ $value->contact }}</td>
                        <td class="center">{{ $value->email }}</td>
                        <td class="center">
                            {{ $value->created_at }}
                        </td>
                        <td class="center">
                        
							{{ $rolename = DB::table('user_role')->where('id','=',$value->userrole)->pluck('name'); }}
                        
                        </td>
                        <td class="center">
                            
                            {{ Form::open(array('id'=>'delform'.$i++,'class'=>'formdel','action' => 'UsersController@delete_user')) }}
                                {{ Form::hidden('id',$value->id) }}
                                <a class="view_btn" href="{{ URL::to('users/'.$value->id) }}">
                                    <i class="fa fa-pencil"></i> 
                                </a>
                                <button type="submit" class="formdel del_btn"><i class="fa fa-trash"></i></button>
                            {{ Form::close() }}
                        </td>
                        
                        </tr>                     
	                @endforeach
                  </tbody>
              </table>   

            </div><!-- .box-content -->
            
</div><!-- .box -->

</div><!-- .row-fluid -->

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