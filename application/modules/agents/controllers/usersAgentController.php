<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class usersAgentController extends MX_Controller {

    function __construct() {
		
        parent::__construct();
        $last = end($this->uri->segments);
        if ($last != 'login') {
            $loggedin = $this->session->userdata('agents');
			if(empty($loggedin)){
				$redirect_url = FRONTEND_URL . 'login';
				redirect($redirect_url);
			}
        } 
        $this->load->model('user_model');
        $this->load->model('ticket_model');
    }

	public function index(){
	}
	
   /*public function login() {
        $short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']= "User Login";
        $data['page_title']  = $data['site_title'] = "User Login";
        $data['pageUrl']     = $pageUrl = base_url('/login');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run()) {
                if(!empty($this->input->post('username')) && !empty($this->input->post('password'))){
                    $responce = $this->user_model->_getUserByKeyValue('email', $this->input->post('username'), array('2', '3'));
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
                                $class_name= SUCCESS_ALERT;
                                $short_msg = 'Success';
                                $full_msg  = 'Successfully Login.';
                                $redirect  = base_url('dashboard');
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
        }
        _manage_template('templates/header', 'templates/footer', 'templates/login', $data);
    } */

    public function updateLogin($userId, $data) {
        $responce = $this->user_model->updateRecordsById('id', $userId, $data);
        return $responce;
    }

    public function setDataIntoSession($responce) {
        $return = false;
        $userData= $this->user_model->getUserDetailsById($responce->id,$responce->user_type);
        $roleType= $this->user_model->getDataBykey('nw_role_tbl', 'id', $responce->user_type, 'role_name')->role_name;
        $this->session->set_userdata('agents',array(
                'user_id'     => $responce->id,
                'user_type'   => $roleType,
                'user_email'  => $responce->email,
                'user_name'   => $userData->name,
                'user_status' => $responce->status,
                'is_logged_in'=> true
            )
        );
        if (!empty($this->session->userdata('agents'))) {
            $return = true;
        }
        return $return;
    }
    public function dashboard() {
        //$this->validateSession();
        $usersession    = $this->session->userdata('agents');
        $user_id    	= $usersession['user_id'];
        $frontend_url   = FRONTEND_URL;		
        if(empty($usersession)){
            redirect($frontend_url); 
        } 
        $data['section_name']	= "Dashboard Management";
		$username				= '';
		if($usersession['user_type'] == 'agent'){
			$agentdata = $this->user_model->getDataBykey('nw_agent_tbl','user_id',$user_id);
			$username 	= isset($agentdata)?ucfirst($agentdata->name):'Agent';
		}
		
        $data['page_title']  	= $data['site_title'] 		= "Dashboard";
        $data['welcome_title']  = "Welcome " .$username ;
        $data['pageUrl']     	= $pageUrl = base_url('agent/dashboard');
        $sessionData        	= $this->session->userdata('agents');
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $ignore_status_code 	 = array(90,91);
		$data['totalTickets']    = $this->ticket_model->getConsultantTicketListCount($this->session->userdata('agents')['user_id'],'','','',$ignore_status_code,'1','');			
		$userData      			 = $this->user_model->getUserDetailsById($this->session->userdata('agents')['user_id'],$this->session->userdata('agents')['user_type']);
		$date					 = date_create($userData->last_login);
		$last_login				 = " '".date_format($date,"Y-m-d H:i:s")."'";
		$completed_status 		 = array(90,91);
		$data['completedTickets']= $this->ticket_model->getCompletedTicket($this->session->userdata('agents')['user_id'],$completed_status,$this->session->userdata('agents')['user_type']);
		//$data['assignTickets']   = $this->ticket_model->getassignticketsconsultant($this->session->userdata('users')['user_id']);
		$data['assignTickets']   = $this->ticket_model->getAssignTicket($this->session->userdata('agents')['user_id'],$ignore_status_code,$this->session->userdata('agents')['user_type']);
       _manage_template('templates/header', 'templates/footer', 'templates/dashboard', $data, 'templates/left_adminMenu');
    }

    public function logout() {		
		//print_r('hello');
		//$url = explode('/',base_url());
		//array_pop($url);
		//echo implode('/', $url); 
		
		$wp_url 		= dirname(base_url()).PHP_EOL;
		$wp_file_url 	= trim($wp_url);
		//echo $wp_file_url;
		//exit;
		
        self::updateLogin($this->session->userdata('agents')['user_id'], array('login_status' => 0, 'last_login' => date('Y-m-d H:i:s')));
        $this->session->set_userdata('agents', array(
                'user_id'     => '',
                'user_type'   => '',
                'user_email'  => '',
                'user_name'   => '',
                'user_status' => '',
                'is_logged_in'=> false
            )
        );
        $this->session->sess_destroy('agents');
        $this->session->sess_destroy();
        $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'Success', 'message' => 'Successfully Logout.'));	
		$redirect_url = FRONTEND_URL . 'login';
        redirect($redirect_url);
    }
    
    function validateSession(){
        if(empty($this->session->userdata('agents')) || empty($this->session->userdata('agents')['user_id']) || empty($this->session->userdata('agents')['is_logged_in'])){
            redirect(base_url('login'));
        }
        return true;
    }
	
	function wp_login($userid) {
		$responce = $this->user_model->getUserLogin([
                            'id'   => $userid
							]);
		$sesresponce = self::setDataIntoSession($responce);
		if ($sesresponce) {
			self::updateLogin($responce->id, array('login_status' => 1, 'current_login' => date('Y-m-d H:i:s')));
			$class_name= SUCCESS_ALERT;
			$short_msg = 'Success';
			$full_msg  = 'Successfully Login.';
			$redirect  = base_url('agent/dashboard');
		}
		redirect($redirect);                        
	}

}
