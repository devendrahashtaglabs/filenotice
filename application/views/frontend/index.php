<style>
	.slick-slide {
		margin: 0px 20px;
	}

	.slick-slide img {
		width: 100%;
	}

	.slick-slider
	{
		position: relative;
		display: block;
		box-sizing: border-box;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
				user-select: none;
		-webkit-touch-callout: none;
		-khtml-user-select: none;
		-ms-touch-action: pan-y;
			touch-action: pan-y;
		-webkit-tap-highlight-color: transparent;
	}

	.slick-list
	{
		position: relative;
		display: block;
		overflow: hidden;
		margin: 0;
		padding: 0;
	}
	.slick-list:focus
	{
		outline: none;
	}
	.slick-list.dragging
	{
		cursor: pointer;
		cursor: hand;
	}

	.slick-slider .slick-track,
	.slick-slider .slick-list
	{
		-webkit-transform: translate3d(0, 0, 0);
		   -moz-transform: translate3d(0, 0, 0);
			-ms-transform: translate3d(0, 0, 0);
			 -o-transform: translate3d(0, 0, 0);
				transform: translate3d(0, 0, 0);
	}

	.slick-track
	{
		position: relative;
		top: 0;
		left: 0;
		display: block;
	}
	.slick-track:before,
	.slick-track:after
	{
		display: table;
		content: '';
	}
	.slick-track:after
	{
		clear: both;
	}
	.slick-loading .slick-track
	{
		visibility: hidden;
	}

	.slick-slide
	{
		display: none;
		float: left;
		height: 100%;
		min-height: 1px;
	}
	[dir='rtl'] .slick-slide
	{
		float: right;
	}
	.slick-slide img
	{
		display: block;
	}
	.slick-slide.slick-loading img
	{
		display: none;
	}
	.slick-slide.dragging img
	{
		pointer-events: none;
	}
	.slick-initialized .slick-slide
	{
		display: block;
	}
	.slick-loading .slick-slide
	{
		visibility: hidden;
	}
	.slick-vertical .slick-slide
	{
		display: block;
		height: auto;
		border: 1px solid transparent;
	}
	.slick-arrow.slick-hidden {
		display: none;
	}
</style>
<?php 
	$ticketformdata = $this->session->userdata('ticketformdata');
	if(!empty($ticketformdata)){
		$this->session->unset_userdata('ticketformdata');
	}
	$currenturl = $this->uri->segments;
		if(empty($currenturl)){
			$oldfilejson = $this->welcome_model->getSettingDataByKey('bannerfilename');
?>
	<aside id="fh5co-hero" class="js-fullheight">
		<div class="flexslider js-fullheight">
			<ul class="slides">
				<?php 
					if(!empty($oldfilejson)){
						$bannerarray = json_decode($oldfilejson->key_value);
						foreach($bannerarray as $banner){
				?>
					<li style="background-image: url(<?php echo base_url().'uploads/frontend/banner/'.$banner->banner; ?>);">
						<div class="overlay-gradient"></div>
						<div class="container">
							<div class="row">
								<div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
									<div class="slider-text-inner">
										<h1><?php echo $banner->bannername; ?></h1>
										<?php /*<p><a class="btn btn-primary btn-lg" href="<?php echo $banner->bannerlink; ?>">Make An Appointment</a></p> */ ?>
									</div>
								</div>
							</div>
						</div>
					</li>
				<?php } } ?>		   	
		  	</ul>
	  	</div>
	</aside>
	<?php } ?>
<section id="servicebox">
	<div class="ouservicebox">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<div class="flat-imagebox  ">
						<div class="flat-imagebox-inner">
							<div class="flat-imagebox-image">
								<img src="https://filenotice.com/uploads/frontend/abouts.jpg">				
							</div>
							<div class="flat-imagebox-header">
							<h3 class="flat-imagebox-title">
							<a href="https://www.onlinelegalindia.com/about/" target="_blank">About Us</a>	
							</h3>
							</div>
							<div class="flat-imagebox-content">
								<div class="flat-imagebox-desc">										
									We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.					
								</div>									
								<div class="flat-imagebox-button">
									<a href="about" target="_blank">Read More</a>
								</div>

								</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="flat-imagebox  ">
						<div class="flat-imagebox-inner">
							<div class="flat-imagebox-image">
								<img src="https://filenotice.com/uploads/frontend/aimbg.jpg">				
							</div>
							<div class="flat-imagebox-header">
							<h3 class="flat-imagebox-title">
							<a href="https://www.onlinelegalindia.com/about/" target="_blank">Our Aim</a>	
							</h3>
							</div>
							<div class="flat-imagebox-content">
								<div class="flat-imagebox-desc">										
									We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.					
								</div>									
								<div class="flat-imagebox-button">
									<a href="about" target="_blank">Read More</a>
								</div>

								</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="flat-imagebox  ">
						<div class="flat-imagebox-inner">
							<div class="flat-imagebox-image">
								<img src="https://filenotice.com/uploads/frontend/missoins.jpg">				
							</div>
							<div class="flat-imagebox-header">
							<h3 class="flat-imagebox-title">
							<a href="https://www.onlinelegalindia.com/about/" target="_blank">Vission & Mission</a>	
							</h3>
							</div>
							<div class="flat-imagebox-content">
								<div class="flat-imagebox-desc">										
									We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.					
								</div>									
								<div class="flat-imagebox-button">
									<a href="about" target="_blank">Read More</a>
								</div>

								</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>
<div id="allcategories">
	<div id="fh5co-practice" class="fh5co-bg-section">
		<div class="container">			
			<div class="row animate-box">				
				<div class="col-md-12 text-center fh5co-heading">
					<h2 class="puttocenter">FileNotice: Your saviour and Consultant in tough times !</h2>
					<p>FileNotice is a platform to offer consultancy services across various subjects to Indian Citizens who often find it difficult when they meet a problem. We have so many problems around - taxes, company issues, service matters, legal matters - that make us feel low and we are in search of a trustworthy partner who can give a helping hand - for us to find solution to the problems that can shake our world.</p>
				</div>
			</div>	
			<div class="row" style="">
				<?php
					/* if($this->session->flashdata('responce_msg')!=""){
						$message = $this->session->flashdata('responce_msg');
						echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
					} */
				?>
			</div>	
			<div class="row">
				<?php 
					if(!empty($allcategory)){
						foreach($allcategory as $category){
							$cat_icon 			= !empty($category->cat_icon)?$category->cat_icon:'fa fa-home';
							$str 				= $category->name .'/'.$category->id .'/'.$category->name; 
							$catid 				= base64_encode($str);
							$subcatamountdata 	= $this->welcome_model->getsubcategorybyparentid($category->id);
							if(in_array($category->id,$showparentcategory)){
								$url 		= base_url().'create_ticket/?catid='.$catid;
								$class		= '';
								$divclass	= '';
							}else{
								$url 		= 'javascript:void(0);';
								$class		= 'catlink';
								$divclass	= 'catcitydiv';
							}
							$derciption = '';
							if(!empty($category->cat_description)){
								$derciption = substr($category->cat_description, 0, 150).'....';
							}
							/* $usersession 	= $this->session->userdata('users');
							if(!empty($usersession) && $usersession['user_type'] != 'customer'){
								$url 	= 'javascript:void(0);';
								$class	= 'catlink';
							} */
				?>
					<div class="col-md-3 text-center animate-box srarea">
						<div class="imagservice">
							<?php 
								if(!empty($category->cat_featureimage)){
							?>
								<img src="<?php echo base_url().'uploads/category/'.$category->cat_featureimage; ?>" style="width: 100%;height: 180px;"> 
							<?php }else{ ?>
								<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" style="width: 100%;height: 180px;"> 							
							<?php } ?>
						</div>					
						<div class="services <?php echo $divclass; ?>">						
							<a href="<?php echo $url;?>" class="<?php echo $class; ?>" <?php if(!empty($class)){ ?> style="cursor:auto" <?php } ?>>
								<span class="icon"><i class="<?php echo $cat_icon; ?>"></i></span>
								<div class="desc">							
									<h3><?php echo $category->name; ?></h3>							
									<?php 
										if(!empty($subcatamountdata)){
											$singlesubcat 	= $subcatamountdata[0];
											$amount 		= $singlesubcat->amount; 
									?>
										<div class="amount section">
											<div class="pricesectin"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $amount; ?></div>
											<div class="seconrtsecitin">
												<span class="startint">Starts From</span>
												<span class="onwardds">Onwards</span>
											</div> 								
										</div>
									<?php } ?>


									<p><?php echo $derciption; ?></p>
								</div>
							<?php if(!empty($class)){ ?>
								<div class="details">
									<h4 class="sorrytext btn btn-block btn-danger">SORRY !</h4>
									<p>We are currently unavailable in your area. We are expanding, please check back soon.</p>
								</div>
							<?php } ?>
							</a>
						</div>				
					</div>
				<?php }} ?>
			</div>
		</div>
	</div>	
</div>	
<div id="help">
<section id="whychooseus">
	<div class="whyus">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="lwtitle">Why Choose Us</h2>
					<p>The key to our success is that we embrace collaboration and demand that our strategists, designers and project managers work closely and directly with our </p>
					<div class="choosecontent">
						<div class="row">
							<div class="col-md-6">
								<h3>Super Fast Service</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>
							<div class="col-md-6">
								<h3>Professional Experts</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h3>On Time Service</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>
							<div class="col-md-6">
								<h3>Data Security</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<h3>Affordable</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>
							<div class="col-md-6">
								<h3>24X7 Platform</h3>
								<p>We specialize in design-led brandcommunication and digital innovation</p>
							</div>						
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<h2 class="lwtitle">FAQ</h2>
					<p>The key to our success is that we embrace collaboration and demand that our strategists, designers and project managers work closely and directly with our </p>
					<div class="faqccord">
						<div class="panel-group" id="accordion">
							<?php 
								if(!empty($faq)){
									$count = 1;
									foreach($faq as $faqdata){
							?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count;?>"><span class="glyphicon glyphicon-menu-right"></span> <?php echo !empty($faqdata->faq_que)?$faqdata->faq_que:'';?></a>
									</h4>
								</div>
								<div id="collapse<?php echo $count;?>" class="panel-collapse collapse <?php echo ($count == 1)?'in':'';?>">
									<div class="panel-body">
										<p><?php echo !empty($faqdata->faq_ans)?$faqdata->faq_ans:''; ?> <a href="<?php echo !empty($faqdata->read_more_link)?$faqdata->read_more_link:''; ?>" target="_blank">Read more.</a></p>
									</div>
								</div>
							</div>
							<?php $count++; } } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
<section id="counter-aprt">
<div id="fh5co-counter" class="fh5co-counters fh5co-bg-section">
		<div class="container">			
			<div class="row">				
				<div class="col-md-3 text-center animate-box">	
					<span class="icon"><i class="icon-speech-bubble"></i></span>	
					<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo count($allcategory); ?>" data-speed="600" data-refresh-interval="1"></span>					
					<span class="fh5co-counter-label">Category</span>	
				</div>
				<div class="col-md-3 text-center animate-box">	
					<span class="icon"><i class="icon-trophy"></i></span>			
					<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo !empty($completedticket)?count($completedticket):''; ?>" data-speed="600" data-refresh-interval="1"></span>					
					<span class="fh5co-counter-label">Completed Case</span>				
				</div>				
				<div class="col-md-3 text-center animate-box">				
					<span class="icon"><i class="icon-users"></i></span>	
					<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo !empty($customersList)?$customersList:''; ?>" data-speed="600" data-refresh-interval="1"></span>
					<span class="fh5co-counter-label">Customers</span>
				</div>				
				<div class="col-md-3 text-center animate-box">					
					<span class="icon"><i class="icon-user"></i></span>					
					<span class="fh5co-counter js-counter" data-from="0" data-to="<?php echo !empty($consultList)?$consultList:''; ?>" data-speed="600" data-refresh-interval="1"></span>					
					<span class="fh5co-counter-label">Consultants</span>				
				</div>
			</div>	
		</div>
	</div>
</section>
<section id="orpartners">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="puttocenter">Our Partners</h2>
				<div class="customer-logos slider my-5">
					<?php 
						if(!empty($partner)){
							foreach($partner as $partnerdata){
					?>
						<div class="slide"><a href="<?php echo !empty($partnerdata->link)?$partnerdata->link:'#'; ?>"><img src="<?php echo base_url().'cosmatics/frontend/images/'.$partnerdata->logo; ?>" title="<?php echo !empty($partnerdata->name)?$partnerdata->name:''; ?>"></a></div>
					<?php 
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	$(document).ready(function() {
		/* $('#user_city').select2({
			placeholder:'Select City'
		}); */
		//$( ".alert" ).fadeOut( "slow");
		/* setTimeout(function() {
			$(".alert").hide('blind', {}, 500)
		}, 5000); */
		
		  $('.customer-logos').slick({
			slidesToShow: 6,
			slidesToScroll: 1,
			autoplay: true,
			autoplaySpeed: 1500,
			arrows: false,
			dots: false,
			pauseOnHover: false,
			responsive: [{
				breakpoint: 768,
				settings: {
					slidesToShow: 4
				}
			}, {
				breakpoint: 520,
				settings: {
					slidesToShow: 3
				}
			}]
		});
	});
</script>	
	