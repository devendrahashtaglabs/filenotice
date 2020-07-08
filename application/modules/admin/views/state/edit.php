<style>
.form-group:last-of-type {
    margin-top: unset;
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
        
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $page_title; ?></h3>
                        </div>
                        <?php
                        echo form_open($pageUrl, array('class' => 'Edit_category', 'id' => 'StateForm'));
                        ?>
                        <div class="card-body floating-laebls">
                            <div class="row">
                                <div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Country Name*', 'country_name');
											$option = array('' => 'Select Country');
											$option[$row->country_id] = ucfirst($this->user_model->getCountryList($row->country_id)->name);
											echo form_dropdown('country_name', $option, $selected = set_value('country_name',$row->country_id), $extra = 'class="form-control input", id="country_name"');
											echo '<div class="error-msg">' . form_error('country_name') . '</div>';
										?>
									</div>
								</div>
                                <div class="col-6">                            
									<div class="form-group inputBox <?php echo !empty($row->id)?'focus':''; ?>">
										<?php
											echo form_label('State Name*', 'state_name');
											echo form_input(array('name' => 'state_name', 'class' => 'form-control input', 'value' => $row->name, 'id' => "state_name"));
											echo form_input(array('name' => 'id', 'type' => 'hidden', 'value' => $row->id, 'id' => "id"));
											echo '<div class="error-msg">' . form_error('state_name') . '</div>';
										?>
									</div>
                                </div>
                            </div>
							<div class="row">
                                <div class="col-6">                            
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Status*', 'state_status');
											echo form_dropdown('state_status', $options = array(
												'1' => 'Active',
												'0' => 'Inactive',
													), $selected = set_value('state_status',$row->status), $extra = 'class="form-control input",id="state_status"');
											echo '<div class="error-msg">' . form_error('state_status') . '</div>';
										?>
									</div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<?php
											echo form_submit(array("class" => "btn btn-primary", "id" => "update_cat_btn", "value" => "Submit"));
											echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('user_type') . '/admin/state/state_list') . '" class="btn btn-default">Cancel</a>';
										?>
									</div>
								</div>
                            </div>
						</div>
						<?php echo form_close(); ?>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
    </section>
</div>