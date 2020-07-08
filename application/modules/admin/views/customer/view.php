<style>
.ticketmanagement {
    margin: 0 0 15px;
    float: left;
    width: 100%;
    background: #eee;
    border-radius: 4px;
    padding: 10px 15px;
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?php echo $page_title; ?>
							<div class="pull-right">
								<?php
									echo '<a class="back-btn btn btn-info white-icon" href="' . base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list') . '" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</a>&nbsp;&nbsp;';
								?>
							</div>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
							<?php if(!empty($row->name)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Name</h5>
										<p><?php echo !empty($row->name)?$row->name:''; ?></p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->email)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Email Address</h5>
										<p><?php echo !empty($row->email)?$row->email:''; ?></p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->mobile)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Mobile Number</h5>
										<p><?php echo !empty($row->mobile)?$row->mobile:''; ?></p>
									</div>
								</div>
							<?php } ?>
							<?php 
							if(!empty($row->dob)) { ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Date Of Birth</h5>
										<p><?php echo date('d-m-Y', strtotime($row->dob)); ?></p>
									</div>
								</div>
							<?php } ?>  
							<?php if(!empty($row->gender)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Gender</h5>
										<p>
										<?php
											if ($row->gender == 1) {
												$gender = 'Male';
											} elseif($row->gender == 2 ) {
												$gender = 'Female';
											}else{
												$gender = 'Other';
											}
											echo  $gender;											 
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->userstatus)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Status</h5>
										<p>
										<?php 
											if ($row->userstatus == 0) {
												$status = 'Inactive';
											} else {
												$status = 'Active';
											}
											echo $status ;
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->countryName)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Country</h5>
										<p>
										<?php 
											echo $row->countryName ;
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->stateName)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>State</h5>
										<p>
										<?php 
											echo $row->stateName ;
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							<?php 
								if(!empty($row->city_id)){ 
								$cityquery = $this->user_model->getCityList($row->city_id,'');
							?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>City</h5>
										<p>
										<?php 
											echo !empty($cityquery)?$cityquery->city_name:'';
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							<?php if(!empty($row->zip)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Pin Code</h5>
										<p>
										<?php 
											echo $row->zip ;
										?>
										</p>
									</div>
								</div>
							<?php } ?>
							
							<?php if(!empty($row->address)){ ?>
								<div class="form-group col-6">
									<div class="ticketmanagement">
										<h5>Address</h5>
										<p>
											<?php 
												echo $row->address ;
											?>
										</p>
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
