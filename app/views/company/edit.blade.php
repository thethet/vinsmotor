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
                <div class="col-md-6"><h2 class="page_header"><i class="fa fa-user"></i> Edit Company</h2></div>
            </div>
            <div class="box-content">
		  <div class="row">
                <div class="col-md-4 col-md-offset-4">
		{{ Form::open(array('url' => 'company/edit','class'=>'form-horizontal','method'=>'post','files' => true)) }}
                {{ Form::hidden('id',$middlemen->id) }}
                    <fieldset>            
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Name</label>
                        <div class="controls">
                          <input type="text" required value="{{ $middlemen->first_name }}" name="first_name" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>

                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Registration No.</label>
                        <div class="controls">
                          <input type="text" required value="{{ $middlemen->reg_no }}" name="reg_no" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                    
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Contact</label>
                        <div class="controls">
                           <input type="number" value="{{ $middlemen->mobile_contact }}" name="mobile_contact" id="inputSuccess" min="0" class="form-control mobilecontact">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Email</label>
                        <div class="controls">
                           <input type="email" required value="{{ $middlemen->email }}" name="email" id="inputSuccess" class="form-control">
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Address</label>
                        <div class="controls">
			    <textarea required name="address" id="inputSuccess" class="form-control">{{ $middlemen->address }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                     <div class="form-group success">
                        <label class="control-label" for="inputSuccess">Remarks</label>
                        <div class="controls">
                           <textarea class="textarea form-control" name="remarks">{{$middlemen->remarks }}</textarea>
                          <span class="help-inline"></span>
                        </div>
                      </div>
                      <?php if(isset($middlemen->photo) && $middlemen->photo != ""){
                      ?>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Existing Logo</label>
                        <div class="controls"> 
                          <?php if($middlemen->photo == ""){ echo "&nbsp;"; } else{ ?>
			    <div class="pro_photo_frame"><img src="<?php echo '../bootstrap/img/'.$middlemen->photo; ?>" style="width:100%;"></div>
                          <?php } ?>
                        </div>
                      </div> 
                      <?php
                          } 
                      ?>
                      <div class="form-group success">
                        <label class="control-label" for="inputSuccess" >Upload New Logo</label>
                        <div class="controls company-image"> 
                          <input type="file" name="photo"/>
                        </div>
                      </div> 
                      <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update</button>
                        
                        <a href="{{ URL::to('company') }}"><input type="button" value="Cancel" class="btn"></a>
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

</script>
@stop