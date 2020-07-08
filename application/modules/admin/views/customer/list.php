<?php //print_r($newcustomer); exit; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="addtitles"><?php echo $section_name; ?></h1>
                    
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
                        
                        <div class="addnewbtn"><a href="<?php echo $pageUrl . '/create'; ?>" class="btcreaten-block btn btn-primary">Add New</a></div>
                        
                        
                    </div>
                    <div class="card-body manage-listd">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>

                        <div class="table-responsive customizetableres">	
                        
                        			<div class="fileterdata">                            
                            <div class="filter Filterstatus"></div>                            
                        </div>		
                        <div class="row">
                            <div class="col-md-12">
                        <table id="customer_list" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
									<th>#</th>
									<th>Customer Detail</th>
									<th style="display:none;">Name</th>
									<th style="display:none;">Email</th>
									<th style="display:none;">Phone</th>
									<th>Gender</th>
									<th>State</th>
									<th>City</th>
									<th style="text-align: center;">Status</th>
									<th style="display:none;">Ticket_status</th>
									<th class="actioncolm" style="width: 80px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
								$a = 1;
								foreach ($response['data'] as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $a;?></td> 
                                    <td><?php echo ucfirst($row->name).'</br>'.$row->email.'</br>'.$row->mobile?></td>
									<td style="display:none;"><?php echo ucfirst($row->name);?></td>
									<td style="display:none;"><?php echo isset($row->email)?$row->email:'';?></td>
									<td style="display:none;"><?php echo isset($row->mobile)?$row->mobile:'';?></td>
                                    <td><?php if($row->gender == 1){ echo "Male";}elseif($row->gender == 2){ echo "Female"; }else{ echo "Other";} ?></td>
                                    <td><?php echo $row->stateName;?></td>
                                    <td><?php echo $row->cityName;?></td>
                                    <td style="text-align: center;" class="statustd">
									<?php $statusRes = __getStatus($row->usersStatus); ?>
										<span class="<?php echo isset($statusRes["spanClass"])? $statusRes['spanClass'] :''; ?>"><?php echo isset($statusRes['status'])?ucfirst($statusRes['status']): ''; ?></span>
									</td>
									<td style="display:none;">
										<?php 
											echo ($row->usersStatus == '1')?'Active':'Inactive';
										?>
									</td>
                                    <td class="actionrow">
                                        <div class="atbtnset">
                                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/customer/view/'.$row->usersId); ?>" title="VIEW"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>&nbsp;
                                        <a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/customer/edit/'.$row->usersId); ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;
                                         <?php /* foreach ($newcustomer as $rown) {  ?>  
                                            <?php if($rown->customer_id == $row->user_id)
                                            { 
                                                //echo $rown->c_status;
                                            ?>    

											<?php if($rown->cus_status >= 1) { ?>
											   <a onclick="myalertFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp; 
											<?php } else { ?>
												<?php// echo 'no act'; ?>
											<?php } ?>
										<?php } else { ?>

                                            <a data-action="delete" class="toChangenew" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/consultant/updateRecords');?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-email="<?php echo $row->email; ?>" data-name="<?php echo $row->name; ?>" data-massege ="Are you sure want to Delete ?" title="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;

										<?php } } */ ?> 
										<a data-action="status" class="toChangenew" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/customer/updateRecords');?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-email="<?php echo $row->email; ?>" data-name="<?php echo $row->name; ?>" data-massege ="Are you sure you want to change the status?" title="Change status to <?php 
                                       if(ucfirst($statusRes['status']) == 'Active') { echo 'Inactive'; } else { echo 'Active'; } ?>" href="javascript:;">
                                        <?php if ($row->usersStatus == 1){?>
                                            <span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
                                        <?php } else { ?>
                                            <span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
                                        <?php } ?></a>
                                    </div>
                                    </td>

                                    
                                </tr>
                            <?php $a++;} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    function myalertFunction() {
    alert("Your ticket is active. Can't Delete customer!");
    }
</script>