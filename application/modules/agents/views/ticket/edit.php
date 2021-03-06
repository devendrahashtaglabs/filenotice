<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script>
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
                   <?php echo form_open_multipart($pageUrl.'/edit/'. $ticket->id, array('id' => 'CustomerTicketForm')); ?>
                    <div class="card-body">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="row">
                            <div class="form-group col-6">
                            <?php
                                echo form_label('Ticket ID', 'ticket_id');
                                echo form_input(array('name' => 'ticket_id', 'class' => 'form-control', 'value' => set_value('ticket_id',$ticket->ticket_id), 'id' => "ticket_id", 'readonly' => 'true'));
                                echo form_input(array('name' => 'id', 'type' => 'hidden', 'value' => $ticket->id, 'id' => "id"));
                                echo '<div class="error-msg">' . form_error('ticket_id') . '</div>';
                            ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Category*', 'category_id');
                                $option = array("" => "Select Category");
                                foreach ($categories as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
                                echo form_dropdown('category_id',$option,$selected=set_value('category_id',$ticket->categoryid), $extra='class="form-control category_id"', false);
                                echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                            </div>
                            <!-- <div class="form-group col-6">
                                <?php
                                // echo form_label('Start Date*', 'start_date');
                                // echo form_input(array('name' => 'start_date', 'class' => 'form-control datepicker', 'value'=>set_value('start_date',date('d-m-Y',strtotime($ticket->start_date))),'id' => "start_date", 'placeholder' => 'Start Date','readonly'=>'readonly'));
                                // echo '<div class="error-msg">' . form_error('start_date') . '</div>';
                                ?>
                            </div> -->
                            <!-- <div class="form-group col-6">
                                <?php
                                // echo form_label('Close Date*', 'close_date');
                                // echo form_input(array('name' => 'close_date', 'class' => 'form-control datepicker', 'value' => set_value('close_date',date('d-m-Y', strtotime($ticket->close_date))), 'id' => "close_date", 'placeholder' => 'Close Date','readonly'=>'readonly'));
                                // echo '<div class="error-msg">' . form_error('close_date') . '</div>';
                                ?>
                            </div> -->
                            <!-- <div class="form-group col-6">
                                <?php
                                // echo form_label('Ticket Status', 'ticket_status');
                                // echo form_dropdown('ticket_status', $options = array(
                                //     '' => 'Select Ticket Status',
                                //     '1' => 'Working',
                                //     '0' => 'Completed',
                                // ), $selected = set_value('ticket_status',$ticket->ticket_status), $extra = 'class="form-control",id="ticket_status"');
                                // echo '<div class="error-msg">' . form_error('ticket_status') . '</div>';
                                ?>
                            </div> -->
                            
                            <!-- <div class="form-group col-6">
                                <?php
                                // echo form_label('Payment Status', 'payment_status');
                                // echo form_dropdown('payment_status', $options = array(
                                //     '' => 'Select Status',
                                //     '1' => 'Completed',
                                //     '0' => 'Pending',
                                // ), $selected=set_value('payment_status',$ticket->payment_status), $extra = 'class="form-control" id="payment_status"');
                                // echo '<div class="error-msg">' . form_error('payment_status') . '</div>';
                                ?>
                            </div> -->
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Status', 'status');
                                echo form_dropdown('status', $options = array(
                                    '' => 'Select Status',
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                ), $selected=set_value('status',$ticket->status), $extra = 'class="form-control",id="status"');
                                echo '<div class="error-msg">' . form_error('status') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">                               
                                <?php echo form_label('Document Upload', 'image'); ?>
                                <input type="file" name="image[]" class="form-control" size="20" />
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx / Max. upload size 2MB)</span></label>
                                <?php echo '<div class="error-msg">' . form_error('image') . '</div>'; ?>
                                <?php if(!empty($ticket->file)) { ?><a href="<?php echo base_url().'uploads/ticket/'.$ticket->file; ?>" target="_blank">View File</a><?php } ?>
                                <?php echo '<div class="error-msg">' . form_error('userfile') . '</div>'; ?>
                            </div>

                            <div class="form-group col-6">
                            <?php
                                echo form_label('Description*', 'description');
                                echo form_textarea(array('name'=>'description','class'=>'form-control','value'=>set_value('description',$ticket->description),
                                    'id' => "description",'cols' => '10','rows' => '3'
                                ));
                                echo '<div class="error-msg">' . form_error('description') . '</div>';
                            ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Select Country *', 'customer_country');
                                    $allCountry        	= [];
                                    $allCountry['']    	= 'Select Country';
									$selected_country	= isset($ticket->customer_country)?$ticket->customer_country:'';
									if(!empty($countryList)){
										foreach($countryList as $singleCountryList){
											$allCountry[$singleCountryList->id] = $singleCountryList->name;
										}                    
                                    } 
                                    echo form_dropdown('customer_country', $allCountry, set_value('customer_country',$selected_country), 'class="form-control" id="customer_country" disabled="disabled"');
									echo form_hidden('customer_country',$selected_country);
									echo '<div class="error-msg">' . form_error('customer_country') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Select State*', 'customer_state');
									$allstate      	= [];
                                    $allstate['']  	= 'Select State';
									$selected_state	= isset($ticket->customer_state)?$ticket->customer_state:'';
									if(!empty($stateList)){
										foreach($stateList as $singleStateList){
											$allstate[$singleStateList->id] = $singleStateList->name;
										}                    
                                    }                    
                                    echo form_dropdown('customer_state', $allstate, set_value('customer_state',$selected_state), 'class="form-control" id="customer_state"'); 
									echo '<div class="error-msg">' . form_error('customer_state') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('City *', 'customer_city');
									$city	= isset($ticket->customer_city)?$ticket->customer_city:'';
									echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city',$city), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
									echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Pincode *', 'customer_pincode');
									$pincode	= isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
									echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control', 'value' => set_value('customer_pincode',$pincode), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6', 'placeholder' => 'Pincode'));
									echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
                                echo form_label('Address *', 'customer_address');
								$address	= isset($ticket->customer_address)?$ticket->customer_address:'';
                                echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control', 'value' => set_value('customer_address',$address), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Address'));
                                echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "update_tkt_btn", "value" => "Submit"));
                               echo '&nbsp;&nbsp;<a href="' . base_url('ticket/list') . '" class="btn btn-danger">Cancel</a>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>






