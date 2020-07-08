<link type="text/css" href="//cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.css" rel="stylesheet" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js"></script>
<script type="text/javascript" src="http://www.alpacajs.org/lib/jquery-maskedinput/dist/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.js"></script>
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
}
.alpaca-required-indicator{
	display:none;
}
</style>
<div class="container">	
	<div class="row">
	   <div class="col-md-12">
			<div class="thim-login form-submission-register custom-form">
			<!-- Your code here -->
			<?php
				$selectedcityid = $this->session->userdata('selectedcityid'); 
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
			<div class="row customlbleint" id="frontticketform">
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
				<?php 
					$subcatname = !empty($ticketformdata)?$ticketformdata["name"]:'';
					$amount 	= !empty($ticketformdata)?$ticketformdata["amount"]:'';
				?>
				<div class="col-md-12">
					<span class="moneytitke"><span id="subcatname"><?php echo $subcatname;  ?></span> &nbsp;&nbsp;( <i class="fa fa-inr" aria-hidden="true"></i><span id="amount"><?php echo $amount;  ?></span> ) </span>
					<a href="<?php echo base_url().'create_ticket/?catid='.$ticketformdata['urlcatid'];?>" class="back-btn btn btn-warning white-icon" id="choosesubcat" style="float:left;padding: 1px 8px;font-size: 11px;margin-left: 8px;" title="Back"><i class="fa fa-arrow-left" ></i> Want to choose a different service ? Change now</a>
				</div>
				<?php 
					echo form_open_multipart($pageUrl, array('class' => 'create_ticket', 'id' => 'ticketformfront'));
				?>
				<div class="col-md-12" style="margin-top: 5px">
					<div class="form-group col-12 text-right">
						<?php
						    echo '&nbsp;&nbsp;<a href="' . base_url() . '" class="btn btn-danger" tabindex="15">Cancel</a>';
							echo form_submit(array("class" => "btn btn-warning", "id" => "create_tkt_btn", "value" => "Submit","tabindex"=>"16"));
							
						?>
					</div>
				</div>
				<?php echo form_close(); ?>
				<div id="form"></div>
			</div>
		</div>
	  </div>
	</div>
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
/* $('#choosesubcat').click(function(){
	$('.choosectg').show();
	$('#frontticketform').hide();
}); */
<?php 
	if(!empty($subcatdata->json_form)){
?>
/* $("#ticketformfront").jsonForm({
	<?php echo $subcatdata->json_form; ?>
}); */
<?php } ?>
</script>
<script type="text/javascript">
   $(document).ready(function() {
		var base_url 	= '<?php echo base_url(); ?>';
		var now 		= new Date();
		$('#userdob').addClass('datepickerdob');
		$("#form").alpaca({
			"schema": {
				"title":"User Feedback",
				"type":"object",
				"properties": {
					"username": {
						"type":"string",
						"title":"Name *",
						"required":true,
						"maxLength": 50,
						"minLength": 5,
					},
					"useremail": {
						"type":"string",
						"title":"Email *",
						"required":true,
						"maxLength": 50,
						"minLength": 5,
					},
					"usermobile": {
						"type":"string",
						"title":"Mobile Number",
						//"format":"phone",
						"required":true,
						"maxLength": 14,
						"minLength": 14,
					},
					"usergender": {
						"type":"string",
						"title":"Gender",
						"enum": [ "male", "female", "other" ],
						"required":true
					},
					"userdob": {
						"type":"string",
						"title":"DOB",
						"format": "date"
					},
					"userpass": {
						"type":"string",
						"title":"Password",
					},
					"image": {
						"type":"string",
						"title":"Profile",
					},
					"feedback": {
						"type":"string",
						"title":"Feedback"
					},
					"language": {
						"type":"string",
						"title":"Native Language",
						"enum": [ "hindi", "english", "urdu", "arabi", "french", "japaneese" ],
						"required":true
					},					
					"icecream":{
						"enum": ["vanilla", "chocolate", "coffee", "strawberry", "mint"],
						"required":true
					},					
					/* "food":{
						"enum": ["Dosa", "Aloo Paratha", "Baingan Bharta", "Zaitooni Subz Biryani", "Ghavan"],
						"required":true
					} */
				}
			},
			"options": {
				"form":{
					"attributes":{
						"action": base_url+ 'getsubcatform',
						"method":"post",
						"id":"subcatform",
					},
					"buttons": {
						"view": {
							"label": "Submit",
							"click": function() {
								var formdetails = new FormData($('#subcatform')[0]);
								$.ajax({
									url: base_url+'frontend/ticketController/getsubcatformdata',
									type: "post",
									data: formdetails, 
									processData: false,
									contentType:false,
									success: function(data){
										window.location.href = data;
									}
								});
							}
						}
					}
				},
				"fields": {
					"username": {
						"size": 20,
						"placeholder": "Please enter your name."
					},
					"useremail": {
						"type": "email",
						"size": 20,
						"placeholder": "Please enter your email."
					},
					"usermobile": {
						"type": "phone",
						"placeholder": "Please enter your mobile number.",
						"maskString": "(999) 999-9999",
					},
					"usergender": {
						"type": "radio",
						"optionLabels": ["Male","Female","Other"]
					},
					"userpass": {
						"type": "password",
						"size": 20,
						"placeholder": "Please enter your password."
					},
					"userdob": {
						"id":"userdob",
						"inputType": "date",
						"dateFormat": "DD/MM/YYYY",
						"placeholder": "Please enter dob.",
						"picker": {
							"minDate": new Date().setDate(now.getYear() -80),
							"maxDate": new Date().setDate(now.getYear() -18),
							"locale": "es"
						}
					},
					"image": {
						"type": "file",
						"size": 20,
						"placeholder": "Please choose your profile."
					},
					"feedback" : {
						"type": "textarea",
						"name": "your_feedback",
						"rows": 5,
						"cols": 40,
						"placeholder": "Please enter your feedback."
					},
					"language": {
						"type": "radio",
						"optionLabels": ["Hindi","English","Urdu","Arabi","French","Japaneese"]
					},
					"icecream":{
						"label": "Choose Icecream",
					},
					/* "food":{
						"dataSource": function(callback) {
							callback(["Dosa", "Aloo Paratha", "Baingan Bharta", "Zaitooni Subz Biryani", "Ghavan"]);
						},
						"label": "Select your favorite food",
						"type": "select",
						"multiple": true,
						"size": 3
					}, */
				}
			}
		});
	});
</script>