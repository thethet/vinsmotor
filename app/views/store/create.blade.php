@extends('layouts.main')
@section('header')

    {{ HTML::style('css/jquery.fancybox.css'); }}
@stop
@section('content')
<style>
.download_btn{
  margin-left:100px;
}
</style>
    <div class="row-fluid sortable">
        <div class="box span12">
             <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-house"></i> New Location</h2></div>
            </div>
            <div class="box-content">
		<div class="row">
		    <div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'store/create','class'=>'form-horizontal','method'=>'post','id'=>'test')) }}
                    <fieldset>     
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Name</label>
                         <div class="controls">
                          <input type="text" required name="store_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"><?php echo $errors->first('store_name'); ?></span>                          
                        </div>
                      </div> 
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Type</label>
                         <div class="controls">
                          <?php $store_type = StoreTypeEntry::all(); ?>
                          <select data-rel="chosen" id="selectError" name="store_type" required class="form-control store_type">
                            <option value="0">Choose location type</option>
                              @foreach($store_type as $key => $value)
                                <option value={{ $value->id }}>{{ $value->store_type }}</option>
                              @endforeach
                          </select>                     
                        </div>
                      </div> 
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Description</label>
                         <div class="controls">
                          <textarea name="store_description" id="inputSuccess" class="form-control"> </textarea>                     
                        </div>
                      </div> 
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location Address</label>
                         <div class="controls">
                          <textarea required name="store_address" id="inputSuccess" class="form-control"></textarea>                      
                        </div>
                      </div>   
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remark</label>
                         <div class="controls">
                          <textarea name="remark" id="inputSuccess" class="form-control"> </textarea>                     
                        </div>
                      </div>                           
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Create Location</button>                        
                        <a href="{{ URL::to('store') }}"><input type="button" value="Cancel" class="btn"></a>
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
    href : "{{ URL::to ('store_type/fancycreate') }}",
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



/******************************/
$(document).ready(function(){

    $("#test").submit(function(e){
      
      var store_type = $(".store_type").val();
      if (store_type == "0") {
        e.preventDefault();
        alert('Please choose the location type.');
      }

    });

});



</script>
@stop