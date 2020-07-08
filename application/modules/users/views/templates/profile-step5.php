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
	border: 1px solid #ced4da !important;
	outline: 0;
	height: 38px;
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
.titkeofpgr{
	font-size: 18px;
	font-weight: 600;
	margin: 0;
	color: #263a7d;
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
								<span class="number three ">
									<a href="<?php echo $profile3; ?>">3</a>
								</span>
								<span class="text-part ">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four">
									<a href="<?php echo $profile4; ?>">4</a>
								</span>
								<span class="text-part">
									Sub Category<br>Margin Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five active">
									<a href="<?php echo $profile5; ?>">5</a>
								</span>
								<span class="text-part active">
									Bank<br>Info
								</span>
							  </div>
							</div>
						</div>
                    </div>
                    <?php echo form_open_multipart($pageUrl, array('class' => 'other_info', 'id' => 'Consultantverifystep5Form')); ?>
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
        						<div class="form-group inputBox <?php echo !empty($usersData->bank_name)?'focus':''; ?>">
									<?php
										echo form_label('Bank Name*', 'bank_name');
										echo form_input(array('name' => 'bank_name', 'class' => 'form-control input', 'value' => set_value('bank_name',$usersData->bank_name), 'id' => "bank_name"));
										echo '<div class="error-msg">' . form_error('account_type') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
        						<div class="form-group inputBox <?php echo !empty($usersData->account_no)?'focus':''; ?>">
                                <?php
									echo form_label('Account Number*', 'account_no');
									echo form_input(array('name' => 'account_no', 'class' => 'form-control input', 'value' => set_value('account_no',$usersData->account_no), 'id' => "account_no"));
									echo '<div class="error-msg">' . form_error('account_no') . '</div>';
                                ?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
        						<div class="form-group inputBox <?php echo !empty($usersData->ifsc_code)?'focus':''; ?>">
									<?php
										echo form_label('IFSC Code*', 'ifsc_code');
										echo form_input(array('name' => 'ifsc_code', 'class' => 'form-control input', 'value' => set_value('ifsc_code',$usersData->ifsc_code), 'id' => "ifsc_code"));
										echo '<div class="error-msg">' . form_error('ifsc_code') . '</div>';
									?>
								</div>
                            </div>
							<div class="col-6">
        						<div class="form-group inputBox <?php echo !empty($usersData->accountholdername)?'focus':''; ?>">
									<?php
										echo form_label('Account Holder Name*', 'accountholdername');
										echo form_input(array('name' => 'accountholdername', 'class' => 'form-control input', 'value' => set_value('accountholdername',$usersData->accountholdername), 'id' => "accountholdername"));
										echo '<div class="error-msg">' . form_error('accountholdername') . '</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "create_user_btn", "value" => "Submit"));
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

