<style>
	label.error {
		margin-top: -1px;
		font-size: 12px;
	}
	.error {
		color: red;
		font-size: 12px;
	}
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



#description {
		min-height: 124px;
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
</style>
<?php 
	$ticketformdata 	= $this->session->userdata('ticketformdata');
	$payment_responce 	= $this->session->userdata('payment_responce');
?>
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
					<!-- Your code here -->
					<form action="#" id="payment_form">
						<div class="card-body">
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
									<a href="<?php //echo $fullURL; ?>"><i class="fa fa-file-text" aria-hidden="true"></i></a>
								 </span>
								<span class="text-part">
									Ticket Details
								</span>
							  </div>
							  <div class="number-account reacehd">
								<span class="number three">
									<a href=""><i class="fa fa-check-circle-o" aria-hidden="true"></i></a>
								</span>
								<span class="text-part">
									Review & Pay
								</span>
							  </div>
							  <div class="number-account">
								<span class="number four active">
									<a href="javascript:void(0);"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
								</span>
								<span class="text-part active">
									Ticket Consultancy
								</span>
							  </div>
							</div>
						</div>
					</div>
						<div class="col-md-12 my-2">
							<h3 class="title-section mycit pyesr">Payment Details</h3>
							<!-- Your code here -->
							<form action ="<?php echo $pageUrl; ?>" method ="post" id="FilenoticeLoginForm">
								<div class="col-md-12a">
									<?php
										if($this->session->flashdata('responce_msg')!=""){
											$message = $this->session->flashdata('responce_msg');
											echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
										}
									?>
								</div>
								<div class="row">
									<div class="form-group col-4">
										<span class="text mainn"><label>Transaction/Order ID:</label></span>
										<span class="valuetext"><?php echo $txnid; ?></span>
									</div>
									
									<div class="form-group col-4">
										<span class="text mainn"><label>Amount:</label></span>
										<span class="valuetext"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $amount; ?></span>    
									</div>
									
									<div class="form-group col-4">
										<span class="text mainn"><label>Product Info:</label></span>
										<span class="valuetext"><?php echo $productInfo; ?></span>
									</div>
								</div>
								<?php 
									$title = $ticketformdata['title'];
									$fname = $ticketformdata['fname'];
									$sname = $ticketformdata['sname'];
									$fullname =  $title .' '. $fname . ' '. $sname;
								?>
								<div class="row">
									<div class="form-group col-4">
										<span class="text mainn"><label>Name:</label></span>
										<span class="valuetext"><?php echo $fullname; ?></span>
									</div>
									
									<div class="form-group col-4">
										<span class="text mainn"><label>Email ID:</label></span>
										<span class="valuetext"><?php echo $ticketformdata['email']; ?></span>
									</div>
									<div class="form-group col-4">
										<span class="text mainn"><label>Mobile:</label></span>
										<span class="valuetext"><?php echo $ticketformdata['customer_mobile']; ?></span>
									</div>
								</div>
								<?php 
									$countrydata 	= $this->user_model->getCountryList($ticketformdata['customer_country']);
									$statedata 		= $this->user_model->getStateList($ticketformdata['customer_state'],'');
									$citydata 		= $this->user_model->getCityList($ticketformdata['customer_city'],'');
								?>
								<div class="row">
									<div class="form-group col-4">
										<span class="text mainn"><label>Country:</label></span>
										<span class="valuetext"><?php echo $countrydata->name; ?></span>
									</div>
									
									<div class="form-group col-4">
										<span class="text mainn"><label>State:</label></span>
										<span class="valuetext"><?php echo $statedata->name; ?></span>
									</div>
									<div class="form-group col-4">
										<span class="text mainn"><label>City:</label></span>
										<span class="valuetext"><?php echo $citydata->city_name; ?></span>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-4">
										<span class="text mainn"><label>Pincode:</label></span>
										<span class="valuetext"><?php echo $ticketformdata['customer_pincode']; ?></span>
									</div>
									
									<div class="form-group col-4">
										<span class="text mainn"><label>Address:</label></span>
										<span class="valuetext"><?php echo $ticketformdata['customer_address']; ?></span>
									</div>
									<div class="form-group col-4">
										<span class="text mainn"><label>Transaction Status:</label></span>
										<span class="valuetext"><?php echo $status; ?></span>
									</div>
								</div>
								
								<?php /*<div class="form-group dv">
									<span class="text"><label>Hash:</label></span>
									<span style="word-wrap: break-word;"><?php echo $resphash; ?></span>
								</div>*/ ?>
								<div class="row">
									
									<div class="form-group col-md-12">
										<span class="text mainn"><label>Message:</label></span>
										<span class="valuetext"><?php echo $msg; ?></span>
									</div>
								</div>
								<div class="form-group dv" style="margin-top:50px;" id="timeLeft">
								</div>
							</form>
						</div>
					</div>
				</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
<script type="text/javascript">
	
	var count = 20;
	var redirect = '<?php echo base_url()."ticket/createnewticket"; ?>';
	 
	function countDown(){
		var timer = document.getElementById("timeLeft");
		if(count > 0){
			count--;
			timer.innerHTML = "This page will redirect in "+count+" seconds.";
			setTimeout("countDown()", 1000);
		}else{
			window.location.href = redirect;
		}
	}
</script>
<script type="text/javascript">
	countDown();
</script>