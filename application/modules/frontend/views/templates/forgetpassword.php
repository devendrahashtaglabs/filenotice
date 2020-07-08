	<style>
		.vertical-center {
		  min-height: 100%; 
		  /*min-height: 100vh*/;    
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
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
			-webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
			-o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		}
		#form_customer label span{
			color:#F00;
		}
		.jumbotron {
			margin:0;
		}
		.thim-login.form-submission-register.custom-form.loginonly.fgot {
			padding: 0px 0px 20px;
			background: #fdfdfd;
		}
		#forgot-form {
	padding: 0px 20px 0;
}
.custom-form .sc_heading.text-center h2 {
	margin: 0 0 10px !important;
	font-size: 18px;
}
.custom-form label {
	display: inline-block;
	max-width: 100%;
	margin-bottom: 0;
	font-weight: 400;
	color: #333;
	font-size: 8px;
	line-height: 17px;
}
.bgsectionlogin .form-control {
	height: 30px;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
}
.form-group {
	margin-bottom: 8px;
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
	.my-5 {
	margin: 1.5em 0px;
}
    </style>
    <div class="bgsectionlogin loginregisfor">
	<div class="container">
		<div class="row my-5">
		    <div class="col-md-6">
			<div class="tab-content resttabs">
				<div class="">
					<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
							<h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 15px 8px;color: #fff;min-height: 65px;"><?php echo $section_name; ?></h2>
						</div>
				  
					  <div class="floating-laebls">
					  <!-- Your code here -->
						<?php echo form_open($pageUrl, array('class' => '', 'id' => 'forgot-form')); ?>
							<div class="col-md-12a">
								<?php
									if($this->session->flashdata('responce_msg')!=""){
										$message = $this->session->flashdata('responce_msg');
										echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
									}
								?>
							</div>
							<div class="col-md-12a mt-5">
								<div class="form-group inputBox">
									<?php
										echo form_label('Email Id*', 'email');
										echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email'), 'id' => "email"));
										echo '<div class="error-msg">' . form_error('email') . '</div>';
									?>
								</div>        
								<div class="form-group text-center" style="margin-top: 20px;">
									<input type ="submit" class="btn btn-warning btn-md btn-learn" name ="submit" value ="Submit" style="width: 100%">
								</div>
							</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
			
		</div>

</div>
    <div class="col-md-8">
	</div>
	</div>
</div>