@extends('layouts.main')@section('content') 
 <div class="row-fluid sortable"> 
 <div class="box span12">  
 <div class="box-header row">   
 <div class="col-md-6">   
 <h2 class="page_header"><i class="fa fa-user"></i> Edit supplier</h2>       
 </div>  
 </div>  
 <div class="box-content">  
 <div class="row">      
 <div class="col-md-6 col-md-offset-3">  
 {{ Form::open(array('url' => 'suppliers/edit','id'=>'addsupplierform','class'=>'form-horizontal','method'=>'post')) }} 
 {{ Form::hidden('id',$supplier->id) }} 
 <fieldset>                
 <div class="row">                 
 <div class="col-md-5">    
 <div class="form-group success">           
 <label class="control-label" for="inputSuccess">Supplier Name</label>   
 <div class="controls"> 
 <input type="text" value="{{ $supplier->supplier_name }}" required name="supplier_name" id="inputSuccess" class="form-control"><span class="help-inline"></span> 
 </div>                    
 </div>                  
 <div class="form-group success">      
 <label class="control-label" for="inputSuccess" >Delivery Address</label>                      <div class="controls">                        
 <textarea required name="delivery_address" id="inputSuccess" class="form-control">
 {{ $supplier->delivery_address }}</textarea>  
 <span class="help-inline"></span> 
 </div>                  
 </div>                  
 <div class="form-group success"> 
 <label class="control-label" for="inputSuccess" >Billing Address</label>                      <div class="controls">                       
 <textarea required name="billing_address" id="inputSuccess" class="form-control">{{ $supplier->billing_address }}</textarea>     
 <span class="help-inline"></span>  
 </div>  
 </div>   
 <div class="form-group success">          
 <label class="control-label" for="inputSuccess">Office Number</label>      
 <div class="controls">      
 <input type="text" value="{{ $supplier->tel }}" required name="tel" id="inputSuccess" class="form-control"><span class="help-inline"></span>                    
 </div>                  
 </div>                    
 <div class="form-group success">   
 <label class="control-label" for="inputSuccess">Mobile Number</label>        
 <div class="controls">          
 <input type="text" value="{{ $supplier->mobile }}" required name="mobile" id="inputSuccess" class="form-control"> 
 <span class="help-inline"></span>  
 </div>                 
 </div>     
 <div class="form-group success">   
 <label class="control-label" for="inputSuccess">Fax</label>    
 <div class="controls"> 
 <input type="text" value="{{ $supplier->fax }}" required name="fax" id="inputSuccess" class="form-control"> 
 <span class="help-inline"></span>   
 </div>         
 </div>        
 <div class="form-group success">   
 <label class="control-label" for="inputSuccess">Email</label>      
 <div class="controls">        
 <input type="text" value="{{ $supplier->email }}" required name="mail" id="inputSuccess" class="form-control">   
 <span class="help-inline"></span>  
 </div>    
 </div>     
 <div class="form-group success">     
 <label class="control-label" for="inputSuccess">Website</label> 
 <div class="controls">     
 <input type="text" value="{{ $supplier->website }}"  name="website" id="inputSuccess" class="form-control">   
 <span class="help-inline"></span>    
 </div>      
 </div>     
 <div class="form-group success"> 
 <label class="control-label" for="inputSuccess">Remarks</label>     
 <div class="controls">              
 <textarea class="textarea form-control" name="remarks">{{ $supplier->remarks }}</textarea>     <span class="help-inline"></span>
 </div>      
 </div>        
 </div>    
 </div>     
 <div class="left">  
 <div class="col-md-1"> 
 <strong>Add</strong>     
 </div>   
 <div class="col-md-2">  
 <input type="number" class="number form-control" value="1" id="addvalue">                  </div>      
 Contact              
 <input type="button" id="addcontact" class="btn btn-warning squarebutton" value="+">          <input type="button" id="bulkdelete" class="btn btn-danger squarebutton" value="Delete Selected">  
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
 <?php                      $cnt = 1;            
 $contacts = DB::table('supplier_contacts')->where('supplier_id','=',$id)->get();                    ?>                   
 @foreach ($contacts as $k=>$v)                 
 <tr id="row{{ $cnt }}">   
 <td>        
 <input type="checkbox" class="delbox" id="delete{{ $cnt }}">
 </td>           
 <td>     
 <input type="text" value="{{ $v->name }}" name="name[]" placeholder="Enter contact name..." class="form-control">      
 </td>           
 <td>    
 <input type="email" value="{{ $v->email }}" name="email[]" id="email{{ $cnt }}" placeholder="Enter email..." class="form-control">           
 </td>   
 <td>  
 <input type="number" min="0" value="{{ $v->contact }}" class="form-control" name="contact[] $cnt }}" id="contact{{ $cnt++ }}" placeholder="Enter contact number...">                    
 </td>                     
 </tr>                  
 @endforeach             
 </tbody>   
 </table>            
 <div class="form-actions">    
 <button type="submit" class="btn btn-primary">Update</button> 
 <a href="{{ URL::to('suppliers') }}">
 <input type="button" value="Cancel" class="btn"></a> 
 </div>      
 </fieldset>      
 {{ Form::hidden('cnt',$cnt,array('id'=>'cnt')) }}   
 {{ Form::close() }}   
 </div>    
 </div>   
 </div>   
 </div>
 <!--/span--> 
 </div><!--/row-->
 @stop
 @section ('script')
 <script type="text/javascript">  

// var cnt = $("#cnt").val();  
var cnt = document.getElementsByClassName('delbox').length + 1;
 $("#addcontact").click(function(){ 
 for (var n = 0; n < $("#addvalue").val(); n++) {    
 var buildHTML = '<tr id="row'+cnt+'"><td><input type="checkbox" class="delbox" id="delete'+cnt+		  '"></td><td><input type="text" name="name[]" placeholder="Enter contact name..." 	class="form-control">		</td><td><input type="email" name="email[]" placeholder="Enter email..." class="form-control"></td><td><input type="text" name="contact[]" placeholder="Enter contact number..." class="form-control"></td></tr>';        
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
		}      else      {
        $(".delbox").prop("checked",false);  
		$.uniform.update(".delbox");      } 
});   
$("#bulkdelete").click(function(){ 
	if($( ".delbox:checked" ).length > 0){	
	Boxy.confirm("Are you sure?", function() { 
		for (var n = 1; n <= cnt; n++)     
		{ 
			if ($("#delete"+n).is(":checked")) 
			{
				$("#email"+n).val(""); 
				$("#contact"+n).val("");  
				$("#row"+n).remove();  
				
			}    
		} 
		cnt = document.getElementsByClassName('delbox').length;
		},
			{title: 'Confirm'});  
			return false;   
	}else{
	alert("Please check the box that you want to delete!");
	}
}); 
 </script>
 @stop