<style>
    .form-group.has-feedback {
    position: relative;
}
.form-group.has-feedback span {
    position: absolute;
    top: 0;
    left: 10px;
}
.form-group.has-feedback input {
    padding-left: 30px;
}
.alert-dismissible strong{
    display:none;
}
.login-page {
    background: #f1f1f1;
}
</style>
<div class="bgsectionlogin loginregisfor logn">
    <div class="container vertical-center">
        <div class="row ">
            <div class="col-md-6">
            	<div class="herelogo">
            		<img src="<?php echo base_url(); ?>cosmatics/images/flogo.png">
            	</div>
                <div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
					<h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 15px 8px;color: #fff;min-height: 65px;"><?php echo $page_title; ?></h2>
				</div>
				<div class="card">
					<div class="card-body login-card-body">
						<div class="floating-laebls">
							<div class="col-md-12a  mt-5"></div>
							<?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
							?>
							<?php echo form_open($pageUrl); ?>
							<div class="form-group inputBox has-feedback">
								<?php 
									echo form_label('Email *', 'username');
									echo form_input(array('name' => 'username','id' => 'username', 'value'=>set_value('username'), 'class' => 'form-control input',)); 
								?>
								<?php echo '<div class="error-msg">' . form_error('username') . '</div>'; ?>
							</div>
							<div class="form-group inputBox has-feedback">
								<?php 
									echo form_label('Password *', 'password'); 
									echo form_password(array('name' => 'password', 'value'=>'', 'id'=>'password', 'class' => 'form-control input',)); 
									echo '<div class="error-msg">' . form_error('password') . '</div>';
								?>
							</div>
							<div class="row">
							  <div class="col-12">
								<div class="checkbox icheck">
									<p class="mb-1"><a href="<?php echo base_url().'admin/forgot_password'; ?>">Forgot Password?</a></p>
								</div>
							  </div>
							  <div class="col-12">
								<?php echo form_submit(array("name" => "login_btn", "class" => "btn btn-warning btn-md btn-learn newlogin", "id" => "login-btn", "value" => "Sign In")); ?>
							  </div>
							  <div class="col-md-12">
							  		<div class="backtohome">
 <a href="<?php echo base_url() ?>"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Back to home</a></div>
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