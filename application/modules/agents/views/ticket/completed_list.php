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
                    <div class="card-body manage-listd">
                    <div class="table-responsive customizetableres">
						<div class="row mb-2">
							<div class="credted filter">Filter : </div>
							<div class="col-md-2 filter FilterCustom1"></div>
							<div class="col-md-3 filter FilterCustom2"></div>
						</div>
						<div class="row mb-2">
							<div class="credted filter">Close Date :</div>
							<?php /*<div class="col-md-2 filter FilterCustom6">
								<select name="datewisedata" id="datewisedata" class="form-control">
									<option value="">Select Custom Option</option>
									<option value="d_ago">1 Day Ago</option>
									<option value="w_ago">1 Week Ago</option>
									<option value="m_ago">1 Month Ago</option>
								</select>
							</div> */ ?>
							<div class="col-md-2 filter FilterCustom7">
								<input class="form-control" name="assignmin" id="assignmin" type="text" placeholder="Start Date">
							</div>
							<div class="col-md-2 filter FilterCustom7">
								<input class="form-control" name="assignmax" id="assignmax" type="text" placeholder="End Date">
							</div>
						</div>
                        <table id="completed_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket Id</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Description</th>
                                    <th>Start Date</th>
                                    <th>Close Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
									$a = 1;
									foreach ($tickets['data'] as $row) {
										$subcatdata = $this->category_model->get_category_data($row->subcategory_id);										
										$subcatname = !empty($subcatdata)?$subcatdata->name:'NA';
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo $row->customId; ?></td>
                                        <td><?php echo $row->category_name; ?></td>
                                        <td><?php echo $subcatname; ?></td>
                                        <td style="word-break: break-all;"><?php echo substr($row->description, 0, 20).'...'; ?></td>
                                        <td>
											<?php 
												$start_date = ($row->start_date)?$row->start_date:'';
												if(!empty($start_date)){
													echo date('d-m-Y', strtotime($row->start_date)); 
												}
											?>
										</td>
                                        <td>
											<?php 
												$close_date = ($row->close_date)?$row->close_date:'';
												if(!empty($close_date)){
													echo date('d-m-Y', strtotime($row->close_date));
												}											
											?>
										</td>
                                        <td>
                                        <?php if($row->ticket_status == '90'){ ?>
                                            <span class="float-left badge bg-danger">Completed</span>
                                        <?php }else{ ?>
											<span class="float-left badge bg-danger">Cancelled</span>
                                        <?php } ?>

                                        <?php $statusRes= __getStatus($row->status, 'float-left'); 
                                        //echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';?></td>
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