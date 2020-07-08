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
                        <div class="float-right"><a href="<?php echo $pageUrl . '/create'; ?>" class="btn btcreaten-block btn-primary">Add New</a></div>
                    </div>
                    <div class="card-body manage-listd">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="table-responsive customizetableres">
                        <table id="experties_table_id" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Expertise Name</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="display:none;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($responce as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $a; ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td class="statustd"><?php $statusRes = __getStatus($row->status);
                                            echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
                                        ?>
                                    </td>
									<td style="display:none;">
										<?php
											$statusRes = __getStatus($row->status);
											echo !empty($statusRes)?ucfirst($statusRes['status']):'';
										?>
									</td>
                                    <td class="actionrow">
                                        <div class="atbtnset">
                                        <a href="<?php echo base_url().$this->session->userdata('admins')['user_type'].'/expertise/edit/' . $row->id; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        <a href="<?php echo base_url().$this->session->userdata('admins')['user_type'].'/expertise/expertise_del/' . $row->id; ?>" onclick="return confirm('Want to delete this Expertise?');" title="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>&nbsp;&nbsp;
                                        <a data-action="status" class="toChange" data-url="<?php echo base_url().$this->session->userdata('admins')['user_type'].'/expertise/expertise_changeStatus' ?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status ?>" data-massege ="Are you sure want to change!" title="Change status to <?php
                                        if($row->status == 1){ echo "Inactive";}else{ echo "Active";} ?>"><?php
                                            if ($row->status == 1) {?>
                                                <span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
                                        <?php } else { ?>
                                            <span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
                                            <?php }
                                            ?>
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                <?php $a++; }?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>