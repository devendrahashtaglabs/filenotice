<link type="text/css" href="<?php echo base_url().'cosmatics/plugins/alpacaform/alpaca.min.css'; ?>" rel="stylesheet" />
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
#description {
	min-height: 124px;
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
#description {
	min-height: 124px;
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
.alpaca-required-indicator{
	display:none;
}
.alpaca-field-object {
	padding: 0;
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
                        <h3 class="card-title"><?php //echo $page_title; ?></h3>
                    </div>
                    <?php
						$selectedcitydata = $this->session->userdata('selectedcitydata');
						echo form_open_multipart($pageUrl.'/create/?catid='.$catids, array('class' => 'create_ticket', 'id' => 'CustomerTicketForm'));
                    ?>
                    
                    <div class="card-body">
						<div class="row">
							<?php 
								$ticketformdata = $this->session->userdata('ticketformdata');
								$usersession 	= $this->session->userdata('users');
								$userdetail		= $this->user_model->getDataBykey('nw_user_tbl','id',$usersession['user_id']);
							?>
							<!-- Your code here -->
							<?php
								$selectedcityid = $this->session->userdata('selectedcityid'); 
								$prefixdata = $this->user_model->getDataByTable('nw_prefix_tbl');
							?>
							<div class="col-md-12">
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
							<div class="col-md-12">
								<div class="form-group">
									<div class="headerdesctiption text-center">
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
									<div class="form-group choosectg">
										<?php echo form_label('Choose Subcategory*', 'description'); ?>
										<br/>
										<ol id="selectable">
											<?php 
												foreach($subcategorylist as $subcatlist){
											?>
												<li class="ui-state-default" data-id="<?php echo $subcatlist->id; ?>">
													<span class="liicons ui-selectee"><i class="fa fa-graduation-cap" aria-hidden="true"></i></span>
													<p><?php echo $subcatlist->name; ?></p><p><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $subcatlist->amount; ?></p>
												</li>
											<?php } ?>
										</ol>
										<input type="text" name="subcatid" id="subcatid" value="<?php echo $ticketformdata['subcatid'];?>" required="required" />
										<?php echo '<div class="error-msg" id="subcat_error_message_tools">' . form_error('image') . '</div>'; ?>
									</div>
								</div> 
							</div>
						</div>
						<div class="row" id="frontticketform">
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
						</div>
						<?php 
							$subcatname = !empty($ticketformdata)?$ticketformdata["name"]:'';
							$amount 	= !empty($ticketformdata)?$ticketformdata["amount"]:'';
						?>
						<div class="row">
							<div class="col-md-12 tittleandback">
								<span class="moneytitke"><span id="subcatname"><?php echo $subcatname;  ?></span> <span class="pricemorny">( <i class="fa fa-inr" aria-hidden="true"></i><span id="amount"><?php echo $amount;  ?></span> )</span> </span>
								<a href="<?php echo base_url().'ticket/create/?catid='.$ticketformdata['urlcatid'];?>" class="back-btn btn btn-warning white-icon defirence" id="choosesubcat" style="float:left;padding: 1px 8px;font-size: 11px;margin-left: 8px;border-radius: 30px;position: relative;top: 5px;" title="Back"><i class="fa fa-arrow-left" ></i> Change Service</a>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="formares floating-laebls" id="subcategoryform">
									
								</div>
							</div>
							<div class="col-md-6">
								<?php 
									$subcatid = $ticketformdata['subcatid'];
									$subcategorydata 	= $this->category_model->get_category_data($subcatid);
									if(!empty($subcategorydata)){ 
										$faqid 	= $subcategorydata->faq;
										$faqids = explode(',',$faqid);
								?>
								<div class="faqccord mt-5">
									<div class="panel-group" id="accordion">
										<?php 
											$count 	= 1;
											foreach($faqids as $faq){
												if($count == 1){
													$in = 'in';
												}else{
													$in = '';					
												}
												$faqdata = $this->user_model->getDataBykey('nw_faq_tbl','id',$faq);
												if(!empty($faqdata)){
										?>
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>"><span class="glyphicon glyphicon-menu-right"></span> <?php echo $faqdata->faq_que; ?></a>
												</h4>
											</div>
											<div id="collapse<?php echo $count; ?>" class="panel-collapse collapse <?php echo $in; ?>">
												<div class="panel-body">
													<?php echo $faqdata->faq_ans; ?><a href="<?php echo $faqdata->read_more_link; ?>" target="_blank">Read more.</a>
												</div>
											</div>
										</div>
										<?php } $count++; } ?>
									</div>
								</div>
								<?php } ?>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
        </div>
        </div>
    </section>
</div>
<script>
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
} );
function alpha(e) {
	var k;
	document.all ? k = e.keyCode : k = e.which;
	return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
}
</script>
<script type="text/javascript">
<?php if(!empty($subcatdata->json_form_back)){ ?>
   $(document).ready(function() {
		var base_url 	= '<?php echo base_url(); ?>';
		$("#subcategoryform").alpaca({
			<?php 
				echo $subcatdata->json_form_back;
			?>
		});
	});
<?php }else{ ?>
	$(document).ready(function() {
		$("#subcategoryform").html('<p class="text-danger">Form not available.</p>');
	});
<?php } ?>
</script>