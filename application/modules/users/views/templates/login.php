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
        <a href="<?php echo $pageUrl; ?>"><b><?php echo $page_title; ?></b></a>
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
            echo '<div class="form-group has-feedback">'
            . form_input(array('name' => 'username', 'value'=>set_value('username'), 'class' => 'form-control', 'placeholder' => 'Email'))
            . '<span class="fa fa-envelope form-control-feedback"></span><div class="error-msg">' . form_error('username') . '</div></div>';
            echo '<div class="form-group has-feedback">'
            . form_password(array('name' => 'password', 'value'=>'', 'class' => 'form-control', 'placeholder' => 'Password'))
            . '<span class="fa fa-lock form-control-feedback"></span><div class="error-msg">' . form_error('password') . '</div></div>';
            echo '<div class="row">
              <div class="col-8"><div class="checkbox icheck"><p class="mb-1"><a href="#">I forgot my password</a></p></div></div>
              <div class="col-4">' . form_submit(array("name" => "login_btn", "class" => "btn btn-primary btn-block btn-flat", "id" => "login-btn", "value" => "Sign In")) . '
              </div></div>';
            echo form_close();
            ?>
        </div>
    </div>
</div>