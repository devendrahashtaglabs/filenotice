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
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left"><h3 class="card-title"><?php echo $page_title; ?></h3></div>
                        
                    </div>
                    <div class="card-body manage-listd">
                        <?php
                        if($this->session->flashdata('responce_msg')!=""){
                            $message = $this->session->flashdata('responce_msg');
                            echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                        }
                        ?>
                        <div class="table-responsive customizetableres">
                        <table id="table_id" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ticket ID</th>
                                    <th>Payer Email</th>
                                    <th>Payment Amt</th>
                                    <th>Payment Date</th>
                                    <th>User Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $a = 1;
                            foreach ($response as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $a; ?></td> 
                                    <td><?php echo $row->ticket_id; ?></td>
                                    <td><?php echo $row->payer_email; ?></td>
                                     <td><?php echo 'Rs '.$row->payment_amount; ?></td>
                                    <td><?php echo $row->payment_date; ?></td>
                                    <td><?php echo $row->user_id; ?></td>
                                    <td></td>
                                </tr>
                            <?php $a++;} ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>