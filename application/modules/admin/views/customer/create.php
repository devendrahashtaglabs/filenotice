<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
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
                        <h3 class="card-title">
                            <?php echo $page_title; ?>
                        </h3>
                    </div>
                    <?php
						echo form_open_multipart($pageUrl, array('id' => 'CustomerForm'));
                    ?>
                    <div class="card-body floating-laebls">
						<?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
							$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
						?>
                        <div class="row">
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Title *', 'title');
										$allprefix = [];
										foreach($prefixdata as $prefix){
											$allprefix[$prefix->id] = $prefix->title;
										}
										echo form_dropdown('title', $allprefix, $selected = set_value('title'), $extra = 'class= "form-control input" id="title"');
										echo '<div id="title_error_msg" class="custom-error"></div>';
										echo '<div class="error-msg">' . form_error('title') . '</div>';
									?>
								</div>
							</div>
                            <div class="col-6">
                                <div class="form-group inputBox">
                                <?php
									echo form_label('First Name*', 'user_name');
									echo form_input(array('name' => 'user_name', 'class' => 'form-control input', 'value' => set_value('user_name'), 'id' => "user_name", 'onkeypress'=> 'return alpha(event)'));
                                    echo '<div id="name_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                ?>
                                </div>
                            </div>
							<div class="col-6">
                                <div class="form-group inputBox">
                                <?php
									echo form_label('Last Name*', 'sname');
									echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname'), 'id' => "sname", 'onkeypress'=> 'return alpha(event)'));
                                    echo '<div id="sname_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_name') . '</div>';
                                ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group inputBox">
                                <?php
                                    echo form_label('Email address <span class="required">*</span>', 'user_email');
                                    echo form_input(array('name' => 'user_email', 'class' => 'form-control input', 'value' => set_value('user_email'), 'id' => "user_email",));
									echo '<div id="email_error_msg" class="custom-error"></div>';
                                    echo '<div class="error-msg">' . form_error('user_email') . '</div>';
                                ?>
                                </div>
                            </div>
                        </div>
							<div class="row">
                                <div class="col-6">
                                    <div class="form-group inputBox ">
                                        <?php
                                        echo form_label('Mobile Number <span class="required">*</span>', 'user_mobile');
                                        echo form_input(array('name' => 'user_mobile', 'class' => 'form-control input','id' => 'user_mobile', 'value' => set_value('user_mobile'), 'maxlength' => '10',));
										echo '<div id="mobile_error_msg" class="custom-error"></div>';
                                        echo '<div class="error-msg">' . form_error('user_mobile') . '</div>';
                                        ?>
                                    </div>   
                                </div>
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
        									echo form_label('Date Of Birth', 'user_dob');
        									echo form_input(array('name' => 'user_dob', 'class' => 'form-control datepickerdob input', 'value' => set_value('user_dob'), 'id' => 'dob', 'readonly'=>'readonly'));
											echo '<div id="dob_error_msg" class="custom-error"></div>';
        									echo '<div class="error-msg">' . form_error('user_dob') . '</div>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
                                        echo form_label('Gender', 'user_gender');
                                        echo form_dropdown('user_gender', $options = array(
                                            '1' => 'Male',
                                            '2' => 'Female',
                                            '3' => 'Other'
                                        ), $selected = set_value('user_gender'), $extra = 'class= "form-control input" id="user_gender"');
                                        echo '<div class="error-msg">' . form_error('user_gender') . '</div>';
                                        ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
                                        echo form_label('Status', 'user_status');
                                        echo form_dropdown('user_status', $options = array(
                                            '1' => 'Active',
                                            '0' => 'Inactive'
                                        ), $selected = set_value('user_status'),$extra = 'class= "form-control input" id="user_status"');
                                        echo '<div class="error-msg">' . form_error('user_status') . '</div>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
        									echo form_label('Country <span class="required">*</span>', 'user_country');
        									$option = array('' => 'Select Country');
        									foreach ($countryList as $key => $value) {
        										$option[$value->id] = ucfirst($value->name);
        									}
        									echo form_dropdown('user_country',$option,$selected=set_value('user_country',DEFAULT_COUNTRY),$extra='class="form-control select-state input" data-section="user_state" data-stateid="'.DEFAULT_STATE.'" id="user_country"');
											echo '<div id="country_error_msg" class="custom-error"></div>';
        									echo '<div class="error-msg">' . form_error('user_country') . '</div>';
                                        ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
        									echo form_label('State <span class="required">*</span>', 'user_state');
        									$option = [];
        									$option = array('' => 'Select State');
        									echo form_dropdown('user_state', $option, $selected = set_value('user_state'), $extra = 'class= "form-control input" id="user_state"');
											echo '<div id="state_error_msg" class="custom-error"></div>';
        									echo '<div class="error-msg">' . form_error('user_state') . '</div>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group inputBox focus">
                                        <?php
        									$cityquery = $this->user_model->getCityList('',DEFAULT_STATE);
        									echo form_label('City <span class="required">*</span>', 'customer_city');
        									$allcity      	= [];
        									$allcity['']  	= 'Select City';
        									if(!empty($cityquery)){
        										foreach($cityquery as $singleCityList){
        											$allcity[$singleCityList->city_id] = $singleCityList->city_name;
        										}                    
        									}                    
        									echo form_dropdown('customer_city', $allcity, set_value('customer_city'), 'class="form-control input" id="customer_city"'); 
											echo '<div id="city_error_msg" class="custom-error"></div>';
        									echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
        									
        									/* echo form_label('City', 'customer_city');
        									echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city'), 'id' => 'customer_city', 'placeholder' => 'Enter City','onkeypress'=> 'return alpha(event)'));
        									echo '<div class="error-msg">' . form_error('customer_city') . '</div>'; */
                                        ?>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group inputBox">
                                        <?php
											echo form_label('Pin Code', 'pin_code');
											echo form_input(array('name' => 'pin_code', 'class' => 'form-control input', 'maxlength' => '6', 'value' => set_value('pin_code'),));
											echo '<div class="error-msg">' . form_error('pin_code') . '</div>';
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
										?>
                                    </div>
                                </div>
                                <div class="col-6">                            
                                    <div class="form-group inputBox">
                                        <?php
                                        echo form_label('Address', 'user_address');
                                        $data = array(
                                            'name' => 'user_address',
                                            'class' => 'form-control input',
                                            'value' => set_value('user_address'),
                                            'cols' => '4',
                                            'rows' => '2',
                                           
                                        );
                                        echo form_textarea($data);
                                        echo '<div class="error-msg">' . form_error('user_address') . '</div>';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
									<div class="form-group">
										<?php
											echo form_submit(array("class" => "btn btn-primary", "id" => "creatre_user_btn", "value" => "Submit"));
											echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list') . '" class="btn btn-default">Cancel</a>';
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
				$("#customer_city").html(data);
			}
		});
	});
</script>

