<style>
.col-lg-3.col-6.mobiledesign {
	width: 20%;
	max-width: 20%;
	flex: 0 0 25%;
}
.small-box > .inner {
	min-height: 115px;
}
</style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-success"><?php echo isset($welcome_title)?$welcome_title:''; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php //echo $breadcrumb; ?>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $customersList; ?></h3>
                            <p>Active Customer</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $consultList; ?></h3>
                            <p>Active Consultant</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
 
                <div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $ticketList['count']; ?></h3>
                            <p>Unassigned Ticket</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/ticket_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				<div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $assignedTicket; ?></h3>
                            <p>Assigned Ticket</p>
                        </div>
                        <div class="icon">
							<i class="fa fa-ticket"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/assign_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo $completeTicket; ?></h3>
                            <p>Completed Ticket</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/completed_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				
            </div>
            <div class="content">
                <div class="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h3 class="card-title">Customer List</h3>
                                    <div class="card-tools">
										 <span data-toggle="tooltip" title="5 New Customers" class="badge badge-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list'); ?>" class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                        <span data-toggle="tooltip" title="5 New Customers" class="badge badge-primary"><?=$fiveCustomers['count'];?></span>
                                        <button type="button" class="btn btn-tool" data-widget="collapse">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
									<div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th style="text-align: right">Status</th>
                                            </tr>
                                        </thead>
                                    <?php echo $fiveCustomers['html'];?>
                                    </table>
 								   </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h3 class="card-title">Consultant List</h3>
                                    <div class="card-tools">
										<span data-toggle="tooltip" title="5 New Customers" class="badge badge-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list'); ?>" class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                        <span data-toggle="tooltip" title="5 New Consultant" class="badge badge-primary"><?=$fiveConsultant['count'];?></span>
                                        <button type="button" class="btn btn-tool" data-widget="collapse">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
								  <div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th style="text-align: right">Status</th>
                                            </tr>
                                        </thead>
                                    <?php echo $fiveConsultant['html'];?>
                                    </table>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h3 class="card-title">Ticket List</h3>
                                    <div class="card-tools">
										<span data-toggle="tooltip" title="5 New Customers" class="badge badge-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/ticket_list'); ?>"  class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                        <span data-toggle="tooltip" title="5 New Ticket" class="badge badge-primary"><?=$fiveTicket['count'];?></span>
                                        <button type="button" class="btn btn-tool" data-widget="collapse">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0">
								  <div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Ticket Id</th>
                                                <th>Description</th>
                                                <th style="text-align: right">Status</th>
                                            </tr>
                                        </thead>
                                    <?php echo $fiveTicket['html'];?>
                                    </table>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>