<style type="text/css">
.btn.btn-warning {
    background: #F3781E;
    color: #fff;
    border: 2px solid #F3781E;
}
.btn.btn-danger {
    background: #263a7d;
    color: #fff;
    border: 2px solid #263a7d;
}
.changesbg {
    background: #f4f4ff;
    padding: 10px;
}
.changesbg .form-control {
    height: 30px;
    padding: 1px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    background-color: #fff;
}
.changesbg label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0;
    font-weight: 400;
    color: #333;
    font-size: 8px;
    line-height: 17px;
}
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $section_name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo $breadcrumb; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('success_msg')): ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <?php echo $this->session->flashdata('success_msg'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="card card-sucess">
                        <div class="card-header">
                            <h3 class="card-title"><?php //echo $page_title; ?></h3>
                        </div>
                        <?php
                        echo form_open($pageUrl, array('id' => 'ChangePwForm'));
                        ?>
                        <div class="card-body floating-laebls">
							<?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
							?>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox">
										<?php
											echo form_label('Old Password*', 'old_password');
											echo form_password(array('name' => 'old_password', 'class' => 'form-control input', 'value' => set_value('old_password')));
											echo '<div class="error-msg">' . form_error('old_password') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6">                            
									<div class="form-group inputBox">
										<?php
											echo form_label('New Password*', 'new_password');
											echo form_password(array('name' => 'new_password', 'class' => 'form-control input', 'value' => set_value('new_password'), 'id' => 'new_password'));
											echo '<div class="error-msg">' . form_error('new_password') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">                            
									<div class="form-group inputBox">
										<?php
											echo form_label('Confirm Password*', 'confirm_password');
											echo form_password(array('name' => 'confirm_password', 'class' => 'form-control input', 'value' => set_value('confirm_password')));
											echo '<div class="error-msg">' . form_error('confirm_password') . '</div>';
										?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<?php
											echo form_submit(array("class" => "btn btn-primary", "id" => "creatre_user_btn", "value" => "Submit"));
											echo '&nbsp;&nbsp;<a href="' . base_url('dashboard') . '" class="btn btn-default">Cancel</a>';
										?>
									</div>
								</div>
							</div>
						</div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
