<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?php echo $section_name;?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo $breadcrumb;?>
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
                        <div class="float-right"><a href="<?php echo base_url($this->session->userdata('user_type').'/admin/state/create');?>" class="btn btcreaten-block btn-primary">Add New</a></div>
                    </div>
                    <div class="card-body manage-listd">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="table-responsive customizetableres">
                        <table id="table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>State Name</th>
                                    <th>Country Name</th>
                                    <th style="text-align: center;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $a = 1;
                                foreach ($responce as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $a; ?></td>
                                        <td><?php echo ucfirst($row->name); ?></td>
                                        <td><?php echo $this->user_model->getCountryList($row->country_id)->name; ?></td>
                                        
                                        <td class="statustd"><?php $statusRes = __getStatus($row->status);
                                            echo '<span class="' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span>';
                                        ?>
                                        </td>
                                        <td class="actionrow">
                                            <div class="atbtnset">
                                            <a href="<?php echo base_url() . 'admin/state/edit/' . $row->id; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                            &nbsp;&nbsp;<a id ="remove" href="<?php echo base_url() . 'admin/state/state_del/' . $row->id; ?>" onclick="return confirm('Want to delete this state?');" title="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
                                            &nbsp;&nbsp;<a data-action="status" class="toChange" data-url="<?php echo base_url() . 'admin/state/state_changeStatus' ?>" data-id="<?php echo $row->id; ?>" data-status ="<?php echo $row->status ?>" data-massege ="Are you sure want to change!" title="Change status to <?php
                                                           if ($row->status == 0) {
                                                               echo "Active";
                                                           } else {
                                                               echo "Inactive";
                                                           }
                                                           ?>"><?php
                                            if ($row->status == 1) {?>
                                                <span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
                                        <?php } else { ?>
                                            <span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
                                            <?php }
                                            ?></a>
                                        </div>
                                        </td>
                                    </tr>
                                <?php $a++;
                                } 
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>