@extends('layouts.main')

@section('content')
    <ul class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ URL::to('/main') }}">Home</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/users') }}">Users</a> 
            <i class="icon-angle-right"></i>
        </li>
        <li> 
        	<a href="{{ URL::to('/users/roles') }}">Edit User Roles</a> 
        </li>
    </ul>
    <div class="row-fluid sortable">	
        <div class="box span12">
            <div class="box-header">
                <h2><i class="halflings-icon white align-justify"></i><span class="break"></span>Edit User Roles</h2>
            </div>
            <div class="box-content">
                <table class="table table-bordered table-striped">
                      <thead>
                          <tr>
                              <th>Role Name</th>
                              <th>Clients</th>
                              <th>Products</th>
                              <th>Suppliers</th>
                              <th>Invoices</th>
                              <th>Purchase Orders</th>
                              <th>Delivery Orders</th> 
                              <th>Company Profile</th>
                              <th>Actions</th>                                             
                          </tr>
                      </thead>   
                      <tbody>
                        <tr class="smallfont">
                            <td><input type="text" class="onefiftypx"></td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                        	<td><input type="checkbox"> Create<br><input type="checkbox"> Read<br><input type="checkbox"> Edit<br><input type="checkbox"> Delete</td>
                            <td class="center">
                            	<button type="submit" class="btn btn-warning">
                                	<i class="halflings-icon white ok"></i> 
                                </button>
                            	<br><button class="btn btn-warning">
                                	<i class="halflings-icon white ok"></i> 
                                </button>
                            	<br><input type="button" value="Unselect All" class="btn btn-danger">
                            </td>
                        </tr>
                      
                        @foreach($user_roles as $key=>$value)
                        	<tr class="smallfont">
                            <td>{{ $value->name }}</td>
                            <td class="center"><input type="checkbox" checked disabled></td>
                            <td class="center"><input type="checkbox" checked disabled></td>
                            <td class="center"><input type="checkbox" checked disabled></td>  
                            <td class="center"><input type="checkbox" checked disabled></td>
                            <td class="center"><input type="checkbox" checked disabled></td> 
                            <td class="center"> 
                                <a class="btn btn-info" href="#">
                                    <i class="halflings-icon white edit"></i>  
                                </a>
                                {{ Form::open(array('action' => 'UsersController@delete_user_role')) }}
                                {{ Form::hidden('id',$value->id) }}
                                <a class="btn btn-danger" href="#">
                                    <i class="halflings-icon white trash"></i> 
                                </a>
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