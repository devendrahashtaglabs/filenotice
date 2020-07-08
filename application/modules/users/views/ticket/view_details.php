<?php 
	$sessiondata = $this->session->userdata('users');
	$user_id 	 = $sessiondata['user_id'];
	$user_type 	 = $sessiondata['user_type'];
?>
<style>
.ticketmanagement {
	margin: 0 0 15px;
	float: left;
	width: 100%;
	padding: 0;
}
.form-group {
	margin-bottom: 0;
}
.ticketmanagement h5 {
	font-weight: normal;
	font-size: 14px;
	color: #333;
	margin: 0 0 0px;
}
.ticketmanagement p {
	font-size: 16px;
	margin: 0;
	color: #000;
	font-weight: 600;
}
.ticketstatus b,span.userdata {
    font-size: 12px;
}
.innerbgf {
	background: #f4f4ff;
	padding: 10px;
}
.btn-warning {
	background: #f3781e;
	color: #fff;
	border: 2px solid #f3781e;
}
.compunt {
	float: left;
	width: 75%;
	font-size: 11px;
	padding-left: 29px;
	font-weight: normal;
	position: relative;
	top: -14px;
}
.updatedby {
	width: 100%;
	float: left;
	line-height: 13px;
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
.titlepr {
	font-size: 18px;
	font-weight: 600;
	margin: 0;
	color: #263a7d;
}
/*.innerbgf .form-control {
	height: 30px;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
	background: #fff;
	border: 1px solid #ccc;
}
.innerbgf label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0;
    font-weight: 400;
    color: #333;
    font-size: 8px;
    line-height: 17px;
}
.innerbgf .form-group {
    margin-bottom: 8px;
}*/
#ticket_status {
	height: 30px;
}
textarea {
	line-height: 25px !important;
}
input[type="file"] {
	padding: 4px !important;
}
#tkt_status_btn, #reset-btn {
	margin-top: 0;
}
.dataTables_length{
	float: left;
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
table tr th {
    background: #494e53;
    color: #fff;
}
.table-responsive.customizetableres label {
    font-size: 14px;
    color: #333;
}
#TicketStatusForm {
	margin: 0;
}
.table-responsive.customizetableres {
	margin: 5px 0 0;
}
</style>
<div class="content-wrapper viewtiket">
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
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?>
							<div style="float:right">
								&nbsp;<a class="back-btn btn btn-warning white-icon" onclick="window.history.back();" style="float:right;" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>&nbsp;
								<?php 
									$ticketmap = $this->ticket_model->getMappedTicket($ticket->id);
									if(!empty($ticketmap)){
										if($user_type === 'consultant'){ 
								?>
									<a class="ticket-btn btn btn-danger white-icon" id="ticket-btn" style="float:right;" title="Change ticket status"><i class="fa fa-ticket"></i> Ticket Status</a> &nbsp;
								<?php } }  
									$agentMapData 	= $this->ticket_model->checkticketassigntoagent($ticket->id,$user_id);
									$ticketDetail 	= $this->ticket_model->get_ticket_data($ticket->id);
									if(!empty($ticketDetail)){
										if($ticketDetail->ticket_status != '10' && $ticketDetail->ticket_status != '20' && $ticketDetail->ticket_status != '90' && $ticketDetail->ticket_status != '91'){
								?>
									<a class="btn btn-danger white-icon" href="<?php echo base_url('/ticket/conversation/'.$ticket->id);?>" title="Chat"><i class="fa fa-comments readchat" aria-hidden="true"></i> Chat</a> &nbsp;
								<?php } }  ?>
									<?php 
										if($user_type == 'consultant' ){ 
											if (!empty($agentMapData)) {
												if($agentMapData->assign_agent_status == 20){
													if($ticketDetail->ticket_status != 90 && $ticketDetail->ticket_status != 91 && $ticketDetail->ticket_status != 92 && $ticketDetail->ticket_status != 93){
										?>
											<a class="btn btn-warning white-icon" href="<?php echo base_url('/ticket/assignagent/' . $ticket->id);?>" title="Agent Reassignment"><i class="fa fa-users" aria-hidden="true"></i> Agent Reassignment</a>
											<?php 
												}
											}
										}
										if (!empty($agentMapData)){
											if ($agentMapData->status == 1) {
												if($agentMapData->ticket_status != '90' && $agentMapData->ticket_status != '91' && $agentMapData->ticket_status != '92' && $agentMapData->ticket_status != '93'){
													$assignurls = ($agentMapData->assign_agent_status == '10')? base_url() . 'ticket/assignagent/'.$agentMapData->ticket_id: 'javascript:;';
													$assignTitle = ($agentMapData->assign_agent_status == '10')? 'Assign to Agent': 'Already Assign to Agent';
													$style = ($agentMapData->assign_agent_status == '10')?'':'color:red';
													$button = ($ticket->ticket_status =='10')?'btn-primary':'btn-danger';
												}else{
													$assignurls = ($ticket->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$ticket->id: 'javascript:;';
													$assignTitle = ($ticket->ticket_status == '90' || $ticket->ticket_status == '91' || $ticket->ticket_status == '92' || $ticket->ticket_status == '93')? 'Can not assign ticket': '';
													$style = ($ticket->ticket_status==='90' || $ticket->ticket_status == '91' || $ticket->ticket_status == '92' || $ticket->ticket_status == '93')?'color:red':''; 
													$button = ($ticket->ticket_status==='90' || $ticket->ticket_status == '91' || $ticket->ticket_status == '92' || $ticket->ticket_status == '93')?'btn-danger':'btn-primary';
												}
											?>
											<a class="btn <?php echo $button; ?> white-icon" href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php //echo $style; ?>"></i> Agent Assignment</a>&nbsp;

										<?php } } else { ?>  
											<a href="<?php echo base_url() . 'ticket/assignagent/'.$ticket->id; ?>" title="Assign To Agent"><i class="fa fa-user" aria-hidden="true"></i></a>&nbsp; 
									<?php } ?>
								<?php } ?>
								<input type="hidden" class="readstatus" value='1'>
								<input type="hidden" class="ticketid" value='<?php echo $ticket->id; ?>'>
								<?php if ($user_type =='customer'){ ?>
									<input type="hidden" class="user_ids" value='<?php echo '2'; ?>'>
								<?php }else { ?>
									<input type="hidden" class="user_ids" value='<?php echo '3'; ?>'>
								<?php } ?>
							</div>
						</h3>
                    </div>
                    <div class="card-body">
                    	<div class="innerbgf">
                        <div class="row">
                        <div class="col-6">
                            <div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>Category</h5>
									<p><?php  echo ($ticket->category_name)?$ticket->category_name:''; ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
							<div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>Subcategory</h5>
									<?php 
										$subcatname = '';
										if(!empty($ticket->subcategory_id)){
											$subcategorydata = $this->category_model->get_category_data($ticket->subcategory_id);
											$subcatname = $subcategorydata->name;
										}
									?>
									<p><?php  echo ($subcatname)?$subcatname:''; ?></p>
                                </div>
                            </div>
                          </div>
							<div class="col-4">
                                <div class="ticketmanagement ticketid">
									<h5>Ticket ID</h5>
									<p><?php  echo $ticket->ticket_id; ?></p>
                                </div>                           
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement ticketstatus">
									<h5>Ticket Status</h5>
									<p>
										<?php $statusRes= __getStatus($ticket->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?>
										<?php
											$ticketlogdata = $this->ticket_model->getthedata('ticket_id',$ticket->id,'nw_ticketstatusremarklog_tbl');
											if(!empty($ticketlogdata)){
											$lastlogdata 	= end($ticketlogdata);
											$userdetail 	= $this->user_model->getDataBykey('nw_user_tbl','id',$lastlogdata->user_id);
											$loguser_type 	= $userdetail->user_type; 
											$userdata 		= $this->user_model->getUserDetailsById($lastlogdata->user_id,$loguser_type);
											$userroledata 	= $this->user_model->getDataBykey('nw_role_tbl','id',$loguser_type);
											$loguser_name 	= $userdata->name;
										?>
											<span class="compunt"><span class="updatedby">Updated By :-<span class="userdata"><?php echo !empty($userroledata->role_name)?ucfirst($userroledata->role_name):'';echo ' - ';?><?php echo !empty($loguser_name)?$loguser_name:'';?></span></span>
											<span class="updatedby">Updated At :- </b> <span class="userdata"><?php echo !empty($lastlogdata->modified_at)?date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at)):'';?></span></span></span>
										<?php } ?>
									</p>
                                </div>
                            </div>
							 
                           <?php /* <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Status</h5>
									<p><?php  echo ($ticket->status=='0')?'Inactive':'Active'; ?></p>
                                </div>
                            </div> */
							?>
							<?php 
								$titleid 	= !empty($ticket->title)?$ticket->title:'';
								$titledata	= $this->ticket_model->getthedata('id',$titleid,'nw_prefix_tbl');
								$title 		= !empty($titledata)?$titledata[0]->title:'';
								$name 		= !empty($ticket->customername)?$ticket->customername:'';
								$sname 		= !empty($ticket->customersname)?$ticket->customersname:'';
							?>
						</div>
						<div class="row">
                            <div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>Title</h5>
										<p><?php echo $title; ?></p>
									</div>
								</div>
                           </div>
						   <div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>First Name</h5>
										<p><?php echo $name; ?></p>
									</div>
								</div>
                           </div>
                           <div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>Last Name</h5>
										<p><?php echo $sname; ?></p>
									</div>
								</div>
                           </div>
                        </div>
						<div class="row">  
                          <div class="col-6">
							<div class="form-group customtextre">
								<div class="ticketmanagement ticketid">
									<h5>Mobile Number</h5>
									<?php 
										$mobile    = isset($ticket->customer_mobile)?$ticket->customer_mobile:'';
									?>
									<p><?php  echo ($mobile)?$mobile:''; ?></p>
                                </div>
                            </div>
                           </div>
                           
                           <div class="col-6">
							<div class="form-group customtextre">
								<div class="ticketmanagement ticketid">
									<h5>Email</h5>
									<p>test@test.com</p>
                                </div>
                            </div>
                           </div>
                           <div class="col-6">
                            <div class="form-group customtextre">
								<div class="ticketmanagement ticketid">
									<h5>Address</h5>
									<?php 
										$address    = isset($ticket->customer_address)?$ticket->customer_address:'';
									?>
									<p><?php  echo ($address)?$address:''; ?></p>
                                </div>
                            </div>
                           </div>
                           <div class="col-6">
                            <div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>Pin code</h5>
									<?php 
										$pincode    = isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
									?>
									<p><?php  echo ($pincode)?$pincode:''; ?></p>
                                </div>
                            </div>
                           </div>
                             <div class="col-4">
                            <div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>Country</h5>
									<?php 
										$countryname    = '';
										$countryid      = isset($ticket->customer_country)?$ticket->customer_country:0;
										if(!empty($countryid)){
											$countryData    = $this->user_model->getCountryList($countryid);
											if(!empty($countryData)){
												$countryname    = $countryData->name;
											}
										}
									?>
									<p><?php  echo ($countryname)?$countryname:''; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>State</h5>
									<?php 
										$statename  = '';
										$stateid    = isset($ticket->customer_state)?$ticket->customer_state:0;
										if(!empty($stateid)){
											$stateData  = $this->user_model->getStateList($stateid);
											if(!empty($stateData)){
												$statename  = $stateData->name;
											}
										}
									?>
									<p><?php  echo ($statename)?$statename:''; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
								<div class="ticketmanagement ticketid">
									<h5>City</h5>
									<?php 
										$city   	= isset($ticket->customer_city)?$ticket->customer_city:'';
										$cityData 	= $this->user_model->getCityList($city,'');
									?>
									<p><?php  echo !empty($cityData)?$cityData->city_name:''; ?></p>
                                </div>
                            </div>
                           </div>
                           <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Description</h5>
									<p><?php  echo ($ticket->description)?$ticket->description:''; ?></p>
                                </div>
                            </div>
                      
                            
                            <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Document Upload</h5>
									<p>
									<?php 
										if(!empty($ticket->file)) {
											$files = json_decode($ticket->file);
											//$files = explode(',',$ticket->file);
											$filecount 	= count($files);
											$counter 	= 1;
											if(!empty($files)){
											foreach($files as $file){
									?>
										<a href="<?php echo base_url().'uploads/ticket/'.$file->file; ?>" target="_blank"><?php echo !empty($file->filename)?$file->filename:'casefile';?></a> <?php echo ($filecount > $counter)?',':''; ?>
									<?php $counter++; } ?> 
									<?php } } else { ?>
										<p>No files uploaded</p>    
									<?php } ?>
									</p>
                                </div>
                            </div>
                        </div>
						<?php /*if(!empty($ticket->json_form_data)){ ?>
                        <div class="row mt-5">
							<div class="col-12">
								<h5>Ticket Related Info</h5>
							</div>
                        </div>
						<div class="row">
							<?php 
								$json_form_data = json_decode($ticket->json_form_data);
							?>
							<div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>User Name</h5>
										<?php 
											$username   	= isset($json_form_data->username)?$json_form_data->username:'';
										?>
										<p><?php  echo !empty($username)?$username:''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>User Email</h5>
										<?php 
											$useremail   	= isset($json_form_data->useremail)?$json_form_data->useremail:'';
										?>
										<p><?php  echo !empty($useremail)?$useremail:''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>User Mobile</h5>
										<?php 
											$usermobile   	= isset($json_form_data->usermobile)?$json_form_data->usermobile:'';
										?>
										<p><?php  echo !empty($usermobile)?$usermobile:''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>Gender</h5>
										<?php 
											$usergender   	= isset($json_form_data->usergender)?$json_form_data->usergender:'';
										?>
										<p><?php  echo !empty($usergender)?ucfirst($usergender):''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>User DOB</h5>
										<?php 
											$userdob   	= isset($json_form_data->userdob)?$json_form_data->userdob:'';
											$newdob		= date('d-m-Y',strtotime($userdob));
										?>
										<p><?php  echo !empty($newdob)?$newdob:''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>User Feedback</h5>
										<?php 
											$feedback  = isset($json_form_data->your_feedback)?$json_form_data->your_feedback:'';
										?>
										<p><?php  echo !empty($feedback)?$feedback:''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>Native Language</h5>
										<?php 
											$language  = isset($json_form_data->language)?$json_form_data->language:'';
										?>
										<p><?php  echo !empty($language)?ucfirst($language):''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>Ordered Icecream Flavor</h5>
										<?php 
											$icecream  = isset($json_form_data->icecream)?$json_form_data->icecream:'';
										?>
										<p><?php  echo !empty($icecream)?ucfirst($icecream):''; ?></p>
									</div>
								</div>
							 </div>
							 <div class="col-4">
								<div class="form-group">
									<div class="ticketmanagement ticketid">
										<h5>Custom Profile Image</h5>
										<?php
											$profilename = $json_form_data->profilename;
											if(!empty($profilename)){
										?>
											<img src="<?php echo base_url().'uploads/ticket/'.$profilename; ?>" class="" width="50" height="50"/>
										<?php }else{ ?>
											<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" class="" width="50" height="50"/>
										<?php } ?>
									</div>
								</div>
							 </div>
                        </div>
						<?php } */ ?>
                        
						<?php
							if($user_type === 'consultant'){ 
							echo form_open_multipart(base_url().'ticket/changeticketstatwithremark/'.$ticket->id, array('class' => 'ticket-status-from', 'id' => 'TicketStatusForm'));
						?>
						<div class="ticket_remark floating-laebls" style="display:none;">
							<div class="row mt-5">
								<div class="form-group col-12">
									<h5 class="titlepr">Update Ticket Status</h5>
								</div>
							</div>
							<div class="row mt-3">
								<div class="col-4">
									<div class="form-group inputBox focus">
										<?php
											$whereindata 		= array(21,22,92,93);
											$ticketstatusdata 	= $this->ticket_model->getticketremarkstatus($whereindata);
											echo form_label('Ticket Status *', 'ticket_status');
											$option = array('' => 'Select Status');
											if(!empty($ticketstatusdata)){
												foreach($ticketstatusdata as $ticketstatus){
													$option[$ticketstatus->status_code] = $ticketstatus->status;
												}                    
											}
											echo form_dropdown('ticket_status', $option, set_value('ticket_status'), $extra = 'class= "form-control input" id="ticket_status"');
											echo '<div class="error-msg">' . form_error('ticket_status') . '</div>';
										?>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group inputBox">
										<?php
											echo form_label('Remark', 'consultant_remark');
											echo form_textarea(array('name' => 'consultant_remark', 'class' => 'form-control input', 'value' => set_value('consultant_remark'), 'id' => "consultant_remark", 'cols' => '10', 'rows' => '3','onkeyup'=>'countChar(this,255)'));
											echo '<div class="remain-char charcount text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
										?>
										<span class="text-danger" style="font-size:8px; color: #a94442 !important;;">(Enter upto 255 character.)</span>
										<?php echo '<div class="error-msg">' . form_error('consultant_remark') . '</div>'; ?>
									</div>
								</div>
								<div class="col-4">
									<div class="form-group inputBox focus">
										<?php echo form_label('Upload File', 'remark_file'); ?>
										<input type="file" id="remark_file" class="form-control remarkfile input" name="remark_file" />
										<span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 1MB)</span>
									</div>
								</div>
								<div class="form-group col-12 pull-right text-right">
									<?php
										echo form_submit(array('name'=>'ticketstatusupdate',"class" => "btn btn-primary", "id" => "tkt_status_btn", "value" => "Submit"));
										echo ' '. form_reset(array('class' => 'btn btn-default','id'=>'reset-btn','value'=>"Reset"));
										
									?>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
						<div class="row ticket_remark" style="display:none;">
							<div class="col-12">
								<h5 class="titlepr">Ticket Status Log</h5>
							</div>
							<div class="col-12">
								<div class="table-responsive customizetableres">
									<table id="ticket_status_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Ticket Status</th>
												<th>Updated By</th>
												<th style="display:none;">Updated By(Name)</th>
												<th style="display:none;">Updated By(Email)</th>
												<th>Remark</th>
												<th>Uploaded File</th>
												<th style="display:none;">Uploaded File</th>
												<th>Updated At</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if(!empty($ticketlogdata)){
												$counter = 1;
												foreach($ticketlogdata as $ticketlog){
													$userdetail = $this->user_model->getDataBykey('nw_user_tbl','id',$ticketlog->user_id);
													$loguser_type 	= $userdetail->user_type; 
													$userdata 		= $this->user_model->getUserDetailsById($ticketlog->user_id,$loguser_type);
													if($loguser_type != '2'){
														if($loguser_type == '3' || $userdata->consultant_id == $user_id){
											?>
												<tr>
													<td><?php echo $counter; ?></td>
													<td>
													<?php 
														$statusRes = __getStatus($ticketlog->ticket_status, 'float-left');
														echo ucfirst($statusRes['status']);
													?>
													</td>
													<?php 
														$loguser_email 	= $userdetail->email; 
														$loguser_name 	= $userdata->name;
													?>
													<td><?php echo $loguser_name .'<br/>'. $loguser_email;?></td>
													<td style="display:none;"><?php echo $loguser_name;?></td>
													<td style="display:none;"><?php echo $loguser_email;?></td>
													<td><?php echo $ticketlog->user_remark; ?></td>
													<td><?php if(!empty($ticketlog->user_file)){ ?> <a href="<?php echo base_url().'uploads/ticket/ticketremarkfiles/'.$ticketlog->user_file; ?>" target="_blank">View File</a><?php }else{ ?>No file attached <?php } ?></td>
													<td style="display:none;"><?php echo isset($ticketlog->user_file)?$ticketlog->user_file:''; ?></td>
													<td><?php echo date('d-m-Y H:i:s',strtotime($ticketlog->modified_at)); ?></td>
												</tr>
											<?php 
													} $counter++; } }
												}												
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php } ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function(){
	$('#ticket-btn').click(function(event){
		//event.preventDefault();
		$('.ticket_remark').toggle();
		$(window).scrollTop( $(".ticket_remark").offset().top,'100' );
	});
	$('#remark_file').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' || fileExt === 'pdf' || fileExt === 'doc' || fileExt === 'docx' || fileExt === 'xls' || fileExt === 'xlsx'){
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
});
</script>




