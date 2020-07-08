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
		<?php 
			$mapticketdata = $this->ticket_model->getMappedTicket($ticket->id);
		?>
        <div class="row">
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
						<?php 
							if(!empty($mapticketdata)){
								if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
						?>
							<h3 class="card-title"><?php echo 'Reassign Ticket'; ?></h3>
						<?php }}else{ ?>
							<h3 class="card-title"><?php echo $page_title; ?></h3>
						<?php } ?>
                    </div>
                    <?php
						echo form_open($pageUrl.'/assign/'.$ticket->id, array('class' => 'assign_ticket', 'id' => 'AssignTicketForm'));
                    ?>
                    <div class="card-body floating-laebls">
                        <?php if ($this->session->flashdata('flash_msg') != "") { ?>
                            <div class="alert alert-success" id="alert-success-div">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('flash_msg'); ?>
                                <button type="button" class="close" aria-label="Close" id="msg-close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php } ?>
                        <div class="row">
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Previous Assign Consultant </h5>
									<?php 
										if(!empty($mapticketdata)){
											if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
											$consultantuserdata 	= $this->user_model->getDataBykey('nw_user_tbl','id',$mapticketdata->consultant_id);
											$consultantdetail 	= $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$consultantuserdata->id);
											$consultantemail = !empty($consultantuserdata)?$consultantuserdata->email:'';
											$consultantname 	= !empty($consultantdetail)?$consultantdetail->name:'';
									?>
										<p><?php  echo $consultantname .' ( '.$consultantemail.' )'; ?></p>
									<?php }else{ ?>
										<p>No Consultant Assigned</p>
									<?php }}else{ ?>
										<p>No Consultant Assigned</p>
									<?php } ?>
                                </div>                           
                            </div>
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Previous Assign Consultant Date</h5>
									<?php 
										if(!empty($mapticketdata)){
											if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
												$preassign_date  = date('d-m-Y',strtotime($mapticketdata->assign_date));
											}else{
												$preassign_date  = 'NA';
											}
									?>
										<p><?php  echo $preassign_date; ?></p>
									<?php }else{ ?>
										<p><?php  echo 'NA'; ?></p>
									<?php } ?>
                                </div>                           
                            </div>
						</div>
						<div class="row mt-3">
                             <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Ticket Id', 'ticket_id');
										echo form_input(array('name' => 'ticket_id', 'class' => 'form-control input', 'value' => $ticket->custom_id, 'id' => "ticket_id", 'readonly' => 'true'));
										echo form_input(array('name' => 'customer_id', 'type' => 'hidden', 'class' => 'form-control', 'value' => $ticket->customer_id, 'id' => "customer_id", 'readonly' => 'true'));
										echo '<div class="error-msg">' . form_error('ticket_id') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Ticket Category', 'category_name');
										echo form_input(array('name' => 'category_name',
											'class' => 'form-control input',
											'value' => $ticket->category_name,
											'id' => "category_name",
											'readonly' => 'true'));
										echo '<div class="error-msg">' . form_error('category_name') . '</div>';
									?>   
								</div>
                            </div>
						</div>
						<div class="row">
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Ticket Subcategory', 'sub_category_name');
										$subcatename = '';
										if(!empty($ticket->subcategory_id)){
											$subcatdata = $this->category_model->parentCategoryName($ticket->subcategory_id);
											if(!empty($subcatdata)){
												$subcatename = $subcatdata->name;
											}
										}
										echo form_input(array('name' => 'sub_category_name',
											'class' => 'form-control input',
											'value' => $subcatename,
											'id' => "sub_category_name",
											'readonly' => 'true'));
										echo '<div class="error-msg">' . form_error('sub_category_name') . '</div>';
									?>   
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
									if(!empty($mapticketdata)){
										if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
											echo form_label('Reassign Consultant Name*', 'consultant_id');
										}else{
											echo form_label('Consultant Name*', 'consultant_id');
										}
									}else{
										echo form_label('Consultant Name*', 'consultant_id');
									}
									$option = array("" => "Select Consultant");
									foreach ($consultant as $categorywiseconsultant) {
										//$categorywiseconsultant = $this->user_model->getconsultantbycategory($value->usersId,$ticket->categoryid,$ticket->subcategory_id,$ticket->customer_city,$ticket->customer_state);
										if(!empty($categorywiseconsultant)){
											$consultantuserdata = $this->user_model->getDataBykey('nw_user_tbl','id',$categorywiseconsultant->user_id);
											if($categorywiseconsultant->step5_verify_time != '0000-00-00 00:00:00'){
												if(!empty($mapticketdata)){
													if($categorywiseconsultant->user_id != $mapticketdata->consultant_id){
														$option[$categorywiseconsultant->user_id] = ucfirst($categorywiseconsultant->account_type) .' - '.ucfirst($categorywiseconsultant->name .' - '. $consultantuserdata->email);
													}
												}else{
													$option[$categorywiseconsultant->user_id] = ucfirst($categorywiseconsultant->account_type) .' - '.ucfirst($categorywiseconsultant->name .' - '. $consultantuserdata->email);
												}
											}
										}
									}
									echo form_dropdown('consultant_id', $option, set_value('consultant_id',$ticket->consultant_id), 'class="form-control input" id="consultant_id"');
									
									echo '<div class="error-msg">' . form_error('consultant_id') . '</div>';
									?>
								</div>
							</div>
						</div>
						<div class="row">
                            <?php /*<div class="form-group col-6">
                                <?php
									echo form_label('Start Date*', 'assign_date');
									echo form_input(array('name' => 'assign_date', 'class' => 'form-control datepicker', 'value' => set_value('assign_date'), 'id' => "assign_date", 'placeholder' => 'Assign Date','readonly'=>'readonly'));
									echo '<div class="error-msg">' . form_error('assign_date') . '</div>';
                                ?>
                            </div>*/ ?>
                            <div class="col-6">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Ticket Description', 'description');
										echo form_textarea(array('name' => 'description',
											'class' => 'form-control input',
											'value' => set_value('description', $ticket->description),
											'id' => "description",
											'cols' => '4',
											'rows' => '4',
											'disabled' => 'disabled',
										));
										echo '<div class="error-msg">' . form_error('description') . '</div>';
									?>
								</div>
                            </div>
                        </div> 
						<div class="row">
							<?php
								echo form_submit(array("class" => "btn btn-primary", "id" => "assign_tkt_btn", "value" => "Submit"));
								echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type'].'/ticket/servicelist/?status=10') . '" class="btn btn-default">Cancel</a>';
                            ?>
						</div>
                    </div>
					<?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>