<?php 
	if($user_type == 'consultant'){
		$categoryid 		= !empty($usersData)?$usersData->category_id:'';
		$subcategoryid 		= !empty($usersData)?$usersData->subcategory_id:'';
		$categoryidarr 		= explode(',',$categoryid);
		$subcategoryidarr 	= explode(',',$subcategoryid);
		$allcat 			= array_merge($categoryidarr,$subcategoryidarr);
		$selectedcategories = implode(',',$allcat);
	}
?>
<style>
.datepickerdob  {
    background: url('http://www.filenotice.com/backend/cosmatics/images/calaendar-icon.png') no-repeat right 5px center !important;
}
.agecale i{
	position: absolute;
	right: 15px;
	top: 15px;
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
.imgbrder {
	border: 1px solid #f3781e;
	margin-top: 0;
	float: left;
	width: 80px;
	height: 80px;
	padding: 4px;
	background: #fff;
	box-shadow: 0 0 5px #000;
}
.havwesomeadon label.error {
    position: absolute !important;
    bottom: -14px !important;
    width: 100%;
    left: 0;
    font-size: 10px;
}
textarea {
	line-height: 25px !important;
}
input [type=file]{
	line-height: 16px !important;
	4px 2px !important;
}
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-sucess">
                        <div class="card-header">
							<h3 class="card-title"><?php echo $page_title; ?></h3>
							<?php 
								if($user_type == 'consultant'){
							?>
							<div class="row" style="min-height: 130px;">
							  <div class="active-screen">
								  <div class="number-account">
									  <span class="number one active">
										<a href="<?php echo $profile; ?>">1</a>
									   </span>
									   <span class="text-part active">
		                                    Personal<br>Info
		                                </span>
								  </div>
								  <div class="number-account">
									<span class="number two notreached">
										<a href="<?php echo $profile2; ?>">2</a>
									 </span>
									 <span class="text-part">
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
							<?php } ?>
                        </div>
                        <?php 
							echo form_open_multipart($pageUrl, array('id' => 'ProfileForm'));
                        ?>
                        <div class="card-body floating-laebls">
                        	<div class="profilebgs">
							<?php
								if($this->session->flashdata('responce_msg')!=""){
									$message = $this->session->flashdata('responce_msg');
									echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
								}
								$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
							?>                           
                            <div class="row">
                                <div class="col-2">
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Title', 'title');
											$allprefix = [];
											foreach($prefixdata as $prefix){
												$allprefix[$prefix->id] = $prefix->title;
											}
											$title = !empty($usersData)?$usersData->title:'';
											echo form_dropdown('title', $allprefix, set_value('title',$title), 'class="form-control input" id="title" tabindex="1"');
											echo '<div class="error-msg">' . form_error('title') . '</div>';
										?>
									</div>  
								</div>
                                <div class="col-5">
									<?php 
										$user_name 		= $usersData->name;
										$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
										$lowercaseTitle = strtolower($new_string); 
										$ucTitleString 	= ucwords($lowercaseTitle);
									?>
									<div class="form-group inputBox <?php echo !empty($user_name)?'focus':'';?>">
										<?php 
											echo form_label('First Name *', 'user_name');
											echo form_input(array('name' => 'user_name', 'class' => 'form-control input', 'value' => set_value('user_name',$ucTitleString), 'id' => "user_name"));
											echo '<div class="error-msg">' . form_error('user_name') . '</div>';
										?>
									</div>
								</div>
								<div class="col-5">
									<?php 
										$user_sname 	= $usersData->sname;
										$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_sname)));
										$lowercaseTitle = strtolower($new_string); 
										$ucTitleString 	= ucwords($lowercaseTitle);
									?>
									<div class="form-group inputBox <?php echo !empty($user_sname)?'focus':'';?>">
										<?php
											echo form_label('Last Name *', 'sname');
											echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$ucTitleString), 'id' => "sname","maxlength" =>"50","tabindex"=>'3',"onkeypress"=>"return alpha(event)"));
											echo '<div class="error-msg">' . form_error('sname') . '</div>';
										?>						
									</div>
								</div>
							</div>
							<div class="row">
                            	<div class="col-6">
									<div class="form-group inputBox <?php echo !empty($usersData->email)?'focus':'';?>">
										<?php
											echo form_label('Email *', 'user_email');
											echo form_input(array('name' => 'user_emails', 'class' => 'form-control input', 'value' => set_value('user_email',$usersData->email), 'id' => "user_email",'disabled' => 'disabled'));
											echo form_input(array('type'=>'hidden','name' => 'user_email', 'class' => 'form-control', 'value' => set_value('user_email',$usersData->email)));
											echo '<div class="error-msg">' . form_error('user_email') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6 havwesomeadon">
									<div class="form-group inputBox <?php echo !empty($usersData->mobile)?'focus':'';?>">
										<?php echo form_label('Mobile Number *', 'user_mobile');?>
										<div class="input-group">
											<span class="input-group-addon" id="sizing-addon1">+91</span>
											<?php
												echo form_input(array('name' => 'user_mobile', 'class' => 'form-control input', 'id' => 'user_mobile', 'value' => set_value('user_mobile',$usersData->mobile), 'maxlength' => '10'));
												echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
											?>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<div class="form-group inputBox focus">
										<label> Gender *</label><br>
										<input id="male" type="radio" name="gender" value="1" tabindex="6" <?php if($usersData->gender == 1){ ?>checked="checked" <?php } ?>> <span class="gnedrename">Male</span>&nbsp; &nbsp;
										<input id="female" type="radio" name="gender" value="2" <?php if($usersData->gender == 2){ ?>checked="checked" <?php } ?>> <span class="gnedrename">Female</span> &nbsp; &nbsp;
										<input id="other" type="radio" name="gender" value="3" <?php if($usersData->gender == 3){ ?>checked="checked" <?php } ?>> <span class="gnedrename">Other</span><br>
									</div>
								</div>
								<div class="col-6 customerdob">
									<?php if($user_type == 'customer'){ ?>
									<div class="row">
										<div class="col-4">
											<div class="form-group">
												<label style="visibility: hidden; width: 100%"> Age Dob *</label>
												<input id="age" type="radio" name="agepriority" tabindex="7" checked="" /> <span class="gnedrename">Age</span>&nbsp; &nbsp;
												<input id="dob" type="radio" name="agepriority"/> <span class="gnedrename">DOB</span> &nbsp; &nbsp;
											</div>
										</div>
										<div class="col-8">
											<div class="form-group calendar-icon agecale inputBox <?php echo !empty($usersData->dob)?'focus':'';?>" id="customer_dob" style="display: none;">
												<?php
													$dob = ''; 
													if(!empty($usersData->dob) && $usersData->dob != '0000-00-00'){
														$dob = date('d-m-Y',strtotime($usersData->dob));
													}
													echo form_label('Date Of Birth', 'user_dob');
													echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('user_dob',$dob), 'id' => 'dob', 'readonly'=>'readonly'));
													echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
												?>				
											</div>
											<?php 
												$age ='';
												if(!empty($usersData->age)){
													$age = $usersData->age;
												}else{
													$userdob	= $usersData->dob;
													if(!empty($userdob) && $userdob != '0000-00-00'){
														$diff 		= (date('Y') - date('Y',strtotime($userdob)));
													}else{
														$diff 		= '';
													}
													$age = $diff;
												}
											?>
											<div class="form-group agecale inputBox <?php echo !empty($age)?'focus':'';?>" id="cr_age" style="display: block;">
												<?php
													echo form_label('Age', 'customer_age');
													echo form_input(array('type'=>'number','name' => 'customer_age', 'class' => 'form-control input', 'value' => set_value('customer_age',$age), 'id' => "customer_age","min"=>"18","max"=>"80"));
												?>						
											</div>
										</div>
									</div>
								<?php }else{ ?>
									<div class="form-group calendar-icon inputBox <?php echo !empty($usersData->dob)?'focus':'';?>">
										<?php
											$dob = ''; 
											if(!empty($usersData->dob)){
												$dob = date('d-m-Y',strtotime($usersData->dob));
											}
											echo form_label('Date Of Birth', 'user_dob');
											echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('user_dob',$dob), 'id' => 'dob','readonly'=>'readonly'));
											echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
										?>				
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="row">
                        	<div class="col-6">                        		 
                                <div class="form-group inputBox <?php echo !empty($usersData->address)?'focus':'';?>">
                                    <?php
                                    echo form_label('Address *', 'user_address');
                                    echo form_textarea(array('name' => 'user_address',
                                            'class' => 'form-control input',
                                            'value' =>  set_value('user_address',$usersData->address),
                                            'cols' => '4',
                                            'rows' => '2'
                                        )
                                    );
                                    echo '<div class="error-msg">' . form_error('user_address') . '</div>';
                                    ?>
                                </div>
                        	</div>
                        	<div class="col-6">                        		 
                                <div class="form-group inputBox <?php echo !empty($usersData->zip)?'focus':'';?>">
                                    <?php
                                    echo form_label('Pin Code *', 'pin_code');
                                    echo form_input(array('name' => 'pin_code', 'class' => 'form-control input', 'value' => set_value('pin_code',$usersData->zip), 'maxlength' => '6'));
                                     echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
                                    ?> 
                                </div>
                        	</div>
						</div>
                        <div class="row">
                        	<div class="col-6">                        		 
                                <div class="form-group inputBox focus">
                                    <?php
										echo form_label('Country *', 'user_country');
										$option = array('' => 'Select Country');
										foreach ($countryList as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
										echo form_dropdown('user_country',$option,$selected=set_value('user_country',$usersData->country_id),$extra='class="form-control select-state input" data-section="edit_state" data-stateid="'.$usersData->state_id.'" id="user_country" disabled="disabled"');
										echo form_hidden('user_country',$usersData->country_id);
										echo '<div class="error-msg">' . form_error('user_country') . '</div>';
                                    ?>
                                </div>
                        	</div>
                        	<div class="col-6">                        		 
                                <div class="form-group inputBox focus">
                                    <?php
										echo form_label('State *', 'user_state');
										$option = array('' => 'Select State');
										echo form_dropdown('user_state', $option, $selected = set_value('user_state'), $extra = 'class= "form-control input" id="edit_state"');
										echo '<div class="error-msg">' . form_error('user_state') . '</div>';
                                    ?>
                                </div>
                        	</div>
						</div>
                        <div class="row">
                        	<div class="col-6">                        		 
                                <div class="form-group inputBox focus">
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
										echo form_dropdown('user_city', $allcity, set_value('user_city',$usersData->city_id), 'class="form-control input" id="user_city"'); 
										echo '<div class="error-msg">' . form_error('user_city') . '</div>';
										/* echo form_label('City *', 'user_city');
										echo form_input(array('name' => 'user_city', 'class' => 'form-control', 'value' => set_value('user_city',$usersData->city_id), 'id' => 'user_city', 'placeholder' => 'Enter City'));
										echo '<div class="error-msg">' . form_error('user_city') . '</div>'; */
                                    ?> 
                                </div>
                        	</div>
                        </div>
                        <?php if($usersData->user_type=='3'){ ?>
							<div class="row">
								<div class="col-6">
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Account Type *', 'account_type');
											echo form_dropdown('account_type', array(
												'' => 'Select Account Type',
												'freelancer' => 'Freelancer',
												'agency'     => 'Agency'
											), $selected = set_value('account_type',$usersData->account_type), $extra = 'class= "form-control input" id="account_type"');
											echo '<div class="error-msg">' . form_error('account_type') . '</div>';
										?>
									</div>
								</div>
	                            <div class="col-6">
									<div class="form-group inputBox focus">
										<?php 
											echo form_label('Category & Subcategory*', 'getids');
										?>
										<input type="text" id="catsubcat" class="form-control input" name="catsubcat" placeholder="Select Category & Subcategory" autocomplete="off" required />
										<input type="hidden" id="getids" name="getids" value="<?php echo $selectedcategories; ?>">
										<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<?php 
										$telephone = '';
										if(!empty($usersData->telephone)){
											$telephone = $usersData->telephone;
										}
									?>
									<div class="form-group inputBox <?php echo !empty($telephone)?'focus':''; ?>">
										<?php
											echo form_label('Emergency Contact Number', 'contact_number');
											echo form_input(array('name' => 'contact_number', 'class' => 'form-control input', 'id' => 'contact_number', 'value' => set_value('contact_number',$telephone), 'maxlength' => '10'));
											echo '<div class="error-msg">' . form_error('contact_number') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6">
									<?php 
										$selectedexpertise = [];
										if(!empty($usersData->expertise)){
											$selectedexpertise = explode(',',$usersData->expertise);
										}
									?>
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Expertise', 'expertise_text[]');
											$option = array();
											foreach ($expertise as $key => $value) {
												$option[$value->id] = ucfirst($value->name);
											}
											echo form_multiselect('expertise_text[]', $option, $selected = set_value('expertise_text[]',$selectedexpertise), $extra = 'class="form-control input" rows=3 id="expertise_text"');
											echo '<div class="error-msg">' . form_error('expertise_text') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6 qualification">
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
												echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification',$usersData->sub_education), $extra = 'class="form-control col-6 input" id="sub_qualification"');
											}else{
												echo form_dropdown('sub_qualification', $subqualioptions, $selected = set_value('sub_qualification'), $extra = 'class="form-control col-6 input" id="sub_qualification"');
											}
											echo '<div class="error-msg">' . form_error('education_text') . '</div>';
										?>
									</div>
								</div>
								<div class="col-6 experience">
									<div class="form-group inputBox focus">
										<?php
											echo form_label('Experience', 'experience_yr');
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
											echo form_dropdown('experience_yr', $option, $selected = set_value('experience_yr',$experience_yr), $extra = 'class="form-control col-6 input" id="experience_yr"');
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
											echo form_dropdown('experience_mn', $option, $selected = set_value('experience_mn',$experience_mn), $extra = 'class="form-control col-6 input" id="experience_mn"');
										?>
									</div>
								</div>
							</div>  
						<?php } ?>
                        <div class="row mt-4 profleopid">
                        	<div class="col-6">
        						<div class="form-group inputBox focus">
                                    <?php 
										echo form_label('Profile Picture <span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Supported Format: gif | jpg | png | jpeg / Max. upload size 1MB)</span>', 'user_photo'); 
										$data = array(
											'type' 	=> 'file',
											'name' 	=> 'user_photo',
											'id'   	=> 'user_profile_photo',
											'value' => set_value('user_photo'),
											'class' => 'form-control input',
											'onchange'=>'loadImg(event)'
										);
										echo form_input($data);	
									?>
                                    <?php echo '<div class="error-msg">' . form_error('user_photo') . '</div>';?>
                                </div>
                        	</div>
							<div class="col-6">
								<?php 
									$profilepic = !empty($usersData->photo)?$usersData->photo:'no_image_available.jpeg';
								?>
								<img class="imgbrder" style="width:150px; height:150px; float:left" src="<?php echo base_url().'uploads/profile/'.$profilepic; ?>" />
							</div>
                        </div> 
						<div class="row mt-3">
							<?php 
								if($user_type == 'consultant'){
									$btnname = 'Submit & Next';
								}else{
									$btnname = 'Submit';
								}
							?>
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "creatre_user_btn", "value" => $btnname));
										echo '&nbsp;&nbsp;<a href="' . base_url('dashboard') . '" class="btn btn-default">Cancel</a>';
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
	$("#expertise_text").select2({
		placeholder: "Select Expertise",
		allowClear: true,
		container:'body'
	});
</script>
<script type="text/javascript">
<?php
	if($user_type == 'consultant'){
		$allcategoryarray 		= [];
		$parentcategoryarray 	= [];
		$subcategoryarray 		= [];
		$a = 0;
		foreach($category as $key => $value){
			$allcategoryarray[$a]['id'] 	= $value->id;
			$allcategoryarray[$a]['title'] 	= $value->name;
			$allsubcat = $this->category_model->getsubcategory($value->id);
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
<?php } ?>
$('#age').click(function(){
	$('#customer_dob').hide();
	$('#cr_age').show();
});
$('#dob').click(function(){
	$('#customer_dob').show();
	$('#cr_age').hide();
});

var loadImg=function(event){
	$('.imgbrder').attr('src', URL.createObjectURL(event.target.files[0]));
};

</script>