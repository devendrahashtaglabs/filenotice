<style type="text/css">
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
    min-width: 122px;
}	
.customizetableres tr th, .customizetableres tr td{
	padding: 5px;
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title; ?></h3></div>
                    </div>
                    <div class="card-body">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
						<div class="fileterdata">							
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom4"></div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="completemin" id="completemin" type="text" placeholder="Start Date">
							</div>
							<div class="filter Filterstatus FilterCustom7">
								<input class="form-control" name="completemax" id="completemax" type="text" placeholder="End Date">
							</div>
						</div>
						
							
						
                        <div class="table-responsive customizetableres">
                        <table id="completed_table_id" class="table table-bordered table-striped" style="margin-top: 20px; width: 100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Consultant</th>
									<th style="display:none;">Consultant Name</th>
									<th style="display:none;">Consultant Email</th>
									<th style="display:none;">Consultant Mobile</th>
									<th>Ticket Id</th>
									<th>Category / Subcategory</th>
									<th style="display:none;">Category</th>
									<th style="display:none;">Subcategory</th>
									<th>State / City</th>
									<th style="display:none;">State</th>
									<th style="display:none;">City</th>
									<?php /* <th>Description</th> */ ?>
									<th style="">Remark</th>
									<th>Rating</th>
									<th style="display:none;">Rating</th>
									<th style="text-align: center;">Status</th>
									<th>Completed Date</th>
									<th>Action</th>
								</tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($tickets['data'] as $row) {
										$remark = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
										if(!empty($remark)){
											$ReviewData =  $remark->review; 
										}else{
											$ReviewData = 'NA';
										}
										$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
										$consultantalldata  = $this->ticket_model->getthedata('user_id',$row->consultant_id,'nw_consultant_tbl');
										$useralldata  = $this->ticket_model->getthedata('id',$row->consultant_id,'nw_user_tbl');
										$consultantdata 	= $consultantalldata[0];
										$userdata 			= $useralldata[0];
										$subcatename 		= !empty($subcategorydata)?$subcategorydata->name:'';
										$statedata 			= $this->user_model->getStateList($row->customer_state,'');
										$citydata 			= $this->user_model->getCityList($row->customer_city,'');
										//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo $consultantdata->name .'<br/>'. $userdata->email .'<br/>'.$consultantdata->mobile; ?></span></td>
                                        <td	style="display:none;"><?php echo $consultantdata->name; ?></td>
                                        <td	style="display:none;"><?php echo $userdata->email; ?></td>
                                        <td	style="display:none;"><?php echo $consultantdata->mobile; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><span style="word-break: break-all; display: block; width:128px; word-wrap: break-word;"><?php echo $row->category_name .' / '.$subcatename; ?></span></td>
                                        <td style="display:none;"><?php echo $row->category_name; ?></td>
                                        <td style="display:none;"><?php echo $subcatename; ?></td>
										<?php 
											$state_name = !empty($statedata)?$statedata->name:'NA';
											$city_name = !empty($citydata)?$citydata->city_name:'NA';
										?>
										<td><?php echo $state_name .' / '.$city_name; ?></td>
                                        <td style="display:none;"><?php echo $state_name; ?></td>
                                        <td style="display:none;"><?php echo $city_name; ?></td>
                                        <?php /*<td style="word-break: break-all;"><?php echo substr($row->description, 0, 20).'...'; ?></td> */?>
                                        <td>
                                            <span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo $ReviewData; ?></span>
                                        </td>
										<?php 
											$ratingArray = $this->customer_model->get_rating_by_ticketid($row->ticket_id); 
										?>
                                        <td>
											<?php 
											if(!empty($ratingArray)){
											   $rating = $ratingArray->rating;
											}else{
												$rating = 0;
											}
											
											if($rating == '') { $rating = 0; }
											   $per = $rating*100/5; echo '<div class="ratings">
													<div class="empty-stars"></div>
													<div class="full-stars" style="width:'.$per.'%"></div>
													</div>'; 
											?>
                                        </td>
                                        <td style="display:none;"><?php echo !empty($ratingArray)?$ratingArray->rating:'0'; ?></td>
                                        <td class="statustd">
                                        <?php if($row->ticket_status == 90){ ?>
                                            <span class="float-left badge bg-danger">Completed</span>
                                        <?php } else { ?>
											 <span class="float-left badge bg-danger">Cancelled</span>
                                        <?php } ?>
                                            <?php 								  //print_r($this->customer_model->get_rating_by_ticketid($row->ticket_id));
                                                $statusArray = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
                                                
                                                if(!empty($statusArray)){
                                                    $statusData = $statusArray->status;
                                                }else{
                                                    $statusData = 0;
                                                }
                                                
                                                $statusRes = __getStatus($statusData, 'float-left'); 
                                                //echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
                                            ?></td>
										<td>
											<?php echo date('d-m-Y',strtotime($row->modified)); ?>
										</td>
                                        <td class="actionrow">
                                        	<div class="atbtnset">
                                            <?php 
                                                $TicketData = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
                                                if(isset($TicketData)){
												$ticket_id_data = $this->customer_model->get_rating_by_ticketid($row->ticket_id);
                                            ?>
											<a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/view/'.$row->ticket_id); ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>
                                            <?php /*<a data-action="status" class="toChange" 
                                            data-url=
                                            "<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/update_ratingStatus');?>" 
                                            data-id=
                                            "<?php echo !empty($ticket_id_data)?$ticket_id_data->id:''; ?>"
                                            data-status =
                                            "<?php echo !empty($ticket_id_data)?$ticket_id_data->status:''; ?>"
                                            data-massege ="Are you sure want to change!" title="Update Status" href="javascript:;">
												<?php
													if(!empty($ticket_id_data)){
														echo ($ticket_id_data->status == 0) ? '<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>':'<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>';
													}else{
														echo '<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>';
													}
												?>
											</a> */ ?>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        </td>
                                    </tr>
                                    <?php $a++;
                                } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>