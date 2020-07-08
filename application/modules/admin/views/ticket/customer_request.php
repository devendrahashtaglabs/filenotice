<style type="text/css">
.credted.filter {
    padding: 0 8px;
    font-size: 16px;
    min-width: 106px;
} 
.filter select {
    padding: 5px;
    font-size: 15px;
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
                        <?php /* <div class="float-right"><a href="<?php echo $pageUrl . '/create'; ?>" class="btn btcreaten-block btn-primary">Add New Ticket</a></div> */?>
                    </div>
                    <div class="card-body manage-listd">
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
							<div class="filter Filterstatus">
								<input class="form-control" name="requestmin" id="requestmin" type="text" placeholder="Start Date">
							</div>
							<div class="filter Filterstatus">
								<input class="form-control" name="requestmax" id="requestmax" type="text" placeholder="End Date">
							</div>
						</div>
                        <div class="table-responsive customizetableres">
                    <table id="customerrequest_table_id" class="table table-bordered table-striped" style="margin-top: 20px; width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Category / Subcategory</th>
                                    <th style="display:none;">Category</th>
                                    <th style="display:none;">Subcategory</th>
									<th>Ticket ( State /City )</th>
                                    <th style="display:none;">State</th>
                                    <th style="display:none;">City</th>
                                    <th>Customer Detail</th>
                                    <th style="display:none;">Customer Name</th>
                                    <th style="display:none;">Customer Email</th>
                                    <th style="display:none;">Customer Phone</th>
                                    <th>Customer Remark</th>
                                    <th>Admin Remark</th>
                                    <th>Updated At</th>
                                    <th style="display:none;">Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($response as $row) {
										$ticketdata = $this->ticket_model->getTicketById($row->ticket_id);
										$catname	= '';
										$subcatname	= '';
										$statename  = '';
										$cityname 	= '';
										if(!empty($ticketdata)){
											$catdata 	= $this->category_model->getCategoryById($ticketdata->category_id);
											$catname 	= $catdata->name;
											$subcatdata = $this->category_model->getCategoryById($ticketdata->subcategory_id);
											$subcatname = $subcatdata->name;
											$statedata 	= $this->user_model->getStateList($ticketdata->customer_state,'');
											$statename  = !empty($statedata->name)?$statedata->name:'NA';
											$citydata 	= $this->user_model->getCityList($ticketdata->customer_city,'');
											$cityname  	= !empty($citydata->city_name)?$citydata->city_name:'NA';
										}
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo $catname .' / '.$subcatname; ?></td>
                                        <td style="display:none;"><?php echo $catname; ?></td>
                                        <td style="display:none;"><?php echo $subcatname; ?></td>
										<td><?php echo $statename .' / '.$cityname; ?></td>
                                        <td style="display:none;"><?php echo !empty($statename)?$statename:'NA'; ?></td>
                                        <td style="display:none;"><?php echo !empty($cityname)?$cityname:'NA'; ?></td>
                                        <td><span style="word-break: break-all; display: block; width:118px; word-wrap: break-word;"><?php echo ucfirst($row->name).'<br/>'.$row->customeremail .'<br/>'.$row->mobile; ?></span></td>
                                        <td style="display:none;"><?php echo ucfirst($row->name); ?></td>
                                        <td style="display:none;"><?php echo $row->customeremail; ?></td>
                                        <td style="display:none;"><?php echo $row->mobile; ?></td>
                                        <td>
                                            <?php echo !empty($row->customer_remark)?$row->customer_remark:''; ?>
                                        </td>
										<td>
                                            <?php echo !empty($row->admin_remark)?$row->admin_remark:''; ?>
                                        </td>
                                        <td>                                            
                                            <?php 
												echo date('d-m-Y H:i:s',strtotime($row->modified_at));
											?>
                                        </td>
										<td style="display:none;">                                            
                                            <?php 
												echo date('d-m-Y',strtotime($row->modified_at));
											?>
                                        </td>
                                        <td class="actionrow">
                                            <div class="atbtnset">
                                            <a href="<?php echo base_url() .'admin/ticket/addremark/' . $row->ticket_id; ?>" title="View"><i class="fa fa-commenting" aria-hidden="true"></i>
</a>    
</div>
                                        </td>
                                    </tr>
                                <?php $a++; } ?>
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