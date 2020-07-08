<?php 
	$usersession = $this->session->userdata('users');
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
	color: #263a7d;
	margin: 0 0 5px;
}
	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected {
		background: #f3781e;
		color: white;
	}
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
	background: #263a7d;
	color: #fff;
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


#selectable li p {
	display: flex;
	width: 100%;
	justify-content: center;
	align-items: center;
	height: auto;
	margin: auto;
	top: 2px;
	position: relative;
}
#selectable li p:last-child {
	display: block;
	position: absolute;
	left: 0;
	align-items: initial;
	top: 75%;
	height: 20px;
	font-size: 30px;
	font-weight: bold;
	color: #f3781e;
}
#selectable li .fa.fa-inr {
	color: #6ed7f7;
	font-size: 20px;
	vertical-align: top;
	position: relative;
	top: -2px;
	left: 6px;
}
.mystyuff{
	float: left;
	width: 100%;
	margin-bottom: 5px;
}
.clone.mt-2 {
    font-size: 12px;
}
#casefilename{
	width: 48%;
	float: left;
	margin-right: 9.5px;
}
.form-control.casefile {
	width: 50%;
	float: left;
	padding: 4px 2px !important;
}
.active-screen .text-part.active {
	color: #f3781e;
}
.numbersssdtf {
    margin-top: 0;
    margin-bottom: 15px;
    float: left;
    width: 100%;
    display: block;
    position: relative;
    min-height: 116px;
}
.active-screen .number {
	border: 3px solid #263a7d;
	background: #263a7d;
}
.active-screen .number.active {
	background: #f3781e;
	border-color: #f3781e;
}
.active-screen .number a {
	color: #fff;
}

#create_tkt_btn{
	background: #F3781E;
	color: #fff;
	border: 2px solid #F3781E;
}
.btn.btn-danger{
	background: #263a7d;
	color: #fff;
	border: 2px solid #263a7d;
}
.liicons.ui-selectee .fa {
	font-size: 38px;
	margin-top: 10px;
}
.form-group.choosectg label {
	font-size: 14px;
}
#selectable li.ui-selected p:last-child {
	color: #263a7d;
}
#subcatname {
	float: left;
	font-size: 18px;
	font-weight: bold;
	color: #263a7d;
}
.input-group-addon {
	padding: 7px 20px;
	font-size: 12px;
}

#sel1 {
	padding-left: 5px;
}
.custom-form p{
	margin-bottom: 0;
}
.back-btn.btn.btn-warning{
	background: #f3781e;
	color: #fff;
	border: 2px solid #f3781e;
}
.moneytitke {
	float: left;
}
</style>
<div class="banner">
	<aside id="fh5co-hero" class="js-fullheight" style="height: 318px;">
		<div class="flexslider js-fullheight" style="height: 318px;">
			<ul class="slides">
				<?php 
					if(!empty($catdata->banner)){
				?>
					<li style="background-image: url(<?php echo base_url().'uploads/category/banner/'.$catdata->banner; ?>); width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2; height: 318px;" class="flex-active-slide">
						<div class="overlay-gradient"></div>
						<div class="container">
							<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text animated fadeInUp" style="height: 318px;">
								<div class="slider-text-inner desc">
									<h2 class="heading-section"><?php echo !empty($catdata->headline)?$catdata->headline:''; ?><br/>
										<span><?php echo !empty($catdata->cat_slogan)?$catdata->cat_slogan:''; ?></span>
									</h2>
								</div>
							</div>
						</div>
					</li>
				<?php }else{ ?>
					<li style="background-image: url(<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>); width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2; height: 318px;" class="flex-active-slide">
						<div class="overlay-gradient"></div>
						<div class="container">
							<div class="col-md-10 col-md-offset-1 text-center js-fullheight slider-text animated fadeInUp" style="height: 318px;">
								<div class="slider-text-inner desc">
									<h2 class="heading-section"><?php echo $catdata->name; ?></h2>
								</div>
							</div>
						</div>
					</li>
				<?php } ?>
		  	</ul>
	  	<ol class="flex-control-nav flex-control-paging"></ol><ul class="flex-direction-nav"><li class="flex-nav-prev"><a class="flex-prev flex-disabled" href="#" tabindex="-1">Previous</a></li><li class="flex-nav-next"><a class="flex-next flex-disabled" href="#" tabindex="-1">Next</a></li></ul></div>
	</aside>
</div>
<div class="container">	
	<div class="row mt-5">
	   <div class="col-md-12">
			<div class="cretticketform">
			<!-- Your code here -->
			<?php
				$selectedcityid = $this->session->userdata('selectedcityid');
				echo form_open_multipart($pageUrl.'/?catid='.$catids, array('class' => 'create_ticket', 'id' => 'ticketformfront')); 
				$prefixdata = $this->frontend_model->getDataByTable('nw_prefix_tbl');
			?>
			<div class="col-md-12a">
				<?php
					if($this->session->flashdata('responce_msg')!=""){
						$message = $this->session->flashdata('responce_msg');
						echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
					}
				?>
			</div>
			<?php 
				$ticketformdata = $this->session->userdata('ticketformdata');
			?>
			<div class="row">
				<div class="form-group">
					<div class="headerdesctiption">
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
						<h2 class="puttocenter"><?php echo $catdata->name; ?></h2>
						<p><?php echo !empty($catdata->cat_description)?$catdata->cat_description:''; ?></p>
					</div>
					<div class="form-group choosectg">
						<?php echo form_label('Choose Subcategory*', 'description'); ?>
						<br/>
						<ol id="selectable">
							<?php 
								foreach($subcategorylist as $subcatlist){
							?>
								<li class="ui-state-default" data-id="<?php echo $subcatlist->id; ?>">
									<span class="liicons"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
									<p><?php echo $subcatlist->name; ?></p><p><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcatlist->amount; ?></p>
								</li>
							<?php } ?>
						</ol>
						<input type="text" name="subcatid" id="subcatid" value="<?php echo $ticketformdata['subcatid'];?>" required="required" />
						<?php echo '<div class="error-msg" id="subcat_error_message_tools">' . form_error('image') . '</div>'; ?>
					</div>
				</div> 
			</div>
		
			<div class="row customlbleint" id="frontticketform" style="display:none;">
				<div class="numbersssdtf">
				  <div class="active-screen">
						<?php 
							$currenturl = current_url();
							$params   	= $_SERVER['QUERY_STRING']; 
							$fullURL 	= $currenturl . '/?' . $params; 
					   ?>
					  <div class="number-account">
						<span class="number one active">
							<a href="<?php echo $fullURL; ?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
						</span>
						<span class="text-part active">
							Ticket Details
						</span>
					  </div>
					   <?php 
							$usersession 	= $this->session->userdata('users');
							if(empty($usersession)){
					   ?>
						  <div class="number-account">
							<span class="number two notreached">
								<a href="javascript:void(0);"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
							</span>
							<span class="text-part">
								Login / Registration
							</span>
						  </div>
					  <?php } ?>
					  <div class="number-account">
						<span class="number three notreached">
							<a href="javascript:void(0);"><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
						</span>
						<span class="text-part">
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
				<div class="row">
					<div class="col-md-12 tittleandback">
						<span class="moneytitke"><span id="subcatname"></span> <span class="pricemorny">( <i class="fa fa-inr" aria-hidden="true"></i><span id="amount"></span> )</span> </span>
						<a class="back-btn btn btn-warning white-icon defirence" onclick="window.location.reload();" style="float:left;padding: 1px 8px;font-size: 11px;margin-left: 8px;" title="Back"><i class="fa fa-arrow-left" ></i>  Change Service</a>
					</div>
				</div>
			<div class="row">
				<div class="col-md-6">
					<div class="formares floating-laebls">
					<h3 class="title-section mycit">Communication Details</h3>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group inputBox focus">
								<?php 
									echo form_label('Title', 'title');
									$allprefix = [];
									foreach($prefixdata as $prefix){
										$allprefix[$prefix->id] = $prefix->title;
									}
									$selectedtitle = $ticketformdata['title'];
									echo form_dropdown('title', $allprefix, set_value('title',$selectedtitle), 'class="form-control input" id="sel1" tabindex="1"');
								?>
							</div>  
						</div>
						<div class="col-md-5"> 
							<?php 
								$selectedfname = $ticketformdata['fname'];
							?>
							<div class="form-group inputBox <?php echo !empty($selectedfname)?'focus':''; ?>">
								<?php
									echo form_label('First Name *', 'fname');
									echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$selectedfname), 'id' => "fname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2'));
									echo '<div class="error-msg">' . form_error('fname') . '</div>';
								?>				
							</div>
						</div>
						<div class="col-md-5">
							<?php 
								$selectedsname = $ticketformdata['sname'];
							?>
							<div class="form-group inputBox <?php echo !empty($selectedsname)?'focus':''; ?>">
								<?php
									echo form_label('Last Name *', 'sname');
									echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$selectedsname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3'));
									echo '<div class="error-msg">' . form_error('sname') . '</div>';
								?>
								<div class="error-msg"></div>	
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
									
									echo form_input(array('name' => 'customer_mobile', 'class' => 'form-control input','id'=>'customer_mobile', 'value' => set_value('customer_mobile',$customermobile), 'maxlength' => '10', 'tabindex'=>'4'));
									//echo '<div class="error-msg">' . form_error('customer_mobile') . '</div>';
								?>
							   </div>
						    </div>
					    </div>
					    <div class="col-md-6">
							<?php 
								$selectedemail = $ticketformdata['email'];
							?>
							<div class="form-group inputBox <?php echo !empty($selectedemail)?'focus':''; ?>">
								<?php
									echo form_label('Email *', 'email');
									echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$selectedemail), 'id' => "email", 'maxlength'=>'50','tabindex'=>'4'));
									echo '<div class="error-msg">' . form_error('email') . '</div>';
								?>
							</div>
					    </div>
					 </div>


				<div class="row">
					<div class="col-md-8">
						<?php 
							$ticketaddress = !empty($ticketformdata['customer_address'])?$ticketformdata['customer_address']:'';
						?>
						<div class="form-group inputBox col-6 customtextre <?php echo !empty($ticketaddress)?'focus':''; ?>">
							<?php
								$customeraddress = !empty($selectedcityid)?'':$ticketaddress;
								if(empty($customeraddress)){
									$customeraddress = $ticketaddress;
								}
								echo form_label('Address *', 'customer_address');
								echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control input', 'value' => set_value('customer_address',$customeraddress), 'id' => "customer_address", 'cols' => '10', 'rows' => '3', 'tabindex'=>'6'));
								//echo '<div class="error-msg">' . form_error('customer_address') . '</div>';
							?>
						</div>
					</div>
					<div class="col-md-4">
						<?php 
							$ticketpincode = !empty($ticketformdata['customer_pincode'])?$ticketformdata['customer_pincode']:'';
						?>
						<div class="form-group inputBox col-6 <?php echo !empty($ticketpincode)?'focus':''; ?>">
					<?php
						$customerzip = !empty($selectedcityid)?'':$ticketpincode;
						if(empty($customerzip)){
							$customerzip = $ticketpincode;
						}
						echo form_label('Pin code *', 'customer_pincode');
						echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control input', 'value' => set_value('customer_pincode',$customerzip), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6', 'tabindex'=>'7'));
						//echo '<div class="error-msg">' . form_error('customer_pincode') . '</div>';
					?>
				</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group inputBox focus col-6">
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
								echo form_dropdown('customer_country', $allCountry, set_value('customer_country',$selected_country), 'class="form-control input" id="customer_country" disabled="disabled" tabindex="8"');
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
						<div class="form-group inputBox focus col-6">
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
								echo form_dropdown('customer_state', $allstate, set_value('customer_state',$selected_state), 'class="form-control input" id="customer_state" disabled="disabled" tabindex="9"'); 
								echo form_hidden('customer_state',$selected_state);
								//echo '<div class="error-msg">' . form_error('customer_state') . '</div>';
							?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group inputBox focus col-6">
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
								echo form_dropdown('customer_city', $allcity, set_value('customer_city',$choosedcity), 'class="form-control input" id="customer_city" disabled="disabled" tabindex="10"'); 
								echo form_hidden('customer_city',$choosedcity);
								//echo '<div class="error-msg">' . form_error('customer_city') . '</div>';
								/* echo form_label('City *', 'customer_city');
								echo form_input(array('name' => 'customer_city', 'class' => 'form-control', 'value' => set_value('customer_city'), 'id' => "customer_city", 'placeholder' => 'City', 'onkeypress'=> 'return alpha(event)'));
								echo '<div class="error-msg">' . form_error('customer_city') . '</div>'; */
							?>
						</div>  
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="title-section mycit">Ticket Details</h3>
						<?php 
							$ticketdesc = !empty($ticketformdata['description'])?$ticketformdata['description']:'';
						?>
						<div class="description form-group inputBox <?php echo !empty($ticketdesc)?'focus':''; ?>">
							<?php
								echo form_label('Description* <span class="text-danger" style="font-size:8px;">(Please enter less than 500 characters.)</span>', 'description');
								echo form_textarea(array('name' => 'description', 'class' => 'form-control input', 'value' => set_value('description',$ticketdesc), 'id' => "description", 'cols' => '10', 'rows' => '3', 'onkeyup'=>'countChar(this,500)','tabindex' => '11'));
								echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
							?>
							<?php echo '<div class="error-msg" id="desc_error_message_tools"></div>'; ?>
						</div>
					</div>					
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group inputBox focus">
						<?php echo form_label('Document Upload <span class="text-danger" style="font-size:8px;">(Supported File Format: gif | jpg | png | jpeg | pdf | doc | docx | xls | xlsx /Max. upload size 2MB)</span>', 'image'); ?>
						<div class="stuffs_to_clone">
							<div class="stuff mt-3 mystyuff">
								<div class="twodievs">
									<input type="text" class="form-control casefilename input" name="casefilename[]" id="casefilename" tabindex="12" />
									<input type="file" id="image" class="form-control casefile input" name="image[]" tabindex="13"/>
									<div class="del disabled hidden"></div>
								</div>
							</div>
							<div class="clone mt-2" title="Add more files">Add more files</div>
							<div id="upload_prev" style="display:none;"></div>
						</div>
						<!--<input type="file" name="image[]" id="image" class="form-control" size="20" multiple required />-->
						
						<?php //echo '<div class="error-msg" id="error_message_tools">' . form_error('image') . '</div>'; ?>
						<?php 
							if(!empty($ticketformdata)){
							$imagename 			= $ticketformdata['imagename'];
							$alluploadedfiles 	= json_decode($imagename);
							if(!empty($alluploadedfiles)){
								$counter 	= 1;
								$allfiles 	= count($alluploadedfiles);
								foreach($alluploadedfiles as $alluploadedfile){ 
						?>
							<a href="<?php echo base_url().'uploads/ticket/'.$alluploadedfile->file; ?>" target="_blank"><?php echo $alluploadedfile->filename; ?></a><?php if($allfiles > $counter ){ echo ' ,';} ?>
						<?php $counter++;} ?>
						<?php }} ?>
					</div>
					</div>
				</div>
				<div class="row">
				<div class="col-md-12" style="margin-top: 5px">
					<div class="form-group">
						<?php
						    echo '<a href="' . base_url() . '" class="btn btn-danger" tabindex="15">Cancel</a>';
							echo form_submit(array("class" => "btn btn-warning", "id" => "create_tkt_btn", "value" => "Submit","tabindex"=>"16"));
							
						?>
					</div>
				</div>
				</div>
				</div>
			</div>
			<div class="col-md-6">									
				<div class="faqccord">
					<div class="panel-group" id="accordion">
						
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
				
				<?php /*<div class="col-md-12">				
					<p style="font-size: 13px; margin: 0"><input type="checkbox" name="terms" tabindex="14"> I accept the <u>Terms and Conditions</u></p>
					<div class="error" id="terms_error_message_tools"></div>			
				</div> */?>
		
				
			</div>
		<?php echo form_close(); ?>
		</div>
	  </div>
	</div>
</div>
<script>

$(document).ready(function(){
	$(".clone").click(function() {
		var $self = $(this),
			$element_to_clone = $self.prev(),
			$wrapper_parent_element = $self.parent(),
			$new_element = $element_to_clone.clone().find("input:text,input:file").val("").end();

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
		var filename = $('.casefilename').val();
		if(filename == ''){
			alert('Enter file name before selecting any file.');
			$(this).val('');
		}else{
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
		}
	});
	$("#ticketformfront").on("submit", function(e){
		$( ".mystyuff" ).each( function( index, element ){
			var images 		=  $( this ).find('#image').val();
			var filesname 	=  $( this ).find('.casefilename').val();
			if(filesname !='' && images == ''){
				e.preventDefault();
				alert('Upload files before submitting.');
			}
		});
	});
	$("#customer_state").change(function() { 
		var $option = $(this).find('option:selected');
		var stateId = $option.val();
		$.ajax({
			url: '<?php echo base_url();?>frontend/frontController/getCityListdata',
			data: {'stateId': stateId}, 
			type: "post",
			success: function(data){
				$("#customer_city").html(data);
			}
		});
	});
});
$( function() {
	<?php if(!empty($ticketformdata)){ ?>
		$( "#selectable li" ).each(function( index ) {
			var subcat = $( this ).data('id');
			var selectedsubcat = <?php echo $ticketformdata['subcatid']; ?>;
			if(subcat == selectedsubcat){
				$( this ).addClass('ui-selected');
			}
		});
	<?php } ?>
	$("#selectable").selectable({
		stop: function(e, ui) {
			$(".ui-selected:first", this).each(function() {
				$(this).siblings().removeClass("ui-selected");
				var refreshVal = $(this).data("id");
				$('#subcatid').val(refreshVal);
				$.ajax({
					url: '<?php echo base_url();?>frontend/frontController/getsubcatdetailbyid',
					data: {'subcatid': refreshVal}, 
					type: "post",
					success: function(data){
						if(data != ''){
							var obj = JSON.parse(data);
							$("#subcatname").text(obj.name);
							$("#amount").text(obj.amount);
							$("#accordion").html(obj.faqhtml);
						}
					}
				});
				$('.choosectg').hide();
				$('#frontticketform').show();
			});
		}
	});
} );
function alpha(e) {
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
}
</script>