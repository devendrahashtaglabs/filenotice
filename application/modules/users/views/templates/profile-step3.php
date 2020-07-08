<?php 
	$categoryid 		= !empty($usersData)?$usersData->category_id:'';
	$subcategoryid 		= !empty($usersData)?$usersData->subcategory_id:'';
	$categoryidarr 		= explode(',',$categoryid);
	$subcategoryidarr 	= explode(',',$subcategoryid);
	$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
	$selectedcategories = implode(',',$allcat);
?>
<style type="text/css">
	.select2-container--default.select2-container--focus .select2-selection--multiple {
	border: 1px solid #ccc !important;
	outline: 0;
	height: 30px;
}
.select2-container--default .select2-selection--multiple {
	background-color: white;
	border: 1px solid #ced4da !important;
	border-radius: 4px;
	cursor: text;
	height: 38px;
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
.consultant-certificate .error {
	margin-top: 28px;
	font-size: 11px;
	left: 0;
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
.casefile {
	width: 49%;
}
.casefilename {
	width: 49.4%;
	float: left;
	margin-right: 14px;
	height: 37px;
}
/* .imgbrder {
	border: 1px solid #f3781e;
	margin-top: 0;
	float: left;
	margin-top: 5px;
	width: 80px;
	height: 80px;
	padding: 4px;
	background: #fff;
	box-shadow: 0 0 5px #000;
} */
table tr th {
    background: #494e53;
    color: #fff;
}
.dataTables_length select {
    background: #fff;
    border: 1px solid #ccc;
    padding: 1px 12px;
    line-height: 1.42857143;
    height: 30px;
    border-radius: 4px;
}
.dataTables_filter input {
    background: #fff;
    border: 1px solid #ccc;
    padding: 1px 12px;
    line-height: 1.42857143;
    height: 30px;
    border-radius: 4px;
}
.table-responsive.customizetableres{
	margin-top: 15px;
}
.thishasimg {
	float: right;
	width: auto;
	position: relative;
	top: -25px;
}
.aadhrphoto .form-control {
	float: left;
	width: 80%;
}
.pancard .form-control {
	float: left;
	width: 80%;
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
								  <span class="number one">
									<a href="<?php echo $profile; ?>">1</a>
								   </span>
								   <span class="text-part">
										Personal<br>Info
									</span>
							  </div>
							  <div class="number-account">
								<span class="number two">
									<a href="<?php echo $profile2; ?>">2</a>
								 </span>
								 <span class="text-part">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three active">
									<a href="<?php echo $profile3; ?>">3</a>
								</span>
								<span class="text-part active">
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
							 <div class="col-6">
								<?php 
									$aadhaar_card_number = '';
									if(!empty($usersData->aadhaar_card_number)){
										$aadhaar_card_number = $usersData->aadhaar_card_number;
									}
								?>
        						<div class="form-group inputBox <?php echo !empty($aadhaar_card_number)?'focus':''; ?>">
									<?php
										echo form_label('Aadhar Number', 'aadhar_no');
										echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control input', 'value' => set_value('aadhar_no',$aadhaar_card_number), 'id' => "aadhar_no", 'maxlength' => '12'));
										echo '<div class="error-msg">' . form_error('aadhar_no') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php echo form_label('Aadhar Photo <span class="text-danger" style="font-size:8px; color: #a94442 !important;"> (Supported Format: pdf | jpg | png | jpeg / Max. upload size 2MB)</span>', 'aadhar_photo'); ?> 
									<?php
										$aadhaar_photo_url = '';
										if(!empty($usersData->aadhaar_photo)){
											$aadhaar_photo_url = 'consultant/'.$usersData->aadhaar_photo;
										}else{
											$aadhaar_photo_url = 'profile/no_image_available.jpeg';
										}
										$data = array(
											'type' => 'file',
											'name' => 'aadhar_photo',
											'id' 	=> 'user_aadhar_photo',
											'value' => set_value('aadhar_photo',$usersData->aadhaar_photo),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									<a href="<?php echo base_url() .'uploads/'.$aadhaar_photo_url; ?>" target="_blank"><img class="imgbrder" src="<?php echo base_url() .'uploads/'.$aadhaar_photo_url; ?>" width="40" height="40"/></a>
									<?php echo '<div class="error-msg">' . form_error('user_aadhar_photo') . '</div>';?>
								</div>
                            </div>
					   </div>
					   <div class="row">
                            <div class="col-6">
								<?php 
									$pan_card_number = '';
									if(!empty($usersData->pan_card_number)){
										$pan_card_number = $usersData->pan_card_number;
									}
								?>
        						<div class="form-group inputBox <?php echo !empty($pan_card_number)?'focus':''; ?>">
									<?php
										echo form_label('Pan Number', 'pan_no');
										echo form_input(array('name' => 'pan_no', 'class' => 'form-control input', 'value' => set_value('pan_no',$pan_card_number), 'id' => "pan_no", 'maxlength' => '10'));
										echo '<div class="error-msg">' . form_error('pan_no') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php echo form_label('Pan Photo <span class="text-danger" style="font-size:8px; color: #a94442 !important;"> (Supported Format: pdf | jpg | png | jpeg / Max. upload size 2MB)</span>', 'pan_photo'); ?> 
									<?php
										$pan_photo_url = '';
										if(!empty($usersData->pan_photo)){
											$pan_photo_url = 'consultant/'. $usersData->pan_photo;
										}else{
											$pan_photo_url = 'profile/no_image_available.jpeg';
										}
										$data = array(
											'type' 	=> 'file',
											'name' 	=> 'pan_photo',
											'id' 	=> 'user_pan_photo',
											'value' => set_value('pan_photo',$usersData->pan_photo),
											'class' => 'form-control input',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									
									?>
									 <a href="<?php echo base_url() .'uploads/'.$pan_photo_url; ?>" target="_blank"><img  class="imgbrder" src="<?php echo base_url() .'uploads/'.$pan_photo_url; ?>" width="40" height="40"/></a>
									<?php echo '<div class="error-msg">' . form_error('user_pan_photo') . '</div>';?>
								</div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-12">
								<?php 
									echo form_label('Certificate Upload ', 'image'); 
								?>
								<div class="stuffs_to_clone">
									<div class="stuff consultant-certificate mystyuffs">
										<div class="form-group inputBox focus">
											<div class="row">
												<div class="col-md-6">
													<input type="text" class="form-control casefilename input" name="casefilename[]" id="casefilename" placeholder="Certificate Name" <?php echo empty($usersData->certificates)?'required':'';?>/>
												</div>
												<div class="col-md-6">
													<input type="file" id="image" class="form-control casefile input" name="image[]" />
													<div class="del disabled hidden"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="clone mt-3" title="Add more files">Add more files</div>
									<div id="upload_prev" style="display:none;"></div>
								</div>
								<span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 2MB)</span>
								<?php 
									echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; 
								?>
							</div>
                        </div>
                        <div class="row">
							<div class="col-12">
								<div class="table-responsive customizetableres">
									<table id="certificate_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Cerificate Name</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$certificates = '';
											if(!empty($usersData)){
												$certificates = $usersData->certificates;
												$certificateArray = json_decode($certificates);
												$counter = 1;
												if(!empty($certificateArray)){
												foreach($certificateArray as $certificate){
										?>
												<tr>
													<td><?php echo $counter; ?></td>
													<td>
														<?php echo ucfirst($certificate->filename); ?>
													</td>
													<td><a href="<?php echo base_url().'uploads/consultant/certificates/'.$certificate->file; ?>" target="_blank">View</a>
													</td>
												</tr>
											<?php 
														$counter++; }
													}
												}												
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                        <div class="row mt-3">
							<div class="col-12">
								<div class="form-group">
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
<script type="text/javascript">
$(".clone").click(function() {
		var
		$self = $(this),
			$element_to_clone = $self.prev(),
			$wrapper_parent_element = $self.parent(),
			$new_element = $element_to_clone.clone().find("input:text,input:file").val("").end();

		$new_element.find('.del').removeClass('hidden disabled').addClass('enabled');

		$new_element.insertAfter($element_to_clone);

		return false;
	});

	$("body").on("click", ".del.enabled", function(event) {
		var $parent = $(this).parent().parent();
		$parent.remove();
		return false;
	});
	var arr = [];
	$(document.body).on("change","#image", function() {
		var filename = $(this).val();
		var lastIndex = filename.lastIndexOf("\\");
		if (lastIndex >= 0) {
			filename = filename.substring(lastIndex + 1);
		}
		if ($.inArray(filename, arr) != -1)
		{
		  alert(filename + " already selected");
		  $(this).val('');
		}
		arr.push(filename);
	});	
	
	$('#image').on('change', function() {
		var filename = $('.casefilename').val();
		if(filename == ''){
			alert('Enter file name before selecting any file.');
			$(this).val('');
		}else{
			var fileExt = $(this).val().split('.').pop();
			if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' || fileExt === 'pdf' || fileExt === 'doc' || fileExt === 'docx' || fileExt === 'xls' || fileExt === 'xlsx'){
				if (this.files[0].size > 2097152) { 
					var extension = file.substr( (file.lastIndexOf('.') +1) );
					alert("Try to upload file less than 2MB!"); 
					$(this).val('');
				}
			}else{
				alert("Try to upload allowed file type!"); 
				$(this).val('');
			}
		}
	});
	$("#ConsultantInfoForm").on("submit", function(e){
		$( ".mystyuffs" ).each( function( index, element ){
			var images 		=  $( this ).find('#image').val();
			var filesname 	=  $( this ).find('.casefilename').val();
			if(filesname !='' && images == ''){
				e.preventDefault();
				alert('Upload files before submitting.');
			}
		});
	});
</script>