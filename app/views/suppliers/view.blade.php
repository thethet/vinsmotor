@extends('layouts.main')

@section('content')
    

    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row" data-original-title>
                 <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> View supplier</h2></div>
            </div>
            <div class="box-content">
            		<table class="table table-striped">
                    	<tr>
                        	<td class="col-md-2"><b>Supplier Name</b></td><td>{{ $supplier->supplier_name }}</td>
                        </tr>
                        <tr>
                        	<td><b>Billing Address</b></td><td>{{ $supplier->billing_address }}</td>
                        </tr>
                        <tr>
                        	<td><b>Tel</b></td><td>{{ $supplier->tel }}</td>
                        </tr>
                        <tr>
                          <td><b>Fax</b></td><td>{{ $supplier->fax }}</td>
                        </tr>
                        <tr>
                          <td><b>Email</b></td><td>{{ $supplier->email }}</td>
                        </tr>
                        <tr>
                          <td><b>Website</b></td><td>{{ $supplier->website }}</td>
                        </tr>
                        <tr>
                        	<td><b>Remarks</b></td><td>{{ $supplier->remarks }}</td>
                        </tr>
                    </table>
                       <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Contact</th>                           
                              </tr>
                          </thead>   
                          <tbody id="contacttable">
                           <?php $cnt = 1; $contacts = DB::table('supplier_contacts')->where('supplier_id','=',$id)->get(); ?>
                            @foreach ($contacts as $k=>$v)
                                
                          <tr id="row{{ $cnt }}">
                                        <td>{{ $v->name }}</td>
                                        <td>{{ $v->email }}</td>
                                        <td>{{ $v->contact }}</td>
                                  </tr>  
                            @endforeach
                                      
                          </tbody>
                     </table> 
                                        
                        
                      <div class="form-actions">
                        
                        <a href="{{ URL::to('suppliers') }}"><input type="button" value="Back" class="btn"></a>
                      </div>
                     
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section ('script')
<script type="text/javascript">
var cnt = $("#cnt").val();
$("#addcontact").click(function(){
	for (var n = 0; n < $("#addvalue").val(); n++)
	{
		var buildHTML = '<tr><td><input type="checkbox" class="delbox" id="delete'+cnt+'"></td><td><input type="text" name="name'+cnt+'" placeholder="Enter contact name..."></td><td><input type="email" name="email'+cnt+'" placeholder="Enter email..."></td><td><input type="text" name="contact'+cnt+'" placeholder="Enter contact number..."></td></tr>';
		$("#contacttable").append(buildHTML);
		cnt++;
	}
});
$("#addsupplierform").submit(function(){
	$("#cnt").val(cnt);
});
$("#alldelete").click(function(){
	if (this.checked)
	{
		$(".delbox").prop("checked",true);
		$.uniform.update(".delbox");

	}
	else
	{
		$(".delbox").prop("checked",false);
		$.uniform.update(".delbox");
	}
});
$("#bulkdelete").click(function(){
	for (var n = 0; n < cnt; n++)
	{
		if ($("#delete"+n).is(":checked"))
		{
			$("#email"+n).val("");
			$("#contact"+n).val("");
			$("#row"+n).fadeOut('fast');
		}
	}
});
</script>
@stop