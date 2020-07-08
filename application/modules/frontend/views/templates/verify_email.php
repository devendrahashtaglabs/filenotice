<style>
	label.error {
		margin-top: -1px;
		font-size: 12px;
	}
	.error {
		color: red;
		font-size: 12px;
	}
	.btn-warning {
		background: #F3781E;
		color: #fff;
		border: 2px solid #F3781E;
	}
	.custom-form label.error {
		color: red;
		font-size: 10px;
		line-height: 12px;
	}
	.my-5 {
	margin: 1.5em 0px;
}
.resttabs form {
    padding: 0px 20px 0;
}
</style>
<div class="bgsectionlogin loginregisfor">
	<div class="container vertical-center">
		<div class="row my-5">	
			<div class="col-md-6">
			<div class="tab-content resttabs">
				<div class="">
					<div class="sc_heading   text-center" style="padding: 0px 0 0;margin-bottom:0px;">
						<h2 class="title" style="margin: 0;font-size: 18px;text-align: left;background: #263a7d;padding: 15px 8px;color: #fff;min-height: 65px;">Consultant Email Veryfication</h2>
					</div>
					<div class="floating-laebls">
						<!-- Your code here -->
						<form action ="#" method ="post" id="FilenoticeLoginForm">
							<div class="col-md-12a  mt-5">
								<div class="alert alert-success alert-dismissible"><strong>Success!</strong> Your email verified successfully.<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a></div>
								<h5 class="text-center">For login please click <a href="<?php echo base_url().'login'; ?>">here</a>!</h5>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
		</div>
		</div>
	</div>
</div>