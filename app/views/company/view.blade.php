@extends('layouts.main')

@section('content')
       <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> View Company</h2></div>
            </div>
            <div class="box-content">
            		<table class="table table-striped">
                    <tr>
                    	<td class="col-md-2"> <strong>Name</strong></td><td>{{ $middlemen->first_name }}</td>
                     </tr>
                     <tr>
                        <td> <strong>Contact</strong></td><td>{{ $middlemen->mobile_contact }}</td>
                       </tr>
                     <tr>
                      <td> <strong>Email</strong></td><td>{{ $middlemen->email }}</td>
                     </tr>
                     <tr>
                        <td> <strong>Address</strong></td><td>{{ $middlemen->address }}</td>
                     </tr>
                    <tr>
                        <td> <strong>Remarks</strong></td><td>{{ $middlemen->remarks }}</td>
                    </tr>
		    <tr>
                        <td><strong>Logo</strong></td><td><?php if($middlemen->photo == ""){ echo "&nbsp;"; } else{ ?><img src="<?php echo '../../bootstrap/img/'.$middlemen->photo; ?>" style="max-width:300px"/><?php }  ?></td>
                    </tr>
                    </table>
                    <fieldset> 
                        <a href="{{ URL::to('company') }}"><input type="button" value="Back" class="btn"></a>
                      </div>
                   </fieldset>
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop