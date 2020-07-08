<section id="servicebox">
	<div class="ouservicebox">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="py-5">
						<div class="row">
							<!-- DEMO 4 Item-->
							<div class="col-lg-12 mb-3 mb-lg-0">
								<div class="hover hover-4 text-white rounded">
									<img src="https://filenotice.com/uploads/frontend/abouts.jpg" alt="">
									<div class="hover-overlay"></div>
									<div class="hover-4-content">
										<h2 class="hover-4-title text-uppercase font-weight-bold mb-0">About Us</h2>
										<p class="hover-4-description text-uppercase mb-0 small">We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="choose animate-box">
						<div class="fh5co-heading">
							<h2>About </h2>
							<p>We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts far from the countries Vokalia and Consonantia, there live the blind texts. </p>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-6">
					<div class="choose animate-box">
						<div class="fh5co-heading">
							<h2>Our Aim</h2>
							<p>We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts far from the countries Vokalia and Consonantia, there live the blind texts. </p>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="py-5">
						<div class="row">
							<!-- DEMO 4 Item-->
							<div class="col-lg-12 mb-3 mb-lg-0">
								<div class="hover hover-4 text-white rounded">
									<img src="https://filenotice.com/uploads/frontend/aimbg.jpg" alt="">
									<div class="hover-overlay"></div>
									<div class="hover-4-content">
										<h2 class="hover-4-title text-uppercase font-weight-bold mb-0">Our Aim</h2>
										<p class="hover-4-description text-uppercase mb-0 small">We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col-md-6">
					<div class="py-5">
						<div class="row">
							<!-- DEMO 4 Item-->
							<div class="col-lg-12 mb-3 mb-lg-0">
								<div class="hover hover-4 text-white rounded">
									<img src="https://filenotice.com/uploads/frontend/missoins.jpg" alt="">
									<div class="hover-overlay"></div>
									<div class="hover-4-content">
										<h2 class="hover-4-title text-uppercase font-weight-bold mb-0">Vission & Mission</h2>
										<p class="hover-4-description text-uppercase mb-0 small">We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="choose animate-box">
						<div class="fh5co-heading">
							<h2>Vission</h2>
							<p>We provide with the best of services to all our clients and understand their needs and file the complaint with sincerity, thus helping them to resolve their issues, in no time. Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts far from the countries Vokalia and Consonantia, there live the blind texts. </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div id="fh5co-content">
	<div class="video fh5co-video" style="background-image: url(<?php echo base_url()?>uploads/frontend/video.jpg);">
		<a href="https://vimeo.com/channels/staffpicks/93951774" class="popup-vimeo"><i class="icon-video2"></i></a>
		<div class="overlay"></div>
	</div>
	<div class="choose animate-box">
		<div class="fh5co-heading">
			<h2>Why Choose Us?</h2>
			<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts far from the countries Vokalia and Consonantia, there live the blind texts. </p>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%">
			Adoption Law 50%
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%">
			Family Law 80%
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:70%">
			Real Estate Law 70%
			</div>
		</div>
		<div class="progress">
			<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:40%">
			Personal Injury Law 40%
			</div>
		</div>
	</div>
</div>
<div id="fh5co-about">
	<div class="container">
		<div class="row animate-box">
			<div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
				<h2 class="puttocenter">Our Consultants</h2>
				<p>Dignissimos asperiores vitae velit veniam totam fuga molestias accusamus alias autem provident. Odit ab aliquam dolor eius.</p>
			</div>
		</div>
		<?php 
			$consultants = $this->frontend_model->getDataByTable('nw_consultant_tbl');
		?>
		<div class="row">
			<div class="owl-carousel owl-carousel-fullwidth" id="consultant-list">
				<?php 
					foreach($consultants as $consultant){
						$expertise = !empty($consultant->expertise)?$consultant->expertise:'';
						$expertisename = [];
						if(!empty($expertise)){
							$expertisearray = explode(',',$expertise);
							foreach($expertisearray as $expertiseid){
								$expertisedata = $this->frontend_model->getDataBykey('nw_experties_tbl','id',$expertiseid);
								$expertisename[] = $expertisedata->name;
							}
						}
						$allexpertise = implode(', ',$expertisename);
						$city_id 	= $consultant->city_id;
						$citydata 	= $this->frontend_model->getDataBykey('nw_cities_tbl','city_id',$city_id);
						$city_name 	= !empty($citydata)?$citydata->city_name:'';
						$state_id 	= $consultant->state_id;
						$statedata 	= $this->frontend_model->getDataBykey('nw_states_tbl','id',$state_id);
						$state_name = !empty($statedata)?$statedata->name:'';
						$country_id  = $consultant->country_id;
						$countrydata = $this->frontend_model->getDataBykey('nw_countrys_tbl','id',$country_id);
						$country_name = !empty($countrydata)?$countrydata->name:'';
				?>
				<div class="item">
					<div class="text-center animate-box" data-animate-effect="fadeIn">
						<div class="fh5co-staff">
							<?php 
								if(!empty($consultant->photo)){
							?>
								<img src="<?php echo base_url() .'uploads/profile/'.$consultant->photo;?>" alt="">
							<?php }else{ ?>
								<img src="<?php echo base_url() .'uploads/profile/no_image_available.jpeg';?>" alt="">
							<?php } ?>
							<?php 
								$fullname = $consultant->name .' '. $consultant->sname;
							?>
							<h3><?php echo $fullname; ?></h3>
							<strong class="role"><?php echo $allexpertise; ?></strong>
							<p><?php echo $consultant->about_consultant; ?></p>
							<p><strong class="address"><?php echo $city_name .' '.$state_name .' '.$country_name; ?></strong></p>
							<!--<ul class="fh5co-social-icons">
								<li><a href="#"><i class="icon-facebook"></i></a></li>
								<li><a href="#"><i class="icon-twitter"></i></a></li>
								<li><a href="#"><i class="icon-dribbble"></i></a></li>
								<li><a href="#"><i class="icon-github"></i></a></li>
							</ul> -->
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<div id="fh5co-testimonial" class="fh5co-bg-section">
	<div class="container">
		<div class="row animate-box">
			<div class="col-md-6 col-md-offset-3 text-center fh5co-heading">
				<h2 class="puttocenter">Testimonials</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="row animate-box">
					<div class="owl-carousel owl-carousel-fullwidth">
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
									<img src="<?php echo base_url()?>uploads/frontend/user-1.jpg" alt="user">
								</figure>
								<span>Jean Doe, via <a href="#" class="twitter">Twitter</a></span>
								<blockquote>
									<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
								</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
									<img src="<?php echo base_url()?>uploads/frontend/user-1.jpg" alt="user">
								</figure>
								<span>John Doe, via <a href="#" class="twitter">Twitter</a></span>
								<blockquote>
									<p>&ldquo;Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
								</blockquote>
							</div>
						</div>
						<div class="item">
							<div class="testimony-slide active text-center">
								<figure>
									<img src="<?php echo base_url()?>uploads/frontend/user-1.jpg" alt="user">
								</figure>
								<span>John Doe, via <a href="#" class="twitter">Twitter</a></span>
								<blockquote>
									<p>&ldquo;Far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
								</blockquote>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		var owl = $('#consultant-list');
		owl.owlCarousel({
			items: 3,
			loop: true,
			margin: 0,
			nav: false,
			dots: true,
			smartSpeed: 800,
			//autoplay:true
		});
	});
</script>
