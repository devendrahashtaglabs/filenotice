<style>
.tooltipz {
  position: relative;  
}

/* Tooltip text */
.tooltipz .tooltiptext {
    visibility: hidden;
    width: 100%;
    background-color: #5a5a5a;
    color: #fff;
    text-align: center;
    padding: 5px 5px;
    border-radius: 6px;
    position: absolute;
    z-index: 1;
    bottom: 85%;
    left: 0;
    opacity: 0;
    transition: opacity 0.3s;
    box-shadow: 0 0 black;
    right: 0;
}

/* Tooltip arrow */
.tooltipz .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltipz:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
.ticketslistr .modal-dialog {
	max-width: 800px;
	margin: 1.75rem auto;
}
.ticketslistr .valuetext {
	font-size: 15px;
	margin: 0 0 10px;
}
.ticketslistr .modal-body{
	background: #f4f4ff;
}
.ticketslistr .text.mainn label {
	font-size: 14px;
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title; ?></h3></div>
                       <?php  if($this->session->userdata('users')['user_type'] != 'consultant') { ?> <div class="float-right"><a href="<?php echo $pageUrl.'/choose_category'; ?>" class="btn btcreaten-block btn-primary"><i class="fa fa-plus"></i> Add Ticket</a></div> <?php } ?>
                    </div>
                    <div class="card-body manage-listd ">
						<?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
						<div class="fileterdata ">
							<div class="filter Filterstatus FilterCustom1"></div>
							<div class="filter Filterstatus FilterCustom2"></div>
							<div class="filter Filterstatus FilterCustom3"></div>
							<div class="filter Filterstatus FilterCustom4"></div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
                            </div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
                            </div>
						</div>
						<?php /*<div class="row mb-2">
							<div class="col-md-1 col-xs-12 filter-text">Filter : </div>
							<div class="col-md-2 col-xs-12"><div class="customfilter"></div></div>
						</div> */?>
                        <div class="table-responsive customizetableres">
                        <table id="ticket_table_id" class="table table-bordered table-striped" style="margin-top: 20px;" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <!--<th>Description</th> -->
                                    <th style="display:none;">Description</th>
									<th>State</th>
									<th>City</th>
                                    <th>Created Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th style="display:none;">Ticket Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($tickets['data'] as $row) {
										$subcatname = '';
										if(!empty($row->subcategory_id)){
											$subcatdata = $this->category_model->get_category_data($row->subcategory_id);
											$subcatname = $subcatdata->name;
										}
										$statequery = $this->user_model->getStateList($row->customer_state,'');
										$statename 	= !empty($statequery)?$statequery->name:'NA';
										$cityquery 	= $this->user_model->getCityList($row->customer_city,'');
										$cityname 	= !empty($cityquery)?$cityquery->city_name:'NA';
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo $row->category_name; ?></td>
                                        <td><?php echo $subcatname; ?></td>
                                       <?php /* <td style="word-break: break-all;" class="tooltipz"><?php echo ($row->description!='')?substr($row->description, 0, 20).'...':DEFAULT_VALUE; ?>

                                         <span class="tooltiptext"><?php echo $row->description; ?></span>
                                        </td> */ ?>
										<td style="display:none;"><?php echo isset($row->description)?$row->description:''; ?></td>
										<td><?php echo $statename; ?></td>
										<td><?php echo $cityname; ?></td>
                                        <td><?php echo ($row->created!='')?date('d-m-Y',strtotime($row->created)):DEFAULT_VALUE;?></td>
                                        <td><?php $statusRes= __getStatus($row->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
                                        <td class="actionrow">
                                            <div class="atbtnset">
												<?php //echo ($row->mapstatus==='true')?'<a href="javascript:;"><span class="float-left badge bg-success" style="margin-right: 25px;">Assigned</span></a>':'';?>
												<?php 
													if($row->mapstatus==='true'){
														if($row->ticket_status == '20'){
															echo '<a href="javascript:;"><span class="float-left badge bg-success" style="margin-right: 25px;">Assigned</span></a>';
														}elseif($row->ticket_status == '21'){
															echo '<a href="javascript:;"><span class="float-left badge bg-success" style="margin-right: 25px;">Response Awaited</span></a>';
														}elseif($row->ticket_status == '30'){
															echo '<a href="javascript:;"><span class="float-left badge bg-warning" style="margin-right: 25px;">Hold</span></a>';
														}elseif($row->ticket_status == '90'){
															echo '<a href="javascript:;"><span class="float-left badge bg-danger" style="margin-right: 25px;">Completed</span></a>';
														}elseif($row->ticket_status == '91'){
															echo '<a href="javascript:;"><span class="float-left badge bg-danger" style="margin-right: 25px;">Cancelled</span></a>';
														}
													}
												?>
												<a href="<?php echo $pageUrl.'/view/'.$row->id; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;
												<?php if($row->mapstatus==='false'){ ?>
													<a href="<?php echo $pageUrl.'/edit/'.$row->id; ?>" title="Edit Ticket"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
													<?php /*<a data-action="status" class="toChange" data-url="<?php echo $pageUrl.'/update';?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure want to change!" title="Update Status" href="javascript:;">
														<?php echo ($row->status == 1) ? '<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>':'<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>';?>
													</a>&nbsp; */?>
													<a href="javascript:;" data-action="delete" class="toChange" data-url="<?php echo $pageUrl.'/update';?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure want to delete!" title="Delete Ticket"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
												<?php } ?>
												<a href="#my_modal" data-toggle="modal" data-id="<?php echo $row->id; ?>" title="See Invoice"><i class="fa fa-server" aria-hidden="true" style="color:green;"></i></a>
											</div>
                                        </td>
                                        <td style="display:none;"><?php if($row->mapstatus === 'true' && $row->ticket_status != 90 && $row->ticket_status != 91){ echo 'Assigned';}else{ echo 'Unassigned';} ?></td>
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
<div class="row">
	<div class="modal modal-success fade ticketslistr" id="modal-success">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 style="margin: 0;font-size: 18px;color: #263a7d;font-weight: 600;">Ticket Created Details</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?php 
						$catdata 		= $this->category_model->get_category_data($lastcreatedticket->category_id);
						$subcatdata 	= $this->category_model->get_category_data($lastcreatedticket->subcategory_id);
						$paymentdatas 	= $this->ticket_model->getthedata('ticket_id',$lastcreatedticket->id,'nw_payment_tbl');
						$paymentdata	= $paymentdatas[0];
						$countrydata 	= $this->user_model->getCountryList($lastcreatedticket->customer_country);
						$statedata 		= $this->user_model->getStateList($lastcreatedticket->customer_state,'');
						$citydata 		= $this->user_model->getCityList($lastcreatedticket->customer_city,'');
					?>
					<div class="row">
						<div class="col-4">
							<span class="text mainn"><label>Ticket Id:</label></span>
							<span class="valuetext"><?php echo $lastcreatedticket->ticket_id; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Category:</label></span>
							<span class="valuetext"><?php echo $catdata->name; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Subcategory:</label></span>
							<span class="valuetext"><?php echo $subcatdata->name; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="text mainn"><label>Payment Status:</label></span>
							<span class="valuetext"><?php echo ($lastcreatedticket->payment_status == '1')?'Paid':'Not Paid'; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Amount:</label></span>
							<span class="valuetext"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $paymentdata->payment_data; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Description:</label></span>
							<span class="valuetext"><?php echo $lastcreatedticket->description; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="text mainn"><label>Mobile Number:</label></span>
							<span class="valuetext"><?php echo $lastcreatedticket->customer_mobile; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Country:</label></span>
							<span class="valuetext"><?php echo $countrydata->name; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>State:</label></span>
							<span class="valuetext"><?php echo $statedata->name; ?></span>
						</div>
					</div>
					<div class="row">
						<div class="col-4">
							<span class="text mainn"><label>City:</label></span>
							<span class="valuetext"><?php echo $citydata->city_name; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Pincode:</label></span>
							<span class="valuetext"><?php echo $lastcreatedticket->customer_pincode; ?></span>
						</div>
						<div class="col-4">
							<span class="text mainn"><label>Address:</label></span>
							<span class="valuetext"><?php echo $lastcreatedticket->customer_address; ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	$createdticket = $this->session->userdata('createdticket');
	if($createdticket == 'success'){
?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#modal-success').modal('show');
    });
</script>
<?php 
		$this->session->unset_userdata('createdticket');
	} 
?>
<!-- show invoice -->

<div id="my_modal" class="modal fade showremark ticketslistr" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
		<span class="remark-heading">Ticket Invoice</span>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
    </div>
  </div>
</div>
<script>
	var $base_url = "<?php echo base_url();?>";
	$('#my_modal').on('show.bs.modal', function(e) {
		var ticketid = $(e.relatedTarget).data('id');
		$.ajax({
            method: "POST",
            url: $base_url+'users/ticketController/getinvoicebyticketid',
            data: {"ticketid":ticketid},
            success:function(response){
				if(response != ''){
					//var obj = JSON.parse(response);
					$("#my_modal .modal-body").html(response);
				}else{
					$("#my_modal .modal-body").html('');
				}
            }
        });
	});
</script>

<!-- show invoice -->

