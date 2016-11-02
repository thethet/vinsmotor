@extends('layouts.fancy')
@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Add new supplier</h2>
                
            </div>
            <div class="box-content">
            
				{{ Form::open(array('url' => 'suppliers/fancycreate','id'=>'addsupplierform','class'=>'form-horizontal','method'=>'post')) }}
                {{ Form::hidden('fancy',1) }}
                    <fieldset>                      
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Supplier Name</label>
                        <div class="controls">
                          <input type="text" required name="supplier_name" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess" >Billing Address</label>
                        <div class="controls">
                           <input type="text" required name="billing_address" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Tel</label>
                        <div class="controls">
                           <input type="text" required name="tel" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Fax</label>
                        <div class="controls">
                           <input type="text" required name="fax" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="text" required name="email" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Website</label>
                        <div class="controls">
                           <input type="text" required name="website" id="inputSuccess">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      
                     <div class="control-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                           <textarea class="textarea" name="remarks"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                        <div class="left"><strong>Add</strong> <input type="number" class="number" value="1" id="addvalue"> Contact <input type="button" id="addcontact" class="btn btn-warning squarebutton" value="+"> <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected"></div>
                     <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                              	  <th><input type="checkbox" id="alldelete"></th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>Contact</th>                           
                              </tr>
                          </thead>   
                          <tbody id="contacttable">
                          <tr id="row0">
                          		<td><input type="checkbox" class="delbox" id="delete0"></td>
                                <td><input type="text" name="name0" placeholder="Enter contact name..."></td>
                                <td><input type="email" id="email0" name="email0" placeholder="Enter email..."></td>
                                <td><input type="text" id="contact0" name="contact0" placeholder="Enter contact number..."></td>
                          </tr>               
                          </tbody>
                     </table> 
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add supplier</button>
                        
                        <a href="{{ URL::to('suppliers') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                    <input type="hidden" name="cnt" id="cnt">
                  {{ Form::close() }}
            
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section ('script')
<script type="text/javascript">
var cnt = 1;
$("#addcontact").click(function(){
	for (var n = 0; n < $("#addvalue").val(); n++)
	{
		var buildHTML = '<tr id="row'+cnt+'"><td><div class="checker"><span><input type="checkbox" class="delbox" id="delete'+cnt+'"></span></div></td><td><input type="text" name="name'+cnt+'" placeholder="Enter contact name..."></td><td><input type="email" name="email'+cnt+'" id="email'+cnt+'" placeholder="Enter email..."></td><td><input type="text" name="contact'+cnt+'" id="contact'+cnt+'" placeholder="Enter contact number..."></td></tr>';
		$("#contacttable").append(buildHTML);
		template_functions();
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
	
		Boxy.confirm("Are you sure?", function() {
			for (var n = 0; n < cnt; n++)
			{
				if ($("#delete"+n).is(":checked"))
				{
					$("#email"+n).val("");
					$("#contact"+n).val("");
					$("#row"+n).fadeOut('fast');
				}
			}
			 
		}, {title: 'Confirm'});
		return false;
 
	
});
</script>
@stop