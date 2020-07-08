<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo $page_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Filenotice" />
	<meta name="keywords" content="legal cases,tax filling" />
	<meta name="author" content="hashtaglabs.in" />

	<!-- 
	//////////////////////////////////////////////////////

	FREE HTML5 TEMPLATE 
	DESIGNED & DEVELOPED by FreeHTML5.co
		
	Website: 		http://freehtml5.co/
	Email: 			info@freehtml5.co
	Twitter: 		http://twitter.com/fh5co
	Facebook: 		https://www.facebook.com/fh5co

	//////////////////////////////////////////////////////
	 -->

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,700,800" rel="stylesheet">
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Animate.css -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/animate.css'; ?>">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/icomoon.css'; ?>">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/jquerysctipttop.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/bootstrap.css'; ?>">
	<?php /*<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/jquery-ui.css'; ?>"> */ ?>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/select2.min.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/dropdowntree.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/materialdesignicons.min.css'; ?>">

	<!-- Magnific Popup -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/magnific-popup.css'; ?>">

	<!-- Owl Carousel  -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/owl.carousel.min.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/owl.theme.default.min.css'; ?>">
	<!-- Flexslider  -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/flexslider.css'; ?>">

	<!-- Theme style  -->
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/style.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/frontend/css/custom.css'; ?>">
	<link rel="stylesheet" href="<?php echo base_url() . 'cosmatics/css/form-validation-style.css'; ?>">

	<!-- Modernizr JS -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/modernizr-2.6.2.min.js'; ?>"></script>
	
	<!-- jQuery -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.min.js'; ?>"></script>
	<!-- jQuery Easing -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery-ui.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.easing.1.3.js'; ?>"></script>
	<!-- Bootstrap -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/bootstrap.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'cosmatics/js/select2.min.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url() . 'cosmatics/js/dropdowntree.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url() . 'cosmatics/js/icontains.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>cosmatics/validation/mask.min.js" type="text/javascript"></script>
	<!--<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback" async defer></script>-->
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<script>
		var onloadCallback = function() {
			grecaptcha.execute();
		};

		function setResponse(response) { 
			document.getElementById('captcha-response').value = response; 
		}
	</script>
	</head>
	<style type="text/css">
		.select2-container .select2-selection--single{
			height: 35px;
		}
		.select2.select2-container.select2-container--default {
			width: 270px !important;
			text-align: left !important;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			height: 35px;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 35px;
		}
		.select2-container--default .select2-selection--single{
			border-radius: 25px;
		}
		#getcategory {
			height: 35px;
			margin: 0;
			line-height: 17px;
			padding: 5px 10px;
			background: #263a7d;
			border: 2px solid #263a7d;
		}

	</style>
	<body style="">
	<?php 
		$currenturl = $this->uri->segments;
	?>
		
	<div class="fh5co-loader"></div>
	
	<div id="page">
		<div class="flat-top header-style1">    
    <div class="container">
        <div class="row">
        	<div class="col-md-6">
            <div class="custom-info">
            <ul><li class="phone"><i class="fa fa-phone"></i><a style="cursor:pointer" href="tel:+91 (0522) 4248697">Call us: +91 (0522) 4248697</a></li>
            	<li class="mail"><i class="fa fa-envelope"></i><a style="cursor:pointer" href="mailto:coffee@hashtaglabs.biz">Email: coffee@hashtaglabs.biz</a></li>
            </ul>
            </div>            </div><!-- /.col-md-7 -->

            <div class="col-md-6 text-right">
            <div class="info-top-right">
            <span><i class="fa fa-question-circle"></i>Have any queries?</span>
            <a class="appoinment" href="#help">Help</a>
            </div>           

            </div><!-- /.col-md-6 -->

        </div><!-- /.container -->
    </div><!-- /.container -->        
</div>
	<nav class="fh5co-nav" role="navigation" id="myHeader">
		<div class="top-menu">
			<div class="container">
				<div class="row">
					<div class="col-xs-3">
						<!-- <img src="<?php //echo base_url(). 'uploads/settings/logo.png'; ?>" class="img-responsive"/> -->
						<div id="fh5co-logo" class="custom-logo">
                        <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>uploads/frontend/flogo.png" /></a>
                        </div>
					</div>
					<div class="col-xs-9 text-right menu-1">
						<div class="location-category">

								<?php
									echo form_open_multipart(base_url().'#allcategories', array('class' => 'form-inline', 'id' => 'getcityForm'));
								 ?>
								  <div class="form-group">
									<?php
										if(!empty($currentcityid)){
											$cityid = $currentcityid;
										}else{
											$currentcitydata 	= $this->session->userdata('currentcitydata');
											$cityid 			= !empty($currentcitydata)?$currentcitydata->city_id:'';
										}
										$option = array();
										foreach ($allcity as $key => $value) {
											$option[$value->city_id] = ucfirst($value->city_name);
										}
										echo form_dropdown('user_city', $option, $selected = set_value('user_city',$cityid), $extra = 'class="form-control" id="user_city"');
									?>
								  </div>
								  <div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-info", "id" => "getcategory", "value" => "Go"));
									?>
								  </div>
								<?php echo form_close(); ?>
							
						</div>
						<div class="menu-tems">
							<ul>
							<li <?php if(empty($currenturl)){ ?>class="active" <?php } ?>><a href="<?php echo base_url(); ?>">Home</a></li>
							<li <?php if($currenturl[1] == 'about'){ ?>class="active" <?php } ?>><a href="<?php echo base_url() .'about'; ?>" >About Us</a></li>
							<li <?php if($currenturl[1] == 'contact'){ ?>class="active" <?php } ?>><a href="<?php echo base_url() .'contact'; ?>">Contact</a></li>
						    <?php if(empty($logout)){ ?>
								<li <?php if($currenturl[1] == 'login'){ ?>class="active" <?php } ?>><a href="<?php echo base_url(). 'login';?>"><span>Sign In</span></a></li>
							<?php }else{ ?>
								<li class=""><a href="<?php echo $dashboard;?>"><span>Dashboard</span></a></li>
								<li class=""><a href="<?php echo $logout;?>"><span>Logout</span></a></li>
							<?php } ?>
							<?php 
								/*$currentcitydata = $this->session->userdata('currentcitydata');
								if(!empty($selectedcitydata)){
							?>
								<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $selectedcitydata->city_name; ?></a></li>
							<?php }else{ ?>
								<li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo !empty($currentcitydata)?$currentcitydata->city_name:''; ?></a></li>
							<?php } */ ?>
							
						</ul>
						</div>
						
						
					</div>
				</div>
				
			</div>
		</div>
	</nav>
	<?php 
		if(empty($currenturl)){
			/*
	?>
	<aside id="fh5co-hero" class="js-fullheight">
		<div class="flexslider js-fullheight">
			<ul class="slides">
		   	<li style="background-image: url(<?php echo base_url().'cosmatics/frontend/images/img_bg_1.jpg'; ?>);">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Expert Legal Solutions</h1>
									<p><a class="btn btn-primary btn-lg" href="#">Make An Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(<?php echo base_url().'cosmatics/frontend/images/img_bg_2.jpg'; ?>);">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Business Law</h1>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make An Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>
		   	<li style="background-image: url(<?php echo base_url().'cosmatics/frontend/images/img_bg_3.jpg'; ?>);">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="row">
			   			<div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
			   				<div class="slider-text-inner">
			   					<h1>Defend Your Constitutional Right with Legal Help</h1>
									<p><a class="btn btn-primary btn-lg btn-learn" href="#">Make An Appointment</a></p>
			   				</div>
			   			</div>
			   		</div>
		   		</div>
		   	</li>		   	
		  	</ul>
	  	</div>
	</aside>
	<?php */ 
		}else{ 
		if(!empty($banner_active)){
	?>
	<aside id="fh5co-hero" class="js-fullheight">
		<div class="flexslider js-fullheight">
			<ul class="slides">
		   	<li style="background-image: url(<?php echo base_url().'uploads/frontend/'.$banner_img;?>);">
		   		<div class="overlay-gradient"></div>
		   		<div class="container">
		   			<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text">
		   				<div class="slider-text-inner desc">
		   					<h2 class="heading-section"><?php echo $page_title; ?></h2>
		   				</div>
		   			</div>
		   		</div>
		   	</li>
		  	</ul>
	  	</div>
	</aside>
	<?php } } ?>