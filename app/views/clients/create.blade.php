@extends('layouts.main')
@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
@stop
@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> New client</h2></div>
            </div>
            <div class="box-content">   
		<div class="row">
		<div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'clients/create','class'=>'form-horizontal','method'=>'post')) }}
                    <fieldset>    
                    <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company</label>
                        <div class="controls">
                          <input type="text" required name="organization" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                    <div class="form-group success">
                        <label class="control-label" for="selectError">Salutation</label>
                        <div class="controls">
                          <select name="salutation" required class="form-control">
                             <option value="Dr.">Dr.</option>
                             <option value="Miss">Miss.</option>
                             <option value="Ms.">Ms.</option>
                             <option value="Mr.">Mr.</option>
                             <option value="Mrs.">Mrs.</option>
                             <option value="M/S.">M/S.</option>
                          </select>                          
                        </div>
                      </div>                  
                      
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required name="first_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     
                    
			
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                           <input type="number" required name="mobile_contact" id="mobilecontact" min="0" class="form-control">
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
                        <label class="control-label" for="inputSuccess" required>Billing Address</label>
                        <div class="controls">
			    <textarea name="billing_address" id="inputSuccess" class="form-control"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Delivery Address</label>
                        <div class="controls">
			    <textarea name="delivery_address" id="inputSuccess" class="form-control"></textarea>
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
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
                        
                        <a href="{{ URL::to('clients') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		</div>
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section ('script')
{{ HTML::script('js/jquery.mousewheel-3.0.6.pack.js') }} 
<script>
$('.fancybox').fancybox({
    href : "{{ URL::to ('middlemen/fancycreate') }}",
    type : 'iframe',
    width: 900,
    height: 800,
    'autoScale'     :   false,
    beforeClose: function() {
      // working
      var $iframe = $('.fancybox-iframe');
      var tmp = $('input', $iframe.contents()).val();
      tmp = tmp.split(";");
      $("#selectError").append($("<option></option>")
               .attr("value",tmp[0])
               .text(tmp[1])); 
               $("#selectError").trigger("liszt:updated");
               
      $("#selectError").val(tmp[0]).trigger("chosen:updated");
    }
});
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