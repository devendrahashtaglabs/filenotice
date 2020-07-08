<?php
$profilePic = fileExistsInLoacation()['target'];
if (!empty($this->session->userdata('users')) && (!empty($this->session->userdata('users')['user_id']))) {
    //$userType = ($this->session->userdata('users')['user_type'] == 'customer') ? '2' : '3';
	if($this->session->userdata('users')['user_type'] == 'customer'){
		$userType = '2';
	}elseif($this->session->userdata('users')['user_type'] == 'consultant'){
		$userType = '3';		
	}else{
		$userType = '4';				
	}
    $userDetails 	= $this->user_model->getUserDetailsById($this->session->userdata('users')['user_id'], $userType);
    if (!empty($userDetails)) {
        $profilePic = fileExistsInLoacation($userDetails->photo, 'profile')['target'];
    }
}
include 'top_header.php';
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <?php /*<a href="<?php echo $pageUrl; ?>" class="brand-link"> */?>
    <a href="<?php echo base_url('dashboard'); ?>" class="brand-link">
        <img src="<?php echo base_url() . 'uploads/settings/flogo.png'; ?>" alt="Filenotice Logo" class="brand-image img-circle elevation-3" style="opacity: .8"><br/>
        <span class="brand-text font-weight-light"style="display: none;"><?php echo _settingBykey('site_title') ?></span>
    </a>
    <div class="sidebar">
        <?php
			$segment1 = $this->uri->segment(1);
			$segment2 = $this->uri->segment(2);
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
                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('dashboard')) ? $menu_open : ''); ?>">
                    <a href="<?php echo base_url('dashboard'); ?>" class="nav-link <?php echo($uri_segment == 'dashboard' ? $li_class : ''); ?>">
                        <i class="fa fa-dashboard nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(1), array('ticket')) && !in_array($this->uri->segment(2), array('feedback')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ticket"></i>
                        <p>Service Management
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($userType == 3 || $userType == 4) { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('ticket/assign'); ?>" class="nav-link <?php echo((in_array($uri_segment, array('assign', 'conversation'))) ? $li_class : ''); ?>">
									<i class="fa fa-handshake-o nav-icon"></i>
                                    <p>Under Process</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="<?php echo base_url('ticket/completed'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'completed')) ? $li_class : ''); ?>">
                                    <i class="fa fa-check nav-icon"></i>
                                    <p>Completed</p>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('ticket/choose_category'); ?>" class="nav-link <?php echo((in_array($uri_segment, array('choose_category','create'))) ? $li_class : ''); ?>">
                                    <i class="fa fa-plus-circle nav-icon"></i>
                                    <p>Add New Service Request</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="<?php echo base_url('ticket/new_assign_list'); ?>" class="nav-link <?php echo((in_array($uri_segment, array('new_assign_list', 'edit'))) ? $li_class : ''); ?>">
                                    <i class="fa fa-ticket nav-icon"></i>
                                    <p>Service Request (s)</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('ticket/assign'); ?>" class="nav-link <?php echo((in_array($uri_segment, array('assign', 'conversation'))) ? $li_class : ''); ?>">
                                    <i class="fa fa-handshake-o nav-icon"></i>
                                    <p>Under Process</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('ticket/completed'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'completed')) ? $li_class : ''); ?>">
                                    <i class="fa fa-check nav-icon"></i>
                                    <p>Completed</p>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="<?php echo base_url('ticket/needhelp'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'needhelp')) ? $li_class : ''); ?>">
                                    <i class="fa fa-question-circle nav-icon"></i>
                                    <p>Need Help?</p>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
				<?php if ($userType == 3){ ?>
					<li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(1), array('agent')) ? $menu_open : ''); ?>">
						<a href="#" class="nav-link">
							<i class="nav-icon fa fa-users"></i>
							<p> Agent Management 
								<i class="fa fa-angle-left right"></i>
							</p>
						</a>
						<ul class="nav nav-treeview">
							<li class="nav-item">
								<a href="<?php echo base_url('/agent'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'agent' ? $li_class : ''); ?>">
									<i class="fa fa-user nav-icon"></i>
									<p>Agents</p>
								</a>
							</li>
						</ul>
					</li>
				<?php } ?>				
                <li class="nav-item has-treeview">
                    <a href="<?php echo base_url('ticket/feedback'); ?>" class="nav-link <?php echo($uri_segment == 'feedback' ? $li_class : ''); ?>">
                        <i class="fa fa-comments nav-icon"></i>
                        <p>Feedback & Rating</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo (in_array($this->uri->segment(1), array('profile', 'change-password')) ? $menu_open : ''); ?> ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-user-circle-o"></i>
                        <p>Profile Management
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="<?php echo base_url('profile'); ?>" class="nav-link <?php echo($uri_segment == 'profile' ? $li_class : ''); ?>">
                                <i class="fa fa-user-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo base_url('change-password'); ?>" class="nav-link <?php echo($uri_segment == 'change-password' ? $li_class : ''); ?>">
                                <i class="fa fa-key nav-icon"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('logout'); ?>"class = "nav-link">
                                <i class="fa fa-power-off nav-icon"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>