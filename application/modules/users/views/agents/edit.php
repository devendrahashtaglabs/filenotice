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
										echo '<div class="error-msg">' . form_error('account_type') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($consultant->name)?'focus':'';?>">
									<?php
										echo form_label('Agent Name *', 'user_name');
										echo form_input(array('name' => 'user_name', 'class' => 'form-control input', 'value' => set_value('user_name',$consultant->name), 'id' => "user_name"));
										echo '<div class="error-msg">' . form_error('user_name') . '</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($consultant->email)?'focus':'';?>">
									<?php
										echo form_label('Email Address*', 'user_email');
										echo form_input(array('name' => 'user_email', 'class' => 'form-control input', 'value' => set_value('user_email',$consultant->email), 'id' => "user_email", 'disabled' => 'disabled' ));
										echo form_input(array('name' => 'user_email', 'type' => 'hidden', 'value' => $consultant->email, 'id' => "consultant_id"));
										echo '<div class="error-msg">' . form_error('user_email') . '</div>';
									?>
								</div>
                            </div>
                           <!--  <div class="form-group col-6">
                                    <?php
                                    //echo form_label('Password*', 'password');
                                    //echo form_input(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'), "placeholder" => "Enter Password"));
                                    //echo '<div class="error-msg">' . form_error('password') . '</div>';
                                    ?>
                                </div> -->
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($consultant->mobile)?'focus':'';?>">
									<?php
										echo form_label('Mobile Number*', 'user_mobile');
										echo form_input(array('name' => 'user_mobile', 'class' => 'form-control input', 'id' => 'user_mobile', 'value' => set_value('user_mobile',$consultant->mobile), 'maxlength' => '10'));
										echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
									?>
								</div>
                            </div>  
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$setdt = empty($consultant->dob)? '' : date('d-m-Y', strtotime($consultant->dob));
								?>
								<div class="form-group inputBox <?php echo !empty($setdt)?'focus':'';?>">
									<?php
										echo form_label('Date Of Birth', 'user_dob');
										echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('user_dob',$setdt), 'id' => 'dob', 'readonly'=>'readonly'));
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
											'3' => 'Other',
										), $selected = set_value('user_gender',$consultant->gender), $extra = 'class= "form-control input" id="user_gender"');
										echo'<div class="error-msg">' . form_error('user_gender') . '</div>';
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
											'2' => 'Inactive'
										), $selected = set_value('user_status',$consultant->status), $extra = 'class= "form-control input",id="user_status"');
										echo'<div class="error-msg">' . form_error('user_status') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Country*', 'user_country');
										$option = array('' => 'Select Country');
										foreach ($countryList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_dropdown('user_country',$option,$selected=set_value('user_country',$consultant->country_id),$extra='class="form-control input select-state" data-section="create_consultant" data-stateid="'.DEFAULT_STATE.'" disabled=disabled');
										echo '<div class="error-msg">' . form_error('user_country') . '</div>';
									?>
									<input type="hidden" name="user_country" value="<?php echo DEFAULT_COUNTRY;?>" />
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
										echo form_dropdown('user_state', $option, set_value('user_state',$selectedState), 'class="form-control input" id="user_state"');
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
										echo '<div class="error-msg">' . form_error('user_city') . '</div>';
										/* echo form_label('City', 'user_city');
										echo form_input(array("name" => "user_city", "value" => set_value('user_city',$consultant->city_id), "id" => "user_city", "class" => "form-control", "placeholder" => "Enter City"));
										echo'<div class="error-msg">' . form_error('user_city') . '</div>'; */
									?>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($consultant->zip)?'focus':''; ?>">
									<?php
										echo form_label('Pin Code', 'pin_code');
										echo form_input(array('name' => 'pin_code', 'class' => 'form-control input', 'value' => set_value('pin_code',$consultant->zip), 'maxlength' => '6'));
										echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
									?>
								</div>
							</div>                            
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($consultant->address)?'focus':''; ?>">
									<?php
										echo form_label('Address', 'user_address');
										$data = array(
											'name' => 'user_address',
											'class' => 'form-control input',
											'value' => set_value('user_address',$consultant->address),
											'cols' => '4',
											'rows' => '2',
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
									echo '&nbsp;&nbsp;<a href="' . base_url('/agent') . '" class="btn btn-default">Cancel</a>';
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
			url: '<?php echo base_url();?>users/customerController/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#user_city").html(data);
			}
		});
	});
</script>