<style>
	.tooltipz:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}
	.ticketslistr .modal-dialog {
		max-width: 800px;
		margin: 1.75rem auto;
	}
	.ticketslistr .valuetext {
		font-size: 15px;
		margin: 0 0 10px;
	}
	.ticketslistr .modal-body{
		background: #f4f4ff;
	}
	.ticketslistr .text.mainn label {
		font-size: 14px;
		margin: 0;
	}
</style>
<?php 
	$subcatdata 	= $this->category_model->get_category_data($ticketdata->subcategory_id);
	$paymentdatas 	= $this->ticket_model->getthedata('ticket_id',$ticketdata->id,'nw_payment_tbl');
	$paymentdata	= $paymentdatas[0];
	$countrydata 	= $this->user_model->getCountryList($ticketdata->customer_country);
	$statedata 		= $this->user_model->getStateList($ticketdata->customer_state,'');
	$citydata 		= $this->user_model->getCityList($ticketdata->customer_city,'');
?>
<div class="row">
	<div class="col-4">
		<span class="text mainn"><label>Ticket Id:</label></span>
		<span class="valuetext"><?php echo $ticketdata->ticket_id; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Category:</label></span>
		<span class="valuetext"><?php echo $ticketdata->category_name; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Subcategory:</label></span>
		<span class="valuetext"><?php echo $subcatdata->name; ?></span>
	</div>
</div>
<div class="row">
	<div class="col-4">
		<span class="text mainn"><label>Payment Status:</label></span>
		<span class="valuetext"><?php echo ($ticketdata->payment_status == '1')?'Paid':'Not Paid'; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Amount:</label></span>
		<span class="valuetext"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $paymentdata->payment_data; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Description:</label></span>
		<span class="valuetext"><?php echo $ticketdata->description; ?></span>
	</div>
</div>
<div class="row">
	<div class="col-4">
		<span class="text mainn"><label>Mobile Number:</label></span>
		<span class="valuetext"><?php echo $ticketdata->customer_mobile; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Country:</label></span>
		<span class="valuetext"><?php echo $countrydata->name; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>State:</label></span>
		<span class="valuetext"><?php echo $statedata->name; ?></span>
	</div>
</div>
<div class="row">
	<div class="col-4">
		<span class="text mainn"><label>City:</label></span>
		<span class="valuetext"><?php echo $citydata->city_name; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Pincode:</label></span>
		<span class="valuetext"><?php echo $ticketdata->customer_pincode; ?></span>
	</div>
	<div class="col-4">
		<span class="text mainn"><label>Address:</label></span>
		<span class="valuetext"><?php echo $ticketdata->customer_address; ?></span>
	</div>
</div>