@extends('layouts.main')

@section('content')
    
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> View staff</h2></div>
            </div>
            <div class="box-content">
            		<table class="table table-striped">
                    <tr>
                    	<td class="col-md-2"> <strong>Staff Name</strong></td><td>{{ $staff->name }}</td>
                     </tr>
                     <tr>
                        <td> <strong>Contact</strong></td><td>{{ $staff->contact }}</td>
                      </tr>
                       
                     <tr>
                      <td> <strong>Email</strong></td><td>{{ $staff->email }}</td>
                     </tr>
                     <tr>
                        <td> <strong>Address</strong></td><td>{{ $staff->address }}</td>
                     </tr>
                    <tr>
                        <td> <strong>Remarks</strong></td><td>{{ $staff->remarks }}</td>
                    </tr>
                    </table>
                    <fieldset>                  
                      
                    
                        
                        
                        <a href="{{ URL::to('staffs') }}"><input type="button" value="Back" class="btn"></a>
                      </div>
                    </fieldset>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop