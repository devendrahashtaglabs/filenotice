<div class="content-wrapper dashboardit">
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
                            <i class="fa fa-users"></i>
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
                            <i class="fa fa-user"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
 
                <div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $ticketList['count']; ?></h3>
                            <p>New Request Service</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-align-center"></i>
                        </div>
                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/ticket_list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
				<div class="col-lg-3 col-6 mobiledesign">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?php echo $assignedTicket; ?></h3>
                            <p>Under Process Service</p>
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
                            <p>Completed Service</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-check"></i>
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
                                    <h3 class="card-title">Customer List <small>(<?=$fiveCustomers['count'];?> new customers)</small></h3>
                                    <div class="card-tools">
										 <span class="viewall btn btn-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list'); ?>" class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
									<div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th style="text-align: center;">Status</th>
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
                                    <h3 class="card-title">Consultant List <small>(<?=$fiveConsultant['count'];?> new consultant)</small></h3>
                                    <div class="card-tools">
										<span class="viewall btn btn-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/consultant/consultant_list'); ?>" class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
								  <div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th style="text-align: center;">Status</th>
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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header no-border">
                                    <h3 class="card-title">Ticket List <small>(<?=$fiveTicket['count'];?> new tickets)</small></h3>
                                    <div class="card-tools">
										<span class="viewall btn btn-primary"><a href="<?php echo base_url($this->session->userdata('admins')['user_type']. '/ticket/ticket_list'); ?>"  class="small-box-footer" style="color:#fff">
										 View all</a></span>
                                    </div>
                                </div>
                                <div class="card-body p-0">
								  <div class="table-responsive">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th style="width: 160px;">Ticket Id</th>
                                                <th>Description</th>
                                                <th style="text-align: center; width: 100px;">Status</th>
                                            </tr>
                                        </thead>
                                    <?php echo $fiveTicket['html'];?>
                                    </table>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
<div class="row">
    <div class="col-lg-4">
        <div class="card latest-update-card">
            <div class="card-header no-border">
                <h3 class="card-title">Ticket List <small>(5 new tickets)</small></h3>
                <div class="card-tools">
                    <span class="viewall btn btn-primary"><a href="https://filenotice.com/admin/ticket/ticket_list" class="small-box-footer" style="color:#fff">
                     View all</a></span>
                </div>
            </div>
            <div class="card-body p-0 card-block">
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 290px;"><div class="scroll-widget" style="overflow: hidden; width: auto; height: 290px;">
<div class="latest-update-box">
<div class="row p-t-20 p-b-30">
<div class="col-auto text-right update-meta p-r-0">
<i class="feather fa fa-suitcase bg-c-red update-icon"></i>
</div>
<div class="col p-l-5">
<a href="#!"><h6>You have 3 pending Task.</h6></a>
<p class="text-muted m-b-0">Hemilton</p>
</div>
</div>
<div class="row p-b-30">
<div class="col-auto text-right update-meta p-r-0">
<i class="feather fa fa-suitcase bg-c-red update-icon"></i>
</div>
<div class="col p-l-5">
<a href="#!"><h6>You have 3 pending Task.</h6></a>
<p class="text-muted m-b-0">Hemilton</p>
</div>
</div>
<div class="row p-b-30">
<div class="col-auto text-right update-meta p-r-0">
<i class="feather fa fa-check bg-c-green update-icon"></i>
</div>
<div class="col p-l-5">
<a href="#!"><h6>New Order Received.</h6></a>
<p class="text-muted m-b-0">Hemilton</p>
</div>
</div>
<div class="row p-b-30">
<div class="col-auto text-right update-meta p-r-0">
<i class="feather fa fa-suitcase bg-c-red update-icon"></i>
</div>
<div class="col p-l-5">
<a href="#!"><h6>You have 3 pending Task.</h6></a>
<p class="text-muted m-b-0">Hemilton</p>
</div>
</div>
<div class="row p-b-30">
<div class="col-auto text-right update-meta p-r-0">
<i class="feather icon-briefcase bg-c-red update-icon"></i>
</div>
<div class="col p-l-5">
<a href="#!"><h6>You have 3 pending Task.</h6></a>
<p class="text-muted m-b-0">Hemilton</p>
</div>
 </div>

</div>
</div><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 186.475px;"></div><div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>








              
            </div>
        </div>
    </div>
</div>



                </div>
            </div>
        </div>
    </section>
</div>