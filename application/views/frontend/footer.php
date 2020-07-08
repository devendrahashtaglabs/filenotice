	<footer id="fh5co-footer" role="contentinfo">
		<div class="container">
			<div class="row row-pb-md">
				<div class="col-md-2">
					<h4>Filenotice by #Labs</h4>
					<p>We facilitate you in consultancy and legal matters, where you struggle to find a helping hand...</p>
				</div>
				<div class="col-md-3">
					<h4>Navigation</h4>
					<ul class="fh5co-footer-links">
						<li><a href="<?php echo base_url();?>">Home</a></li>
						<li><a href="<?php echo base_url().'about';?>">About Us</a></li>
						<li><a href="<?php echo base_url().'contact';?>">Contact Us</a></li>
					</ul>
				</div>

				<div class="col-md-3">
					<h4>Contact Information</h4>
					<ul class="fh5co-footer-links">
						<li>D-147/4A, Indira Nagar, Lucknow – 226016 INDIA (UP)</li>
						<li><a href="tel:+91 (0522) 4248697">+91 (0522) 4248697</a></li>
						<li><a href="mailto:coffee@hashtaglabs.biz">coffee@hashtaglabs.biz</a></li>						
					</ul>
				</div>

				<div class="col-md-4">
					<h4>Consultancy Services</h4>
					<div class="consultancy-service">
						<?php 
							$allcategory = $this->welcome_model->getParentCategory();
							foreach($allcategory as $category){ 
								$str 	= $category->name .'/'.$category->id .'/'.$category->name; 
								$catid 	= base64_encode($str);
								$url 	= base_url().'create_ticket/?catid='.$catid;
						?>
							<span class="badge badge-pill badge-warning"><a href="<?php echo $url; ?>" target="_blank"><?php echo $category->name; ?></a></span> 
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="row copyright">
				<div class="col-md-12 text-center">
					<p>
						<small class="block">&copy; 2020 Filenotice.com All Rights Reserved.</small> 
					</p>
					<p>
						<ul class="fh5co-social-icons">
							<li><a href="#"><i class="icon-twitter"></i></a></li>
							<li><a href="#"><i class="icon-facebook"></i></a></li>
							<li><a href="#"><i class="icon-linkedin"></i></a></li>
							<li><a href="#"><i class="icon-dribbble"></i></a></li>
						</ul>
					</p>
				</div>
			</div>

		</div>
	</footer>
	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
	<!-- Waypoints -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.waypoints.min.js'; ?>"></script>
	<!-- Stellar Parallax -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.stellar.min.js'; ?>"></script>
	<!-- Carousel -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/owl.carousel.min.js'; ?>"></script>
	<!-- Flexslider -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.flexslider-min.js'; ?>"></script>
	<!-- countTo -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.countTo.js'; ?>"></script>
	<!-- Magnific Popup -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/jquery.magnific-popup.min.js'; ?>"></script>
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/magnific-popup-options.js'; ?>"></script>
	<!-- validation -->
	<script src="<?php echo base_url() . 'cosmatics/validation/jquery.validate.min.js'; ?>" type="text/javascript"></script> 
	<script src="<?php echo base_url() . 'cosmatics/validation/additional-methods.js'; ?>" type="text/javascript"></script> 
	<script src="<?php echo base_url() . 'cosmatics/validation/email-validation.js'; ?>" type="text/javascript"></script>
	<script src="<?php echo base_url() . 'cosmatics/validation/front_custom _validate.js'; ?>" type="text/javascript"></script>
	<!-- Main -->
	<script src="<?php echo base_url() . 'cosmatics/frontend/js/main.js'; ?>"></script>
	<script>
		$(document).ready(function(){
			if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition(showLocation);
			}else{ 
				alert('Geolocation is not supported by your browser.');
			}
		});

		function showLocation(position){
			console.log(position);
			/* var latitude 	= position.coords.latitude;
			var longitude 	= position.coords.longitude;
			var url 		= '<?php echo base_url();?>getaddressfromip';
			$.ajax({
				type:'POST',
				url:url,
				data:'latitude='+latitude+'&longitude='+longitude,
				success:function(msg){
					if(msg){
						console.log(msg);
					   //$("#location").html(msg);
					}else{
						//$("#location").html('Not Available');
						console.log('Not Available');
					}
				}
			}); */
		}
		$('#user_city').select2({
			placeholder:'Select City'
		});
	</script>
	<script>
window.onscroll = function() {myFunction()};

var header = document.getElementById("myHeader");
var sticky = header.offsetTop;

function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
  } else {
    header.classList.remove("sticky");
  }
}
</script>
	</body>
</html>