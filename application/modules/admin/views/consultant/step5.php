<style>
.verifyinput {
	float: right;
	margin-top: -30px;
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
								<span class="number three">
									<a href="<?php echo $step3; ?>">3</a>
								</span>
								<span class="text-part">
									Certification<br>Info
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four">
									<a href="<?php echo $step4; ?>">4</a>
								</span>
								<span class="text-part">
									Sub Category <br/>Margin Info 
								</span>
							  </div>
							  <div class="number-account">
								<span class="number five active">
									<a href="<?php echo $pageUrl; ?>">5</a>
								</span>
								<span class="text-part active">
									Bank<br/>Info 
								</span>
							  </div>
							</div>
						</div>
                    </div>
                    <?php echo form_open($pageUrl, array('class' => 'create_users', 'id' => 'Consultantverifystep5Form')); ?>
                    <div class="card-body">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="row">
							<h4>Bank Details</h4>
						</div>
                        <div class="row">
                            <div class="form-group col-6">
                                <?php
									echo form_label('Bank Name*', 'bank_name');
									echo form_input(array('name' => 'bank_name', 'class' => 'form-control col-8', 'value' => set_value('bank_name',$consultant->bank_name), 'id' => "bank_name", 'placeholder' => 'Enter bank name'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_bank_name" class="v_checkbox" name="v_bank_name" <?php if($verifiedconsultantdata->v_bank_name == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_bank_name" id="v_bank_name_lbl"> <?php echo ($verifiedconsultantdata->v_bank_name == 1)?'Verified':'Not verified'; ?></label>
									<?php 
										echo '<div class="custom-error" id="v_bank_name_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('bank_name') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('Account Number*', 'account_no');
									echo form_input(array('name' => 'account_no', 'class' => 'form-control col-8', 'value' => set_value('account_no',$consultant->account_no), 'id' => "account_no", 'placeholder' => 'Enter account number'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_account_no" class="v_checkbox" name="v_account_no" <?php if($verifiedconsultantdata->v_account_no == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_account_no" id="v_account_no_lbl"> <?php echo ($verifiedconsultantdata->v_account_no == 1)?'Verified':'Not verified'; ?></label>
									<?php 
										echo '<div class="custom-error" id="v_account_no_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('account_no') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('IFSC Code*', 'ifsc_code');
									echo form_input(array('name' => 'ifsc_code', 'class' => 'form-control col-8', 'value' => set_value('ifsc_code',$consultant->ifsc_code), 'id' => "ifsc_code", 'placeholder' => 'Enter IFSC Code.'));
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_ifsc_code" class="v_checkbox" name="v_ifsc_code" <?php if($verifiedconsultantdata->v_ifsc_code == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_ifsc_code" id="v_ifsc_code_lbl"> <?php echo ($verifiedconsultantdata->v_ifsc_code == 1)?'Verified':'Not verified'; ?></label>
									<?php 
										echo '<div class="custom-error" id="v_ifsc_code_error"></div>';
									?>
								</div>
								<?php 
									echo '<div class="error-msg">' . form_error('ifsc_code') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Account Holder Name*', 'accountholdername');
									echo form_input(array('name' => 'accountholdername', 'class' => 'form-control col-8', 'value' => set_value('accountholdername',$consultant->accountholdername), 'id' => "accountholdername", 'placeholder' => 'Enter account holder name')); 
								?>
								<div class="col-4 verifyinput">
									<input type="checkbox" id="v_accountholdername" class="v_checkbox" name="v_accountholdername" <?php if($verifiedconsultantdata->v_accountholdername == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>>
									<label for="v_accountholdername" id="v_accountholdername_lbl"> <?php echo ($verifiedconsultantdata->v_ifsc_code == 1)?'Verified':'Not verified'; ?></label>
									<?php 
										echo '<div class="custom-error" id="v_accountholdername_error"></div>';
									?>
								</div>
								<?php
									echo '<div class="error-msg">' . form_error('accountholdername') . '</div>';
                                ?>
                            </div>
							<div class="col-md-12">								
								<p style="font-size: 13px; margin: 0"><input type="checkbox" name="allverified_step5" id="allverified" <?php if($verifiedconsultantdata->allverified_step5 == 1){ ?>value="1" checked <?php }else{ ?> value="0"<?php } ?>> <label for="allverified">All bank details are verified. </label></p>
								<?php echo '<div class="error" id="procedure_error_message_tools">' . form_error('customer_id') . '</div>'; ?>
							</div>
                            <div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_user_btn", "value" => "Verify & Submit"));
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
	$(document).ready(function(){
		$('#v_bank_name').click(function() {
			if($('#v_bank_name').prop('checked')){
				$('#v_bank_name').val('1');
				$('#v_bank_name_lbl').text('Verified');
			}else{
				$('#v_bank_name').val('0');
				$('#v_bank_name_lbl').text('Not verified');
			}
		});
		$('#v_account_no').click(function() {
			if($('#v_account_no').prop('checked')){
				$('#v_account_no').val('1');
				$('#v_account_no_lbl').text('Verified');
			}else{
				$('#v_account_no').val('0');
				$('#v_account_no_lbl').text('Not verified');
			}
		});
		$('#v_ifsc_code').click(function() {
			if($('#v_ifsc_code').prop('checked')){
				$('#v_ifsc_code').val('1');
				$('#v_ifsc_code_lbl').text('Verified');
			}else{
				$('#v_ifsc_code').val('0');
				$('#v_ifsc_code_lbl').text('Not verified');
			}
		});
		$('#v_accountholdername').click(function() {
			if($('#v_accountholdername').prop('checked')){
				$('#v_accountholdername').val('1');
				$('#v_accountholdername_lbl').text('Verified');
			}else{
				$('#v_accountholdername').val('0');
				$('#v_accountholdername_lbl').text('Not verified');
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