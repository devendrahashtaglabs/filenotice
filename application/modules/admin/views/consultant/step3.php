<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
}
.verifyinput {
	float: right;
	margin-top: -40px;
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
						<div class="row" style="margin-top: 25px; margin-bottom: 85px">
						  <div class="active-screen">
							  <div class="number-account">
								<span class="number one">
									<a href="<?php echo $step1; ?>">1</a>
								</span>
								<span class="text-part">
									Personal<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number two">
									<a href="<?php echo $step2; ?>">2</a>
								</span>
								<span class="text-part">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three active">
									<a href="<?php echo $pageUrl; ?>">3</a>
								</span>
								<span class="text-part active">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four">
									<a href="javascript:void(0);">4</a>
								</span>
								<span class="text-part">
									Sub Category <br/>Margin Info 
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five">
									<a href="javascript:void(0);">5</a>
								</span>
								<span class="text-part">
									Bank<br/>Info 
								</span>
							  </div>
							</div>
						</div>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'create_users', 'id' => 'ConsultantverificationForm')); ?>
                    <div class="card-body">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
                        <div class="row">
							<div class="form-group col-6">
                                <?php
									echo form_label('Aadhar Number', 'aadhar_no');
									echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control col-8', 'value' => set_value('aadhar_no', $consultant->aadhaar_card_number), 'id' => "aadhar_no", 'maxlength' => '12', 'placeholder' => 'Enter Aadhar Number', 'disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_aadhar_no" class="v_checkbox" name="v_aadhar_no" <?php if($verifiedconsultantdata->v_aadhar_no == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_aadhar_no" id="v_aadhar_no_lbl"> <?php echo ($verifiedconsultantdata->v_aadhar_no == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
								<?php 
									echo '<div class="custom-error" id="v_aadhar_no_error"></div>';
								?>
                            </div>
                            <div class="form-group col-6">
								<div class="col-8">
									<?php echo form_label('Aadhar Photo', 'aadhar_photo'); ?><br/>
									<?php 
										if(!empty($consultant->aadhaar_photo)){ 
									?>
										<img src="<?php echo base_url().'uploads/consultant/'.$consultant->aadhaar_photo; ?>" class="" width="100" height="100">
									<?php }else{ ?>
										<img src="<?php echo base_url(); ?>uploads/profile/no_image_available.jpeg" class="" width="100" height="100">
									<?php } ?>
								</div>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_aadhar_photo" class="v_checkbox" name="v_aadhar_photo" <?php if($verifiedconsultantdata->v_aadhar_photo == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_aadhar_photo" id="v_aadhar_photo_lbl"> <?php echo ($verifiedconsultantdata->v_aadhar_photo == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_aadhar_photo_error"></div>';
									?>
								</div>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('Pan Number', 'pan_no');
									echo form_input(array('name' => 'pan_no', 'class' => 'form-control col-8', 'value' => set_value('pan_no', $consultant->pan_card_number), 'id' => "pan_no", 'maxlength' => '10', 'placeholder' => 'Enter Pan Number', 'disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_pan_no" class="v_checkbox" name="v_pan_no" <?php if($verifiedconsultantdata->v_pan_no == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_pan_no" id="v_pan_no_lbl"> <?php echo ($verifiedconsultantdata->v_pan_no == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_pan_no_error"></div>';
									?>
								</div>
                            </div>
                            <div class="form-group col-6">
								<div class="col-8">
									<?php echo form_label('Pan Photo', 'pan_photo'); ?><br/>
									<?php 
										if(!empty($consultant->pan_photo)){ 
									?>
										<img src="<?php echo base_url().'uploads/consultant/'.$consultant->pan_photo; ?>" class="" width="100" height="100">
									<?php }else{ ?>
										<img src="<?php echo base_url(); ?>uploads/profile/no_image_available.jpeg" class="" width="100" height="100">
									<?php } ?>
								</div>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_pan_photo" class="v_checkbox" name="v_pan_photo" <?php if($verifiedconsultantdata->v_pan_photo == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_pan_photo" id="v_pan_photo_lbl"> <?php echo ($verifiedconsultantdata->v_pan_photo == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_pan_photo_error"></div>';
									?>
								</div>
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
											if(!empty($consultant)){
												$certificates 		= $consultant->certificates;
												$certificateArray 	= json_decode($certificates);
												if(!empty($certificateArray)){
												$counter = 1;
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
												$counter++; }}
											}												
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
                        <div class="row">
							<div class="col-12">
								<?php echo form_label('Certificate Upload ', 'image'); ?>
								<div class="stuffs_to_clone">
									<div class="stuff mt-3">
										<div class="form-group col-12">
											<input type="text" class="form-control casefilename" name="casefilename[]" placeholder="Certificate Name" id="casefilename" />
											<input type="file" id="image" class="form-control casefile" name="image[]" />
											<div class="del disabled hidden"></div>
										</div>
									</div>
									<div class="clone mt-2" title="Add more files">Add more files</div>
									<div id="upload_prev" style="display:none;"></div>
								</div>
								<!--<input type="file" name="image[]" id="image" class="form-control" size="20" multiple required />-->
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 2MB)</span></label>
								<?php echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
							</div>
							<div class="col-md-12">								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="allverified_step3" id="allverified" <?php if($verifiedconsultantdata->allverified_step3 == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>> <label for="allverified">All certificates are verified by backend team. </label></p>
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
                            <div class="form-group col-12 mt-5">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_user_btn", "value" => "Verify & Next"));
                                echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list') . '" class="btn btn-danger">Cancel</a>';
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
<script>
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
	}); 
	$(document).ready(function() {
		$('#v_aadhar_no').click(function() {
			if($('#v_aadhar_no').prop('checked')){
				$('#v_aadhar_no').val('1');
				$('#v_aadhar_no_lbl').text('Verified');
			}else{
				$('#v_aadhar_no').val('0');
				$('#v_aadhar_no_lbl').text('Not verified');
			}
		});
		$('#v_aadhar_photo').click(function() {
			if($('#v_aadhar_photo').prop('checked')){
				$('#v_aadhar_photo').val('1');
				$('#v_aadhar_photo_lbl').text('Verified');
			}else{
				$('#v_aadhar_photo').val('0');
				$('#v_aadhar_photo_lbl').text('Not verified');
			}
		});
		$('#v_pan_no').click(function() {
			if($('#v_pan_no').prop('checked')){
				$('#v_pan_no').val('1');
				$('#v_pan_no_lbl').text('Verified');
			}else{
				$('#v_pan_no').val('0');
				$('#v_pan_no_lbl').text('Not verified');
			}
		});
		$('#v_pan_photo').click(function() {
			if($('#v_pan_photo').prop('checked')){
				$('#v_pan_photo').val('1');
				$('#v_pan_photo_lbl').text('Verified');
			}else{
				$('#v_pan_photo').val('0');
				$('#v_pan_photo_lbl').text('Not verified');
			}
		});
		var clicked = false;
		$('#allverified').click(function() {
			if($(this).prop('checked')){
				$(this).val('1');
				$(".verifyinput .v_checkbox").prop("checked", !clicked);
				$('.verifyinput .v_checkbox').val('1');
				$('.verifyinput label').html('verified');
			}else{
				$(this).val('0');
				$(".verifyinput .v_checkbox").prop("checked", clicked);
				$('.verifyinput .v_checkbox').val('0');
				$('.verifyinput label').html('Not Verified');
			}
		});
		
	});
</script>