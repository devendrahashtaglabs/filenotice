<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script>
<style type="text/css">
.editdetailspge {
    background: #f4f4ff;
    padding: 10px;
}
.editdetailspge .form-control {
    height: 30px;
    padding: 1px 12px;
    font-size: 12px;
    line-height: 1.42857143;
    background-color: #fff;
}
.editdetailspge select.form-control {
    height: 30px !important;
}
#description {
    min-height: 124px;
}
.editdetailspge label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 0;
    font-weight: 400;
    color: #333;
    font-size: 8px;
    line-height: 17px;
}
#ticketfile_table_id_filter {
    float: right;
}
#ticketfile_table_id_length {
    float: left;
}
#ticketfile_table_id tr th {
    background: #494e53;
    color: #fff;
}
.table-responsive.customizetableres label {
    font-size: 14px;
    color: #333;
}
.table-responsive.customizetableres {
    margin-top: 25px;
}
#ticketfile_table_id_info {
    float: left;
    padding-top: 0;
}
#ticketfile_table_id_paginate {
    float: right;
}
.form-group:last-of-type {
    margin-top: 0;
}
.form-group{
    margin-bottom: 8px;
}
.subtitkes{
    float: left;
    font-size: 18px;
    font-weight: bold;
    color: #263a7d;
}
.editdetailspge .btn.btn-danger {
    background: #263a7d;
    color: #fff;
    border: 2px solid #263a7d;
}
.editdetailspge .btn.btn-warning {
    background: #F3781E;
    color: #fff;
    border: 2px solid #F3781E;
}
#casefilename {
    width: 48%;
    float: left;
    margin-right: 9.5px;
}
.form-control.casefile {
    width: 50%;
    float: left;
    padding: 4px 2px !important;
}
.clone.mt-2 {
    font-size: 12px;
}
.clone {
    width: 100%;
    background-position: bottom left;
    background-size: 17px;
    top: 0px;
}
#ticketfile_table_id_filter input {
    background: #fff;
    border: 1px solid #ccc;
    padding: 1px 12px;
    line-height: 1.42857143;
    height: 30px;
    border-radius: 4px;
}
#ticketfile_table_id_length select{
    background: #fff;
    border: 1px solid #ccc;
    padding: 1px 12px;
    line-height: 1.42857143;
    height: 30px;
    border-radius: 4px;
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
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                   <?php echo form_open_multipart($pageUrl.'/edit/'. $ticket->id, array('id' => 'CustomerTicketForm')); ?>
                    <div class="card-body">
                        <div class="editdetailspge">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
						<div class="row">
							<div class="col-12">
								<h4 class="subtitkes">Ticket Info</h4>
							</div>
						</div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                <?php
                                    echo form_label('Ticket ID', 'ticket_id');
                                    echo form_input(array('name' => 'ticket_id', 'class' => 'form-control', 'value' => set_value('ticket_id',$ticket->ticket_id), 'id' => "ticket_id", 'readonly' => 'true'));
                                    echo form_input(array('name' => 'id', 'type' => 'hidden', 'value' => $ticket->id, 'id' => "id"));
                                    echo '<div class="error-msg">' . form_error('ticket_id') . '</div>';
                                ?>
                                </div>
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
                            </div> 
                            <div class="form-group col-6">
                                <?php
                                /* echo form_label('Status', 'status');
                                echo form_dropdown('status', $options = array(
                                    '' => 'Select Status',
                                    '1' => 'Active',
                                    '0' => 'Inactive',
                                ), $selected=set_value('status',$ticket->status), $extra = 'class="form-control",id="status"');
                                echo '<div class="error-msg">' . form_error('status') . '</div>'; */
                                ?>
                            </div>-->
                            <div class="col-4">
							<div class="form-group">
                                <?php
                                echo form_label('Category*', 'category_id');
                                $option = array("" => "Select Category");
                                foreach ($categories as $key => $value) {
                                    $option[$value->id] = ucfirst($value->name);
                                }
                                echo form_dropdown('category_id',$option,$selected=set_value('category_id',$ticket->categoryid), $extra='class="form-control category_id" id="category_id" data-url="' . base_url("admin/ticket/getsubcategory") . '"', false);
                                echo '<div class="error-msg">' . form_error('category_id') . '</div>';
                                ?>
								<input type="hidden" class="categorytext" name="categorytext" value="">
                            </div>
                        </div>
                        <div class="col-4">
							<div class="form-group">
                                <?php
									echo form_label('Subcategory *', 'subcategory_id');
                                    $option = array('' => 'Select Sub-category');
									if(!empty($ticket->category_id)){
										$sections 		= $this->category_model->getsubcategory($ticket->category_id);
										foreach ($sections as $key => $value) {
											$option[$value->id] = ucfirst($value->name);
										}
									}
									$subcatId = '';
									if(!empty($ticket->subcategory_id)){
										$subcatId = $ticket->subcategory_id;
									}
                                    echo form_dropdown('subcategory_id', $option, set_value('subcategory_id',$subcatId), $extra = 'class= "form-control" id="subcategory_id"');
                                    echo '<div class="error-msg">' . form_error('subcategory_id') . '</div>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">							
							<div class="form-group">
                            <?php
                                echo form_label('Description*', 'description');
								echo '<label><span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Please enter less than 500 characters.)</span></label>';
                                echo form_textarea(array('name'=>'description','class'=>'form-control','value'=>set_value('description',$ticket->description),
                                    'id' => "description",'cols' => '10','rows' => '3','onkeyup'=>'countChar(this,500)'
                                ));
								echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
                                echo '<div class="error-msg">' . form_error('description') . '</div>';
                            ?>
                            </div>
						</div>
                        <div class="col-6">
                            <div class="stuffs_to_clone">
                                    <div class="stuff mt-3">
                                        <div class="form-group">
                                            <input type="text" class="form-control casefilename" name="casefilename[]" placeholder="Document Name" />
                                            <input type="file" id="image" style="line-height: 16px !important; padding: 3px 5px;" class="form-control casefile" name="image[]" />
                                            <div class="del disabled hidden"></div>
                                        </div>
                                    </div>
                                    <div class="clone mt-2" title="Add more files">Add more files</div>
                                </div>
                                <!--<input type="file" name="image[]" id="image" class="form-control" size="20" multiple required />-->
                                <label><span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx )</span></label>
                                <?php echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
                        </div>
                    </div>
						<div class="row">
							<div class="form-group col-12">
							   <?php echo form_label('Document Uploaded', 'image'); ?>
							   <div class="table-responsive customizetableres">
                        			<table id="ticketfile_table_id" class="table table-bordered table-striped" style="margin-top: 20px;">
										<thead>
											<tr>
												<th>#</th>
												<th>Document Name</th>
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
								<h4 class="subtitkes">Communication Info</h4>
							</div>
						</div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="title">Title</label><select name="title" class="form-control" id="sel1" tabindex="1">
<option value="Mr">Mr.</option>
<option value="Mrs">Mrs.</option>
</select>                           
                                </div>  
                            </div>
                            <div class="col-md-5">                
                                <div class="form-group">
                                    <label for="fname">First Name *</label><input type="text" name="fname" value="Deepak" class="form-control" id="fname" placeholder="Name*" onkeypress="return alpha(event)" maxlength="50" tabindex="2"><div class="error-msg"></div>                    
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="sname">Last Name *</label><input type="text" name="sname" value="" class="form-control" id="sname" placeholder="Surname Name*" onkeypress="return alpha(event)" maxlength="50" tabindex="3"><div class="error-msg"></div>   
                                </div>
                            </div>
                    </div>

						<div class="row">
                            <div class="col-6">
    							<div class="form-group">
                                    <?php
    									echo form_label('Mobile Number*', 'customer_mobile');
    									echo form_input(array('name' => 'customer_mobile', 'class' => 'form-control', 'value' => set_value('customer_mobile',$ticket->customer_mobile), 'maxlength' => '10', 'placeholder' => 'Mobile Number'));
    									echo '<div class="error-msg">' . form_error('customer_mobile') . '</div>';
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email *</label><input type="email" name="email" value="deepak@yopmail.com" class="form-control " id="email" placeholder="Email Id*" maxlength="50" tabindex="4"><div class="error-msg"></div>                            </div>
                        </div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                 <div class="form-group customtextre">
                                <?php
                                echo form_label('Address *', 'customer_address');
                                $address    = isset($ticket->customer_address)?$ticket->customer_address:'';
                                echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control', 'value' => set_value('customer_address',$address), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'placeholder' => 'Address'));
                                echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
                                ?>
                            </div>                              
                            
                            </div>
                            <div class="col-3">
                               <div class="form-group">
                                <?php
                                    echo form_label('Pin code *', 'customer_pincode');
                                    $pincode    = isset($ticket->customer_pincode)?$ticket->customer_pincode:'';
                                    echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control', 'value' => set_value('customer_pincode',$pincode), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6', 'placeholder' => 'Pin code'));
                                    echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
                                ?>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                <?php
                                    echo form_label('Select Country *', 'customer_country');
                                    $allCountry         = [];
                                    $allCountry['']     = 'Select Country';
                                    $selected_country   = isset($ticket->customer_country)?$ticket->customer_country:'';
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
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <?php
                                    echo form_label('Select State*', 'customer_state');
                                    $allstate       = [];
                                    $allstate['']   = 'Select State';
                                    $selected_state = isset($ticket->customer_state)?$ticket->customer_state:'';
                                    if(!empty($stateList)){
                                        foreach($stateList as $singleStateList){
                                            $allstate[$singleStateList->id] = $singleStateList->name;
                                        }                    
                                    }                    
                                    echo form_dropdown('customer_state', $allstate, set_value('customer_state',$selected_state), 'class="form-control" id="customer_state"'); 
                                    echo '<div class="error-msg">' . form_error('customer_state') . '</div>';
                                ?>
                            </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <?php
                                    $cityquery = $this->user_model->getCityList('',$ticket->customer_state);
                                    echo form_label('City *', 'customer_city');
                                    $allcity        = [];
                                    $allcity['']    = 'Select City';
                                    if(!empty($cityquery)){
                                        foreach($cityquery as $singleCityList){
                                            $allcity[$singleCityList->city_id] = $singleCityList->city_name;
                                        }                    
                                    }                    
                                    echo form_dropdown('customer_city', $allcity, set_value('customer_city',$ticket->customer_city), 'class="form-control" id="customer_city"'); 
                                    echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
                                    /* echo form_label('City *', 'customer_city');
                                    $city   = isset($ticket->customer_city)?$ticket->customer_city:'';
                                    echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city',$city), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
                                    echo '<div class="error-msg">' . form_error('customer_city') . '</div>'; */
                                ?>
                            </div>
                            </div>
                        </div>
						
						<div class="row">
                            <div class="form-group col-12 text-right mt-2">
                                <?php
                                echo '&nbsp;&nbsp;<a href="' . base_url('ticket/new_assign_list') . '" class="btn btn-danger">Cancel</a>';
                                echo form_submit(array("class" => "btn btn-warning", "id" => "update_tkt_btn", "value" => "Submit"));
                              
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
	$('.category_id').change(function() {
		var selectedText = $(this).find("option:selected").text();
		//alert( selectedText );
		$('.categorytext').val(selectedText);
	});
	$(".toChange").click(function() {
		var rowid 		= $(this).data("id");
		var ticketid 	= $(this).data("ticket");
		$.ajax({
			url: "<?php echo base_url(); ?>users/customerController/deleteticketfile",
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
            //$new_element = $new_element.find(".").val("").end();

        $new_element.find('.del').removeClass('hidden disabled').addClass('enabled');
        $new_element.insertAfter($element_to_clone);
        return false;
    });

    $("body").on("click", ".del.enabled", function(event) {
        var $parent = $(this).parent().parent();
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
	$('#image').on('change', function() { 
		var fileExt = $(this).val().split('.').pop();
		if(fileExt === 'jpg' || fileExt === 'gif' || fileExt === 'png' || fileExt === 'jpeg' || fileExt === 'pdf' || fileExt === 'doc' || fileExt === 'docx' || fileExt === 'xls' || fileExt === 'xlsx'){
			if (this.files[0].size > 2097152) { 
				var extension = file.substr( (file.lastIndexOf('.') +1) );
				alert("Try to upload file less than 2MB!"); 
				$(this).val('');
			}
		}else{
			alert("Try to upload allowed file type!"); 
			$(this).val('');
		}
	}); 
	$("#customer_state").change(function() { 
		var $option = $(this).find('option:selected');
		var stateId = $option.val();
		$.ajax({
			url: '<?php echo base_url();?>users/customerController/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#customer_city").html(data);
			}
		});
	});
	
</script>





