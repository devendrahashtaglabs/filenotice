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
                        <h3 class="card-title"><?php echo $page_title; ?>
							<a class="back-btn btn btn-info white-icon" href="<?php echo base_url('agent/profile'); ?>" style="float:right;"><i class="fa fa-arrow-left"></i> Back</a>
						</h3>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'AgentInfoForm')); ?>
                    <div class="card-body">
                        <?php
                        if ($this->session->flashdata('responce_msg') != "") {
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
                        }
                        ?>
                        <div class="row">
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Category Name*', 'category_id');
                                $option = array("" => "Select Category");
                                foreach ($category as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
								$catId = '';
								if(!empty($usersData->category_id)){
									$catId = $usersData->category_id;
								}
                                echo form_dropdown('category_id', $option, $selected = set_value('category_id',$catId), $extra = 'class="form-control change-category" id="category_id" data-section="create_consultant" data-selectedid=""');
                                echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Subcategory Name *', 'subcategory_id');
                                    $option = array('' => 'Select Sub-category');
									if(!empty($usersData->category_id)){
										$sections 		= $this->category_model->getsubcategory($usersData->category_id);
										foreach ($sections as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
									}
									$subcatId = '';
									if(!empty($usersData->subcategory_id)){
										$subcatId = $usersData->subcategory_id;
									}
                                    echo form_dropdown('subcategory_id', $option, set_value('subcategory_id',$subcatId), $extra = 'class= "form-control" id="subcategory_id"');
                                    echo '<div class="error-msg">' . form_error('subcategory_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('Contact Number', 'contact_number');
									$telephone = '';
									if(!empty($usersData->telephone)){
										$telephone = $usersData->telephone;
									}
									echo form_input(array('name' => 'contact_number', 'class' => 'form-control', 'value' => set_value('contact_number',$telephone), 'maxlength' => '10', 'placeholder' => 'Contact Number'));
									echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
								<?php
								echo form_label('Expertise', 'expertise_text[]');
								$selectedexpertise = [];
								if(!empty($usersData->expertise)){
									$selectedexpertise = explode(',',$usersData->expertise);
								}
								$option = array();
								foreach ($expertise as $key => $value) {
									$option[$value->id] = ucfirst($value->name);
								}
								echo form_multiselect('expertise_text[]', $option, $selected = set_value('expertise_text[]',$selectedexpertise), $extra = 'class="form-control" rows=3 id="expertise_text"');
								echo '<div class="error-msg">' . form_error('expertise_text') . '</div>';
								?>
							</div>
						</div>
						<div class="row">
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Aadhar Number', 'aadhar_no');
								$aadhaar_card_number = '';
								if(!empty($usersData->aadhaar_card_number)){
									$aadhaar_card_number = $usersData->aadhaar_card_number;
								}
                                echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control', 'value' => set_value('aadhar_no',$aadhaar_card_number), 'id' => "aadhar_no", 'maxlength' => '12', 'placeholder' => 'Enter Aadhar Number '));
                                echo '<div class="error-msg">' . form_error('aadhar_no') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Aadhar Photo', 'aadhar_photo'); ?> <label><span class="text-danger" style="font-size:10px;"> (Supported Format: pdf | jpg | png | jpeg / Max. upload size 2MB)</span></label>
								<?php
									$aadhar_photo_url = '';
									if(!empty($usersData->aadhaar_photo)){
										$aadhar_photo_url = 'consultant/agent/'. $usersData->aadhaar_photo;
									}else{
										$aadhar_photo_url = 'profile/no_image_available.jpeg';
									}
									$data = array(
										'type' => 'file',
										'name' => 'aadhar_photo',
										'id' => 'user_aadhar_photo',
										'value' => set_value('aadhar_photo',$usersData->aadhaar_photo),
										'class' => 'form-control',
										'style' => 'line-height:17px;'
									);
									echo form_input($data);							   
								?>
								<a href="<?php echo base_url() .'uploads/'.$aadhar_photo_url; ?>" target="_blank"><img src="<?php echo base_url() .'uploads/'.$aadhar_photo_url; ?>" width="50" height="50"/></a>
                                <?php echo '<div class="error-msg">' . form_error('user_aadhar_photo') . '</div>';?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Pan Number', 'pan_no'); 
								$pan_card_number = '';
								if(!empty($usersData->pan_card_number)){
									$pan_card_number = $usersData->pan_card_number;
								}
                                echo form_input(array('name' => 'pan_no', 'class' => 'form-control', 'value' => set_value('pan_no',$pan_card_number), 'id' => "pan_no", 'maxlength' => '10', 'placeholder' => 'Enter Pan Number '));
                                echo '<div class="error-msg">' . form_error('pan_no') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Pan Photo', 'pan_photo'); ?><label><span class="text-danger" style="font-size:10px;"> (Supported Format: pdf | jpg | png | jpeg / Max. upload size 2MB)</span></label>
								<?php
									$pan_photo_url = '';
									if(!empty($usersData->pan_photo)){
										$pan_photo_url = 'consultant/agent/'. $usersData->pan_photo;
									}else{
										$pan_photo_url = 'profile/no_image_available.jpeg';
									}
									$data = array(
										'type' => 'file',
										'name' => 'pan_photo',
										'id' => 'user_pan_photo',
										'value' => set_value('pan_photo',$usersData->pan_photo),
										'class' => 'form-control',
										'style' => 'line-height:17px;'
									);
									echo form_input($data);
								
								?>
                                 <a href="<?php echo base_url() .'uploads/'.$pan_photo_url; ?>" target="_blank"><img src="<?php echo base_url() .'uploads/'.$pan_photo_url; ?>" width="50" height="50"/></a>
                                <?php echo '<div class="error-msg">' . form_error('user_pan_photo') . '</div>';?>
                            </div>
                            <div class="form-group col-6 qualification">
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
                                echo form_dropdown('qualification', $qualioptions, $selected = set_value('qualification',$selectededucation), $extra = 'class="form-control col-6" id="qualification"');
								
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
									echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification',$usersData->sub_education), $extra = 'class="form-control col-6" id="sub_qualification"');
								}else{
									echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification'), $extra = 'class="form-control col-6" id="sub_qualification"');
								}
									
								
                                /*
								$selectededucation = '';
								if(!empty($usersData->education)){
									$selectededucation = $usersData->education;
								}
								$data = array(
                                    'name' 			=> 'education_text',
                                    'class' 		=> 'form-control',
                                    'value' 		=> set_value('education_text',$selectededucation),
                                    'rows' 			=> '3',
                                    'placeholder' 	=> 'Education'
                                );
                                echo form_textarea($data); */
                                echo '<div class="error-msg">' . form_error('education_text') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6 experience">
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
								$experience = isset($usersData->experience)?$usersData->experience:'';
								$experience_yr = '';
								$experience_mn = '';
								if(!empty($experience)){
									$implodeData = explode(' ',$experience);
									if(!empty($implodeData)){
										$experience_yr = $implodeData['0'];
										$experience_mn = $implodeData['1'];
									}
								}
								$option = array(
											'' 			=> 'Select Year',
											'1' 		=> '1',
											'2' 		=> '2',
											'3' 		=> '3',
											'4' 		=> '4',
											'5' 		=> '5',
											'5+' 		=> '5+',
								);
                                echo form_dropdown('experience_yr', $option, $selected = set_value('experience_yr',$experience_yr), $extra = 'class="form-control col-6" id="experience_yr"');
								$option = array(
											'' 			=> 'Select Month',
											'1' 		=> '1',
											'2' 		=> '2',
											'3' 		=> '3',
											'4' 		=> '4',
											'5' 		=> '5',
											'6' 		=> '6',
											'7' 		=> '7',
											'8' 		=> '8',
											'9' 		=> '9',
											'10' 		=> '10',
											'11' 		=> '11'
								);
                                echo form_dropdown('experience_mn', $option, $selected = set_value('experience_mn',$experience_mn), $extra = 'class="form-control col-6" id="experience_mn"');
                                //echo '<div class="error-msg">' . form_error('experience_mn') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_user_btn", "value" => "Submit"));
                                echo '&nbsp;&nbsp;<a href="' . base_url('agent/profile') . '" class="btn btn-danger">Cancel</a>';
                                ?>
                            </div>
						</div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="profile_pic_modal" class="modal fade">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div class="modal-body">
<form id="cropimage" method="post" enctype="multipart/form-data" action="<?php echo base_url('/users/customerController/change_image');?>">
<strong>Upload Image:</strong> <br><br>
<input type="file" name="profile-pic" id="profile-pic" />
<input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />
<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis" value="" />
<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis" value="" />
<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axis" />
<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis" />
<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width" value="" />
<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height" value="" />
<input type="hidden" name="action" value="" id="action" />
<input type="hidden" name="image_name" value="" id="image_name" />
<div id='preview-profile-pic'></div>
<div id="thumbs" style="padding:5px; width:600p"></div>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<button type="button" id="save_crop" class="btn btn-primary">Crop & Save</button>
</div>
</div>
</div>
</div>
<script>
	jQuery(document).ready(function(){
	/* When click on change profile pic */	
	jQuery('#change-profile-pic').on('click', function(e){
        jQuery('#profile_pic_modal').modal({show:true});        
    });	
	jQuery('#profile-pic').on('change', function()	{
		jQuery("#preview-profile-pic").html('');
		jQuery("#preview-profile-pic").html('Uploading....');
		jQuery("#cropimage").ajaxForm({
		target: '#preview-profile-pic',
		success:    function() { 
				jQuery('img#photo').imgAreaSelect({
				aspectRatio: '1:1',
				onSelectEnd: getSizes,
			});
			jQuery('#image_name').val(jQuery('#photo').attr('file-name'));
			}
		}).submit();
	});
	/* handle functionality when click crop button  */
	jQuery('#save_crop').on('click', function(e){
    e.preventDefault();
	var base_url = '<?php echo base_url("/users/customerController/change_image");?>';
    params = {
            targetUrl: base_url+'?action=save',
            action: 'save',
            x_axis: jQuery('#hdn-x1-axis').val(),
            y_axis : jQuery('#hdn-y1-axis').val(),
            x2_axis: jQuery('#hdn-x2-axis').val(),
            y2_axis : jQuery('#hdn-y2-axis').val(),
            thumb_width : jQuery('#hdn-thumb-width').val(),
            thumb_height:jQuery('#hdn-thumb-height').val()
        };
        saveCropImage(params);
    });
    /* Function to get images size */
    function getSizes(img, obj){
        var x_axis = obj.x1;
        var x2_axis = obj.x2;
        var y_axis = obj.y1;
        var y2_axis = obj.y2;
        var thumb_width = obj.width;
        var thumb_height = obj.height;
        if(thumb_width > 0) {
			jQuery('#hdn-x1-axis').val(x_axis);
			jQuery('#hdn-y1-axis').val(y_axis);
			jQuery('#hdn-x2-axis').val(x2_axis);
			jQuery('#hdn-y2-axis').val(y2_axis);
			jQuery('#hdn-thumb-width').val(thumb_width);
			jQuery('#hdn-thumb-height').val(thumb_height);
        } else {
            alert("Please select portion..!");
		}
    }
    /* Function to save crop images */
    function saveCropImage(params) {
		jQuery.ajax({
			url: params['targetUrl'],
			cache: false,
			dataType: "html",
			data: {
				action: params['action'],
				id: jQuery('#hdn-profile-id').val(),
				t: 'ajax',
				w1:params['thumb_width'],
				x1:params['x_axis'],
				h1:params['thumb_height'],
				y1:params['y_axis'],
				x2:params['x2_axis'],
				y2:params['y2_axis'],
				image_name :jQuery('#image_name').val()
			},
			type: 'Post',
		   	success: function (response) {
					jQuery('#profile_pic_modal').modal('hide');
					jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
					jQuery("#profile_picture").attr('src', response);
					jQuery("#cropped_banner_image").val(response);
					jQuery("#preview-profile-pic").html('');
					jQuery("#profile-pic").val();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
			}
		});
    }
	$("#expertise_text").select2( {
		placeholder: "Select Expertise",
		allowClear: true,
		container:'body'
	} );
	$('#user_aadhar_photo,#user_pan_photo').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'pdf' || fileExt === 'png' || fileExt === 'jpeg' ){
			if (this.files[0].size > 2097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 1MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	});
});
</script>