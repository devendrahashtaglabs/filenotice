<?php 
	$ticketformdata = $this->session->userdata('ticketformdata');
?>
<style>
	label.error {
		margin-top: -1px;
		font-size: 12px;
	}
	.error {
		color: red;
		font-size: 12px;
	}
	
</style>
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js"></script>
<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script> 
<style>
.form-group:last-of-type {
	margin-top:0px;
}
.customtextre textarea{
	height: 38px;
}
.form-group:last-of-type {
	margin-top:0px;
}
.amount{
	min-height:60px;
}
.services {
	min-height: 298px;
	margin-bottom: 70px;
	padding: 20px 15px;
}
.desc h3 {
	font-size: 18px;
	min-height: 35px;
	margin: 0 0 10px;
}
.services.catcitydiv{
	background: #00000057;	
}
.services.catcitydiv .details {
	position: absolute;
	top: 0;
	height: 100%;
	left: 0;
	width: 100%;
}
.services.catcitydiv .details p{
	color: red;
	font-size: 18px;
	padding: 2px;
	display: flex;
	height: 100%;
	justify-content: center;
	align-items: center;
	margin: auto;
}
.active-screen .number::after {
	top: 0;
}
.active-screen .number a i {
	position: relative;
	top: 18px;
}
.active-screen .number.four::after {
	content: "";
}
.subcatinfo label {
    font-size: 14px;
}
.form-group.bluethis {
	margin: 10px 0px;
	text-align: center;
}
.form-group.bluethis label {
	font-size: 14px;
	line-height: 12px;
	margin: 0;
	color: #333;
	font-weight: normal;
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
                    <?php //echo $breadcrumb; ?>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php //echo $page_title; ?></h3>
                    </div>
					<!-- Your code here -->
					<form action="#" id="payment_form">
						<div class="card-body">
							<?php 
								$catname 	= !empty($ticketformdata['categorytext'])?$ticketformdata['categorytext']:'';
								$subcatname = !empty($ticketformdata['name'])?$ticketformdata['name']:'';
								$productinfo = ' '. $catname .' - '.$subcatname; 
							?>
							<div class="row">
								<div class="col-md-12">
								  <h2 class="puttocenter"><?php echo $catname; ?></h2>
								</div>
							</div>
							<input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
							<input type="hidden" id="surl" name="surl" value="<?php echo base_url().'users/ticketController/payment_response'; ?>" />
							<input type="hidden" id="furl" name="furl" value="<?php echo base_url().'create_ticket/?catid='.$ticketformdata['urlcatid']; ?>" />
							<div class="dv">
								<input type="hidden" id="key" name="key" placeholder="Merchant Key" value="<?php echo MERCHANT_KEY; ?>" />
							</div>
							
							<div class="dv">
								<input type="hidden" id="salt" name="salt" placeholder="Merchant Salt" value="<?php echo MERCHANT_SALT; ?>" />
							</div>
							
							<div class="dv">
								<input type="hidden" id="txnid" name="txnid" placeholder="Transaction ID" value="<?php echo  "Txn" . rand(10000,99999999)?>" />
							</div>
							 <div class="form-group bluethis">
								<label for="product_info">Product Info :- &nbsp; <?php echo $productinfo; ?></label>
							  </div>
							  <div class="dv">
								<input type="hidden" id="pinfo" name="pinfo" placeholder="Product Info" value="<?php echo !empty($productinfo)?$productinfo:''; ?>" />
							  </div>
								<?php 
									$amount = !empty($ticketformdata['amount'])?$ticketformdata['amount']:'';
								?>
							  <div class="form-group bluethis">
								<label for="product_amount">Amount :- &nbsp;<i class="fa fa-inr" aria-hidden="true"></i> <?php echo $amount; ?></label>
							  </div>
							  <div class="dv">
								<input type="hidden" id="amount" name="amount" placeholder="Amount" value="<?php echo $amount; ?>" />
							  </div>
						
						<div class="form-group">
							<?php
								$name = !empty($userdata)?$userdata->name:'';
								$data = [
										'type'  => 'hidden',
										'name'  => 'fname',
										'id'    => 'fname',
										'value' => $name,
								];
								echo form_input($data);
							?>
						</div>
						<div class="form-group">
							<?php
								$email = !empty($userdata)?$userdata->email:'';
								$data = [
										'type'  => 'hidden',
										'name'  => 'email',
										'id'    => 'email',
										'value' => $email,
								];
								echo form_input($data);
							?>
						</div>
						<div class="form-group">
							<?php
								//$mobile = !empty($userdata)?$userdata->mobile:'';
								$mobile = !empty($ticketformdata['customer_mobile'])?$ticketformdata['customer_mobile']:'';
								//echo form_label('Mobile Number*', 'mobile');
								$data = [
										'type'  => 'hidden',
										'name'  => 'mobile',
										'id'    => 'mobile',
										'value' => $mobile,
								];
								echo form_input($data);
							?>
						</div>
						
						<div class="dv">
							<div class="form-group">
								<span><input type="hidden" id="hash" name="hash" placeholder="Hash" value="" class="form-control" /></span>
							</div>
						</div>
					<div class="customlbleint custom-form">
						<div class="row">
							<div class="numbersssdtfss">
							<?php 
								$currenturl = current_url();
								$params   	= $_SERVER['QUERY_STRING']; 
								$fullURL 	= $currenturl . '/?' . $params; 
							?>
							  <div class="active-screen createticket">							  
								  <div class="number-account reacehd">
									<span class="number two">
										<a href="<?php echo $fullURL; ?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
									 </span>
									<span class="text-part">
										Ticket Details
									</span>
								  </div>
								  <div class="number-account">
									<span class="number three active">
										<a href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
									</span>
									<span class="text-part active">
										Review & Pay
									</span>
								  </div>
								  <div class="number-account">
									<span class="number four notreached">
										<a href="javascript:void(0);"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
									</span>
									<span class="text-part">
										Ticket Consultancy
									</span>
								  </div>
								</div>
							</div>
						</div>
						<div class="bagckgrdcolor">
							<div class="row floating-laebls">
								<div class="col-md-6">
									<h3 class="title-section mycit">Communication Details</h3>
									<div class="row mt-5">
										<div class="col-md-2">
											<?php 
												$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
											?>
											<div class="form-group inputBox focus">
												<?php 
													echo form_label('Title', 'title');
													$allprefix = [];
													foreach($prefixdata as $prefix){
														$allprefix[$prefix->id] = $prefix->title;
													}
													$selectedtitle = $ticketformdata['title'];
													echo form_dropdown('title', $allprefix, set_value('title',$selectedtitle), 'class="form-control input" id="sel1" tabindex="1" disabled="disabled"');
												?>								
											 </div>  
										</div>
										<div class="col-md-5">                
											<div class="form-group inputBox focus">
												<?php
													$selectedfname = $ticketformdata['fname'];
													echo form_label('Name *', 'fname');
													echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$selectedfname), 'id' => "fname",  'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2','disabled'=>'disabled'));
													echo '<div class="error-msg">' . form_error('fname') . '</div>';
												?>				
											</div>
										</div>
										<div class="col-md-5">
											<div class="form-group inputBox focus">
												<?php
													$selectedsname = $ticketformdata['sname'];
													echo form_label('Surname Name *', 'sname');
													echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$selectedsname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3','disabled'=>'disabled'));
													echo '<div class="error-msg">' . form_error('sname') . '</div>';
												?>							
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 havwesomeadon">
											<div class="form-group inputBox focus">
												<?php echo form_label('Mobile Number*', 'customer_mobile'); ?>
												<div class="input-group">
													<span class="input-group-addon" id="sizing-addon1">+91</span>
												<?php
													$ticketmobile = !empty($ticketformdata['customer_mobile'])?$ticketformdata['customer_mobile']:'';
													$customermobile = !empty($selectedcityid)?'':$ticketmobile;
													if(empty($customermobile)){
														$customermobile = $ticketmobile;
													}
													echo form_input(array('name' => 'customer_mobile', 'class' => 'form-control input', 'value' => set_value('customer_mobile',$customermobile), 'maxlength' => '10', 'disabled' => 'disabled'));
												?>
											   </div>
											</div>
										</div>								
										<div class="col-md-6">
											<div class="form-group inputBox focus">
												<?php
													$selectedemail = $ticketformdata['email'];
													echo form_label('Email *', 'email');
													echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$selectedemail), 'id' => "email",'maxlength'=>'50','tabindex'=>'4','disabled'=>'disabled'));
													echo '<div class="error-msg">' . form_error('email') . '</div>';
												?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-9">
											<div class="form-group inputBox focus customtextre">
												<?php
													$ticketaddress = !empty($ticketformdata['customer_address'])?$ticketformdata['customer_address']:'';
													$customeraddress = !empty($selectedcityid)?'':$ticketaddress;
													echo form_label('Address *', 'customer_address');
													echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control input', 'value' => set_value('customer_address',$customeraddress), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'disabled'=>'disabled'));
													//echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
												?>
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group inputBox focus">
												<?php
													$ticketpincode = !empty($ticketformdata['customer_pincode'])?$ticketformdata['customer_pincode']:'';
													$customerzip = !empty($selectedcityid)?'':$ticketpincode;
													echo form_label('Pin code *', 'customer_pincode');
													echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control input', 'value' => set_value('customer_pincode',$customerzip), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6','disabled'=>'disabled'));
													//echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
												?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group inputBox focus">
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
													echo form_dropdown('customer_country', $allCountry, set_value('customer_country',$selected_country), 'class="form-control input" id="customer_country" disabled="disabled"');
													echo form_hidden('customer_country',$selected_country);
													//echo '<div class="error-msg">' . form_error('customer_country') . '</div>';
												?>
											</div>					
										</div>
										<div class="col-md-4">
											<?php 
												$ticketstate = !empty($ticketformdata['customer_state'])?$ticketformdata['customer_state']:'';
												$ticketcity = !empty($ticketformdata['customer_city'])?$ticketformdata['customer_city']:'';
												$selectedstate 	= '';
												if(!empty($selectedcityid)){
													$selectedcity 	= $this->user_model->getCityList($selectedcityid,'');
													$selectedstate  = $selectedcity->city_state;
												}
												$selected_state	= !empty($selectedstate)?$selectedstate:$ticketstate;
												$choosedcity 	= !empty($selectedcityid)?$selectedcityid:$ticketcity;
											?>
											<div class="form-group inputBox focus">
												<?php
													echo form_label('Select State*', 'customer_state');
													$allstate      	= [];
													$allstate['']  	= 'Select State';
													//$selected_state	= $customerData->state_id;
													if(!empty($stateList)){
														foreach($stateList as $singleStateList){
															$allstate[$singleStateList->id] = $singleStateList->name;
														}                    
													}                    
													echo form_dropdown('customer_state', $allstate, set_value('customer_state',$selected_state), 'class="form-control input" id="customer_state" disabled="disabled"'); 
													//echo '<div class="error-msg">' . form_error('customer_state') . '</div>';
												?>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group inputBox focus">
												<?php
													$cityquery = $this->user_model->getCityList('',$ticketstate);
													echo form_label('City *', 'customer_city');
													$allcity      	= [];
													$allcity['']  	= 'Select City';
													if(!empty($cityquery)){
														foreach($cityquery as $singleCityList){
															$allcity[$singleCityList->city_id] = $singleCityList->city_name;
														}                    
													}                    
													echo form_dropdown('customer_city', $allcity, set_value('customer_city',$choosedcity), 'class="form-control input" id="customer_city" disabled="disabled"'); 
													//echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
													/* echo form_label('City *', 'customer_city');
													echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city'), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
													echo '<div class="error-msg">' . form_error('customer_city') . '</div>'; */
												?>
											</div>  
										</div>
									</div>	
									<h3 class="title-section mycit">Ticket Details</h3>
								<div class="mt-5">
									<div class="form-group inputBox focus">
										<?php
											$ticketdesc = !empty($ticketformdata['description'])?$ticketformdata['description']:'';
											echo form_label('Query or describe your problem* (<span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Please enter less than 500 characters.)</span>)', 'description');
											echo form_textarea(array('name' => 'description', 'class' => 'form-control input', 'value' => set_value('description',$ticketdesc), 'id' => "description", 'cols' => '10', 'rows' => '3','onkeyup'=>'countChar(this,500)','disabled'=>'disabled'));
											echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
											//echo '<div class="error-msg">' . form_error('description') . '</div>';
										?>
									</div>
								</div>
								<div class="mt-3">
									<div class="form-group inputBox focus">
										<?php echo form_label('Uploaded Document', 'image'); ?>
											<?php 
												/*<div class="stuffs_to_clone">
													<div class="stuff mt-3 mystyuff">
														<div class="form-group">
															<input type="text" class="form-control casefilename" name="casefilename[]" placeholder="Document Name" id="casefilename" />
															<input type="file" id="image" class="form-control casefile" name="image[]" />
															<div class="del disabled hidden"></div>
														</div>
													</div>
													<div class="clone mt-2" title="Add more files">Add more files</div>
													<div id="upload_prev" style="display:none;"></div>
												</div>
												<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 2MB)</span></label> */ 
											?>
											<br/>
											<?php 
												$imagename 			= $ticketformdata['imagename'];
												$alluploadedfiles 	= json_decode($imagename);
												if(!empty($alluploadedfiles)){
													$counter 	= 1;
													$allfiles 	= count($alluploadedfiles);
													foreach($alluploadedfiles as $alluploadedfile){ 
											?>
												<a href="<?php echo base_url().'uploads/ticket/'.$alluploadedfile->file; ?>" target="_blank"><?php echo $alluploadedfile->filename; ?></a><?php if($allfiles > $counter ){ echo ' ,';} ?>
											<?php $counter++;} ?>
											<?php }else{ ?>
												<p style="margin-left:25px;font-size:12px;">No document uploaded.</p>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="faqccord">
									  <div class="panel-group" id="accordion">
										<div class="panel panel-default">
										  <div class="panel-heading">
											<h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><span class="glyphicon glyphicon-menu-right"></span> Subcategory Related Info</a> </h4>
										  </div>
										  <div id="collapse1" class="panel-collapse collapse in">
											<div class="panel-body">
											  <div class="subcatinfo reltedinformation">
												<?php 
													$subcatdata 		= $ticketformdata['subcatdata'];
													$subcatdataarray 	= array_keys($subcatdata);
												?>
												<div class="row">
													<?php 
														$counter = 1;
														foreach($subcatdata as $key=>$value){
															$keyarray 	= explode('_',$key);
															$newkey 	= implode(' ',$keyarray);
															if($key == 'Upload_Document'){ 
													?>
													<div class="col-md-6"> <span class="text mainn">
													  <label><?php echo ucwords($newkey); ?> :</label>
													  </span>
													  <?php
																if(!empty($value)){
															?>
													  <img src="<?php echo base_url().'uploads/ticket/'.$value; ?>" class="" width="50" height="50"/>
													  <?php }else{ ?>
													  <img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" class="" width="50" height="50"/>
													  <?php } ?>
													</div>
													<?php }else{ ?>
													<div class="col-md-6"> <span class="text mainn">
													  <label><?php echo ucwords($newkey); ?>:</label>
													  </span> <span class="valuetext"><?php echo ' '.$value; ?></span> </div>
													<?php } 
														if($counter%2 == 0){
													?>
														</div>
														<div class="row">
													<?php } $counter++; } ?>
												  </div>
											  </div>
											</div>
										  </div>
										</div>
									  </div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
								<div class="col-md-12">				
									<p style="font-size: 13px; margin: 5px 0 0"><input type="checkbox" name="terms" tabindex="17" required="required" id="terms"> I accept the <u>Terms and Conditions</u></p>
									<div class="error" id="terms_error_message_tools"></div>			
								</div>
							</div>
						<div class="btnsedt">
							<div class="form-group col-1d2 text-right customsubmtcandel">
								<a class="btn btn-default" href="<?php echo base_url().'ticket/create/?catid='.$ticketformdata['urlcatid'];?>">Edit Ticket Form</a>
								<input class="btn btn-primary" type="submit" value="Pay now" onclick="launchBOLT(); return false;"  id="paybtn" />
								
							</div>
						</div>
					</div>
				</div>
					</form>
				</div>
			</div>
		</div>		
	</section>
</div>
<script type="text/javascript"><!--
$('#payment_form').bind('keyup blur',function(){
	/* $.ajax({
          url: '<?php echo base_url();?>users/ticketController/create_hash',
          type: 'post',
          data: JSON.stringify({ 
            key: $('#key').val(),
			salt: $('#salt').val(),
			txnid: $('#txnid').val(),
			amount: $('#amount').val(),
		    pinfo: $('#pinfo').val(),
            fname: $('#fname').val(),
			email: $('#email').val(),
			mobile: $('#mobile').val(),
			udf5: $('#udf5').val()
          }),
		  contentType: "application/json",
          dataType: 'json',
          success: function(json) {
            if (json['error']) {
			 $('#alertinfo').html('<i class="fa fa-info-circle"></i>'+json['error']);
            }
			else if (json['success']) {	
				$('#hash').val(json['success']);
            }
          }
        });  */
});
//-->
</script>
<script type="text/javascript"><!--
function launchBOLT()
{
	bolt.launch({
	key: $('#key').val(),
	txnid: $('#txnid').val(), 
	hash: $('#hash').val(),
	amount: $('#amount').val(),
	firstname: $('#fname').val(),
	email: $('#email').val(),
	phone: $('#mobile').val(),
	productinfo: $('#pinfo').val(),
	udf5: $('#udf5').val(),
	surl : $('#surl').val(),
	furl: $('#surl').val(),
	mode: 'dropout'	
},{ responseHandler: function(BOLT){
	console.log( BOLT.response.txnStatus );		
	if(BOLT.response.txnStatus != 'CANCEL')
	{
		//Salt is passd here for demo purpose only. For practical use keep salt at server side only.
		var fr = '<form action=\"'+$('#surl').val()+'\" method=\"post\">' +
		'<input type=\"hidden\" name=\"key\" value=\"'+BOLT.response.key+'\" />' +
		'<input type=\"hidden\" name=\"salt\" value=\"'+$('#salt').val()+'\" />' +
		'<input type=\"hidden\" name=\"txnid\" value=\"'+BOLT.response.txnid+'\" />' +
		'<input type=\"hidden\" name=\"amount\" value=\"'+BOLT.response.amount+'\" />' +
		'<input type=\"hidden\" name=\"productinfo\" value=\"'+BOLT.response.productinfo+'\" />' +
		'<input type=\"hidden\" name=\"firstname\" value=\"'+BOLT.response.firstname+'\" />' +
		'<input type=\"hidden\" name=\"email\" value=\"'+BOLT.response.email+'\" />' +
		'<input type=\"hidden\" name=\"udf5\" value=\"'+BOLT.response.udf5+'\" />' +
		'<input type=\"hidden\" name=\"mihpayid\" value=\"'+BOLT.response.mihpayid+'\" />' +
		'<input type=\"hidden\" name=\"status\" value=\"'+BOLT.response.status+'\" />' +
		'<input type=\"hidden\" name=\"hash\" value=\"'+BOLT.response.hash+'\" />' +
		'</form>';
		var form = jQuery(fr);
		jQuery('body').append(form);
		form.submit();
	}
},
	catchException: function(BOLT){
 		alert( BOLT.message );
	}
});
}
function alpha(e) {
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
}

/* $("#paybtn").click(function() {
	if ($("#terms").is(":checked")) { 
	} else { 
		alert("Please confirm terms and conditions.");
		location.reload();
	}
	$.ajax({
	  url: '<?php echo base_url();?>users/ticketController/createticketonpaynow',
	  type: 'post',
	  success: function(data) {
	  }
	});
}); */

function createhash(){
  $.ajax({
	  url: '<?php echo base_url();?>users/ticketController/create_hash',
	  type: 'post',
	  data: JSON.stringify({ 
		key: $('#key').val(),
		salt: $('#salt').val(),
		txnid: $('#txnid').val(),
		amount: $('#amount').val(),
		pinfo: $('#pinfo').val(),
		fname: $('#fname').val(),
		email: $('#email').val(),
		mobile: $('#mobile').val(),
		udf5: $('#udf5').val()
	  }),
	  contentType: "application/json",
	  dataType: 'json',
	  success: function(json) {
		if (json['error']) {
		 $('#alertinfo').html('<i class="fa fa-info-circle"></i>'+json['error']);
		}
		else if (json['success']) {	
			$('#hash').val(json['success']);
		}
	  }
	}); 
}
 setTimeout(createhash,1000);

//--
</script>