<style>
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
}
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
    min-width: 98px;
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
                        <?php /* ?><div class="float-right"><a href="<?php echo $pageUrl . '/create'; ?>" class="btn btcreaten-block btn-primary">Add New Ticket</a></div> */?>
                    </div>
                    <div class="card-body manage-listd">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
						
						<div class="fileterdata ">
							<div class="filter Filterstatus customfiltercategory"></div>
							<div class="filter Filterstatus customfiltersubcategory"></div>
							<div class="filter Filterstatus customfiltercity"></div>
							<div class="filter Filterstatus customfilterstate"></div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmin" id="unassignmin" type="text" placeholder="Start Date">
                            </div>
                            <div class="filter Filterstatus FilterCustom7">
                                <input class="form-control" name="unassignmax" id="unassignmax" type="text" placeholder="End Date">
                            </div>
						</div>
						

						
                        <div class="table-responsive customizetableres mahgepddin">
                        <table id="ticket_table_id" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Customer</th>
                                    <th style="display:none;">Customer Name</th>
                                    <th style="display:none;">Customer Email</th>
                                    <th style="display:none;">Customer Mobile</th>
                                    <th>Category / Subcategory</th>
                                    <th style="display:none;">Category</th>
                                    <th style="display:none;">Subcategory</th>
									<th>State / City</th>
                                    <th style="display:none;">State</th>
                                    <th style="display:none;">City</th>
                                    <th>Start Date</th>
                                    <th style="display:none;">Close Date</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="display:none;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($response['data'] as $row) {
										$subcategorydata = $this->category_model->getCategoryById($row->subcategory_id);
										$statedata 	= $this->user_model->getStateList($row->customer_state,'');
										$citydata 	= $this->user_model->getCityList($row->customer_city,'');
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo ucfirst($row->customer_name).'<br/>'.$row->customer_email .'<br/>'.$row->customer_mobile; ?></td>
                                        <td style="display:none;"><?php echo ucfirst($row->customer_name); ?></td>
                                        <td style="display:none;"><?php echo $row->customer_email; ?></td>
                                        <td style="display:none;"><?php echo $row->customer_mobile; ?></td>
                                        <td><span style="word-break: break-all; display: block; width:138px; word-wrap: break-word;"><?php echo $row->category_name .' / '.$subcategorydata->name; ?></span></td>
                                        <td style="display:none;"><?php echo $row->category_name; ?></td>
                                        <td style="display:none;"><?php echo $subcategorydata->name; ?></td>
										<?php 
											$city_name = !empty($citydata)?$citydata->city_name:'NA';
											$state_name = !empty($statedata)?$statedata->name:'NA';
										?>
										<td><?php echo  $state_name.' / '.$city_name; ?></td>
                                        <td style="display:none;"><?php echo $state_name; ?></td>
                                        <td style="display:none;"><?php echo $city_name; ?></td>
                                        <td>
                                            <?php 
                                                if($row->start_date != ''){
                                                    echo date('d-m-Y', strtotime($row->start_date)); 
                                                }else{
                                                    echo 'NA';
                                                }
                                                ///TICKET-JSKMP
                                            ?>
                                        </td>
                                        <td style="display:none;">                                            
                                            <?php 
                                                if($row->close_date != ''){
                                                    echo date('d-m-Y', strtotime($row->close_date)); 
                                                }else{
                                                    echo 'NA';
                                                }
                                            ?>
                                        </td>
                                        <td class="statustd">
											<?php 
												$statusRes= __getStatus($row->ticket_status, 'float-left');
												echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
											?>
										</td>
										<td style="display:none;"><?php echo ($row->status == '1')?'Active':'Inactive'; ?></td>
                                        <td class="actionrow">
                                            <div class="atbtnset">
                                            <a href="<?php echo base_url() .'admin/ticket/view/' . $row->id; ?>" title="View"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>&nbsp;&nbsp;
											<?php 
											if ($row->status == 1) {
												if($row->ticket_status != '90' && $row->ticket_status != '91'){
													$assignurls = ($row->mapstatus==='false')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
													$assignTitle = ($row->mapstatus==='false')? 'Assign User': 'Already Assign';
													$style = ($row->mapstatus==='false')?'':'color:red';
												}else{
													$assignurls = ($row->ticket_status =='10')? base_url() . 'admin/ticket/assign/'.$row->id: 'javascript:;';
													$assignTitle = ($row->ticket_status == '90' || $row->ticket_status == '91')? 'Ticket Completed': '';
													$style = ($row->ticket_status==='90' || $row->ticket_status == '91')?'color:red':'';
												}
                                            ?>
                                            <a href="<?php echo $assignurls; ?>" title="<?php echo $assignTitle;?>"><i class="fa fa-user" aria-hidden="true" style="<?php echo $style; ?>"></i></a>&nbsp;

                                    <?php } else { ?>  
                                            <a onclick="alertFunction()" title="Inactive Ticket" style="cursor:pointer;"><i class="fa fa-user" aria-hidden="true" style="color:red"></i></i></a>&nbsp; 

                                     <?php } ?>

                                            
                                           <?php /* <a href="<?php echo base_url() . 'admin/ticket/edit/' . $row->id; ?>" title="Edit Ticket"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp; 
                                            <a data-action="status" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure you want to change the Status?" title="Change status to <?php if($row->status == 1) { echo 'Inactive'; } else { echo 'Active'; } ?>" href="javascript:;">
                                                <?php echo ($row->status == 1) ? '<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>' : '<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>';?>
                                            </a>&nbsp;*/ ?>

                                     <?php if ($row->status == 1) { ?>  
                                       
                                            <a onclick="alertassignFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;   

                                      <?php } else { ?>  

                                            <a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/ticket/updateRecords');?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status;?>" data-massege ="Are you sure you want to Delete?"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
                                      <?php } ?> 
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
<script>
    function alertassignFunction() {
    alert("Active ticket cannot be deleted");
    }
    function alertFunction() {
    alert("Inactive ticket cannot be assigned");
    }
</script>