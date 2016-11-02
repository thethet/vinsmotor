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
    <div class="row-fluid sortable">
        <div class="box span12">
           <div class="box-header row">
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-cube"></i> Edit product</h2></div>
            </div>
	  
		<div class="box-content">  
		    <div class="row">
		      <div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'products/edit','class'=>'form-horizontal','method'=>'post','files' => true)) }}
		<?php
		if (!isset($quotationid))
		$quotationid = -1;
		?>
		    <input type="hidden" value="{{$quotationid}}" name="quotationid">
		    <input type="hidden" value="{{ $product->id }}" name="id"/>
                    <fieldset>    
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Code</label>
                        <div class="controls">
                          <input type="text" value="{{{ $product->product_itemno }}}" required name="itemno" id="inputSuccess" class="form-control"> {{  $errors->first('itemno');}}
                          <span class="help-inline"></span>
                        </div>
                      </div>  
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Category</label>
                        <div class="controls">
                            <select name="pro_cat" required id="selectError1" data-rel="chosen" class="form-control">
                             <!-- <option value=" ">None</option> -->
                             @foreach($product_category as $key => $value)
                                <option value="{{ $value->id }}" <?php if($product->product_catid == $value->id){ echo "selected"; } ?>>{{ $value->cat_name }}</option>
                              @endforeach 
                            </select>
                            
                        </div>
                      </div>                
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Name</label>
                        <div class="controls">
                          <input type="text" value="{{{ $product->product_name }}}" required name="name" id="inputSuccess" class="form-control"> {{  $errors->first('name');}}
                          <span class="help-inline"></span>
                        </div>
                      </div>
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Product Description</label>
                        <div class="controls">
                          <textarea name="description" id="inputSuccess" class="form-control">{{ $product->product_description }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>      
                     
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Cost Price</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                            <span class="add-on">$</span><input value="{{{ $product->unit_price }}}" class="unprice form-control" id="appendedPrependedInput" name="unit_price" size="16" type="number" min="0">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Selling price</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <span class="add-on">$</span><input value="{{{ $product->selling_price }}}"  class="sellprice form-control" id="appendedPrependedInput" name="selling_price" size="16" type="number" min="0">
                             {{  $errors->first('selling_price');}}
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <?php                    	
                         $msrm = explode(';',$product->measurements);
                        						if (count($msrm) < 3)
                        {
                        $msrm[0] = "";$msrm[1] = "";$msrm[2] = ""; 

                        }
                      ?>
                     <!-- <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Measurements</label>
                        <div class="controls">
			    <div class="col-md-4">Width <input type="number" name="width" class="number form-control" value="<?php echo $msrm[0]; ?>" min="0"></div><div class="col-md-4">Height <input type="number" class="number form-control" name="height" value="<?php echo $msrm[1]; ?>" min="0"></div><div class="col-md-4"> Depth <input type="number" class="number form-control" name="depth" value="<?php echo $msrm[2]; ?>" min="0"></div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                       <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Weight (kg)</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="weight" size="16" type="text" value="{{ $product->weight }}" class="form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>-->
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Quantity</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="quantity" size="16" type="text" value="{{ $product->quantity }}" class="qty_val form-control">
                          </div>
                          <?php
                              $count_required_qty = ProductStatusEntry::where('pro_id','=',$product->id)->count();
                              if($count_required_qty > 0){
                                 $get_required_qty = ProductStatusEntry::where('pro_id','=',$product->id)->get();
                                  $required_qty_total = "";
                                  foreach ($get_required_qty  as $key => $value) {                                  
                                      $required_qty_total = $value->required_qty + $required_qty_total;
                                  }
                                  echo "<span class='btn_add_qty' data-id='".$required_qty_total."'>Please add at least this amount: <span style='color:red;background:#ccc;padding:5px;cursor:pointer;'>".$required_qty_total."</span></span>";
                                  }                            
                           ?>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" required for="inputSuccess" >Min Product Quantity to inform</label>
                        <div class="controls">
                          <div class="input-prepend input-append">
                            <input required id="appendedPrependedInput" name="min_product_qty" size="16" type="text" value="{{ $product->min_product_qty}}" class="minqty form-control">
                          </div>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Company</label>
                        <div class="controls">
                            <select name="company" required data-rel="chosen" class="form-control">
                             <option value="">None</option>
                            @foreach($company as $key => $value)
                                <option value="{{ $value->id }}" <?php if($product->company_id == $value->id){echo "selected";} ?>>{{ $value->first_name }}</option>
                              @endforeach
                            </select>
                           
                        </div>
                      </div>      
                       <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Location</label>
                        <div class="controls">
                            <select name="store" required data-rel="chosen" class="form-control">
                             <option value="">None</option>
                            @foreach($store as $key => $value)
                                <option value="{{ $value->id }}" <?php if($product->store_id == $value->id){echo "selected";} ?>>{{ $value->store_name }}</option>
                              @endforeach
                            </select>
                           
                        </div>
                      </div>                     
                      <div class="form-group success">
                        <label class="control-label" for="selectError">Supplier</label>
                        <div class="controls">
                          <select name="supplier" required id="selectError" data-rel="chosen" class="form-control">
                           @if($product->supplier == -1) 
                                <option value="-1">None</option>
                                @endif 
                             @foreach($suppliers as $key => $value) 
                                <option @if ($product->supplier == $value->id) selected @endif value="{{ $value->id }}">{{ $value->supplier_name }}</option>
                              @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remark</label>
                        <div class="controls">
                          <textarea name="remark" id="inputSuccess" class="form-control">{{ $product->pro_remark; }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>   
                      <?php if(isset($product->pro_photos) && $product->pro_photos != ""){
                      ?>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Existing Image</label>
                        <div class="controls"> 
                          <?php if($product->pro_photos == ""){ echo "&nbsp;"; } else{ ?>
			    <div class="pro_photo_frame"><img src="<?php echo '../bootstrap/img/'.$product->pro_photos; ?>" style="width:100%"/></div>
                          <?php } ?>
                        </div>
                      </div> 
                      <?php
                          } 
                      ?>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Upload New Image</label>
                        <div class="controls pimage"> 
                          <input type="file" name="photo"/>
                        </div>
                      </div> 
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        
                        <a href="{{ URL::to('products') }}"><input type="button" value="Cancel" class="btn" class="form-control"></a>
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
<script type="text/javascript">
$(document).ready(function(){
    $(".btn_add_qty").click(function(){
      var addval = $(this).attr('data-id');
      var stockval = $(".qty_val").val();
      var newval = parseFloat(addval) + parseFloat(stockval);
      $('.qty_val').val(newval);
      $('.btn_add_qty').attr('data-id','');
      $('.btn_add_qty').hide();
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