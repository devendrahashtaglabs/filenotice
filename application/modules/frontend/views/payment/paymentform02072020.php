<?php 
	$ticketformdata = $this->session->userdata('ticketformdata');
	//$userdata		= $this->frontend_model->getUserDetailsById($ticketformdata['userid'],'2');
?>
<style>
	
	.hidden {
		display:none;
	}

	.stuffs_to_clone {
		position:relative;
	}

	.del, 
	.clone
	{
		z-index:999;
		cursor:pointer;
		background-position:left center;
		background-repeat:no-repeat;
		min-width:24px;
		min-height:24px;
		padding-left:26px;
	}

	.clone {
	background-image: url('http://cdn1.iconfinder.com/data/icons/musthave/24/Copy.png');
	width: 100%;
	top: 0px;
	background-position: bottom left;
	background-size: 20px;
}

	.del {
		position:relative;
		float:right;
		bottom:30px;    
		right:0px;
		background-image:url('http://cdn1.iconfinder.com/data/icons/fugue/bonus/icons-24/cross.png');
	}

	.centered
	{
		text-align:center;
	}
	.casefilename{
		width: 48%;
		float: left;
		margin-right: 10px;
		height: 45px;
	}
	.casefile{
		width: 48%;
	}
	.catname {
		font-size: 18px;
		font-weight: 600;
	}
	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { background: #F39814; color: white; }
	#selectable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
	#selectable li {
		margin: 0;
		padding: 10px;
		float: left;
		width: 25%;
		height: 160px;
		font-size: 16px;
		text-align: center;
		line-height: 20px;
		box-sizing: border-box;
		text-transform: capitalize;
		position: relative;
	}
	table {
		font-size: 1em;
	}

	.ui-draggable, .ui-droppable {
		background-position: top;
	}
	#subcatid {
	  opacity: 0;
	  width: 0;
	  float: left; /* Reposition so the validation message shows over the label */
	}
/*Multiform*/
#selectable li p{
	display: flex;
	width: 100%;
	justify-content: center;
	align-items: center;
	height: 100%;
	margin: auto;
}
#selectable li p:last-child {
	display: inline;
	position: absolute;
	left: 0;
	align-items: initial;
	top: 108px;
}
.mystyuff{
	float: left;
	width: 100%;
}
#casefilename{
	width: 48%;
	float: left;
	margin-right: 9.5px;
}
.form-control.casefile{
	width: 50%;
	float: left;
}
.catname {
    font-size: 18px;
    font-weight: 600;
    color: #263a7d;
}
.form-group {
	margin-bottom: 8px;
}
.form-group.bluethis label {
	font-size: 14px;
	line-height: 12px;
	margin: 0;
	color: #263a7d;
}
.form-group.bluethis {
	margin: 0;
}
.active-screen .number.active {
	background: #f3781e;
	border-color: #f3781e;
}
.active-screen .number {
	border: 3px solid #263a7d;
	background: #263a7d;
}
.active-screen .number a {
	color: #fff;
}
.active-screen .text-part.active {
	color: #f3781e;
}
.thim-login.form-submission-register.custom-form {
	padding: 40px 25px 40px;
	border: 1px solid #F2F2F2;
	background: #fdfdfd;
}
.bagckgrdcolor {
	background: #f4f4ff;
	padding: 0 15px;
}
.title-section.mycit {
	font-size: 14px;
	margin-bottom: 5px;
}
.custom-form label {
	display: inline-block;
	max-width: 100%;
	margin-bottom: 0;
	font-weight: 400;
	color: #333;
	font-size: 8px;
	line-height: 17px;
}
.bagckgrdcolor .form-control {
	height: 30px;
	padding: 1px 12px;
	font-size: 12px;
	line-height: 1.42857143;
}
.input-group-addon {
	padding: 7px 20px;
	font-size: 12px;
}
.havwesomeadon label.error {
	position: absolute !important;
	bottom: -14px !important;
	width: 100%;
	left: 0;
	font-size: 10px;
}
.btn.btn-danger {
	background: #263a7d;
	color: #fff;
	border: 2px solid #263a7d;
}
.btn.btn-warning{
    background: #F3781E;
    color: #fff;
    border: 2px solid #F3781E;
}
.custom-form label.error {
	color: red;
	font-size: 10px;
	line-height: 12px;
	position: relative;
	bottom: 8px;
}
textarea {
	line-height: 25px !important;
}
.container-payment-gateway .navbar.navbar-default {
	background-color: #263a7d !important;
}
#citrusCardPayButton {
	background-color: #263a7d !important;
}
.subcatinfo label {
    font-size: 14px;
}
</style>
<script id="bolt" src="https://sboxcheckout-static.citruspay.com/bolt/run/bolt.min.js"></script>
<div class="container vertical-center">
	<div class="row">	
		<div class="register-formbg">
			<div class="thim-login form-submission-register custom-form">
				
				<!-- Your code here -->
				<form action="#" id="payment_form">
					<div class="row">
						<div class="col-md-12">
							<h4 class="catname">Payment Info</h4>							
						</div>
					</div> 
					<input type="hidden" id="udf5" name="udf5" value="BOLT_KIT_PHP7" />
					<input type="hidden" id="surl" name="surl" value="<?php echo base_url().'frontend/ticketController/payment_response'; ?>" />
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
					<?php 
						$catname 	= !empty($ticketformdata['categorytext'])?$ticketformdata['categorytext']:'';
						$subcatname = !empty($ticketformdata['name'])?$ticketformdata['name']:'';
						$productinfo = ' '. $catname .' - '.$subcatname; 
					?>
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
							//echo form_label('Name *', 'fname');
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
							//echo form_label('Email*', 'email');
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
					<?php /*
					<div class="row">
						<div class="form-group col-md-12">
							<div class="form-group">
								<input type="hidden" name="userid" value="<?php echo !empty($usersession['user_id'])?$usersession['user_id']:''; ?>" />
								<?php 
									$postcatid 	= !empty($ticketformdata['catid'])?$ticketformdata["catid"]:'';
									$categoryid = !empty($catid)?$catid:$postcatid;
								?>
								<input type="hidden" name="catid" value="<?php echo $categoryid; ?>" />
								<?php 
									$postcattext 	= !empty($ticketformdata['categorytext'])?$ticketformdata["categorytext"]:'';
									$categorydata 	= $this->user_model->get_category_data($categoryid);
								?>
								<input type="hidden" name="categorytext" value="<?php echo !empty($categorydata)?$categorydata->name:''; ?>" />
								<?php 
									$postcatids = !empty($ticketformdata['urlcatid'])?$ticketformdata["urlcatid"]:'';
								?>
								<input type="hidden" name="urlcatid" value="<?php echo !empty($catids)?$catids:$postcatids; ?>" />
								<h4 class="catname"><?php echo $catdata->name; ?></h4>
								<p><?php echo !empty($catdata->cat_description)?$catdata->cat_description:''; ?></p>
							</div>
							<div class="form-group">
								<?php
									echo form_label('Choose Subcategory*', 'description'); ?>
									<br/>
								<ol id="selectable">
									<?php 
										foreach($subcategorylist as $subcatlist){
									?>
										<li class="ui-state-default" data-id="<?php echo $subcatlist->id; ?>"><p><?php echo $subcatlist->name; ?></p><p><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcatlist->amount; ?></p></li>
									<?php } ?>
								</ol>
								<input type="text" name="subcatid" id="subcatid" value="" required="required" />
								<?php echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
							</div>
						</div> 
					</div> */ ?>
				<div class="bagckgrdcolor">
					<div class="row" style="margin-top: 25px; margin-bottom: 85px">
					  <div class="active-screen">
						  <div class="number-account">
							 <span class="number one">
								<a href="<?php echo base_url().'create_ticket/?catid='.$ticketformdata['urlcatid'];?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
							 </span>
							<span class="text-part">
								Create Ticket
							</span>
						  </div>
						   <?php 
								$usersession 	= $this->session->userdata('users');
								if(empty($usersession)){
						   ?>
						  <div class="number-account">
							<span class="number two">
								<a href="javascript:void(0);"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
							</span>
							<span class="text-part">
								Login / Registration
							</span>
						  </div>
						  <?php } ?>
						  <div class="number-account">
							<span class="number three active">
								<a href="<?php echo base_url().'payment';?>"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
							</span>
							<span class="text-part active">
								Confirmation
							</span>
						  </div>
						  <div class="number-account">
							<span class="number four">
								<a href="javascript:void(0);"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
							</span>
							<span class="text-part">
								Review
							</span>
						  </div>
						</div>
					</div>
					<div class="row floating-laebls">
						<div class="col-md-6">
							<h3 class="title-section mycit">Communication Details</h3>
							<div class="row mt-5">
								<div class="col-md-2">
								    <div class="form-group inputBox focus">
										<?php 
											$prefixdata = $this->frontend_model->getDataByTable('nw_prefix_tbl');
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
											echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$selectedfname), 'id' => "fname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2','disabled'=>'disabled'));
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
												echo form_input(array('name' => 'customer_mobile', 'class' => 'form-control input', 'value' => set_value('customer_mobile',$customermobile), 'maxlength' => '10','disabled'=>'disabled'));
												//echo '<div class="error-msg">' . form_error('customer_mobile') . '</div>';
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
								<div class="customtextre form-group inputBox focus">
									<?php
										$ticketaddress = !empty($ticketformdata['customer_address'])?$ticketformdata['customer_address']:'';
										$customeraddress = !empty($selectedcityid)?'':$ticketaddress;
										echo form_label('Address *', 'customer_address');
										echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control input', 'value' => set_value('customer_address',$customeraddress), 'id' => "customer_address", 'cols' => '10', 'rows' => '3','disabled'=>'disabled'));
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
										if(!empty($stateList)){
											foreach($stateList as $singleStateList){
												$allstate[$singleStateList->id] = $singleStateList->name;
											}                    
										}                    
										echo form_dropdown('customer_state', $allstate, set_value('customer_state',$selected_state), 'class="form-control input" id="customer_state" disabled="disabled"'); 
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
									?>
								</div>  
							</div>
						</div>
					   </div>
					   <div class="col-md-6">
							<h3 class="title-section mycit">Ticket Details</h3>
							<div class="row mt-5">
								<div class="form-group inputBox focus">
									<?php
										$ticketdesc = !empty($ticketformdata['description'])?$ticketformdata['description']:'';
										echo form_label('Query or describe your problem* (<span class="text-danger" style="font-size:10px;">(Please enter less than 500 characters.)</span>)', 'description');
										echo '<label></label>';
										echo form_textarea(array('name' => 'description', 'class' => 'form-control input', 'value' => set_value('description',$ticketdesc), 'id' => "description",'onkeyup'=>'countChar(this,500)','disabled'=>'disabled'));
										echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
									?>
								</div>

								<div class="form-group inputBox focus">
									<?php echo form_label('Uploaded Document', 'image'); ?>
									<?php /*<div class="stuffs_to_clone">
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
									<label><span class="text-danger" style="font-size:10px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 2MB)</span></label> */?>
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
					</div>
					<div class="my-5 subcatinfo">
						<h3 class="title-section mycit">Subcategory Related Info</h3>
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
								<div class="col-md-4">
									<span class="text mainn"><label><?php echo ucwords($newkey); ?> :</label></span>
									<?php
										if(!empty($value)){
									?>
										<img src="<?php echo base_url().'uploads/ticket/'.$value; ?>" class="" width="50" height="50"/>
									<?php }else{ ?>
										<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" class="" width="50" height="50"/>
									<?php } ?>
								</div>
							<?php }else{ ?>
								<div class="col-md-4">
									<span class="text mainn"><label><?php echo ucwords($newkey); ?>:</label></span>
									<span class="valuetext"><?php echo ' '.$value; ?></span>
								</div>
							<?php } 
								if($counter%3 == 0){
							?>
								</div>
								<div class="row">
							<?php } $counter++; } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">				
							<p style="font-size: 13px; margin: 5px 0 0"><input type="checkbox" name="terms" tabindex="17" required="required" id="terms"> I accept the <u>Terms and Conditions</u></p>
							<div class="error" id="terms_error_message_tools"></div>			
						</div>
					</div>
					<div class="row">
						<div class="col-md-12" style="margin-top: 5px">
							<div class="form-group col-12 text-right">							
								<a class="btn btn-danger" href="<?php echo base_url().'create_ticket/?catid='.$ticketformdata['urlcatid'];?>">Edit Ticket Form</a>
								<input class="btn btn-warning" type="submit" value="Pay now" onclick="launchBOLT(); return false;"  id="paybtn" />
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript"><!--
$('#payment_form').bind('keyup blur',function(){
	/* $.ajax({
          url: '<?php echo base_url();?>frontend/ticketController/create_hash',
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

$( function() {
	//$('#selectable li:first').addClass('ui-selected')
	$( "#selectable li" ).each(function( index ) {
		var subcat = $( this ).data('id');
		var selectedsubcat = <?php echo $ticketformdata['subcatid']; ?>;
		if(subcat == selectedsubcat){
			$( this ).addClass('ui-selected');
		}
	});
	$("#selectable").selectable({
		stop: function(e, ui) {
			$(".ui-selected:first", this).each(function() {
				$(this).siblings().removeClass("ui-selected");
				var refreshVal = $(this).data("id");
				$('#subcatid').val(refreshVal);
			});
		}
	});
	
} );

$("#paybtn").click(function() {
	if ($("#terms").is(":checked")) { 
	} else { 
		alert("Please confirm terms and conditions.");
		location.reload();
	}
	$.ajax({
	  url: '<?php echo base_url();?>frontend/ticketController/createticketonpaynow',
	  type: 'post',
	  success: function(data) {
	  }
	});
}); 


function createhash(){
  $.ajax({
	  url: '<?php echo base_url();?>frontend/ticketController/create_hash',
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

$(document).ready(function() {
	window.history.pushState(null, "", window.location.href);        
	window.onpopstate = function() {
		window.history.pushState(null, "", window.location.href);
	};
});

//--
</script>