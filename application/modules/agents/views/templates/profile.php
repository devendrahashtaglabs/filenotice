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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sucess">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $page_title; ?></h3>
                        </div>
                        <?php 
							echo form_open_multipart($pageUrl, array('id' => 'ProfileForm'));
                        ?>
                        <div class="card-body">
                            <?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
                            ?>
                            <div class="row">
                                <?php if($usersData->user_type=='4'){ ?>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Account Type *', 'account_type');
										echo form_dropdown('account_type', array(
											'' => 'Select Account Type',
											'freelancer' 	=> 'Freelancer',
											'agency'      	=> 'Agency'
										), $selected = set_value('account_type',$usersData->account_type), $extra = 'class= "form-control" id="account_type"');
										echo '<div class="error-msg">' . form_error('account_type') . '</div>';
                                    ?>
                                </div>
                                <?php } ?>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Name *', 'user_name');
										echo form_input(array('name' => 'user_name', 'class' => 'form-control', 'value' => set_value('user_name',$usersData->name), 'id' => "user_name", "placeholder" => "Name"));
										echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Email *', 'user_email');
										echo form_input(array('name' => 'user_emails', 'class' => 'form-control', 'value' => set_value('user_email',$usersData->email), 'id' => "user_email", 'placeholder' => 'Enter email','disabled' => 'disabled'));
										echo form_input(array('type'=>'hidden','name' => 'user_email', 'class' => 'form-control', 'value' => set_value('user_email',$usersData->email)));
										echo '<div class="error-msg">' . form_error('user_email') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Mobile Number *', 'user_mobile');
										echo form_input(array('name' => 'user_mobile', 'class' => 'form-control', 'value' => set_value('user_mobile',$usersData->mobile), 'maxlength' => '10', 'placeholder' => 'Mobile Number'));
										echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Date Of Birth *', 'user_dob');
										echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob', 'value' => set_value('user_dob',$usersData->dob), 'id' => 'dob', 'placeholder' => 'Date Of Birth', 'readonly'=>'readonly'));
										echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Country *', 'user_country');
										$option = array('' => 'Select Country');
										foreach ($countryList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_dropdown('user_country',$option,$selected=set_value('user_country',$usersData->country_id),$extra='class="form-control select-state" data-section="edit_state" data-stateid="'.$usersData->state_id.'" id="user_country" disabled="disabled"');
										echo '<div class="error-msg">' . form_error('user_country') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('State *', 'user_state');
										$option = array('' => 'Select State');
										echo form_dropdown('user_state', $option, $selected = set_value('user_state'), $extra = 'class= "form-control" id="edit_state"');
										echo '<div class="error-msg">' . form_error('user_state') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										$cityquery = $this->user_model->getCityList('',$usersData->state_id);
										echo form_label('City *', 'user_city');
										$allcity      	= [];
										$allcity['']  	= 'Select City';
										if(!empty($cityquery)){
											foreach($cityquery as $singleCityList){
												$allcity[$singleCityList->city_id] = $singleCityList->city_name;
											}                    
										}                    
										echo form_dropdown('user_city', $allcity, set_value('user_city',$usersData->city_id), 'class="form-control" id="user_city"'); 
										echo '<div class="error-msg">' . form_error('user_city') . '</div>';
										/* echo form_label('City', 'user_city');
										echo form_input(array('name' => 'user_city', 'class' => 'form-control', 'value' => set_value('user_city',$usersData->city_id), 'id' => 'user_city', 'placeholder' => 'Enter City'));
										 echo '<div class="error-msg">' . form_error('user_city') . '</div>'; */
                                    ?> 
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Pin Code *', 'pin_code');
										echo form_input(array('name' => 'pin_code', 'class' => 'form-control', 'value' => set_value('pin_code',$usersData->zip), 'maxlength' => '6', 'placeholder' => 'Pincode'));
										 echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
                                    ?> 
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Gender *', 'user_gender');
										echo form_dropdown('user_gender', $options = array(
											'' => 'Select Gender',
											'1' => 'Male',
											'2' => 'Female',
											'2' => 'Other'
												), $selected = set_value('user_gender',$usersData->gender), $extra = 'class= "form-control" id="user_gender"');
										 echo '<div class="error-msg">' . form_error('user_gender') . '</div>';
                                    ?>
                                </div>
                                <div class="form-group col-6">
                                    <?php echo form_label('Profile Picture', 'user_photo'); ?>
                                    <label><span class="text-danger" style="font-size:10px;">(Supported Format: gif | jpg | png | jpeg / Max. upload size 1MB)</span></label>
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'user_photo',
											'id'   => 'user_profile_photo',
											'value' => set_value('user_photo'),
											'class' => 'form-control'
										);
										echo form_input($data);
										$profilepic = !empty($usersData->photo)?$usersData->photo:'no_image_available.jpeg';
									?>
									<img src="<?php echo base_url().'uploads/profile/'.$profilepic; ?>" width="50" height="50"/>
									<?php echo '<div class="error-msg">' . form_error('user_photo') . '</div>';?>
                                </div>
                                <div class="form-group col-6">
                                    <?php
										echo form_label('Address *', 'user_address');
										echo form_textarea(array('name' => 'user_address',
												'class' => 'form-control',
												'value' =>  set_value('user_address',$usersData->address),
												'placeholder' => 'address',
												'cols' => '4',
												'rows' => '2'
											)
										);
										echo '<div class="error-msg">' . form_error('user_address') . '</div>';
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
<script>
	$('#user_profile_photo').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' ){
			if (this.files[0].size > 1097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 1MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	});
	$("#edit_state").change(function() { 
		var $option = $(this).find('option:selected');
		var stateId = $option.val();
		$.ajax({
			url: '<?php echo base_url();?>agents/agentController/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#user_city").html(data);
			}
		});
	});
</script>