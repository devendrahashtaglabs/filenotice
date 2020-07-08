<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class usersController extends MX_Controller {

    function __construct() {
		
        parent::__construct();
		$this->load->library('session');
        $last = end($this->uri->segments);
		if(!is_numeric($last)) {
			if ($last != 'login'){
				$loggedin = $this->session->userdata('users');
				if(empty($loggedin)){
					$redirect_url = FRONTEND_URL . 'login';
					redirect($redirect_url);
				}
			}
		}
        $this->load->model('user_model');
        $this->load->model('ticket_model');
    }

	public function index(){
	}
	
	
	public function updateLogin($userId, $data) {
        $responce = $this->user_model->updateRecordsById('id', $userId, $data);
        return $responce;
    }
    public function dashboard() {
        $usersession    = $this->session->userdata('users');		
        /* $frontend_url   = FRONTEND_URL; 
        if(empty($usersession)){
            redirect($frontend_url); 
        }  */
        $data['section_name']	= "Dashboard Management";
		$user_id				= $usersession['user_id'];
		if($usersession['user_type'] == 'consultant'){
			$consultantdata = $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$user_id);
			$username 		= isset($consultantdata)?ucfirst($consultantdata->name):'Consultant';
		}else{
			$customerdata 	= $this->user_model->getDataBykey('nw_customer_tbl','user_id',$user_id);
			$username 		= isset($customerdata)?ucfirst($customerdata->name):'Customer';			
		}
        $data['page_title']  	= $data['site_title'] = "Dashboard";
        $data['welcome_title']  = "Welcome " .$username ;
        $data['pageUrl']     	= $pageUrl = base_url('dashboard');
        //$sessionData        	= $this->session->userdata('users');
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if($usersession['user_type'] == 'consultant'){
			$ignore_status_code 	 = array(90,91);
            $data['totalTickets']    = $this->ticket_model->getConsultantTicketListCount($this->session->userdata('users')['user_id'],'','',$ignore_status_code,'','1','');
            //$data['newTickets']      = $this->ticket_model->getConsultantTicketListCount($this->session->userdata('users')['user_id'],'','','','1','1','new');
            $userData      			 = $this->user_model->getUserDetailsById($this->session->userdata('users')['user_id'],$this->session->userdata('users')['user_type']);
			$date					 = date_create($userData->last_login);
			$last_login				 = " '".date_format($date,"Y-m-d H:i:s")."'";
            $data['newTickets']      = $this->ticket_model->getnewticketdata($this->session->userdata('users')['user_id'],$last_login);
			$completed_status 		 = array(90,91);
            $data['completedTickets']= $this->ticket_model->getCompletedTicket($this->session->userdata('users')['user_id'],$completed_status,$this->session->userdata('users')['user_type']);
			//$data['assignTickets']   = $this->ticket_model->getassignticketsconsultant($this->session->userdata('users')['user_id']);
			$ignore_status_code 	 = array(90,91);
			$data['assignTickets']   = $this->ticket_model->getAssignTicket($this->session->userdata('users')['user_id'],$ignore_status_code,$this->session->userdata('users')['user_type']);
        }else{
            $data['totalTickets']    = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'],'','','','','1','');
            $data['newTickets']      = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'],'','','','10','1','new');
			$completed_status 		 = array(90,91);
            $data['completedTickets']= $this->ticket_model->getCompletedTicket($this->session->userdata('users')['user_id'],$completed_status,$this->session->userdata('users')['user_type']);
			$ignore_status_code 	 = array(90,91);
			$data['assignTickets']   = $this->ticket_model->getAssignTicket($this->session->userdata('users')['user_id'],$ignore_status_code,$this->session->userdata('users')['user_type']);
        }
       _manage_template('templates/header', 'templates/footer', 'templates/dashboard', $data, 'templates/left_adminMenu');
    }

    public function logout() {		
        self::updateLogin($this->session->userdata('users')['user_id'], array('login_status' => 0, 'last_login' => date('Y-m-d H:i:s')));
        $this->session->set_userdata('users', array(
                'user_id'     => '',
                'user_type'   => '',
                'user_email'  => '',
                'user_name'   => '',
                'user_status' => '',
                'is_logged_in'=> false
            )
        );
        $this->session->sess_destroy('users');
        $this->session->sess_destroy();
        $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'Success', 'message' => 'Successfully Logout.'));	
		$redirect_url = FRONTEND_URL . 'login';
        redirect($redirect_url); 
    }
    
    /* function validateSession(){
        if(empty($this->session->userdata('users')) || empty($this->session->userdata('users')['user_id']) || empty($this->session->userdata('users')['is_logged_in'])){
            redirect(base_url('login'));
        }
        return true;
    } */
	
	/* function wp_login($userid) {
		$responce = $this->user_model->getUserLogin([
                            'id'   => $userid
							]);
		$sesresponce = self::setDataIntoSession($responce);
		if ($sesresponce) {
			self::updateLogin($responce->id, array('login_status' => 1, 'current_login' => date('Y-m-d H:i:s')));
			$class_name= SUCCESS_ALERT;
			$short_msg = 'Success';
			$full_msg  = 'Successfully Login.';
			$redirect  = base_url('dashboard');
		}
		redirect($redirect);
                        
	} */
	

}
