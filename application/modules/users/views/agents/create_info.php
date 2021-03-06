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
                        <h3 class="card-title">Other Informations / Step 2</h3>
                    </div>
                    <?php echo form_open_multipart($pageUrl . '/' . $id, array('class' => 'other_info', 'id' => 'ConsultantInfoForm')); ?>
                    <div class="card-body floating-laebls">
                        <?php
							if ($this->session->flashdata('responce_msg') != "") {
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
							}
                        ?>
                        <div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Emergency Contact Number', 'contact_number');
										echo form_input(array('name' => 'contact_number', 'class' => 'form-control input', 'id' => 'contact_number', 'value' => set_value('contact_number'), 'maxlength' => '10'));
										echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php echo form_label('Profile Picture', 'user_photo'); ?>
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'user_photo',
											'id'   => 'user_profile_photo',
											'value' => set_value('user_photo'),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									<span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg /Max. upload size 1MB)</span>
									<?php echo '<div class="error-msg">' . form_error('user_photo') . '</div>';?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
										echo form_label('Aadhar Number', 'aadhar_no');
										echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control input', 'value' => set_value('aadhar_no'), 'id' => "aadhar_no", 'maxlength' => '12'));
										echo '<div class="error-msg">' . form_error('aadhar_no') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php echo form_label('Aadhar Photo', 'aadhar_photo'); ?>
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'aadhar_photo',
											'id' => 'user_aadhar_photo',
											'value' => set_value('aadhar_photo'),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									<span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx /Max. upload size 2MB)</span>
									<?php echo '<div class="error-msg">' . form_error('user_aadhar_photo') . '</div>';?>
								</div>
							</div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox">
									<?php
									echo form_label('Pan Number', 'pan_no');
									echo form_input(array('name' => 'pan_no', 'class' => 'form-control input', 'value' => set_value('pan_no'), 'id' => "pan_no", 'maxlength' => '10'));
									echo '<div class="error-msg">' . form_error('pan_no') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php echo form_label('Pan Photo', 'pan_photo'); ?>
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'pan_photo',
											'id' => 'user_pan_photo',
											'value' => set_value('pan_photo'),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									<?php echo '<div class="error-msg">' . form_error('user_pan_photo') . '</div>';?>
									<span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx /Max. upload size 2MB)</span>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Expertise', 'expertise_text[]');
										$option = array();
										foreach ($expertise as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_multiselect('expertise_text[]', $option, $selected = set_value(''), $extra = 'class="form-control input" rows=3 id="expertise_text"');
										echo '<div class="error-msg">' . form_error('expertise_text') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
									echo form_label('Heighest Qualification', 'qualification');
									$qualioptions = array('' => 'Select Qualification');
									if(!empty($qualificationData)){
										foreach($qualificationData as $qualification){
											$qualioptions[$qualification->qualification_id] = $qualification->qualification_name;
										}
									}
									$selectededucation = '';
									if(!empty($usersData->education)){
										$selectededucation = $usersData->education;
									}
									echo form_dropdown('qualification', $qualioptions, $selected = set_value('qualification',$selectededucation), $extra = 'class="form-control col-6 input" id="qualification"');
									
									$subqualioptions = array('' => 'Select Course');
									if(!empty($usersData->education)){
										$subqualificationData = $this->user_model->getsubqualificationbyqualid($usersData->education);
										if(!empty($subqualificationData)){
											foreach($subqualificationData as $subqualification){
												$subqualioptions[$subqualification->subqualification_id] = $subqualification->subquali_name;
											}
										}
									}
									if(!empty($usersData->sub_education)){
										echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification',$usersData->sub_education), $extra = 'class="form-control col-6 input" id="ad_sub_qualification"');
									}else{
										echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification'), $extra = 'class="form-control col-6 input" id="sub_qualification"');
									}
										
									
									/*
									$selectededucation = '';
									if(!empty($usersData->education)){
										$selectededucation = $usersData->education;
									}
									$data = array(
										'name'          => 'education_text',
										'class'         => 'form-control',
										'value'         => set_value('education_text',$selectededucation),
										'rows'          => '3',
										'placeholder'   => 'Education'
									);
									echo form_textarea($data); */
									echo '<div class="error-msg">' . form_error('education_text') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group experience inputBox focus">
									<?php
									echo form_label('Experience', 'experience_yr');
									/* $experience = '';
									if(!empty($usersData->experience)){
										$experience = $usersData->experience;
									}
									$data = array(
										'name' => 'experience',
										'class' => 'form-control',
										'value' => set_value('experience',$experience),
										'rows' => '3',
										'placeholder' => 'experience'
									);
									echo form_textarea($data); */
									//$experience = $usersData->experience;
									$experience_yr = '';
									$experience_mn = '';
									/* if(!empty($experience)){
										$implodeData = explode(' ',$experience);
										if(!empty($implodeData)){
											$experience_yr = $implodeData['0'];
											$experience_mn = $implodeData['1'];
										}
									} */
									$option = array(
												''          => 'Select Year',
												'1'         => '1',
												'2'         => '2',
												'3'         => '3',
												'4'         => '4',
												'5'         => '5',
												'5+'        => '5+',
									);
									echo form_dropdown('experience_yr', $option, $selected = set_value('experience_yr',$experience_yr), $extra = 'class="form-control col-6 input" id="experience_yr"');
									$option = array(
												''          => 'Select Month',
												'1'         => '1',
												'2'         => '2',
												'3'         => '3',
												'4'         => '4',
												'5'         => '5',
												'6'         => '6',
												'7'         => '7',
												'8'         => '8',
												'9'         => '9',
												'10'        => '10',
												'11'        => '11'
									);
									echo form_dropdown('experience_mn', $option, $selected = set_value('experience_mn',$experience_mn), $extra = 'class="form-control col-6 input" id="experience_mn"');
									//echo '<div class="error-msg">' . form_error('experience_mn') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row mt-3">
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
	$("#expertise_text").select2( {
		placeholder: "Select Expertise",
		allowClear: true,
		container:'body'
	} );
	$('#user_profile_photo').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg'){
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
	$('#user_aadhar_photo,#user_pan_photo').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' || fileExt === 'pdf' || fileExt === 'doc' || fileExt === 'docx'){
			if (this.files[0].size > 2097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 2MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	});
</script>