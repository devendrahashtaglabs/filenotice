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
							<a class="back-btn btn btn-info white-icon" onclick="window.history.back();" style="float:right;" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
							<div style="float:right;">
								<a class="btn btn-primary white-icon" href="<?php echo base_url('/agent/ticket/conversation/'.$ticket->id);?>" title="Chat Log"><i class="fa fa-comments readchat" aria-hidden="true"></i> Chat</a>&nbsp;
								<a class="ticket-btn btn btn-primary white-icon" id="ticket-btn" title="Change ticket status"><i class="fa fa-ticket"></i> Ticket Status</a> &nbsp;
								<input type="hidden" class="readstatus" value='1'>
								<input type="hidden" class="ticketid" value='<?php echo $ticket->id; ?>'>
							</div>
						</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Ticket ID</h5>
									<p><?php  echo $ticket->ticket_id; ?></p>
                                </div> 
                            </div>
							<div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Customer Name</h5>
									<p><?php  echo $ticket->customername; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ticketmanagement ticketstatus">
									<h5>Ticket Status</h5>
									<p>
										<?php $statusRes= __getStatus($ticket->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?><br/>
										<?php
											$ticketlogdata = $this->ticket_model->getthedata('ticket_id',$ticket->id,'nw_ticketstatusremarklog_tbl');
											if(!empty($ticketlogdata)){
											$lastlogdata 	= end($ticketlogdata);
											$userdetail 	= $this->user_model->getDataBykey('nw_user_tbl','id',$lastlogdata->user_id);
											$loguser_type 	= $userdetail->user_type; 
											$userdata 		= $this->user_model->getUserDetailsById($lastlogdata->user_id,$loguser_type);
											$userroledata 	= $this->user_model->getDataBykey('nw_role_tbl','id',$loguser_type);
											//echo '<pre>'; print_r(); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
											$loguser_name 	= $userdata->name;
										?>
											<b>Updated By :-</b> <span class="userdata"><?php echo !empty($userroledata->role_name)?ucfirst($userroledata->role_name):'';echo ' - ';?><?php echo !empty($loguser_name)?$loguser_name:'';?></span><br/>
											<b>Updated At :- </b> <span class="userdata"><?php echo !empty($lastlogdata->modified_at)?date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at)):'';?></span>
										<?php } ?>
									</p>
                                </div>
                            </div> 
							<div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Status</h5>
									<p><?php  echo ($ticket->status=='0')?'Inactive':'Active'; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Category</h5>
									<p><?php  echo ($ticket->category_name)?$ticket->category_name:''; ?></p>
                                </div>
                            </div>
							<div class="col-6">
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
                            <div class="col-6  customtextre">
                                <div class="ticketmanagement ticketid">
									<h5>Address</h5>
									<?php 
										$address    = isset($ticket->customer_address)?$ticket->customer_address:'';
									?>
									<p><?php  echo ($address)?$address:''; ?></p>
                                </div>
                            </div>
                            <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>City</h5>
									<?php 
										$city   	= isset($ticket->customer_city)?$ticket->customer_city:'';
										$cityquery  = $this->user_model->getCityList($city,'');
									?>
									<p><?php  echo !empty($cityquery)?$cityquery->city_name:''; ?></p>
                                </div>                            </div>
                            <div class="col-6">
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
                                </div>                            </div>
                            <div class="col-6">
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
                            
                            <div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Pin code</h5>
									<?php 
										$pincode    = isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
									?>
									<p><?php  echo ($pincode)?$pincode:''; ?></p>
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
                        <div class="row">
                            <div class="form-group col-12">
								<div class="ticketmanagement ticketid">
									<h5>Description</h5>
									<p><?php  echo ($ticket->description)?$ticket->description:''; ?></p>
                                </div>
                            </div>
						</div>
						<?php 
							echo form_open_multipart(base_url().'agent/ticket/changeticketstatwithremark/'.$ticket->id, array('class' => 'ticket-status-from', 'id' => 'TicketStatusForm'));
						?>
						<div class="row mt-5 ticket_remark" style="display:none;">
							<div class="form-group col-12">
								<h5>Update Ticket Status</h5>
							</div>
                            <div class="form-group col-3">
								<?php
									$whereindata 		= array(21,22,92);
									$ticketstatusdata 	= $this->ticket_model->getticketremarkstatus($whereindata);
									echo form_label('Ticket Status *', 'ticket_status');
                                    $option = array('' => 'Select Status');
									if(!empty($ticketstatusdata)){
										foreach($ticketstatusdata as $ticketstatus){
											$option[$ticketstatus->status_code] = $ticketstatus->status;
										}                    
                                    }
                                    echo form_dropdown('ticket_status', $option, set_value('ticket_status'), $extra = 'class= "form-control" id="ticket_status"');
                                    echo '<div class="error-msg">' . form_error('ticket_status') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-4 customtextre">
								<?php
									echo form_label('Remark', 'consultant_remark');
									echo form_textarea(array('name' => 'consultant_remark', 'class' => 'form-control', 'value' => set_value('consultant_remark'), 'id' => "consultant_remark", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Remark','onkeyup'=>'countChar(this,255)'));
									echo '<div class="remain-char charcount text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
								?>
									<label><span class="text-danger" style="font-size:10px;">(Enter upto 255 character.)</span></label>
								<?php echo '<div class="error-msg">' . form_error('consultant_remark') . '</div>'; ?>
                            </div>
							<div class="form-group col-3">
								<?php echo form_label('Upload File', 'remark_file'); ?>
								<input type="file" id="remark_file" class="form-control remarkfile" name="remark_file" />
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 1MB)</span></label>
                            </div>
							<div class="form-group col-2">
								<?php
									echo form_submit(array('name'=>'ticketstatusupdate',"class" => "btn btn-success", "id" => "tkt_status_btn", "value" => "Submit"));
									echo ' '. form_reset(array('class' => 'btn btn-info','id'=>'reset-btn','value'=>"Reset"));
								?>
                            </div>
						</div>
						<?php echo form_close(); ?>
						<div class="row ticket_remark" style="display:none;">
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
														$loguser_type 	= $userdetail->user_type; 
														$loguser_email 	= $userdetail->email; 
														$userdata 		= $this->user_model->getUserDetailsById($ticketlog->user_id,$loguser_type);
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
												$counter++; }
											}												
											?>
										</tbody>
									</table>
								</div>
							</div>
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





