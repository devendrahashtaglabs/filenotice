<?php $usersession = $this->session->userdata('users'); ?>
<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding-top: 0px;">
                <div class="user-panel d-flex">
                    <div class="image displaypicture">
                        <img src="<?php echo $profilePic; ?>" class="img-circle elevation-2" alt="User Image"/>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    <div class="info">
                        <a href="<?php echo base_url($userType.'/profile'); ?>" class="d-block"><?php echo !empty($usersession)?$usersession['user_name']:''; ?></a>
                    </div>
                </span>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url($userType.'/profile'); ?>" class="dropdown-item">
                    <i class="fa fa-envelope mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url($userType.'/change-password'); ?>" class="dropdown-item">
                    <i class="fa fa-user mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url($userType.'/logout'); ?>" class="dropdown-item">
                    <i class="fa fa-sign-out mr-2"></i> Logout
                </a>
            </div>
        </li>
<!--        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url($userType.'/logout'); ?>" title="Logout">
                <i class="fa fa-sign-out mr-2"></i>
            </a>
        </li>-->
    </ul>
</nav>

