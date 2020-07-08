<?php //print_r($newt); exit; ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $section_name;?></h1>
                </div>
                <div class="col-sm-6">
                    <?php //echo $breadcrumb;?>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title;?></h3></div>
                        <div class="float-right"><a href="<?php echo $pageUrl.'/addagent';?>" class="btn btcreaten-block btn-primary">Add New</a></div>
                    </div>
                    <div class="card-body  manage-listd">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
                        <div class="table-responsive customizetableres">
                        <table id="agent_table_id" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Agent Detail</th>
                                    <th style="display:none;">Name</th>
                                    <th style="display:none;">Email</th>
                                    <th style="display:none;">Phone</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th style="display:none;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($response['data'] as $row) {
										$catname = '';
										if(!empty($row->category_id)){
											$catData = $this->category_model->get_category_data($row->category_id);
											if(!empty($catData)){
												$catname = $catData->name;
											}
										}
										$subcatname = '';
										if(!empty($row->subcategory_id)){
											$subcatData = $this->category_model->get_category_data($row->subcategory_id);
											if(!empty($subcatData)){
												$subcatname = $subcatData->name;
											}
										}
										$cityquery = $this->user_model->getCityList($row->city_id,'');
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td> 
                                        <td><?php echo ucfirst($row->name).'</br>'.$row->email.'</br>'.$row->mobile ;?></td>
                                        <td style="display:none;"><?php echo ucfirst($row->name);?></td>
                                        <td style="display:none;"><?php echo isset($row->email)?$row->email:'';?></td>
                                        <td style="display:none;"><?php echo isset($row->mobile)?$row->mobile:'';?></td>
                                        <td><?php echo isset($catname)?$catname:'';?></td>
                                        <td><?php echo isset($subcatname)?$subcatname:'';?></td>
                                        <td><?php echo $row->stateName;?></td>
                                        <td><?php echo !empty($cityquery)?$cityquery->city_name:'';?></td>
                                        <td><?php echo $row->address;?></td>
                                        <td><?php $statusRes = __getStatus($row->usersStatus); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
                                        <td style="display:none;"><?php $statusRes = __getStatus($row->usersStatus); echo ucfirst($statusRes['status']);?></td>
                                                                      
                                        <td>
                                            <a href="<?php echo base_url() .'agent/agentview/' . $row->usersId; ?>" title="VIEW"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>&nbsp;&nbsp;
                                            <a href="<?php echo base_url() .'agent/editagent/' . $row->usersId; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
											<?php /*foreach ($newt as $rown) {  ?>  
                                            <?php if($rown->consultant_id == $row->user_id){ 
												//echo $rown->c_status;
											?>    

											<?php if($rown->c_status >= 1) { ?>
											   <a onclick="myalertsFunction()" title="Delete" style="cursor:pointer;"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp; 
											<?php } else { ?>
												<?php// echo 'no act'; ?>
											<?php } ?>
											<?php } else { ?>

                                            <a data-action="delete" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/consultant/updateRecords');?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-massege ="Are you sure want to Delete ?" title="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;

                                   <?php } }*/ 
										$activetext = "All agent`s ticket will assign to consultant!";
								   ?> 
                                            <a data-action="status" class="toChangeagent" data-url="<?php echo base_url('/agent/updateAgentRecords');?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-email="<?php echo $row->email; ?>" data-name="<?php echo $row->name; ?>" data-massege ='<?php echo ($row->usersStatus == '1')? $activetext:"Want to active agent!"; ?>' onClick="myalertsFunction()" title="Change status to <?php
                                            if(ucfirst($statusRes['status']) == 'Active') { echo 'Inactive'; } else { echo 'Active'; } ?>" href="javascript:;">
                                            <?php if ($row->usersStatus == 1){?>
                                                <span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
                                        <?php } else { ?>
                                            <span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
                                            <?php } ?></a>
                                        </td>
                                    </tr>
                                <?php  $a++; } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<script>
    function myalertsFunction() {
		alert("Are you sure you want to change the status?");
    }
	$(document).on('click','.toChangeagent',function() {
        var $url    = $(this).data('url');
        var $action = $(this).data('action');
        var $id     = $(this).data('id');
        var $msg    = $(this).data('massege');
        var $ststus = $(this).data('status');
		var $email 	= $(this).data('email');
		var $name 	= $(this).data('name');
        if(confirm($msg)){
            $.ajax({
                method: "POST",
                url: $url,
                data: {"uid":$id,"status":$ststus,"action":$action,"email":$email,"name":$name},
                success:function(response){
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    setTimeout(function() {
                        window.location.reload()
                    }, 1000);
                }
            });
        }
    });
</script>
