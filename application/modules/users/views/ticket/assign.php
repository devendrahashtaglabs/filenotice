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
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                    <?php
                    echo form_open($pageUrl, array('class' => 'assign_ticket'));
                    ?>
                    <div class="card-body manage-listd">
                        <?php if ($this->session->flashdata('flash_msg') != "") { ?>
                            <div class="alert alert-success" id="alert-success-div">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('flash_msg'); ?>
                                <button type="button" class="close" aria-label="Close" id="msg-close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-6">
                                <?php
                                echo form_label('Ticket Id', 'ticket_id');
                                echo form_input(array('name' => 'ticket_id', 'class' => 'form-control', 'value' => $ticket->custom_id, 'id' => "ticket_id", 'readonly' => 'true'));
                                echo form_input(array('name' => 'customer_id', 'type' => 'hidden', 'class' => 'form-control', 'value' => $ticket->customer_id, 'id' => "customer_id", 'readonly' => 'true'));
                                echo '<div class="error-msg">' . form_error('ticket_id') . '</div>';
                                ?>
                            </div>
                            <div class="col-6">
                                <?php
                                echo form_label('Ticket Category', 'category_name');
                                echo form_input(array('name' => 'category_name',
                                    'class' => 'form-control',
                                    'value' => $ticket->category_name,
                                    'id' => "category_name",
                                    'readonly' => 'true'));
                                echo '<div class="error-msg">' . form_error('category_name') . '</div>';
                                ?>   
                            </div>
                            <div class="col-6">
                                <?php
                                echo form_label('Consultant Name*', 'consultant_id');
                                $option = array("" => "Select Consultant");
                                foreach ($consultant['data'] as $key => $value) {
                                    $option[$value->usersId] = ucfirst($value->name).' - '.$value->email;
                                }
                                echo form_dropdown('consultant_id', $option, $selected = set_value('consultant_id',$ticket->consultant_id), $extra = 'class="form-control", id="consultant_id"');
                                echo '<div class="error-msg">' . form_error('consultant_id') . '</div>';
                                ?>
                            </div>
                            <div class="col-6">
                                <?php
                                echo form_label('Start Date*', 'assign_date');
                                echo form_input(array('name' => 'assign_date', 'class' => 'form-control datepicker', 'value' => set_value('assign_date',$ticket->assign_date), 'id' => "assign_date", 'placeholder' => 'Assign Date','readonly'=>'readonly'));
                                echo '<div class="error-msg">' . form_error('assign_date') . '</div>';
                                ?>
                            </div>
                            <div class="col-6">
                                <?php
                                echo form_label('Ticket Discription', 'description');
                                echo form_textarea(array('name' => 'description',
                                    'class' => 'form-control',
                                    'value' => set_value('description', $ticket->description),
                                    'id' => "description",
                                    'cols' => '4',
                                    'rows' => '4'
                                ));
                                echo '<div class="error-msg">' . form_error('description') . '</div>';
                                ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <?php
                            echo form_submit(array("class" => "btn btn-success", "id" => "assign_tkt_btn", "value" => "Submit"));
                            echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('user_type').'/ticket/assign_list') . '" class="btn btn-primary">Cancel</a>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>