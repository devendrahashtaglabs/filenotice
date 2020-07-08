<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MX_Controller {

    function __construct() {
        parent::__construct();
        //parent::checkloggedinuser();
        $this->load->model('user_model');
        $last = end($this->uri->segments);
        $secondLastKey = count($this->uri->segment_array())-1;
        $beforelast = $this->uri->segment($secondLastKey);
        if ($last == 'login' || $last == 'forgot_password' || $beforelast == 'reset_password' || $last == 'reset_password') {
            if (!empty($this->session->userdata('admins')['user_type'])) {
                redirect('admin/dashboard');
            }
        } else {
			$loggedin = $this->session->userdata('admins');
			if(empty($loggedin)){
				$redirect_url = FRONTEND_URL . 'admin/login';
				redirect($redirect_url);
			}
        }
        $this->load->model('ticket_model');
        $this->load->library(array('form_validation'));
        $this->form_validation->run($this);
		ob_start();
    }
    
    public function _isValidUser() {
        $userEmail = $this->input->post('username');
        $responce = $this->user_model->_getUserByKeyValue('email', $this->input->post('username'), array('1'));
        if (empty($responce)) {
            $this->form_validation->set_message('_isValidUser', 'User id not exits.');
            return FALSE;
        } else if (!empty($responce) && $responce->status != '1') {
            $this->form_validation->set_message('_isValidUser', 'Account inactive, Please contact your Admin.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function validateEmail($email,$userId){
        $details = $this->user_model->validateEmail($email,$userId);
        if (!empty($details)) {
            $this->form_validation->set_message('validateEmail', 'Email already exists.');
            return FALSE;
        }
        return TRUE;
    }
    
    function userProflephoto() {
        if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
            $filename = $_FILES['user_photo']['name'];
            $file_extension= _getExtension($filename);
            $allowed_size  = 1000000;//109715; //5000000;//5mb-2Mb
            $allowed_extension = array('jpg', 'jpeg', 'JPG', 'JPEG', 'gif', 'GIF', 'png', 'PNG');
            if (!in_array($file_extension, $allowed_extension)) {
                $this->form_validation->set_message('userProflephoto', 'The filetype you are attempting to upload is not allowed.');
                return FALSE;
            }else if ($_FILES['user_photo']['size'] > $allowed_size) {
                $this->form_validation->set_message('userProflephoto', 'The file you are attempting to upload is larger than the permitted size.');
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            return TRUE;
        }
    }
    
    public function login() {
        $short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']= "Admin Login";
        $data['page_title']  = $data['site_title'] = "Admin Login";
        $data['pageUrl']     = $pageUrl = base_url('admin/login');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$usersession    = $this->session->userdata('users');
		if(empty($usersession)){
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				
				$this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email');
				$this->form_validation->set_rules('password', 'Password', 'trim|required');
				if ($this->form_validation->run()) {
					$responce = $this->user_model->_getUserByKeyValue('email', $this->input->post('username'), array());
					if (empty($responce)) {
						$full_msg = 'Email id not exits.';
						$redirect = $pageUrl;
					}else if (!empty($responce) && $responce->status != '1') {
						$full_msg = 'Account inactive, Please contact your Admin.';
						$redirect = $pageUrl;
					}else{
						$responce = $this->user_model->getUserLogin([
							'email'   => $this->input->post('username'),
							'password'=> md5($this->input->post('password')),
							'status'  => 1
						]);
						if (!empty($responce)) {
							$sesresponce = self::setDataIntoSession($responce);
							if ($sesresponce) {
								self::updateLogin($responce->id, array('login_status' => 1, 'current_login' => date('Y-m-d H:i:s')));
								$class_name	= SUCCESS_ALERT;
								$short_msg 	= 'Success';
								$full_msg  	= 'Successfully Login.';
								$redirect  = base_url($this->session->userdata('admins')['user_type']. '/dashboard');
							}else{
								$full_msg  = 'Somwthing went wrong.';
								$redirect  = $pageUrl;
							}
						} else {
							$full_msg = 'Invalid Credentials.';
							$redirect = $pageUrl;
						}
					}
					$this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
					redirect($redirect);
				}
			}
			_manage_template('templates/header', 'templates/footer', 'templates/login', $data);
		}else{            
            $this->session->unset_userdata('users');
            redirect(FRONTEND_URL);
		}
    }
    
    public function updateLogin($userId, $data) {
        $responce = $this->user_model->updateRecordsById('id', $userId, $data);
        return $responce;
    }
    
    public function setDataIntoSession($responce) {
        $return = false;
        $userData= $this->user_model->getUserDetailsById($responce->id,$responce->user_type);
        $roleType= $this->user_model->getDataBykey('nw_role_tbl', 'id', $responce->user_type, 'role_name')->role_name;
        $this->session->set_userdata('admins',array(
                'user_id'     => $responce->id,
                'user_type'   => 'admin',//$roleType
                'user_email'  => $responce->email,
                'user_name'   => $userData->name,
                'user_status' => $responce->status,
                'is_logged_in'=> true
            )
        );
        if (!empty($this->session->userdata('admins'))) {
            $return = true;
        }
        return $return;
    }
    
    public function dashboard() {
        if(in_array('admins',$this->session->userdata)){
            redirect(base_url('admin/login'));
        }
        $adminsession = $this->session->userdata('admins');
        if($adminsession != TRUE || empty($adminsession)){
            redirect(base_url().'admin/login');
        }
		
        $completed_status = array(90,91);
        $total_completed_ticket = count($this->ticket_model->getCompletedTicket($completed_status)['data']);
        $data['section_name']   = "Dashboard Management";
        $data['page_title']     = $data['site_title'] = "Dashboard";
		$username				= ''; 
		if($adminsession['user_type'] == 'admin'){
			$username 	= isset($adminsession['user_name'])?ucfirst($adminsession['user_name']):'Admin';
		}
		$data['welcome_title']  = "Welcome " .$username ;
        $data['pageUrl']        = $pageUrl = base_url($this->session->userdata('admins')['user_type']. '/dashboard');
        $data['breadcrumb']     = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $data['customersList']  = $this->user_model->getCountOfUser('2','1');
        $data['consultList']    = $this->user_model->getCountOfUser('3','1');
        //$data['ticketList']     = $this->ticket_model->getActiveTicketListAdmin($completed_status,'1','','','','id'); // parameter (ticket_status == 1) active
        $data['ticketList']     = $this->ticket_model->getAllTicketList('1','','','','id'); // parameter (ticket_status == 1) active
        $data['completeTicket'] = $total_completed_ticket;
		$ignore_status 			= array(10,90,91);
		$assignedticket  		= $this->ticket_model->getAssignTicket($ignore_status);
		if(!empty($assignedticket)){
			$data['assignedTicket'] = count($assignedticket);
		}else{
			$data['assignedTicket'] = 0;
		}
        
        
        $data['fiveCustomers']  = __dashboardtablehtml($this->user_model->getUserList('2', '', '', '5', 'users.id'));
        $data['fiveConsultant'] = __dashboardtablehtml($this->user_model->getUserList('3', '', '', '5', 'users.id'));
        $data['fiveTicket']     = __dashboardtablehtml($this->ticket_model->getTicketList('1', '', '', '5', 'tickets.id'), 'tickets');
        _manage_template('templates/header', 'templates/footer', 'dashboard', $data, 'templates/left_adminMenu');
    }

    public function logout() {
        $user_type = $this->session->userdata('admins')['user_type'];
        self::updateLogin($this->session->userdata('admins')['user_id'], array('login_status' => 0, 'last_login' => date('Y-m-d H:i:s')));
        $this->session->set_userdata('admins', array(
                'user_id'     => '',
                'user_type'   => '',
                'user_email'  => '',
                'user_name'   => '',
                'user_status' => '',
                'is_logged_in'=> false
            )
        );
		$this->session->unset_userdata('admins');
		$this->session->sess_destroy();
		$this->load->driver('cache');
		$this->cache->clean();
		ob_clean();
		//$this->session->sess_destroy('admins');
        $this->session->set_flashdata('responce_msg', array('class'=>SUCCESS_ALERT,'short_msg'=>'Success','message'=>'Successfully Logout.'));
		$redirect_url = FRONTEND_URL . 'admin/login';
        redirect($redirect_url);
    }
    
    public function stateList() {
        if ($this->input->is_ajax_request() == true) {
            $status = false;
            $style_color = 'red';
            $redirectURL = "";
            $data = "";
            $responce = $this->user_model->getStateList('',$this->input->post('countryId'));
            if (!empty($responce)) {
                $status= true;
                $data  = $responce;
                $mesage= 'Record Available.';
                $style_color= 'green';
            } else {
                $mesage = 'No record available for seleted country.';
            }
            $ajaxResponse=json_encode(array('data'=>$data,'status'=>$status,"massege"=>$mesage,'style_color'=>$style_color,'redirectURL'=>$redirectURL));
            echo $ajaxResponse;
        }
    }
    
    public function profile() {
        if(in_array('admins',$this->session->userdata)){
            redirect(base_url('admin/login'));
        }
        $data['section_name']= "Update Profile";
        $data['page_title']  = $data['site_title'] = "Update Profile";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('admins')['user_type'].'/profile');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="'.base_url($this->session->userdata('admins')['user_type'].'/dashboard').'">Dashboard</a></li><li class="breadcrumb-item"><a href="'.$pageUrl .'">'.$data['page_title'].'</a></li></ol>'; 
        $userid = $this->session->userdata('admins')['user_id'];
        $data['coustomer']   = $customerData = $this->user_model->getAdmin($userid);
        $data['countryList'] = $this->user_model->getCountryList();
        if($this->input->server('REQUEST_METHOD')==="POST"){
            $this->form_validation->set_rules('user_name', 'Name', 'trim|required|min_length[2]');
            //$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_validateEmail['.$userid.']');
            $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|exact_length[10]|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required|callback_validateAge');
            $this->form_validation->set_rules('user_country', 'Country', 'trim|required');
            $this->form_validation->set_rules('user_state', 'State', 'trim|required');
            $this->form_validation->set_rules('user_city', 'City', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|exact_length[6]|numeric');
            $this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
            if ($this->form_validation->run()) {
                $countrydata	= $this->user_model->getCountryList($this->input->post('user_country'));
                $countryName	= ($countrydata !='') ? $countrydata->name:'';
                $stateList  	= $this->user_model->getStateList($this->input->post('user_state'));
                $stateName  	= ($stateList !='') ? $stateList->name:'';
                $cityName   	= $this->input->post('customer_city');
                $getGeoData 	= _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
				$user_name		= $this->input->post('user_name');
				$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
				$lowercaseTitle = strtolower($new_string);
				$ucTitleString 	= ucwords($lowercaseTitle);
				
                $updateArr = array(
                    'id'        => $userid,
                    'name'      => $ucTitleString,
                    'mobile'    => $this->input->post('user_mobile'),
                    'dob'       => date('Y-m-d', strtotime($this->input->post('user_dob'))),
                    'country_id'=> $this->input->post('user_country'),
                    'state_id'  => $this->input->post('user_state'),
                    'city_id'   => $this->input->post('user_city'),
                    'zip'       => $this->input->post('pin_code'),
                    'gender'    => $this->input->post('user_gender'),
                    'latitude'  => ($getGeoData !='') ? $getGeoData['lat']:'',
                    'longitude' => ($getGeoData !='') ? $getGeoData['long']:'',
                    'modified'  => date('Y-m-d H:i:s')
                );
               
                if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
                    $filename   = $_FILES['user_photo']['name'];
                    $tmp_path   = $_FILES['user_photo']['tmp_name'];
                    $image_name = uploadImage($filename, $tmp_path, 'profile', '140');
                    $updateArr['photo'] = $image_name;
                    unlinkImage('uploads/profile/',$customerData->photo);
                }
                $this->user_model->updateAdmin($updateArr);
				if(empty($this->input->post('user_email'))){
					$adminData  = $this->user_model->_getUserByKeyValue('id', $userid,'1');
					if(!empty($adminData)){
						$user_email = isset($adminData->email)?$adminData->email:'';
					}
				}else{
					$user_email = $this->input->post('user_email');
				}
                $responce = $this->user_model->updateUser([
                    'user_id'   => $userid,
                    'email'     => $user_email,
                    'modified'  => date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Profile has been updated successfully.'));
                redirect($pageUrl);
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile', $data, 'templates/left_adminMenu');
    }
    
    public function oldpassword_check($old_password){
        $old_password_hash = md5($old_password);
        $passwordDb = $this->user_model->getDataBykey('nw_user_tbl','id',$this->session->userdata('admins')['user_id'],'password');
        if(empty($passwordDb) || $old_password_hash != $passwordDb->password){
           $this->form_validation->set_message('oldpassword_check', 'Old password not match');
           return FALSE;
        }
        return TRUE;
    }
    
    public function change_password() {
        $data['section_name'] = "Update Password";
        $data['page_title'] = $data['site_title'] = "Update Password";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('admins')['user_type'].'/change-password');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="'.base_url($this->session->userdata('admins')['user_type'].'/dashboard').'">Dashboard</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|callback_oldpassword_check');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[30]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            if ($this->form_validation->run()) {
                
                $responce = $this->user_model->updateRecordsById('id', $this->session->userdata('admins')['user_id'], array('password' => md5($this->input->post('new_password'))));
                if(!empty($responce)){
                   
                    $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Password has been updated successfully.'));
                }else{
                    $this->session->set_flashdata('responce_msg',array('class'=>INFO_ALERT,'short_msg' =>'Worning','message'=>'Something Went Wrong.'));
                    $this->session->set_flashdata('flash_msg', '');
                }
                redirect($pageUrl);
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/change-password', $data, 'templates/left_adminMenu');
    }
    
     public function forgot_password() {
        //$short_msg = 'Failed3';
        $class_name= INFO_ALERT;
        $data['section_name']= "Forgot Password";
        $data['page_title']  = $data['site_title'] = "Forgot Password";
        $data['pageUrl']     = $pageUrl = base_url('admin/forgot_password');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
                $responce = $this->user_model->_getUserByKeyValue('email', $this->input->post('username'), array());
                if (empty($responce)) {
                    $full_msg = 'Failed! Email id not exits.';
                    $redirect = $pageUrl;
                }else if (!empty($responce) && $responce->status != '1') {
                    $full_msg = 'Account inactive, Please contact your Admin.';
                    $redirect = $pageUrl;
                }else{
                    $activation_hash = md5(uniqid(mt_rand(), true));
                    $data = array(
                        'email' => $this->input->post('username'),
                        'token' => $activation_hash
                    );
                    $responce   = $this->user_model->add_token($data);
                    $link       = base_url()."admin/reset_password/".$activation_hash;
                                
                    if(!empty($responce)) {        
                        $this->load->library('email');
                        $this->email->set_mailtype("html");
                        $this->email->from('coffee@hashtaglabs.biz');
                        $this->email->to($this->input->post('username'));
                        //$this->email->cc('another@another-example.com');
                        //$this->email->bcc('them@their-example.com');
                        $this->email->subject('FileNotice - Forgot Password');
                        $this->email->message('Hi<br><br>Please click the link to change password..<br><br>
                            '.$link.'
                            <br><br><br>Thanks');
                        $this->email->send();
                        
                        $full_msg = 'Please check your email to reset password.';
                        $redirect = base_url().'admin/login';
                    }
                }
                $this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
                redirect($redirect);
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/forgot_password', $data);
    }
    
    public function reset_password() {
        $token = $this->uri->segment(4);
        $short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name'] = "Reset Password";
        $data['page_title'] = $data['site_title'] = "Reset Password";
        $data['pageUrl'] = $pageUrl = base_url('admin/reset_password');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '/'.$token.'">' . $data['page_title'] . '</a></li></ol>';
        
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[30]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            if ($this->form_validation->run()) {
                $token = $this->input->post('token');
               $responce = $this->user_model->get_token($token);
                if (empty($responce)) {
                    $full_msg = 'Link expired! Please try again.';
                    $redirect = base_url('admin/login');
                }else if (!empty($responce) && $responce->status == '1') {
                    $full_msg = 'Link expired! Please try again.';
                    $redirect = base_url('admin/login');
                }else{
                    $email = $responce->email;
            $data = array(
                'password' => md5($this->input->post('new_password')),
                                );
                        $this->user_model->update_token($token);
                        $result = $this->user_model->update_admin_password($data, $email);
                    if(!empty($result)) {
                        $short_msg = 'Success';
                        $full_msg = 'Password reset successful';
                        $redirect = base_url('admin/login');
                    }
                }
                $this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
                redirect($redirect);
            }
        }
       _manage_template('templates/header', 'templates/footer', 'templates/reset_password', $data);
    }

	public function getCityListdata(){
		$stateId = $this->input->post('stateId');
		$allcitybystateid = $this->user_model->getCityList('',$stateId);
		$html = '';
		if(isset($allcitybystateid)){
            foreach($allcitybystateid as $res){
                $html .= '<option value="'. $res->city_id .'">'. $res->city_name .'</option>'; 
            }
        }else{
            $html .= '<option value=" ">No City Mapped.</option>'; 
        }
        print_r($html);
	}
}
