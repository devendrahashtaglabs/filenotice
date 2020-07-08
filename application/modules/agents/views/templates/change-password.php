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
                            <h3 class="card-title"><?php echo $page_title; ?></h3>
                        </div>
                        <?php
                        echo form_open($pageUrl, array('id' => 'ChangePwForm'));
                        ?>
                        <div class="card-body">
                            <?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
                            ?>
                            <div class="row">
                                <div class="form-group col-7">
                                    <?php
										echo form_label('Password*', 'old_password');
										echo form_password(array('name' => 'old_password', 'class' => 'form-control', 'value' => set_value('old_password'), "placeholder" => "Old Password"));
										echo '<div class="error-msg">' . form_error('old_password') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-7">
                                    <?php
										echo form_label('New Password*', 'new_password');
										echo form_password(array('name' => 'new_password', 'class' => 'form-control', 'value' => set_value('new_password'), 'id' => 'new_password', 'placeholder'=>'New Password'));
										echo '<div class="error-msg">' . form_error('new_password') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-7">
                                    <?php
										echo form_label('Confirm Password*', 'confirm_password');
										echo form_password(array('name' => 'confirm_password', 'class' => 'form-control', 'value' => set_value('confirm_password'), 'placeholder' => 'Confirm Password'));
										echo '<div class="error-msg">' . form_error('confirm_password') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-12">
                                <?php
                                    echo form_submit(array("class" => "btn btn-success", "id" => "creatre_user_btn", "value" => "Submit"));
                                    echo '&nbsp;&nbsp;<a href="' . base_url('agent/dashboard') . '" class="btn btn-danger">Cancel</a>';
                                ?>
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
