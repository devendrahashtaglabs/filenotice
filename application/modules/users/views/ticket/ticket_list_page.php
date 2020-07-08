<style>
	.tooltipz {
	  position: relative;  
	}

	/* Tooltip text */
	.tooltipz .tooltiptext {
		visibility: hidden;
		width: 100%;
		background-color: #5a5a5a;
		color: #fff;
		text-align: center;
		padding: 5px 5px;
		border-radius: 6px;
		position: absolute;
		z-index: 1;
		bottom: 85%;
		left: 0;
		opacity: 0;
		transition: opacity 0.3s;
		box-shadow: 0 0 black;
		right: 0;
	}

	/* Tooltip arrow */
	.tooltipz .tooltiptext::after {
	  content: "";
	  position: absolute;
	  top: 100%;
	  left: 50%;
	  margin-left: -5px;
	  border-width: 5px;
	  border-style: solid;
	  border-color: #555 transparent transparent transparent;
	}

	/* Show the tooltip text when you mouse over the tooltip container */
	.tooltipz:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}
	.ticketslistr .modal-dialog {
		max-width: 950px;
		margin: 1.75rem auto;
	}
	.ticketslistr .valuetext {
		font-size: 15px;
		margin: 0 0 10px;
	}
	.ticketslistr .modal-body{
		background: #f4f4ff;
	}
	.ticketslistr .text.mainn label {
		font-size: 14px;
		margin: 0;
	}
	.modal{
		z-index: 9999;
	}
	.invoice {
		position: relative;
		background: transparent;
		border: none;
	}
	.ticketslistr .modal-body {
	  background: #f4f4ff;
	  flex: none;
	  padding: 8px 28px 8px;
	}
	.modal-open .modal {
	  overflow: hidden;  
	  padding-right: 0 !important;
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title; ?></h3></div>
                       <?php  if($this->session->userdata('users')['user_type'] != 'consultant') { ?> <div class="float-right"><a href="<?php echo $pageUrl.'/choose_category'; ?>" class="btn btcreaten-block btn-primary"><i class="fa fa-plus"></i> Add Ticket</a></div> <?php } ?>
                    </div>
                    <div class="card-body manage-listd ">
						<?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
							$SessionData 	= $this->session->userdata('users');
							$user_id 		= $SessionData['user_id'];
							$user_type 		= $SessionData['user_type'];
							if(empty($status)|| $status == '10'){
						?>
						<div class="fileterdata ">
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom4"></div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
                            </div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
                            </div>
						</div>
                        <div class="table-responsive customizetableres">
							<table id="ticketlist_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Ticket Id</th>
										<th>Category</th>
										<th>Subcategory</th>
										<th style="display:none;">Description</th>
										<th>State</th>
										<th>City</th>
										<th>Created Date</th>
										<th>Status</th>
										<th>Action</th>
										<th style="display:none;">Ticket Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$a = 1;
										foreach ($tickets['data'] as $row) {
											$subcatname = '';
											if(!empty($row->subcategory_id)){
												$subcatdata = $this->category_model->get_category_data($row->subcategory_id);
												$subcatname = $subcatdata->name;
											}
											$statequery = $this->user_model->getStateList($row->customer_state,'');
											$statename 	= !empty($statequery)?$statequery->name:'NA';
											$cityquery 	= $this->user_model->getCityList($row->customer_city,'');
											$cityname 	= !empty($cityquery)?$cityquery->city_name:'NA';
									?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><?php echo $row->customId; ?></td>
											<td><?php echo $row->category_name; ?></td>
											<td><?php echo $subcatname; ?></td>
											<td style="display:none;"><?php echo isset($row->description)?$row->description:''; ?></td>
											<td><?php echo $statename; ?></td>
											<td><?php echo $cityname; ?></td>
											<td><?php echo ($row->created!='')?date('d-m-Y',strtotime($row->created)):DEFAULT_VALUE;?></td>
											<td><?php $statusRes= __getStatus($row->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
											<td class="actionrow">
												<div class="atbtnset">
													<a href="<?php echo $pageUrl.'/view/'.$row->id; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;
													<?php 
														if($row->mapstatus==='false'){ 
															if($row->payment_status != 1){
													?>
														<a href="<?php echo $pageUrl.'/edit/'.$row->id; ?>" title="Edit Ticket"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
														<?php } ?>
														<a href="javascript:;" data-action="delete" class="toChange" data-url="<?php echo $pageUrl.'/update';?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure want to delete!" title="Delete Ticket"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
													<?php } ?>
													<a href="#my_modal" data-toggle="modal" data-id="<?php echo $row->id; ?>" title="See Invoice"><i class="fa fa-server" aria-hidden="true" style="color:green;"></i></a>
												</div>
											</td>
											<td style="display:none;"><?php if($row->mapstatus === 'true' && $row->ticket_status != 90 && $row->ticket_status != 91){ echo 'Assigned';}else{ echo 'Unassigned';} ?></td>
										</tr>
										<?php $a++;
									} ?>
								</tbody>
							</table>
                        </div>
						<?php }elseif($status == '20'){ ?>
						<div class="fileterdata ">
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
							</div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
							</div>
						</div>
						<div class="table-responsive customizetableres">
							<table id="assignticketlist_table" class="table table-bordered table-striped" style="margin-top: 20px;">
								<thead>
									<tr>
										<th>#</th>
										<th>Ticket Id</th>
										<th>
											<?php
												if ($SessionData['user_type']=='customer'){
													echo 'Consultant';    
												}else{
													echo 'Customer';
												}
											?>
										</th>
										<th style="display:none;">Consultant Name</th>
										<th style="display:none;">Experties</th>
										<th style="display:none;">Rating</th>
										<?php if ($SessionData['user_type']!='customer'){ ?>
											<th>Assigned To Agent</th>
											<th style="display:none;">Agent Name</th>
											<th style="display:none;">Agent Email</th>
											<th style="display:none;">Agent Phone</th>
										<?php } ?>
										<th>Category</th>
										<th>Subcategory</th>
										<th>Ticket Assigned Date</th>
										<th>Ticket Status</th>
										<th style="display:none;">Ticket Status</th>
										<th style="display:none;">Status Update Date</th>
										<th>Action</th>
										<th style="display:none;">datetime</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$a = 1;
										foreach ($tickets['data'] as $assign) {
											$catname 		= '';
											$subcatname 	= '';
											$expertiesname 	= '';
											if(!empty($assign->id)){
												$ticketdetails = $this->ticket_model->getTicketById($assign->id);
												if(!empty($ticketdetails->subcategory_id)){
													$subcatdata = $this->category_model->get_category_data($ticketdetails->subcategory_id);
													$subcatname = $subcatdata->name;
												}
												if(!empty($ticketdetails)){
													$catname = $ticketdetails->category_name;
												}
											}
											$agentData = $this->user_model->getAgentdetailByTicket($assign->id,$assign->consultant_id);
											$consultant_id = $assign->consultant_id;
											if(!empty($consultant_id)){
												$consultantdetail = $this->user_model->getconsultantdetail($consultant_id);
												if(!empty($consultantdetail)){
													$expertise = isset($consultantdetail->expertise)?$consultantdetail->expertise:'';
													$expertises = explode(',',$expertise);
													$expertiesnamearray = []; 
													foreach($expertises as $expertiseid){
														$expertisedetails = $this->expertise_model->getExpertiseById($expertiseid,'1');
														if(!empty($expertisedetails)){
															$expertiesnamearray[] = $expertisedetails->name;
														}
													}
													$expertiesname = implode(',',$expertiesnamearray);
												}
												$avgrate = 0;
												$consultantrate = $this->user_model->getconsultantavgrating($consultant_id);
												if(!empty($consultantrate)){
													$avgrate = round($consultantrate->rating,2);
												}
											}
											/*** last updated ticket data ****/
												$ticketlogdata  = $this->ticket_model->getthedata('ticket_id',$assign->id,'nw_ticketstatusremarklog_tbl');
												$updatedtime 	= '';
												if(!empty($ticketlogdata)){
													$lastlogdata 	= end($ticketlogdata);
													$updatedtime 	= date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at));
												}
											/*** last updated ticket data ****/
											//echo "<pre>";print_r($assign);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
										?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><?php echo isset($assign->customId)?$assign->customId:''; ?></td>
											<td>
												<?php 
													if($avgrate == '') { $avgrate = 0; }
													$per = $avgrate*100/5;
													/* if ($SessionData['user_type']=='customer'){                                         
														 echo $assign->consultant_name . ' - ' . $assign->typeThreeEmail;
													}else{
														 echo $assign->customer_name . ' - ' . $assign->typeTwoEmail; 
													} */
													if ($SessionData['user_type']=='customer'){
														echo $assign->consultant_name .' '.$assign->consultant_sname .'<br/>';
														echo $expertiesname .'<br/>';
														echo '<div class="ratings">
															<div class="empty-stars"></div>
															<div class="full-stars" style="width:'.$per.'%"></div>
															</div><br/>';
													}else{
														echo $assign->customer_name .' '.$assign->customer_sname; 
													}
												?>
											</td>
											<td style="display:none;"><?php echo isset($assign->consultant_name)?$assign->consultant_name:'';echo ' '; echo isset($assign->consultant_sname)?$assign->consultant_sname:''; ?></td>
											<td style="display:none;"><?php echo isset($expertiesname)?$expertiesname:''; ?></td>
											<td style="display:none;"><?php echo isset($avgrate)?$avgrate:''; ?></td>
											<?php if ($SessionData['user_type']!='customer'){ 
												if(!empty($agentData)){
											?>
												<td><?php echo $agentData->name .'<br/>'.$agentData->email .'<br/>'.$agentData->mobile ; ?></td>
												<td style="display:none;"><?php echo isset($agentData->name)?$agentData->name:''; ?></td>
												<td style="display:none;"><?php echo isset($agentData->email)?$agentData->email:''; ?></td>
												<td style="display:none;"><?php echo isset($agentData->mobile)?$agentData->mobile:''; ?></td>
											<?php }else{ ?>
												<td><?php echo 'Self'; ?></td>
												<td style="display:none;"><?php echo 'NA'; ?></td>
												<td style="display:none;"><?php echo 'NA'; ?></td>
												<td style="display:none;"><?php echo 'NA'; ?></td>
											<?php } } ?>
											<td><?php echo isset($catname)?$catname:''; ?></td>
											<td><?php echo isset($subcatname)?$subcatname:''; ?></td>
											<td><?php echo date('d-m-Y', strtotime($assign->created)); ?></td>
											<td>
											<?php 
												$statusRes = __getStatus($assign->ticket_status, 'float-left');
												echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
												if($assign->ticket_status != 90 || $assign->ticket_status != 91){
													if(!empty($updatedtime)){
														$assign_date = date('d-m-Y', strtotime($updatedtime));
														echo '<span class="'. $statusRes["spanClass"] .'">'. $assign_date .'</span>'; 
													}elseif($assign->assign_date != ''){
														$assign_date = date('d-m-Y', strtotime($assign->assign_date));
														echo '<span class="'. $statusRes["spanClass"] .'">'. $assign_date .'</span>'; 
													}else{
														echo '<span class="'. $statusRes["spanClass"] .'"> NA </span>'; 
													} 
												}else{
													if($assign->close_date != ''){ 
														$close_date = date('d-m-Y', strtotime($assign->close_date));
														echo '<span class="'. $statusRes["spanClass"] .'">'. $close_date .'</span>';
													}else{
														echo '<span class="'. $statusRes["spanClass"] .'"> NA </span>'; 
													}
												}
											?>
											</td>
											<?php 
												if($assign->ticket_status != 90 || $assign->ticket_status != 91){
													$assign_date = date('d-m-Y', strtotime($assign->assign_date));
											?>
												<td style="display:none;"><?php echo ucfirst($statusRes['status']);?> </td>
												<td style="display:none;"><?php echo isset($assign_date)?$assign_date:'';?></td>
											<?php 
												}else{
													$close_date = date('d-m-Y', strtotime($assign->close_date));
											?>
												<td style="display:none;"><?php echo ucfirst($statusRes['status']);?> </td>
												<td style="display:none;"><?php echo isset($close_date)?$close_date:'';?></td>
											<?php } ?>
											<?php 
												$agentMapData 	= $this->ticket_model->checkticketassigntoagent($assign->ticket_id,$user_id);
												$ChatData = $this->ticket_model->GetChatlastdatetime($assign->id);
												$blinkclass = '';
												$style = "";
												if(!empty($ChatData)){
													if($ChatData->msg_to == $SessionData['user_id']){
														if($ChatData->read_status == '0'){
															$blinkclass = "blinkchat";
															$style = "color:red;";
														}else{
															$blinkclass = " ";
															$style = " ";
														} 
													}
												}
											?>
											<td class="actionrow">
												<div class="atbtnset">
												<?php 
													if($assign->ticket_status != '10' && $assign->ticket_status != '20' && $assign->ticket_status != '90' && $assign->ticket_status != '91'){
												?>
												<a href="<?php echo base_url('/ticket/conversation/'.$assign->ticket_id);?>" title="Chat Log" style="<?php echo $style; ?>"><i class="fa fa-comments readchat <?php echo $blinkclass; ?>" aria-hidden="true"></i></a>
												<?php } ?>
												<a href="<?php echo base_url().'ticket/view/'.$assign->ticket_id; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
												<?php if($user_type == 'consultant' ){ ?>
													<?php
														if (!empty($agentMapData)) {
															if ($agentMapData->status == 1) {
																if($agentMapData->ticket_status != '90' && $agentMapData->ticket_status != '91'){
																	$assignurls = ($agentMapData->assign_agent_status == '10')? base_url() . 'ticket/assignagent/'.$agentMapData->ticket_id: 'javascript:;';
																	$assignTitle = ($agentMapData->assign_agent_status == '10')? 'Assign to Agent': 'Already Assign to Agent';
																	$style = ($agentMapData->assign_agent_status == '10')?'':'color:red';
																}else{
																	/* $assignurls = ($assign->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$assign->id: 'javascript:;';
																	$assignTitle = ($assign->ticket_status == '90' || $assign->ticket_status == '91')? 'Ticket Completed': '';
																	$style = ($assign->ticket_status==='90' || $assign->ticket_status == '91')?'color:red':''; */
																}
															?>
															<a href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php echo $style; ?>"></i></a>&nbsp;

														<?php } } else { ?>  
														<a href="<?php echo base_url() . 'ticket/assignagent/'.$assign->ticketid; ?>" title="Assign To Agent"><i class="fa fa-user" aria-hidden="true"></i></a>&nbsp;
														<?php } ?>
												<?php } ?>
												<input type="hidden" class="readstatus" value='1'>
												<input type="hidden" class="ticketid" value='<?php echo $assign->ticket_id; ?>'>
												<?php if ($SessionData['user_type']=='customer'){ ?>
													<input type="hidden" class="user_ids" value='<?php echo $assign->customeridentity; ?>'>
												<?php }else { ?>
													<input type="hidden" class="user_ids" value='<?php echo $assign->consultantidentity; ?>'>
												<?php } ?>
												</div>   
											</td>
											<td  style="display:none;">
											<?php 
												if(isset($ChatData)){
													echo $ChatData->created_at;
												}
											?>
											</td>
											
										</tr>
										<?php $a++;
									}
									?>
								</tbody>
							</table>
						</div>
						<?php }elseif($status == '90'){ ?>
							<div class="fileterdata ">
								<div class="filter Filterstatus FilterCustom1"></div>
								<div class="filter Filterstatus FilterCustom2"></div>
								<div class="filter Filterstatus FilterCustom7">
									<input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
								</div>
								<div class="filter Filterstatus FilterCustom7">
									<input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
								</div>
							</div>
							<div class="table-responsive customizetableres">
								<table id="completedticketlist_table" class="table table-bordered table-striped" style="margin-top: 20px;">
									<thead>
										<tr>
											<th>#</th>
											<th>Ticket Id</th>
											<th>Consultant</th>
											<th>Category</th>
											<th>Subcategory</th>
											<th>Description</th>
											<th>Start Date</th>
											<th>Close Date</th>
											<th>Status</th>
											<?php if($user_type == 'customer'){ ?>
												<th>Rate Consultant</th>
											<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php
											$a = 1;
											foreach ($tickets['data'] as $row) {
												
												$consultantdata = $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$row->consultant_id,'name,sname');
												$subcatname = '';
												if(!empty($row->subcategory_id)){
													$subcatdata = $this->category_model->get_category_data($row->subcategory_id);
													$subcatname = $subcatdata->name;
												}
										?>
											<tr>
												<td><?php echo $a; ?></td>
												<td><?php echo $row->customId; ?></td>
												<td><?php echo isset($consultantdata->name)?$consultantdata->name:'';echo ' '; echo isset($consultantdata->sname)?$consultantdata->sname:''; ?></td>
												<td><?php echo $row->category_name; ?></td>
												<td><?php echo isset($subcatname)?$subcatname:''; ?></td>
												<td style="word-break: break-all;"><?php echo substr($row->description, 0, 20).'...'; ?></td>
												<td>
													<?php 
														$start_date = ($row->start_date)?$row->start_date:'';
														if(!empty($start_date)){
															echo date('d-m-Y', strtotime($row->start_date)); 
														}
													?>
												</td>
												<td>
													<?php 
														$close_date = ($row->close_date)?$row->close_date:'';
														if(!empty($close_date)){
															echo date('d-m-Y', strtotime($row->close_date));
														}											
													?>
												</td>
												<td>
												<?php if($row->ticket_status == '90'){ ?>
													<span class="float-left badge bg-danger">Completed</span>
												<?php }else{ ?>
													<span class="float-left badge bg-danger">Cancelled</span>
												<?php } ?>

												<?php $statusRes= __getStatus($row->status, 'float-left'); 
												//echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?>
												</td>
												<?php
													$rating = $this->ticket_model->get_rating($row->ticket_id, $row->customer_id, $row->consultant_id);
													if($user_type == 'customer'){ ?>
												<td>
													
													<?php 
														if(count($rating) > 0) {
															$per = $rating[0]->rating*100/5; 
															echo '<div class="ratings">
															<div class="empty-stars"></div>
															<div class="full-stars" style="width:'.$per.'%"></div>
															</div>';
														} else { 
													?>                                            
													<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#feedbackModal<?php echo $row->ticket_id; ?>" style="color:#fff">Rate <i class="fa fa-star-o"></i></a>
													
													<div class="modal fade" id="feedbackModal<?php echo $row->ticket_id; ?>" role="dialog">
													<div class="modal-dialog" style="max-width:50%">
													  <!-- Modal content -->
														<form method="post" id="ratingForm<?php echo $row->ticket_id; ?>" onsubmit="return confirm_rating('<?php echo base_url('ticket/feedback'); ?>', <?php echo $row->ticket_id; ?>);">
														  <div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title star-rating" style="float:left;">Rating & Review &nbsp; &nbsp; </h4>
																
															  <button type="button" class="close" data-dismiss="modal">&times;</button>
															  
															</div>
															  
															<div class="modal-body" id="feedbackModal<?php echo $row->ticket_id; ?>">
															  <div class="row">
																  <?php
																	$consultantdata = $this->user_model->getUserDetailsById($row->consultant_id,'3');
																	if(!empty($consultantdata->photo)) {
																		$Profile_img = base_url().'uploads/profile/'.$consultantdata->photo;
																	}else{
																		$Profile_img = base_url().'uploads/profile/no_image_available.jpeg';
																	}
																	clearstatcache();
																  ?>
																  
																  <table class="table table-hover">
																	  <tr><td rowspan="4" width="25%" class="sutomfile">
																			  <?php if(empty($consultantdata->photo)) { echo '<img src="'.$Profile_img.'" style="width:100%;" />'; } else { echo '<img src="'.$Profile_img.'" />'; } ?>
																		  </td>
																		  <th>Name:</th><td><?php echo $consultantdata->name; ?></td> 
																		  
																	  </tr>
																	  <tr><th>Email:</th><td><?php echo $consultantdata->email; ?></td></tr>
																	  <tr><th>Mobile:</th><td><?php echo $consultantdata->mobile; ?></td></tr>
																	   <tr><th>Rate:</th><td><h4 class="star-rating">
																				   <span class="fa fa-star-o" data-rating="1"></span>
																<span class="fa fa-star-o" data-rating="2"></span>
																<span class="fa fa-star-o" data-rating="3"></span>
																<span class="fa fa-star-o" data-rating="4"></span>
																<span class="fa fa-star-o" data-rating="5"></span> 
																		<input type="hidden" name="rating" class="rating-value" value="0">
															   <input type="hidden" name="ticket_id" value="<?php echo $row->ticket_id; ?>">
															   <input type="hidden" name="customer_id" value="<?php echo $row->customer_id; ?>">
															   <input type="hidden" name="consultant_id" value="<?php echo $row->consultant_id; ?>">       
																			   </h4></td></tr>
																  </table>
																
															   
															  <div class="item form-group" style="width:100%">
																		<textarea id="remark" name="remark" placeholder="Enter Remark" class="form-control"></textarea>
																 </div>
															 </div>

														  </div>

															<div class="modal-footer" style="text-align: center;">
															  <input type="submit" name="submit" class="btn btn-primary" value="Submit" id="rateformsubmit">
																<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
															</div>
														  </div>
														</form>

													</div>
													</div>
													<?php } ?>
												</td>
											   <?php } ?>
											</tr>
											<?php $a++; } ?>
									</tbody>
								</table>
							</div>
						<?php }else{ ?>
							<div class="table-responsive customizetableres">
								<table id="allticketlist_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Ticket Id</th>
											<th>Category</th>
											<th>Subcategory</th>
											<th>State</th>
											<th>City</th>
											<th>Created Date</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
							</div>
						<?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php 
	if(empty($status)|| $status == '10'){
?>
	<div class="row">
		<div class="modal modal-success fade ticketslistr" id="modal-success">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 style="margin: 0;font-size: 18px;color: #263a7d;font-weight: 600;">Ticket Created Details</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<?php 
							/* $catdata 		= $this->category_model->get_category_data($lastcreatedticket->category_id);
							$subcatdata 	= $this->category_model->get_category_data($lastcreatedticket->subcategory_id);
							$paymentdatas 	= $this->ticket_model->getthedata('ticket_id',$lastcreatedticket->id,'nw_payment_tbl');
							$paymentdata	= $paymentdatas[0];
							$countrydata 	= $this->user_model->getCountryList($lastcreatedticket->customer_country);
							$statedata 		= $this->user_model->getStateList($lastcreatedticket->customer_state,'');
							$citydata 		= $this->user_model->getCityList($lastcreatedticket->customer_city,''); */
							
							$catdata 		= $this->category_model->get_category_data($lastcreatedticket->category_id);
							$subcatdata 	= $this->category_model->get_category_data($lastcreatedticket->subcategory_id);
							$paymentdatas 	= $this->ticket_model->getthedata('ticket_id',$lastcreatedticket->id,'nw_payment_tbl');
							$paymentdata	= $paymentdatas[0];
							$invoicedatas 	= $this->ticket_model->getthedata('ticket_id',$lastcreatedticket->id,'nw_invoice_tbl');
							$invoicedata	= $invoicedatas[0];
							$countrydata 	= $this->user_model->getCountryList($lastcreatedticket->customer_country);
							$statedata 		= $this->user_model->getStateList($lastcreatedticket->customer_state,'');
							$citydata 		= $this->user_model->getCityList($lastcreatedticket->customer_city,'');
						?>
						<div class="row">
							<section class="content invoice">
								<!-- title row -->
								<div class="row">
									<div class="col-md-12 invoice-header">
										<h3>
											<i class="fa fa-globe"></i> Invoice.
											<?php 
												$invoicedate = date('d-m-Y',strtotime($invoicedata->created));
											?>
											<small class="pull-right">Date: <?php echo !empty($invoicedate)?$invoicedate:''; ?></small>
										</h3>
									</div>
									<!-- /.col -->
								</div>
								<!-- info row -->
								<div class="row invoice-info">
									<div class="col-sm-4 invoice-col">
										From
										<address>
											<strong>HashTag Labs</strong>
											<br>D-147/4A, Indira Nagar, Lucknow – 226016 (UP) INDIA
											<br>Phone: +91 (0522) 4248697
											<br>Email: coffee@hashtaglabs.biz
										</address>
									</div>
									<!-- /.col -->
									<div class="col-sm-4 invoice-col">
										To
										<address>
											<?php
												$customerdata = $this->user_model->getUserDetailsById($lastcreatedticket->customer_id,'2');
												$title 			= $customerdata->title;
												$prefixdatas 	= $this->ticket_model->getthedata('id',$title,'nw_prefix_tbl');
												$titledata 		= !empty($prefixdatas)?$prefixdatas[0]:'';
												$fullname 		= $titledata->title .' '. $customerdata->name .' '.$customerdata->sname;
											?>
											<strong><?php echo $fullname; ?></strong>
											<br><?php  echo !empty($lastcreatedticket->customer_address)?$lastcreatedticket->customer_address:''; ?>
											<br>Phone: <?php  echo !empty($customerdata->mobile)?$customerdata->mobile:''; ?>
											<br>Email: <?php  echo !empty($customerdata->email)?$customerdata->email:''; ?>
										</address>
									</div>
									<!-- /.col -->
									<div class="col-sm-4 invoice-col">
										<b>Invoice #<?php echo !empty($invoicedata->invoice_id)?$invoicedata->invoice_id:''; ?></b>
										<br>
										<br>
										<b>Order ID:</b> <?php echo !empty($lastcreatedticket->ticket_id)?$lastcreatedticket->ticket_id:''; ?>
										<br>
										<?php 
											$payment_date 	= !empty($paymentdata->payment_date)?$paymentdata->payment_date:'';
											$paymentdate 	=  date('d-m-Y',strtotime($payment_date));
										?>
										<b>Payment Due:</b> <?php echo $paymentdate; ?>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->

								<!-- Table row -->
								<div class="row">
									<div class="col-xs-12 table" style="margin-bottom: 0">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>S No</th>
													<th>Ticket Raised For</th>
													<th>Ticket Id</th>
													<th style="width: 59%">Description</th>
													<th>Amount</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<?php 
														$catname 	= $catdata->name;
														$subcatname = $subcatdata->name;
													?>
													<td><?php echo $catname.' [ '. $subcatname .' ]'; ?></td>
													<td><?php echo !empty($lastcreatedticket->ticket_id)?$lastcreatedticket->ticket_id:''; ?></td>
													<td><?php echo !empty($lastcreatedticket->description)?$lastcreatedticket->description:''; ?>
													</td>
													<td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->

								<div class="row">
									<!-- accepted payments column -->
									<div class="col-md-6">
										<p class="lead">Payment Methods:</p>
										<img src="<?php echo base_url() ?>cosmatics/images/visa.png" alt="Visa">
										<img src="<?php echo base_url() ?>cosmatics/images/mastercard.png" alt="Mastercard">
										<img src="<?php echo base_url() ?>cosmatics/images/american-express.png" alt="American Express">
										<img src="<?php echo base_url() ?>cosmatics/images/paypal.png" alt="Paypal">
										<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
											Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
										</p>
									</div>
									<!-- /.col -->
									<div class="col-md-6">
										<?php 
											$payment_date 	= !empty($paymentdata->payment_date)?$paymentdata->payment_date:'';
											$paymentdate 	=  date('d-m-Y',strtotime($payment_date));
										?>
										<p class="lead">Amount Due <?php echo $paymentdate; ?></p>
										<div class="table-responsive">
											<table class="table">
												<tbody>
													<tr>
														<th style="width:50%">Subtotal:</th>
														<td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></td>
													</tr>
													<tr>
														<th>Tax </th>
														<td><i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
													</tr>
													<tr>
														<th>Shipping:</th>
														<td> <i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
													</tr>
													<tr>
														<th>Total:</th>
														<td><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></strong></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!-- /.col -->
								</div>
								<!-- /.row -->

								<!-- this row will not appear when printing -->
								<div class="row no-print">
									<div class="col-md-12">
										<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
										<!--<button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>-->
										<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		$createdticket = $this->session->userdata('createdticket');
		if($createdticket == 'success'){
	?>
	<script type="text/javascript">
		$(window).on('load',function(){
			$('#modal-success').modal('show');
		});
	</script>
	<?php 
			$this->session->unset_userdata('createdticket');
		} 
	?>
	<!-- show invoice -->

	<div id="my_modal" class="modal fade showremark ticketslistr" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<span class="remark-heading">Ticket Invoice</span>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>
		  <div class="modal-body">
			
		  </div>
		</div>
	  </div>
	</div>
	<script>
		var $base_url = "<?php echo base_url();?>";
		$('#my_modal').on('show.bs.modal', function(e) {
			var ticketid = $(e.relatedTarget).data('id');
			$.ajax({
				method: "POST",
				url: $base_url+'users/ticketController/getinvoicebyticketid',
				data: {"ticketid":ticketid},
				success:function(response){
					if(response != ''){
						//var obj = JSON.parse(response);
						//console.log(response);return false;
						$("#my_modal .modal-body").html(response);
					}else{
						$("#my_modal .modal-body").html('');
					}
				}
			});
		});
	</script>
	<!-- show invoice -->
<?php }elseif($status == '20'){ ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
	/* 	$(document).ready(function(){
			$('.readchat').click(function() {
			 var read_status = $('.readstatus').val();
			  var ticket_id = $('.ticketid').val();
			  var user_ids = $('.user_ids').val();
			 //alert('{"read_status" : '+read_status+'}');
					
			$.ajax({
				url: "<?php echo base_url(); ?>customerController/assign_list",
				type : "POST",
				dataType : "json",
				data : {"read_status" : '+read_status+'},
				success : function(data) {
				  //alert(data);
				},
				error : function(data) {
					//alert(data);
				}
			});

		});
		});
	*/
	</script>
<?php } ?>