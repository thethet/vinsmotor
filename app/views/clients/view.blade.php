@extends('layouts.main')

@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> View Client</h2></div>
            </div>
            <div class="box-content">
            	<table class="table table-bordered">
		    <tbody>
                    <tr>
                    <td class="col-md-2"> <strong>Client Name</strong></td><td>{{ $client->salutation." ".$client->first_name." ".$client->last_name }}</td>
                    </tr>
                    <tr>
                    <td > <strong>Company</strong></td><td>{{ $client->organization }}</td>
                    </tr>
                    <tr>
                    <td> <strong>Mobile Contact</strong></td><td>{{ $client->mobile_contact }}</td>
                    </tr>
                    <tr>
                      <td> <strong>Email</strong></td><td>{{ $client->email }}</td>
                     </tr>
                     
                     <tr>
                        <td> <strong>Billing Address</strong></td><td>{{ $client->billing_address }}</td>
                     </tr>
                     <tr>
                        <td> <strong>Delivery Address</strong></td><td>{{ $client->delivery_address }}</td>
                    </tr>
                    
                    <tr>
                        <td> <strong>Remarks</strong></td><td>{{ $client->remarks }}</td>
                    </tr>
		    </tbody>
                    </table>
		
                    <fieldset>                  
                     <br/> 
                        <a href="{{ URL::to('clients') }}"><input type="button" value="Back" class="btn"></a>
                     
                    </fieldset>
		 </div>
            </div>
        </div><!--/span-->
 
@stop