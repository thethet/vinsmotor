@extends('layouts.main')
@section('header')

    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
    <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-gear"></i> Edit company profile</h2></div>
            </div>
            <div class="box-content">
		<div class="row">
                <div class="col-md-4 col-md-offset-4">
		    {{ Form::open(array('url' => 'profile','class'=>'form-horizontal','method'=>'post','files'=> true)) }}
                    <fieldset>                      
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company Name</label>
                        <div class="controls">
                          <input type="text" value="{{ $profile->company_name }}" required name="name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company Logo</label>
                        <div class="controls">
                     	  {{ HTML::image('images/stocks_logo.png') }}
			    <input class="input-file uniform_on" name="logo" id="fileInput" type="file" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Registration No.</label>
                        <div class="controls">
                          
                          <input type="text" value="{{ $profile->registration_no }}" required name="regno" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company Header</label>
                        <div class="controls">                         
			    <textarea class="cleditor form-control" name="header" id="textarea2" rows="3">{{ $profile->header }}</textarea>
                        </div>
                      </div>
                      <h2>Invoice Footer</h2>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="remarks" id="textarea2" rows="3">{{ $profile->remarks }}</textarea>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Terms & Conditions</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="terms" id="textarea2" rows="3">{{ $profile->terms }}</textarea>
                        </div>
                      </div>
                      <h2>Purchase Order Footer</h2>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="remarks2" id="textarea2" rows="3">{{ $profile->remarks2 }}</textarea>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Terms & Conditions</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="terms2" id="textarea2" rows="3">{{ $profile->terms2 }}</textarea>
                        </div>
                      </div>
                      <h2>Delivery Order Footer</h2>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="remarks3" id="textarea2" rows="3">{{ $profile->remarks3 }}</textarea>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Terms & Conditions</label>
                        <div class="controls">
                          <textarea class="cleditor form-control" name="terms3" id="textarea2" rows="3">{{ $profile->terms3 }}</textarea>
                        </div>
                      </div>
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>
			<a href="{{ URL::to('main') }}"><input type="button" class="btn btn-warning" value="Back"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
                </div>
		</div>
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

@section('script')

    {{ HTML::script('js/jquery.mousewheel-3.0.6.pack.js') }}

	<script type="text/javascript">
		$(document).ready(function() {

			$('.fancybox').fancybox({
					href : "{{ URL::to ('suppliers/fancycreate') }}",
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


		});
	</script>
@stop