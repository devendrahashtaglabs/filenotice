<script>
    function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
</script> 
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
	#selectable { list-style-type: none; margin: 0; padding: 10px; width: 100%; }

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
.clone {
    width: 100%;
    background-position: bottom left;
    background-size: 20px;
    top: 0px;
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
.customlbleint .form-control {
    height: 30px;
    padding: 1px 12px;
    font-size: 12px;
    line-height: 1.42857143;
}
.customlbleint {
	background: #f4f4ff;
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
.havwesomeadon label.error {
	position: absolute !important;
	bottom: -14px !important;
	width: 100%;
	left: 0;
	font-size: 10px;
}
.form-group {
    margin-bottom: 8px;
}
#sel1 {
	padding-left: 5px;
}
.custom-form label.error {
	color: red;
	font-size: 10px;
	line-height: 12px;
	position: relative;
	bottom: 8px;
}
.remain-char.text-danger {
	font-size: 8px;
	position: relative;
	top: -15px;
	color: red;
}
.thim-login.form-submission-register.custom-form {
	padding: 20px 40px 40px;
	border: 1px solid #F2F2F2;
	background: #fdfdfd;
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
	font-size:18px;
}
.content-wrapper{
	background:transparent;
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
    <section class="content custom-form">
        <div class="row">
            <div class="col-md-12" >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo $page_title; ?></h3>
                    </div>
                    <?php
						$selectedcitydata = $this->session->userdata('selectedcitydata');
						echo form_open_multipart($pageUrl.'/create/?catid='.$catids, array('class' => 'create_ticket', 'id' => 'CustomerTicketForm'));
                    ?>
                    <div class="card-body">
                        <?php
							if($this->session->flashdata('responce_msg')!=""){
								$message = $this->session->flashdata('responce_msg');
								echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
							}
                        ?>
						<?php 
							$ticketformdata = $this->session->userdata('ticketformdata');
							$usersession 	= $this->session->userdata('users');
							$userdetail		= $this->user_model->getDataBykey('nw_user_tbl','id',$usersession['user_id']);
						?>
						<div class="row mt-5">
							<div class="col-md-12">
								<div class="headerdesctiption form-group text-center">
									<input type="hidden" name="userid" value="<?php echo !empty($usersession['user_id'])?$usersession['user_id']:''; ?>" />
									<?php 
										$postcatid 	= !empty($ticketformdata['catid'])?$ticketformdata["catid"]:'';
										$categoryid = !empty($catid)?$catid:$postcatid;
									?>
									<input type="hidden" name="catid" value="<?php echo $categoryid; ?>" />
									<?php 
										$postcattext 	= !empty($ticketformdata['categorytext'])?$ticketformdata["categorytext"]:'';
										$categorydata 	= $this->category_model->get_category_data($categoryid);
									?>
									<input type="hidden" name="categorytext" value="<?php echo !empty($categorydata)?$categorydata->name:''; ?>" />
									<?php 
										$postcatids = !empty($ticketformdata['urlcatid'])?$ticketformdata["urlcatid"]:'';
									?>
									<input type="hidden" name="urlcatid" value="<?php echo !empty($catids)?$catids:$postcatids; ?>" />
									<h2 class="puttocenter"><?php echo $catdata->name; ?></h2>
									<p><?php echo !empty($catdata->cat_description)?$catdata->cat_description:''; ?></p>
								</div>
								
								<div class="form-group choosectg mt-3">
									<?php echo form_label('Choose Subcategory*', 'description');
									?>
									<br/>
									<ol id="selectable">
										<?php 
											foreach($subcategorylist as $subcatlist){
												$cat_icon 			= !empty($subcatlist->cat_icon)?$subcatlist->cat_icon:'fa fa-home';
										?>
										<li class="ui-state-default" data-id="<?php echo $subcatlist->id; ?>">
											<div class="col-md-3 text-center animate-box srarea fadeInUp animated-fast">
												<div class="imagservice"> 
													<?php 
														if(!empty($subcatlist->cat_featureimage)){
													?>
														<img src="<?php echo base_url().'uploads/category/'.$subcatlist->cat_featureimage; ?>" style="width: 100%;height: 180px;"> 
													<?php }else{ ?>
														<img src="<?php echo base_url().'uploads/profile/no_image_available.jpeg'; ?>" style="width: 100%;height: 180px;"> 							
													<?php } ?>
												</div>
												<div class="services "> 
													<a href="<?php echo $subcatlist->id; ?>" class=""> <span class="icon"><i class="<?php echo $cat_icon; ?>"></i></span>
													  <div class="desc">
															<h3><?php echo $subcatlist->name; ?></h3>
															<div class="amount section">
															  <div class="pricesectin">
																<i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcatlist->amount; ?>
															  </div>
															  <?php if($subcatlist->recurring_payment == 1){ ?>
															  <div class="seconrtsecitin"> 	<span class="startint">Annual</span>
															  </div>
															  <?php } ?>
															</div>
													  </div>
													</a> 
												</div>
											</div>
										</li>
										<?php } ?>
									</ol>
									<input type="text" name="subcatid" id="subcatid" value="<?php echo $ticketformdata['subcatid'];?>" required="required" />
								</div>
							</div> 
						</div>
						<div class="row customlbleint" id="frontticketform" style="display:none;">
							<div class="numbersssdtfss">
								<?php 
									$currenturl = current_url();
									$params   	= $_SERVER['QUERY_STRING']; 
									$fullURL 	= $currenturl . '/?' . $params; 
								?>
								  <div class="active-screen createticket">									  
									  <div class="number-account">
										<span class="number three active">
											<a href="<?php echo $fullURL; ?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
										 </span>
										<span class="text-part active">
											Ticket Details
										</span>
									  </div>
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
							<div class="col-md-12">
								<span class="moneytitke"><span id="subcatname"></span> <span class="pricemorny">( <i class="fa fa-inr" aria-hidden="true"></i><span id="amount"></span> )</span> </span>
								<a class="back-btn btn btn-warning white-icon defirence" onclick="window.location.reload();" style="float:left;padding: 1px 8px;font-size: 11px;margin-left: 8px;border-radius: 30px;position: relative;top: 5px;" title="Back"><i class="fa fa-arrow-left" ></i>  Change Service</a>
							</div>
							<?php 
								$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
							?>
							<div class="col-md-6 floating-laebls mt-3">
								<h3 class="title-section mycit">Communication Details</h3>
								<div class="row mt-5">
									<div class="col-md-2">
										<div class="form-group inputBox focus">
											<?php 
												echo form_label('Title', 'title');
												$allprefix = [];
												foreach($prefixdata as $prefix){
													$allprefix[$prefix->id] = $prefix->title;
												}
												$selectedtitle = $ticketformdata['title'];
												if(empty($selectedtitle)){
													$selectedtitle = $customerData->title;
												}
												echo form_dropdown('title', $allprefix, set_value('title',$selectedtitle), 'class="form-control input" id="sel1" tabindex="1"');
											?>							
										</div>  
									</div>
									<div class="col-md-5">                
										<div class="form-group inputBox focus">
											<?php
												$selectedfname = $ticketformdata['fname'];
												if(empty($selectedfname)){
													$selectedfname = $customerData->name;
												}
												echo form_label('First Name *', 'fname');
												echo form_input(array('name' => 'fname', 'class' => 'form-control input', 'value' => set_value('fname',$selectedfname), 'id' => "fname",'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'2'));
												echo '<div class="error-msg">' . form_error('fname') . '</div>';
											?>					
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group inputBox focus">
											<?php
												$selectedsname = $ticketformdata['sname'];
												if(empty($selectedsname)){
													$selectedsname = $customerData->sname;
												}
												echo form_label('Last Name *', 'sname');
												echo form_input(array('name' => 'sname', 'class' => 'form-control input', 'value' => set_value('sname',$selectedsname), 'id' => "sname", 'onkeypress'=> 'return alpha(event)','maxlength'=>'50','tabindex'=>'3'));
												echo '<div class="error-msg">' . form_error('sname') . '</div>';
											?>	
										</div>
									</div>
								</div>
								 <div class="row mt-3">
									<div class="col-md-6 havwesomeadon">
										<div class="form-group inputBox focus">
											<?php echo form_label('Mobile Number*', 'customer_mobile'); ?>
											<div class="input-group">
												<span class="input-group-addon" id="sizing-addon1">+91</span>
											<?php
												$ticketmobile = !empty($ticketformdata['customer_mobile'])?$ticketformdata['customer_mobile']:'';
												$customermobile = !empty($selectedcityid)?'':$ticketmobile;
												if(empty($customermobile)){
													$customermobile = !empty($ticketmobile)?$ticketmobile:$customerData->mobile;
												}									
												echo form_input(array('name' => 'customer_mobile', 'class' => 'form-control input','id' => 'customer_mobile', 'value' => set_value('customer_mobile',$customermobile), 'maxlength' => '10'));
											?>
										   </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group inputBox focus">
											<?php
												$selectedemail = $ticketformdata['email'];
												if(empty($selectedemail)){
													$selectedemail = $userdetail->email;
												}
												echo form_label('Email *', 'email');
												echo form_input(array('type'=>'email','name' => 'email', 'class' => 'form-control input', 'value' => set_value('email',$selectedemail), 'id' => "email",'maxlength'=>'50','tabindex'=>'4'));
												echo '<div class="error-msg">' . form_error('email') . '</div>';
											?>
										</div>
									</div> 
								  </div>
								  <div class="row mt-3">
									<div class="col-md-9">
										<div class="form-group customtextre inputBox focus">
											<?php
												$ticketaddress = !empty($ticketformdata['customer_address'])?$ticketformdata['customer_address']:'';
												$customeraddress = !empty($selectedcityid)?'':$ticketaddress;
												if(empty($customeraddress)){
													$customeraddress = !empty($ticketaddress)?$ticketaddress:$customerData->address;
												}
												echo form_label('Address *', 'customer_address');
												echo form_textarea(array('name' => 'customer_address', 'class' => 'form-control input', 'value' => set_value('customer_address',$customeraddress), 'id' => "customer_address", 'cols' => '10', 'rows' => '3'));
											?>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group inputBox focus">
											<?php
												$ticketpincode = !empty($ticketformdata['customer_pincode'])?$ticketformdata['customer_pincode']:'';
												$customerzip = !empty($selectedcityid)?'':$ticketpincode;
												if(empty($customerzip)){
													$customerzip = !empty($ticketpincode)?$ticketpincode:$customerData->zip;
												}
												echo form_label('Pin code *', 'customer_pincode');
												echo form_input(array('name' => 'customer_pincode', 'class' => 'form-control input', 'value' => set_value('customer_pincode',$customerzip), 'id' => "customer_pincode",'maxlength'=>'6','minlength'=>'6'));
											?>
										</div>
									</div>	
								  </div>
								  <div class="row mt-3">
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
											$selectedcitydata = $this->session->userdata('selectedcitydata');
											$ticketstate = !empty($ticketformdata['customer_state'])?$ticketformdata['customer_state']:'';
											$ticketcity = !empty($ticketformdata['customer_city'])?$ticketformdata['customer_city']:'';
											$selectedstate 	= '';
											if(!empty($selectedcitydata)){
												$selectedcity 	= $this->user_model->getCityList($selectedcitydata,'');
												$selectedstate  = $selectedcity->city_state;
											}
											$selected_state	= !empty($selectedstate)?$selectedstate:$ticketstate;
											$choosedcity 	= !empty($selectedcitydata)?$selectedcitydata:$ticketcity;
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
												echo form_hidden('customer_state',$selected_state);
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
												echo form_hidden('customer_city',$choosedcity);
											?>
										</div>  
									</div>
								  </div>
								  <div class="row">
									<h3 class="title-section mycit">Ticket Details</h3>
									<div class="col-md-12 mt-5">
										<div class="form-group inputBox focus">
											<?php
												$ticketdesc = !empty($ticketformdata['description'])?$ticketformdata['description']:'';
												echo form_label('Query or describe your problem*(<span class="text-danger" style="font-size:8px; color: #a94442 !important;">(Please enter less than 500 characters.)</span>)', 'description');
												echo form_textarea(array('name' => 'description', 'class' => 'form-control input', 'value' => set_value('description',$ticketdesc), 'id' => "description", 'cols' => '10', 'rows' => '3', 'onkeyup'=>'countChar(this,500)'));
												echo '<div class="remain-char text-danger" style="display:none;"><span id="charNum"></span> Character remaining.</div>';
											?>
										</div>
									</div>
									<div class="col-md-12 mt-3">
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
								<div class="col-md-12" style="margin-top: 5px">
									<div class="form-group text-right customsubmtcandel">
										<?php
											echo form_submit(array("class" => "btn btn-primary", "id" => "create_tkt_btn", "value" => "Submit"));
											echo '&nbsp;&nbsp;<a href="' . base_url() . 'ticket/choose_category" class="btn btn-default">Cancel</a>';
										?>
									</div>
								</div>
						</div>
					 </div>
					 <div class="col-md-6 mt-3">
						<div class="faqccord">
							<div class="panel-group" id="accordion">
								
							</div>
						</div>
					 </div>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
		<div id="advantages" class="adventages">   
          <div class="container">
             <div class="row">
                 <div class="col-sm-12 col-md-12 margin-bottom">
                    <h2 class="puttocenter">Our Advantages</h2>
                  </div>
                 
                 <div class="col-sm-12 col-md-12 advantage_margin">
                     <div class="row">
                     <div class="col-sm-12 col-md-4 advantage_right">
                        <div class="advantge_box">
                            <span class="thisi"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
                            <h4>Time saving</h4>
                            <p>File online consumer complaint will save your time</p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 advantage_right">
                    	<div class="advantge_box">
                            <span class="thisi"><i class="fa fa-compass" aria-hidden="true"></i></span>
                            <h4>Complaint Anywhere</h4>
                            <p>It can be done from any location i.e. home, office or vacation trip</p>
                        </div>
                        
                     </div>
                     <div class="col-sm-12 col-md-4 advantage_right">
                        <div class="advantge_box legalbnotcie">
                           <span class="thisi"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>
                            <h4>Legal Notice</h4>
                            <p>You can send legal notice to the company</p>
                        </div>
                        </div>
                       </div>
                       <div class="row">
                    <div class="col-sm-12 col-md-4 advantage_right">
                    	<div class="advantge_box">
                            <span class="thisi"><i class="fa fa-mobile" aria-hidden="true"></i></span>
                            <h4>Any Device</h4>
                            <p>The complaint can be filed from mobile/computer</p>
                        </div>
                        
                     </div>
                     <div class="col-sm-12 col-md-4 advantage_right">
                     	<div class="advantge_box expertadvice">
                            <span class="thisi"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
                            <h4>Expert Advice</h4>
                            <p>You will receive assistance from Consumer Complaint experts of Online Legal India</p>
                        </div>
                        
                        </div>
                    <div class="col-sm-12 col-md-4 advantage_right">
                         
                         <div class="advantge_box">
                            <span class="thisi"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            <h4>Claim for Compensation</h4>
                            <p>You can claim for compensation amount from consumer court</p>
                        </div>
                        
                     </div>
                     </div>
                 </div>
              </div>
          </div>
      </div>
	  <div class="whychossefile">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="puttocenter">Why Choose Us</h2>
					<p>The key to our success is that we embrace collaboration and demand that our strategists, designers and project managers work closely and directly with our </p>
					<div class="choosecontent advantage_margin">
						<div class="row">
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-tachometer" aria-hidden="true"></i></span>
										<h4>Super Fast Service</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-user-o" aria-hidden="true"></i></span>
										<h4>Professional Experts</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-clock-o" aria-hidden="true"></i></span>
										<h4>On Time Service</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>							
							</div>
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-lock" aria-hidden="true"></i></span>
										<h4>Data Security</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>							
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-rupee" aria-hidden="true"></i></span>
										<h4>Affordable</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>							
							</div>
							<div class="col-md-6">
								<div class="advantage_right">
									<div class="advantge_box">
										<span class="thisi"><i class="fa fa-headphones" aria-hidden="true"></i></span>
										<h4>24X7 Platform</h4>
										<p>We specialize in design-led brandcommunication and digital innovation</p>
									</div>
								</div>
							</div>						
						</div>
					</div>


				</div>
			</div>
		</div>
	</div>
	<div class="refundpolicy">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h2 class="lwtitle">Refund policy</h2>
					<p>People don't have a tendency to read long and boring legal documents online. On the other hand, you have to provide all the necessary information.</p>
					<p>This is why it is advised to break down your return/refund policy into smaller sections. This will increase the readability of the document, make it easier for customers to find what they need and, at the same time, protect you legally.</p>
					<p>Despite what you sell, your refund/return policy should usually contain these three sections:</p>
					<ol><li>How many days a customer has to return the product. Does the counting start from the moment they order it, or from when the product gets shipped to them?</li><li>If the customer does return a product, you have to specify what kind of refund they are eligible to get. Some stores allow customers to get similar products or get a store credit in the value of the purchased item, while others return the cash spent on the product.</li><li>At last, you will have to specify who will pay for the return shipping. Some stores don’t charge customers that are in the same state or country as the business is, while others offer free return shipping regardless of the customer’s location.</li></ol>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
				</div>
				<div class="col-md-6">
					<div class="refundblockimg">
						<img class="img-responsive" src="https://filenotice.com/uploads/frontend/refund.png" />
					</div>
				</div>
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
			$('.categorytext').val(selectedText);
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
					url: '<?php echo base_url();?>users/ticketController/getsubcatdetailbyid',
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
</script>
