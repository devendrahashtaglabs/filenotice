<style>
	#form_customer label span{
		color:#F00;
	}
	.error {
		color: red;
		font-size: 12px;
	}
	.jumbotron {
		margin:0;
	}
</style>
<div class="container vertical-center">
	<div class="row my-5">
   <div class="register-formbg loginwindow">
		<div class="thim-login form-submission-register custom-form loginonly fgot">
			<div class="sc_heading   text-center" style="padding: 0;">
				<h2 class="title" style="margin: 0;"><?php echo $section_name; ?></h2>
			</div>
			<?php 
				$userData	= $this->user_model->getActivationdetail('activation_code',$activationid);
				if(!empty($userData))                        
				{ 
			?>
			<div class="floating-laebls">
				<!-- Your code here -->
				<?php echo form_open($pageUrl,array('class' => '', 'id' => 'form_resets')); ?>
					<div class="col-md-12a">
						<?php 
							if($this->session->flashdata('responce_msg')!=""){ 
							$message = $this->session->flashdata('responce_msg'); 
							echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']); 
							} 
						?>
					</div>
					<div class="col-md-12 mt-5">
						<div class="form-group inputBox">
							<?php
								echo form_label('New Password *', 'newpassword');
								echo form_password(array('name' => 'newpassword', 'class' => 'form-control input', 'value' => set_value('newpassword'), 'id' => "newpassword"));
								echo '<div class="error-msg">' . form_error('newpassword') . '</div>';
							?>
						</div>
						<div class="form-group inputBox">
							<?php
								echo form_label('Confirm Password *', 'confirmpassword');
								echo form_password(array('name' => 'confirmpassword', 'class' => 'form-control input', 'value' => set_value('confirmpassword'), 'id' => "confirmpassword"));
								echo '<div class="error-msg">' . form_error('confirmpassword') . '</div>';
							?>
						</div>
						<div class="form-group" style="margin-top: 10px;">
							<input type="submit" class="btn btn-primary btn-md btn-learn" name ="submitpassword" value="Submit" style="width: 100%">
						</div>
					</div>
				<?php echo form_close(); ?>
			</div>
			<?php } else { ?>
				<div class="form-group text-center">
					<label style="color:blue" id="password-update">Your password has been changed.</label>
				</div>
			<?php } ?>
        </div>
      </div>
      </div>
    </div>
	<script>
		$("#password-update").fadeOut(3000,function(){
			window.location.href = "<?php echo base_url().'login';?>"
		});
	</script>