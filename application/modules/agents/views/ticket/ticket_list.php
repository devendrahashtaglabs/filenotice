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
                       <?php  if($this->session->userdata('users')['user_type'] != 'consultant') { ?> <div class="float-right"><a href="<?php echo $pageUrl.'/create'; ?>" class="btn btcreaten-block btn-primary"><i class="fa fa-plus"></i> Add Ticket</a></div> <?php } ?>
                    </div>
                    <div class="card-body manage-listd ">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
						<?php /*<div class="row mb-2">
							<div class="col-md-1 col-xs-12 filter-text">Filter : </div>
							<div class="col-md-2 col-xs-12"><div class="customfilter"></div></div>
						</div> */?>
                        <div class="table-responsive customizetableres">
                        <table id="ticket_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th style="display:none;">Description</th>
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
										//echo "<pre>";print_r();echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo $row->category_name; ?></td>
                                        <td style="word-break: break-all;" class="tooltipz"><?php echo ($row->description!='')?substr($row->description, 0, 20).'...':DEFAULT_VALUE; ?>

                                         <span class="tooltiptext"><?php echo $row->description; ?></span>
                                        </td>
										<td style="display:none;"><?php echo isset($row->description)?$row->description:''; ?></td>
                                        <td><?php echo ($row->created!='')?date('d-m-Y',strtotime($row->created)):DEFAULT_VALUE;?></td>
                                        <td><?php $statusRes= __getStatus($row->ticket_status, 'float-left'); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
                                        <td>
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
                                                <a data-action="status" class="toChange" data-url="<?php echo $pageUrl.'/update';?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure want to change!" title="Update Status" href="javascript:;">
                                                    <?php echo ($row->status == 1) ? '<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>':'<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>';?>
                                                </a>&nbsp;
                                                <a href="javascript:;" data-action="delete" class="toChange" data-url="<?php echo $pageUrl.'/update';?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure want to delete!" title="Delete Ticket"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
                                            <?php } ?>
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