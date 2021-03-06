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
                        <div class="float-right"><a href="<?php echo base_url().'admin/category/create_subcategory';?>" class="btn btcreaten-block btn-primary">Add New</a></div>
                    </div>
                    <div class="card-body manage-listd">
                         <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="table-responsive customizetableres">
                        <table id="subcategory_table_id" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Parent Category</th>
                                    <th>Amount</th>
                                    <th>Located City</th>
                                    <th>Recurring Payment</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="display:none;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $a =1;
                                foreach($responce as $row) { 
                                    $res =$this->category_model->parentCategoryName($row->parent_id);
                                ?>
                                <tr>
                                    <td><?php echo $a;?></td>
                                    <td><?php echo ucfirst($row->name);?></td>
                                    <td><?php if (!empty($res)){echo ucfirst($res->name);}else{ echo "N.A.";}?></td>
                                    <td><?php echo $row->amount;?></td>
									<td><?php echo '<span style="word-break: break-all;" class="tooltipz">' . substr($row->mapped_city, 0, 20).'...<span class="tooltiptext">'.$row->mapped_city.'</span></span>'; ?></td>
                                    <td><?php echo ($row->recurring_payment == '0')?'False':'True';?></td>
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
                                        <a href="<?php echo base_url().'admin/category/edit_subcategory/'.$row->id; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                        &nbsp;&nbsp;<a class = "remove" href="<?php echo base_url().'admin/category/subcategory_del/'.$row->id; ?>" onclick="return confirm('Want to delete this category?');" title="Delete"><i class="fa fa-trash" aria-hidden="true" style="color:red;"></i></a>
                                        &nbsp;&nbsp;<a data-action="status" class="toChange" href="javascript:;" 
                                                       data-url="<?php echo base_url().'admin/category/subcategory_changeStatus'?>" 
                                                       data-id="<?php echo $row->id;?>" 
                                                       data-status ="<?php echo $row->status?>" 
                                                       data-massege ="Are you sure you want to change the Status?"
                                                       title="Change status to <?php if($row->status == 0) 
                                                    {echo "Active";}
                                                else{echo "Inactive";}?>"><?php 
                                                if ($row->status == 1) { ?>
                                                <span style="color:red;"><i class="fa fa-thumbs-down"></i></span>
                                            <?php } else {?>
                                                <span style="color:green;"><i class="fa fa-thumbs-up"></i></span>
                                            <?php }
                                            ?></a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $a++; }  ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>