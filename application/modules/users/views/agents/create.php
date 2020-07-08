<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
}
</style>
<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $section_name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo isset($breadcrumb)?$breadcrumb:''; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title . ' / Step 1'; ?></h3>
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
										), $selected = set_value('account_type'), $extra = 'class= "form-control input" id="account_type"');
										echo '<div class="error-msg">' . form_error('account_type') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Agent Name*', 'user_name');
										echo form_input(array('name' => 'user_name', 'class' => 'form-control input', 'value' => set_value('user_name'), 'id' => "user_name",'onkeypress'=> 'return alpha(event)'));
										echo '<div class="error-msg">' . form_error('user_name') . '</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Email Address*', 'user_email');
										echo form_input(array('name' => 'user_email', 'class' => 'form-control input', 'value' => set_value('user_email'), 'id' => "user_email"));
										echo '<div class="error-msg">' . form_error('user_email') . '</div>';
									?>
								</div>
                            </div>
                            <?php /*<div class="form-group col-6">
                                    <?php
                                    echo form_label('Password*', 'password');
                                    echo form_input(array('name' => 'password', 'type'=>'password', 'class' => 'form-control', 'value' => set_value('password'), "placeholder" => "Enter Password"));
                                    echo '<div class="error-msg">' . form_error('password') . '</div>';
                                    ?>
                                </div> */ ?>
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Mobile Number*', 'user_mobile');
										echo form_input(array('name' => 'user_mobile', 'class' => 'form-control input', 'id' => 'user_mobile', 'value' => set_value('user_mobile'), 'maxlength' => '10'));
										echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Date Of Birth', 'user_dob');
										echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('user_dob'), 'id' => 'dob','readonly'=>'readonly'));
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
											'3' => 'Others'
										), $selected = set_value('user_gender'), $extra = 'class= "form-control input",id="user_gender"');
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
										), $selected = set_value('user_status'), $extra = 'class= "form-control input",id="user_status"');
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
									echo form_dropdown('user_country',$option,$selected=set_value('user_country',DEFAULT_COUNTRY),$extra='class="form-control input select-state" data-section="create_consultant" data-stateid="'.DEFAULT_STATE.'" disabled=disabled');
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
										echo form_dropdown('user_state', $option, $selected = set_value('user_state'), $extra = 'class= "form-control input" id="create_consultant"');
										echo '<div class="error-msg">' . form_error('user_state') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										$cityquery = $this->user_model->getCityList('',DEFAULT_STATE);
										echo form_label('City *', 'user_city');
										$allcity      	= [];
										$allcity['']  	= 'Select City';
										if(!empty($cityquery)){
											foreach($cityquery as $singleCityList){
												$allcity[$singleCityList->city_id] = $singleCityList->city_name;
											}                    
										}                    
										echo form_dropdown('user_city', $allcity, set_value('user_city'), 'class="form-control input" id="user_city"'); 
										echo '<div class="error-msg">' . form_error('user_city') . '</div>';
										/* echo form_label('City*', 'user_city');
										echo form_input(array("name" => "user_city", "value" => set_value('user_city'), "id" => "user_city", "class" => "form-control", "placeholder" => "Enter City",'onkeypress'=> 'return alpha(event)'));
										echo'<div class="error-msg">' . form_error('user_city') . '</div>'; */
									?>

								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Pin Code', 'pin_code');
										echo form_input(array('name' => 'pin_code', 'class' => 'form-control input', 'value' => set_value('pin_code'), 'maxlength' => '6'));
										echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
									?>
								</div>
                            </div>
							<div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Address', 'user_address');
										$data = array(
											'name' => 'user_address',
											'class' => 'form-control input',
											'value' => set_value('user_address'),
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
	$("#create_consultant").change(function() { 
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
