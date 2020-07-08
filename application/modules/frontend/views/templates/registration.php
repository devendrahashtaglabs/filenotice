<style>
	.vertical-center {
		  min-height: 100%; 
		  min-height: 100vh;    
		  display: flex;
		  align-items: center;
	} 
	input[type="text"] {
		display: block;
		width: 100%;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.42857143;
		margin:0;
		color: #555;
		background-color: #fff;
		background-image: none;
		border: 1px solid #ccc;
		border-radius: 4px;		
		-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	}
	
	#form_customers label span{
		color:#F00;
	}		
	
	#form_customers .short{
		font-weight:bold;
		color:#FF0000;
		font-size:larger;
	}
	#form_customers .weak{
		font-weight:bold;
		color:orange;
		font-size:larger;
	}
	#form_customers .good{
		font-weight:bold;
		color:#2D98F3;
		font-size:larger;
	}
	#form_customers .strong{
		font-weight:bold;
		color: limegreen;
		font-size:larger;
	}
	.blogShort{ border-bottom:1px solid #ddd;}
.add{background: #333; padding: 10%; height: 300px;}

.nav-sidebar {
	width: 100%;	
	height: 100%;
	min-height: 456px;	
}
.nav-sidebar a {
    color: #333;
    -webkit-transition: all 0.08s linear;
    -moz-transition: all 0.08s linear;
    -o-transition: all 0.08s linear;
    transition: all 0.08s linear;
}
.nav-sidebar .active a { 
    cursor: default;
    background-color: transparent; 
    color: #fff; 
    cursor: pointer;
}
.nav-sidebar li.active {
	background: #263a7d;
}
.nav-sidebar .text-overflow a,
.nav-sidebar .text-overflow .media-body {
    white-space: nowrap;
    overflow: hidden;
    -o-text-overflow: ellipsis;
    text-overflow: ellipsis; 
}

.btn-blog {
    color: #ffffff;
    background-color: #E50000;
    border-color: #E50000;
    border-radius:0;
    margin-bottom:10px
}
.btn-blog:hover,
.btn-blog:focus,
.btn-blog:active,
.btn-blog.active,
.open .dropdown-toggle.btn-blog {
    color: white;
    background-color:#0b56a8;
    border-color: #0b56a8;
}
article h2{color:#333333;}
h2{color:#0b56a8;}
 .margin10{margin-bottom:10px; margin-right:10px;}
 
label.error {
    color: red !important;
    font-size: 12px !important;
    font-weight: normal !important;
    text-align: left;
    line-height: 15px;
}
.tab-content.resttabs {
	background: #ffffffe6;
	padding: 0 0 10px;
}
.nav-sidebar li a {
	padding: 65px 10px;
	text-align: center;
	font-size: 25px;
	
	color: #fff;
}
.nav-sidebar li {
	background: #f3781e;
}
.tab-content.resttabs input.btn-warning {
	background: #F3781E;
	color: #fff;
	border: 2px solid #F3781E;
}
.tab-content.resttabs input.btn-info {
	background: #263a7d;
	color: #fff;
	border: 2px solid #263a7d;
}
.tab-content.resttabs input.btn-info:hover {
	background: #30468e !important;
	border-color: #263a7d !important;
}
.nav > li > a:hover, .nav > li > a:focus {
	text-decoration: none;
	background-color: transparent;
	color: #fff;
}
.tab-content.resttabs label {
	font-size: 12px;
	color: #333;
	margin-bottom: 0;
	line-height: 17px;
}
.tab-content.resttabs .form-control {
	height: 30px !important;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
}
.form-control-feedback {	
	top: 27px;	
}
.gnedrename {
	font-size: 12px;
	color: #333;
}
.bgsectionlogin {
	background-repeat: no-repeat;
}
.container.tavconbtiner {
	width: 1250px;
}
.tab-pane {
	padding: 0 15px;
	margin: 0 !important;
}
.form-group.btnisnide.text-right {
	text-align: right;
	margin: 5px 0 0;
}
.customerdob .form-group.calendar-icon .form-control-feedback {
	top: 17px;
	font-size: 14px;
	right: 10px;
}
.form-group.calendar-icon .form-control-feedback {
	top: 18px;
}
.form-group {
	margin-bottom: 8px;
}
#phone {
	border-top-right-radius: 4px;
	border-bottom-right-radius: 4px;

}
.havwesomeadon label.error {
	position: absolute;
	bottom: -20px;
	width: 100%;
	left: 0;
}
.input-group-addon {
	padding: 7px 20px;
	font-size: 12px;
}
.my-5 {
	margin: 1.5em 0px;
}

.consultantpart {
	width: 100%;
	float: left;
	background: #f3781ecf;
	margin: 15px 0;
	padding: 10px;
	text-align: center;
	border-radius: 25px;
}
.consultantpart a {
	color: #fff;
}
.consultantpart a span {
	color: #263a7d;
	font-weight: bold;
}
.consultantpart:hover {
	background: #f3781e;
}
.customerdob .col-md-4 {
	padding-right: 0;
}
.customerdob .col-md-8 {
	padding-left: 0;
}
.title2 a{
	color:#fff;
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
<div class="bgsectionlogin loginregisfor">
	<div class="container">
		<div class="row my-5">
			<div class="tavconbtiner">
				<?php 
					$prefixdata = $this->frontend_model->getDataByTable('nw_prefix_tbl');
				?>
				<div class="col-md-6">
					<!-- tab content -->
					<div class="tab-content resttabs">
						<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
							<h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 15px 8px;color: #fff;min-height: 65px;">Customer Sign Up</h2>
						</div>
						<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
							<div class="title2 btn btn-warning" style="float: right;position: absolute;right: 15px;top: 0;margin-top: 11px;"><a href="#tab2" data-toggle="tab" id="consultant_tab">Partner with us</a><a href="#tab1" data-toggle="tab" id="customer_tab" style="display:none;">Join as customer</a></div>
						</div>
						<div class="tab-pane active text-style floating-laebls" id="tab1">
							<?php echo form_open($pageUrl, array('class' => '', 'id' => 'form_customers')); ?>
							<input type="hidden" name="user" value="2" />
							<div class="col-md-12a">
								<?php
									if($this->session->flashdata('responce_msg')!=""){
										$message = $this->session->flashdata('responce_msg');
										echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
									}
								?>
							</div>
							<div class="row mt-5">
								<div class="col-md-2">
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Title', 'title');
											$allprefix = [];
											foreach($prefixdata as $prefix){
												$allprefix[$prefix->id] = $prefix->title;
											}
											$title = !empty($postdata)?$postdata['title']:'';
											echo form_dropdown('title', $allprefix, set_value('title',$title), 'class="form-control input" id="title" tabindex="1"');
											echo '<div class="error-msg">' . form_error('title') . '</div>';
										?>
									</div>  
								</div>
								<div class="col-md-5"> 
									<?php $fname = !empty($postdata)?$postdata['fname']:''; ?>
									<div class="form-group inputBox <?php echo !empty($sname)?'focus':''; ?>">
										<?php
											$fname = !empty($postdata)?$postdata['fname']:'';
											echo form_label('First Name *', 'fname');
											echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$fname), 'id' => "fname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2'));
											echo '<div class="error-msg">' . form_error('fname') . '</div>';
										?>
									</div>
								</div>
								<div class="col-md-5">
									<?php $sname = !empty($postdata)?$postdata['sname']:''; ?>
									<div class="form-group inputBox <?php echo !empty($sname)?'focus':''; ?>">
										<?php
											echo form_label('Last Name *', 'sname');
											echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$sname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3'));
											echo '<div class="error-msg">' . form_error('sname') . '</div>';
										?>
									</div>
								</div>
							</div>	
							<div class="row">
								<div class="col-md-6">
									<?php $email = !empty($postdata)?$postdata['email']:''; ?>
									<div class="form-group inputBox <?php echo !empty($email)?'focus':''; ?>">
										<?php
											echo form_label('Email *', 'email');
											echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$email), 'id' => "email",'maxlength'=>'50','tabindex'=>'4'));
											echo '<div class="error-msg">' . form_error('email') . '</div>';
										?>
									</div>
								</div>
								<div class="col-md-6 havwesomeadon">
									<div class="form-group inputBox focus">
										<?php echo form_label('Mobile Number *', 'phone'); ?>
										<div class="input-group">
											<span class="input-group-addon" id="sizing-addon1">+91</span>
											<?php
												$phone = !empty($postdata)?$postdata['phone']:'';
												echo form_input(array('name' => 'phone', 'class' => 'form-control input', 'value' => set_value('phone',$phone), 'id' => "phone", 'maxlength'=>'10','tabindex'=>'5'));
												echo '<div class="error-msg">' . form_error('phone') . '</div>';
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group inputBox focus">
										<label> Gender *</label>
										<input id="male" type="radio" name="gender" value="1" tabindex="6" checked> <span class="gnedrename">Male</span>&nbsp; &nbsp;
										<input id="female" type="radio" name="gender" value="2" <?php echo ($this->input->post('gender') == 2)?'checked':''; ?>> <span class="gnedrename">Female</span> &nbsp; &nbsp;
										<input id="other" type="radio" name="gender" value="3" <?php echo ($this->input->post('gender') == 3)?'checked':''; ?>> <span class="gnedrename">Other</span><br>
									</div>
								</div>
								<div class="col-md-6 customerdob">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label style="visibility: hidden; width: 100%"> Age Dob *</label>
												<input id="age" type="radio" name="agepriority" tabindex="7" checked> <span class="gnedrename">Age</span>&nbsp; &nbsp;
												<input id="dob" type="radio" name="agepriority"> <span class="gnedrename">DOB</span> &nbsp; &nbsp;
											</div>
										</div>
										<div class="col-md-6">
											<?php $c_dob = !empty($postdata)?$postdata['c_dob']:''; ?>
											<div class="form-group calendar-icon agecale inputBox <?php echo !empty($c_dob)?'focus':''; ?>" id="customer_dob" style="display:none;">
												<?php
													echo form_label('Date of Birth*', 'c_dob');
													echo form_input(array('name' => 'c_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('c_dob',$c_dob), 'id' => "c_dob",'tabindex'=>'8'));
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
								<div class="col-md-6">
									<?php 
										$c_password = '';
										if(!empty($postdata) && $postdata['user'] == '2'){
											$c_password = !empty($postdata)?$postdata['c_password']:'';
										}
									?>
									<div class="form-group inputBox <?php echo !empty($c_password)?'focus':''; ?>">
										<?php
											echo form_label('Password *', 'c_password');
											echo form_password(array('name' => 'c_password', 'class' => 'form-control input', 'value' => set_value('c_password',$c_password), 'id' => "c_password", 'maxlength'=>'50','tabindex'=>'10'));
											echo '<div class="error-msg">' . form_error('c_password') . '</div>';
										?>
										<!--<span id="result"></span> -->
									</div>
								</div>
								<div class="col-md-6">
									<?php 
										$c_cpassword = '';
										if(!empty($postdata) && $postdata['user'] == '2'){
											$c_cpassword = !empty($postdata)?$postdata['c_cpassword']:'';
										}
									?>
									<div class="form-group inputBox <?php echo !empty($c_cpassword)?'focus':''; ?>">
										<?php
											echo form_label('Confirm Password *', 'c_cpassword');
											echo form_password(array('name' => 'c_cpassword', 'class' => 'form-control input', 'value' => set_value('c_cpassword',$c_cpassword), 'id' => "c_cpassword",'maxlength'=>'50','tabindex'=>'11'));
											echo '<div class="error-msg">' . form_error('c_cpassword') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">						
									<p style="font-size: 13px; margin: 0"><input type="checkbox" name="terms" tabindex="12"> I accept the <u>Terms and Conditions</u></p>
									<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
								</div>
							</div>	
							<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
							<input type="hidden" name="action" value="validate_captcha">						
							<div class="row">	
								<div class="col-md-12 col-xs-12">
									 <div class="form-group btnisnide text-right">
										<input type ="reset" class="resetbtn btn btn-info btn-md btn-learn"  name ="reset" value ="Reset" tabindex="13" />
										<input type ="submit" class="btn btn-warning btn-md btn-learn" name ="submit" value ="Submit" tabindex="14" />
										
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>			  
						</div>
						<div class="tab-pane text-style floating-laebls" id="tab2">
							<?php echo form_open($pageUrl, array('class' => '', 'id' => 'form_consultant')); ?>
							<input type="hidden" name="user" value="3" />
							<div class="col-md-12a">
								<?php
									if($this->session->flashdata('responce_msg')!=""){
										$message = $this->session->flashdata('responce_msg');
										echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
									}
								?>
							</div>
							<div class="row mt-5">
								<div class="col-md-2">
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Title', 'title');
											$allprefix = [];
											foreach($prefixdata as $prefix){
												$allprefix[$prefix->id] = $prefix->title;
											}
											$title = !empty($postdata)?$postdata['title']:'';
											echo form_dropdown('title', $allprefix, set_value('title',$title), 'class="form-control input" id="title" tabindex="1"');
											echo '<div class="error-msg">' . form_error('title') . '</div>';
										?>
									</div>  
								</div>
								<div class="col-md-5"> 
									<?php $fname = !empty($postdata)?$postdata['fname']:''; ?>
									<div class="form-group inputBox <?php echo !empty($fname)?'focus':''; ?>">
										<?php
											echo form_label('First Name *', 'fname');
											echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$fname), 'id' => "fname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2'));
											echo '<div class="error-msg">' . form_error('fname') . '</div>';
										?>
									</div>
								</div>
								<div class="col-md-5">
									<?php $sname = !empty($postdata)?$postdata['sname']:''; ?>
									<div class="form-group inputBox <?php echo !empty($sname)?'focus':''; ?>">
										<?php
											echo form_label('Last Name *', 'sname');
											echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$sname), 'id' => "sname",'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3'));
											echo '<div class="error-msg">' . form_error('sname') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<?php $email = !empty($postdata)?$postdata['email']:''; ?>
									<div class="form-group inputBox <?php echo !empty($email)?'focus':''; ?>">
										<?php
											echo form_label('Email *', 'email');
											echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$email), 'id' => "email",'maxlength'=>'50','tabindex'=>'4'));
											echo '<div class="error-msg">' . form_error('email') . '</div>';
										?>
									</div>
								</div>
								<div class="col-md-6 havwesomeadon">
									<div class="form-group inputBox focus">
										<?php echo form_label('Mobile Number *', 'phone'); ?>
										<div class="input-group">
										  <span class="input-group-addon" id="sizing-addon1">+91</span>
											<?php
												$phone = !empty($postdata)?$postdata['phone']:'';
												echo form_input(array('name' => 'phone', 'class' => 'form-control input','id' => 'consultant_phone', 'value' => set_value('phone',$phone),'maxlength'=>'10','tabindex'=>'5'));
												echo '<div class="error-msg">' . form_error('phone') . '</div>';
											?>
										</div>
									</div>
								</div>
						   </div>
							
							<div class="row">
								<div class="col-md-6">
									<div class="form-group inputBox focus">
										<label> Gender *</label>
										<input id="male" type="radio" name="gender" value="1" tabindex="6" checked> <span class="gnedrename">Male</span>&nbsp; &nbsp;
										<input id="female" type="radio" name="gender" value="2" <?php echo ($this->input->post('gender') == 2)?'checked':''; ?>> <span class="gnedrename">Female</span> &nbsp; &nbsp;
										<input id="other" type="radio" name="gender" value="3" <?php echo ($this->input->post('gender') == 3)?'checked':''; ?>> <span class="gnedrename">Other</span><br>
									</div>
								</div>
								<div class="col-md-6">
									<?php $co_dob = !empty($postdata)?$postdata['co_dob']:''; ?>
									<div class="form-group calendar-icon inputBox <?php echo !empty($co_dob)?'focus':''; ?>">
										<?php
											echo form_label('Date of Birth *', 'co_dob');
											echo form_input(array('name' => 'co_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('co_dob',$c_dob), 'id' => "co_dob", 'tabindex'=>'7'));
											echo '<i class="fa fa-calendar dobcalaendaer"></i>';
											echo '<div class="error-msg">' . form_error('co_dob') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-9">
									<?php $c_address = !empty($postdata)?$postdata['c_address']:''; ?>
									<div class="form-group selectbox textares inputBox <?php echo !empty($c_address)?'focus':''; ?>">
										<?php
											echo form_label('Address *', 'c_address');
											echo form_input(array('name' => 'c_address', 'class' => 'form-control input', 'value' => set_value('c_address',$c_address), 'id' => "c_address",'maxlength'=>'255','tabindex'=>'8'));
											echo '<div class="error-msg">' . form_error('c_address') . '</div>';
										?>
									</div>
								</div>			
								<div class="col-md-3">
									<?php $c_pin = !empty($postdata)?$postdata['c_pin']:''; ?>
									<div class="form-group inputBox <?php echo !empty($c_pin)?'focus':''; ?>">
										<?php
											echo form_label('Pin code *', 'c_pin');
											echo form_input(array('name' => 'c_pin', 'class' => 'form-control input', 'value' => set_value('c_pin',$c_pin), 'id' => "c_pin",'maxlength'=>'6','tabindex'=>'9'));
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
											$c_country = !empty($postdata)?$postdata['c_country']:'';
											echo form_label('Country *', 'c_country');
											$allCountry        	= [];
											$allCountry['']    	= 'Select Country';
											$selected_country	= '88';
											if(!empty($countryquery)){
												foreach($countryquery as $singleCountryList){
													$allCountry[$singleCountryList->id] = $singleCountryList->name;
												}                    
											}                    
											echo form_dropdown('c_country', $allCountry, set_value('c_country',$selected_country), 'class="form-control input" id="c_country" tabindex="10" disabled="disabled"');
											echo form_hidden('c_country',$selected_country);
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
											$selected_state	= '38';
											if(!empty($statequery)){
												foreach($statequery as $singleStateList){
													$allstate[$singleStateList->id] = $singleStateList->name;
												}                    
											}                    
											echo form_dropdown('c_state', $allstate, set_value('c_state',$selected_state), 'class="form-control input" id="c_state" tabindex="11"'); 
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
											$c_city = !empty($postdata)?$postdata['c_city']:'';
											echo form_label('City *', 'c_city');
											$allcity      	= [];
											$allcity['']  	= 'Select City';
											if(!empty($cityquery)){
												foreach($cityquery as $singleCityList){
													$allcity[$singleCityList->city_id] = $singleCityList->city_name;
												}                    
											}                    
											echo form_dropdown('c_city', $allcity, set_value('c_city',$c_city), 'class="form-control input" id="c_city" tabindex="12"'); 
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
									<?php $co_password = !empty($postdata)?$postdata['co_password']:''; ?>
									<div class="form-group inputBox <?php echo !empty($co_password)?'focus':'';?> ">
										<?php
											echo form_label('Password *', 'co_password');
											echo form_password(array('name' => 'co_password', 'class' => 'form-control input', 'value' => set_value('co_password',$co_password), 'id' => "co_password",'maxlength'=>'50','tabindex'=>'13'));
											echo '<div class="error-msg">' . form_error('co_password') . '</div>';
										?>
										<!--<span id="result"></span> -->
									</div>
								</div>
								<div class="col-md-6">
									<?php $co_cpassword = !empty($postdata)?$postdata['co_cpassword']:''; ?>
									<div class="form-group inputBox <?php echo !empty($co_cpassword)?'focus':'';?>">
										<?php
											echo form_label('Confirm Password *', 'co_cpassword');
											echo form_password(array('name' => 'co_cpassword', 'class' => 'form-control input', 'value' => set_value('co_cpassword',$co_cpassword), 'id' => "co_cpassword",'maxlength'=>'50','tabindex'=>'14'));
											echo '<div class="error-msg">' . form_error('co_cpassword') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">  
									<?php $acc_type = !empty($postdata)?$postdata['acc_type']:''; ?>
									<div class="form-group inputBox focus" id="acc_tp">
										<?php
											echo form_label('Account Type*', 'acc_type');
											echo form_dropdown('acc_type', array(
												'' => 'Select Account Type',
												'freelancer' => 'Freelancer',
												'agency' => 'Agency'
											), $selected = set_value('acc_type',$acc_type), $extra = 'class= "form-control input" id="acc_type" tabindex="15"');
											echo '<div class="error-msg">' . form_error('acc_type') . '</div>';
										?>
									</div>
								</div>
								<div class="col-md-6"> 
									<?php $catlists = $this->user_model->getParentCategory(); ?>
									<div class="form-group inputBox focus" id="catandsubcat">
										<?php 
											echo form_label('Category & Subcategory*', 'getids');
											$getids = !empty($postdata)?$postdata['getids']:'';
										?>
										<input type="text" id="catsubcat" name="catsubcat" placeholder="Select Category & Subcategory" class="form-control input" tabindex="16" autocomplete="off" required />
										<input type="hidden" id="getids" name="getids" value="<?php echo $getids; ?>">
										<?php echo '<div class="error" id="subcat_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
									</div>
								</div>
								
							</div>
							<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
							<input type="hidden" name="action" value="validate_captcha">
							<div class="row">
							<div class="col-md-12">
								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="terms" tabindex="17"> I accept the <u>Terms and Conditions</u></p>
								<?php echo '<div class="error" id="terms_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
						</div>						
						<div class="row">	
							<div class="col-md-12 col-xs-12">
								 <div class="form-group btnisnide text-right">
									
									<input type ="reset" class="conresetbtn btn btn-info btn-md btn-learn"  name ="reset" value ="Reset" tabindex="18" />
									<input type ="submit" class="btn btn-warning btn-md btn-learn" name ="submit" value ="Submit" tabindex="19" />
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
					</div> 
				</div>
				<div class="col-sm-6">
					<?php /* <nav class="nav-sidebar">
						<ul class="nav tabs">
						  <li class="active">
							<a onclick="location.reload();" href="#tab1" data-toggle="tab" id="usertab">Customer</a>
						  </li>										  
						</ul>
					</nav> */ ?>						
				</div>
			</div>
		</div>
	</div>
</div>
<?php //if($this->input->post('user') == '3'){ ?>
	<script type="text/javascript">
		/* $(document).ready( function(){
			showType(<?php echo $this->input->post('user'); ?>);
		}); */
	</script>
<?php //}
/* echo '<script type="text/javascript">
        function showType(type) {
            var x 	= document.getElementById("acc_tp");
            var cat = document.getElementById("catandsubcat");
            if(type == 2) {
                x.style.display = "none";
                cat.style.display = "none";
            } else {
                x.style.display = "block";
                cat.style.display = "block";
            }
        }
		
</script>'; */ ?>
<script>
	$(document).ready( function(){         
		/*$("#cat_id").change(function(){
			var $option = $(this).find('option:selected');
			var catId = $option.val();	  
			$.ajax({
				url: '<?php echo base_url();?>frontend/frontController/getsubcatbycatid',
				data: {'catId': catId}, 
				type: "post",
				success: function(data){
					$("#subcat_id").html(data);
				}
			});
		});*/
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
		$('#consultant_tab').click(function(e){
			$('.title').text('Consultant Sign Up');
			$(this).hide();
			$('#customer_tab').show();
		});
		$('#customer_tab').click(function(e){
			$('.title').text('Customer Sign Up');
			$(this).hide();
			$('#consultant_tab').show();
		});
		
	});
</script>
<script>
<?php
	$allcategoryarray 		= [];
	$parentcategoryarray 	= [];
	$subcategoryarray 		= [];
	$a = 0;
	foreach($category as $key => $value){
		$allcategoryarray[$a]['id'] 	= $value->id;
		$allcategoryarray[$a]['title'] 	= $value->name;
		$allsubcat = $this->user_model->getsubcategory($value->id);
		$newa = 0;
		foreach($allsubcat as $subcat){
			$subcategoryarray[$newa]['id'] 	= $subcat->id;
			$subcategoryarray[$newa]['title'] 	= $subcat->name;
			$newa++; 
		}
		$allcategoryarray[$a]['subs'] = $subcategoryarray;
		$a++; 
	}
?>

var SampleJSONData2 = <?php echo json_encode($allcategoryarray); ?>;
var comboTree3;
comboTree3 = $('#catsubcat').comboTree({
	source : SampleJSONData2,
	isMultiple: true,
	cascadeSelect: true,
	collapse: true,
	selectableLastNode:true,
	hiddeninput:'#getids'
});
comboTree3.setSource(SampleJSONData2);


$('#age').click(function(){
	$('#customer_dob').hide();
	$('#cr_age').show();
});
$('#dob').click(function(){
	$('#customer_dob').show();
	$('#cr_age').hide();
});
</script>