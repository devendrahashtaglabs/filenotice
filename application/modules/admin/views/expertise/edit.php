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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                    <?php
						echo form_open($pageUrl, array('class' => 'Edit_expertise', 'id' => 'ExpertiseForm'));
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
								<div class="form-group inputBox <?php echo !empty($row->id)?'focus':''; ?>">
									<?php
										echo form_label('Expertise Name*','exp_name');
										echo form_input(array('name' => 'exp_name', 'class' => 'form-control input', 'value' => $row->name, 'id' => "exp_name"));
										echo form_input(array('name' => 'id','type'=>'hidden' ,'value' => $row->id, 'id' => "id"));
										echo '<div class="error-msg">' . form_error('exp_name') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">                            
								<div class="form-group inputBox focus">
									<?php 
										echo form_label('Expertise Status*','exp_status'); 
										echo form_dropdown('exp_status', $options=array(
											''=>'Select Status',
											'1'=>'Active',
											'0'=>'Inactive'
										), $selected=$row->status,$extra ='class="form-control input",id="exp_status"');
										echo '<div class="error-msg">' . form_error('exp_status') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "update_exp_btn", "value" => "Submit"));
										echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type'].'/expertise/expertise_list') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>






