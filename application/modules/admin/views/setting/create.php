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
                        <h3 class="card-title">
                            <?php echo $page_title; ?>
                        </h3>
                    </div>
                    <?php
						echo form_open_multipart($pageUrl);
                    ?>
                    <div class="card-body settingsgenr floating-laebls">
						<?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
                        <?php if ($this->session->flashdata('flash_msg') != "") { ?>
                            <div class="alert alert-success" id="alert-success-div">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('flash_msg'); ?>
                                <button type="button" class="close" aria-label="Close" id="msg-close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-6">
								<?php 
									$site_title = _settingBykey('site_title');
								?>
        						<div class="form-group inputBox <?php echo !empty($site_title)?'focus':''; ?>">
									<?php
										echo form_label('Site Title', 'site_title');
										echo form_input(array(
												'type' => 'text',
												'name' => 'site_title',
												'value' => set_value('site_title',$site_title),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('site_title').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$site_email = _settingBykey('site_email');
								?>
        						<div class="form-group inputBox <?php echo !empty($site_email)?'focus':''; ?>">
									<?php
										echo form_label('Admin Email', 'site_email');
										echo form_input(array(
												'type' 	=> 'text',
												'name' 	=> 'site_email',
												'value' => set_value('site_email', $site_email),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('site_email').'</div>';
									?>
								</div>
                            </div>
                         </div>
						 <div class="row">
                            <div class="col-6">
								<?php 
									$site_phone = _settingBykey('site_phone');
								?>
        						<div class="form-group inputBox <?php echo !empty($site_phone)?'focus':''; ?>">
									<?php
										echo form_label('Contact Number', 'site_phone');
										echo form_input(array(
											'type' 	=> 'text',
											'name' 	=> 'site_phone',
											'value' => set_value('site_phone', $site_phone),
											'class' => 'form-control input'
										));
										echo '<div class="error-msg">'.form_error('site_phone').'</div>';
									?>
								</div>   
                            </div>   
                            <div class="col-6">
								<?php 
									$site_copyright = _settingBykey('site_copyright');
								?>
        						<div class="form-group inputBox <?php echo !empty($site_copyright)?'focus':''; ?>">
									<?php
										echo form_label('Copyright', 'site_copyright');
										echo form_input(array(
												'type' => 'text',
												'name' => 'site_copyright',
												'value' => set_value('site_copyright', $site_copyright),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('site_copyright').'</div>';
									?>
								</div>
                            </div>
                         </div>
						 <div class="row">
                            <div class="col-6">
								<?php 
									$site_mode = _settingBykey('site_mode');
								?>
        						<div class="form-group inputBox <?php echo !empty($site_mode)?'focus':''; ?>">
									<?php echo form_label('Site Mode', 'site_mode');?>
									<select class="form-control input" name="site_mode">
										<option value="developement" <?php if(_settingBykey('site_mode')=='developement'){echo 'selected="selected"';}?>>Developement</option>
										<option value="production" <?php if(_settingBykey('site_mode')=='production'){echo 'selected="selected"';}?>>Production</option>
									</select>
									<?php echo '<div class="error-msg">'.form_error('site_mode').'</div>';?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$paypal_mode = _settingBykey('paypal_mode');
								?>
        						<div class="form-group inputBox <?php echo !empty($paypal_mode)?'focus':''; ?>">
									<?php
									echo form_label('PayPal Mode', 'paypal_mode');
									?>
									<select class="form-control input" name="paypal_mode">
										<option value="off" <?php if(_settingBykey('paypal_mode')=='off'){echo 'selected="selected"';}?>>sandbox</option>
										<option value="on" <?php if(_settingBykey('paypal_mode')=='on'){echo 'selected="selected"';}?>>Live</option>
									</select>
									<?php echo '<div class="error-msg">'.form_error('paypal_mode').'</div>';?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$paypal_user = _settingBykey('paypal_user');
								?>
        						<div class="form-group inputBox <?php echo !empty($paypal_user)?'focus':''; ?>">
									<?php
										echo form_label('PayPal User', 'paypal_user');
										echo form_input(array(
												'type' => 'text',
												'name' => 'paypal_user',
												'value' => set_value('paypal_user',_settingBykey('paypal_user')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('paypal_user').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$paypal_password = _settingBykey('paypal_password');
								?>
        						<div class="form-group inputBox <?php echo !empty($paypal_password)?'focus':''; ?>">
									<?php
										echo form_label('PayPal Password', 'paypal_password');
										echo form_input(array(
												'type' => 'text',
												'name' => 'paypal_password',
												'value' => set_value('paypal_password', _settingBykey('paypal_password')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('paypal_password').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$paypal_secretkey = _settingBykey('paypal_secretkey');
								?>
        						<div class="form-group inputBox <?php echo !empty($paypal_secretkey)?'focus':''; ?>">
									<?php
										echo form_label('PayPal Secret', 'paypal_secretkey');
										echo form_input(array(
												'type' => 'text',
												'name' => 'paypal_secretkey',
												'value' => set_value('paypal_secretkey', _settingBykey('paypal_secretkey')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('paypal_secretkey').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$paytm_id = _settingBykey('paytm_id');
								?>
        						<div class="form-group inputBox <?php echo !empty($paytm_id)?'focus':''; ?>">
									<?php
										echo form_label('Paytm Id', 'paytm_id');
										echo form_input(array(
												'type' => 'text',
												'name' => 'paytm_id',
												'value' => set_value('paytm_id',_settingBykey('paytm_id')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('paytm_id').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                             <div class="col-6">
								<?php 
									$paytm_secret = _settingBykey('paytm_secret');
								?>
        						<div class="form-group inputBox <?php echo !empty($paytm_secret)?'focus':''; ?>">
									<?php
										echo form_label('Paytm Secret', 'paytm_secret');
										echo form_input(array(
												'type' => 'text',
												'name' => 'paytm_secret',
												'value' => set_value('paytm_secret',_settingBykey('paytm_secret')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('paytm_secret').'</div>';
									?>
								</div>                            
                            </div>                            
                            <div class="col-6">
								<?php 
									$payumoney_key = _settingBykey('payumoney_key');
								?>
        						<div class="form-group inputBox <?php echo !empty($payumoney_key)?'focus':''; ?>">
									<?php
										echo form_label('Payumoney Key', 'payumoney_key');
										echo form_input(array(
												'type' => 'text',
												'name' => 'payumoney_key',
												'value' => set_value('payumoney_key',_settingBykey('payumoney_key')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('payumoney_key').'</div>';
									?>
								</div>
                            </div>
                        </div>
						<div class="row">
                             <div class="col-6">
								<?php 
									$payumoney_salt = _settingBykey('payumoney_salt');
								?>
        						<div class="form-group inputBox <?php echo !empty($payumoney_salt)?'focus':''; ?>">
									<?php
										echo form_label('Payumoney Salt', 'payumoney_salt');
										echo form_input(array(
												'type' => 'text',
												'name' => 'payumoney_salt',
												'value' => set_value('payumoney_salt',_settingBykey('payumoney_salt')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('payumoney_salt').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$meta_keywords = _settingBykey('meta_keywords');
								?>
        						<div class="form-group inputBox <?php echo !empty($meta_keywords)?'focus':''; ?>">
									<?php
										echo form_label('Meta Keywords', 'meta_keywords');
										echo form_input(array(
												'type' => 'text',
												'name' => 'meta_keywords',
												'value' => set_value('meta_keywords',_settingBykey('meta_keywords')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('meta_keywords').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$min_ticket_amt = _settingBykey('min_ticket_amt');
								?>
        						<div class="form-group inputBox <?php echo !empty($min_ticket_amt)?'focus':''; ?>">
									<?php
										echo form_label('Minimum Ticket Amount', 'min_ticket_amt');
										echo form_input(array(
												'type' => 'text',
												'name' => 'min_ticket_amt',
												'value' => set_value('min_ticket_amt',_settingBykey('min_ticket_amt')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('min_ticket_amt').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$sms_gateway_user = _settingBykey('sms_gateway_user');
								?>
        						<div class="form-group inputBox <?php echo !empty($sms_gateway_user)?'focus':''; ?>">
									<?php
										echo form_label('SMS Gateway User', 'sms_gateway_user');
										echo form_input(array(
												'type' => 'text',
												'name' => 'sms_gateway_user',
												'value' => set_value('sms_gateway_user',_settingBykey('sms_gateway_user')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('sms_gateway_user').'</div>';
									?>
								</div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$sms_gateway_password = _settingBykey('sms_gateway_password');
								?>
        						<div class="form-group inputBox <?php echo !empty($sms_gateway_password)?'focus':''; ?>">
									<?php
									echo form_label('SMS Gateway Password', 'sms_gateway_password');
									echo form_input(array(
											'type' => 'text',
											'name' => 'sms_gateway_password',
											'value' => set_value('sms_gateway_password',_settingBykey('sms_gateway_password')),
											'class' => 'form-control input',
										)
									);
									echo '<div class="error-msg">'.form_error('sms_gateway_password').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$gst_rate = _settingBykey('gst_rate');
								?>
        						<div class="form-group inputBox <?php echo !empty($gst_rate)?'focus':''; ?>">
									<?php
									echo form_label('GST Rate', 'gst_rate');
									echo form_input(array(
											'type' => 'text',
											'name' => 'gst_rate',
											'value' => set_value('gst_rate',_settingBykey('gst_rate')),
											'class' => 'form-control input'
										)
									);
									echo '<div class="error-msg">'.form_error('gst_rate').'</div>';
									?>
								</div>
                            </div>
                        </div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$tds = _settingBykey('tds');
								?>
        						<div class="form-group inputBox <?php echo !empty($tds)?'focus':''; ?>">
									<?php
										echo form_label('TDS', 'tds');
										echo form_input(array(
												'type' => 'text',
												'name' => 'tds',
												'value' => set_value('tds',_settingBykey('tds')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('tds').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$currency = _settingBykey('currency');
								?>
        						<div class="form-group inputBox <?php echo !empty($currency)?'focus':''; ?>">
									<?php
										echo form_label('Currency', 'currency');
										echo form_input(array(
												'type' => 'text',
												'name' => 'currency',
												'value' => set_value('currency',_settingBykey('currency')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('currency').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$time_zone = _settingBykey('time_zone');
								?>
        						<div class="form-group inputBox <?php echo !empty($time_zone)?'focus':''; ?>">
									<?php
										echo form_label('Time-Zone', 'time_zone');
										echo form_input(array(
												'type' => 'text',
												'name' => 'time_zone',
												'value' => set_value('time_zone',_settingBykey('time_zone')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">'.form_error('time_zone').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$gstn = _settingBykey('gstn');
								?>
        						<div class="form-group inputBox <?php echo !empty($gstn)?'focus':''; ?>">
									<?php
										echo form_label('GSTN', 'gstn');
										echo form_input(array(
												'type' => 'text',
												'name' => 'gstn',
												'value' => set_value('gstn',_settingBykey('gstn')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('gstn').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$google_map_api_key = _settingBykey('google_map_api_key');
								?>
        						<div class="form-group inputBox <?php echo !empty($google_map_api_key)?'focus':''; ?>">
									<?php
										echo form_label('Google Map Api Key', 'google_map_api_key');
										echo form_input(array(
												'type' => 'text',
												'name' => 'google_map_api_key',
												'value' => set_value('google_map_api_key',_settingBykey('google_map_api_key')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('google_map_api_key').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$smtp_mode = _settingBykey('smtp_mode');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_mode)?'focus':''; ?>">
									<?php echo form_label('SMTP Mode', 'smtp_mode'); ?>
									<select class="form-control input" name="smtp_mode">
										<option value="sandbox" <?php if(_settingBykey('smtp_mode')=='sandbox'){echo 'selected="selected"';}?>>sandbox</option>
										<option value="live" <?php if(_settingBykey('smtp_mode')=='live'){echo 'selected="selected"';}?>>Live</option>
									</select>
									<?php echo '<div class="error-msg">'.form_error('smtp_mode').'</div>';?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$smtp_title = _settingBykey('smtp_title');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_title)?'focus':''; ?>">
									<?php
										echo form_label('SMTP Title', 'smtp_title');
										echo form_input(array(
												'type' => 'text',
												'name' => 'smtp_title',
												'value' => set_value('smtp_title', _settingBykey('smtp_title')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('smtp_title').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$smtp_user = _settingBykey('smtp_user');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_user)?'focus':''; ?>">
									<?php
										echo form_label('SMTP Email', 'smtp_user');
										echo form_input(array(
												'type' => 'text',
												'name' => 'smtp_user',
												'value' => set_value('smtp_user', _settingBykey('smtp_user')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('smtp_user').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$smtp_password = _settingBykey('smtp_password');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_password)?'focus':''; ?>">
									<?php
										echo form_label('SMTP Password', 'smtp_password');
										echo form_input(array(
												'type' => 'password',
												'name' => 'smtp_password',
												'value' => set_value('smtp_password', _settingBykey('smtp_password')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('smtp_password').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$smtp_host = _settingBykey('smtp_host');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_host)?'focus':''; ?>">
									<?php
										echo form_label('SMTP Host', 'smtp_host');
										echo form_input(array(
												'type' => 'text',
												'name' => 'smtp_host',
												'value' => set_value('smtp_host', _settingBykey('smtp_host')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('smtp_host').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$smtp_port = _settingBykey('smtp_port');
								?>
        						<div class="form-group inputBox <?php echo !empty($smtp_port)?'focus':''; ?>">
									<?php
										echo form_label('SMTP Port', 'smtp_port');
										echo form_input(array(
												'type' => 'text',
												'name' => 'smtp_port',
												'value' => set_value('smtp_port', _settingBykey('smtp_port')),
												'class' => 'form-control input'
											)
										);
										echo '<div class="error-msg">'.form_error('smtp_port').'</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<?php 
									$date_format = _settingBykey('date_format');
								?>
        						<div class="form-group inputBox <?php echo !empty($date_format)?'focus':''; ?>">
									<?php echo form_label('Date Format', 'date_format');?>
									<select class="form-control input" name="date_format">
										<option value="F j, Y" <?php if(_settingBykey('date_format')=='F j, Y'){echo 'checked="checked"';}?>><?php echo date('F j, Y');?></option>
										<option value="d/m/Y" <?php if(_settingBykey('date_format')=='d/m/Y'){echo 'checked="checked"';}?>><?php echo date('d/m/Y');?></option>
										<option value="m/d/Y" <?php if(_settingBykey('date_format')=='m/d/Y'){echo 'checked="checked"';}?>><?php echo date('m/d/Y');?></option>
									</select>
									<?php echo '<div class="error-msg">'.form_error('date_format').'</div>';?>
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<?php 
									$time_format = _settingBykey('time_format');
								?>
        						<div class="form-group inputBox <?php echo !empty($time_format)?'focus':''; ?>">
									<?php echo form_label('Time Format', 'time_format');?>
									<select class="form-control input" name="time_format">
										<option value="h:i a" <?php if(_settingBykey('time_format')=='h:i a'){echo 'checked="checked"';}?>><?php echo date('h:i a');?></option>
										<option value="h:i A" <?php if(_settingBykey('time_format')=='h:i A'){echo 'checked="checked"';}?>><?php echo date('h:i A');?></option>
										<option value="H:i" <?php if(_settingBykey('time_format')=='H:i'){echo 'checked="checked"';}?>><?php echo date('H:i');?></option>
									</select>
									<?php echo '<div class="error-msg">'.form_error('time_format').'</div>';?>
								</div>
                            </div>
							<div class="col-6">
								<?php $logo = _settingBykey('logo'); ?>
        						<div class="form-group inputBox <?php echo !empty($logo)?'focus':''; ?>">
									<?php echo form_label('Logo', 'logo'); ?>
									<input type="file" name="logo" class="form-control input" />
									<?php echo '<div class="error-msg">' . form_error('logo') . '</div>'; ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<?php $site_address = _settingBykey('site_address'); ?>
        						<div class="form-group inputBox <?php echo !empty($site_address)?'focus':''; ?>">
									<?php
										echo form_label('Address', 'site_address');
										echo form_textarea(array(
											'name'        => 'site_address',
											'value'       => set_value('site_address', _settingBykey('site_address')),
											'class'       => 'form-control input',
											'rows'        => '1',
										));
										echo '<div class="error-msg">'.form_error('site_address').'</div>';
									?>
								</div>
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
								<?php $gr_sitekey = _settingBykey('gr_sitekey'); ?>
        						<div class="form-group inputBox <?php echo !empty($gr_sitekey)?'focus':''; ?>">
									<?php 
										echo form_label('Google recaptcha site key', 'gr_sitekey');
										echo form_input(array(
												'type' 	=> 'text',
												'name' 	=> 'gr_sitekey',
												'value' => set_value('gr_sitekey', _settingBykey('gr_sitekey')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">' . form_error('gr_sitekey') . '</div>'; 
									?>
								</div>
                            </div>
							<div class="col-6">
								<?php $gr_secretkey = _settingBykey('gr_secretkey'); ?>
        						<div class="form-group inputBox <?php echo !empty($gr_secretkey)?'focus':''; ?>">
									<?php
										echo form_label('Google recaptcha secret key', 'gr_secretkey');
										echo form_input(array(
												'type' => 'text',
												'name' => 'gr_secretkey',
												'value' => set_value('gr_secretkey', _settingBykey('gr_secretkey')),
												'class' => 'form-control input',
											)
										);
										echo '<div class="error-msg">' . form_error('gr_secretkey') . '</div>'; 
									?>
								</div>
                            </div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group inputBox focus no-margin">
								<?php echo form_label('Home Page Banner', 'homepage_banner'); ?>
								</div>
							</div>
						</div>
							<div class="row bannerfilesex">
							<div class="col-12">
								<?php 
									$oldfilejson = _settingBykey('bannerfilename');
									$bannerarray = json_decode($oldfilejson);
								?>
								<div class="stuffs_to_clone">
									<?php 
										if(!empty($bannerarray)){
											foreach($bannerarray as $banner){
									?>
										<div class="stuff multiplefilesuplaod">
											<div class="form-group inputBox focus">
												<div class="row">
													<div class="col-md-4">
														<input type="text" class="form-control input bannername" name="bannername[]" placeholder="Banner Name" id="bannername" value="<?php echo $banner->bannername; ?>"/>
													</div>
													<div class="col-md-4">
														<input type="text" class="form-control input bannerlink" name="bannerlink[]" placeholder="Banner Link" id="bannerlink" value="<?php echo $banner->bannerlink; ?>"/>
													</div>
													<div class="col-md-4 havefiletouplod">
														<input type="file" id="image" class="form-control input casefile" name="image[]" />
												<div class="updateimgd"><img src="<?php echo base_url().'uploads/frontend/banner/'.$banner->banner; ?>" class="" width="" height="" /></div>
												<div class="del enabled"></div>
													</div>
												</div>
												
												
												
											</div>
										</div>
									<?php } }else{ ?>
										<div class="stuff ">
											<div class="form-group inputBox focus">
												<input type="text" class="form-control input bannername" name="bannername[]" placeholder="Banner Name" id="bannername" />
												<input type="text" class="form-control inputbannerlink" name="bannerlink[]" placeholder="Banner Link" id="bannerlink" />
												<div class="updateimgd"><input type="file" id="image" class="form-control inputcasefile" name="image[]" />
												<div class="del disabled hidden"></div></div>
											</div>
										</div>
									<?php } ?>
									<div class="clone mt-2" title="Add more files">Add more files</div>
									<div id="upload_prev" style="display:none;"></div>
								</div>
								<!--<input type="file" name="image[]" id="image" class="form-control" size="20" multiple required />-->
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif|jpg|png|jpeg /Max. upload size 2MB)</span></label>
							</div>
						</div>
                        
                        <div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class"=>"btn btn-primary", "id"=>"creatre_user_btn", "value"=>"Submit"));
										echo '&nbsp;&nbsp;<a href="'.base_url($this->session->userdata('user_type').'/admin/dashboard').'" class="btn btn-default">Cancel</a>';
									?>
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
	$(".clone").click(function() {
		var
		$self = $(this),
			$element_to_clone = $self.prev(),
			$wrapper_parent_element = $self.parent(),
			$new_element = $element_to_clone.clone().find("input:text,input:file").val("").end();

		$new_element.find('.del').removeClass('hidden disabled').addClass('enabled');
		$new_element.find('img').remove();
		//$new_element.find('input:file').show();

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
</script>