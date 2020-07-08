<?php 
	$categoryid 		= !empty($usersData)?$usersData->category_id:'';
	$subcategoryid 		= !empty($usersData)?$usersData->subcategory_id:'';
	$categoryidarr 		= explode(',',$categoryid);
	$subcategoryidarr 	= explode(',',$subcategoryid);
	$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
	$selectedcategories = implode(',',$allcat);
?>
<style type="text/css">
.select2-container--default .select2-selection--multiple {
	background-color: white;
	border: 1px solid #ced4da !important;
	border-radius: 4px;
	cursor: text;
	height: 30px;
}
.form-group:last-of-type {
	margin-top: 0;
}
.img-fluid {
	margin: 15px 0 0;
}
#qualification, #experience_yr, #ad_qualification {
	float: left;
	width: 49%;
}
#sub_qualification, #experience_mn, #ad_sub_qualification {
	float: left;
	width: 49%;
	margin-left: 10px;
}
.form-group.col-12.mt-5.pb-3.border-bottom{
	margin-top: 25px !important;
}
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
.profilebg {
	background: #f4f4ff;
	padding: 10px;
	display: block;
	float: left;
	width: 100%;
}
.profilebg .form-control {
    height: 30px;
    padding: 1px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    background-color: #fff;
}
.profilebg label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0;
    font-weight: 400;
    color: #333;
    font-size: 8px;
    line-height: 17px;
}
.profilebg select.form-control {
	height: 30px !important;
}
.form-group:last-of-type {
	margin-top: 0;
}
.form-group{
	margin-bottom: 8px;
}
input[type="file"] {
	padding: 4px !important;
}
::placeholder {
	font-size: 12px !important;
}
textarea {
	line-height: 25px !important;
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
						<div class="row" style="min-height: 130px;">
						  <div class="active-screen">
							  <div class="number-account">
								  <span class="number one ">
									<a href="<?php echo $profile; ?>">1</a>
								   </span>
								   <span class="text-part">
										Personal<br>Info
									</span>
							  </div>
							  <div class="number-account ">
								<span class="number two active">
									<a href="<?php echo $profile2; ?>">2</a>
								 </span>
								 <span class="text-part active">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three notreached">
									<a href="<?php echo $profile3; ?>">3</a>
								</span>
								<span class="text-part">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four notreached">
									<a href="<?php echo $profile4; ?>">4</a>
								</span>
								<span class="text-part">
									Sub Category<br>Margin Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five notreached">
									<a href="<?php echo $profile5; ?>">5</a>
								</span>
								<span class="text-part">
									Bank<br>Info
								</span>
							  </div>
							</div>
						</div>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'ConsultantInfoForm')); ?>
                    <div class="card-body floating-laebls">
                    	<div class="profilebgs">
                        <?php
							if ($this->session->flashdata('responce_msg') != "") {
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
							}
                        ?>
						<div class="row">
							<div class="form-group col-12 mt-5 pb-3">
								<h4 class="card-title"> Public Profile Section </h4>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
        						<div class="form-group inputBox focus">
									<?php echo form_label('Banner Image <small style="font-size:8px; color: #a94442 !important;">(Supported Format: gif | jpg | png | jpeg / Max. upload size 2MB)</small>', 'banner_image'); ?> 
									
									<?php
										$banner_image = '';
										if(!empty($usersData->banner_image)){
											$banner_image = $usersData->banner_image;
										}
										$data = array(
											'type' 	=> 'file',
											'name' 	=> 'banner_image',
											'id' 	=> 'user_banner_image',
											'value' => set_value('banner_image',$banner_image),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									<?php echo '<div class="error-msg">' . form_error('user_banner_image') . '</div>'; ?>
									<?php 
										if(!empty($banner_image)){ 
											$bannerimgurl = base_url() . '/uploads/consultant/banners/' .$banner_image;
											$existbannerimg = does_url_exists($bannerimgurl);
											if (!$existbannerimg) { 
									?>
										<img src="<?php echo base_url() . '/uploads/profile/no_image_available.jpeg'; ?>" class="" width="40" height="40" />
									<?php 	}else{  ?>
										<img src="<?php echo base_url() . '/uploads/consultant/banners/' .$banner_image; ?>" class="" width="40" height="40" />
									<?php } clearstatcache(); } 
										$data = array(
												'type'  => 'hidden',
												'name'  => 'cropped_banner_image',
												'id'    => 'cropped_banner_image',
												'value' => '',
												'class' => 'cropped_banner_image'
										);
										echo form_input($data);
									?>
								</div>
							</div>
							<div class="col-6">
								<?php 
									$company_name = '';
									if(!empty($usersData->company_name)){
										$company_name = $usersData->company_name;
									}
								?>
        						<div class="form-group inputBox <?php echo !empty($company_name)?'focus':''; ?>">
									<?php
										echo form_label('Company Name', 'company_name');
										echo form_input(array('name' => 'company_name', 'class' => 'form-control input', 'value' => set_value('company_name',$company_name)));
										echo '<div class="error-msg">' . form_error('company_name') . '</div>';
									?>
								</div>
							</div>
                        </div>
                        <div class="row">
							<div class="col-6">
								<?php 
									$about_consultant = '';
									if(!empty($usersData->about_consultant)){
										$about_consultant = $usersData->about_consultant;
									}
								?>
								<div class="form-group inputBox <?php echo !empty($about_consultant)?'focus':''; ?>">
									<?php
										echo form_label('About Consultant * ', 'about_consultant');
										echo form_textarea(array('name' => 'about_consultant', 'class' => 'form-control input', 'value' => set_value('about_consultant',$about_consultant),'minlength' => '20','rows' => '5','cols' => '5'));
										echo '<div class="error-msg">' . form_error('about_consultant') . '</div>';
									?>
								</div>
                            </div>
							<div class="col-6">
								<?php 
									$company_address = '';
									if(!empty($usersData->company_address)){
										$company_address = $usersData->company_address;
									}
								?>
								<div class="form-group inputBox <?php echo !empty($company_address)?'focus':''; ?>">
                                <?php
									echo form_label('Company Address', 'company_address');
									echo form_textarea(array('name' => 'company_address', 'class' => 'form-control input', 'value' => set_value('company_address',$company_address), 'rows' => '5','cols' => '5'));
									echo '<div class="error-msg">' . form_error('company_address') . '</div>';
                                ?>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-12 mt-2">
								<div class="form-group text-right">
									<?php
									   echo form_submit(array("class" => "btn btn-primary", "id" => "create_user_btn", "value" => "Submit & Next"));
									   echo '&nbsp;&nbsp;<a href="' . base_url('profile') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
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
	$('#user_banner_image').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' ){
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