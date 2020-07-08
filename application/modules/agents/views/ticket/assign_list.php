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
					<div class="table-responsive customizetableres">
						<div class="row mb-2">
							<div class="credted filter">Filter :</div>
							<div class="col-md-2 filter FilterCustom1"></div>
							<div class="col-md-3 filter FilterCustom2"></div>
							<div class="col-md-3 filter FilterCustom3"></div>
						</div>
						<div class="row mb-2">
							<div class="credted filter">Assign Date :</div>
							<?php /*<div class="col-md-2 filter FilterCustom6">
								<select name="datewisedata" id="datewisedata" class="form-control">
									<option value="">Select Custom Option</option>
									<option value="d_ago">1 Day Ago</option>
									<option value="w_ago">1 Week Ago</option>
									<option value="m_ago">1 Month Ago</option>
								</select>
							</div> */ ?>
							<div class="col-md-2 filter FilterCustom7">
								<input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
							</div>
							<div class="col-md-2 filter FilterCustom7">
								<input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
							</div>
						</div>
                        <table id="assignticket_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>
										<?php
											echo 'Customer';
										?>
                                    </th>
                                    <th style="display:none;">Name</th>
                                    <th style="display:none;">Experties</th>
                                    <th style="display:none;">Rating</th>
                                    <th>Category</th>
                                    <th>Subategory</th>
                                    <th>Assign Date</th>
                                    <th style="display:none;">Close Date</th>
                                    <th>Created</th>
                                    <th>Ticket Status</th>
                                    <th style="display:none;">Ticket Status</th>
                                    <th>Action</th>
									 <th style="display:none;">datetime</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($response['data'] as $assign) {
										$catname 		= '';
										$subcatname		= '';
										$expertiesname 	= '';
										if(!empty($assign->ticketid)){
											$ticketdetails = $this->ticket_model->getTicketById($assign->ticketid);
											if(!empty($ticketdetails)){
												$catname = $ticketdetails->category_name;
												$subcatdata = $this->category_model->get_category_data($ticketdetails->subcategory_id);
												$subcatname = $subcatdata->name;
											}
										}
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
											<?php echo $assign->customer_name; ?>
                                        </td>
										<td style="display:none;"><?php echo isset($assign->consultant_name)?$assign->consultant_name:''; ?></td>
										<td style="display:none;"><?php echo isset($expertiesname)?$expertiesname:''; ?></td>
										<td style="display:none;"><?php echo isset($avgrate)?$avgrate:''; ?></td>
										<td><?php echo isset($catname)?$catname:'NA'; ?></td>
										<td><?php echo isset($subcatname)?$subcatname:'NA'; ?></td>
                                        <td>
                                            <?php                                         
                                                if($assign->assign_date != ''){
                                                    echo date('d-m-Y', strtotime($assign->assign_date)); 
                                                }else{
                                                    echo 'NA';
                                                } 
                                            ?>
                                        </td>
                                        <td style="display:none;">
                                            <?php                                         
                                                if($assign->close_date != ''){
                                                    echo date('d-m-Y', strtotime($assign->close_date)); 
                                                }else{
                                                    echo 'NA';
                                                } 
                                            ?>                                            
                                        </td>
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
										<td style="display:none;">
											<?php echo ucfirst($statusRes['status']); ?>
										</td>
										<?php 
											$ChatData = $this->ticket_model->GetChatlastdatetime($assign->ticketid);
											$SessionData = $this->session->userdata('agents');
											$blinkclass = '';
											$style = "";
											if(!empty($ChatData)){
												if($ChatData->msg_to == $SessionData['user_id'] || $ChatData->msg_to == $consultant_id){
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
                                        <td>
                                            <a href="<?php echo base_url('/agent/ticket/conversation/'.$assign->ticket_id);?>" title="Chat Log" style="<?php echo $style; ?>"><i class="fa fa-comments readchat <?php echo $blinkclass; ?>" aria-hidden="true"></i></a>
											<a href="<?php echo base_url().'agent/ticket/view/'.$assign->ticket_id; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <input type="hidden" class="readstatus" value='1'>
                                            <input type="hidden" class="ticketid" value='<?php echo $assign->ticket_id; ?>'>
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
