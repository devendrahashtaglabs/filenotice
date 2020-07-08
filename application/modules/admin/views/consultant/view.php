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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo $page_title; ?>
                            <a class="back-btn btn btn-info white-icon" onclick="window.history.back();" style="float:right;"><i class="fa fa-arrow-left"></i> Back</a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
							<?php 
							if(!empty($row->account_type)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
										<h5>Account Type</h5>
										<p>
											<?php 
												if($row->account_type == 'freelancer'){
													echo 'Freelancer';
												}else{
												  echo 'Agency';
												} 
											?>
										</p>
									</div>							   
								</div>
                            <?php } if(!empty($row->name)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Consultant Name</h5>
									<p><?php echo !empty($row->name)?$row->name:'NA';?></p>
									</div>
									
								</div>
							<?php } if(!empty($row->email)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Email address</h5>
									<p><?php echo !empty($row->email)?$row->email:'NA'; ?></p>
									</div>                               
								</div>
							<?php } if(!empty($row->mobile)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Mobile Number</h5>
									<p><?php echo !empty($row->mobile)?$row->mobile:'NA'; ?></p>
									</div>
									
								</div>
							<?php }if(!empty($row->gender)){ ?>
								<div class="col-4">
									  <div class="ticketmanagement">
									<h5>Gender</h5>
									<p><?php if($row->gender == 1){
										echo 'Male';
									}else{
									  echo 'Female';  
									}?></p>
									</div>
									
								</div>
							<?php }if(!empty($row->status)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Status</h5>
									<p><?php if($row->status == 1){
										echo 'Active';
									}else{
									  echo 'Inactive';  
									}?></p>
									</div>
								</div>
                            <?php } if(!empty($row->dob)){ ?>
								<div class="col-4">
									 <div class="ticketmanagement">
									<h5>Date Of Birth</h5>
									<?php if($row->dob=="") { ?>
												<p></p>
									  <?php } else { ?>
												 <p><?php echo date('d-m-Y',strtotime($row->dob)); ?></p>
									  <?php } ?>
									</div>
									
								</div>
							<?php }if(!empty($row->zip)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Pin Code</h5>
									<p><?php echo !empty($row->zip)?$row->zip:'NA'; ?></p>
									</div>
								</div>
							<?php }if(!empty($row->city_id)){
								$cityquery = $this->user_model->getCityList($row->city_id,'');
							?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>City</h5>
									<p><?php echo !empty($cityquery)?$cityquery->city_name:'NA'; ?></p>
									</div>                               
								</div>
							<?php } ?>
							<?php if(!empty($row->stateName)){ ?>
								<div class="form-group col-4">
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
							<?php if(!empty($row->countryName)){ ?>
								<div class="form-group col-4">
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
							<?php if(!empty($row->address)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Address</h5>
									<p><?php echo $row->address.', '.$row->stateName.', '.$row->countryName; ?></p>
									</div>
								</div>
							<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Other Informations</h3>
                        </div>
                        <?php echo form_open_multipart($pageUrl, array('class' => 'other_info')); ?>
                        <div class="card-body">
                            <div class="row">
							<?php if(!empty($row->category_name)){ ?>
								<div class="col-4">
									 <div class="ticketmanagement">
									<h5>Category Name</h5>
									<p><?php echo !empty($row->category_name)?$row->category_name:'NA'; ?></p>
									</div>
								  
								</div>
                            <?php }if(!empty($row->subcategory_id)){ ?>
								<div class="col-4">
									 <div class="ticketmanagement">
									<h5>Subcategory Name</h5>
									<?php 
										$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
									?>
									<p><?php echo !empty($subcategorydata)?$subcategorydata->name:'NA'; ?></p>
									</div>
								  
								</div>
                            <?php }if(!empty($row->telephone)){ ?>
								<div class="col-4">
									 <div class="ticketmanagement">
									<h5>Contact Number</h5>
									<p><?php echo !empty($row->telephone)?$row->telephone:'NA'; ?></p>
									</div>
								</div>
							<?php }if(!empty($row->aadhaar_card_number)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Aadhar Number</h5>
									<p><?php echo !empty($row->aadhaar_card_number)?$row->aadhaar_card_number:'NA'; ?></p>
									</div>
								</div>
							<?php }if(!empty($row->pan_card_number)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
										<h5>Pan Number</h5>
										<p><?php echo !empty($row->pan_card_number)?$row->pan_card_number:'NA'; ?></p>
									</div>
								</div>
							<?php }if(!empty($expertise)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
									<h5>Expertise</h5>
									<p><?php echo !empty($expertise)?$expertise:'NA'; ?></p>
									</div>
								</div>
							<?php }if(!empty($row->qualification_name)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
										<h5>Qualification</h5>
										<?php 
											$qualificationData = $this->user_model->getallqualification($row->education);
										?>
										<p><?php echo (empty($qualificationData->qualification_name)? 'NA' : $qualificationData->qualification_name); ?></p>
									</div>
								</div>
							<?php }if(!empty($row->subquali_name)){ ?>
								<div class="col-4">
									<div class="ticketmanagement">
										<h5>Sub Qualification</h5>
										<?php 
											$subqualificationData = $this->user_model->getallsubqualification($row->sub_education);
										?>
										<p><?php echo (empty($subqualificationData->subquali_name)? 'NA' : $subqualificationData->subquali_name); ?></p>
									</div>                                
								</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
			<div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Public Profile Section</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
							<?php if(!empty($row->banner_image) || !empty($row->company_name) || !empty($row->company_address) ){ ?>
								<div class="col-4">
									<?php if(!empty($row->banner_image)){ ?>
										<div class="ticketmanagement">
											<h5>Banner Image</h5>
											<p><img src="<?php echo FRONTEND_URL . 'uploads/consultant/banners/' .$row->banner_image; ?>" alt="Banner Image"class="img-responsive" width="50" height="50" /></p>
										</div>
									<?php }if(!empty($row->company_name)){ ?>
										<div class="ticketmanagement">
											<h5>Company Name</h5>
											<p><?php echo !empty($row->company_name)?$row->company_name:'NA'; ?></p>
										</div>							  
									<?php }if(!empty($row->company_address)){ ?>
										<div class="ticketmanagement">
											<h5>Company Address</h5>
											<p><?php echo !empty($row->company_address)?$row->company_address:'NA'; ?></p>
										</div>
									<?php } ?>
								</div>
								<div class="col-8">
                            <?php }else{ ?>
								<div class="col-12">
							<?php } ?>
									<?php if(!empty($row->about_consultant)){ ?>
									<div class="ticketmanagement" style="min-height:150px;">
										<h5>About Consultant</h5>
										<p><?php echo !empty($row->about_consultant)?$row->about_consultant:'NA'; ?></p>
									</div>
									<?php } ?>
								</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
