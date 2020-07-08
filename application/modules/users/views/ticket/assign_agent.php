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
                    <h1><?php echo isset($section_name)?$section_name:''; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo isset($breadcrumb)?$breadcrumb:''; ?>
                </div>
            </div>
        </div>
    </section>   
    <section class="content">
		<?php 
			$categorywiseagent 	= $this->user_model->getagentbycategory($user_id,$ticket->category_id,$ticket->subcategory_id,'','');
			$mapticketdata 		= $this->ticket_model->getAgentMappedTicket($ticket->id);
		?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
						<h3 class="card-title">
							<?php 
								if(!empty($mapticketdata)){
									if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
										echo 'Reassign Ticket'; 
									}else{
										echo isset($page_title)?$page_title:''; 
									}
								}else{
									echo isset($page_title)?$page_title:''; 
								}
							?>
						</h3>
                    </div>
                    <?php
						echo form_open($pageUrl.'/assignagent/'.$ticket->id, array('class' => 'assign_ticket', 'id' => 'AgentAssignTicketForm'));
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
									<h5>Previous Assign Agent </h5>
									<?php 
										if(!empty($mapticketdata)){
											if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
											$agentuserdata 	= $this->user_model->_getUserByKeyValue('id',$mapticketdata->agent_id,'4');
											$agentdetail 	= $this->user_model->getDataBykey('nw_agent_tbl','user_id',$agentuserdata->id);
											$agentemail = !empty($agentuserdata)?$agentuserdata->email:'';
											$agentname 	= !empty($agentdetail)?$agentdetail->name:'';
									?>
										<p><?php  echo $agentname .' ( '.$agentemail.' )'; ?></p>
									<?php }else{ ?>
										<p>No Agent Assigned</p>
									<?php }}else{ ?>
										<p>No Agent Assigned</p>
									<?php } ?>
                                </div>                           
                            </div>
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Previous Assign Agent Date</h5>
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
								<div class="form-group inputBox <?php echo !empty($ticket->custom_id)?'focus':'' ?> ">
									<?php
										echo form_label('Ticket Id', 'ticket_id');
										echo form_input(array('name' => 'ticket_id', 'class' => 'form-control input', 'value' => $ticket->custom_id, 'id' => "ticket_id", 'readonly' => 'true'));
										echo form_input(array('name' => 'customer_id', 'type' => 'hidden', 'class' => 'form-control', 'value' => $ticket->customer_id, 'id' => "customer_id", 'readonly' => 'true'));
										echo '<div class="error-msg">' . form_error('ticket_id') . '</div>';
									?>
								</div>
                            </div>
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($ticket->category_name)?'focus':'' ?> ">
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
								<?php 
									$subcatname = '';
									if(!empty($ticket->subcategory_id)){
										$subcategorydata = $this->category_model->get_category_data($ticket->subcategory_id);
										$subcatname = $subcategorydata->name;
									}
								?>
								<div class="form-group inputBox <?php echo !empty($subcatname)?'focus':'' ?> ">
									<?php
										echo form_label('Ticket Subcategory', 'sub_category_name');
										echo form_input(array('name' => 'sub_category_name',
											'class' => 'form-control input',
											'value' => $subcatname,
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
												echo form_label('Reassign Agent Name*', 'agent_id');
											}else{
												echo form_label('Agent Name*', 'agent_id');
											}
										}else{
											echo form_label('Agent Name*', 'agent_id');
										}
										$option = array("" => "Select Agent");
										if(!empty($categorywiseagent)){
											foreach ($categorywiseagent as $agentlist) {
												$agentuserid 	= $agentlist->user_id;
												$agentuserdata 	= $this->user_model->_getUserByKeyValue('id',$agentuserid,'4');
												if($agentlist->category_id == $ticket->categoryid){
													if(!empty($mapticketdata)){
														if($agentlist->user_id != $mapticketdata->agent_id){
															$option[$agentlist->user_id] = ucfirst($agentlist->name) .' ( '. $agentuserdata->email .' ) ';
														}
													}else{
														$option[$agentlist->user_id] = ucfirst($agentlist->name) .' ( '. $agentuserdata->email .' ) ';
													}
												}
											}
										}else{
											$option[''] = 'No Agent mapped.';
										}
										if(!empty($mapticketdata)){
											if($mapticketdata->ticket_status != 90 && $mapticketdata->ticket_status != 91 && $mapticketdata->ticket_status != 92){
												echo form_dropdown('agent_id', $option, set_value('agent_id',$mapticketdata->agent_id), 'class="form-control input" id="agent_id"');	
											}else{
												echo form_dropdown('agent_id', $option, set_value('agent_id'), 'class="form-control input" id="agent_id"');
											}
										}else{
											echo form_dropdown('agent_id', $option, set_value('agent_id'), 'class="form-control input" id="agent_id"');
										}
										echo '<div class="error-msg">' . form_error('agent_id') . '</div>';
									?>
								</div>
                            </div>
                          <?php /*  <div class="form-group col-6">
                                <?php
									echo form_label('Start Date*', 'assign_date');
									echo form_input(array('name' => 'assign_date', 'class' => 'form-control datepicker', 'value' => set_value('assign_date'), 'id' => "agent_assign_date", 'placeholder' => 'Assign Date','readonly'=>'readonly'));
									echo '<div class="error-msg">' . form_error('assign_date') . '</div>';
                                ?>
                            </div> */ ?>
                            <div class="col-6">
								<div class="form-group inputBox <?php echo !empty($ticket->description)?'focus':'' ?>">
									<?php
										echo form_label('Ticket Description', 'description');
										echo form_textarea(array('name' => 'description',
											'class' 	=> 'form-control input',
											'value' 	=> set_value('description', $ticket->description),
											'id' 		=> "description",
											'cols' 		=> '4',
											'rows' 		=> '4',
											'disabled' 	=> 'disabled',
										));
										echo '<div class="error-msg">' . form_error('description') . '</div>';
									?>
								</div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "assign_tkt_btn", "value" => "Submit"));
										echo '&nbsp;&nbsp;<a href="' . base_url('/ticket/servicelist/?status=20') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>