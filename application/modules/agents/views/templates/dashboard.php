<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-success"><?php echo isset($welcome_title)?$welcome_title:''; ?></h1>
                </div>
                <div class="col-sm-6">
                    <?php echo $breadcrumb; ?>
                </div>
            </div>
        </div>
    </div>
    <section class="flash_msg">
        <div class="container-fluid">
            <div class="row"> 
				<div class="col-md-12 col-xs-12">
					<?php
						if($this->session->flashdata('responce_msg')!=""){
							$message = $this->session->flashdata('responce_msg');
							echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
						}
					?>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner total-count">
							<h3><?php echo isset($totalTickets['count']) ? $totalTickets['count']:'0'; ?></h3>
							<p>Total Tickets </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-ticket" aria-hidden="true"></i>
                        </div>
                        <?php /*<a href="<?php echo base_url('ticket/list'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>*/ ?>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo isset($assignTickets['count'])? $assignTickets['count']:'0';?></h3>
                            <p>Assigned Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </div>
                        <a href="<?php echo base_url('agent/ticket/assign'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?php echo isset($completedTickets['count'])? $completedTickets['count']:'0';?></h3>
                            <p>Completed Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                        </div>
                        <a href="<?php echo base_url('agent/ticket/completed'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>