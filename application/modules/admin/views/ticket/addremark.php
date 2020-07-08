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
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                    <?php
						echo form_open($pageUrl.'/addremark/'.$response->ticket_id, array('class' => 'Addremarkform', 'id' => 'Addremarkform'));
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
									<h5>Ticket ID </h5>
									<p><?php echo !empty($response->customId)?$response->customId:''; ?></p>
                                </div>                           
                            </div>
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Customer Name</h5>
									<p><?php echo !empty($response->name)?ucfirst($response->name):''; ?></p>
                                </div>                           
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Customer Email</h5>
									<p><?php echo !empty($response->customeremail)?$response->customeremail:''; ?></p>
                                </div>                           
                            </div>
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Customer Phone</h5>
									<p><?php echo !empty($response->mobile)?$response->mobile:''; ?></p>
                                </div>                           
                            </div>
						</div>
						<div class="row">
							<div class="col-6">
                                <div class="ticketmanagement ticketid">
									<h5>Customer Remark</h5>
									<p><?php echo !empty($response->customer_remark)?$response->customer_remark:''; ?></p>
                                </div>                           
                            </div>
                            <div class="form-group col-6">
								<div class="ticketmanagement ticketid">
									<h5>Updated At</h5>
									<p><?php echo date('d-m-Y H:i:s',strtotime($response->modified_at)); ?></p>
                                </div> 
							</div>
						</div>
						<div class="row">
                            <div class="col-12">
								<div class="form-group inputBox focus">
									<?php
										echo form_label('Admin Remark *', 'admin_remark');
										echo form_textarea(array('name' => 'admin_remark',
											'class' => 'form-control input',
											'value' => set_value('admin_remark', $response->admin_remark),
											'id' 	=> "admin_remark",
											'cols' 	=> '4',
											'rows' 	=> '4',
										));
										echo '<div class="error-msg">' . form_error('admin_remark') . '</div>';
									?>
								</div>
                            </div>
                        </div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<?php
										echo form_submit(array("class" => "btn btn-primary", "id" => "assign_tkt_btn", "value" => "Submit"));
										echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type'].'/ticket/customer_request') . '" class="btn btn-default">Cancel</a>';
									?>
								</div>
							</div>
						</div>                        
                    </div>
				<?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>