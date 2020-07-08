<?php 
$profilePic= fileExistsInLoacation()['target'];
$userType  = 'admin';
if(!empty($this->session->userdata('admins')) && (!empty($this->session->userdata('admins')['user_id']))){
    $userDetails = $this->user_model->getUserDetailsById($this->session->userdata('admins')['user_id'], 1);
    if(!empty($userDetails)){
        $profilePic = fileExistsInLoacation($userDetails->photo,'profile')['target'];
    }
    $userType = $this->session->userdata('admins')['user_type'];
    include 'top_header.php';
}

$segment1 = $this->uri->segment(1);
$segment2 = $this->uri->segment(2);
$segment3 = $this->uri->segment(3);

$uri_segment = '';
if ($segment2) {
    $uri_segment = $segment2;
} else if ($segment2 = segment3) {
    $uri_segment = $segment3;
} else {
    $uri_segment = $segment1;
}
$li_class = 'active';
$menu_open= 'menu-open';
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo base_url($this->session->userdata('admins')['user_type'].'/dashboard'); ?>" class="brand-link">
        <img src="<?php echo base_url() . 'uploads/settings/flogo.png'; ?>" alt="Filenotice Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <br />
        <span class="brand-text font-weight-light" style="display: none;"><?php echo _settingBykey('site_title');?></span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('dashboard')) ? $menu_open : ''); ?>">
                    <a href="<?php echo base_url($userType . '/dashboard'); ?>" class="nav-link <?php echo($uri_segment == 'dashboard' ? $li_class : ''); ?>">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('customer', 'consultant')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users" aria-hidden="true"></i>
                        <p>User Management <i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/customer/customer_list'); ?>" class="nav-link <?php echo($uri_segment == 'customer' ? $li_class : ''); ?>">
                                <i class="fa fa-user-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/consultant/consultant_list'); ?>" class="nav-link <?php echo($uri_segment == 'consultant' ? $li_class : ''); ?>">
                                <i class="fa fa-user nav-icon"></i>
                                <p>Consultant</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('ticket')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-ticket" aria-hidden="true"></i>
                        <p>Service Management<i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/ticket/ticket_list'); ?>" class="nav-link <?php echo((in_array(end($this->uri->segments), array('ticket_list', 'edit', 'create')) || ($segment2 == 'ticket' && $segment3 == 'edit')) ? $li_class : ''); ?>">
                                <i class="fa fa-ticket nav-icon"></i>
                                <p>New Request List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/ticket/assign_list'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'assign_list') || (in_array($segment3, array('assign', 'conversation')))) ? $li_class : ''); ?>">
								<i class="fa fa-handshake-o nav-icon"></i>
								<p>Under Process</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/ticket/completed_list'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'completed_list') || (in_array($segment3, array('completed_list')))) ? $li_class : ''); ?>">
                                <i class="fa fa-check nav-icon"></i>
                                <p>Completed</p>
                            </a>
                        </li>
						<li class="nav-item">
                            <a href="<?php echo base_url($userType . '/ticket/customer_request'); ?>" class="nav-link <?php echo(((end($this->uri->segments) == 'customer_request') || (in_array($segment3, array('customer_request')))) ? $li_class : ''); ?>">
                                <i class="fa fa-bullhorn nav-icon"></i>
                                <p>Customer Request</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php /*<li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('expertise')) ? $menu_open : ''); ?>">
                    <a href="<?php echo base_url($userType . '/expertise/expertise_list'); ?>" class="nav-link">
                        <i class="nav-icon fa fa-edit"></i>
                        <p>Expertise Management</p>
                    </a>
                </li>*/ ?>
                
<!--                <li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('report')) ? $menu_open : ''); ?>">
                    <a href="<?php echo base_url($userType . '/report/report_list'); ?>" class="nav-link">
                        <i class="nav-icon fa fa-file" aria-hidden="true"></i>
                        <p>Report</p>
                    </a>
                </li>-->
                <li class="nav-item has-treeview">
                    <a href="<?php echo base_url($userType . '/payment/paymentinfo_list'); ?>" class="nav-link">
                        <i class="nav-icon fa fa-money" aria-hidden="true"></i>
                        <p>Payment Information</p>
                    </a>
                </li>
                
                <li class="nav-item has-treeview">
                    <a href="<?php echo base_url($userType . '/rating/consultant_rating'); ?>" class="nav-link <?php echo($uri_segment == 'rating' ? $li_class : ''); ?>">
                        <i class="fa fa-star-o nav-icon"></i>
                        <p> Consultant Rating </p>
                    </a>
                </li>
				<li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('setting')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-sliders" aria-hidden="true"></i>
                        <p>Settings <i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/setting/general_setting'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'general_setting' ? $li_class : ''); ?>">
                                <i class="fa fa-cogs nav-icon"></i>
                                <p>System Configuration</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/setting/templates'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'templates' ? $li_class : ''); ?>">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>Template</p>
                            </a>
                        </li>-->
                    </ul>
                </li>
				<li class="nav-item has-treeview <?php echo (in_array($uri_segment, array('category', 'state')) ? $menu_open : ''); ?>">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-th-large" aria-hidden="true"></i>
                        <p>Masters Management <i class="fa fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/category/category_list'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'category_list' ? $li_class : ''); ?>">
                                <i class="fa fa-cube nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/category/subcategory_list'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'subcategory_list' ? $li_class : ''); ?>">
                                <i class="fa fa-cubes nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url($userType . '/state/state_list'); ?>" class="nav-link <?php echo(end($this->uri->segments) == 'state_list' ? $li_class : ''); ?>">
                                <i class="fa fa-map-marker nav-icon"></i>
                                <p>Locations</p>
                            </a>
                        </li>
						<li class="nav-item">
                            <a href="<?php echo base_url($userType . '/expertise/expertise_list'); ?>" class="nav-link">
								<i class="nav-icon fa fa-edit"></i>
								<p>Expertise Management</p>
							</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>