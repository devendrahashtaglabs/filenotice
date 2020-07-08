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
                    <?php echo form_open_multipart($pageUrl.'/edit/'. $ticket->id, array('class' => 'Edit_ticket', 'id' => 'TicketForm'));?>
                    <div class="card-body">
						<?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
                        <?php if ($this->session->flashdata('flash_msg') != "") { ?>
                            <div class="alert alert-success" id="alert-success-div">
                                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                <?php echo $this->session->flashdata('flash_msg'); ?>
                                <button type="button" class="close" aria-label="Close" id="msg-close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php } ?>
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
                                if($ticket->start_date != ''){
                                    $dateVAl = set_value('start_date',date('d-m-Y', strtotime($ticket->start_date)));
                                }else{
                                    $dateVAl = '';
                                }
                                echo form_label('Start Date*', 'start_date');
                                echo form_input(array('name' => 'start_date', 'class' => 'form-control datepicker', 'value'=>$dateVAl, 'id' => "start_date", 'placeholder' => 'Start Date','readonly'=>'readonly'));
                                echo '<div class="error-msg">' . form_error('start_date') . '</div>';
                                ?>
                            </div>
                            
                            <div class="form-group col-6">
                                <?php echo form_label('Ticket Status*', 'ticket_status'); ?>
                                <?php
									$options = [];
									foreach($ticket_status as $status){
										$options[$status->status_code] = $status->status;
									}
									echo form_dropdown('ticket_status', $options, $selected = set_value('ticket_status',$ticket->ticket_status), $extra = 'class="form-control" id="ticket_status"');
									echo '<div class="error-msg">' . form_error('ticket_status') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
									echo form_label('Category*', 'category_id');
									$option = array("" => "Select Category");
									foreach ($categories as $key => $value) {
										$option[$value->id] = ucfirst($value->name);
									}
									echo form_dropdown('category_id', $option, $selected = set_value('category_id',$ticket->categoryid), $extra = 'class="form-control category_id", id="category_id" data-url="' . base_url("admin/ticket/getsubcategory") . '"', false);
									echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6 sub-categoryBox" style="display: none" id="sub-categoryBox">
                                <?php echo form_label('Sub Category*', 'subcategory_id'); ?>
                                <div class="append-sub-category">
                                </div>
                                <span style="color: red;"><?php echo form_error('subcategory_id'); ?></span>
                            </div>

                            <div class="form-group col-6">
                                <?php echo form_label('Payment Status*', 'payment_status'); ?>
                                <?php
                                echo form_dropdown('payment_status', $options = array(
                                    '' => 'Select Status',
                                    '1' => 'Completed',
                                    '0' => 'Pending',
                                ), $selected = $ticket->payment_status, $extra = 'class="form-control",id="payment_status"');
                                echo '<div class="error-msg">' . form_error('payment_status') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                echo form_label('Status*', 'status');
                                echo form_dropdown('status', $options = array(
                                    '' => 'Select Status',
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                        ), $selected = $ticket->status, $extra = 'class="form-control",id="status"');
                                echo '<div class="error-msg">' . form_error('status') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                            <?php
                                echo form_label('Description', 'description'); echo ' <label><span class="text-danger" style="font-size:10px;">(Maximum 200 characters)</span></label>';
                                echo form_textarea(array('name' => 'description',
                                    'class' => 'form-control',
                                    'value' => $ticket->description,
                                    'id' => "description",
                                    'cols' => '10', 
                                    'rows' => '5'
                                ));
                                echo '<div class="error-msg">' . form_error('description') . '</div>';
                            ?>
                            </div>
							<div class="col-6">
                                <?php
                                echo form_label('Address *', 'customer_address');
								$selectedAddress = isset($ticket->customer_address)?$ticket->customer_address:'';
								echo form_textarea(array('name' => 'customer_address',
                                    'class' => 'form-control',
                                    'value' => $selectedAddress,
                                    'id' => "customer_address",
                                    'cols' => '10', 
                                    'rows' => '5',
									'placeholder' => 'Address'
                                ));
                                //echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control', 'value' => set_value('customer_address',$selectedAddress), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Address'));
                                echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
                                ?>
                            </div>
                        </div>
						<div class="row mt-3">
							<div class="form-group col-6">
                                <?php
									echo form_label('City *', 'customer_city');
									$selectedCity = isset($ticket->customer_city)?$ticket->customer_city:'';
									echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city',$selectedCity), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
									echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
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
									echo form_label('Select Country *', 'customer_country');
                                    $allCountry        	= [];
                                    $allCountry['']    	= 'Select Country';
									$selected_country	= '88';
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
							<div class="col-6">
                                <?php
									echo form_label('Pin code *', 'customer_pincode');
									$selectedPincode = isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
									echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control', 'value' => set_value('customer_pincode',$selectedPincode), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6', 'placeholder' => 'Pin code'));
									echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
                                ?>
                            </div>
                        </div>
						<div class="row">
							<div class="form-group col-12">
							   <?php echo form_label('Document Upload *', 'image'); ?>
							   <div class="table-responsive customizetableres">
                        			<table id="ticketfile_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Filename</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
												if(!empty($ticket->file)) {
													$files = json_decode($ticket->file);
													//$files = explode(',',$ticket->file);
													$filecount 	= count($files);
													$counter 	= 1;
													foreach($files as $file){
											?>
											<tr>
												<td><?php echo $counter; ?></td>
												<td><?php echo !empty($file->filename)?$file->filename:'casefile';?></td>
												<td><a href="<?php echo base_url().'uploads/ticket/'.$file->file; ?>" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a><a href="javascript:;" class="toChange" data-ticket="<?php echo $ticket->id; ?>" data-id="<?php echo $counter-1; ?>" data-massege ="Are you sure want to delete!" title="Delete File"><i class="fa fa-trash" aria-hidden="true" style="color:red;margin-left: 5px;"></i></a></td>
											</tr>
											<?php $counter++; } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="stuffs_to_clone">
									<div class="stuff mt-3">
										<div class="form-group col-12">
											<input type="text" class="form-control casefilename" name="casefilename[]" placeholder="Document Name" />
											<input type="file" id="image" class="form-control casefile" name="userfile[]" />
											<div class="del disabled hidden"></div>
										</div>
									</div>
									<div class="clone mt-2" title="Add more files">Add more files</div>
								</div>
								<!--<input type="file" name="image[]" id="image" class="form-control" size="20" multiple required />-->
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx )</span></label>
								<?php echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
							</div>
						</div>
                    </div>
                    <div class="card-footer">
                        <?php
                        echo form_submit(array("class" => "btn btn-success", "id" => "update_tkt_btn", "value" => "Submit"));
                        echo '&nbsp;&nbsp;<a href="' . base_url($this->session->userdata('admins')['user_type'].'/ticket/ticket_list') . '" class="btn btn-danger">Cancel</a>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
	$(".toChange").click(function() {
		var rowid 		= $(this).data("id");
		var ticketid 	= $(this).data("ticket");
		$.ajax({
			url: "<?php echo base_url(); ?>admin/ticket/deleteticketfile",
			type : "POST",
			dataType : "json",
			data : { 'rowid' : rowid,'ticketid':ticketid },
			success : function(data) {
				if(data){
					var currenturl = '<?php echo current_url(); ?>';
					window.location.href = currenturl;
				}
			},
			error : function(data) {
				//alert(data);
			}
		});
	});
	$(".clone").click(function() {
        var
        $self = $(this),
            $element_to_clone = $self.prev(),
            $wrapper_parent_element = $self.parent(),
            $new_element = $element_to_clone.clone().find("input:text,input:file").val("").end();

        $new_element.find('.del').removeClass('hidden disabled').addClass('enabled');

        $new_element.insertAfter($element_to_clone);

        return false;
    });

    $("body").on("click", ".del.enabled", function(event) {
        var $parent = $(this).parent();
        $parent.remove();
        return false;
    });
	var arr = [];
	$(document.body).on("change","#image", function() {
		var filename = $(this).val();
		var lastIndex = filename.lastIndexOf("\\");
		if (lastIndex >= 0) {
			filename = filename.substring(lastIndex + 1);
		}
		if ($.inArray(filename, arr) != -1)
		{
		  alert(filename + " already selected");
		  $(this).val('');
		}
		arr.push(filename);
	});
</script>





