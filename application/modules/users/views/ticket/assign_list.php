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
                    <?php
						$CI 			= & get_instance();
						$SessionData 	= $CI->session->userdata('users');
                    ?>
					<div class="table-responsive customizetableres">
                        <table id="assignticket_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
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
									foreach ($response['data'] as $assign) {
										$catname 		= '';
										$subcatname 	= '';
										$expertiesname 	= '';
										if(!empty($assign->ticketid)){
											$ticketdetails = $this->ticket_model->getTicketById($assign->ticketid);
											if(!empty($ticketdetails->subcategory_id)){
												$subcatdata = $this->category_model->get_category_data($ticketdetails->subcategory_id);
												$subcatname = $subcatdata->name;
											}
											if(!empty($ticketdetails)){
												$catname = $ticketdetails->category_name;
											}
										}
										$agentData = $this->user_model->getAgentdetailByTicket($assign->ticketid,$assign->consultant_id);
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
											$ticketlogdata  = $this->ticket_model->getthedata('ticket_id',$assign->ticketid,'nw_ticketstatusremarklog_tbl');
											$updatedtime 	= '';
											if(!empty($ticketlogdata)){
												$lastlogdata 	= end($ticketlogdata);
												$updatedtime 	= date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at));
											}
										/*** last updated ticket data ****/
									?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo isset($assign->customid)?$assign->customid:''; ?></td>
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
													echo $assign->consultant_name .'<br/>';
													echo $expertiesname .'<br/>';
													echo '<div class="ratings">
														<div class="empty-stars"></div>
														<div class="full-stars" style="width:'.$per.'%"></div>
														</div><br/>';
												}else{
													echo $assign->customer_name; 
												}
											?>
                                        </td>
										<td style="display:none;"><?php echo isset($assign->consultant_name)?$assign->consultant_name:''; ?></td>
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
												//echo '<pre>'; print_r($assign->ticket_status); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
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
											$ChatData = $this->ticket_model->GetChatlastdatetime($assign->ticketid);
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
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
</script>
