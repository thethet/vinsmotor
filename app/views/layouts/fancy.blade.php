<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>PH Bathroom Dashboard</title>
	<meta name="description" content="PH Bathroom">
	<meta name="author" content="Ricky Halim">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
    {{ HTML::style('css/bootstrap.min.css',array('id'=>'bootstrap-style')); }}
    {{ HTML::style("css/bootstrap-responsive.min.css"); }}
    {{ HTML::style('css/style.css',array('id'=>'base-style')); }}
    {{ HTML::style('css/style-responsive.css',array('id'=>'base-style-responsive')); }}
    {{ HTML::style('css/styles.css'); }}
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	@yield('header')
	<link rel="shortcut icon" href="img/favicon.ico">
</head>

<body>
	
                @yield('content')
			
	
	<!-- start: JavaScript-->
    
    {{ HTML::script("js/jquery-1.9.1.min.js") }}
    {{ HTML::script("js/jquery-migrate-1.0.0.min.js") }}
    
    {{ HTML::script("js/jquery-ui-1.10.0.custom.min.js") }}
    
    {{ HTML::script("js/jquery.ui.touch-punch.js") }}
    
    {{ HTML::script("js/modernizr.js") }}
    
    {{ HTML::script("js/bootstrap.min.js") }}
    
    {{ HTML::script("js/jquery.cookie.js") }}
    
    {{ HTML::script('js/fullcalendar.min.js') }}
    
    {{ HTML::script('js/jquery.dataTables.min.js') }}
    
    {{ HTML::script("js/excanvas.js") }}
    {{ HTML::script("js/jquery.flot.js") }}
    {{ HTML::script("js/jquery.flot.pie.js") }}
    {{ HTML::script("js/jquery.flot.stack.js") }}
    {{ HTML::script("js/jquery.flot.resize.min.js") }}
    
    {{ HTML::script("js/jquery.chosen.min.js") }}
    
    {{ HTML::script("js/jquery.uniform.min.js") }}
    
    {{ HTML::script("js/jquery.cleditor.min.js") }}
    
    {{ HTML::script("js/jquery.noty.js") }}
    
    {{ HTML::script("js/jquery.elfinder.min.js") }}
    
    {{ HTML::script("js/jquery.raty.min.js") }}
    
    {{ HTML::script("js/jquery.iphone.toggle.js") }}
    
    {{ HTML::script("js/jquery.uploadify-3.1.min.js") }}
    
    {{ HTML::script("js/jquery.gritter.min.js") }}
    
    {{ HTML::script("js/jquery.imagesloaded.js") }}
    
    {{ HTML::script("js/jquery.masonry.min.js") }}
    
    {{ HTML::script("js/jquery.knob.modified.js") }}
    
    {{ HTML::script("js/jquery.sparkline.min.js") }}
    
    {{ HTML::script("js/counter.js") }}
    
    {{ HTML::script("js/retina.js") }}
    
    {{ HTML::script("js/custom.js") }}
        
	@yield('script')
	<!-- end: JavaScript-->
	
</body>
</html>
