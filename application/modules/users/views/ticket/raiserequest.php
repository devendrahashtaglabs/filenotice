<?php 
	$sessiondata = $this->session->userdata('users');
	$user_id 	 = $sessiondata['user_id'];
	$user_type 	 = $sessiondata['user_type'];
?>
<style>
.ticketmanagement {
	margin: 0 0 10px;
	float: left;
	width: 100%;
	padding: 0;
}
.ticketmanagement h5 {
	font-weight: normal;
	font-size: 14px;
	color: #333;
	margin: 0 0 5px;
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
.innerbgf .form-control {
	height: 30px;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
	background-color: #fff;
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
.innerbgf select.form-control {
	height: 30px !important;
}
#tkt_status_btn, #reset-btn {
    margin-top: 0;
}
.form-group{
	margin-bottom: 8px;
}
.subtitkes {
	float: left;
	font-size: 18px;
	font-weight: bold;
	color: #263a7d;
}
#customer_ticket_status_table tr th {
    background: #494e53;
    color: #fff;
}
.dataTables_filter input{
	background: #fff;
	border: 1px solid #ccc;
	padding: 1px 12px;
	line-height: 1.42857143;
	height: 30px;
	border-radius: 4px;
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
								&nbsp;<a class="back-btn btn btn-warning white-icon" onclick="window.history.back();" style="float:right;" title="Back"><i class="fa fa-arrow-left" ></i>&nbsp;Back</a>
							</div>
						</h3>
                    </div>
                    <div class="card-body">
                    	<div class="innerbgf">
                    		<div class="row">
							<div class="col-12">
								<h4 class="subtitkes">Ticket Info</h4>
							</div>
						</div>
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
                        </div>
                        <div class="row">
                        	<div class="col-6">
                        		<div class="ticketmanagement ticketid">
									<h5>Ticket ID</h5>
									<p><?php  echo $ticket->ticket_id; ?></p>
                                </div>  
                        	</div>
                        	<?php if($sessiondata['user_type'] != 'customer'){ ?>
							<div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Customer Name</h5>
									<p><?php  echo $ticket->customername; ?></p>
                                </div>
                            </div>
							<?php } ?>
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
											$loguser_name 	= $userdata->name;
										?>
											<b>Updated By :-</b> <span class="userdata"><?php echo !empty($userroledata->role_name)?ucfirst($userroledata->role_name):'';echo ' - ';?><?php echo !empty($loguser_name)?$loguser_name:'';?></span><br/>
											<b>Updated At :- </b> <span class="userdata"><?php echo !empty($lastlogdata->modified_at)?date('d-m-Y H:i:s',strtotime($lastlogdata->modified_at)):'';?></span>
										<?php } ?>
									</p>
                                </div>
                            </div>
                        </div>
						<?php
							$titledata  = $this->user_model->getDataBykey('nw_prefix_tbl','id',$ticket->title);
						?>
                        <div class="row">
							<div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>Title</h5>
										<p><?php echo !empty($titledata->title)?$titledata->title:''; ?></p>
									</div>
								</div>
                            </div>
							<div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>First Name</h5>
										<p><?php echo !empty($ticket->customername)?$ticket->customername:''; ?></p>
									</div>
								</div>
                            </div>
							<div class="col-4">
								<div class="form-group customtextre">
									<div class="ticketmanagement ticketid">
										<h5>Last Name</h5>
										<p><?php echo !empty($ticket->customersname)?$ticket->customersname:''; ?></p>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row">
                        	<div class="col-6">
							<div class="form-group customtextre">
								<div class="ticketmanagement ticketid">
									<h5>Mobile Number</h5>
									<p><?php echo !empty($ticket->customer_mobile)?$ticket->customer_mobile:''; ?></p>
                                </div>
                            </div>
                           </div>
                           <div class="col-6">
							<div class="form-group customtextre">
								<div class="ticketmanagement ticketid">
									<h5>Email</h5>
									<p><?php echo !empty($ticket->useremail)?$ticket->useremail:''; ?></p>
                                </div>
                            </div>
                           </div>
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
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
                        </div>
                        <div class="row">
                        	<div class="col-6">
                        		<div class="">
								<div class="ticketmanagement ticketid">
									<h5>Description</h5>
									<p><?php  echo ($ticket->description)?$ticket->description:''; ?></p>
                                </div>
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
							
							 
                           <?php /* <div class="col-6">
								<div class="ticketmanagement ticketid">
									<h5>Status</h5>
									<p><?php  echo ($ticket->status=='0')?'Inactive':'Active'; ?></p>
                                </div>
                            </div> */?>
                            
                           
                        
                       
						<?php 
							if($user_type === 'customer'){ 
							echo form_open_multipart(base_url().'ticket/raiserequestwithremark/'.$ticket->id, array('class' => 'ticket-status-from', 'id' => 'TicketStatusForm'));
							$requestlogdata = $this->ticket_model->getthedata('ticket_id',$ticket->id,'nw_customer_request_tbl');
						?>
						<div class="row mt-2 ticket_remark">
							<div class="form-group col-12">
								<h5 class="subtitkes">Raise Your Request</h5>
							</div>
							<?php 
								$requestbyticket = !empty($requestlogdata)?$requestlogdata[0]:'';
								$adminRemark	 = !empty($requestbyticket)?$requestbyticket->admin_remark:'No Remark'; 
								if(!empty($adminRemark)){
							?>
                            <div class="form-group col-6">
								<?php
									echo form_label('Request Type *', 'ticket_status');
                                    $option = array(
										'' => 'Select Type',
										'I need refund' => 'I need refund',
										'Problem Solved, Closed my ticket' => 'Problem Solved, Closed my ticket',
										'Reassign Consultant' => 'Reassign Consultant',
										'Too late to solving problem ' => 'Too late to solving problem',
									);
                                    echo form_dropdown('ticket_status', $option, set_value('ticket_status'), $extra = 'class= "form-control" id="ticket_status"');
                                    echo '<div class="error-msg">' . form_error('ticket_status') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6 customtextre">
								<?php
									echo form_label('Remark', 'customer_remark');
									echo form_textarea(array('name' => 'customer_remark', 'class' => 'form-control', 'value' => set_value('customer_remark'), 'id' => "customer_remark", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Remark','onkeyup'=>'countChar(this,255)'));
									echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
									?>
									<label><span class="text-danger" style="font-size:10px;">(Enter upto 255 character.)</span></label>
								<?php echo '<div class="error-msg">' . form_error('customer_remark') . '</div>'; ?>
                            </div>
							<!--<div class="form-group col-3">
								<?php //echo form_label('Upload File', 'remark_file'); ?>
								<input type="file" id="remark_file" class="form-control remarkfile" name="remark_file" />
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 1MB)</span></label>
                            </div>-->
							<div class="form-group col-12 pull-right text-right">
								<?php
								    echo ' '. form_reset(array('class' => 'btn btn-danger','id'=>'reset-btn','value'=>"Reset"));
									echo form_submit(array('name'=>'ticketstatusupdate',"class" => "btn btn-warning", "id" => "tkt_status_btn", "value" => "Submit"));
									
								?>
                            </div>
							<?php }else{ ?>
							<div class="form-group col-12">
								<p class="text-danger">You have already raise a request, wait for admin remark.</p>
							</div>
							<?php } ?>
						</div>
						<?php echo form_close(); ?>
						<div class="row ticket_remark">
							<div class="col-12">
								<h5 class="subtitkes">Ticket Status Log</h5>
							</div>
							<div class="col-12">
								<div class="table-responsive customizetableres">
									<table id="customer_ticket_status_table" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
										<thead>
											<tr>
												<th>#</th>
												<th>Request Status</th>
												<th>Customer Remark</th>
												<th>Request Accepted</th>
												<th>Admin Remark</th>
												<th>Updated At</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(!empty($requestlogdata)){
												$counter = 1;
												foreach($requestlogdata as $ticketlog){
													$userdetail = $this->user_model->getDataBykey('nw_user_tbl','id',$ticketlog->user_id);
													$loguser_type 	= $userdetail->user_type; 
													$userdata 		= $this->user_model->getUserDetailsById($ticketlog->user_id,$loguser_type);
										?>
												<tr>
													<td><?php echo $counter; ?></td>
													<td>
													<?php 
														echo ucfirst($ticketlog->request_status);
													?>
													</td>
													<td><?php echo $ticketlog->customer_remark; ?></td>
													<td>
														<?php 
															echo ($ticketlog->request_accepted == '1')?'Yes':'No';
														?>
													</td>
													<td><?php echo $ticketlog->admin_remark; ?></td>
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
                </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function(){
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




