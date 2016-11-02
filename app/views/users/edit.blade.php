@extends('layouts.main')

@section('content')
    <!-- <ul class="breadcrumb">
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
        	<a href="{{ URL::to('/users/create') }}">Edit Users</a> 
        </li>
    </ul> -->
    
   

    <div class="row-fluid sortable">
        <div class="box span12">
            
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-house"></i> Edit user</h2></div>
            </div>

            <div class="box-content">

            @if ($errors->has())
                <div class="col-md-12">
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
                </div>
            @endif

            @if (Session::has('message'))
              <div class="col-md-12">
                <div class="alert alert-danger">{{ Session::get('message') }}</div>
              </div>
            @endif

            
				{{ Form::open(array('url' => 'users/edit','class'=>'form-horizontal','method'=>'post')) }}
                	{{ Form::hidden('id',$user->id) }}
                    <fieldset>                      
                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">First Name</label>
                        <div class="controls">
                          <input type="text" value="{{ $user->first_name }}" required name="first_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Last Name</label>
                        <div class="controls">
                          <input type="text" value="{{ $user->last_name }}"  required name="last_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                          <input type="text" value="{{ $user->email }}"  required name="email" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Password</label>
                        <div class="controls">
                          <input type="password" name="password" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Confirm Password</label>
                        <div class="controls">
                          <input type="password" name="cfm_password" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                          <div class="col-md-4">
                          <label class="control-label" for="date01">Date of Birth</label>
                          <div class="controls">
                            <input type="date" value="{{ $user->dob }}"  required name="dob"  id="date01" value="02/16/12" class="form-control">
                          </div>
                          </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Address</label>
                        <div class="controls">
                          <input type="text" value="{{ $user->address }}"   required name="address" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->


                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                          <input type="text" value="{{ $user->contact }}"  required name="contact" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                        </div>
                      </div><!-- .control-group -->

                      <div class="row control-group success">
                        <div class="col-md-4">
                        <label class="control-label" for="selectError">User Roles</label>
                        <div class="controls">
                          <select name="user_role" required id="selectError" data-rel="chosen" class="form-control">
                             @foreach($user_roles as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                              @endforeach
                          </select>
                          <!-- <a class="btn btn-success" href="#">
                            <i class="halflings-icon white plus"></i>
                       	  </a> -->
                        </div>
                        </div>
                      </div><!-- .control-group -->

                     
                      <div class="form-actions" style="margin-top:30px;">
                        <button type="submit" class="btn btn-primary">Edit User</button>
                        <a href="{{ URL::to('users') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>

                    </fieldset>
                  {{ Form::close() }}
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop