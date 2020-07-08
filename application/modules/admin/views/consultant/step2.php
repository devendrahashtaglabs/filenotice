<style>
	.verifyinput {
		float: right;
		margin-top: -40px;
	}
</style>
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
						<h3 class="card-title"><?php echo $page_title; ?></h3>
						<div class="row" style="margin-top: 25px; margin-bottom: 85px">
						  <div class="active-screen">
							  <div class="number-account">
								<span class="number one">
									<a href="<?php echo $edit; ?>">1</a>
								</span>
								<span class="text-part">
									Personal<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number two active">
									<a href="<?php echo $pageUrl; ?>">2</a>
								</span>
								<span class="text-part active">
									Company<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number three">
									<a href="javascript:void(0);">3</a>
								</span>
								<span class="text-part">
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
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'ConsultantverificationForm')); ?>
                    <div class="card-body">
                        <?php
                        if ($this->session->flashdata('responce_msg') != "") {
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE, $message['class'], $message['short_msg'], $message['message']);
                        }
                        ?>
                        <div class="row">
							<?php /*<div class="form-group col-6">
								<?php 
									echo form_label('Category & Subcategory*', 'getids');
								?>
								<input type="text" id="catsubcat" name="catsubcat" placeholder="Select Category & Subcategory" autocomplete="off" required />
								<input type="hidden" id="getids" name="getids" value="<?php echo $selectedcategories; ?>">
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>								
							</div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Category Name*', 'category_id');
                                $option = array("" => "Select Category");
                                foreach ($category as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
                                echo form_dropdown('category_id', $option, $selected = set_value('category_id',$consultant->category_id), $extra = 'class="form-control change-category" data-section="create_consultant" data-selectedid=""');
                                echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php echo form_label('Subcategory name*', 'subcategory_id');

                                    $option = array('' => 'Select Sub-category');
                                    $subcats = empty($consultant->category_id) ? array() : $this->category_model->listSubCategoryById($consultant->category_id);
                                   
                                    foreach ($subcats as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                    }
                                    echo form_dropdown('subcategory_id', $option, $selected = set_value('subcategory_id', empty($consultant->subcategory_id)? '' : $consultant->subcategory_id), $extra = 'class="form-control" id="create_consultant"');
                                    echo '<div class="error-msg">' . form_error('subcategory_id') . '</div>';
                                ?>
                            </div> */?>
                            
                        </div>
						<div class="row">
							<div class="form-group col-12 mt-5 pb-3 border-bottom">
								<h4 class="card-title"> Public Profile Section </h4>
							</div>
							<div class="form-group col-6">
								<div class="col-8">
									<?php echo form_label('Banner Image', 'banner_image'); ?><br/>
									<?php 
										if(!empty($consultant->banner_image)){ 
									?>
										<img src="<?php echo base_url().'uploads/consultant/banners/'.$consultant->banner_image; ?>" class="" width="100" height="100">
									<?php }else{ ?>
										<img src="<?php echo base_url(); ?>uploads/profile/no_image_available.jpeg" class="" width="100" height="100">
									<?php } ?>
								</div>
                                <div class="col-4 verifyinput">
									<input type="checkbox" id="v_banner_image" class="v_checkbox" name="v_banner_image" <?php if($verifiedconsultantdata->v_banner_image == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_banner_image" id="v_banner_image_lbl"> <?php echo ($verifiedconsultantdata->v_banner_image == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_banner_image_error"></div>';
									?>
								</div>
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
							<div class="form-group col-6">
                                <?php
									echo form_label('Company Name', 'company_name');
									$company_name = '';
									if(!empty($consultant->company_name)){
										$company_name = $consultant->company_name;
									}
									echo form_input(array('name' => 'company_name', 'class' => 'form-control col-8', 'value' => set_value('company_name',$company_name), 'placeholder' => 'Company Name', 'disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_company_name" class="v_checkbox" name="v_company_name" <?php if($verifiedconsultantdata->v_company_name == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_company_name" id="v_company_name_lbl"> <?php echo ($verifiedconsultantdata->v_company_name == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_company_name_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('company_name') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('About Consultant * ', 'about_consultant');
									$about_consultant = '';
									if(!empty($consultant->about_consultant)){
										$about_consultant = $consultant->about_consultant;
									}
									echo form_textarea(array('name' => 'about_consultant', 'class' => 'form-control col-8', 'value' => set_value('about_consultant',$about_consultant),'minlength' => '20','rows' => '5','cols' => '5','disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_about_consultant" class="v_checkbox" name="v_about_consultant" <?php if($verifiedconsultantdata->v_about_consultant == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_about_consultant" id="v_about_consultant_lbl"> <?php echo ($verifiedconsultantdata->v_about_consultant == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_about_consultant_error"></div>';
									?>
								</div>								
								<?php 
									echo '<div class="error-msg">' . form_error('about_consultant') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Comany Address', 'company_address');
									$company_address = '';
									if(!empty($consultant->company_address)){
										$company_address = $consultant->company_address;
									}
									echo form_textarea(array('name' => 'company_address', 'class' => 'form-control col-8', 'value' => set_value('company_address',$company_address), 'rows' => '5','cols' => '5','disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_company_address" class="v_checkbox" name="v_company_address" <?php if($verifiedconsultantdata->v_company_address == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_company_address" id="v_company_address_lbl"> <?php echo ($verifiedconsultantdata->v_company_address == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit_info/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_company_address_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('company_address') . '</div>';
                                ?>
                            </div>
							<div class="col-md-12">								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="allverified_step2" id="allverified" <?php if($verifiedconsultantdata->allverified_step2 == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>> <label for="allverified">All the details are verified by backend team. </label></p>
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
							<div class="form-group col-12">
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

/* var SampleJSONData2 = <?php echo json_encode($allcategoryarray); ?>;
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
comboTree3.setSource(SampleJSONData2); */
$(document).ready(function(){
	$('#v_banner_image').click(function() {
		if($('#v_banner_image').prop('checked')){
			$('#v_banner_image').val('1');
			$('#v_banner_image_lbl').text('Verified');
		}else{
			$('#v_banner_image').val('0');
			$('#v_banner_image_lbl').text('Not verified');
		}
	});
	$('#v_company_name').click(function() {
		if($('#v_company_name').prop('checked')){
			$('#v_company_name').val('1');
			$('#v_company_name_lbl').text('Verified');
		}else{
			$('#v_company_name').val('0');
			$('#v_company_name_lbl').text('Not verified');
		}
	});
	$('#v_about_consultant').click(function() {
		if($('#v_about_consultant').prop('checked')){
			$('#v_about_consultant').val('1');
			$('#v_about_consultant_lbl').text('Verified');
		}else{
			$('#v_about_consultant').val('0');
			$('#v_about_consultant_lbl').text('Not verified');
		}
	});
	$('#v_company_address').click(function() {
		if($('#v_company_address').prop('checked')){
			$('#v_company_address').val('1');
			$('#v_company_address_lbl').text('Verified');
		}else{
			$('#v_company_address').val('0');
			$('#v_company_address_lbl').text('Not verified');
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
