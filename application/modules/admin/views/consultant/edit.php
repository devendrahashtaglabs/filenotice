<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
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
                        <h3 class="card-title"><?php echo $page_title; // echo $page_title.' =><a href="'.$pageUrl.'">Step 1(General Info)</a>'."=>".'<a href="'.$edit_info.'">Step 2(Bank Info)</a>'; ?></h3>
                    </div>
                    <?php echo form_open($pageUrl, array('class' => 'create_users', 'id' => 'ConsultantForm')); ?>
                    <div class="card-body floating-laebls">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
							$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
                        ?>
                        <div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Account Type*', 'account_type');
										echo form_dropdown('account_type', array(
											'' 				=> 'Select Account Type',
											'freelancer' 	=> 'Freelancer',
											'agency' 		=> 'Agency'
										), $selected = set_value('account_type',$consultant->account_type), $extra = 'class= "form-control input" id="account_type"');
										echo '<div id="account_type_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('account_type') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Title *', 'title');
										$allprefix = [];
										foreach($prefixdata as $prefix){
											$allprefix[$prefix->id] = $prefix->title;
										}
										echo form_dropdown('title', $allprefix, $selected = set_value('title',$consultant->title), $extra = 'class= "form-control input" id="title"');
										echo '<div id="title_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('title') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<?php 
									$user_name_focus 	= !empty($consultant->name)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $user_name_focus; ?>">
                                <?php
									echo form_label('First Name*', 'user_name');
									echo form_input(array('name' => 'user_name', 'class' => 'form-control input', 'value' => set_value('user_name',$consultant->name), 'id' => "user_name", 'onkeypress'=> 'return alpha(event)'));
                                    echo '<div id="name_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                ?>
                                </div>
                            </div>
							<div class="col-6">
								<?php 
									$sname_focus 	= !empty($consultant->sname)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $sname_focus; ?>">
                                <?php
									echo form_label('Last Name*', 'sname');
									echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$consultant->sname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)'));
                                    echo '<div id="sname_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                ?>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
								<?php 
									$email_focus = !empty($consultant->email)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $email_focus; ?>">
                                <?php
                                    echo form_label('Email address <span class="required">*</span>', 'user_email');
                                    echo form_input(array('type'=>'email','name' => 'user_email', 'class' => 'form-control input', 'value' => set_value('user_email',$consultant->email), 'id' => "user_email",));
									echo '<div id="email_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_email') . '</div>';
                                ?>
                                </div>
                            </div>
							<div class="col-6">
								<?php 
									$mobile_focus = !empty($consultant->mobile)?"focus":"";
								?>
								<div class="form-group inputBox <?php echo $mobile_focus; ?>">
									<?php
										echo form_label('Mobile Number <span class="required">*</span>', 'user_mobile');
										echo form_input(array('name' => 'user_mobile', 'class' => 'form-control input','id' => 'user_mobile', 'value' => set_value('user_mobile',$consultant->mobile), 'maxlength' => '14',));
										echo '<div id="mobile_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
									?>
								</div>   
							</div>
                        </div>
						<div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										$setdt = empty($consultant->dob)? '' : date('d-m-Y', strtotime($consultant->dob));
										echo form_label('Date Of Birth', 'user_dob');
										echo form_input(array('name' => 'user_dob', 'class' => 'form-control input datepickerdob', 'value' => set_value('user_dob',$setdt), 'id' => 'dob','readonly'=>'readonly'));
										echo '<div id="dob_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Gender', 'user_gender');
										echo form_dropdown('user_gender', $options = array(
											'1' => 'Male',
											'2' => 'Female',
											'3' => 'Other'
										), $selected = set_value('user_gender',$consultant->gender), $extra = 'class= "form-control input" id="user_gender"');
										echo '<div class="error-msg">' . form_error('user_gender') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Status', 'user_status');
										echo form_dropdown('user_status', $options = array(
											'1' => 'Active',
											'0' => 'Inactive'
										), $selected = set_value('user_status',$consultant->userstatus),$extra = 'class= "form-control input" id="user_status"');
										echo '<div class="error-msg">' . form_error('user_status') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Country <span class="required">*</span>', 'user_country');
										$option = array('' => 'Select Country');
										foreach ($countryList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_dropdown('user_country',$option,$selected=set_value('user_country',$consultant->country_id),$extra='class="form-control select-state input" data-section="user_state" data-stateid="'.DEFAULT_STATE.'" id="user_country" disabled="disabled"');
										echo '<div id="country_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('user_country') . '</div>';
									?>
									<input type="hidden" name="user_country" class="form-control" value="<?php echo DEFAULT_COUNTRY; ?>" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('State*', 'user_state');
										$option = array('' => 'Select State');
										foreach ($stateList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										$selectedState = isset($consultant->state_id)?$consultant->state_id:'';
										//echo form_dropdown('user_state', $option,set_value('user_state','3'), $extra = 'class= "form-control" id="create_consultant"');
										echo form_dropdown('user_state', $option, set_value('user_state',$selectedState), 'class="form-control input" id="user_state"');
										echo '<div id="state_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('user_state') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										$cityquery = $this->user_model->getCityList('',$consultant->state_id);
										echo form_label('City *', 'user_city');
										$allcity      	= [];
										$allcity['']  	= 'Select City';
										if(!empty($cityquery)){
											foreach($cityquery as $singleCityList){
												$allcity[$singleCityList->city_id] = $singleCityList->city_name;
											}                    
										}                    
										echo form_dropdown('user_city', $allcity, set_value('user_city',$consultant->city_id), 'class="form-control input" id="user_city"'); 
										echo '<div id="city_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('user_city') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<?php 
									$pin_focus = !empty($consultant->zip)?"focus":"";
								?>
								<div class="form-group inputBox <?php echo $pin_focus; ?>">
									<?php
										echo form_label('Pin Code', 'pin_code');
										echo form_input(array('name' => 'pin_code', 'class' => 'form-control input', 'maxlength' => '6', 'value' => set_value('pin_code',$consultant->zip)));
										echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">  
								<?php 
									$address_focus = !empty($consultant->address)?"focus":"";
								?>
								<div class="form-group inputBox <?php echo $address_focus; ?>">
									<?php
										echo form_label('Address', 'user_address');
										$data = array(
											'name' 	=> 'user_address',
											'class' => 'form-control input',
											'value' => set_value('user_address',$consultant->address),
											'cols' 	=> '4',
											'rows' 	=> '2',
										   
										);
										echo form_textarea($data);
										echo '<div class="error-msg">' . form_error('user_address') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
									echo form_submit(array("class" => "btn btn-primary", "id" => "create_user_btn", "value" => "Submit"));
									echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
	$("#user_state").change(function() { 
		var $option = $(this).find('option:selected');
		var stateId = $option.val();
		$.ajax({
			url: '<?php echo base_url();?>admin/admin/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#user_city").html(data);
			}
		});
	});
</script>