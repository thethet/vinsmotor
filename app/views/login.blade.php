<!DOCTYPE html>
<html lang="en">
<head>	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Vin's Motor</title>
	<meta name="description" content="Innov8te">
	<meta name="author" content="Innov8te">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="icon" href="images/favicon.png">
	 {{ HTML::script("js/jquery-1.9.1.min.js") }}
	 <style>
	     body{
		 background:#eee;
	     }
	     .logo_wrapper{
		 margin-top:100px;
	     }
	     .login_input_wrapper{
		 padding:100px 50px;
		 background:#fff;
		 position:relative;
		 background:#ccc;
	     }	     
	     .login_input_wrapper input{
		 border:#ccc solid 1px;
		 height:50px;
		 line-height:50px;
		 font-size:17px !important;
		 color:#222;
		 width:80%;
		 margin:0 auto;
		 outline:none !important;
	     }
	     *:focus {
		outline: none !important;
		 -webkit-appearance:none !important;
		 border:none !important;
	    }  
	     .btn-primary{
		 background:#db280b !important;
		 border:#db280b solid 1px;
		 padding:10px 50px;
		 text-transform: uppercase;
		 font-weight: bold;
		 font-size:17px;
	     }
	    
	 </style>
</head>

<body>
	    <div class="container-fluid">
	    <div class="row-fluid">					
		<div class="row-fluid">
			    <div class="col-md-12">				   
				<p class="text-center logo_wrapper"><img src="images/vinsmotor_logo.png"/></p>
				<br/>
				<div class="row">
				<div class="col-md-4 text-center login_box col-md-offset-4 login_input_wrapper effect8">
				{{ Form::open(array('url' => 'login','method'=>'POST')) }}
					<fieldset>
						<div class="input-prepend help-inline">@if($errors->any())
							<h4>{{$errors->first()}}</h4>
							@endif
						</div>
						<div class="form-group" title="Username">
						    <input class="form-control" name="email" id="username" type="email" required placeholder="Email" autocomplete="off"/>
							<span class="help-inline"><?php echo $errors->first('email'); ?></span>
						</div>
						<div class="clearfix"></div>

						<div class="form-group" title="Password">
							<input class="form-control" name="password" id="password" type="password" required placeholder="Password"/>
							<span class="help-inline"><?php echo $errors->first('password'); ?></span>
						</div>
						<div class="clearfix"></div>
						<div>	
							<button type="submit" class="btn btn-primary">Login</button>
						</div>
						<div class="clearfix"></div>
				{{ Form::close() }}
				</div>
				</div>
			    </div><!--/span-->
		</div><!--/row-->

	    </div>
    </div><!--/.fluid-container-->
	
		</div><!--/fluid-row-->
		{{ HTML::script("js/jquery-migrate-1.0.0.min.js") }}    
		{{ HTML::script("js/jquery-ui-1.10.0.custom.min.js") }}    
		{{ HTML::script("js/bootstrap.min.js") }}
</body>
</html>
