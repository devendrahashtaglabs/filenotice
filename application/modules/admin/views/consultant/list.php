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
                        
                        <div class="float-right"><a href="<?php echo $pageUrl.'/create';?>" class="btn btcreaten-block btn-primary">Add New</a></div>
                    </div>
                    <div class="card-body  manage-listd">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="table-responsive customizetableres mahgepddin">
                            <div class="fileterdata cusotmfiltrer">                            
                                <div class="filter Filterstatus FilterCustom1"></div>
                                <div class="filter Filterstatus FilterCustom2"></div>
                                <!--<div class="filter Filterstatus FilterCustom3"></div>-->
                                <div class="filter Filterstatus FilterCustom4"></div>
                                <div class="filter Filterstatus FilterCustom5"></div>
                                <div class="filter Filterstatus FilterCustom6"></div>
                            </div>
						
                        <table id="consultant_table_id" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Account Type</th>
                                    <th>Consultant Detail</th>
                                    <th style="display:none;">Name</th>
                                    <th style="display:none;">Email</th>
                                    <th style="display:none;">Phone</th>
                                    <th>Agents</th>
                                    <th>Category</th>
                                    <th style="display:none;">Category</th>
                                    <!--<th>Subcategory</th>-->
                                    <th>State</th>
                                    <th>City</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="display:none;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $a = 1;
                                foreach ($response['data'] as $row) {
									//echo "<pre>";print_r($row);echo "</pre>";//die(" on file ". __FILE__ ." on line ". __LINE__ );
									$catname = '';
									if(!empty($row->category_id)){
										$catarray 		= explode(',',$row->category_id);
										$catnamearray 	= [];
										$catcounter = 0;
										foreach($catarray as $catid){
											$catData = $this->category_model->getCategoryById($catid);
											if(!empty($catData)){
												$catnamearray[$catcounter] = $catData->name;
											}
											$catcounter++; 
										}
										$catname = implode(',',$catnamearray);
									}
									$subcatname = '';
									if(!empty($row->subcategory_id)){
										
										$subcatarray 	 = explode(',',$row->subcategory_id);
										$subcatnamearray = [];
										$subcatcounter = 0;
										foreach($subcatarray as $subcatid){
											$subcatData = $this->category_model->getCategoryById($subcatid);
											if(!empty($subcatData)){
												$subcatnamearray[$subcatcounter] = $subcatData->name;
											}
											$subcatcounter++; 
										}
										$subcatname = implode(',',$subcatnamearray);
									}
									$agentData = $this->user_model->getagentbyconsultantid($row->user_id);
									$agentDatacount = count($agentData);
									$cityquery = $this->user_model->getCityList($row->city_id,'');
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td> 
                                        <td><?php echo ucfirst($row->account_type); ?></td> 
                                        <td><span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo ucfirst($row->name).'</br>'.$row->email.'</br>'.$row->mobile ;?></span> </td>
                                        <td style="display:none;"><?php echo ucfirst($row->name);?></td>
                                        <td style="display:none;"><?php echo isset($row->email)?$row->email:'';?></td>
                                        <td style="display:none;"><?php echo isset($row->mobile)?$row->mobile:'';?></td>
                                        <td><?php echo isset($agentDatacount)?$agentDatacount:'0';?></td>
                                        <td><span style="word-break: break-all; display: block; width:108px; word-wrap: break-word;"><?php echo isset($catname)?$catname:'';?></span></td>
                                        <td style="display:none;"><?php echo isset($catname)?$catname:'';?></td>
                                        <?php /*<td><span style="word-break: break-all; display: block; width:108px; word-wrap: break-word;"><?php echo isset($subcatname)?$subcatname:'';?></span></td> */?> 
                                        <td><?php echo $row->stateName;?></td>
                                        <td><?php echo !empty($cityquery)?$cityquery->city_name:'';?></td>
                                        <td style="width: 100px; text-align: center;" class="statustd"><?php $statusRes = __getStatus($row->usersStatus); echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
                                        <td style="display:none;"><?php $statusRes = __getStatus($row->usersStatus); echo ucfirst($statusRes['status']);?></td>                        
                                        <td class="actionrow">
                                            <div class="atbtnset">
                                            <a href="<?php echo base_url() .'admin/consultant/view/' . $row->usersId; ?>" title="VIEW"><i class="fa fa-eye" aria-hidden="true" style="color:orange;"></i></a>
                                            <a href="<?php echo base_url() .'admin/consultant/edit/' . $row->usersId; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

                                   <?php } }*/ ?> 
											<a data-action="status" class="toChange" data-url="<?php echo base_url($this->session->userdata('admins')['user_type'].'/consultant/updateRecords');?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-massege ="Are you sure want to change status?" title="Change status to <?php
											if(ucfirst($statusRes['status']) == 'Active') { echo 'Inactive'; } else { echo 'Active'; } ?>" href="javascript:;">
											<?php if ($row->usersStatus == 1){?>
											<span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
											<?php } else { ?>
											<span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
											<?php } ?></a>
											<?php 
												if($row->verified_consultant == '1'){
											?>
											<a onclick="verifyalertsFunction()" data-action="status" href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/consultant/consultantstep1/'.$row->user_id);?>" data-id="<?php echo $row->usersId; ?>" data-status ="<?php echo $row->usersStatus;?>" data-email="<?php echo $row->email; ?>" data-name="<?php echo $row->name; ?>" title="verify consultant"><span style="color:green;"><i class="fa fa-empire" aria-hidden="true"></i></span></a>
											<?php } ?>
                                        </div>
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
		alert("Your ticket is active. Can't Delete consultant!");
    }
	function verifyalertsFunction() {
		alert("Are you sure you want to verify consultant?");
    }

</script>
