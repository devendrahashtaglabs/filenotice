<?php 
	$categoryid 		= !empty($consultant)?$consultant->category_id:'';
	$subcategoryid 		= !empty($consultant)?$consultant->subcategory_id:'';
	$categoryidarr 		= explode(',',$categoryid);
	$subcategoryidarr 	= explode(',',$subcategoryid);
	$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
	$selectedcategories = implode(',',$allcat);
?>
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
                        <h3 class="card-title"><?php echo $page_title . ' =><a href="' . $pageUrl . '">Step 2</a>' . "=>" . '<a href="' . $edit . '">Step 1</a>'; ?></h3>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'ConsultantInfoForm')); ?>
                    <div class="card-body floating-laebls">
                        <?php
                        if ($this->session->flashdata('responce_msg') != "") {
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
                        }
                        ?>
                        <div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php 
										echo form_label('Category & Subcategory*', 'getids');
									?>
									<input type="text" id="catsubcat" name="catsubcat" placeholder="Select Category & Subcategory" autocomplete="off" required />
									<input type="hidden" id="getids" name="getids" value="<?php echo $selectedcategories; ?>">
									<?php 
										echo '<div id="catsubcat_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('getids') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<?php 
									$contact_focus 	= !empty($consultant->telephone)?"focus":"";
								?>
								<div class="form-group inputBox <?php echo $contact_focus; ?>">
									<?php
										echo form_label('Emergency Contact Number', 'contact_number');
										echo form_input(array('name' => 'contact_number', 'class' => 'form-control input', 'id' => 'contact_number', 'value' => set_value('contact_number',$consultant->telephone), 'maxlength' => '14'));
										echo '<div id="contact_number_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
									?>
								</div>   
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								 <div class="form-group inputBox focus">
									<?php echo form_label('Profile Picture', 'user_photo'); ?>
								   <span class="text-danger profilepicmsg">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 1MB)</span>                                 
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'user_photo',
											'id'   => 'user_profile_photo',
											'value' => set_value('user_photo'),
											'class' => 'form-control input',
										);
										echo form_input($data);
										echo '<div class="error-msg">' . form_error('user_photo') . '</div>'; 
										if($consultant->photo) { echo '<img src="'.base_url().'uploads/profile/'.$consultant->photo.'" style="width:50px; height:50px;" />'; }
									?>
								</div>
							</div>
							<div class="col-6">
								<?php 
									$aadhar_focus 	= !empty($consultant->aadhaar_card_number)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $aadhar_focus; ?>">
                                <?php
									echo form_label('Aadhar Number', 'aadhar_no');
									echo form_input(array('name' => 'aadhar_no', 'class' => 'form-control input', 'value' => set_value('aadhar_no',$consultant->aadhaar_card_number), 'id' => "aadhar_no", 'maxlength' => '12'));
                                    echo '<div id="aadhar_no_error_msg" class="custom-error"></div>';
									echo '<div class="error-msg">' . form_error('aadhar_no') . '</div>';
                                ?>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
								 <div class="form-group inputBox focus">
									<?php echo form_label('Aadhar Photo', 'aadhar_photo'); ?>
								   <span class="text-danger profilepicmsg">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 2MB)</span>                                 
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'aadhar_photo',
											'id'   => 'user_aadhar_photo',
											'value' => set_value('aadhar_photo'),
											'class' => 'form-control input',
										);
										echo form_input($data);
										echo '<div class="error-msg">' . form_error('aadhar_photo') . '</div>'; 
										 if($consultant->aadhaar_photo) { echo '<img src="'.base_url().'uploads/consultant/'.$consultant->aadhaar_photo.'" style="width:50px; height:50px;" />'; }
									?>
								</div>
							</div>
							<div class="col-6">
								<?php 
									$pan_focus 	= !empty($postdata['pan_no'])?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $pan_focus; ?>">
									<?php
										echo form_label('Pan Number', 'pan_no');
										echo form_input(array('name' => 'pan_no', 'class' => 'form-control input', 'value' => set_value('pan_no',$consultant->pan_card_number), 'id' => "pan_no", 'maxlength' => '10'));
										echo '<div id="pan_no_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('pan_no') . '</div>';
									?>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
								 <div class="form-group inputBox focus">
									<?php echo form_label('Pan Photo', 'pan_photo'); ?>
								   <span class="text-danger profilepicmsg">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 2MB)</span>                                 
									<?php
										$data = array(
											'type' => 'file',
											'name' => 'pan_photo',
											'id'   => 'user_pan_photo',
											'value' => set_value('pan_photo'),
											'class' => 'form-control input',
										);
										echo form_input($data);
										echo '<div class="error-msg">' . form_error('pan_photo') . '</div>';
										 if($consultant->pan_photo) { echo '<img src="'.base_url().'uploads/consultant/'.$consultant->pan_photo.'" style="width:50px; height:50px;" />'; }
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Expertise', 'expertise_text[]');
										$option = array();
										foreach ($expertise as $key => $value) {
										$option[$value->id] = ucfirst($value->name);
										}
										$selectedexp = (empty($consultant->expertise)? '' : explode(',', $consultant->expertise));
										echo form_multiselect('expertise_text[]', $option, $selected = $selectedexp, $extra = 'class="form-control input", id="expertise_text"');
									?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								<div class="form-group inputBox focus qualification">
									<?php
										echo form_label('Heighest Qualification', 'qualification');
										$qualioptions = array('' => 'Select Qualification');
										if(!empty($qualificationData)){
											foreach($qualificationData as $qualification){
												$qualioptions[$qualification->qualification_id] = $qualification->qualification_name;
											}
										}
										$selectededucation = '';
										if(!empty($consultant->education)){
											$selectededucation = $consultant->education;
										}
										echo form_dropdown('qualification', $qualioptions, $selected = set_value('qualification',$selectededucation), $extra = 'class="form-control input col-6" id="ad_qualification"');
										
										$subqualioptions = array('' => 'Select Course');
										if(!empty($consultant->education)){
											$subqualificationData = $this->user_model->getsubqualificationbyqualid($consultant->education);
											if(!empty($subqualificationData)){
												foreach($subqualificationData as $subqualification){
													$subqualioptions[$subqualification->subqualification_id] = $subqualification->subquali_name;
												}
											}
										}
										if(!empty($consultant->sub_education)){
											echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification',$consultant->sub_education), $extra = 'class="form-control input col-6" id="ad_sub_qualification"');
										}else{
											echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification'), $extra = 'class="form-control input col-6" id="ad_sub_qualification"');
										}
										echo '<div class="error-msg">' . form_error('education_text') . '</div>';
									?>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group inputBox focus experience">
									<?php
										echo form_label('Experience', 'experience_yr');
										$experience = [];
										if(!empty($consultant->experience)){
											$experience = $consultant->experience;
										}
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
													''          => 'Select Year',
													'1'         => '1',
													'2'         => '2',
													'3'         => '3',
													'4'         => '4',
													'5'         => '5',
													'5+'        => '5+',
										);
										echo form_dropdown('experience_yr', $option, $selected = set_value('experience_yr',$experience_yr), $extra = 'class="form-control input col-6" id="experience_yr"');
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
										echo form_dropdown('experience_mn', $option, $selected = set_value('experience_mn',$experience_mn), $extra = 'class="form-control input col-6" id="experience_mn"');
									?>
								</div>
							</div>
                        </div>
						<div class="row">
							<div class="form-group col-12 mt-5 pb-3 border-bottom">
								<h4 class="card-title"> Public Profile Section </h4>
							</div>
						</div>
						<div class="row">
							<div class="col-6">
								 <div class="form-group inputBox focus">
									<?php echo form_label('Banner Image', 'banner_image'); ?>
								   <span class="text-danger profilepicmsg">(Supported File Format: gif | jpg | png | jpeg / Max. upload size 2MB)</span>                                 
									<?php
										
										$banner_image = '';
										if(!empty($consultant->banner_image)){
											$banner_image = $consultant->banner_image;
										}
										$data = array(
											'type' 	=> 'file',
											'name' 	=> 'banner_image',
											'id' 	=> 'user_banner_image',
											'value' => set_value('banner_image',$banner_image),
											'class' => 'form-control',
											'style' => 'line-height:17px;'
										);
										echo form_input($data);
									?>
									 
									<?php echo '<div class="error-msg">' . form_error('user_banner_image') . '</div>';?>
									<?php if(!empty($banner_image)){ ?>
										<img src="<?php echo FRONTEND_URL . 'uploads/consultant/banners/' .$banner_image; ?>" class="img-fluid" width="100" height="100" />
									<?php } ?>
									<?php /*<div>
										<img src="<?php echo FRONTEND_URL . 'uploads/consultant/' .$banner_image; ?>" class="img img-responsive" id="profile_picture" data-src="<?php echo FRONTEND_URL . 'uploads/consultant/' .$banner_image; ?>" data-holder-rendered="true" /><br />
									</div>*/?>
									<?php 
										$data = array(
												'type'  => 'hidden',
												'name'  => 'cropped_banner_image',
												'id'    => 'cropped_banner_image',
												'value' => '',
												'class' => 'cropped_banner_image'
										);
										echo form_input($data);
									?>
									<!--<a type="button" class="btn btn-default" id="change-profile-pic">Change Banner Picture</a>-->
								</div>
							</div>
							<div class="col-6">
								<?php 
									$company_name = '';
									if(!empty($consultant->company_name)){
										$company_name = $consultant->company_name;
									}
									$sname_focus 	= !empty($company_name)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $sname_focus; ?>">
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
									if(!empty($consultant->about_consultant)){
										$about_consultant = $consultant->about_consultant;
									}
									$about_focus = !empty($about_consultant)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $about_focus; ?>">
                                <?php
									echo form_label('About Consultant * ', 'about_consultant');
									echo form_textarea(array('name' => 'about_consultant', 'class' => 'form-control input', 'value' => set_value('about_consultant',$about_consultant),'minlength' => '20','rows' => '5','cols' => '5'));
									echo '<div id="about_consultant_error_msg" class="custom-error"></div>';
									echo '<div class="error-msg">' . form_error('about_consultant') . '</div>';
                                ?>
                                </div>
                            </div>
							<div class="col-6">
								<?php 
									$company_address = '';
									if(!empty($consultant->company_address)){
										$company_address = $consultant->company_address;
									}
									$company_address_focus = !empty($company_address)?"focus":"";
								?>
                                <div class="form-group inputBox <?php echo $company_address_focus; ?>">
                                <?php
									echo form_label('Comany Address', 'company_address');
									echo form_textarea(array('name' => 'company_address', 'class' => 'form-control input', 'value' => set_value('company_address',$company_address), 'rows' => '5','cols' => '5'));
									echo '<div class="error-msg">' . form_error('company_address') . '</div>';
                                ?>
                                </div>
                            </div>
						</div>
						<div class="row">
							<div class="form-group col-12">
                                <?php
									echo form_submit(array("class" => "btn btn-primary", "id" => "create_user_btn", "value" => "Submit"));
									echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list') . '" class="btn btn-default">Cancel</a>';
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
<script type="text/javascript">
<?php
	$allcategoryarray 		= [];
	$parentcategoryarray 	= [];
	$subcategoryarray 		= [];
	$a = 0;
	foreach($category as $key => $value){
		$allcategoryarray[$a]['id'] 	= $value->id;
		$allcategoryarray[$a]['title'] 	= $value->name;
		$allsubcat = $this->category_model->listSubCategoryById($value->id);
		$newa = 0;
		foreach($allsubcat as $subcat){
			$subcategoryarray[$newa]['id'] 	= $subcat->id;
			$subcategoryarray[$newa]['title'] 	= $subcat->name;
			$newa++; 
		}
		$allcategoryarray[$a]['subs'] = $subcategoryarray;
		$a++; 
	}
?>

var SampleJSONData2 = <?php echo json_encode($allcategoryarray); ?>;
var comboTree3;
comboTree3 = $('#catsubcat').comboTree({
	source : SampleJSONData2,
	isMultiple: true,
	cascadeSelect: true,
	collapse: true,
	selectableLastNode:true,
	selected:<?php echo json_encode($allcat); ?>,
	hiddeninput:'#getids'
});
comboTree3.setSource(SampleJSONData2);
</script>
