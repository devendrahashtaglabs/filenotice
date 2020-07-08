<style>
	.star-rating .fa-star{color: #FEC963;}
	.star .fa-star{color: #FEC963;}
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
			if($this->session->flashdata('responce_msg')!=""){
				$message = $this->session->flashdata('responce_msg');
				echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
			}
		?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title; ?></h3></div>
                    </div>
                    <div class="card-body manage-listd">
                        <div class="table-responsive customizetableres">
                        <table id="table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Consultant</th>
                                    <th>Ticket Id</th>
                                    <th>Category</th>
                                    <th><?php if($this->session->userdata('users')['user_type'] == "consultant"){ ?> Remark <?php }else{ ?>Description<?php } ?></th>
                                    <th>Start Date</th>
                                    <th>Close Date</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <?php 
								if($this->session->userdata('users')['user_type'] != "consultant"){    
                            ?>
                                <tbody>
                                <?php
									$a = 1;
									foreach ($tickets['data'] as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo isset($row->consultant_name)?$row->consultant_name:''; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo $row->category_name; ?></td>
                                        <td style="word-break: break-all;"><?php echo substr($row->description, 0, 20).'...'; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($row->start_date)); ?></td>
										<?php 
											//echo "<pre>";print_r($row);echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
											$close_date = !empty($row->close_date)? date('d-m-Y', strtotime($row->close_date)) : '';
										?>
                                        <td><?php echo $close_date; ?></td>
                                        <td>
                                            <?php 
												$rating = $this->ticket_model->get_rating($row->ticket_id, $row->customer_id, $row->consultant_id); 
												if(count($rating) > 0) {
													$per = $rating[0]->rating*100/5; 
													echo '<div class="ratings">
													<div class="empty-stars"></div>
													<div class="full-stars" style="width:'.$per.'%"></div>
													</div>';
												} else { 
											?>                                            
                                            <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#feedbackModal<?php echo $row->ticket_id; ?>" style="color:#fff">Rate <i class="fa fa-star-o"></i></a>
                                            
                                            <div class="modal fade" id="feedbackModal<?php echo $row->ticket_id; ?>" role="dialog">
                                            <div class="modal-dialog" style="max-width:50%">
                                              <!-- Modal content -->
												<form method="post" id="ratingForm<?php echo $row->ticket_id; ?>" onsubmit="return confirm_rating('<?php echo base_url('ticket/feedback'); ?>', <?php echo $row->ticket_id; ?>);">
												  <div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title star-rating" style="float:left;">Rating & Review &nbsp; &nbsp; </h4>
														
													  <button type="button" class="close" data-dismiss="modal">&times;</button>
													  
													</div>
													  
													<div class="modal-body" id="feedbackModal<?php echo $row->ticket_id; ?>">
													  <div class="row">
														  <?php    
															if(!empty($row->consultant_photo)) {
																$Profile_img = base_url().'uploads/profile/'.$row->consultant_photo;
															}else{
																$Profile_img = base_url().'uploads/profile/no_image_available.jpeg';
															}
															clearstatcache();
														  ?>
														  
														  <table class="table table-hover">
															  <tr><td rowspan="4" width="25%" class="sutomfile">
																	  <?php if(empty($row->consultant_photo)) { echo '<img src="'.$Profile_img.'" style="width:100%;" />'; } else { echo '<img src="'.$Profile_img.'" />'; } ?>
																  </td>
																  <th>Name:</th><td><?php echo $row->consultant_name; ?></td> 
																  
															  </tr>
															  <tr><th>Email:</th><td><?php echo $row->consultant_email; ?></td></tr>
															  <tr><th>Mobile:</th><td><?php echo $row->consultant_mobile; ?></td></tr>
															   <tr><th>Rate:</th><td><h4 class="star-rating">
																		   <span class="fa fa-star-o" data-rating="1"></span>
														<span class="fa fa-star-o" data-rating="2"></span>
														<span class="fa fa-star-o" data-rating="3"></span>
														<span class="fa fa-star-o" data-rating="4"></span>
														<span class="fa fa-star-o" data-rating="5"></span> 
																<input type="hidden" name="rating" class="rating-value" value="0">
													   <input type="hidden" name="ticket_id" value="<?php echo $row->ticket_id; ?>">
													   <input type="hidden" name="customer_id" value="<?php echo $row->customer_id; ?>">
													   <input type="hidden" name="consultant_id" value="<?php echo $row->consultant_id; ?>">       
																	   </h4></td></tr>
														  </table>
														
													   
													  <div class="item form-group" style="width:100%">
																<textarea id="remark" name="remark" placeholder="Enter Remark" class="form-control"></textarea>
														 </div>
													 </div>

												  </div>

													<div class="modal-footer" style="text-align: center;">
													  <input type="submit" name="submit" class="btn btn-primary" value="Submit">
														<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													</div>
												  </div>
												</form>

											</div>
											</div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $a++;
                                } ?>
                            </tbody>
                            <?php
								}else{
                            ?>
                            <tbody>
                                <?php 
                                    $a = 1; 
                                    foreach($tickets as $row){                                        
										$ticketData = $this->ticket_model->get_ticket_data($row->ticket_id);
										$consultantData = $this->user_model->getconsultantdetail($row->consultant_id);
										//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
                                ?>
                                
                                <tr>
                                    <td><?php echo $a; ?></td>
                                    <td><?php echo isset($consultantData->name)?$consultantData->name:''; ?></td>
                                    <td><?php echo $ticketData->ticket_id; ?></td>
                                    <td><?php echo $this->category_model->get_category_data($ticketData->category_id)->name; ?></td>
                                    <td><?php echo $row->review; ?></td>
                                    <td><?php echo date('d-m-Y',strtotime($ticketData->start_date)); ?></td>
                                    <td><?php echo  date('d-m-Y',strtotime($ticketData->close_date)); ?></td>
                                    <td>
                                        
                                        <?php 
											$rating = $this->ticket_model->get_rating($row->ticket_id, $row->customer_id, $row->consultant_id); 
                                            if(count($rating) > 0) {
												$per = $rating[0]->rating*100/5; 
												echo '<div class="ratings">
													<div class="empty-stars"></div>
													<div class="full-stars" style="width:'.$per.'%"></div>
													</div>';
											}
                                        ?>
                                        
                                    </td>
                                </tr>
                                
                                <?php
                                $a++;
                                    }
                                ?>
                                
                            </tbody>
                            <?php } ?>
                        </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

