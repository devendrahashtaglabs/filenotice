<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agentController extends MX_Controller {

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
        $this->load->model('category_model');
        $this->load->model('expertise_model');
        $this->load->library(array('form_validation'));
        $this->form_validation->run($this);
    }
    
    function _alpha_dash_space($str_in = ''){
		if($str_in != '') {   
			if (! preg_match("/^([a-z ])+$/i", $str_in))
			{
				$this->form_validation->set_message('_alpha_dash_space', 'The %s field may only contain alphabets and spaces.');
				return FALSE;
			}else{
				return TRUE;
			}
		} else {
			return TRUE;
		}
	}
    
    function userProflephoto() {
        if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
            $filename = $_FILES['user_photo']['name'];
            $file_extension= _getExtension($filename);
            $allowed_size  = 109715; //5000000;//5mb-2Mb
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

    public function tickets() {
        $data['section_name'] 	= "Ticket Management";
        $data['page_title'] 	= $data['site_title'] = "Ticket List";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '/list">' . $data['page_title'] . '</a></li></ol>';
        //$data['tickets'] 		= $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','','1','');
        $data['tickets'] 		= $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'],'','','','10','1','new');
        _manage_template('templates/header', 'templates/footer', 'ticket/ticket_list', $data, 'templates/left_adminMenu');
    }

	public function image_upload(){
    
		if($_FILES['userfile']['size'] != 0){
			$upload_dir = './uploads/ticket/';
			if (!is_dir($upload_dir)) {
				 mkdir($upload_dir);
			}   
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = "gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx";
					$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;
					$new_name = time().$_FILES["userfile"]['name'];
					$config['file_name']     = $new_name;
			$config['overwrite']     = false;

			$this->load->library('upload', $config);
					$this->upload->initialize($config);
				 
			if (!$this->upload->do_upload('userfile')){

				$this->form_validation->set_message('image_upload', $this->upload->display_errors());
				return false;
			}   
			else{
				$this->upload_data['file'] =  $this->upload->data();
				return true;
			}   
		}   
		else{
			//$this->form_validation->set_message('image_upload', "No file selected");
			return true;
		}
    }
    public function create_ticket() {
        // $this->load->helper(array('form', 'url'));
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Create Ticket";
        $data['pageUrl'] = $pageUrl = base_url('ticket');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/create">' . $data['page_title'] . '</a></li></ol>';
        $data['categories'] = $this->category_model->getParentCategory();
        $data['countryList']= $this->user_model->getCountryList();
        $data['stateList']= $this->user_model->getStateList('','88');
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
           //$this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[10]');
           // $this->form_validation->set_rules('image[]', 'Document', 'trim|required');
            $this->form_validation->set_rules('customer_country', 'Country', 'trim|required');
            $this->form_validation->set_rules('customer_state', 'State', 'trim|required');
            $this->form_validation->set_rules('customer_city', 'City', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('customer_address', 'Address', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('customer_pincode', 'Pincode', 'trim|required|max_length[6]');
            if ($this->form_validation->run()) {
				$str 	= $this->input->post('categorytext');
				$len	= 3;
				$ticketname = substr(str_replace(" ", "", $str), 0, $len).'-'.date('Ymdh24is');//edited at 02012020
				$newticketname = strtoupper($ticketname);
				$path1= "./uploads/ticket/".$_FILES['image']['name'][0];
				$extension = substr(strrchr($path1, '.'), 1);
				$imagename = $_FILES['image']['name'][0];

				if($imagename!=''){
				   if (($extension!= "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp") && ($extension != "pdf") && ($extension != "doc") && ($extension != "docx") && ($extension != "xls") && ($extension != "xlsx") && ($_FILES["file"]["size"] < 1000000)) 
					{
					 $this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WARNING','message'=>'File not supported!'));
					 redirect($pageUrl . '/create');
					}else{
						$prod = date("Ymdhis");
						$path1= "./uploads/ticket/".$prod."".$_FILES['image']['name'][0];
						copy($_FILES['image']['tmp_name'][0], $path1);
						$img = $_FILES['image']['name'][0];
						$filename=$prod ."".$img;
						// echo "$filename";
						// exit;
					} 
				}else{
					 $filename = '';
				}
				$responce = $this->ticket_model->createTicket([
					'ticket_id'     	=> $newticketname,
					'customer_id'   	=> $this->session->userdata('users')['user_id'],
					'description'   	=> $this->input->post('description'),
					'file'          	=> $filename,
					'start_date'    	=> date('Y-m-d'),
					'category_id'   	=> $this->input->post('category_id'),
					'ticket_status' 	=> '10',
					'status'        	=> '1',
					'customer_country'  => $this->input->post('customer_country'),
					'customer_state'    => $this->input->post('customer_state'),
					'customer_city'     => $this->input->post('customer_city'),
					'customer_pincode'  => $this->input->post('customer_pincode'),
					'customer_address'  => $this->input->post('customer_address'),
					'created'       	=> date('Y-m-d H:i:s'),
				]);
                if ($responce) {
                    $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been created successfully.'));
                    redirect($pageUrl . '/list');
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'ticket/create', $data, 'templates/left_adminMenu');
    }

    public function view_ticket() {
        $id = $this->uri->segment(4);
        $data['section_name']= "Ticket Management";
        $data['page_title']  = $data['site_title'] = "View Ticket";
        $data['pageUrl']     = $pageUrl = base_url('agent/ticket/assign');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item">'
                . '<a href="' . $pageUrl . '/view/' . $id . '">' . $data['page_title'] . '</a></li></ol>';
        $data['ticket'] = $this->ticket_model->getTicketById($id);
        $data['ticketlogdata'] = $this->ticket_model->getthedata('ticket_id',$id,'nw_ticketstatusremarklog_tbl');
		if(!empty($data['ticket'])){
			_manage_template('templates/header', 'templates/footer', 'ticket/view_details', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			if($this->session->userdata('agents')['user_type'] == 'agent'){
				redirect(base_url() . 'agent/ticket/assign');
			}
		}
    }
    public function edit_ticket() {
        $id = $this->uri->segment(3);
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Edit Ticket";
        $data['pageUrl'] = $pageUrl = base_url('ticket');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item">'
                . '<a href="' . $pageUrl . '/edit/' . $id . '">' . $data['page_title'] . '</a></li></ol>';
        $data['categories'] = $this->category_model->getParentCategory();
        $data['ticket'] = $this->ticket_model->getTicketById($id);
		$data['countryList']= $this->user_model->getCountryList();
        $data['stateList']= $this->user_model->getStateList('','88');
		if(!empty($data['ticket'])){
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
				$this->form_validation->set_rules('status', 'Status', 'trim|required');
				$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[10]');
				// $this->form_validation->set_rules('ticket_status', 'ticket status', 'trim|required');
				// $this->form_validation->set_rules('payment_status', 'Payment status', 'trim|required');
				// $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
				// $this->form_validation->set_rules('close_date', 'Cloase Date', 'trim|required|callback_validateDate');
				$this->form_validation->set_rules('customer_country', 'Country', 'trim|required');
				$this->form_validation->set_rules('customer_state', 'State', 'trim|required');
				$this->form_validation->set_rules('customer_city', 'City', 'trim|required|max_length[100]');
				$this->form_validation->set_rules('customer_address', 'Address', 'trim|required|max_length[200]');
				$this->form_validation->set_rules('customer_pincode', 'Pincode', 'trim|required|max_length[6]');
				if ($this->form_validation->run()) {
					$newimg = $_FILES['image']['name'][0];

					if($newimg != ""){
						$path1= "./uploads/ticket/".$_FILES['image']['name'][0];
						$extension = substr(strrchr($path1, '.'), 1);


						 if (($extension!= "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp") && ($extension != "pdf") && ($extension != "doc") && ($extension != "docx") && ($extension != "xls") && ($extension != "xlsx") && ($_FILES["file"]["size"] < 1000000)) 
						{
						 $this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WARNING','message'=>'File not supported!'));
						 redirect($pageUrl . '/edit/'.$id);
						} else {

						$prod = date("Ymdhis");
						$path1= "./uploads/ticket/".$prod."".$_FILES['image']['name'][0];
						copy($_FILES['image']['tmp_name'][0], $path1);
						$img = $_FILES['image']['name'][0];
						$filename=$prod ."".$img;
						// echo "$filename";
						// exit;
						}
					}else{
						$filename = "";
					}
					if($filename == ""){
						$data = array(
							'description' 		=> $this->input->post('description'),
							'category_id' 		=> $this->input->post('category_id'),
							'status' 			=> $this->input->post('status'),                    
							'customer_country' 	=> $this->input->post('customer_country'),
							'customer_state' 	=> $this->input->post('customer_state'),
							'customer_city' 	=> $this->input->post('customer_city'),
							'customer_address' 	=> $this->input->post('customer_address'),
							'customer_pincode' 	=> $this->input->post('customer_pincode'),                    
						);
						
					}else{
						$data = array(
							'description' 		=> $this->input->post('description'),
							'category_id' 		=> $this->input->post('category_id'),
							'status' 			=> $this->input->post('status'),
							'customer_country' 	=> $this->input->post('customer_country'),
							'customer_state' 	=> $this->input->post('customer_state'),
							'customer_city' 	=> $this->input->post('customer_city'),
							'customer_address' 	=> $this->input->post('customer_address'),                    
							'customer_pincode' 	=> $this->input->post('customer_pincode'),
							'file'          	=> $filename,
						);
					}     
					$responce = $this->ticket_model->updateTicket($data, $id);
					if ($responce) {
						$this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been updated successfully.'));
						redirect($pageUrl . '/new_assign_list');
					}
				}
			}
			_manage_template('templates/header', 'templates/footer', 'ticket/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			if($this->session->userdata('users')['user_type'] == 'consultant'){
				redirect(base_url() . 'ticket/assign');
			}else{
				redirect(base_url() . 'ticket/new_assign_list');
			}
		}
    }
    public function updateTicketRecords() {
        $ticketid = $this->input->post('uid');
        $status = $this->input->post('status');
        $action = $this->input->post('action');
        if ($action == 'delete') {
            $return = $this->ticket_model->delete($ticketid);
            $status = true;
            $message = 'Record has been Successfully deleted.';
            $style_color = 'green';
            $redirectURL = base_url('ticket/list');
        } else {
            $return = $this->ticket_model->updateTicket(array("status" => ($status == '1') ? '0' : '1'), (int) $ticketid);
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
            $redirectURL = base_url('ticket/list');
        }
        $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
        echo $ajaxResponse;
    }
    public function assign_list() {

        $data['section_name'] 	= "Ticket Management";
        $data['page_title'] 	= $data['site_title'] = "Assigned Ticket List";
        $data['pageUrl'] 		= $pageUrl = base_url('agent/ticket/assign');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$data['user_id'] 		= $user_id 		= $this->session->userdata('agents')['user_id'];
		$data['user_type'] 		= $user_type	= $this->session->userdata('agents')['user_type'];
		$ignore_status_code 	= array(90,91);
        $data['response'] 		= $this->ticket_model->getAssignTicket($user_id,$ignore_status_code,$user_type);
        _manage_template('templates/header', 'templates/footer', 'ticket/assign_list', $data, 'templates/left_adminMenu');
    }
    
    public function completed_list() {
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Completed List";
        $data['pageUrl'] = $pageUrl = base_url('agent/ticket/completed');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$completed_status 		= array(90,91);
        $data['tickets'] 		= $this->ticket_model->getCompletedTicket($this->session->userdata('agents')['user_id'],$completed_status,$this->session->userdata('agents')['user_type']);
        _manage_template('templates/header', 'templates/footer', 'ticket/completed_list', $data, 'templates/left_adminMenu');
    }
    
    public function feedback() {
        $data['section_name'] = "Feedback";
        $data['page_title'] = $data['site_title'] = "Feedback";
        $data['pageUrl'] = $pageUrl = base_url('agent/ticket/feedback');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if($this->session->userdata('agents')['user_type'] == "consultant"){        
            $data['tickets'] = $this->ticket_model->getCustomerFeedBackList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','90');
        }else{
            $data['tickets'] = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','90');
        }
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $responce = $this->ticket_model->createFeedback([
                        'ticket_id'    => $this->input->post('ticket_id'),
                        'customer_id'  => $this->input->post('customer_id'),
                        'consultant_id'=> $this->input->post('consultant_id'),
                        'rating'       => $this->input->post('rating'),
                        'review'       => $this->input->post('remark'),
                        'created'      => date('Y-m-d H:i:s'),
                        'modified'     => date('Y-m-d H:i:s')
                    ]
                );
            if($responce){
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Feedback given successfully.'));
            }else {
                $this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
            }
                redirect(base_url('ticket/feedback'));
        }
        _manage_template('templates/header', 'templates/footer', 'ticket/feedback', $data, 'templates/left_adminMenu');
    }
    
    
    public function validateEmail($email,$userId){
        $details = $this->user_model->validateEmail($email,$userId);
        if (!empty($details)) {
            $this->form_validation->set_message('validateEmail', 'Email already exists.');
            return FALSE;
        }
        return TRUE;
    }

    function validateAge($date) {
        if(!empty($date)){
            $seletedDate = date('Y-m-d', strtotime($date));
            $currentDate = date('Y-m-d');
            $difference = dateDifference($currentDate,$seletedDate,'%y');
            if($difference>=18){
                return true;
            }else{
                $this->form_validation->set_message('validateAge', 'Age Must be greater than 18 Years.');
                return false;
            }
        }
    }
    
    public function profile() {
        $data['section_name'] = "Update Profile";
        $data['page_title'] = $data['site_title'] = "Personal Information / Step 1";
        $data['pageUrl'] = $pageUrl = base_url('agent/profile');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="' . base_url('agent/dashboard') . '">Dashboard</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $userid  	= $this->session->userdata('agents')['user_id'];
        $userType	= $this->session->userdata('agents')['user_type'];
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($userid,$userType);
        $data['countryList']= $this->user_model->getCountryList();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            if($usersData->user_type=='4'){
                $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
            }
            $this->form_validation->set_rules('user_name', 'Name', 'trim|required|min_length[2]|callback__alpha_dash_space');
            //$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_validateEmail[' . $userid . ']');
            $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|exact_length[10]|regex_match[/^[0-9]{10}$/]');
            //$this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required|callback_validateAge');
            // $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required');

            //$this->form_validation->set_rules('user_country', 'Country', 'trim|required');
            //$this->form_validation->set_rules('user_state', 'State', 'trim|required');
            //$this->form_validation->set_rules('user_city', 'City', 'trim|required');
            //$this->form_validation->set_rules('user_address', 'Address', 'trim|required');
            //$this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|exact_length[6]|numeric');
            //$this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
            //$this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
            if ($this->form_validation->run()) {
                $countrydata = $this->user_model->getCountryList($this->input->post('user_country'));
                $countryName = ($countrydata != '') ? $countrydata->name : '';
                $stateList = $this->user_model->getStateList($this->input->post('user_state'));
                $stateName = ($stateList != '') ? $stateList->name : '';
                $cityName = $this->input->post('customer_city');
                $getGeoData = _getGEOLocationByAddress($countryName . ',' . $stateName . ',' . $this->input->post('user_address') . ',' . $cityName);
                $dt = $this->input->post('user_dob');
                if($dt!=''){
                    $dat = date('Y-m-d', strtotime($this->input->post('user_dob')));
                }else{
                    //$dat = Null;
					$dat = date('Y-m-d', strtotime('-18 years'));
                } 
				$user_name 		= $this->input->post('user_name');
				$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
				$lowercaseTitle = strtolower($new_string); 
				$ucTitleString 	= ucwords($lowercaseTitle);
				$user_country	= $this->input->post('user_country');
				$country_id		= !empty($user_country)?$user_country:'88';
                $updateArr = array(
                    'user_id'       => $userid,
                    'name'          => $ucTitleString,
                    'mobile'        => $this->input->post('user_mobile'),
                    'dob'           => $dat,
                    'country_id'    => $country_id,
                    'state_id'      => $this->input->post('user_state'),
                    'city_id'       => $this->input->post('user_city'),
                    'zip'           => $this->input->post('pin_code'),
                    'gender'        => $this->input->post('user_gender'),
                    'latitude'      => ($getGeoData != '') ? $getGeoData['lat'] : '',
                    'longitude'     => ($getGeoData != '') ? $getGeoData['long'] : '',
                    'address'       => $this->input->post('user_address'),
                    'modified'      => date('Y-m-d H:i:s')
                );
                if (!empty($_FILES) && !empty($_FILES['user_photo']['name'])) {
                    $filename = $_FILES['user_photo']['name'];
                    $tmp_path = $_FILES['user_photo']['tmp_name'];
                    $image_name = uploadImage($filename, $tmp_path, 'profile', '140');
                    $updateArr['photo'] = $image_name;
                    unlinkImage('uploads/profile/', $usersData->photo);
                }
                if($usersData->user_type == '4'){
                    $updateArr['account_type']=$this->input->post('account_type');
                    //$updateArr['pan_photo']  = '';
                    //$updateArr['expertise']  = '';
                }
                $updateresponse = $this->user_model->updateUsersDetails($updateArr,($usersData->user_type=='4')?'nw_agent_tbl':'nw_customer_tbl');
                $responce = $this->user_model->updateUser([
                    'user_id' => $userid,
                    'email'   => $this->input->post('user_email'),
                    'modified'=> date('Y-m-d H:i:s')
                ]);
                if(isset($updateresponse)){
                    if($userType == 'agent'){
                        redirect(base_url('agent/profile2'));
                    }else{
                        $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Profile has been updated successfully.'));
                        redirect(base_url('agent/profile'));
                    }
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile', $data, 'templates/left_adminMenu');
    }

    public function other_Info() {
        $data['id'] = $id = $this->uri->segment(4);
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "Other Info";
        $data['pageUrl'] = $pageUrl = base_url('other-Info');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="'.base_url('dashboard').'">Dashboard</a></li><li class="breadcrumb-item"><a href="'.$pageUrl.'">'.$data['page_title'].'</a></li></ol>';
        $userid  = $this->session->userdata('users')['user_id'];
        $data['expertise'] = $this->expertise_model->listExpertise();
        $data['category'] = $this->category_model->getParentCategory();
        $data['consultant']  = $usersData = $this->user_model->getUserDetails($userid,($userType=='consultant') ? 3 : 2);
        $data['countryList']= $this->user_model->getCountryList();
        _manage_template('templates/header', 'templates/footer', 'templates/other-info', $data, 'templates/left_adminMenu');
    }

    public function oldpassword_check($old_password) {
        $old_password_hash = md5($old_password);
        $passwordDb = $this->user_model->getDataBykey('nw_user_tbl', 'id', $this->session->userdata('users')['user_id'], 'password');
        if (!empty($passwordDb) && $old_password_hash != $passwordDb->password) {
            $this->form_validation->set_message('oldpassword_check', 'Old password not match');
            return FALSE;
        }
        return TRUE;
    }

    public function change_password() {
        $data['section_name'] = "Update Password";
        $data['page_title'] = $data['site_title'] = "Update Password";
        $data['pageUrl'] = $pageUrl = base_url('agent/change-password');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="' . base_url($this->session->userdata('agents')['user_type'] . '/dashboard') . '">Dashboard</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|callback_oldpassword_check');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[30]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            if ($this->form_validation->run()) {
                $responce = $this->user_model->updateRecordsById('id', $this->session->userdata('agents')['user_id'], array('password' => md5($this->input->post('new_password'))));
                if (!empty($responce)) {                     
                    $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Password has been updated successfully.'));
                } else {
                    $this->session->set_flashdata('responce_msg', array('class' => INFO_ALERT, 'short_msg' => 'Worning', 'message' => 'Something Went Wrong.'));
                    $this->session->set_flashdata('flash_msg', '');
                }
                redirect(base_url('agent/change-password'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/change-password', $data, 'templates/left_adminMenu');
    }

    public function conversation() {
        $data['section_name']	= "Ticket Management";
        $data['page_title']  	= $data['site_title'] = "Conversation";
        $data['pageUrl']     	= $pageUrl = base_url('agent/ticket/assign');
        $data['ticketid']    	= $ticketid = $this->uri->segment(4);
        $data['user_type']    	= $this->session->userdata('agents')['user_type'];		
        //$data['ticketid']    = $ticketid = $id;
		
		$userschatdata 			= $this->ticket_model->getChatAgainstTicket($ticketid,'','','',0,4);
		$data['usersdata']		= $this->ticket_model->getuserdatabyticketid($ticketid,$this->session->userdata('agents')['user_type']);
		$chatdata 				= count($userschatdata);
		$data['chatdataslow']	= isset($userschatdata[$chatdata-1])?$userschatdata[$chatdata-1]->id:'';
		array_multisort($userschatdata, SORT_ASC );
		
		$data['chatdatas']	= 	isset($userschatdata[$chatdata-1])?$userschatdata[$chatdata-1]->id:'';
		
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/assign">Assign List</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/conversation/' . $ticketid . '">' . $data['page_title'] . '</a></li></ol>';
		$isticket = [];
        if(!empty($ticketid)){
			$user_id 	= $this->session->userdata('agents')['user_id'];
			$isticket 	= $this->ticket_model->checkticketavailable($ticketid);
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			redirect(base_url('agent/ticket/assign'));
		}
		if(!empty($isticket['data'])){
			$ticketChat = $this->ticket_model->getChatAgainstTicket($ticketid);
			$html = '<div class="direct-chat-messages">';
			$userType = ($this->session->userdata('agents')['user_type']=='agent')?4:'';
			if(!empty($ticketChat)){
				array_multisort($ticketChat, SORT_ASC );
				foreach ($ticketChat as $key => $value) {
					$chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
					$details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
				   // print_r($details);
				   // exit;
					if(!empty($details)){
						if(!empty($details->photo) && $details->photo != ''){
							$ImageUser = base_url('uploads/profile/'.$details->photo);
						}else{
							$ImageUser = base_url('uploads/profile/no_image_available.jpeg');
						}
						
						$rightbox = ($chatData->user_type==$userType) ? 'right':'left';
						$floatname= ($chatData->user_type==$userType) ? 'float-right':'float-left';
						$floatdate= ($chatData->user_type==$userType) ? 'float-left':'float-right';
						$iconcolor= ($chatData->user_type==$userType) ? 'ffffff':'000000';
						
						if($chatData->chat_type =='file') {
							 $acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
							 if(in_array(pathinfo($chatData->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
								$chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" style="width:60px; height:50px;"/></a>': $chatData->chat_massege;
							} else {
								$chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$chatData->chat_massege.'</a>': $chatData->chat_massege;
							}
						} else {
							$chatType = $chatData->chat_massege;
						}
						if($details->user_type == 4){
							$profileName = 'Agent '.$details->name;
						}else{
							$profileName = $details->name;
						}
						$html .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
								<span class="direct-chat-name '.$floatname.'">'.$profileName .'</span>
								<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
							</div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
							<div class="direct-chat-text">'.$chatType.'</div></div>';
					}else{
						$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
						redirect(base_url('agent/ticket/assign'));
					}
				}
			}else{
				$html .= '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name float-right"></span><span class="direct-chat-timestamp float-left"></span></div><div class="direct-chat-text">No Record Available.</div></div>';
			}
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			redirect(base_url('agent/ticket/assign'));
		}        
        if ($this->input->is_ajax_request() == true) {
            if(empty(trim($this->input->post('message'))) && (empty($_FILES) || empty($_FILES['upload_file']['name']))){
                $status     = false;
                $style_color= 'red';
                $chatList   = ''; 
                $massege    = 'Please enter Message.';
            }else{
                $status     = true;
                $massege    = 'Message Sent';
                $style_color= 'green';
                $chatList   =  '';
                $ticketData = $this->ticket_model->getMappedTicket($ticketid);
                if(!empty($this->input->post('message'))){
                    $insertArry = $this->ticket_model->createChat(array(
                        'ticket_id'   => $ticketid,
                        'user_id'     => $this->session->userdata('users')['user_id'],
                        'chat_massege'=> $this->input->post('message'),
                        'created_at'  => date('Y-m-d H:i:s')
                    ));
                    
                    $details  = $this->user_model->getUserDetailsById($insertArry->userid,$insertArry->user_type);                    
                    if($details->photo != ''){
                    $ImageUser = base_url('uploads/profile/'.$details->photo);
                    }else{
                        $ImageUser = base_url('uploads/profile/no_image_available.jpeg');
                    }
                    
                    
                    $rightbox = ($details->user_type==$userType) ? 'right':'left';
                    $floatname= ($details->user_type==$userType) ? 'float-right':'float-left';
                    $floatdate= ($details->user_type==$userType) ? 'float-left':'float-right';
                    $chatList = '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$details->name.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$insertArry->chat_massege.'</div></div>';
                }

                if (!empty($_FILES) && !empty($_FILES['upload_file']['name'])) {
                    $filename  = $_FILES['upload_file']['name'];
                    $tmp_path  = $_FILES['upload_file']['tmp_name'];
                    $image_name= uploadImage($filename, $tmp_path, 'conversation');
                    $insertArry= $this->ticket_model->createChat(array(
                        'ticket_id'   => $ticketid,
                        'user_id'     => $this->session->userdata('users')['user_id'],
                        'chat_massege'=> $image_name,
                        'chat_type'   => 'file',
                        'created_at'  => date('Y-m-d H:i:s')
                    ));
                    $details  = $this->user_model->getUserDetailsById($insertArry->userid,$insertArry->user_type);
					                   
                    if($details->photo != ''){
                        $ImageUser = base_url('uploads/profile/'.$details->photo);
                    }else{
                        $ImageUser = base_url('uploads/profile/no_image_available.jpeg');
                    }
                       
                    $rightbox = ($details->user_type==$userType) ? 'right':'left';
                    $floatname= ($details->user_type==$userType) ? 'float-right':'float-left';
                    $floatdate= ($details->user_type==$userType) ? 'float-left':'float-right';
                    if($insertArry->chat_type =='file') {
                     $acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
						if(in_array(pathinfo($insertArry->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
							$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" style="width:60px; height:50px;"/></a>': $insertArry->chat_massege;
						} else {
							$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$insertArry->chat_massege.'</a>': $insertArry->chat_massege;
						}
                    } else {
                        $chatType = $insertArry->chat_massege;
                    }
                    
                    //$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to view this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;" title="Attachment"></i>&nbsp;&nbsp;<i class="fa fa-eye" style="font-size:24px;"></i></a>': $insertArry->chat_massege;
                    $chatList .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$details->name.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$chatType.'</div></div>';
                }
            }
            $ajaxResponse = json_encode(array('datalist'=>$chatList,'status'=>$status,"massege"=>$massege,'style_color'=>$style_color));
            echo $ajaxResponse;
            exit();
        }
        $data['html'] = $html .='</div>';
        _manage_template('templates/header', 'templates/footer', 'ticket/conversation', $data, 'templates/left_adminMenu');
    }
    
	public function getChatDataByAjax($ticketid=null){
		$ticketid = $_POST['ticketid'];
        $ticketChat = $this->ticket_model->getChatAgainstTicket($ticketid);
        
        $html = '<div class="direct-chat-messages">';
        $userType = ($this->session->userdata('users')['user_type']=='consultant')?3:2;        
        if(!empty($ticketChat)){
            array_multisort($ticketChat, SORT_ASC );
            foreach ($ticketChat as $key => $value) {
                $chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
                $details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
                
                if($details->photo != ''){
                    $ImageUser = base_url('uploads/profile/'.$details->photo);
                }else{
                    $ImageUser = base_url('uploads/profile/no_image_available.jpeg');
                }
                
                
                $rightbox = ($chatData->user_type==$userType) ? 'right':'left';
                $floatname= ($chatData->user_type==$userType) ? 'float-right':'float-left';
                $floatdate= ($chatData->user_type==$userType) ? 'float-left':'float-right';
                $iconcolor= ($chatData->user_type==$userType) ? 'ffffff':'000000';
                if($chatData->chat_type =='file') {
                     $acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
                     if(in_array(pathinfo($chatData->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
                        $chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" style="width:60px; height:50px;"/></a>': $chatData->chat_massege;
                    } else {
                        $chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$chatData->chat_massege.'</a>': $chatData->chat_massege;
                    }
                } else {
                    $chatType = $chatData->chat_massege;
                }
               // $chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to view this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';" title="Attachment"></i>&nbsp;&nbsp;<i class="fa fa-eye" style="font-size:24px;color:#'.$iconcolor.';"></i></a>': $chatData->chat_massege;
				if($details->user_type == 4){
					$profileName = 'Agent '.$details->name;
				}else{
					$profileName = $details->name;
				}
                $html .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
                    </div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
                    <div class="direct-chat-text">'.$chatType.'</div></div>';
                
                
               
            }
        }else{
            $html .= '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name float-right"></span><span class="direct-chat-timestamp float-left"></span></div><div class="direct-chat-text">No Record Available.</div></div>';
        }
        
        $data['html'] = $html .='</div>';
        
        echo $html;
        
    }
    public function updateProfile2(){
        //$data['id'] = $id = $this->uri->segment(4);
        $sessionData = $this->session->userdata('agents');
        $data['id'] = $id = $sessionData['user_id'];
        $data['user_type'] = $user_type = $sessionData['user_type'];
        $data['section_name'] = "Agent Profile Update";
        $data['page_title'] = $data['site_title'] = "Other Information / Step 2";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
        $data['pageUrl'] = $pageUrl = base_url('agent/profile2');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url('agent/dashboard') . '">Dashboard</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,$user_type);
		//echo "<pre>";print_r($usersData);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
            //$this->form_validation->set_rules('subcategory_id', 'Subcategory Name', 'trim|required');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|numeric|exact_length[10]');
            if($this->input->post('aadhar_no') != $usersData->aadhaar_card_number){
                $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|numeric|exact_length[12]|is_unique[nw_consultant_tbl.aadhaar_card_number]');
            }
            if($this->input->post('pan_no') != $usersData->pan_card_number){
                 $this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|alpha_numeric|exact_length[10]|is_unique[nw_consultant_tbl.pan_card_number]');
            }
            //$this->form_validation->set_rules('expertise_text', 'Expertise', 'trim');
            $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[30]');
            //$this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
            $this->form_validation->set_rules('experience', 'Experience', 'trim|max_lenght[50]');
            $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
            $this->form_validation->set_rules('user_aadhar_photo', 'Profile Picture', 'callback_userProflephoto');
            $this->form_validation->set_rules('user_pan_photo', 'Profile Picture', 'callback_userProflephoto');
			
            if ($this->form_validation->run()) {
                if (!empty($this->input->post('expertise_text'))) {
                    $expertise = implode(',', $this->input->post('expertise_text'));
                } else {
                    $expertise = "";
                }
               /* if (empty($this->input->post('subcategory_id'))) {
                    $category = $this->input->post('category_id');
                } else {
                    $category = $this->input->post('subcategory_id');
                } */
                /* if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
                    $filename = $_FILES['user_photo']['name'];
                    $tmp_path = $_FILES['user_photo']['tmp_name'];
                    $profilephoto = uploadImage($filename, $tmp_path, 'profile', '140');
                }else{
                    $profilephoto = '';
                } */
                if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
                    $aadharname 	= $_FILES['aadhar_photo']['name'];
                    $tmp_path1  	= $_FILES['aadhar_photo']['tmp_name'];
                    $aadharphoto	= uploadImage($aadharname, $tmp_path1, 'consultant/agent', '140');
                }else{
                    $aadharphoto	= $usersData->aadhaar_photo;
                }
                if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
                    $panname 	= $_FILES['pan_photo']['name'];
                    $tmp_path2  = $_FILES['pan_photo']['tmp_name'];
                    $panphoto	= uploadImage($panname, $tmp_path2, 'consultant/agent', '140');
                }else{
                    $panphoto	= $usersData->pan_photo;
                }
                $experience_yr = $this->input->post('experience_yr');
                $experience_mn = $this->input->post('experience_mn');
                $experience    = $experience_yr.' ' .$experience_mn;
				$subcategory_id = !empty($this->input->post('subcategory_id'))?$this->input->post('subcategory_id'):'0';
                $this->user_model->updateAgentById('user_id', $id, [
                    'category_id'       	=> $this->input->post('category_id'),
                    'subcategory_id'    	=> $subcategory_id,
                    'telephone'         	=> $this->input->post('contact_number'),
                    //'photo'             => $profilephoto,
                    'aadhaar_card_number'	=> $this->input->post('aadhar_no'),
                    'aadhaar_photo'     	=> $aadharphoto,
                    'pan_card_number'   	=> $this->input->post('pan_no'),
                    'pan_photo'         	=> $panphoto,
                    'education'         	=> $this->input->post('qualification'),
                    'sub_education'     	=> $this->input->post('sub_qualification'),
                    'expertise'         	=> $expertise,
                    'experience'        	=> $experience,
                    'modified'          	=> date('Y-m-d H:i:s')
                ],'nw_agent_tbl');
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Agent profile updated successfully.'));
                redirect(base_url('agent/dashboard'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile-step2', $data, 'templates/left_adminMenu');
    }
    
    public function getsubcatbycat(){
        $catId      = $this->input->post('catId');
        $html = "";
		if(!empty($catId)){
			$sections   = $this->category_model->getsubcategory($catId);
			if(isset($sections)){
				foreach($sections as $res){
					$html .= '<option value="'. $res->id .'">'. $res->name .'</option>'; 
				}
			}else{
				$html .= '<option value=" ">No category Mapped.</option>'; 
			}
		}
        print_r($html);
    }
    public function getsubqualbyqualid(){
        $qualId         = $this->input->post('qualId');
        $html = "";
        $sections       = $this->user_model->getsubqualificationbyqualid($qualId);
        if(isset($sections)){
            foreach($sections as $res){
                $html .= '<option value="'. $res->subqualification_id .'">'. $res->subquali_name .'</option>'; 
            }
        }else{
            $html .= '<option value=" ">No Qualification Mapped.</option>'; 
        }
        print_r($html);
    }
    public function changereadstatus(){
		$ticketid 	= $this->input->post('ticketid');
		$userdata	= $this->session->userdata('agents');
		$userid 	= '';
		if(!empty($userdata)){
			$userid = $userdata['user_id'];
		}
		$data 		= array(
						'read_status' => '1'
		); 
		$sections 	= $this->ticket_model->changereadstatus($data,$ticketid,$userid);
		$allchat 	= $this->ticket_model->getChatAgainstTicket($ticketid);
		$lastid 	= 0;
		if(!empty($allchat)){
			$lastid 	= $allchat[0]->id;
		}
		print_r($lastid);
		exit();
    } 
    public function userchat($ticketid){
		$sessionData = $this->session->userdata('agents');
        $data['ticketid'] = $ticketid;
        $data['id'] = $id = $sessionData['user_id'];
        $data['user_type'] = $user_type = $sessionData['user_type'];
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "Consultant Chat";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
        $data['pageUrl'] = $pageUrl = base_url('profile2');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise();
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,($user_type=='consultant') ? 3 : 2);
		//$ticketid 			= '47';
		$data['userschatdata']  = $userschatdata = $this->ticket_model->getChatAgainstTicket($ticketid);
		_manage_template('templates/header', 'templates/footer', 'chat/chat', $data, 'templates/left_adminMenu');
    }
	public function getchatdata(){	
		$ticketid 		= $this->input->post('ticketid');
		$limit 			= $this->input->post('count');
		//$start 			= $this->input->post('start');
		$lastid 		= $this->input->post('lastid');
		$start 			= '0';
		$userType 		= ($this->session->userdata('agents')['user_type']=='agent')?4:'';
		$userschatdata 	= $this->ticket_model->getChatAgainstTicket($ticketid,'','','',$start,$limit,$lastid);
		$chatdata 				= count($userschatdata);
		$data['chatdataslow']	= $chatdataslow = isset($userschatdata[$chatdata-1])?$userschatdata[$chatdata-1]->id:'0';
		$data['chatdatashigh']	= $chatdatashigh = isset($userschatdata[$chatdata-1])?$userschatdata[0]->id:'0';
		array_multisort($userschatdata, SORT_ASC );
		$html 	= '';
		$html 	.= '<input type="hidden" name="chatdataslow" id="chatdataslow" value="'.$chatdataslow.'" />';
		if(!empty($userschatdata)){
			/* foreach($userschatdata as $userschat){
				$html.='<div class="messages">'.$userschat->chat_massege .'</div><br/>';
			} */
			foreach ($userschatdata as $key => $value) {
                $chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
                $details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
                
                if($details->photo != ''){
                    $ImageUser = base_url('uploads/profile/'.$details->photo);
                   
                }else{
                    $ImageUser = base_url('uploads/profile/no_image_available.jpeg');
                }
                $rightbox = ($chatData->user_type==$userType) ? 'right':'left';
                $floatname= ($chatData->user_type==$userType) ? 'float-right':'float-left';
                $floatdate= ($chatData->user_type==$userType) ? 'float-left':'float-right';
                $iconcolor= ($chatData->user_type==$userType) ? 'ffffff':'000000';
                
                
                if($chatData->chat_type =='file') {
                     $acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
                     if(in_array(pathinfo($chatData->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
                        $chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" style="width:60px; height:50px;"/></a>': $chatData->chat_massege;
                    } else {
                        $chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$chatData->chat_massege.'</a>': $chatData->chat_massege;
                    }
                } else {
                    $chatType = $chatData->chat_massege;
                }
				
				if($details->user_type == 4){
					$profileName = 'Agent '.$details->name;
				}else{
					$profileName = $details->name;
				}
                $html .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
                    </div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
                    <div class="direct-chat-text">'.$chatType.'</div></div>';
            }
		}
		if ($this->input->is_ajax_request() == true) {
			if($this->input->post('flag') == 'callajax'){
				if(empty(trim($this->input->post('message'))) && (empty($_FILES) || empty($_FILES['upload_file']['name']))){
					$status     	= false;
					$style_color	= 'red';
					$chatList   	= ''; 
					$massege    	= 'Please enter Message.';
				}else{
					$status     	= true;
					$massege    	= 'Message Sent';
					$style_color	= 'green';
					$chatList   	=  '';
					$ticketid 		= $this->input->post('ticketid');
					$ticketData 	= $this->ticket_model->getMappedTicket($ticketid);
					//$msg_to = '';
					/* if($userType == '3'){
						$msg_to = $ticketData->customer_id;
					}else{
						$msg_to = $ticketData->consultant_id;
					} */
					$msg_to = $ticketData->customer_id;
					if(!empty($this->input->post('message'))){
						$insertArry = $this->ticket_model->createChat(array(
							'ticket_id'   	=> $ticketid,
							'user_id'     	=> $this->session->userdata('agents')['user_id'],
							'msg_to'   		=> $msg_to,
							'msg_from'   	=> $this->session->userdata('agents')['user_id'],
							'user_type'   	=> $userType,
							'chat_massege'	=> $this->input->post('message'),
							'created_at'  	=> date('Y-m-d H:i:s')
						));
						
						$details  = $this->user_model->getUserDetailsById($insertArry->userid,$insertArry->user_type);
						if($details->photo != ''){
							$ImageUser = base_url('uploads/profile/'.$details->photo);
						}else{
							$ImageUser = base_url('uploads/profile/no_image_available.jpeg');
						}
						$rightbox = ($details->user_type==$userType) ? 'right':'left';
						$floatname= ($details->user_type==$userType) ? 'float-right':'float-left';
						$floatdate= ($details->user_type==$userType) ? 'float-left':'float-right';
						
						if($details->user_type == 4){
							$profileName = 'Agent '.$details->name;
						}else{
							$profileName = $details->name;
						}
						
						$chatList = '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
							<span class="direct-chat-name '.$floatname.'">'. $profileName .'</span>
							<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$insertArry->chat_massege.'</div></div>';
					}

					if (!empty($_FILES) && !empty($_FILES['upload_file']['name'])) {
						$filename  = $_FILES['upload_file']['name'];
						$tmp_path  = $_FILES['upload_file']['tmp_name'];
						$image_name= uploadImage($filename, $tmp_path, 'conversation');
						$insertArry= $this->ticket_model->createChat(array(
							'ticket_id'   	=> $ticketid,
							'user_id'     	=> $this->session->userdata('agents')['user_id'],
							'msg_to'   		=> $msg_to,
							'msg_from'   	=> $this->session->userdata('agents')['user_id'],
							'chat_massege'	=> $image_name,
							'user_type'   	=> $userType,
							'chat_type'   	=> 'file',
							'created_at'  	=> date('Y-m-d H:i:s')
						));
						$details  = $this->user_model->getUserDetailsById($insertArry->userid,$insertArry->user_type);
											
						if($details->photo != ''){
							$ImageUser = base_url('uploads/profile/'.$details->photo);
						}else{
							$ImageUser = base_url('uploads/profile/no_image_available.jpeg');
						}
						   
						$rightbox = ($details->user_type==$userType) ? 'right':'left';
						$floatname= ($details->user_type==$userType) ? 'float-right':'float-left';
						$floatdate= ($details->user_type==$userType) ? 'float-left':'float-right';
						if($insertArry->chat_type =='file') {
							$acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
							if(in_array(pathinfo($insertArry->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
								$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" style="width:60px; height:50px;"/></a>': $insertArry->chat_massege;
							} else {
								$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$insertArry->chat_massege.'</a>': $insertArry->chat_massege;
							}
						} else {
							$chatType = $insertArry->chat_massege;
						}
						if($details->user_type == 4){
							$profileName = 'Agent '.$details->name;
						}else{
							$profileName = $details->name;
						}
						//$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to view this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;" title="Attachment"></i>&nbsp;&nbsp;<i class="fa fa-eye" style="font-size:24px;"></i></a>': $insertArry->chat_massege;
						$chatList = '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
							<span class="direct-chat-name '.$floatname.'">'. $profileName .'</span>
							<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$chatType.'</div></div>';
					}
				}
				$ajaxResponse=json_encode(array('datalist'=>$chatList,'status'=>$status,"massege"=>$massege,'style_color'=>$style_color,'chatdatashigh'=>$chatdatashigh));
				echo $ajaxResponse;
				exit();
			}
        }
        $html .='</div>';
		print_r($html);
	}
	public function getnewchat(){
		if(!empty($this->input->post())){
			$chatdatashigh 	= $this->input->post('chatdatashigh');
			$chatticketid 	= $this->input->post('chatticketid');
			$chatdetails  	= $this->ticket_model->getNewChatAgainstTicket($chatticketid,$chatdatashigh);
			$userType 		= ($this->session->userdata('agents')['user_type']=='agent')?4:'';
			$html = '';
			if(!empty($chatdetails)){
				array_multisort($chatdetails, SORT_ASC );
				$endchat = end($chatdetails);
				$countchat = count($chatdetails);
				if($endchat->id > $chatdatashigh){
					foreach ($chatdetails as $key => $value) {
						$chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
						//echo '<pre>'; print_r($chatData); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
						$details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
						
						if($details->photo != ''){
							$ImageUser = base_url('uploads/profile/'.$details->photo);
						   
						}else{
							$ImageUser = base_url('uploads/profile/no_image_available.jpeg');
						}
						$rightbox = ($chatData->user_type==$userType) ? 'right':'left';
						$floatname= ($chatData->user_type==$userType) ? 'float-right':'float-left';
						$floatdate= ($chatData->user_type==$userType) ? 'float-left':'float-right';
						$iconcolor= ($chatData->user_type==$userType) ? 'ffffff':'000000';	
						if($chatData->chat_type =='file') {
							 $acceptedFormats = array('gif', 'png', 'jpg', 'jpeg');
							 if(in_array(pathinfo($chatData->chat_massege, PATHINFO_EXTENSION), $acceptedFormats)) {
								$chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to view this file" target="_blank"><img src="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" style="width:60px; height:50px;"/></a>': $chatData->chat_massege;
							} else {
								$chatType = ($chatData->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$chatData->chat_massege).'" alt="'.$chatData->chat_massege.'" title="Click to download this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;color:#'.$iconcolor.';"></i>'.$chatData->chat_massege.'</a>': $chatData->chat_massege;
							}
						} else {
							$chatType = $chatData->chat_massege;
						}
						if($details->user_type == 4){
							$profileName = 'Agent '.$details->name;
						}else{
							$profileName = $details->name;
						}
						$html .= '<div class="direct-chat-msg '.$value->id.' '.$rightbox.'"><div class="direct-chat-info clearfix">
								<span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
								<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
							</div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
							<div class="direct-chat-text">'.$chatType.'</div></div>';
					}
				}
				$lastchat 	= end($chatdetails);
				$lastid 	= $lastchat->id;
				if(!empty($html)){
					$ajaxResponse	= json_encode(array('datalist'=>$html,'lastid'=>$lastid,'countchat'=>$countchat));
					echo $ajaxResponse;
					exit();
				}
			}
		}
	}
	public function getnewnotification(){
		//if(!empty($this->input->post())){
			$usersession 		= $this->session->userdata('agents');
			$user_id 	 		= $usersession['user_id'];
			$user_type 	 		= $usersession['user_type'];
			$agentData			= $this->user_model->getconsultantbyagent($user_id);
			$consultant_id		= $agentData->consultant_id;
			$chatdetails  		= $this->ticket_model->getallnewnotification($consultant_id);
			$checkagent  		= $this->ticket_model->checkticketisassigntoagent($user_id,$consultant_id);
			$notificationlist 	= '';
			if(!empty($chatdetails['data']) && !empty($checkagent['data'])){
				$counter = 1;
				foreach($chatdetails['data'] as $allnotifications){
					$username = '';
					if($usersession['user_type'] == 'consultant'){
						$customerdetails  = $this->user_model->getUserDetailsById($allnotifications->msg_from,$user_type);
						$username = isset($customerdetails->name)?$customerdetails->name:'';
					}elseif($usersession['user_type'] == 'customer'){
						$consultantdetails  = $this->user_model->getUserDetailsById($allnotifications->msg_from,$user_type);	
						$username = isset($consultantdetails->name)?$consultantdetails->name:'';
					}else{
						$agentdetails  = $this->user_model->getUserDetailsById($allnotifications->msg_from,'2');	
						$username = isset($agentdetails->name)?$agentdetails->name:'';
					}
					if($counter <= 5 ){
						$ticketurl = base_url() . "agent/ticket/conversation/" .$allnotifications->id;
						$chat_massege = isset($allnotifications->chat_massege)?$allnotifications->chat_massege:"";
						$notifytime = '';
						if(!empty($allnotifications->created_at)){
							$created_date = date_create( $allnotifications->created_at );
							$notifytime	  =	date_format($created_date,"d M Y h:i:s a");
						}
						
						$ticket_id = isset($allnotifications->ticket_id)?$allnotifications->ticket_id:'';
						$notificationlist .= '<div class="dropdown-divider"></div>
						<a href="' . $ticketurl .'" class="dropdown-item">
						<i class="fa fa-envelope mr-2"></i> '.$chat_massege.'<br/><span> <b>From: </b>'.$username.'</span><br/><span> <b>Ticket Id: </b>'.$ticket_id.'</span><br/><span>'.$notifytime.'</span></a>';
					}
					$counter++; 
				}
				//$chatdetails['data']
				$count = $chatdetails['count'];
			}else{
				$notificationlist .= '<div class="dropdown-divider"></div><p>No Record Available</p>';
				$count = '0';
			}
			$ajaxResponse	= json_encode(array('datalist'=>$notificationlist,'countchat'=>$count));
			echo $ajaxResponse;
			exit();
		//}
	}
	public function new_assign_list() {

        $data['section_name'] 	= "Ticket Management";
        $data['page_title'] 	= $data['site_title'] = "Unassigned Ticket List";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket');
		$newticketlisturl		=  base_url('ticket/new_assign_list');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $newticketlisturl . '">' . $data['page_title'] . '</a></li></ol>';
		//$ignore_status_code 	= array(90,91);
        $data['tickets'] 		= $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'],'','tickets.id','desc','10','1','new');
        _manage_template('templates/header', 'templates/footer', 'ticket/ticket_list', $data, 'templates/left_adminMenu');
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
	public function changeticketstatwithremark($ticketid){
		if($this->input->post('ticketstatusupdate')){
			$this->form_validation->set_rules('ticket_status', 'Ticket Status', 'required');
			if ($this->form_validation->run()) {
				$ticket_status 		= $this->input->post('ticket_status');
				$ticketdata			= $this->ticket_model->getallticketdata($ticketid);
				/*** Update ticket table ***/
				$returndata 		= $this->ticket_model->updateTicketsTable('id',$ticketid,'nw_ticket_tbl',array('ticket_status' => $ticket_status));
				if($returndata){
					$returnticketmapdata 	= $this->ticket_model->updateTicketsTable('ticket_id',$ticketid,'nw_ticket_map_tbl',array('ticket_status' => $ticket_status));
					if($ticketdata->agent_assign_status == '20'){
						if($returnticketmapdata){
							$returnagentticketmapdata 	= $this->ticket_model->updateTicketsTable('ticket_id',$ticketid,'nw_agent_ticket_map_tbl',array('ticket_status' => $ticket_status));
						}
					}
					if($returnticketmapdata){
						$consultant_remark  = $this->input->post('consultant_remark');
						$userdata 			= $this->session->userdata('agents');
						$user_id			= $userdata['user_id'];
						$inserteddata		= array(
							'user_id' 		=> $user_id,
							'ticket_id' 	=> $ticketid,
							'ticket_status' => $ticket_status,
							'user_remark' 	=> $consultant_remark,
							'created_at' 	=> date('Y-m-d H:i:s'),
							'modified_at' 	=> date('Y-m-d H:i:s')							
						);
						$ticketlogdata = $this->ticket_model->getthedata('ticket_id',$ticketid,'nw_ticketstatusremarklog_tbl');
						if (!empty($_FILES) && !empty($_FILES['remark_file']['name'])) {
							$filename = $_FILES['remark_file']['name'];
							$tmp_path = $_FILES['remark_file']['tmp_name'];
							$image_name = uploadImage($filename, $tmp_path, 'ticket/ticketremarkfiles', '140');
							$inserteddata['user_file'] = $image_name;
							if(!empty($ticketlogdata->user_file)){
								unlinkImage('ticket/ticketremarkfiles/', $ticketlogdata->user_file);
							}
						}
						$insertedsuccess = $this->ticket_model->createTicket('nw_ticketstatusremarklog_tbl',$inserteddata);
						if($insertedsuccess){
							$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Ticket status updated successfully.'));
							redirect(base_url('/agent/ticket/view/'.$ticketid));
						}
					}
				}
			}
		}
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