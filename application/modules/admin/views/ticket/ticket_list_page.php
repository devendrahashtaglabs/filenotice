<style>
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
}
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
    min-width: 98px;
}
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
                    </div>
                    <div class="card-body manage-listd">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
							if($status == '10'){
                        ?>
						<div class="fileterdata ">
							<div class="filter Filterstatus customfiltercategory"></div>
							<div class="filter Filterstatus customfiltersubcategory"></div>
							<div class="filter Filterstatus customfiltercity"></div>
							<div class="filter Filterstatus customfilterstate"></div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmin" id="unassignmin" type="text" placeholder="Start Date">
                            </div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmax" id="unassignmax" type="text" placeholder="End Date">
                            </div>
						</div>
                        <div class="table-responsive customizetableres mahgepddin">
							<table id="ticketlist_table" class="table table-bordered table-striped" style="width: 100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Ticket Id</th>
										<th>Customer</th>
										<th style="display:none;">Customer Name</th>
										<th style="display:none;">Customer Email</th>
										<th style="display:none;">Customer Mobile</th>
										<th>Category / Subcategory</th>
										<th style="display:none;">Category</th>
										<th style="display:none;">Subcategory</th>
										<th>State / City</th>
										<th style="display:none;">State</th>
										<th style="display:none;">City</th>
										<th>Start Date</th>
										<th style="display:none;">Close Date</th>
										<th style="text-align: center;">Status</th>
										<th style="display:none;">Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$a = 1;
										foreach ($response['data'] as $row) {
											$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
											$statedata 	= $this->user_model->getStateList($row->customer_state,'');
											$citydata 	= $this->user_model->getCityList($row->customer_city,'');
									?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><?php echo $row->customId; ?></td>
											<td><?php echo ucfirst($row->customer_name).'<br/>'.$row->customer_email .'<br/>'.$row->customer_mobile; ?></td>
											<td style="display:none;"><?php echo ucfirst($row->customer_name); ?></td>
											<td style="display:none;"><?php echo $row->customer_email; ?></td>
											<td style="display:none;"><?php echo $row->customer_mobile; ?></td>
											<td><span style="word-break: break-all; display: block; width:138px; word-wrap: break-word;"><?php echo $row->category_name .' / '.$subcategorydata->name; ?></span></td>
											<td style="display:none;"><?php echo $row->category_name; ?></td>
											<td style="display:none;"><?php echo $subcategorydata->name; ?></td>
											<?php 
												$city_name = !empty($citydata)?$citydata->city_name:'NA';
												$state_name = !empty($statedata)?$statedata->name:'NA';
											?>
											<td><?php echo  $state_name.' / '.$city_name; ?></td>
											<td style="display:none;"><?php echo $state_name; ?></td>
											<td style="display:none;"><?php echo $city_name; ?></td>
											<td>
												<?php 
													if($row->start_date != ''){
														echo date('d-m-Y', strtotime($row->start_date)); 
													}else{
														echo 'NA';
													}
												?>
											</td>
											<td style="display:none;">                                            
												<?php 
													if($row->close_date != ''){
														echo date('d-m-Y', strtotime($row->close_date)); 
													}else{
														echo 'NA';
													}
												?>
											</td>
											<td class="statustd">
												<?php 
													$statusRes= __getStatus($row->ticket_status, 'float-left');
													echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
												?>
											</td>
											<td style="display:none;"><?php echo ($row->status == '1')?'Active':'Inactive'; ?></td>
											<td class="actionrow">
												<div class="atbtnset">
												<a href="<?php echo base_url() .'admin/ticket/view/' . $row->id; ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>&nbsp;&nbsp;
												<?php 
												if ($row->status == 1) {
													if($row->ticket_status != '90' && $row->ticket_status != '91'){
														$assignurls = ($row->mapstatus==='false')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
														$assignTitle = ($row->mapstatus==='false')? 'Assign User': 'Already Assign';
														$style = ($row->mapstatus==='false')?'':'color:red';
													}else{
														$assignurls = ($row->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
														$assignTitle = ($row->ticket_status == '90' || $row->ticket_status == '91')? 'Ticket Completed': '';
														$style = ($row->ticket_status==='90' || $row->ticket_status == '91')?'color:red':'';
													}
												?>
												<a href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php echo $style; ?>"></i></a>&nbsp;

										<?php } else { ?>  
												<a onclick="alertFunction()" title="Inactive Ticket" style="cursor:pointer;"><i class="fa fa-user" aria-hidden="true" style="color:red"></i></i></a>&nbsp; 

										 <?php } ?>
										 <?php if ($row->status == 1) { ?>  
										   
												<a onclick="alertassignFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;   

										  <?php } else { ?>  

												<a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure you want to Delete?"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
										  <?php } ?> 
										  </div>     
											</td>
										</tr>
										<?php $a++;
									} ?>
								</tbody>
							</table>
                        </div> 
						<?php }elseif($status == '20'){ ?>
						<div class="fileterdata">							
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom4"></div>
							<div class="filter Filterstatus FilterCustom5"></div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
							</div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
							</div>
						</div>
                        <div class="table-responsive customizetableres">
							<table id="assignedticket_list" class="table table-bordered table-striped" style="width: 100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Ticket Id</th>
										<th>Customer</th>
										<th	style="display:none">Customer Name</th>
										<th	style="display:none">Customer Email</th>
										<th	style="display:none">Customer Mobile</th>
										<th>Consultant</th>
										<th	style="display:none">Consultant Name</th>
										<th	style="display:none">Consultant Email</th>
										<th	style="display:none">Consultant Expertise</th>
										<th>Category / Subcategory</th>                                    
										<th style="display:none">Category</th>    
										<th style="display:none">Subcategory</th>
										<th> State / City</th>                                    
										<th style="display:none">State</th>
										<th style="display:none">City</th>    
										<th>Assign Date / Created</th>                                    
										<th style="display:none">Assign Date</th>
										<th style="display:none">Created</th>
										<th>Ticket Status</th>
										<th style="display:none">Ticket Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$this->load->model('expertise_model');
										$a = 1;
										foreach ($response['data'] as $row) {
											//echo "<pre>";print_r($row);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
											$expertiesname = '';
											if(!empty($row->consultant_id)){
												$consultantdetail = $this->user_model->getConsultantById($row->consultant_id);
												if(!empty($consultantdetail->expertise)){
													$expertiselists = explode(',',$consultantdetail->expertise);
													$experties = [];
													foreach($expertiselists as $expertiselist){
														$expertisedata = $this->expertise_model->getExpertiseById($expertiselist);	
														$experties[] = isset($expertisedata->name)?$expertisedata->name:'';
													}
													$expertiesname =  implode(',',$experties);
												}
												if($consultantdetail->account_type == 'freelancer'){
													$account_type = '<span class="badge bg-success">'. ucfirst($consultantdetail->account_type) .'</span>';
												}else{
													$account_type = '<span class="badge bg-danger">'. ucfirst($consultantdetail->account_type) .'</span>';
												}
											}
											/*** last updated ticket data ****/
												$ticketlogdata  = $this->ticket_model->getthedata('ticket_id',$row->ticket_id,'nw_ticketstatusremarklog_tbl');
												$updatedtime 	= '';
												if(!empty($ticketlogdata)){
													$lastlogdata 	= end($ticketlogdata);
													$updatedtime 	= date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at));
												}
												$allticketdata  = $this->ticket_model->getthedata('id',$row->ticket_id,'nw_ticket_tbl');
												$ticketdata		= $allticketdata[0];
												$categorydata 	= $this->category_model->getCategoryById($ticketdata->category_id);
												$subcategorydata = $this->category_model->getCategoryById($ticketdata->subcategory_id);
												$statedata 	= $this->user_model->getStateList($ticketdata->customer_state,'');
												$citydata 	= $this->user_model->getCityList($ticketdata->customer_city,'');
											/*** last updated ticket data ****/
									?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><?php echo $row->customId; ?></td>
											<td><?php echo ucfirst($row->customer_name) . '<br/><span style="word-break: break-all;" class="tooltipz">' . substr($row->customer_email, 0, 10).'...<span class="tooltiptext">'.$row->customer_email.'</span></span><br/>'. $ticketdata->customer_mobile; ?></td>
											<td style="display:none"><?php echo ucfirst($row->customer_name); ?></td>
											<td style="display:none"><?php echo $row->customer_email; ?></td>
											<td style="display:none"><?php echo $ticketdata->customer_mobile; ?></td>
											<td><?php echo $row->consultant_name . '  '.$account_type.'<br/><span style="word-break: break-all;" class="tooltipz">' . substr($row->consultant_email, 0, 10).'...<span class="tooltiptext">'.$row->consultant_email.'</span></span><br/>' . $expertiesname ; ?></td>
											<td style="display:none"><?php echo ucfirst($row->consultant_name); ?></td>
											<td style="display:none"><?php echo $row->consultant_email; ?></td>
											<td style="display:none"><?php echo $expertiesname; ?></td>
											<?php 
												$catename 	 = !empty($categorydata)?$categorydata->name:'NA';
												$subcatename = !empty($subcategorydata)?$subcategorydata->name:'NA';
											?>
											<td><span style="word-break: break-all; display: block; width:128px; word-wrap: break-word;"><?php echo $catename .' / '. $subcatename; ?></span></td>
											<td style="display:none"><?php echo $catename; ?></td>
											<td style="display:none"><?php echo $subcatename; ?></td>
											<?php 
												$statename 	= !empty($statedata)?$statedata->name:'NA';
												$cityname 	= !empty($citydata)?$citydata->city_name:'NA';
											?>
											<td><?php echo $statename .' /'. $cityname; ?></td>
											<td style="display:none"><?php echo $statename; ?></td>
											<td style="display:none"><?php echo $cityname; ?></td>
											<?php                                         
												if($row->assign_date != ''){
													$assign_date = date('d-m-Y', strtotime($row->assign_date)); 
												}else{
													$assign_date = 'NA';
												} 
												$createddate = date('d-m-Y', strtotime($row->created)); ?>
											<td><?php echo $assign_date .' / '.$createddate; ?></td>
											<td style="display:none;"><?php echo $assign_date; ?></td>
											<td style="display:none;"><?php echo $createddate; ?></td>
											<?php $statusRes = __getStatus($row->ticket_status, 'float-left'); ?>
											<td class="statustd"><?php 
												echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span> ';
												if(!empty($updatedtime)){
													$updated_date = date('d-m-Y', strtotime($updatedtime));
													echo '<span class="'. $statusRes["spanClass"] .'">'. $updated_date .'</span>'; 
												}elseif($row->assign_date != ''){
													$assign_date = date('d-m-Y', strtotime($row->assign_date));
													echo '<span class="'. $statusRes["spanClass"] .'">'. $assign_date .'</span>'; 
												}else{
													echo '<span class="'. $statusRes["spanClass"] .'"> NA </span>'; 
												} 
												?>
											</td>
											<td style="display:none"><?php echo $statusRes['status']; ?></td>
											<td class="actionrow">
												<div class="atbtnset">
												<a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/view/'.$row->ticket_id); ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>
												<?php 
													if($row->ticket_status != 90 && $row->ticket_status != 91 && $row->ticket_status != 92){
												?>
													<a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/assign/' . $row->ticket_id);?>" title="Consultant Reassignment"><i class="fa fa-users" aria-hidden="true"></i></a>
												<?php } 
													if($row->ticket_status != '10' && $row->ticket_status != '20' && $row->ticket_status != '90' && $row->ticket_status != '91'){
												?>
													<a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/conversation/'.$row->ticket_id);?>" title="Chat Log"><i class="fa fa-comments" aria-hidden="true"></i></a>
												<?php } ?>
											<?php /*if ($row->status == 1) { ?>  
										   
												<a onclick="alertassignFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>

											<?php } else { ?>  
												<a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateMapRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->mapstatue;?>" data-massege ="Are you sure want to delete!"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
											<?php } */
												if($row->ticket_status == 92){
											?>      
												<a data-action="mark_completed" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateMapRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->mapstatue;?>" data-massege ="Are you sure want to complete this ticket!" title="mark as completed"><i class="fa fa-times-circle-o" aria-hidden="true"></i></a>
												<?php } ?>
											</div>
											</td>
										</tr>
										<?php $a++;} ?>
								</tbody>
							</table>
                        </div>
						<?php }elseif($status == '90'){ ?>
						<div class="fileterdata">							
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom4"></div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="completemin" id="completemin" type="text" placeholder="Start Date">
							</div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="completemax" id="completemax" type="text" placeholder="End Date">
							</div>
						</div>
                        <div class="table-responsive customizetableres">
							<table id="completed_list" class="table table-bordered table-striped" style="margin-top: 20px; width: 100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Consultant</th>
										<th style="display:none;">Consultant Name</th>
										<th style="display:none;">Consultant Email</th>
										<th style="display:none;">Consultant Mobile</th>
										<th>Ticket Id</th>
										<th>Category / Subcategory</th>
										<th style="display:none;">Category</th>
										<th style="display:none;">Subcategory</th>
										<th>State / City</th>
										<th style="display:none;">State</th>
										<th style="display:none;">City</th>
										<?php /* <th>Description</th> */ ?>
										<th style="">Remark</th>
										<th>Rating</th>
										<th style="display:none;">Rating</th>
										<th style="text-align: center;">Status</th>
										<th>Completed Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$a = 1;
										foreach ($response['data'] as $row) {
											$remark = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
											if(!empty($remark)){
												$ReviewData =  $remark->review; 
											}else{
												$ReviewData = 'NA';
											}
											$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
											$consultantalldata  = $this->ticket_model->getthedata('user_id',$row->consultant_id,'nw_consultant_tbl');
											$useralldata  = $this->ticket_model->getthedata('id',$row->consultant_id,'nw_user_tbl');
											$consultantdata 	= $consultantalldata[0];
											$userdata 			= $useralldata[0];
											$subcatename 		= !empty($subcategorydata)?$subcategorydata->name:'';
											$statedata 			= $this->user_model->getStateList($row->customer_state,'');
											$citydata 			= $this->user_model->getCityList($row->customer_city,'');
											//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
									?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo $consultantdata->name .'<br/>'. $userdata->email .'<br/>'.$consultantdata->mobile; ?></span></td>
											<td	style="display:none;"><?php echo $consultantdata->name; ?></td>
											<td	style="display:none;"><?php echo $userdata->email; ?></td>
											<td	style="display:none;"><?php echo $consultantdata->mobile; ?></td>
											<td><?php echo $row->customId; ?></td>
											<td><span style="word-break: break-all; display: block; width:128px; word-wrap: break-word;"><?php echo $row->category_name .' / '.$subcatename; ?></span></td>
											<td style="display:none;"><?php echo $row->category_name; ?></td>
											<td style="display:none;"><?php echo $subcatename; ?></td>
											<?php 
												$state_name = !empty($statedata)?$statedata->name:'NA';
												$city_name = !empty($citydata)?$citydata->city_name:'NA';
											?>
											<td><?php echo $state_name .' / '.$city_name; ?></td>
											<td style="display:none;"><?php echo $state_name; ?></td>
											<td style="display:none;"><?php echo $city_name; ?></td>
											<td>
												<span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo $ReviewData; ?></span>
											</td>
											<?php 
												$ratingArray = $this->customer_model->get_rating_by_ticketid($row->ticket_id); 
											?>
											<td>
												<?php 
												if(!empty($ratingArray)){
												   $rating = $ratingArray->rating;
												}else{
													$rating = 0;
												}
												
												if($rating == '') { $rating = 0; }
												   $per = $rating*100/5; echo '<div class="ratings">
														<div class="empty-stars"></div>
														<div class="full-stars" style="width:'.$per.'%"></div>
														</div>'; 
												?>
											</td>
											<td style="display:none;"><?php echo !empty($ratingArray)?$ratingArray->rating:'0'; ?></td>
											<td class="statustd">
												<?php if($row->ticket_status == 90){ ?>
													<span class="float-left badge bg-danger">Completed</span>
												<?php } else { ?>
													 <span class="float-left badge bg-danger">Cancelled</span>
												<?php } 
													$statusArray = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
													
													if(!empty($statusArray)){
														$statusData = $statusArray->status;
													}else{
														$statusData = 0;
													}
													
													$statusRes = __getStatus($statusData, 'float-left'); 
												?>
											</td>
											<td>
												<?php echo date('d-m-Y',strtotime($row->modified)); ?>
											</td>
											<td class="actionrow">
												<div class="atbtnset">
													<?php 
														$TicketData = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
														if(isset($TicketData)){
														$ticket_id_data = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
													?>
													<a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/view/'.$row->ticket_id); ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>
													<?php } ?>
												</div>
											</td>
										</tr>
										<?php $a++;
									} ?>
								</tbody>
							</table>
                        </div>
						<?php }else{ ?>
						<div class="fileterdata ">
							<div class="filter Filterstatus customfiltercategory"></div>
							<div class="filter Filterstatus customfiltersubcategory"></div>
							<div class="filter Filterstatus customfiltercity"></div>
							<div class="filter Filterstatus customfilterstate"></div>
							<div class="filter Filterstatus customfilterstatus"></div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmin" id="unassignmin" type="text" placeholder="Start Date">
                            </div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmax" id="unassignmax" type="text" placeholder="End Date">
                            </div>
						</div>
                        <div class="table-responsive customizetableres mahgepddin">
							<table id="allticketlist_table" class="table table-bordered table-striped" style="width: 100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Ticket Id</th>
										<th>Customer</th>
										<th style="display:none;">Customer Name</th>
										<th style="display:none;">Customer Email</th>
										<th style="display:none;">Customer Mobile</th>
										<th>Category / Subcategory</th>
										<th style="display:none;">Category</th>
										<th style="display:none;">Subcategory</th>
										<th>State / City</th>
										<th style="display:none;">State</th>
										<th style="display:none;">City</th>
										<th>Start Date</th>
										<th style="display:none;">Close Date</th>
										<th style="text-align: center;">Status</th>
										<th style="display:none;">Status</th>
										<th style="display:none;">Ticket Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$a = 1;
										foreach ($response['data'] as $row) {
											$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
											$statedata 	= $this->user_model->getStateList($row->customer_state,'');
											$citydata 	= $this->user_model->getCityList($row->customer_city,'');
									?>
										<tr>
											<td><?php echo $a; ?></td>
											<td><?php echo $row->customId; ?></td>
											<td><?php echo ucfirst($row->customer_name).'<br/>'.$row->customer_email .'<br/>'.$row->customer_mobile; ?></td>
											<td style="display:none;"><?php echo ucfirst($row->customer_name); ?></td>
											<td style="display:none;"><?php echo $row->customer_email; ?></td>
											<td style="display:none;"><?php echo $row->customer_mobile; ?></td>
											<td><span style="word-break: break-all; display: block; width:138px; word-wrap: break-word;"><?php echo $row->category_name .' / '.$subcategorydata->name; ?></span></td>
											<td style="display:none;"><?php echo $row->category_name; ?></td>
											<td style="display:none;"><?php echo $subcategorydata->name; ?></td>
											<?php 
												$city_name = !empty($citydata)?$citydata->city_name:'NA';
												$state_name = !empty($statedata)?$statedata->name:'NA';
											?>
											<td><?php echo  $state_name.' / '.$city_name; ?></td>
											<td style="display:none;"><?php echo $state_name; ?></td>
											<td style="display:none;"><?php echo $city_name; ?></td>
											<td>
												<?php 
													if($row->start_date != ''){
														echo date('d-m-Y', strtotime($row->start_date)); 
													}else{
														echo 'NA';
													}
												?>
											</td>
											<td style="display:none;">                                            
												<?php 
													if($row->close_date != ''){
														echo date('d-m-Y', strtotime($row->close_date)); 
													}else{
														echo 'NA';
													}
												?>
											</td>
											<?php 
												$statusRes = __getStatus($row->ticket_status, 'float-left');
											?>
											<td class="statustd">
												<?php 
													echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
												?>
											</td>
											<td style="display:none;"><?php echo ($row->status == '1')?'Active':'Inactive'; ?></td>
											<td style="display:none;"><?php echo $statusRes['status']; ?></td>
											<td class="actionrow">
												<div class="atbtnset">
													<a href="<?php echo base_url() .'admin/ticket/view/' . $row->id; ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>&nbsp;&nbsp;
													<?php
													if($row->ticket_status != '5'){
														if ($row->status == 1) {
															if($row->ticket_status != '90' && $row->ticket_status != '91'){
																$assignurls = ($row->mapstatus==='false')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
																$assignTitle = ($row->mapstatus==='false')? 'Assign User': 'Already Assign';
																$style = ($row->mapstatus==='false')?'':'color:red';
															}else{
																$assignurls = ($row->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
																$assignTitle = ($row->ticket_status == '90' || $row->ticket_status == '91')? 'Ticket Completed': '';
																$style = ($row->ticket_status==='90' || $row->ticket_status == '91')?'color:red':'';
															}
														?>
														<a href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php echo $style; ?>"></i></a>&nbsp;

												<?php } else { ?>  
														<a onclick="alertFunction()" title="Inactive Ticket" style="cursor:pointer;"><i class="fa fa-user" aria-hidden="true" style="color:red"></i></i></a>&nbsp; 

												 <?php } 
													if ($row->status == 1) { 
												?> 
													<a onclick="alertassignFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;   

											  <?php } else { ?>  
													<a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure you want to Delete?"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
											  <?php } }else{ 
													if($row->leads_read_status == '0'){
											  ?> 
													<a data-url="<?php echo base_url().'admin/ticket/changeleadreadstatus'; ?>" data-id="<?php echo $row->id; ?>" title="Read this ticket" class="read-ticket"><i class="fa fa-book readchat" aria-hidden="true" style="color:red;"></i></a>
											  <?php }}  ?> 
											  </div>     
											</td>
										</tr>
										<?php $a++;
									} ?>
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
<script>
	function alertassignFunction() {
		alert("Active ticket cannot be deleted");
	}
	function alertFunction() {
	alert("Inactive ticket cannot be assigned");
	}
	$('.read-ticket').click(function(){
		var ticketid 	= $(this).data('id');
		var ticketurl 	= $(this).data('url');
		$.ajax({
			url: ticketurl,
			data: {'ticketid': ticketid}, 
			type: "post",
			beforeSend:function(){
				return confirm("Are you sure want to read?");
			},
			success: function(data){
				if(data == '1'){
					location.reload();
				}else{
					alert('Something went wrong!');
				}
			}
		});
	});
	
</script>