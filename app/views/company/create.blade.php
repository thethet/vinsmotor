@extends('layouts.main')

@section('header')
  <style type="text/css">
      .company-image span.filename{
        display: none;
      }
       .company-image span.action{
        display: none;
      }
    </style>
@stop


@section('content')
      <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> New Company</h2></div>
            </div>
            <div class="box-content">            
		  <div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'company/create','class'=>'form-horizontal','method'=>'post','files' => true)) }}
                    <fieldset>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required name="first_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>                      

                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Registration No.</label>
                        <div class="controls">
                          <input type="text" required name="reg_no" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                           <input type="number" required name="mobile_contact" id="mobilecontact" class="form-control mobilecontact">
                          <span class="help-inline" id="mobilehelp"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" required name="email" id="email" class="form-control">
                          <span class="help-inline" id="emailhelp"></span>
                        </div>
                      </div>
                     
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Address</label>
                        <div class="controls">
			    <textarea required name="address" id="inputSuccess" class="form-control"></textarea>
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
                     <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Logo</label>
                          <div class="controls company-image"> 
                            <input type="file" name="photo" class="form-control"/> 
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                        
                        <a href="{{ URL::to('company') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		  </div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section ('script')

<script type="text/javascript">

$(document).ready(function(){ 

    $(".mobilecontact").on("input", function(){
       number_only(this);
    });

});

function number_only($this){
  var numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "+"];
  var value = $($this).val();
  var total = value.length;
  var ans = numbers.indexOf(value.slice(total-1, total));
  if(ans=="-1"){
    $($this).val(value.slice(0, total-1));
  }
}

/*
$("form").submit(function(){
	if ($("#homecontact").val() != "")
	{
		if (isNaN($("#homecontact").val()))
		{
			return false;
		}
	}
	if ($("#mobilecontact").val() != "")
	{
		if (isNaN($("#mobilecontact").val()))
		{
			return false;
		}
	}
});*/


</script>
@stop