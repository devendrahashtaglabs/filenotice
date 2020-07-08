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
                    <?php
						echo form_open_multipart($pageUrl.'/create', array('class' => 'create_ticket', 'id' => 'CustomerTicketForm'));
                    ?>
                    
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
									echo form_label('Category*', 'category_id');
									$option = array("" => "Select Category");
									foreach ($categories as $key => $value) {
										$option[$value->id] = ucfirst($value->name);
									}
									echo form_dropdown('category_id', $option, $selected = set_value('category_id'), $extra = 'class="form-control category_id" id="category_id" data-url="' . base_url("admin/ticket/getsubcategory") . '"');
									echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
                                 <input type="hidden" class="categorytext" name="categorytext" value="">
                            </div>  
                            
                            <div class="form-group col-6 sub-categoryBox" style="display: none" id="sub-categoryBox">
                                <?php echo form_label('Sub Category', 'subcategory_id'); ?>
                                <div class="append-sub-category">
                                </div>
                                <span style="color: red;"><?php echo form_error('subcategory_id'); ?></span>
                            </div>
                            <!-- <div class="form-group col-6">
                                <?php
                                // echo form_label('Start Date*', 'start_date');
                                // echo form_input(array('name' => 'start_date', 'class' => 'form-control datepicker', 'value' => set_value('start_date'), 'id' => "start_date", 'placeholder' => 'Start Date', 'readonly' => 'readonly'));
                                // echo '<div class="error-msg">' . form_error('start_date') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-6">
                                <?php
                                // echo form_label('Close Date*', 'close_date');
                                // echo form_input(array('name' => 'close_date', 'class' => 'form-control datepicker', 'value' => set_value('close_date'), 'id' => "close_date", 'placeholder' => 'Close Date', 'readonly' => 'readonly'));
                                // echo '<div class="error-msg">' . form_error('close_date') . '</div>';
                                ?>
                            </div> -->
                            <!--  <div class="form-group col-6">
                                <?php
                                // echo form_label('Ticket Status*', 'ticket_status');
                                // echo form_dropdown('ticket_status', $options = array(
                                //     '' => 'Select Status',
                                //     '1' => 'Working',
                                //     '0' => 'Completed',
                                //         ), $selected = set_value('ticket_status'), $extra = 'class= "form-control",id="ticket_status"');
                                // echo '<div class="error-msg">' . form_error('close_date') . '</div>';
                                ?>
                            </div> -->
                           <!--  <div class="form-group col-6">
                                <?php
                                // echo form_label('Payment Status*', 'payment_status');
                                // echo form_dropdown('payment_status', $options = array(
                                //     '' => 'Select Status',
                                //     '1' => 'Completed',
                                //     '0' => 'Pending',
                                //         ), $selected = set_value('payment_status'), $extra = 'class="form-control",id="payment_status"');
                                // echo '<div class="error-msg">' . form_error('payment_status') . '</div>';
                                ?>
                            </div> 
                            <div class="form-group col-6">
                                <?php
									/* echo form_label('Status*', 'status');
									echo form_dropdown('status', $options = array(
										'' => 'Select Status',
										'1' => 'Active',
										'0' => 'Inactive',
											), $selected = set_value('status','1'), $extra = 'class="form-control" id="status"');
									echo '<div class="error-msg">' . form_error('status') . '</div>'; */
                                ?>
                            </div>-->
                            
                            <div class="form-group col-6">
                               <?php echo form_label('Document Upload *', 'image'); ?>
                                <input type="file" name="image[]" id="image" class="form-control" size="20" required />
								<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx / Max. upload size 2MB)</span></label>
                                <?php echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Description*', 'description');
									echo '<label><span class="text-danger" style="font-size:10px;">(Please enter less than 200 characters.)</span></label>';
									echo form_textarea(array('name' => 'description', 'class' => 'form-control', 'value' => set_value('description'), 'id' => "description", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Description'));
									echo '<div class="error-msg">' . form_error('description') . '</div>';
                                ?>
                            </div>
						</div>
						<div class="row">
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
							<div class="form-group col-6">
                                <?php
									echo form_label('Select State*', 'customer_state');
									$allstate      	= [];
                                    $allstate['']  	= 'Select State';
									$selected_state	= '38';
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
									echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city'), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
									echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
									echo form_label('Pin  code *', 'customer_pincode');
									echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control', 'value' => set_value('customer_pincode'), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6', 'placeholder' => 'Pin code'));
									echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
                                ?>
                            </div>
							<div class="form-group col-6">
                                <?php
                                echo form_label('Address *', 'customer_address');
                                echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control', 'value' => set_value('customer_address'), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Address'));
                                echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
                                ?>
                            </div>
                            <div class="form-group col-12">
                                <?php
                                echo form_submit(array("class" => "btn btn-success", "id" => "create_tkt_btn", "value" => "Submit"));
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $('.category_id').change(function() {
     var selectedText = $(this).find("option:selected").text();
     //alert( selectedText );
    $('.categorytext').val(selectedText);
});
});
</script>
