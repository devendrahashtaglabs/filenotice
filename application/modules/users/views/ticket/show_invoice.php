<style>
	.tooltipz:hover .tooltiptext {
	  visibility: visible;
	  opacity: 1;
	}
	.ticketslistr .modal-dialog {
		max-width: 950px;
		margin: 1.75rem auto;
	}
	.ticketslistr .valuetext {
		font-size: 15px;
		margin: 0 0 10px;
	}
	
	.ticketslistr .text.mainn label {
		font-size: 14px;
		margin: 0;
	}
	.modal{
		z-index: 9999;
	}
	.invoice {
		position: relative;
		background: transparent;
		border: none;
	}
	.ticketslistr .modal-body {
	  background: #f4f4ff;
	  flex: none;
	  padding: 8px 28px 8px;
	}
	.modal-open .modal {
	  overflow: hidden;  
	  padding-right: 0 !important;
	}
</style>
<?php 
	$catdata 		= $this->category_model->get_category_data($ticketdata->category_id);
	$subcatdata 	= $this->category_model->get_category_data($ticketdata->subcategory_id);
	$paymentdatas 	= $this->ticket_model->getthedata('ticket_id',$ticketdata->id,'nw_payment_tbl');
	$paymentdata	= $paymentdatas[0];
	$invoicedatas 	= $this->ticket_model->getthedata('ticket_id',$ticketdata->id,'nw_invoice_tbl');
	$invoicedata	= $invoicedatas[0];
	$countrydata 	= $this->user_model->getCountryList($ticketdata->customer_country);
	$statedata 		= $this->user_model->getStateList($ticketdata->customer_state,'');
	$citydata 		= $this->user_model->getCityList($ticketdata->customer_city,'');
?>
<div class="row">
	<section class="content invoice">
		<!-- title row -->
		<div class="row">
			<div class="col-md-12 invoice-header">
				<h3>
					<i class="fa fa-globe"></i> Invoice.
					<?php 
						$invoicedate = date('d-m-Y',strtotime($invoicedata->created));
					?>
					<small class="pull-right">Date: <?php echo !empty($invoicedate)?$invoicedate:''; ?></small>
				</h3>
			</div>
			<!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info">
			<div class="col-sm-4 invoice-col">
				From
				<address>
					<strong>HashTag Labs</strong>
					<br>D-147/4A, Indira Nagar, Lucknow – 226016 (UP) INDIA
					<br>Phone: +91 (0522) 4248697
					<br>Email: coffee@hashtaglabs.biz
				</address>
			</div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col">
				To
				<address>
					<?php 
						$title 			= $ticketdata->title;
						$prefixdatas 	= $this->ticket_model->getthedata('id',$title,'nw_prefix_tbl');
						$titledata 		= !empty($prefixdatas)?$prefixdatas[0]:'';
						$fullname 		= $titledata->title .' '. $ticketdata->customername .' '.$ticketdata->customersname;
					?>
					<strong><?php echo $fullname; ?></strong>
					<br><?php  echo !empty($ticketdata->customer_address)?$ticketdata->customer_address:''; ?>
					<br>Phone: <?php  echo !empty($ticketdata->customer_mobile)?$ticketdata->customer_mobile:''; ?>
					<br>Email: <?php  echo !empty($ticketdata->useremail)?$ticketdata->useremail:''; ?>
				</address>
			</div>
			<!-- /.col -->
			<div class="col-sm-4 invoice-col">
				<b>Invoice #<?php echo !empty($invoicedata->invoice_id)?$invoicedata->invoice_id:''; ?></b>
				<br>
				<br>
				<b>Order ID:</b> <?php echo !empty($ticketdata->ticket_id)?$ticketdata->ticket_id:''; ?>
				<br>
				<?php 
					$payment_date 	= !empty($paymentdata->payment_date)?$paymentdata->payment_date:'';
					$paymentdate 	=  date('d-m-Y',strtotime($payment_date));
				?>
				<b>Payment Due:</b> <?php echo $paymentdate; ?>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- Table row -->
		<div class="row">
			<div class="col-xs-12 table" style="margin-bottom: 0">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>S No</th>
							<th>Ticket Raised For</th>
							<th>Ticket Id</th>
							<th style="width: 59%">Description</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<?php 
								$catname 	= $catdata->name;
								$subcatname = $subcatdata->name;
							?>
							<td><?php echo $catname.' [ '. $subcatname .' ]'; ?></td>
							<td><?php echo !empty($ticketdata->ticket_id)?$ticketdata->ticket_id:''; ?></td>
							<td><?php echo !empty($ticketdata->description)?$ticketdata->description:''; ?>
							</td>
							<td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<div class="row">
			<!-- accepted payments column -->
			<div class="col-md-6">
				<p class="lead">Payment Methods:</p>
				<img src="<?php echo base_url() ?>cosmatics/images/visa.png" alt="Visa">
				<img src="<?php echo base_url() ?>cosmatics/images/mastercard.png" alt="Mastercard">
				<img src="<?php echo base_url() ?>cosmatics/images/american-express.png" alt="American Express">
				<img src="<?php echo base_url() ?>cosmatics/images/paypal.png" alt="Paypal">
				<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
					Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
				</p>
			</div>
			<!-- /.col -->
			<div class="col-md-6">
				<?php 
					$payment_date 	= !empty($paymentdata->payment_date)?$paymentdata->payment_date:'';
					$paymentdate 	=  date('d-m-Y',strtotime($payment_date));
				?>
				<p class="lead">Amount Due <?php echo $paymentdate; ?></p>
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th style="width:50%">Subtotal:</th>
								<td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></td>
							</tr>
							<tr>
								<th>Tax </th>
								<td><i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
							</tr>
							<tr>
								<th>Shipping:</th>
								<td> <i class="fa fa-inr" aria-hidden="true"></i> 0.00</td>
							</tr>
							<tr>
								<th>Total:</th>
								<td><strong><i class="fa fa-inr" aria-hidden="true"></i> <?php echo !empty($paymentdata->payment_data)?$paymentdata->payment_data:''; ?></strong></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->

		<!-- this row will not appear when printing -->
		<div class="row no-print">
			<div class="col-md-12">
				<button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
				<!--<button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>-->
				<button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>
			</div>
		</div>
	</section>
</div>


