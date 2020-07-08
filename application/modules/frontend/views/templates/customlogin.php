<?php 
	$ticketformdata 	= $this->session->userdata('ticketformdata');
	$customloginsession = $this->session->userdata('customlogin');
	$customregistration = $this->session->userdata('customregistration');
?>
<style>
	label.error {
		margin-top: -1px;
		font-size: 12px;
	}
	.error {
		color: red;
		font-size: 12px;
	}
#login {
	max-width: 348px;
	margin: 25px auto;
	border: 1px solid #ccc;
	
}
	.custom-form .sc_heading.text-center h2 {
		margin: 25px 0 30px !important;
		font-size: 24px;
	}
	.thim-login.form-submission-register.custom-form {
	padding: 10px 10px 10px;
	border: 1px solid #F2F2F2;
	background: #ffffffe6;
}
.custom-form .sc_heading.text-center h2 {
	margin: 0 0 10px !important;
	font-size: 18px;
}

.bgsectionlogin .form-control {
	height: 30px;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
}

.btn-primary {
	background: #F3781E;
	color: #fff;
	border: 2px solid #F3781E;
}
.customloginpage {
	padding: 0px 20px 0;
}

.active-screen .number {
	border: 3px solid #263a7d;
	background: #263a7d;
}
.active-screen .number.active {
	background: #f3781e;
	border-color: #f3781e;
}
.active-screen .number a {
	color: #fff;
}
.active-screen .text-part.active {
	color: #f3781e;
}
.input-group-addon {
	padding: 7px 20px;
	font-size: 12px;
}
#form_customers {
	padding: 0 20px 20px;
}
.btn.btn-danger {
	background: #263a7d;
	color: #fff;
	border: 2px solid #263a7d;
}
.btn.btn-warning {
	background: #F3781E;
	color: #fff;
	border: 2px solid #F3781E;
}
.register-formbg .nav-tabs > li.active > a {
	background: #f4f4ff;
}
</style>
<script>
	function alpha(e) {
		var k;
		document.all ? k = e.keyCode : k = e.which;
		return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
	}
	$(document).ready(function() {
		$('#c_password').keyup(function() {
			$('#result').html(checkStrength($('#c_password').val()))
		})
		function checkStrength(password) {
			var strength = 0
			if (password.length < 6) {
				$('#result').removeClass()
				$('#result').addClass('short')
				return 'Too short'
			}
			if (password.length > 7) strength += 1
			// If password contains both lower and uppercase characters, increase strength value.
			if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
			// If it has numbers and characters, increase strength value.
			if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
			// If it has one special character, increase strength value.
			if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
			// If it has two special characters, increase strength value.
			if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
			// Calculated strength value, we can return messages
			// If value is less than 2
			if (strength < 2) {
				$('#result').removeClass()
				$('#result').addClass('weak')
				return 'Weak'
			} else if (strength == 2) {
				$('#result').removeClass()
				$('#result').addClass('good')
				return 'Good'
			} else {
				$('#result').removeClass()
				$('#result').addClass('strong')
				return 'Strong'
			}
		}
		$(".datepickerdob").datepicker({
			dateFormat: "dd-mm-yy",
			maxDate: '<?php $date = strtotime(date("d-m-Y").' -18 year'); echo date('d-m-Y', $date); ?>',
			// showButtonPanel: true,
			yearRange: "-80:+0",
			showOtherMonths: true,
			selectOtherMonths: true,
			changeMonth: true,
			changeYear: true
		});
		
		$("#register_account").fadeOut(3000,function(){
		   window.location.href = "<?php echo base_url().'/login';?>"
		});
	});
</script>
<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
<?php 
	$siteKeydata  = $this->frontend_model->getSettingDataByKey('gr_sitekey');
?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo !empty($siteKeydata)?$siteKeydata->key_value:'';?>"></script>
<script>
	grecaptcha.ready(function() {
	// do request for recaptcha token
	// response is promise with passed token
		grecaptcha.execute('<?php echo !empty($siteKeydata)?$siteKeydata->key_value:'';?>', {action:'validate_captcha'})
				  .then(function(token) {
			// add token value to form
			document.getElementById('g-recaptcha-response').value = token;
		});
	});
</script>
<script>
   function onSubmit(token) {
	 document.getElementById("form_customers").submit();
   }
 </script>
 <div class="scustmomlogin">
<div class="container vertical-center">	
	<div class="row my-5">	
		<div class="register-formbg cusomtlogndorm">
			<div class="thim-login form-submission-register custom-form">
				<ul class="nav nav-tabs" id="customlogintab">
				  <li class="active"><a data-toggle="tab" href="#login">Login</a></li>
				  <li><a data-toggle="tab" href="#registration">Registration</a></li>
				</ul>
				<div class="tab-content">
					<div class="row" style="margin-top: 0px; margin-bottom: 85px">
					  <div class="active-screen">
						  <div class="number-account reacehd">
							<span class="number one ">
								<a href="<?php echo base_url().'create_ticket/?catid='.$ticketformdata['urlcatid'];?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
							 </span>
							<span class="text-part">
								Ticket Details
							</span>
						   </div>
						  <div class="number-account">
							<span class="number two active">
								<a href="<?php echo base_url().'customlogin';?>"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
							</span>
							<span class="text-part active">
								Login / Registration
							</span>
						  </div>
						  <div class="number-account">
							<span class="number three notreached">
								<a href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
							</span>
							<span class="text-part">
								Review & Pay
							</span>
						  </div>
						  <div class="number-account">
							<span class="number four notreached">
								<a href="javascript:void(0);"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
							</span>
							<span class="text-part">
								Ticket Consultancy
							</span>
						  </div>
						</div>
					</div>
					<div id="login" class="tab-pane fade in active">
						<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
							<h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 8px;color: #fff;">Customer Login</h2>
						</div>
						<div class="customloginpage floating-laebls mt-5">
							<!-- Your code here -->
							<form action ="<?php echo $pageUrl; ?>" method ="post" id="FilenoticeLoginForm">
								<div class="col-md-12a">
									<?php
										if($this->session->flashdata('responce_msg')!=""){
											$message = $this->session->flashdata('responce_msg');
											echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
										}
									?>
								</div>
								<?php 
									$ticketformdata = $this->session->userdata('ticketformdata');
									$email 			= '';
									if($customloginsession == 'login' && !empty($ticketformdata['email'])){
										$email = $ticketformdata['email'];
									}
									if(!empty($customregistration)){
										$email = $customregistration['email'];
									}
								?>
								<div class="form-group inputBox <?php echo !empty($email)?'focus':''; ?>">
									<?php
										echo form_label('Email *', 'username');
										echo form_input(array('type'=>'email','name' => 'username', 'class' => 'form-control input', 'value' => set_value('username',$email), 'id' => "username"));
										echo '<div class="error-msg">' . form_error('username') . '</div>';
									?>
								</div>
								<div class="form-group inputBox">
									<?php
										echo form_label('Password *', 'password');
										echo form_password(array('name' => 'password', 'class' => 'form-control input', 'value' => set_value('password'), 'id' => "password"));
										echo '<div class="error-msg">' . form_error('password') . '</div>';
									?>
								</div>
								
								<a style="color: #F3781E;font-size: 10px;" href="<?php echo base_url().'forgetpassword';?>">Forgot Password?</a>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="margin-top: 10px;">
											<input class="btn btn-primary btn-md btn-learn" type="submit" name="loginsubmit" value ="Login" style="width:100%">
										</div>
									</div>
								</div>
							</form>
						</div>
				  </div>
				  <div id="registration" class="tab-pane fade">
						<div class="sc_heading text-center" style="padding: 0px 0 0;margin-bottom:0px;"><h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 8px;color: #fff;"><?php echo 'Customer Registration'; ?></h2></div>
						<!-- Your code here -->
						<?php echo form_open($pageUrl, array('class' => 'floating-laebls', 'id' => 'form_customers')); ?>
						<div class="col-md-12a">
							<?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
							?>
						</div>
						<?php 
							$prefixdata = $this->frontend_model->getDataByTable('nw_prefix_tbl');
						?>
						<div class="row floating-laebls mt-5">
							<div class="col-md-2">
								<div class="form-group inputBox focus">
									<?php 
										echo form_label('Title', 'title');
										$allprefix = [];
										foreach($prefixdata as $prefix){
											$allprefix[$prefix->id] = $prefix->title;
										}
										$selectedtitle = $ticketformdata['title'];
										echo form_dropdown('title', $allprefix, set_value('title',$selectedtitle), 'class="form-control input" id="sel1" tabindex="1"');
									?>
								</div>  
							</div>
							<div class="col-md-5">                
								<?php $selectedfname = $ticketformdata['fname']; ?>
								<div class="form-group inputBox <?php echo !empty($selectedfname)?'focus':'';?>">
									<?php
										echo form_label('First Name*', 'fname');
										echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$selectedfname), 'id' => "fname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2'));
										echo '<div class="error-msg">' . form_error('fname') . '</div>';
									?>
								</div>
							</div>
							<div class="col-md-5">
								<?php $selectedsname = $ticketformdata['sname']; ?>
								<div class="form-group inputBox <?php echo !empty($selectedsname)?'focus':'';?>">
									<?php
										echo form_label('Last Name *', 'sname');
										echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$selectedsname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3'));
										echo '<div class="error-msg">' . form_error('sname') . '</div>';
									?>						
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<?php $selectedemail = $ticketformdata['email']; ?>
								<div class="form-group inputBox <?php echo !empty($selectedemail)?'focus':'';?>">
									<?php
										echo form_label('Email *', 'email');
										echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$selectedemail), 'id' => "email", 'maxlength'=>'50','tabindex'=>'4'));
										echo '<div class="error-msg">' . form_error('email') . '</div>';
									?>
								</div>
							</div>
							<div class="col-md-6 havwesomeadon">
								<?php $selectedphone = $ticketformdata['customer_mobile']; ?>
								<div class="form-group inputBox focus <?php echo !empty($selectedphone)?'focus':'';?>">
									<?php echo form_label('Mobile Number *', 'phone'); ?>
									<div class="input-group">
										<span class="input-group-addon" id="sizing-addon1">+91</span>
										<?php
											echo form_input(array('name' => 'phone', 'class' => 'form-control input', 'value' => set_value('phone',$selectedphone), 'id' => "phone", 'maxlength'=>'10','tabindex'=>'5'));
											echo '<div class="error-msg">' . form_error('phone') . '</div>';
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group inputBox focus">
									<label> Gender *</label><br/>
									<input id="male" type="radio" name="gender" value="1" tabindex="6" checked> <span class="gnedrename">Male</span> &nbsp; &nbsp;
									<input id="female" type="radio" name="gender" value="2" <?php echo ($this->input->post('gender') == 2)?'checked':''; ?>> <span class="gnedrename"><span class="gnedrename">Female</span>&nbsp; &nbsp;
									<input id="other" type="radio" name="gender" value="3" <?php echo ($this->input->post('gender') == 3)?'checked':''; ?>> <span class="gnedrename">Other</span><br>
								</div>
							</div>
							<div class="col-md-7 customerdob">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group inputBox focus">
											<label style="visibility: hidden; width: 100%"> Age Dob *</label>
											<input id="age" type="radio" name="agepriority" tabindex="7" checked> <span class="gnedrename">Age</span>&nbsp; &nbsp;
											<input id="dob" type="radio" name="agepriority"> <span class="gnedrename">DOB</span> &nbsp; &nbsp;
										</div>
									</div>
									<div class="col-md-8">
										<?php 
											$c_dob = !empty($postdata)?$postdata['c_dob']:'';
										?>
										<div class="form-group calendar-icon agecale inputBox <?php echo !empty($c_dob)?'focus':''; ?>" id="customer_dob" style="display:none;">
											<?php
												echo form_label('Date of Birth (DD-MM-YYYY) *', 'c_dob');
												echo form_input(array('name' => 'c_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('c_dob',$c_dob), 'id' => "c_dob", 'tabindex'=>'8'));
												echo '<i class="fa fa-calendar dobcalaendaer"></i>';
											?>
										</div>
										<?php 
											$customer_age = '';
											if(!empty($postdata) && $postdata['user'] == '2'){
												$customer_age = !empty($postdata)?$postdata['customer_age']:'';
											}
										?>
										<div class="form-group agecale inputBox <?php echo !empty($customer_age)?'focus':''; ?>" id="cr_age">
											<?php
												echo form_label('Age', 'customer_age');
												echo form_input(array('type'=>'number','name' => 'customer_age', 'class' => 'form-control input', 'value' => set_value('customer_age',$customer_age), 'id' => "customer_age",'min'=>'18','max'=>'80','tabindex'=>'9'));
											?>
										</div>
									</div>
								</div>
							</div>							
						</div>	
						<div class="row">
							<div class="col-md-9">
								<?php 
									$selectedaddress = $ticketformdata['customer_address'];
								?>
								<div class="form-group inputBox selectbox textares <?php echo !empty($selectedaddress)?'focus':''; ?>">
									<?php 
										echo form_label('Address *', 'c_address');
										echo form_input(array('name' => 'c_address', 'class' => 'form-control input', 'value' => set_value('c_address',$selectedaddress), 'id' => "c_address",'maxlength'=>'255','tabindex'=>'8'));
										echo '<div class="error-msg">' . form_error('c_address') . '</div>';
									?>
								</div>
							</div>
							<div class="col-md-3">
								<?php 
									$selectedpincode = $ticketformdata['customer_pincode'];
								?>
								<div class="form-group inputBox focus <?php echo !empty($selectedpincode)?'focus':''; ?>">
									<?php
										echo form_label('Pin code *', 'c_pin');
										echo form_input(array('name' => 'c_pin', 'class' => 'form-control input', 'value' => set_value('c_pin',$selectedpincode), 'id' => "c_pin",'maxlength'=>'6','tabindex'=>'9'));
										echo '<div class="error-msg">' . form_error('c_pin') . '</div>';
									?>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-4">
								<?php $countryquery = $this->user_model->getCountryList(); ?>
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Country *', 'c_country');
										$allCountry        	= [];
										$allCountry['']    	= 'Select Country';
										$selectedcountry 	= $ticketformdata['customer_country'];
										if(!empty($countryquery)){
											foreach($countryquery as $singleCountryList){
												$allCountry[$singleCountryList->id] = $singleCountryList->name;
											}                    
										}                    
										echo form_dropdown('c_country', $allCountry, set_value('c_country',$selectedcountry), 'class="form-control input" id="c_country" tabindex="10" disabled="disabled"');
										echo form_hidden('c_country',$selectedcountry);
										echo '<div class="error-msg">' . form_error('c_country') . '</div>';
									?>
								</div>
							</div>
							<div class="col-md-4">
								<?php $statequery = $this->user_model->getStateList(); ?>
								<div class="form-group selectbox inputBox focus">
									<?php
										echo form_label('State *', 'c_state');
										$allstate      	= [];
										$allstate['']  	= 'Select State';
										$selectedstate 	= $ticketformdata['customer_state'];
										if(!empty($statequery)){
											foreach($statequery as $singleStateList){
												$allstate[$singleStateList->id] = $singleStateList->name;
											}                    
										}                    
										echo form_dropdown('c_state', $allstate, set_value('c_state',$selectedstate), 'class="form-control input" id="c_state" tabindex="11"'); 
										echo '<div class="error-msg">' . form_error('c_state') . '</div>';
									?>
								</div>								
							</div>
							<div class="col-md-4">
								<?php 
									if(!empty($defaultcitylist)){
										$cityquery = $defaultcitylist;
									}else{
										$cityquery = $this->user_model->getCityList();
									}
								?>
								<div class="form-group selectbox inputBox focus">
									<?php
										$selectedcity 	= $ticketformdata['customer_city'];
										echo form_label('City *', 'c_city');
										$allcity      	= [];
										$allcity['']  	= 'Select City';
										if(!empty($cityquery)){
											foreach($cityquery as $singleCityList){
												$allcity[$singleCityList->city_id] = $singleCityList->city_name;
											}                    
										}                    
										echo form_dropdown('c_city', $allcity, set_value('c_city',$selectedcity), 'class="form-control input" id="c_city" tabindex="12"'); 
										echo '<div class="error-msg">' . form_error('c_city') . '</div>';
									?>
									<?php
										/* echo form_label('City *', 'c_city');
										echo form_input(array('name' => 'c_city', 'class' => 'form-control', 'value' => set_value('c_city'), 'id' => "c_city", 'placeholder' => 'City *','onkeypress'=>'return alpha(event)', 'tabindex'=>'8'));
										echo '<div class="error-msg">' . form_error('c_city') . '</div>'; */
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Password *', 'c_password');
										echo form_password(array('name' => 'c_password', 'class' => 'form-control input', 'value' => set_value('c_password'), 'id' => "c_password",'maxlength'=>'50','tabindex'=>'13'));
										echo '<div class="error-msg">' . form_error('c_password') . '</div>';
									?>
									<!--<span id="result"></span> -->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Confirm Password *', 'c_cpassword');
										echo form_password(array('name' => 'c_cpassword', 'class' => 'form-control input', 'value' => set_value('c_cpassword'), 'id' => "c_cpassword", 'maxlength'=>'50','tabindex'=>'14'));
										echo '<div class="error-msg">' . form_error('c_cpassword') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">				
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="terms" tabindex="15"> I accept the <u>Terms and Conditions</u></p>
								<div class="error" id="terms_error_message_tools"></div>			
							</div>
						</div>
						<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
						<input type="hidden" name="action" value="validate_captcha">						
						<div class="row">	
							<div class="col-md-12 col-xs-12">
								 <div class="form-group btnisnide text-right">
								 	<input type ="reset" class="resetbtn btn btn-danger"  name ="reset" value ="Reset" tabindex="16" />
									<input type ="submit" class="btn btn-warning" name ="registersubmit" value ="Submit" tabindex="17" />
									
								</div>
							</div>
						</div>
					<?php echo form_close(); ?>
				  </div>
				</div>
			</div>
		</div>
		
	</div>
</div>
</div>
<?php 
	if($customloginsession =='registration'){
?>
	<script>
		$('#customlogintab a[href="#registration"]').tab('show'); 
	</script>
<?php } ?>
<script>
	$("#c_state").change(function(){
		var $option = $(this).find('option:selected');
		var stateId = $option.val();	
		$.ajax({
			url: '<?php echo base_url();?>frontend/frontController/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#c_city").html(data);
			}
		});
	});
	$('#age').click(function(){
		$('#customer_dob').hide();
		$('#cr_age').show();
	});
	$('#dob').click(function(){
		$('#customer_dob').show();
		$('#cr_age').hide();
	});
</script>
