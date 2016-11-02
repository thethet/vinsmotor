<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vin's Inventory System</title>
	<meta name="description" content="Stocks">
	<meta name="author" content="Innov8te">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="images/favicon.png">
	{{ HTML::style('src/css/boxy.css'); }}
	{{ HTML::style('font-awesome/css/font-awesome.min.css')}}
	{{ HTML::style('css/jquery.dataTables.min.css') }}
	{{ HTML::style('css/datatables.min.css') }}
	 {{ HTML::style('css/bootstrap.min.css')}}
	 {{ HTML::style('css/chosen.css') }}
	 {{ HTML::style('css/jquery.cleditor.css') }}	 
	{{ HTML::style('css/admin.css') }}
	     
    <?php $settings = DB::table('settings')->first(); ?>
	<style>
	.childbar{
		overflow: auto;
	width: 215px !Important;
	}
	#sidebar-left{
			background:#<?php echo $settings->sidemenu_color; ?> !important;
		overflow:auto;
	}
	.navbar-inner{
		background:#<?php echo $settings->menu_color; ?> !important;
		border::#<?php echo $settings->menu_color; ?> !important;
	}
		.nav-tabs.nav-stacked > li > a:hover, .nav-tabs.nav-stacked > li > ul > li > a:hover{
			background:#<?php echo $settings->sidemenu_hover; ?> !important;
			
		}
		#footer{
			background-color:#<?php echo $settings->sidemenu_color; ?> !important;
		}
	</style>
	@yield('header')

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	{{ HTML::script("http://html5shim.googlecode.com/svn/trunk/html5.js") }}
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
	
	 {{ HTML::script("js/jquery-1.9.1.min.js") }}
</head>

<body>
		<div id="wrapper">
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to ('main') }}"><img src="{{ asset('images/vinsmotor_logo.png') }}" /></a>
            </div>
            <ul class="nav navbar-right top-nav">                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Admin <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <!--<li>
                            <a href="{{ URL::to('profile/') }}"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="{{ URL::to('settings/') }}"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>-->
                        <li>
                            <a href="{{ URL::to('logout/') }}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li id="dashboard">
                        <a href="{{ URL::to ('main') }}"><i class="fa fa-dashboard add_color_toicon"></i> Dashboard</a>
                    </li>
		    <li id="middlemen">
                        <a href="{{ URL::to ('company') }}"><i class="fa fa-user add_color_toicon"></i> Company</a>
                    </li>
                    <li id="clients">
                        <a href="{{ URL::to ('clients') }}" data-id="clients"><i class="fa fa-user add_color_toicon"></i> Clients</a>
                    </li>
                    <li id="product">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"> <i class="fa fa-cube add_color_toicon"></i>  Product<i class="fa fa-angle-down place_right"></i></a>
                        <ul id="demo" class="collapse">
                            <li id="products">
                                <a href="{{ URL::to ('products') }}" class><i class="fa fa-cube add_color_toicon"></i> Product List</a>
                            </li>
                            <li id="product_category">
                                <a href="{{ URL::to ('product_category') }}"><i class="fa fa-cube add_color_toicon"></i> Product Category</a>
                            </li>
                        </ul>
                    </li>
                    <li id="stores">
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo1"> <i class="fa fa-home add_color_toicon"></i>  Location<i class="fa fa-angle-down place_right"></i></a>
                        <ul id="demo1" class="collapse">
                            <li id="Locatio">
                                <a href="{{ URL::to ('store') }}"><i class="fa fa-home add_color_toicon"></i> Location List</a>
                            </li>
                            <li id="store_type">
                                <a href="{{ URL::to ('store_type') }}"><i class="fa fa-home add_color_toicon"></i> Location Type</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li id="suppliers">
                        <a href="{{ URL::to ('suppliers') }}"><i class="fa fa-user add_color_toicon"></i> Supplier</a>
                    </li>
                   
                    <li id="staffs">
                        <a href="{{ URL::to ('staffs') }}"><i class="fa fa-user add_color_toicon"></i> Sales Staff</a>
                    </li>
               
                    <li id="quotations">
                        <a href="{{ URL::to ('quotations') }}"><i class="fa fa-file add_color_toicon"></i> Quotation</a>
                    </li>
                    <li id="invoices">
                        <a href="{{ URL::to ('invoices') }}"><i class="fa fa-file add_color_toicon"></i> Invoice</a>
                    </li>
                   <!-- <li id="delivery_orders">
                        <a href="{{ URL::to ('delivery_orders') }}"><i class="fa fa-truck add_color_toicon"></i> Delivery Order</a>
                    </li>
                    <li id="credit_notes">
                        <a href="{{ URL::to ('credit_notes') }}"><i class="fa fa-credit-card add_color_toicon"></i> Credit Note</a>
                    </li>-->
                    <li id="purchase_orders">
                        <a href="{{ URL::to ('purchase_orders') }}"><i class="fa fa-file add_color_toicon"></i> Purchase Order</a>
                    </li>
                    <li>
                     <a  href="{{ URL::to('users') }}"><i class="fa fa-user add_color_toicon"></i> Users</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
	<div id="page-wrapper">
     @yield('content')
	</div>
	<footer class="footer">
		&copy; <?php echo date('Y'); ?>	
     
         {{ HTML::script("js/jquery-migrate-1.0.0.min.js") }}
	 
	 <script ></script>
    
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
    {{ HTML::script("src/js/jquery.boxy.js") }}
    

     <script>
		$(document).ready(function(){
			$("#dashboard").addClass('active');
			var aa = location.href.replace(/#.*/, "");
			var name = aa.match(/([^\/]*)\/*$/)[1];
            //alert(name);
			$("#"+name).addClass('active');
            $("#dashboard").removeClass('active');
            if((name == "store") || (name=="store_type")){
                $("#stores").addClass('active');
            }
            else{
                $("#stores").removeClass('active');
            }
            if((name == "currency_exchange") || (name =="currency_country")){
                $("#currency").addClass('active');
            }
            else{
                $("#currency").removeClass('active');
            }
             
			$(".navbar-nav a").filter(function(){
			    return this.href == location.href.replace(/#.*/, "");
			}).addClass("active");
		});
	</script>
	@yield('script')
	
</body>
</html>

