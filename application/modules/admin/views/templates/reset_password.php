<style>
    .form-group.has-feedback {
    position: relative;
}
.form-group.has-feedback span {
    position: absolute;
    top: 0;
    left: 10px;
}
.form-group.has-feedback input {
    padding-left: 30px;
}
</style>
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo $pageUrl.'/'.$this->uri->segment(3); ?>"><b><?php echo $page_title; ?></b></a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <?php
                if($this->session->flashdata('responce_msg')!=""){
                    $message = $this->session->flashdata('responce_msg');
                    echo sprintf(ALERT_MESSAGE,$message['class'],$message['short_msg'],$message['message']);
                }
            ?>
            <?php
            echo form_open($pageUrl);
            echo '<div class="form-group has-feedback"><input name="token" type="hidden" value="'.$this->uri->segment(3).'">'
            . form_password(array('name' => 'new_password', 'value'=>'', 'class' => 'form-control', 'placeholder' => 'New Password'))
            . '<span class="fa fa-lock form-control-feedback"></span><div class="error-msg">' . form_error('password') . '</div></div>';
            echo '<div class="form-group has-feedback">'
            . form_password(array('name' => 'confirm_password', 'value'=>'', 'class' => 'form-control', 'placeholder' => 'Confirm Password'))
            . '<span class="fa fa-lock form-control-feedback"></span><div class="error-msg">' . form_error('password') . '</div></div>';
            echo '<div class="row">
              <div class="col-4">' . form_submit(array("name" => "submit", "class" => "btn btn-primary btn-block btn-flat", "value" => "Submit")) . '
              </div><div class="col-8" ><a href="'.base_url().'admin/login" class="btn btn-info btn-block btn-flat col-4" style="float:right">Back</a>
              </div></div>';
            echo form_close();
            ?>
        </div>
    </div>
    
</div>