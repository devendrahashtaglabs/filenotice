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
                        ?>
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
                        <table id="assignedticket_table_id" class="table table-bordered table-striped" style="width: 100%">
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
									foreach ($response as $row) {
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
											$ticketlogdata  = $this->ticket_model->getthedata('ticket_id',$row->ticketid,'nw_ticketstatusremarklog_tbl');
											$updatedtime 	= '';
											if(!empty($ticketlogdata)){
												$lastlogdata 	= end($ticketlogdata);
												$updatedtime 	= date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at));
											}
											$allticketdata  = $this->ticket_model->getthedata('id',$row->ticketid,'nw_ticket_tbl');
											$ticketdata		= $allticketdata[0];
											$categorydata 	= $this->category_model->getCategoryById($ticketdata->category_id);
											$subcategorydata = $this->category_model->getCategoryById($ticketdata->subcategory_id);
											$statedata 	= $this->user_model->getStateList($ticketdata->customer_state,'');
											$citydata 	= $this->user_model->getCityList($ticketdata->customer_city,'');
										/*** last updated ticket data ****/
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customid; ?></td>
                                        <td><?php echo ucfirst($row->customer_name) . '<br/><span style="word-break: break-all;" class="tooltipz">' . substr($row->typeTwoEmail, 0, 10).'...<span class="tooltiptext">'.$row->typeTwoEmail.'</span></span><br/>'. $ticketdata->customer_mobile; ?></td>
                                        <td style="display:none"><?php echo ucfirst($row->customer_name); ?></td>
                                        <td style="display:none"><?php echo $row->typeTwoEmail; ?></td>
                                        <td style="display:none"><?php echo $ticketdata->customer_mobile; ?></td>
                                        <td><?php echo $row->consultant_name . '  '.$account_type.'<br/><span style="word-break: break-all;" class="tooltipz">' . substr($row->typeThreeEmail, 0, 10).'...<span class="tooltiptext">'.$row->typeThreeEmail.'</span></span><br/>' . $expertiesname ; ?></td>
										<td style="display:none"><?php echo ucfirst($row->consultant_name); ?></td>
                                        <td style="display:none"><?php echo $row->typeThreeEmail; ?></td>
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
                                           <?php /* <a data-action="status" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateMapRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->mapstatue;?>" data-massege ="Are you sure want to change!" title="Change status to <?php if($row->mapstatue == 1) { echo 'Inactive'; } else { echo 'Active'; } ?>" href="javascript:;">
                                                <?php echo ($row->mapstatue == 1) ? '<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>' : '<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>'; ?>
                                            </a> */ ?>
                                           
										<?php if ($row->status == 1) { ?>  
                                       
                                            <a onclick="alertFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>

										<?php } else { ?>  
                                            <a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateMapRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->mapstatue;?>" data-massege ="Are you sure want to delete!"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
										<?php } 
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function alertFunction() {
		alert("Active ticket cannot be deleted");
    }
	/* $(document).ready(function(){
		$('#datewisedata').change(function(){
			var selectedOption = $(this).children("option:selected").val();
			var assigntable = $('#assignedticket_table_id').DataTable();
			$.ajax({
				method: "POST",
				url: '<?php echo base_url();?>admin/ticket/getcustomoptiondata',
				data: {"selectedOption":selectedOption},
				beforeSend: function() {
					// setting a timeout
					assigntable.destroy();
				},
				success:function(response){
					
				}
			});
		});
	}); */
</script>