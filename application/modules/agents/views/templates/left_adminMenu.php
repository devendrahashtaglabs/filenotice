<?php
$profilePic = fileExistsInLoacation()['target'];
if (!empty($this->session->userdata('agents')) && (!empty($this->session->userdata('agents')['user_id']))) {
    //$userType 		= ($this->session->userdata('users')['user_type'] == 'customer') ? '2' : '3';
	if($this->session->userdata('agents')['user_type'] == 'agent'){
		$userType = '4';
	}elseif($this->session->userdata('users')['user_type'] == 'consultant'){
		$userType = '3';		
	}else{
		$userType = '2';				
	}
    $userDetails 	= $this->user_model->getUserDetailsById($this->session->userdata('agents')['user_id'], $userType);
    if (!empty($userDetails)) {
        $profilePic = fileExistsInLoacation($userDetails->photo, 'profile')['target'];
    }
}
include 'top_header.php';
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php /*<a href="<?php echo $pageUrl; ?>" class="brand-link"> */?>
    <a href="<?php echo base_url('agent/dashboard'); ?>" class="brand-link">
        <img src="<?php echo base_url() . 'uploads/settings/5-1-300x185.png'; ?>" alt="Filenotice Logo" class="brand-image img-circle elevation-3" style="opacity: .8"><br/><br/>
        <span class="brand-text font-weight-light"><?php echo _settingBykey('site_title') ?></span>
    </a>
    <div class="sidebar">
        <?php
			$segment1 = $this->uri->segment(2);
			$segment2 = $this->uri->segment(3);
			$uri_segment = '';
			if ($segment2) {
				$uri_segment = $segment2;
			} else {
				$uri_segment = $segment1;
			}
			$li_class = 'active';
			$menu_open = 'menu-open';
        ?>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('agent/dashboard')) ? $menu_open : ''); ?>">
                    <a href="<?php echo base_url('agent/dashboard'); ?>" class="nav-link <?php echo($uri_segment == 'dashboard' ? $li_class : ''); ?>">
                        <i class="fa fa-dashboard nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(2), array('ticket')) && !in_array($this->uri->segment(3), array('feedback')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ticket"></i>
                        <p>Ticket Management
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
							<a href="<?php echo base_url('agent/ticket/assign'); ?>" class="nav-link <?php echo((in_array($uri_segment, array('assign', 'conversation'))) ? $li_class : ''); ?>">
								<i class="fa fa-list nav-icon"></i>
								<p>Assigned Ticket</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('agent/ticket/completed'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'completed')) ? $li_class : ''); ?>">
								<i class="fa fa-list nav-icon"></i>
								<p>Completed Ticket</p>
							</a>
						</li>
                    </ul>
                </li>				
                <?php /*<li class="nav-item has-treeview">
                    <a href="<?php echo base_url('agent/ticket/feedback'); ?>" class="nav-link <?php echo($uri_segment == 'feedback' ? $li_class : ''); ?>">
                        <i class="fa fa-user-plus nav-icon"></i>
                        <p>Feedback</p>
                    </a>
                </li>*/?>
                <li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(2), array('profile', 'change-password')) ? $menu_open : ''); ?> ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ticket"></i>
                        <p>Profile Management
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?php echo base_url('agent/profile'); ?>" class="nav-link <?php echo($uri_segment == 'profile' ? $li_class : ''); ?>">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url('agent/change-password'); ?>" class="nav-link <?php echo($uri_segment == 'change-password' ? $li_class : ''); ?>">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('agent/logout'); ?>"class = "nav-link">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>