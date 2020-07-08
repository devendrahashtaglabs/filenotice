<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
}
.verifyinput {
	float: right;
	margin-top: 0;
	position: relative;
	top: -22px;
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
    background-color: #fff !important;
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
.havwesomeadon label.error {
    position: absolute;
    bottom: -20px;
    width: 100%;
    left: 0;
}
#qualification, #experience_yr, #ad_qualification {
	float: left;
	width: 49%;
}
#sub_qualification, #experience_mn, #ad_sub_qualification {
	float: left;
	width: 48%;
	margin-left: 15px;
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
								<span class="number one active">
									<a href="<?php echo $pageUrl; ?>">1</a>
								</span>
								<span class="text-part active">
									Personal<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number two">
									<a href="javascript:void(0);">2</a>
								</span>
								<span class="text-part">
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
                    <?php echo form_open($pageUrl, array('class' => 'create_users', 'id' => 'ConsultantverificationForm')); ?>
                    <div class="card-body">
                    	<div class="profilebg">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="row">
                            <div class="form-group col-6">
                                <?php
									echo form_label('Account Type*', 'account_type');
									echo form_dropdown('account_type', array(
										'' => 'Select Account Type',
										'freelancer' => 'Freelancer',
										'agency' => 'Agency'
									), $selected = set_value('account_type',$consultant->account_type), $extra = 'class= "form-control col-8" id="account_type" disabled ="disabled"');
                                ?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_account_type" class="v_checkbox" name="v_account_type" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_account_type == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_account_type" id="v_account_type_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_account_type == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_account_type_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('account_type') . '</div>';
								?>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('Consultant Name*', 'user_name');
									echo form_input(array('name' => 'user_name', 'class' => 'form-control col-8', 'value' => set_value('user_name',$consultant->name), 'id' => "user_name", 'placeholder' => 'Enter name', 'disabled' => 'disabled'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_user_name" class="v_checkbox" name="v_user_name" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_name == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_user_name" id="v_user_name_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_name == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_user_name_error"></div>';
									?>
								</div>
                                <?php 
									echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <?php
									echo form_label('Email Address*', 'user_email');
									echo form_input(array('name' => 'user_email', 'class' => 'form-control col-8', 'value' => set_value('user_email',$consultant->email), 'id' => "user_email", 'placeholder' => 'Enter email', 'disabled' => 'disabled' ));
									echo form_input(array('name' => 'user_email', 'type' => 'hidden', 'value' => $consultant->email, 'id' => "consultant_id"));
								?>
									<div class="col-4 verifyinput">
										<input type="checkbox" id="v_user_email" class="v_checkbox" name="v_user_email" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_email == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
										<label for="v_user_email" id="v_user_email_lbl"><?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_email == 1)?'Verified':'Not verified'; ?></label>
										<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php 
											echo '<div class="custom-error" id="v_user_email_error"></div>';
										?>
									</div>
								<?php 
									echo '<div class="error-msg">' . form_error('user_email') . '</div>';
                                ?>
                            </div>
                           <!--  <div class="form-group col-6">
                                    <?php
                                    //echo form_label('Password*', 'password');
                                    //echo form_input(array('name' => 'password', 'class' => 'form-control', 'value' => set_value('password'), "placeholder" => "Enter Password"));
                                    //echo '<div class="error-msg">' . form_error('password') . '</div>';
                                    ?>
                                </div> -->
                            <div class="form-group col-6">
                                <?php
									echo form_label('Mobile Number*', 'user_mobile');
									echo form_input(array('name' => 'user_mobile', 'class' => 'form-control col-8', 'value' => set_value('user_mobile',$consultant->mobile), 'maxlength' => '10', 'placeholder' => 'Mobile Number', 'disabled' => 'disabled'));
								?>
									<div class="col-4 verifyinput">
										<input type="checkbox" id="v_user_mobile" class="v_checkbox" name="v_user_mobile" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_mobile == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
										<label for="v_user_mobile" id="v_user_mobile_lbl"><?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_mobile == 1)?'Verified':'Not verified'; ?></label>
										<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php 
											echo '<div class="custom-error" id="v_user_mobile_error"></div>';
										?>
									</div>
                                <?php 
									echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
                                ?>
                            </div>
                         </div>
                         <div class="row">
                         	 <div class="form-group col-6">
                                <?php
									echo form_label('Gender', 'user_gender');
									echo form_dropdown('user_gender', $options = array(
										'1' => 'Male',
										'2' => 'Female',
										'3' => 'Other'
									), $selected = set_value('user_gender',$consultant->gender), $extra = 'class= "form-control col-8" id="user_gender" disabled="disabled"');
								?>
									<div class="col-4 verifyinput">
										<input type="checkbox" id="v_user_gender" class="v_checkbox" name="v_user_gender" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_gender == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
										<label for="v_user_gender" id="v_user_gender_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_gender == 1)?'Verified':'Not verified'; ?></label>
										<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php 
											echo '<div class="custom-error" id="v_user_gender_error"></div>';
										?>
									</div>	
                            </div>
                            
                            <div class="form-group col-6">
                                <?php
									$setdt = empty($consultant->dob)? '' : date('d-m-Y', strtotime($consultant->dob));
									echo form_label('Date Of Birth', 'user_dob');
									echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob col-8', 'value' => set_value('user_dob',$setdt), 'id' => 'dob', 'placeholder' => 'Date Of Birth', 'disabled'=>'disabled')); 
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_user_dob" class="v_checkbox" name="v_user_dob" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_dob == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_user_dob" id="v_user_dob_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_dob == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_user_dob_error"></div>';
									?>
								</div>								
								<?php 
									echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
                                ?>
                            </div>
                           </div>
                           <div class="row">
                           	<div class="col-4">
                           		<input type="hidden" value="<?php echo $consultant->userstatus; ?>" />
	                            <div class="form-group">
	                                <?php
										echo form_label('Country*', 'user_country');
										$option = array('' => 'Select Country');
										foreach ($countryList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_dropdown('user_country',$option,$selected=set_value('user_country',$consultant->country_id),$extra='class="form-control col-8 select-state" data-section="create_consultant" data-stateid="'.DEFAULT_STATE.'" disabled="disabled"');
										echo '<div class="error-msg">' . form_error('user_country') . '</div>';
	                                ?>
	                            </div>
                           	</div>
                           	<div class="col-4">
                           		<div class="form-group">
                                <?php
									echo form_label('State*', 'user_state');
									$option = array('' => 'Select State');
									foreach ($stateList as $key => $value) {
										$option[$value->id] = ucfirst($value->name);
									}
									$selectedState = isset($consultant->state_id)?$consultant->state_id:'';
									//echo form_dropdown('user_state', $option,set_value('user_state','3'), $extra = 'class= "form-control" id="create_consultant"');
									echo form_dropdown('user_state', $option, set_value('user_state',$selectedState), 'class="form-control col-8" id="user_state" disabled="disabled"'); 
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_user_state" class="v_checkbox" name="v_user_state" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_state == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_user_state" id="v_user_state_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_state == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
								<?php 
									echo '<div class="custom-error" id="v_user_state_error"></div>';
								?>
                            </div>
                           	</div>
                           	<div class="col-4">
                           		  <div class="form-group">
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
									echo form_dropdown('user_city', $allcity, set_value('user_city',$consultant->city_id), 'class="form-control col-8" id="user_city" disabled="disabled"'); 
									?>
									<div class="col-4 verifyinput">
										<input type="checkbox" id="v_user_city" class="v_checkbox" name="v_user_city" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_city == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
										<label for="v_user_city" id="v_user_city_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_city == 1)?'Verified':'Not verified'; ?></label>
										<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php 
											echo '<div class="custom-error" id="v_user_city_error"></div>';
										?>
									</div>
								<?php echo '<div class="error-msg">' . form_error('user_city') . '</div>';
                                ?>
                            </div>
                           	</div>
                           </div>

                           <div class="row">
                           	<div class="col-9">
                           	<div class="form-group">
                                <?php
                                echo form_label('Address', 'user_address');
                                $data = array(
                                    'name' => 'user_address',
                                    'class' => 'form-control col-8',
                                    'value' => set_value('user_address',$consultant->address),
                                    'cols' => '4',
                                    'rows' => '2',
                                    'placeholder' => 'Address',
                                    'disabled' => 'disabled'
                                );
                                echo form_textarea($data); 
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_user_address" class="v_checkbox" name="v_user_address" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_address == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_user_address" id="v_user_address_lbl"><?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_user_address == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_user_address_error"></div>';
									?>
								</div>
								<?php 
                                echo '<div class="error-msg">' . form_error('user_address') . '</div>';
                                ?>
                            </div>
                            </div>
                            <div class="col-3">
                              <div class="form-group">
                                <?php
									echo form_label('Pin Code', 'pin_code');
									echo form_input(array('name' => 'pin_code', 'class' => 'form-control col-8', 'value' => set_value('pin_code',$consultant->zip), 'maxlength' => '6', 'placeholder' => 'Pin code', 'disabled' => 'disabled'));
								?>
									<div class="col-4 verifyinput">
										<input type="checkbox" id="v_pin_code" class="v_checkbox" name="v_pin_code" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_pin_code == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
										<label for="v_pin_code" id="v_pin_code_lbl"><?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_pin_code == 1)?'Verified':'Not verified'; ?></label>
										<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
										<?php 
											echo '<div class="custom-error" id="v_pin_code_error"></div>';
										?>
									</div>
								<?php 
									echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
                                ?>
                            </div>
                        	</div>
                           </div>
                           <div class="row">
                           	  <div class="col-6">
								<div class="form-group">
	                                <?php
										echo form_label('Emergency Contact Number', 'contact_number');
										echo form_input(array('name' => 'contact_number', 'class' => 'form-control col-8', 'value' => set_value('contact_number', $consultant->telephone), 'maxlength' => '10', 'placeholder' => 'Contact Number', 'disabled' => 'disabled'));
										echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
	                                ?>
	                            </div>
	                        </div>
	                        <div class="col-6">
	                        	<div class="form-group qualification">
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
									echo form_dropdown('qualification', $qualioptions, $selected = set_value('qualification',$selectededucation), $extra = 'class="form-control col-6" id="ad_qualification" disabled="disabled"');
									
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
										echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification',$consultant->sub_education), $extra = 'class="form-control col-6" id="ad_sub_qualification" disabled="disabled"');
									}else{
										echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification'), $extra = 'class="form-control col-6" id="ad_sub_qualification" disabled="disabled"');
									} 
									echo '<div class="error-msg">' . form_error('education_text') . '</div>';
                                ?>
                            </div>
	                        </div>
	                        
                           </div>
                           <div class="row">
                            
							<div class="form-group col-6">
								<div class="col-8" style="padding:0">
									<?php
										echo form_label('Expertise', 'expertise_text[]');

										$option = array();
										foreach ($expertise as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										$selectedexp = (empty($consultant->expertise)? '' : explode(',', $consultant->expertise));
										echo form_multiselect('expertise_text[]', $option, $selected = $selectedexp, $extra = 'class="form-control", id="expertise_text" , disabled="disabled"');
									?>
								</div>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_expertise" class="v_checkbox" name="v_expertise" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_expertise == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_expertise" id="v_expertise_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_expertise == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_expertise_error"></div>';
									?>
								</div>
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
                                echo form_dropdown('experience_yr', $option, $selected = set_value('experience_yr',$experience_yr), $extra = 'class="form-control" id="experience_yr" disabled="disabled"');
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
                                echo form_dropdown('experience_mn', $option, $selected = set_value('experience_mn',$experience_mn), $extra = 'class="form-control" id="experience_mn" disabled="disabled"');
                                //echo '<div class="error-msg">' . form_error('experience_mn') . '</div>';
                                ?>
                            </div>
                          </div>
                          <div class="row">
                           <div class="col-6">
	                        	<div class="form-group">
								<div class="col-8">
									<?php echo form_label('Profile Picture', 'user_photo'); ?><br/>
									<?php 
										if(!empty($consultant->photo)){ 
									?>
										<img src="<?php echo base_url().'uploads/profile/'.$consultant->photo; ?>" class="" width="100" height="100">
									<?php }else{ ?>
										<img src="<?php echo base_url(); ?>uploads/profile/no_image_available.jpeg" class="" width="100" height="100">
									<?php } ?>
								</div>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_user_photo" class="v_checkbox" name="v_user_photo" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_profile_pic == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_user_photo" id="v_user_photo_lbl"> <?php echo (!empty($verifiedconsultantdata) && $verifiedconsultantdata->v_profile_pic == 1)?'Verified':'Not verified'; ?></label>
									<a href="<?php echo base_url().'admin/consultant/edit/'.$consultant->user_id; ?>" title="Edit" class="" target="_blank"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php 
										echo '<div class="custom-error" id="v_user_photo_error"></div>';
									?>
								</div>
                            </div>
	                        </div>
	                       </div>
	                       <div class="'row">						

							<div class="col-md-12">								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="allverified_step1" id="allverified" <?php if(!empty($verifiedconsultantdata) && $verifiedconsultantdata->allverified_step1 == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>> <label for="allverified">All the details are verified by backend team. </label></p>
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
						</div>
						<div class="row">
                            <div class="form-group col-12 pull-right text-right mt-2">
                                <?php
									echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list') . '" class="btn btn-danger">Cancel</a>';
									echo form_submit(array("class" => "btn btn-warning", "id" => "create_user_btn", "value" => "Verify & Next"));
									
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
<script>
	$("#user_state").change(function() { 
		var $option = $(this).find('option:selected');
		var stateId = $option.val();
		$.ajax({
			url: '<?php echo base_url();?>admin/admin/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#user_city").html(data);
			}
		});
	});
	$('#v_account_type').click(function() {
		if($('#v_account_type').prop('checked')){
			$('#v_account_type').val('1');
			$('#v_account_type_lbl').text('Verified');
		}else{
			$('#v_account_type').val('0');
			$('#v_account_type_lbl').text('Not verified');
		}
	});
	$('#v_user_name').click(function() {
		if($('#v_user_name').prop('checked')){
			$('#v_user_name').val('1');
			$('#v_user_name_lbl').text('Verified');
		}else{
			$('#v_user_name').val('0');
			$('#v_user_name_lbl').text('Not verified');
		}
	});
	$('#v_user_email').click(function() {
		if($('#v_user_email').prop('checked')){
			$('#v_user_email').val('1');
			$('#v_user_email_lbl').text('Verified');
		}else{
			$('#v_user_email').val('0');
			$('#v_user_email_lbl').text('Not verified');
		}
	});
	$('#v_user_mobile').click(function() {
		if($('#v_user_mobile').prop('checked')){
			$('#v_user_mobile').val('1');
			$('#v_user_mobile_lbl').text('Verified');
		}else{
			$('#v_user_mobile').val('0');
			$('#v_user_mobile_lbl').text('Not verified');
		}
	});
	$('#v_user_dob').click(function() {
		if($('#v_user_dob').prop('checked')){
			$('#v_user_dob').val('1');
			$('#v_user_dob_lbl').text('Verified');
		}else{
			$('#v_user_dob').val('0');
			$('#v_user_dob_lbl').text('Not verified');
		}
	});
	$('#v_user_gender').click(function() {
		if($('#v_user_gender').prop('checked')){
			$('#v_user_gender').val('1');
			$('#v_user_gender_lbl').text('Verified');
		}else{
			$('#v_user_gender').val('0');
			$('#v_user_gender_lbl').text('Not verified');
		}
	});
	$('#v_user_state').click(function() {
		if($('#v_user_state').prop('checked')){
			$('#v_user_state').val('1');
			$('#v_user_state_lbl').text('Verified');
		}else{
			$('#v_user_state').val('0');
			$('#v_user_state_lbl').text('Not verified');
		}
	});
	$('#v_user_city').click(function() {
		if($('#v_user_city').prop('checked')){
			$('#v_user_city').val('1');
			$('#v_user_city_lbl').text('Verified');
		}else{
			$('#v_user_city').val('0');
			$('#v_user_city_lbl').text('Not verified');
		}
	});
	$('#v_pin_code').click(function() {
		if($('#v_pin_code').prop('checked')){
			$('#v_pin_code').val('1');
			$('#v_pin_code_lbl').text('Verified');
		}else{
			$('#v_pin_code').val('0');
			$('#v_pin_code_lbl').text('Not verified');
		}
	});
	$('#v_user_address').click(function() {
		if($('#v_user_address').prop('checked')){
			$('#v_user_address').val('1');
			$('#v_user_address_lbl').text('Verified');
		}else{
			$('#v_user_address').val('0');
			$('#v_user_address_lbl').text('Not verified');
		}
	});
	$('#v_user_photo').click(function() {
		if($('#v_user_photo').prop('checked')){
			$('#v_user_photo').val('1');
			$('#v_user_photo_lbl').text('Verified');
		}else{
			$('#v_user_photo').val('0');
			$('#v_user_photo_lbl').text('Not verified');
		}
	});
	$('#v_expertise').click(function() {
		if($('#v_expertise').prop('checked')){
			$('#v_expertise').val('1');
			$('#v_expertise_lbl').text('Verified');
		}else{
			$('#v_expertise').val('0');
			$('#v_expertise_lbl').text('Not verified');
		}
	});
	/* $('#v_heighest_qualification').click(function() {
		if($('#v_heighest_qualification').prop('checked')){
			$('#v_heighest_qualification').val('1');
			$('#v_heighest_qualification_lbl').text('Verified');
		}else{
			$('#v_heighest_qualification').val('0');
			$('#v_heighest_qualification_lbl').text('Not verified');
		}
	});
	$('#v_experience').click(function() {
		if($('#v_experience').prop('checked')){
			$('#v_experience').val('1');
			$('#v_experience_lbl').text('Verified');
		}else{
			$('#v_experience').val('0');
			$('#v_experience_lbl').text('Not verified');
		}
	}); */
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
</script>