@extends('layouts.main')

@section('header')
    {{ HTML::style('css/jquery.fancybox.css'); }}
    <style type="text/css">
      .pimage span.filename{
        display: none;
      }
       .pimage span.action{
        display: none;
      }
    </style>
@stop
@section('content')
<style>
.download_btn{
  margin-left:100px;
}
body
{
font-family:arial;
}

#preview
{
color:#cc0000;
font-size:12px
}
.imgList 
{
max-height:150px;
margin-left:5px;
border:1px solid #dedede;
padding:4px;  
float:left; 
}

</style>
    <div class="row-fluid sortable">
        <div class="box span12">
	    <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> New product</h2></div>
            </div>
            <div class="box-content">
		<div class="row">
		    <div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'products/create','class'=>'form-horizontal','method'=>'post','id'=>'test','files' => true)) }}
                    <fieldset>     
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Code</label>
                         <div class="controls">
                          <input type="text" required name="itemno" id="inputSuccess" class="form-control"  autocomplete="off">
                          <span class="help-inline"><?php echo $errors->first('itemno'); ?></span>                          
                        </div>
                      </div>  
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Category</label>
                        <div class="controls">
                            <select name="pro_cat" required id="selectError1" data-rel="chosen" class="form-control cat"> 
                             <option value="0">None</option>
                             @foreach($product_category as $key => $value)
                                <option value="{{ $value->id }}"><pa>{{ $value->cat_name }}</option>
                              @endforeach 
                            </select>                            
                        </div>
                      </div>                                       
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Name</label>
                        <div class="controls">
			    <input type="text" required name="name" id="inputSuccess" class="form-control" autocomplete="off">
                          <span class="help-inline"></span>
                        </div>
                      </div>  
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Description</label>
                        <div class="controls">
                          <textarea name="description" id="inputSuccess" class="form-control"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>  
			
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess">Cost Price</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on"></span><input placeholder="0" required id="appendedPrependedInput" name="unit_price" size="16" type="number" min="0" class="unprice form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Selling price</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on"></span><input placeholder="0" required id="appendedPrependedInput" name="selling_price" size="16" type="text" class="sellprice form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                    <!-- <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Measurements (mm)</label>
                        <div class="controls">
			    <div class="col-md-4"> Width<input type="number" name="width" class="number form-control" min="0"></div><div class="col-md-4">Height <input type="number" name="height" class="number form-control" min="0"></div><div class="col-md-4"> Depth <input type="number" class="number form-control" name="depth" min="0"></div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Weight (kg)</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="weight" size="16" type="text" class="form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>-->
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Quantity</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="quantity" size="16" type="text" class="qty_val form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Min Product Quantity to inform</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="min_product_qty" size="16" type="text" value="1" class="minqty form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
			<div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company</label>
                        <div class="controls">
                            <select name="company" required data-rel="chosen" class="form-control">
                             <option value=" ">None</option>
                              @foreach($company as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->first_name }}</option>
                              @endforeach
                             
                            </select>
                           
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location</label>
                        <div class="controls">
                            <select name="store" required data-rel="chosen" class="form-control">
                             <option value=" ">None</option>
                              @foreach($store as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->store_name }}</option>
                              @endforeach
                             
                            </select>
                           
                        </div>
                      </div>
                     
                      <div class="form-group success">
                        <label class="control-label" for="selectError">Supplier</label>
                        <div class="controls">
                          <select name="supplier" required id="selectError" data-rel="chosen" class="form-control">
                             <option value="-1">None</option>
                             @foreach($suppliers as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                              @endforeach
                          </select>
                        
                        </div>
                      </div>  
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remark</label>
                        <div class="controls">
                          <textarea name="remark" id="inputSuccess" class="form-control"></textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>  
			 <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Image</label>
                          <div class="controls pimage"> 
                            <input type="file" name="photo" class="form-control"/> 
                        </div>
                      </div>
			
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Save</button>                        
                        <a href="{{ URL::to('products') }}"><input type="button" value="Cancel" class="btn"></a>
                      </div>
                    </fieldset>
                  {{ Form::close() }}
		    </div>
		</div>
		
            </div>
        </div><!--/span-->
    
    </div><!--/row-->
	<div class="row-fluid sortable">
        <!--  <div class="box span12">
            <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Improt product</h2></div>
            </div>
          <div class="box-content">
<div class="col-md-4 col-md-offset-4">
            <div>
		<br/>
              <ul>
                <li>Please download the template and follow the template column.</li>
                <li>Please do not delete header column in excel template</li>
                <li>Please fill every column value in sheet.</li>
                <li>Please add at least two rows of product. </li>
                <li>Please make sure product code are unique.</li>
              </ul>
              <hr>
               @if(Session::get('exist_record') == 1)
                {{ "<h4>Some is wrong</h4>"}}
                @endif
            </div>
            
	    {{ Form::open(array('url' => 'products/import','class'=>'form-horizontal','method'=>'post','files' => true)) }}
                <fieldset> 
                 
                 <div class="form-group success">
                    <label class="control-label" for="selectError">File</label>
                    <div class="controls">
                      <input name="file" type="file" required class="form-control">
                    </div>
                    <!--<input type='file' name="products" required/>-->
                 <!-- </div>
                  <div class="form-group form-actions">
                    <button type="submit" class="btn btn-primary">Import Products</button>
                    
                    <a href="{{ URL::to('products') }}"><input type="button" value="Cancel" class="btn"></a>
                    <a href="{{ URL::to('images/template.xlsx') }}" target="_blank" class="download_btn"><input type="button" value="Download Sheet" class="btn btn-info"></a>
                  </div>
                </fieldset>
            {{ Form::close() }}
	    </div>
            </div>
            
        </div><!--/span-->
    
    </div><!--/row-->		
			
    
@stop

@section('script')

    {{ HTML::script('js/jquery.mousewheel-3.0.6.pack.js') }}
    {{ HTML::script('js/jquery.wallform.js') }} 
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

      /**********************************/
    $(".qty_val").on("input", function(){
       number_only(this);
    });    

    $(".minqty").on("input", function(){
       number_only(this);
    }); 

    $(".unprice").on("input", function(){
       number_only(this);
    }); 

    $(".sellprice").on("input", function(){
       number_only(this);
    });

    /******************************/

    $("#test").submit(function(e){
      
      var product_cat = $(".cat").val();
      if (product_cat == "0") {
        e.preventDefault();
        alert('Please choose the product category');
      }

    });
    
});


    function number_only($this){
    var numbers = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    var value = $($this).val();
    var total = value.length;
    var ans = numbers.indexOf(value.slice(total-1, total));
    if(ans=="-1"){
        $($this).val(value.slice(0, total-1));
      }
    }



		
	</script>
@stop