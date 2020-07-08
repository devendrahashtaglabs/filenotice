<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
	<?php 
		$usersession = $this->session->userdata('agents');
		$user_id 	 = $usersession['user_id'];
	?>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
        </li>
    </ul>
	<?php 
		$urlarray = $this->uri->segments;
		if(!in_array('dashboard',$urlarray)){
			$agentdata = $this->user_model->getDataBykey('nw_agent_tbl','user_id',$user_id);
	?>
	<ul class="list-unstyled text-center">
		<?php 
			$user_name 		= $agentdata->name;
			$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
			$lowercaseTitle = strtolower($new_string); 
			$ucTitleString 	= ucwords($lowercaseTitle);
		?>
		<li><b><?php echo isset($usersession)? ucfirst($usersession['user_type']).' Name' :'Agent Name';?></b> : <?php echo isset($ucTitleString)? $ucTitleString :'';?></li>
	</ul>
	<?php } ?>
    <ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" style="padding-top: 0px;">
                <div class="user-panel d-flex">
                    <div class="image displaypicture notification-icon">
						<i class="fa fa-envelope" aria-hidden="true"></i>
						<?php
							$user_id 	 		= $usersession['user_id'];
							$allnotification   	= $this->ticket_model->getallnewnotification($user_id);
							//echo isset($allnotification['count'])?$allnotification['count']:''; 
						?>
						<span id="countchat" ><?php echo isset($allnotification['count'])?$allnotification['count']:'0'; ?></span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notification_list">
				<?php 
					if(!empty($allnotification['data'])){
						foreach($allnotification['data'] as $notification){
							$ticketurl = base_url() . "ticket/conversation/" .$notification->ticket_id;
							$chat_massege = isset($notification->chat_massege)?$notification->chat_massege:"";
				?>
					<div class="dropdown-divider"></div>
					<a href="<?php echo isset($ticketurl)?$ticketurl:''; ?>" class="dropdown-item">
						<i class="fa fa-envelope mr-2"></i> <?php echo $chat_massege; ?>
					</a>
				<?php } }else{?>
					<div class="dropdown-divider"></div><p>No Record Available</p>
				<?php } ?>
            </div>
        </li>
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
                        <a href="<?php echo base_url('agent/profile'); ?>" class="d-block"><?php echo $userDetails->name; ?></a>
                    </div>
                </span>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('agent/profile'); ?>" class="dropdown-item">
                    <i class="fa fa-envelope mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('agent/change-password'); ?>" class="dropdown-item">
                    <i class="fa fa-user mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('agent/logout'); ?>" class="dropdown-item">
                    <i class="fa fa-sign-out mr-2"></i> Logout
                </a>
            </div>
        </li>
<?php /*<li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('logout'); ?>" title="Logout">
                <i class="fa fa-sign-out mr-2"></i>
            </a>
        </li>*/ ?>
    </ul>
</nav>

