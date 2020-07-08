<style>
	label.error {
		margin-top: -1px;
		font-size: 12px;
	}
	.error {
		color: red;
		font-size: 12px;
	}
	.btn-warning {
		background: #F3781E;
		color: #fff;
		border: 2px solid #F3781E;
	}
	.custom-form label.error {
		color: red;
		font-size: 10px;
		line-height: 12px;
	}
</style>
<div class="bgsectionlogin">
	<div class="container vertical-center">
		<div class="row my-5">	
			<div class="register-formbg loginwindow loginlu">
				<div class="thim-login form-submission-register custom-form loginonly">
					<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
						<h2 class="puttocenter">User Sign In</h2>
					</div>
					<div class="floating-laebls">
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
							<div class="form-group inputBox">
								<?php
									echo form_label('Email<span class="required">*</span>', 'username');
									echo form_input(array('type'=>'email','name' => 'username', 'class' => 'form-control input', 'value' => set_value('username'), 'id' => "username"));
									echo '<div class="error-msg">' . form_error('username') . '</div>';
								?>
							</div>
							<div class="form-group inputBox">
								<?php
									echo form_label('Password<span class="required">*</span>', 'password');
									echo form_password(array('name' => 'password', 'class' => 'form-control input', 'value' => set_value('password'), 'id' => "password"));
									echo '<div class="error-msg">' . form_error('password') . '</div>';
								?>
							</div>
							<a class="fgrtpswd" href="<?php echo base_url().'forgetpassword';?>">Forget Password?</a>
							<a href="<?php echo base_url().'registration';?>" class="fgrtpswd pull-right">Sign Up</a>
							<div class="row">
								
								<div class="col-md-12">
									<div class="form-group" style="margin-top: 10px;">
										<input class="btn btn-warning btn-md btn-learn" type="submit" name="submit" value ="Login" style="width:100%">
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>