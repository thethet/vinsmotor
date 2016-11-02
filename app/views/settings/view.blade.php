@section('header')
{{HTML::style('css/chosen.min.css')}}
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  
@stop
@section('content')  

    <div class="row-fluid sortable">
        <div class="box span12">
             <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-gear"></i> Setting</h2></div>
            </div>
            <div class="box-content">
		<div class="col-md-6 col-md-offset-3">
          {{ Form::open(array('class'=>'form-horizontal style-form','method'=>'post','url'=>'settings')) }}
              <div class="form-group">
                  <label class="col-sm-3 control-label">Website Title</label>
                  <div class="col-sm-4">
                      <input type="text" name="name" value="{{ $settings->name }}" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Top Menu Color</label>
                  <div class="col-sm-4">
                      <input type="text" name="menu_color" value="{{ $settings->menu_color }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Button Main Color</label>
                  <div class="col-sm-4">
                      <input type="text" name="button_main" value="{{ $settings->button_color }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Button Hover Color</label>
                  <div class="col-sm-4">
                      <input type="text" name="button_hover" value="{{ $settings->button_hover }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Sidebar Main Color</label>
                  <div class="col-sm-4">
                      <input type="text" name="sidemenu_main" value="{{ $settings->sidemenu_color }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label">Sidebar Hover Color</label>
                  <div class="col-sm-4">
                      <input type="text" name="sidemenu_hover" value="{{ $settings->sidemenu_hover }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
             
              <div class="form-group">
                  <label class="col-sm-3 control-label">Version</label>
                  <div class="col-sm-4">
                      <input type="text" name="version" value="{{ $settings->version }}" id="colorSelector" class="form-control">
                      <span class="help-block"></span>
                  </div>
              </div>
	      <div class="form-group">
		  <label class="col-sm-3 control-label"></label>
		    <input type="submit" class="btn btn-primary" value="Save">
		     <a href="{{ URL::to('main') }}"><input type="button" class="btn btn-warning" value="Back"></a>
              </div>
          {{ Form::close() }}
		</div>
	    </div>
        </div>
        </div><!--/span-->
    
    </div><!--/row-->
			
			
    
@stop

