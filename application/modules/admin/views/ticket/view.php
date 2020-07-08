<style>
.ticketmanagement {
	margin: 0 0 15px;
	float: left;
	width: 100%;
	background: #eee;
	border-radius: 4px;
	padding: 10px 15px;
	min-height: 68px;
}
.ticketmanagement h5 {
    font-weight: 600;
    font-size: 16px;
    color: #696969;
    margin: 0 0 5px;
}
.ticketmanagement p {
    font-size: 16px;
    margin: 0;
}
.ticketstatus b,span.userdata {
    font-size: 12px;
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
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?>
							<a class="back-btn btn btn-info white-icon" onclick="window.history.back();" style="float:right;" title="Back"><i class="fa fa-arrow-left"></i>   Back</a>
							<div style="float:right;">
							<?php
								if ($ticket->status == 1) {
									if($ticket->ticket_status != '90' && $ticket->ticket_status != '91'){
										$assignurls = ($ticket->ticket_status == '10')? base_url() . 'admin/ticket/assign/'.$ticket->id: 'javascript:;';
										$assignTitle = ($ticket->ticket_status =='10')? 'Assign User': 'Already Assign';
										$style = ($ticket->ticket_status =='10')?'':'color:red';
										$button = ($ticket->ticket_status =='10')?'btn-primary':'btn-danger';
									}else{
										$assignurls = ($ticket->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$ticket->id: 'javascript:;';
										$assignTitle = ($ticket->ticket_status == '90' || $ticket->ticket_status == '91')? 'Ticket Completed': '';
										$style = ($ticket->ticket_status==='90' || $ticket->ticket_status == '91')?'color:red':'';
										$button = ($ticket->ticket_status==='90' || $ticket->ticket_status == '91')?'btn-danger':'btn-primary';
									}
									if($ticket->ticket_status != '90' && $ticket->ticket_status != '91'){
								?>
								&nbsp; <a class="btn <?php echo $button; ?> white-icon" href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php //echo $style; ?>"></i> Assign Consultant</a>&nbsp;
							<?php }
								}
								if($ticket->ticket_status == '20' || $ticket->ticket_status == '21' || $ticket->ticket_status == '22' || $ticket->ticket_status == '93'){ ?>
								<a class="btn btn-warning white-icon" href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/assign/' . $ticket->id);?>" title="Consultant Reassignment"><i class="fa fa-users" aria-hidden="true"></i> Consultant Reassignment</a>
							<?php }
								if($ticket->ticket_status != '10' && $ticket->ticket_status != '20' && $ticket->ticket_status != '90' && $ticket->ticket_status != '91'){
								/* if($ticket->ticket_status == '20' || $ticket->ticket_status == '21' || $ticket->ticket_status == '22' || $ticket->ticket_status == '92' || $ticket->ticket_status == '93'){ */
							?>
							<a class="btn btn-primary white-icon" href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/conversation/'.$ticket->id);?>" title="Chat Log"><i class="fa fa-comments" aria-hidden="true"></i> Chat</a> &nbsp;
							<?php }
								$mapdata = $this->ticket_model->getthedata('ticket_id',$ticket->id,'nw_ticket_map_tbl');
								$ticketmapdata = !empty($mapdata)?$mapdata[0]:'';
								if(!empty($ticketmapdata)){
								if($ticketmapdata->ticket_status == 92){ 
							?>
								<a data-action="mark_completed" id="ticket_mark_completed" class="btn btn-danger white-icon" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateMapRecords');?>" data-id="<?php echo $ticketmapdata->id; ?>" data-status ="<?php echo $ticketmapdata->status; ?>" data-massege ="Are you sure want to complete this ticket!" title="mark as completed"><i class="fa fa-times-circle-o" aria-hidden="true"></i> Mark Completed</a>
							<?php } } ?>								
							</div>							
                        </h3>
                    </div>
                    <div class="card-body">
						<?php 
							$ticketlogdata = $this->ticket_model->getthedata('ticket_id',$ticket->id,'nw_ticketstatusremarklog_tbl'); 
						?>
                        <div class="row">
                            <div class="col-4">
                                <div class="ticketmanagement ticketid">
                                <h5>Ticket ID</h5>
                                <p><?php  echo $ticket->ticket_id; ?></p>
                                </div>
                           
                            </div>
							<div class="col-4">
                                <div class="ticketmanagement ticketid">
                                <h5>Customer Name</h5>
                                <p><?php  echo $ticket->customername; ?></p>
                                </div>
                           
                            </div>
                            <div class="col-4">
                               <div class="ticketmanagement startdate">
                                <h5>Start Date</h5>
                                <p>
                                    <?php 
                                    if($ticket->start_date != ''){
                                    echo date('d-m-Y', strtotime($ticket->start_date)); 
                                    }else{
                                    echo 'NA';
                                    }
                                    
                                    ///TICKET-JSKMP
                                    ?>
                                </p>
                               </div>
                            </div>
                           
                            <div class="col-4">
                                <div class="ticketmanagement ticketstatus">
									<h5>Ticket Status</h5>
									<p>
										<?php $statusRes= __getStatus($ticket->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?><br/>
										<?php
											if(!empty($ticketlogdata)){
											$lastlogdata 	= end($ticketlogdata);
											$userdetail 	= $this->user_model->getDataBykey('nw_user_tbl','id',$lastlogdata->user_id);
											$loguser_type 	= $userdetail->user_type; 
											$userdata 		= $this->user_model->getUserDetailsById($lastlogdata->user_id,$loguser_type);
											$userroledata 	= $this->user_model->getDataBykey('nw_role_tbl','id',$loguser_type);
											$loguser_name 	= $userdata->name;
										?>
											<b>Updated By :-</b> <span class="userdata"><?php echo !empty($userroledata->role_name)?ucfirst($userroledata->role_name):'';echo ' - ';?><?php echo !empty($loguser_name)?$loguser_name:'';?></span><br/>
											<b>Updated At :- </b> <span class="userdata"><?php echo !empty($lastlogdata->modified_at)?date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at)):'';?></span>
										<?php } ?>
									</p>
                                </div>
                            </div>
                            

                            <div class="col-4">
                                 <div class="ticketmanagement paymentstatus">
                                <h5>Payment Status</h5>
                                <p><?php switch($ticket->payment_status) {
                                    case 0: echo 'Pending'; break;
                                    case 1: echo 'Completed'; break;
                                } ?>
                                </p>
                                 </div>
                            </div>
                            <div class="col-4">
                                 <div class="ticketmanagement status">
                                <h5>Status</h5>
                                <p><?php switch($ticket->status) {
                                    case 0: echo 'Inactive'; break;
                                    case 1: echo 'Active'; break;
                                    } ?>
                                </p>
                                 </div>
                            </div>
                            <div class="col-4">
                                 <div class="ticketmanagement category">
                                 <h5>Category</h5>
                                <p><?php
									$categoryData = $this->category_model->parentCategoryName($ticket->categoryid);
									echo (!empty($categoryData))?$categoryData->name:'NA';
                                ?>
                                </p>
                                 </div>
                            </div>
							<div class="col-4">
                                 <div class="ticketmanagement category">
                                 <h5>Subcategory</h5>
                                <p><?php 
									if(!empty($ticket->subcategory_id)){
										$subcatdata = $this->category_model->parentCategoryName($ticket->subcategory_id);
										if(!empty($subcatdata)){
											echo $subcatdata->name;
										}else{
											echo '';
										}
									}else{
										echo '';
									}
                                ?>
                                </p>
                                 </div>
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>Address</h5>
									<?php
										$address 	= isset($ticket->customer_address)?$ticket->customer_address:'';
										if(!empty($address)){
											echo '<p>'.$address.'</p>';
										}
									?>
                                </div>                            
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>City</h5>
									<?php
										$city 	= isset($ticket->customer_city)?$ticket->customer_city:'';
										if(!empty($city)){
											echo '<p>'.$city.'</p>';
										}
									?>
                                </div>                            
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>State</h5>
									<?php
										$stateid 	= isset($ticket->customer_state)?$ticket->customer_state:0;
										if(!empty($stateid)){
											$stateData 	= $this->user_model->getStateList($stateid);
											if(!empty($stateData)){
												$statename 	= $stateData->name;
												echo '<p>'.$statename.'</p>';
											}
										}
									?>
                                </div>                            
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>Country</h5>
									<?php
										if(!empty($ticket->customer_country)){
											$countryData = $this->user_model->getCountryList($ticket->customer_country);
											if(!empty($countryData)){
												echo '<p>'.$countryData->name.'</p>';
											}
										}
									?>
                                </div>                            
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>Pin code</h5>
									<?php
										$pincode 	= isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
										if(!empty($pincode)){
											echo '<p>'.$pincode.'</p>';
										}
									?>
                                </div>                            
                            </div>
                            <div class="col-4">
                                <div class="ticketmanagement description">
									<h5>Uploaded File</h5>
									<p>
									<?php
										if(!empty($ticket->file)) {
											$files = json_decode($ticket->file);
											//$files = explode(',',$ticket->file);
											if(!empty($files)){
											$filecount 	= count($files);
											$counter 	= 1;
											foreach($files as $file){
									?>
										<a href="<?php echo base_url().'uploads/ticket/'.$file->file; ?>" target="_blank"><?php echo !empty($file->filename)?$file->filename:'casefile';?></a> <?php echo ($filecount > $counter)?',':''; ?>
									<?php $counter++; } ?> 
									<?php }else{ ?>
										<p>No files uploaded</p> 
									<?php }}else{ ?>
										<p>No files uploaded</p>    
									<?php } ?>
									</p>
                              </div>
                            </div>
							<div class="col-4">
                                <div class="ticketmanagement description">
									<h5>Description</h5>
									<p><?php echo $ticket->description; ?></p>
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
											$profilename = $json_form_data->Upload_Document;
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
					<?php } */ if(!empty($ticketlogdata)){ ?>
						<div class="row ticket_remark mt-5">
							<div class="col-12">
								<h5>Ticket Status Log</h5>
							</div>
							<div class="col-12">
								<div class="table-responsive customizetableres">
									<table id="ticket_status_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Ticket Status</th>
												<th>User Type</th>
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
												rsort($ticketlogdata); 
												foreach($ticketlogdata as $ticketlog){
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
														$userdetail = $this->user_model->getDataBykey('nw_user_tbl','id',$ticketlog->user_id);
														$loguser_type = $userdetail->user_type; 
														$userroledata 	= $this->user_model->getDataBykey('nw_role_tbl','id',$loguser_type);
														$loguser_email 	= $userdetail->email; 
														$userdata 		= $this->user_model->getUserDetailsById($ticketlog->user_id,$loguser_type);
														$loguser_name 	= $userdata->name;
													?>
													<td><?php echo !empty($userroledata)?ucfirst($userroledata->role_name):'';?></td>
													<td><?php echo $loguser_name .'<br/>'. $loguser_email;?></td>
													<td style="display:none;"><?php echo $loguser_name;?></td>
													<td style="display:none;"><?php echo $loguser_email;?></td>
													<td><?php echo $ticketlog->user_remark; ?></td>
													<td><?php if(!empty($ticketlog->user_file)){ ?> <a href="<?php echo base_url().'uploads/ticket/ticketremarkfiles/'.$ticketlog->user_file; ?>" target="_blank">View File</a><?php }else{ ?>No file attached <?php } ?></td>
													<td style="display:none;"><?php echo isset($ticketlog->user_file)?$ticketlog->user_file:''; ?></td>
													<td><?php echo date('d-m-Y H:i:s',strtotime($ticketlog->modified_at)); ?></td>
												</tr>
											<?php 
												$counter++; }
											}												
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<?php } ?>
                    </div>
                    <div class="card-footer">
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
	$('document').ready(function(){
		var base_url = '<?php echo base_url(); ?>';
		$('#ticket_mark_completed').click(function(){
			var ticketid 		= $(this).data('id');
			var ticketstatus 	= $(this).data('status');
			var ticketaction	= $(this).data('action');
			$.ajax({
				url: base_url+'admin/ticket/updateMapRecords',
				data: {'uid': ticketid,'status': ticketstatus,'action': ticketaction}, 
				type: "post",
				success: function(data){
					var obj = JSON.parse(data);
					window.location.href= obj.redirectURL;
					//console.log(obj.redirectURL);return false;
				}
			});
		});
	});
</script>