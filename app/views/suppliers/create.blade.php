@extends('layouts.main')
@section('content')  
<div class="row-fluid sortable">    
<div class="box span12">      
	<div class="box-header row">        
		<div class="col-md-6">          
		<h2 class="page_header"><i class="fa fa-house"></i> New supplier</h2>        
		</div>      
	</div>	    
{{ Form::open(array('url' => 'suppliers/create','id'=>'addsupplierform','class'=>'form-horizontal','method'=>'post')) }}        
<div class="box-content">		      
<div class="row">			      
<div class="col-md-6 col-md-offset-3">      				
<div class="row">					      
<div class="col-md-6">                  
<fieldset>                    
<div class="form-group success">                     
 <label class="control-label" for="inputSuccess">Supplier Name</label>                      
 <div class="controls">                        
 <input type="text" required name="supplier_name" id="inputSuccess" class="form-control">                        
 <span class="help-inline">                          
 @if (Session::get('error') == 1)                          	
 Supplier already exists!                         
  @endif                        
  </span>                      
  </div>                    
  </div>                    
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess" >Delivery Address</label>                      
  <div class="controls">                        
  <textarea required name="delivery_address" id="inputSuccess" class="form-control"></textarea>                        
  <span class="help-inline"></span>                     
  </div>                    
  </div>                    
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess" >Billing Address</label>                      
  <div class="controls">                        
  <textarea required name="billing_address" id="inputSuccess" class="form-control"></textarea>                        
  <span class="help-inline"></span>                      
  </div>                    
  </div>                    
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess">Office Number</label>                      
  <div class="controls">                        
  <input type="number" required name="tel" id="inputSuccess" class="form-control">                        
  <span class="help-inline"></span>                      
  </div>                    
  </div>				            
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess">Mobile Number</label>                      
  <div class="controls">                        
  <input type="number" required name="mobile" id="inputSuccess" class="form-control">                        
  <span class="help-inline"></span>                      
  </div>                    
  </div>                    
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess">Fax</label>                      
  <div class="controls">                        
  <input type="number" required name="fax" id="inputSuccess" class="form-control">                        
  <span class="help-inline"></span>                      
  </div>                    
  </div>                    
  <div class="form-group success">                      
  <label class="control-label" for="inputSuccess">Email</label>                     
   <div class="controls">                        
   <input type="email" required name="email" id="inputSuccess" class="form-control">                       
    <span class="help-inline"></span>                      
    </div>                    
    </div>                    
    <div class="form-group success">                      
    <label class="control-label" for="inputSuccess">Website</label>                      
    <div class="controls">                        
    <input type="text" name="website" id="inputSuccess" class="form-control">                        
    <span class="help-inline"></span>                     
     </div>                    
     </div>                    
     <div class="form-group success">                     
      <label class="control-label" for="inputSuccess">Remarks</label>                      
      <div class="controls">                        
      <textarea class="textarea form-control" name="remarks"></textarea>                        
      <span class="help-inline"></span>                      
      </div>                    
      </div>                  
      </fieldset>		            
      </div>		          
      </div>		          
      <div class="left">                
      <div class="col-md-1">                  
      <strong>Add</strong>                
      </div>                
      <div class="col-md-2">                 
      <input type="number" class="number form-control" value="1" id="addvalue">                
      </div>                
      Contact                
      <input type="button" id="addcontact" class="btn btn-warning squarebutton" value="+">                
      <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected">              
      </div>              
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
      <td><input type="text" name="name[]" placeholder="Enter contact name..." class="form-control"></td>                    
      <td><input type="email" id="email0" name="mail[]" placeholder="Enter email..." class="form-control"></td>                    
      <td><input type="number" min="0" id="contact0" name="contact[]" placeholder="Enter contact number..." class="form-control"></td>                  
      </tr>                
      </tbody>              
      </table>              
      <div class="form-actions">                
      <button type="submit" class="btn btn-primary">Save</button>                
      <a href="{{ URL::to('suppliers') }}">
      <input type="button" value="Cancel" class="btn"></a></div>              
      <input type="hidden" name="cnt" id="cnt">            
      </div>          
      </div>        
      </div>      
      {{ Form::close() }}    
      </div><!--/span-->  
      </div><!--/row-->
      @stop

      @section ('script')
      
      <script type="text/javascript">

var cnt = 1;

$("#addcontact").click(function(){

	for (var n = 0; n < $("#addvalue").val(); n++)

	{

		var buildHTML = '<tr id="row'+cnt+'"><td><div class="checker"><span><input type="checkbox" class="delbox" id="delete'+cnt+'"></span></div></td><td><input type="text" name="name[]" placeholder="Enter contact name..." class="form-control"></td><td><input type="email" name="mail[]" id="email'+cnt+'" placeholder="Enter email..." class="form-control"></td><td><input type="text" name="contact[]" id="contact'+cnt+'" placeholder="Enter contact number..." class="form-control"></td></tr>';

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
	if($( ".delbox:checked" ).length > 0){		
				Boxy.confirm("Are you sure?", function() {

					for (var n = 0; n < cnt; n++)

					{

						if ($("#delete"+n).is(":checked"))

						{

							$("#email"+n).val("");

							$("#contact"+n).val("");

							$("#row"+n).remove();
							

						}

					}
					
					cnt = document.getElementsByClassName('delbox').length;

					 

				}, {title: 'Confirm'});

				return false;

	}else{
	alert("Please check the box that you want to delete!");
	}	

});


</script>
        @stop