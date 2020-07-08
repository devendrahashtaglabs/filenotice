<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class customerController extends MX_Controller {

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $last = end($this->uri->segments);  
        if ($last != 'login') {
			$loggedin = $this->session->userdata('users');
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
        $data['section_name'] 	= "Service Management";
        $data['page_title'] 	= $data['site_title'] = "Service List";
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
	public function image_uploads(){
		if($_FILES['image']['size'] != 0){
			$upload_dir = './uploads/ticket/';
			$config = array();
			if (!is_dir($upload_dir)) {
				 mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx';
			$config['max_size']      = '0';
			$config['overwrite']     = FALSE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload');

			$files 		= $_FILES;
			$filecount  = count($_FILES['image']['name']);
			$file 		= [];
			for($i=0; $i< $filecount; $i++)
			{           
				$rndstr 	= randomstring();
				$file_extension = _getExtension($files['image']['name'][$i]);
				$_FILES['image']['name']= time().$rndstr.'.'.$file_extension;
				$_FILES['image']['type']= $files['image']['type'][$i];
				$_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
				$_FILES['image']['error']= $files['image']['error'][$i];
				$_FILES['image']['size']= $files['image']['size'][$i]; 
				$this->upload->initialize($config);
				$targetpath = $config['upload_path'].$_FILES['image']['name'];
				if(move_uploaded_file($_FILES['image']['tmp_name'], $targetpath)){			
				//if (($this->upload->do_upload())){
					$file[] 	=  $_FILES['image']['name'];		
				}else{
					$this->form_validation->set_message('image_upload',$this->upload->display_errors());
					return false;
				}
			}
			return $file;			
		}else{
			return true;
		}		
    }
	public function uploadscertificate(){
		if($_FILES['image']['size'] != 0){
			$upload_dir = './uploads/consultant/certificates/';
			$config = array();
			if (!is_dir($upload_dir)) {
				 mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx';
			$config['max_size']      = '0';
			$config['overwrite']     = FALSE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload');

			$files 		= $_FILES;
			$filecount  = count($_FILES['image']['name']);
			$file 		= [];
			for($i=0; $i< $filecount; $i++)
			{           
				$rndstr 	= randomstring();
				$file_extension = _getExtension($files['image']['name'][$i]);
				$_FILES['image']['name']= time().$rndstr.'.'.$file_extension;
				$_FILES['image']['type']= $files['image']['type'][$i];
				$_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
				$_FILES['image']['error']= $files['image']['error'][$i];
				$_FILES['image']['size']= $files['image']['size'][$i]; 
				$this->upload->initialize($config);
				$targetpath = $config['upload_path'].$_FILES['image']['name'];
				if(move_uploaded_file($_FILES['image']['tmp_name'], $targetpath)){			
				//if (($this->upload->do_upload())){
					$file[] 	=  $_FILES['image']['name'];		
				}else{
					$this->form_validation->set_message('image_upload',$this->upload->display_errors());
					return false;
				}
			}
			return $file;			
		}else{
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
        $data['stateList']	= $this->user_model->getStateList('','88');
		$user_id = $this->session->userdata('users')['user_id'];
		$data['customerData']	= $customerData = $this->user_model->getDataBykey('nw_customer_tbl','user_id',$user_id);
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
            $this->form_validation->set_rules('customer_mobile', 'Mobile Number', 'trim|required|max_length[10]');
            if ($this->form_validation->run()) {
				$str 	= $this->input->post('categorytext');
				$len	= 3;
				$rndnumber = randomstring('2');
				$ticketname = substr(str_replace(" ", "", $str), 0, $len).'-'.date('mdh24is') . $rndnumber;//edited at 02012020
				$newticketname = strtoupper($ticketname);
				/* $path1= "./uploads/ticket/".$_FILES['image']['name'][0];
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
				} */
				$imagename 	= $_FILES['image']['name'][0];
				$allfile	= [];
				if(!empty($imagename)){
					$userdocuments = $this->image_uploads();
					if(!empty($userdocuments)){
						foreach($userdocuments as $userdocument){
							$allfile[] = $userdocument;
						}
					}
				}
				$casefilename = $this->input->post('casefilename');
				$casefiledata =  [];
				$filearray 	  =  [];
				$filecounts	  = count($allfile);					
				for($i=0;$i<$filecounts;$i++){
					$filearray[$i]['file'] 		= $allfile[$i];
					$casefilenewname 			= ltrim($casefilename[$i]);
					$count 						= $i+1;
					$filearray[$i]['filename'] 	= !empty($casefilenewname)?$casefilenewname:'casefile '.$count;
				} 
				$casefiledata = json_encode($filearray);
				//$filename = implode(',',$allfile);
				$responce = $this->ticket_model->createTicket('',[
					'ticket_id'     	=> $newticketname,
					'customer_id'   	=> $this->session->userdata('users')['user_id'],
					'description'   	=> $this->input->post('description'),
					'file'          	=> $casefiledata,
					'start_date'    	=> date('Y-m-d'),
					'category_id'   	=> $this->input->post('category_id'),
					'subcategory_id'   	=> $this->input->post('subcategory_id'),
					'ticket_status' 	=> '10',
					'status'        	=> '1',
					'customer_mobile'  	=> $this->input->post('customer_mobile'),
					'customer_country'  => $this->input->post('customer_country'),
					'customer_state'    => $this->input->post('customer_state'),
					'customer_city'     => $this->input->post('customer_city'),
					'customer_pincode'  => $this->input->post('customer_pincode'),
					'customer_address'  => $this->input->post('customer_address'),
					'created'       	=> date('Y-m-d H:i:s'),
				]);
                if ($responce) {
                    $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been created successfully.'));
                    redirect($pageUrl . '/servicelist/?status=10');
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'ticket/create', $data, 'templates/left_adminMenu');
    }

    public function view_ticket() {
        $id = $this->uri->segment(3);
        $data['section_name']= "Ticket Management";
        $data['page_title']  = $data['site_title'] = "View Ticket";
        $data['pageUrl']     = $pageUrl = base_url('ticket');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item">'
                . '<a href="' . $pageUrl . '/view/' . $id . '">' . $data['page_title'] . '</a></li></ol>';
        $data['ticket'] = $this->ticket_model->getTicketById($id);
        $data['ticketlogdata'] = $this->ticket_model->getthedata('ticket_id',$id,'nw_ticketstatusremarklog_tbl');
		if(!empty($data['ticket'])){
			_manage_template('templates/header', 'templates/footer', 'ticket/view_details', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			if($this->session->userdata('users')['user_type'] == 'consultant'){
				redirect(base_url() . 'ticket/servicelist/?status=20');
			}else{
				redirect(base_url() . 'ticket/servicelist/?status=10');
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
        $data['ticket'] = $ticket = $this->ticket_model->getTicketById($id);
		$data['countryList']= $this->user_model->getCountryList();
        $data['stateList']= $this->user_model->getStateList('','88');
		if(!empty($data['ticket'])){
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
				//$this->form_validation->set_rules('status', 'Status', 'trim|required');
				$this->form_validation->set_rules('description', 'Description', 'required');
				// $this->form_validation->set_rules('ticket_status', 'ticket status', 'trim|required');
				// $this->form_validation->set_rules('payment_status', 'Payment status', 'trim|required');
				// $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
				// $this->form_validation->set_rules('close_date', 'Cloase Date', 'trim|required|callback_validateDate');
				$this->form_validation->set_rules('customer_country', 'Country', 'trim|required');
				$this->form_validation->set_rules('customer_state', 'State', 'trim|required');
				$this->form_validation->set_rules('customer_city', 'City', 'trim|required|max_length[100]');
				$this->form_validation->set_rules('customer_address', 'Address', 'trim|required|max_length[200]');
				$this->form_validation->set_rules('customer_pincode', 'Pincode', 'trim|required|max_length[6]');
				$this->form_validation->set_rules('customer_mobile', 'Mobile Number', 'trim|required');
				if ($this->form_validation->run()) {

					/* $newimg = $_FILES['image']['name'][0];

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
					} */
					$imagename 	= $_FILES['image']['name'][0];
					$allfile	= [];
					if(!empty($imagename)){
						$userdocuments = $this->image_uploads();
						if(!empty($userdocuments)){
							foreach($userdocuments as $userdocument){
								$allfile[] = $userdocument;
							}
						}
						$casefilename = $this->input->post('casefilename');
						$casefiledata =  [];
						$filearray 	  =  [];
						$filecounts	  = count($allfile);					
						for($i=0;$i<$filecounts;$i++){
							$filearray[$i]['file'] 		= $allfile[$i];
							$casefilenewname 			= ltrim($casefilename[$i]);
							$count 						= $i+1;
							$filearray[$i]['filename'] 	= !empty($casefilenewname)?$casefilenewname:'casefile '.$count;
						}
						$oldfilearray = json_decode($ticket->file);
						$newfilearray = array_merge($oldfilearray,$filearray);
						$filename 	  = json_encode($newfilearray);
						//$filename = $ticket->file .','. implode(',',$allfile);
					}else{
						$filename = $ticket->file;
					}
					if($filename == ""){
						$updatedata = array(
							'description' 		=> $this->input->post('description'),
							'category_id' 		=> $this->input->post('category_id'),
							'subcategory_id' 	=> $this->input->post('subcategory_id'),
							//'status' 			=> $this->input->post('status'), 
							'customer_mobile'  	=> $this->input->post('customer_mobile'),
							'customer_country' 	=> $this->input->post('customer_country'),
							'customer_state' 	=> $this->input->post('customer_state'),
							'customer_city' 	=> $this->input->post('customer_city'),
							'customer_address' 	=> $this->input->post('customer_address'),
							'customer_pincode' 	=> $this->input->post('customer_pincode'),
							'modified' 			=> date('Y-m-d H:i:s'),
							);
					}else{
						$updatedata = array(
							'description' 		=> $this->input->post('description'),
							'category_id' 		=> $this->input->post('category_id'),
							'subcategory_id' 	=> $this->input->post('subcategory_id'),
							//'status' 			=> $this->input->post('status'),
							'customer_mobile'  	=> $this->input->post('customer_mobile'),
							'customer_country' 	=> $this->input->post('customer_country'),
							'customer_state' 	=> $this->input->post('customer_state'),
							'customer_city' 	=> $this->input->post('customer_city'),
							'customer_address' 	=> $this->input->post('customer_address'),                    
							'customer_pincode' 	=> $this->input->post('customer_pincode'),
							'file'          	=> $filename,
							'modified' 			=> date('Y-m-d H:i:s'),
						);
					} 				
					$responce = $this->ticket_model->updateTicket($updatedata, $id);
					if ($responce) {
						$this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been updated successfully.'));
						redirect($pageUrl . '/servicelist/?status=10');
					}
				}
			}
			_manage_template('templates/header', 'templates/footer', 'ticket/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			if($this->session->userdata('users')['user_type'] == 'consultant'){
				redirect(base_url() . 'ticket/servicelist/?status=20');
			}else{
				redirect(base_url() . 'ticket/servicelist/?status=10');
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
            $redirectURL = base_url('ticket/servicelist');
        } else {
            $return = $this->ticket_model->updateTicket(array("status" => ($status == '1') ? '0' : '1'), (int) $ticketid);
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
            $redirectURL = base_url('ticket/servicelist');
        }
        $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
        echo $ajaxResponse;
    }

    public function assign_list() {

        $data['section_name'] 	= "Service Management";
        $data['page_title'] 	= $data['site_title'] = "Under Process";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket/servicelist/?status=20');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$data['user_id'] 		= $user_id 		= $this->session->userdata('users')['user_id'];
		$data['user_type'] 		= $user_type	= $this->session->userdata('users')['user_type'];
		$ignore_status_code 	= array(90,91);
		if($user_type != 'agent' ){
			$data['response'] 		= $this->ticket_model->getAssignTicket($user_id,$ignore_status_code,$user_type);
		}else{
			$data['response'] 		= $this->ticket_model->getAgentAssignTicket($user_id,$ignore_status_code,$user_type);
		}
        _manage_template('templates/header', 'templates/footer', 'ticket/assign_list', $data, 'templates/left_adminMenu');
    }
    
    public function completed_list() {
        $data['section_name'] = "Service Management";
        $data['page_title'] = $data['site_title'] = "Completed";
        $data['pageUrl'] = $pageUrl = base_url('ticket/completed');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$completed_status 		= array(90,91);
        $data['tickets'] 		= $this->ticket_model->getCompletedTicket($this->session->userdata('users')['user_id'],$completed_status,$this->session->userdata('users')['user_type']);
        _manage_template('templates/header', 'templates/footer', 'ticket/completed_list', $data, 'templates/left_adminMenu');
    }
    
    public function feedback() {
        $data['section_name'] = "Feedback";
        $data['page_title'] = $data['site_title'] = "Feedback";
        $data['pageUrl'] = $pageUrl = base_url('ticket/feedback');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if($this->session->userdata('users')['user_type'] == "consultant"){        
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
        $data['section_name'] 	= "Update Profile";
        $data['user_id'] 		= $userid 	= $this->session->userdata('users')['user_id'];
        $data['user_type'] 		= $userType = $this->session->userdata('users')['user_type'];
		if($userType == 'consultant'){
			$data['page_title'] = $data['site_title'] = "Personal Information / Step 1";
		}else{
			$data['page_title'] = $data['site_title'] = "Profile";			
		}
		$data['profile']  	= base_url('profile');
        $data['profile2'] 	= base_url('profile2');
        $data['profile3'] 	= base_url('profile3');
        $data['profile4'] 	= base_url('profile4');
        $data['profile5'] 	= base_url('profile5');
        $data['pageUrl'] = $pageUrl = base_url('profile');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="' . base_url('dashboard') . '">Dashboard</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($userid,($userType=='consultant') ? 3 : 2);
        $data['countryList']= $this->user_model->getCountryList();
		$data['category']   = $this->category_model->getParentCategory();
		$data['expertise']  = $this->expertise_model->listExpertise('1');
		$data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            if($usersData->user_type=='3'){
				$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
				$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|numeric|exact_length[10]');
				$this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
				$this->form_validation->set_rules('experience', 'Experience', 'trim|max_lenght[50]');
            }
            $this->form_validation->set_rules('user_name', 'Name', 'trim|required|min_length[2]|callback__alpha_dash_space');
            //$this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_validateEmail[' . $userid . ']');
            //$this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|exact_length[10]|regex_match[/^[0-9]{10}$/]');
            //$this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required|callback_validateAge');
            // $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required');

            //$this->form_validation->set_rules('user_country', 'Country', 'trim|required');
            //$this->form_validation->set_rules('user_state', 'State', 'trim|required');
            //$this->form_validation->set_rules('user_city', 'City', 'trim|required');
            //$this->form_validation->set_rules('user_address', 'Address', 'trim|required');
            //$this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|exact_length[6]|numeric');
            //$this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
			//echo '<pre>'; print_r($_FILES); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
            //$this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
            if ($this->form_validation->run()) {
                $countrydata = $this->user_model->getCountryList($this->input->post('user_country'));
                $countryName 	= ($countrydata != '') ? $countrydata->name : '';
                $stateList 		= $this->user_model->getStateList($this->input->post('user_state'));
                $stateName 		= ($stateList != '') ? $stateList->name : '';
                $cityName 		= $this->input->post('customer_city');
                $getGeoData 	= _getGEOLocationByAddress($countryName . ',' . $stateName . ',' . $this->input->post('user_address') . ',' . $cityName);
                $dt = $this->input->post('user_dob');
                if($dt!=''){
                    $dat = date('Y-m-d', strtotime($this->input->post('user_dob')));
                }else{
                    //$dat = Null;
					$dat = date('Y-m-d', strtotime('-18 years'));
                } 
				$age 			= $this->input->post('customer_age');
				if(empty($age)){
					$age 			= (date('Y') - date('Y',strtotime($dat)));
				}
				$user_name 		= $this->input->post('user_name');
				$sname 			= $this->input->post('sname');
				$title 			= $this->input->post('title');
				$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
				$lowercaseTitle = strtolower($new_string); 
				$ucTitleString 	= ucwords($lowercaseTitle);
				
				$new_stringsur 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $sname)));
				$lowercaseSname = strtolower($new_stringsur); 
				$user_sname 	= ucwords($lowercaseSname);
				
				$user_country 	= $this->input->post('user_country');
				$country_id		= !empty($user_country)?$user_country:'88';
				
				$user_mobile 	= $this->input->post('user_mobile');
				$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $user_mobile);
				$mobile			= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
				
				$contact_number	= $this->input->post('contact_number');
				$contactstr 	= preg_replace("/[^A-Za-z0-9 ]/", '', $contact_number);
				$mobile_number	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $contactstr);
				
				if( $usersData->user_type !='3' ){
					$updateArr = array(
						'user_id'       => $userid,
						'title'         => $title,
						'name'          => $ucTitleString,
						'sname'         => $user_sname,
						'mobile'        => $mobile,
						'age'           => $age,
						'dob'           => $dat,
						'country_id'    => $country_id,
						'state_id'      => $this->input->post('user_state'),
						'city_id'       => $this->input->post('user_city'),
						'zip'           => $this->input->post('pin_code'),
						'gender'        => $this->input->post('gender'),
						'latitude'      => ($getGeoData != '') ? $getGeoData['lat'] : '',
						'longitude'     => ($getGeoData != '') ? $getGeoData['long'] : '',
						'address'       => $this->input->post('user_address'),
						'modified'      => date('Y-m-d H:i:s')
					);
				}else{
					if (!empty($this->input->post('expertise_text'))) {
						$expertise = implode(',', $this->input->post('expertise_text'));
					} else {
						$expertise = "";
					}
					$experience_yr = $this->input->post('experience_yr');
					$experience_mn = $this->input->post('experience_mn');
					$experience    = $experience_yr.' ' .$experience_mn;
					
					$redirect_url	= base_url().'profile2';
					$getids 		= $this->input->post('getids');
					$allcatarray	= $this->getselectedcatsubcat($getids,$redirect_url);
					$category_id 	= $allcatarray['category'];
					$subcategory_id = $allcatarray['subcategory'];
					
					$updateArr = array(
						'user_id'       	=> $userid,
						'title'         	=> $title,
						'name'          	=> $ucTitleString,
						'sname'         	=> $user_sname,
						'mobile'        	=> $mobile,
						'age'           	=> $age,
						'dob'           	=> $dat,
						'country_id'    	=> $country_id,
						'state_id'      	=> $this->input->post('user_state'),
						'city_id'       	=> $this->input->post('user_city'),
						'zip'           	=> $this->input->post('pin_code'),
						'gender'        	=> $this->input->post('gender'),
						'latitude'      	=> ($getGeoData != '') ? $getGeoData['lat'] : '',
						'longitude'     	=> ($getGeoData != '') ? $getGeoData['long'] : '',
						'address'       	=> $this->input->post('user_address'),
						'category_id'       => $category_id,
						'subcategory_id'    => $subcategory_id,
						'telephone'         => $mobile_number,
						'education'         => $this->input->post('qualification'),
						'sub_education'     => $this->input->post('sub_qualification'),
						'expertise'         => $expertise,
						'experience'        => $experience,
						'modified'      	=> date('Y-m-d H:i:s')
					);
				}
                if (!empty($_FILES) && !empty($_FILES['user_photo']['name'])) {
                    $filename = $_FILES['user_photo']['name'];
                    $tmp_path = $_FILES['user_photo']['tmp_name'];
                    $image_name = uploadImage($filename, $tmp_path, 'profile', '140');
                    $updateArr['photo'] = $image_name;
                    unlinkImage('uploads/profile/', $usersData->photo);
                }
                if($usersData->user_type=='3'){
                    $updateArr['account_type']=$this->input->post('account_type');
                    //$updateArr['pan_photo']  = '';
                    //$updateArr['expertise']  = '';
                }
                $updateresponse = $this->user_model->updateUsersDetails($updateArr,($usersData->user_type=='3')?'nw_consultant_tbl':'nw_customer_tbl');
                $responce = $this->user_model->updateUser([
                    'user_id' => $userid,
                    'email'   => $this->input->post('user_email'),
                    'modified'=> date('Y-m-d H:i:s')
                ]);
                if(isset($updateresponse)){
                    if($userType == 'consultant'){
                        redirect(base_url('profile2'));
                    }else{
                        $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Profile has been updated successfully.'));
                        redirect(base_url('dashboard'));
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
        // if ($this->input->server('REQUEST_METHOD') === "POST") {
        //     $this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
        //     $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim|required|numeric|exact_length[10]');
        //     $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|required|numeric|exact_length[12]|is_unique[nw_consultant_tbl.aadhaar_card_number]');
        //     $this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|required|alpha_numeric|exact_length[10]|is_unique[nw_consultant_tbl.pan_card_number]');
        //     $this->form_validation->set_rules('expertise_text', 'Expertise', 'trim');
        //     $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[30]');
        //     $this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
        //     $this->form_validation->set_rules('experience', 'Experience', 'trim|max_lenght[50]');
        //     $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
        //     $this->form_validation->set_rules('user_aadhar_photo', 'Profile Picture', 'callback_userProflephoto');
        //     $this->form_validation->set_rules('user_pan_photo', 'Profile Picture', 'callback_userProflephoto');
        //     if ($this->form_validation->run()) {
        //         if (!empty($this->input->post('expertise_text'))) {
        //             $expertise = implode(',', $this->input->post('expertise_text'));
        //         } else {
        //             $expertise = "";
        //         }
        //         if (empty($this->input->post('subcategory_id'))) {
        //             $category = $this->input->post('category_id');
        //         } else {
        //             $category = $this->input->post('subcategory_id');
        //         }
        //         if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
        //             $filename = $_FILES['user_photo']['name'];
        //             $tmp_path = $_FILES['user_photo']['tmp_name'];
        //             $profilephoto = uploadImage($filename, $tmp_path, 'profile', '140');
        //         }else{
        //             $profilephoto = '';
        //         }
        //         if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
        //             $aadharname = $_FILES['aadhar_photo']['name'];
        //             $tmp_path1  = $_FILES['aadhar_photo']['tmp_name'];
        //             $aadharphoto= uploadImage($aadharname, $tmp_path1, 'consultant', '140');
        //         }else{
        //             $aadharphoto= '';
        //         }
        //         if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
        //             $panname = $_FILES['pan_photo']['name'];
        //             $tmp_path2  = $_FILES['pan_photo']['tmp_name'];
        //             $panphoto= uploadImage($panname, $tmp_path2, 'consultant', '140');
        //         }else{
        //             $panphoto= '';
        //         }
        //         $this->user_model->updateConsultantById('user_id', $id, [
        //             'category_id'       => $category,
        //             'telephone'         => $this->input->post('contact_number'),
        //             'photo'             => $profilephoto,
        //             'aadhaar_card_number'=> $this->input->post('aadhar_no'),
        //             'aadhaar_photo'     => $aadharphoto,
        //             'pan_card_number'   => $this->input->post('pan_no'),
        //             'pan_photo'         => $panphoto,
        //             'education'         => $this->input->post('education_text'),
        //             'expertise'         => $expertise,
        //             'experience'        => $this->input->post('experience'),
        //             'modified'          => date('Y-m-d H:i:s')
        //         ]);
        //         $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant has been created successfully.'));
        //         redirect(base_url($this->session->userdata('user_type') . '/consultant/consultant_list'));
        //     }
        // }
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
        $data['section_name'] = "Change Password";
        $data['page_title'] = $data['site_title'] = "Change Password";
        $data['pageUrl'] = $pageUrl = base_url('change-password');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="' . base_url($this->session->userdata('users')['user_type'] . '/dashboard') . '">Dashboard</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('old_password', 'Current Password', 'trim|required|callback_oldpassword_check');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[30]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            if ($this->form_validation->run()) {
               
                $responce = $this->user_model->updateRecordsById('id', $this->session->userdata('users')['user_id'], array('password' => md5($this->input->post('new_password'))));
                if (!empty($responce)) {
                     
                    //$this->user_model->update_wordpress_password(array('user_pass' => md5($this->input->post('new_password'))), $this->session->userdata('users')['user_email']);
                    $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Password has been updated successfully.'));
                } else {
                    $this->session->set_flashdata('responce_msg', array('class' => INFO_ALERT, 'short_msg' => 'Worning', 'message' => 'Something Went Wrong.'));
                    $this->session->set_flashdata('flash_msg', '');
                }
                redirect(base_url('change-password'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/change-password', $data, 'templates/left_adminMenu');
    }

    public function conversation() {
        $data['section_name']	= "Ticket Management";
        $data['page_title']  	= $data['site_title'] = "Conversation";
        $data['pageUrl']     	= $pageUrl = base_url('/ticket');
        $data['ticketid']    	= $ticketid = $this->uri->segment(3);
        $data['user_type']    	= $this->session->userdata('users')['user_type'];
		
        //$data['ticketid']    = $ticketid = $id;
		
		$userschatdata 			= $this->ticket_model->getChatAgainstTicket($ticketid,'','','',0,4);
		$data['usersdata']		= $this->ticket_model->getuserdatabyticketid($ticketid,$this->session->userdata('users')['user_type']);
		$chatdata 				= count($userschatdata);
		$data['chatdataslow']	= isset($userschatdata[$chatdata-1])?$userschatdata[$chatdata-1]->id:'';
		array_multisort($userschatdata, SORT_ASC );
		
		$data['chatdatas']		= 	isset($userschatdata[$chatdata-1])?$userschatdata[$chatdata-1]->id:'';
		
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/servicelist/?status=20">Assign List</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/conversation/' . $ticketid . '">' . $data['page_title'] . '</a></li></ol>';
		$isticket = [];
        if(!empty($ticketid)){
			$user_id 	= $this->session->userdata('users')['user_id'];
			$isticket 	= $this->ticket_model->checkticketavailable($ticketid);
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			redirect(base_url('ticket/servicelist/?status=20'));
		}
		if(!empty($isticket['data'])){
			$ticketChat = $this->ticket_model->getChatAgainstTicket($ticketid);
			$html = '<div class="direct-chat-messages">';
			$userType = ($this->session->userdata('users')['user_type']=='consultant')?3:2;
			
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
								<span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
								<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
							</div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
							<div class="direct-chat-text">'.$chatType.'</div></div>';
					}else{
						$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
						redirect(base_url('ticket/servicelist/?status=20'));
					}
				}
			}else{
				$html .= '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name float-right"></span><span class="direct-chat-timestamp float-left"></span></div><div class="direct-chat-text">No Record Available.</div></div>';
			}
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			redirect(base_url('ticket/servicelist/?status=20'));
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
					if($details->user_type == 4){
						$profileName = 'Agent '.$details->name;
					}else{
						$profileName = $details->name;
					}
					
                    $chatList = '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
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
					if($details->user_type == 4){
						$profileName = 'Agent '.$details->name;
					}else{
						$profileName = $details->name;
					}
                    $chatList .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$chatType.'</div></div>';
                }
            }
            $ajaxResponse=json_encode(array('datalist'=>$chatList,'status'=>$status,"massege"=>$massege,'style_color'=>$style_color));
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
        $sessionData 		= $this->session->userdata('users');
        $data['id'] 		= $id 			= $sessionData['user_id'];
        $data['user_type'] 	= $user_type 	= $sessionData['user_type'];
        $data['section_name'] 	= "Update Profile";
        $data['page_title'] 	= $data['site_title'] = "Company Information / Step 2";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
        $data['profile']  		= base_url('profile');
        $data['profile2'] 		= base_url('profile2');
        $data['profile3'] 		= base_url('profile3');
        $data['profile4'] 		= base_url('profile4');
        $data['profile5'] 		= base_url('profile5');
        $data['pageUrl'] 		= $pageUrl = base_url('profile2');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,($user_type=='consultant') ? 3 : 2);
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            //$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
            //$this->form_validation->set_rules('subcategory_id', 'Subcategory Name', 'trim|required');
            //$this->form_validation->set_rules('expertise_text', 'Expertise', 'trim');
            /* $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[30]');
            $this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
            $this->form_validation->set_rules('experience', 'Experience', 'trim|max_lenght[50]');
            $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto'); */
            
			$this->form_validation->set_rules('about_consultant', 'About Consultant', 'required|strip_tags');
			
            if ($this->form_validation->run()) {
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
                
				if(empty($this->input->post('cropped_banner'))){
					if(!empty($_FILES) && !empty($_FILES['banner_image']['name'])){
						$bannername 	= $_FILES['banner_image']['name'];
						$tmp_path3  	= $_FILES['banner_image']['tmp_name'];
						$bannerphoto	= uploadImage($bannername, $tmp_path3, 'consultant/banners');
					}else{
						$bannerphoto	= $usersData->banner_image;
					}
				}else{
					$bannerphoto	= $this->input->post('cropped_banner');
				}
				
                $this->user_model->updateConsultantById('user_id', $id, [
                    'banner_image'    		=> $bannerphoto,
                    'about_consultant'    	=> $this->input->post('about_consultant'),
                    'company_name'    		=> $this->input->post('company_name'),
                    'company_address'    	=> $this->input->post('company_address'),
                    'modified'          	=> date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant profile updated successfully.'));
                redirect(base_url('profile3'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile-step2', $data, 'templates/left_adminMenu');
    }
	public function updateProfile3(){
		//$data['id'] = $id = $this->uri->segment(4);
        $sessionData = $this->session->userdata('users');
        $data['id'] = $id = $sessionData['user_id'];
        $data['user_type'] = $user_type = $sessionData['user_type'];
        $data['section_name'] = "Update Profile";
        $data['page_title'] = $data['site_title'] = "Certification Information / Step 3";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
		$data['profile']  	= base_url('profile');
        $data['profile2'] 	= base_url('profile2');
        $data['profile3'] 	= base_url('profile3');
        $data['profile4'] 	= base_url('profile4');
        $data['profile5'] 	= base_url('profile5');
        $data['pageUrl'] 	= $pageUrl = base_url('profile3');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,($user_type=='consultant') ? 3 : 2);
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			if($this->input->post('aadhar_no') != $usersData->aadhaar_card_number){
                $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|numeric|exact_length[12]|is_unique[nw_consultant_tbl.aadhaar_card_number]');
            }
            if($this->input->post('pan_no') != $usersData->pan_card_number){
                 $this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|alpha_numeric|exact_length[10]|is_unique[nw_consultant_tbl.pan_card_number]');
            }
			$this->form_validation->set_rules('user_aadhar_photo', 'Profile Picture', 'callback_userProflephoto');
            $this->form_validation->set_rules('user_pan_photo', 'Profile Picture', 'callback_userProflephoto');
			if ($this->form_validation->run()) {
				if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
					$aadharname 	= $_FILES['aadhar_photo']['name'];
					$tmp_path1  	= $_FILES['aadhar_photo']['tmp_name'];
					$aadharphoto	= uploadImage($aadharname, $tmp_path1, 'consultant', '140');
				}else{	
					$aadharphoto	= $usersData->aadhaar_photo;
				}
				if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
					$panname 	= $_FILES['pan_photo']['name'];
					$tmp_path2  = $_FILES['pan_photo']['tmp_name'];
					$panphoto	= uploadImage($panname, $tmp_path2, 'consultant', '140');
				}else{
					$panphoto= $usersData->pan_photo;
				}
				
				$imagename 	= $_FILES['image']['name'][0];
				$allfile	= [];
				if(!empty($imagename)){
					$userdocuments = $this->uploadscertificate();
					if(!empty($userdocuments)){
						foreach($userdocuments as $userdocument){
							$allfile[] = $userdocument;
						}
					}
					$casefilename = $this->input->post('casefilename');
					$casefiledata =  [];
					$filearray 	  =  [];
					$filecounts	  = count($allfile);					
					for($i=0;$i<$filecounts;$i++){
						$filearray[$i]['file'] 		= $allfile[$i];
						$casefilenewname 			= ltrim($casefilename[$i]);
						$count 						= $i+1;
						$filearray[$i]['filename'] 	= !empty($casefilenewname)?$casefilenewname:'casefile '.$count;
					}
					if(!empty($usersData->certificates)){
						$oldfilearray = json_decode($usersData->certificates);
						$newfilearray = array_merge($oldfilearray,$filearray);
					}else{
						$newfilearray = $filearray;
					}
					$filename 	  = json_encode($newfilearray);
				}else{
					$filename = $usersData->certificates;
				} 
				$this->user_model->updateConsultantById('user_id', $id, [
						'aadhaar_card_number'	=> $this->input->post('aadhar_no'),
						'aadhaar_photo'     	=> $aadharphoto,
						'pan_card_number'   	=> $this->input->post('pan_no'),
						'pan_photo'         	=> $panphoto,
						'certificates' 			=> $filename,
						'modified'          	=> date('Y-m-d H:i:s')
					]);
				$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant profile updated successfully.'));
				redirect(base_url('profile4'));
			}
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile-step3', $data, 'templates/left_adminMenu');
    }
	public function updateProfile4(){
        //$data['id'] = $id = $this->uri->segment(4);
        $sessionData = $this->session->userdata('users');
        $data['id'] = $id = $sessionData['user_id'];
        $data['user_type'] = $user_type = $sessionData['user_type'];
        $data['section_name'] = "Update Profile";
        $data['page_title'] = $data['site_title'] = "Category & Sucategory Info / Step 4";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
        $data['profile']  	= base_url('profile');
        $data['profile2'] 	= base_url('profile2');
        $data['profile3'] 	= base_url('profile3');
        $data['profile4'] 	= base_url('profile4');
        $data['profile5'] 	= base_url('profile5');
		$data['pageUrl'] 	= $pageUrl = base_url('profile4');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,($user_type=='consultant') ? 3 : 2);
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant profile updated successfully.'));
			redirect(base_url('profile5'));
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile-step4', $data, 'templates/left_adminMenu');
    }
	public function updateProfile5(){
        //$data['id'] = $id = $this->uri->segment(4);
        $sessionData = $this->session->userdata('users');
        $data['id'] = $id = $sessionData['user_id'];
        $data['user_type'] = $user_type = $sessionData['user_type'];
        $data['section_name'] = "Update Profile";
        $data['page_title'] = $data['site_title'] = "Bank Information / Step 5";
       //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
		$data['profile']  	= base_url('profile');
        $data['profile2'] 	= base_url('profile2');
        $data['profile3'] 	= base_url('profile3');
        $data['profile4'] 	= base_url('profile4');
        $data['profile5'] 	= base_url('profile5');
        $data['pageUrl'] 	= $pageUrl = base_url('profile5');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory();
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($id,($user_type=='consultant') ? 3 : 2);
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			$response = $this->user_model->updateConsultantById('user_id', $id, [
						'verified_consultant' 	=> '1',
						'bank_name' 			=> $this->input->post('bank_name'),
						'account_no' 			=> $this->input->post('account_no'),
						'ifsc_code' 			=> $this->input->post('ifsc_code'),
						'accountholdername'		=> $this->input->post('accountholdername'),
						'modified'          	=> date('Y-m-d H:i:s')
					]);
			$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant profile updated successfully.'));
			redirect(base_url('dashboard'));
        }
        _manage_template('templates/header', 'templates/footer', 'templates/profile-step5', $data, 'templates/left_adminMenu');
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
		$userdata	= $this->session->userdata('users');
		$userid 	= '';
		if(!empty($userdata)){
			$userid = $userdata['user_id'];
		}
		$data 		= array(
						'read_status' => '1'
		); 
		$sections 	= $this->ticket_model->changereadstatus($data,$ticketid,$userid);
		$allchat 	= $this->ticket_model->getChatAgainstTicket($ticketid);
		$lastid 	= $allchat[0]->id;
		print_r($lastid);
		exit();
    } 
    public function userchat($ticketid){
		$sessionData = $this->session->userdata('users');
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
		$userType 		= ($this->session->userdata('users')['user_type']=='consultant')?3:2;
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
					$msg_to = '';
					if($userType == '3'){
						$msg_to = $ticketData->customer_id;
					}else{
						$msg_to = $ticketData->consultant_id;
					}
					if(!empty($this->input->post('message'))){
						$insertArry = $this->ticket_model->createChat(array(
							'ticket_id'   	=> $ticketid,
							'user_id'     	=> $this->session->userdata('users')['user_id'],
							'msg_to'   		=> $msg_to,
							'msg_from'   	=> $this->session->userdata('users')['user_id'],
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
							<span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
							<span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($insertArry->created_at)).'</span></div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/><div class="direct-chat-text">'.$insertArry->chat_massege.'</div></div>';
					}

					if (!empty($_FILES) && !empty($_FILES['upload_file']['name'])) {
						$filename  = $_FILES['upload_file']['name'];
						$tmp_path  = $_FILES['upload_file']['tmp_name'];
						$image_name= uploadImage($filename, $tmp_path, 'conversation');
						$insertArry= $this->ticket_model->createChat(array(
							'ticket_id'   	=> $ticketid,
							'user_id'     	=> $this->session->userdata('users')['user_id'],
							'msg_to'   		=> $msg_to,
							'msg_from'   	=> $this->session->userdata('users')['user_id'],
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
						
						//$chatType = ($insertArry->chat_type =='file') ? '<a href="'.base_url('uploads/conversation/'.$insertArry->chat_massege).'" alt="'.$insertArry->chat_massege.'" title="Click to view this file" target="_blank"><i class="fa fa-paperclip" style="font-size:24px;" title="Attachment"></i>&nbsp;&nbsp;<i class="fa fa-eye" style="font-size:24px;"></i></a>': $insertArry->chat_massege;
						if($details->user_type == 4){
							$profileName = 'Agent '.$details->name;
						}else{
							$profileName = $details->name;
						}
						$chatList = '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
							<span class="direct-chat-name '.$floatname.'">'.$profileName.'</span>
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
			$userType 		= ($this->session->userdata('users')['user_type']=='consultant')?3:2;
			$html = '';
			if(!empty($chatdetails)){
				array_multisort($chatdetails, SORT_ASC );
				$endchat = end($chatdetails);
				$countchat = count($chatdetails);
				if($endchat->id > $chatdatashigh){
					foreach ($chatdetails as $key => $value) {
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
			$usersession 	= $this->session->userdata('users');
			$user_id 	 	= $usersession['user_id'];
			$chatdetails  	= $this->ticket_model->getallnewnotification($user_id);
			$notificationlist = '';
			if(!empty($chatdetails['data'])){
				$counter = 1;
				foreach($chatdetails['data'] as $allnotifications){
					$username = '';
					if($usersession['user_type'] == 'consultant'){
						$customerdetails  = $this->user_model->getUserDetailsById($allnotifications->msg_from,'2');
						$username = isset($customerdetails->name)?$customerdetails->name:'';
					}else{
						$chatusertype  = $this->user_model->getDataBykey('nw_user_tbl', 'id',$allnotifications->msg_from, 'user_type');					
						$consultantdetails  = $this->user_model->getUserDetailsById($allnotifications->msg_from,$chatusertype->user_type);	
						if($consultantdetails->user_type == '4'){
							$username =  isset($consultantdetails->name)? 'Agent ' .$consultantdetails->name:'';
						}else{
							$username = isset($consultantdetails->name)?$consultantdetails->name:'';
						}
					}
					if($counter <= 5 ){
						$ticketurl = base_url() . "ticket/conversation/" .$allnotifications->id;
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

        $data['section_name'] 	= "Service Management";
        $data['page_title'] 	= $data['site_title'] = "Service Request";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket');
		$newticketlisturl		=  base_url('ticket/servicelist/?status=10');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $newticketlisturl . '">' . $data['page_title'] . '</a></li></ol>';
		//$ignore_status_code 	= array(90,91);
        $data['tickets'] 		= $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'],'','tickets.id','desc','10','1','new');
		$usersession 				= $this->session->userdata('users');
		$data['lastcreatedticket'] 	= $lastcreatedticket = $this->ticket_model->userticketdata($usersession['user_id']);
        _manage_template('templates/header', 'templates/footer', 'ticket/ticket_list', $data, 'templates/left_adminMenu');
    }
	public function agent_list(){
		$data['section_name'] = "Agent Management";
        $data['page_title'] = $data['site_title'] = "All Agent";
        //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/agent');
        $data['pageUrl'] 	= $pageUrl = base_url('/agent');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/agent">' . $data['page_title'] . '</a></li>'
                . '</ol>';
		$sessionData = $this->session->userdata('users');
		$id 		 = $sessionData['user_id'];
		$user_type 	 = $sessionData['user_type'];
        $data['response']   = $this->user_model->getAgentUserList('4', '', '', '', 'users.id', 'desc','',$id);
        //$data['newt']       = $this->user_model->getCountOfticketstatus('3', '', '', '', 'users.id', 'desc');
       
        //$this->load->view('consultant_list', $data);

        _manage_template('templates/header', 'templates/footer', 'agents/list', $data, 'templates/left_adminMenu');
	}
	public function addagent(){
		$data['section_name']   = "Agent Management";
        $data['page_title']     = $data['site_title'] = "Create Agent";
        $data['pageUrl']        = $pageUrl = base_url($this->session->userdata('user_type') . '/agent/addagent');
        $data['breadcrumb']     = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/aggent') . '">Agent</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['countryList']    = $this->user_model->getCountryList();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('user_name', 'Agent Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
            $this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|is_unique[nw_user_tbl.email]');
            //$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_message('is_unique', 'Email ID already registered!');
            $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required');
            $this->form_validation->set_rules('user_dob', 'Date Of Birth', 'trim|callback_validateAge');
            $this->form_validation->set_rules('user_country', 'Country', 'trim');
            $this->form_validation->set_rules('user_state', 'State', 'trim');
			$this->form_validation->set_rules('user_city', 'City', 'trim|min_length[2]|xss_clean|alpha_numeric_spaces');			
            $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[50]');
            $this->form_validation->set_rules('pin_code', 'Pincode', 'trim|numeric|exact_length[6]');
            $this->form_validation->set_rules('user_gender', 'Gender', 'trim');
            $this->form_validation->set_rules('user_status', 'Status', 'trim');
            $randompass = randomPassword();
			//echo '<pre>'; print_r($randompass); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
            if ($this->form_validation->run()) {
				$user_email  = $this->input->post('user_email');
				//$wpuserexist = $this->user_model->checkwpusersexist($user_email);
				//if(empty($wpuserexist->user_email)){
					$responce = $this->user_model->createNewUsers('nw_user_tbl', [
							'user_type'    		=> 4,
							'email'        		=> $this->input->post('user_email'),
							'password'     		=> md5($randompass),
							'status'       		=> $this->input->post('user_status'),
							'created'      		=> date('Y-m-d H:i:s'),
							'last_login'   		=> date('Y-m-d H:i:s'),
							'login_status' 		=> 0,
							'activation_code'	=> md5('test@123')
						]
					);
					if ($responce) {
						$countrydata = $this->user_model->getCountryList($this->input->post('user_country'));
						$countryName = ($countrydata !='') ? $countrydata->name:'';
						$stateList   = $this->user_model->getStateList($this->input->post('user_state'));
						$stateName   = ($stateList !='') ? $stateList->name:'';
						$cityName    = $this->input->post('customer_city');
						$getGeoData  = _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
						//$dob         = date('Y-m-d',strtotime($this->input->post('user_dob')));
						if(!empty($this->input->post('user_dob'))){
							$dob = date('Y-m-d', strtotime($this->input->post('user_dob')));
						}else{
							$dob = date('Y-m-d', strtotime('-18 years'));
						}
						$sessionData 	= $this->session->userdata('users');
						$user_id 		= $sessionData['user_id'];
						$user_type 		= $sessionData['user_type'];
						$consultantData = $this->user_model->getUserDataById($user_id,$user_type);
						
						$user_name 		= $this->input->post('user_name');
						$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
						$lowercaseTitle = strtolower($new_string); 
						$ucTitleString 	= ucwords($lowercaseTitle);
						
						$user_mobile	= $this->input->post('user_mobile');
						$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $user_mobile);
						$mobile 		= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
						
						$createagent = $this->user_model->createNewUsers('nw_agent_tbl', [
								'user_id'  	 	=> $responce,
								'consultant_id' => $user_id,
								'name'      	=> $ucTitleString,
								'dob'       	=> $dob,
								'gender'    	=> $this->input->post('user_gender'),
								'address'   	=> $this->input->post('user_address'),
								'country_id'	=> $this->input->post('user_country'),
								'state_id'  	=> $this->input->post('user_state'),
								'city_id'   	=> $this->input->post('user_city'),
								'zip'       	=> $this->input->post('pin_code'),
								'mobile'    	=> $mobile,
								'photo'     	=> '',
								'latitude'  	=> ($getGeoData !='') ? $getGeoData['lat']:'',
								'longitude' 	=> ($getGeoData !='') ? $getGeoData['long']:'',
								'status'    	=> 1,
								'account_type'	=> $this->input->post('account_type'),
								'created'   	=> date('Y-m-d H:i:s')
							]
						);
						
						if(!empty($createagent)){
							$subject= "File Notice- Agent Registration";
								$name   = ucfirst($this->input->post('user_name'));
								$email  = $this->input->post('user_email');
								/* $message='Hello '.$this->input->post('user_name').',<br><br>Welcome to Filenotice.com.<br><br> You have register on my portal.<br><br><br>Your login detail is <br><br> Username : '.$this->input->post('user_email').'<br>Password : '.$randompass.' Thanks'; */
								$loginurl = FRONTEND_URL .'/login';
								$msg = $this->getMailData($name,$email,$randompass,$loginurl);
								$from = "Filenotice <coffee@filenotice.com>";
								$header = "From: $from\r\n";
								$header .= "Content-type: text/html; charset=utf-8";

								$responsemail = mail($email,$subject,$msg,$header);
								
								$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Agent creation step1 completed successfully.'));
								redirect(base_url($this->session->userdata('user_type') . '/agent/addagent_info/' . $responce));
						}else {
							$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
						}
					}else {
						$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
					}
				/* }else{
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'Email is already exist.'));
					redirect(base_url($this->session->userdata('user_type') . '/agent/addagent'));
				} */
            }
        }
        _manage_template('templates/header', 'templates/footer', 'agents/create', $data, 'templates/left_adminMenu');
	}
	public function addagent_info(){
		$data['id'] 		= $id = $this->uri->segment(3);
        $data['section_name'] = "Agent Management";
        $data['page_title'] = $data['site_title'] = "Create Agent";
        $data['pageUrl'] 	= $pageUrl = base_url('/agent/addagent_info');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url('/agent') . '">Agent</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  = $this->expertise_model->listExpertise('1');
        $data['category']   = $this->category_model->getParentCategory('1');
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            //$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
            //$this->form_validation->set_rules('subcategory_id', 'Subcategory Name', 'trim|required');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'trim');
            $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|numeric|exact_length[12]|is_unique[nw_consultant_tbl.aadhaar_card_number]');
            $this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|alpha_numeric|exact_length[10]|is_unique[nw_consultant_tbl.pan_card_number]');
            //$this->form_validation->set_rules('expertise_text', 'Expertise', 'trim');
            $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[30]');
            $this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
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
                if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
                    $filename = $_FILES['user_photo']['name'];
                    $tmp_path = $_FILES['user_photo']['tmp_name'];
                    $profilephoto = uploadImage($filename, $tmp_path, 'profile', '140');
                }else{
                    $profilephoto = '';
                }
                if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
                    $aadharname = $_FILES['aadhar_photo']['name'];
                    $tmp_path1  = $_FILES['aadhar_photo']['tmp_name'];
                    $aadharphoto= uploadImage($aadharname, $tmp_path1, 'consultant/agent', '140');
                }else{
                    $aadharphoto= '';
                }
                if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
                    $panname = $_FILES['pan_photo']['name'];
                    $tmp_path2  = $_FILES['pan_photo']['tmp_name'];
                    $panphoto= uploadImage($panname, $tmp_path2, 'consultant/agent', '140');
                }else{
                    $panphoto= '';
                }
				$sessionData 	= $this->session->userdata('users');
				$user_id 		= $sessionData['user_id'];
				$user_type 		= $sessionData['user_type'];
				$consultantData = $this->user_model->getUserDataById($user_id,$user_type);
				if(isset($consultantData)){
					$category_id 	= $consultantData->category_id;
					$subcategory_id = $consultantData->subcategory_id;
				}else{
					$category_id 	= 0;
					$subcategory_id = 0;
				}
                $experience_yr 	= $this->input->post('experience_yr');
                $experience_mn 	= $this->input->post('experience_mn');
                $experience    	= $experience_yr.' ' .$experience_mn;
				$contact_number	= $this->input->post('contact_number');
				$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $contact_number);
				$mobilenumber	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
				
                $this->user_model->updateAgentById('user_id', $id, [
                    'category_id'       => $category_id,
                    'subcategory_id'    => $subcategory_id,
                    'telephone'         => $mobilenumber,
                    'photo'             => $profilephoto,
                    'aadhaar_card_number'=> $this->input->post('aadhar_no'),
                    'aadhaar_photo'     => $aadharphoto,
                    'pan_card_number'   => $this->input->post('pan_no'),
                    'pan_photo'         => $panphoto,
                    'education'         => $this->input->post('qualification'),
                    'sub_education'     => $this->input->post('sub_qualification'),
                    'expertise'         => $expertise,
                    'experience'        => $experience,
                    'modified'          => date('Y-m-d H:i:s')
                ],'nw_agent_tbl');
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Agent has been created successfully.'));
                redirect(base_url('/agent'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'agents/create_info', $data, 'templates/left_adminMenu');
	}
	public function agentview() {
        $id = $this->uri->segment(3);
        if(empty($id)){
            redirect(base_url('/agent'));
        };
        $data['section_name']= "Agent Management";
        $data['page_title']  = $data['site_title'] = "Agent Detail";
        $data['pageUrl']     = $pageUrl = base_url('/agent/agentview/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url('/agent') . '">Agent</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['row'] = $consultant= $this->user_model->getUserDetailsById($id,'4');
		if(!empty($data['row'])){
			$expertise = '';
			if(!empty($consultant)){
				$expertIds = explode(',',$consultant->expertise);
				foreach($expertIds as $key=>$value){
					$exName = $this->user_model->getExpertiseById($value);
					if(!empty($exName)){
						$expertise .= $exName->name.', ';
					}
				}
			}
			$data['expertise'] = removeCommaFromLast($expertise, ', ');
			_manage_template('templates/header', 'templates/footer', 'agents/view', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/agent'));
		}
    }
	public function editagent() {
        $id = $this->uri->segment(3);
        if(empty($id)){
            redirect(base_url('/agent'));
        }
        $data['section_name'] = "Agent Management";
        $data['page_title'] = $data['site_title'] = "Edit Agent";
        $data['pageUrl'] 	= $pageUrl = base_url('/agent/editagent/'.$id);
        $data['edit_info'] 	= $edit_info = base_url('/agent/editagent_info/'.$id);
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url('/agent') . '">Agent</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['consultant'] = $this->user_model->getUserDetailsById($id,'4');
		if(!empty($data['consultant'])){
			$data['expertise'] = $this->expertise_model->listExpertise();
			$data['category']  = $this->category_model->getParentCategory('1');
			$data['countryList'] 	= $this->user_model->getCountryList();
			$data['stateList'] 		= $this->user_model->getStateList();
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$this->form_validation->set_rules('user_name', 'Agent Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
				$this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|callback_validateEmail['.$id.']');
				$this->form_validation->set_rules('password', 'Password', 'min_length[6]');
				$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
				$this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required');
				$this->form_validation->set_rules('user_dob', 'Date Of Birth', 'trim|callback_validateAge');
				$this->form_validation->set_rules('user_country', 'Country', 'trim');
				$this->form_validation->set_rules('user_state', 'State', 'trim');
				$this->form_validation->set_rules('user_city', 'City', 'trim||min_length[2]|xss_clean|alpha_numeric_spaces');
				$this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[100]');
				$this->form_validation->set_rules('pin_code', 'Pincode', 'trim|numeric|exact_length[6]');
				$this->form_validation->set_rules('user_gender', 'Gender', 'trim');
				$this->form_validation->set_rules('user_status', 'Status', 'trim');
				if ($this->form_validation->run()) {
					$countrydata= $this->user_model->getCountryList($this->input->post('user_country'));
					$countryName= ($countrydata !='') ? $countrydata->name:'';
					$stateList  = $this->user_model->getStateList($this->input->post('user_state'));
					$stateName  = ($stateList !='') ? $stateList->name:'';
					$cityName   = $this->input->post('customer_city');
					$getGeoData = _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
					//$dob        = date('Y-m-d',strtotime($this->input->post('user_dob')));
					if(!empty($this->input->post('user_dob'))){
						$dob = date('Y-m-d', strtotime($this->input->post('user_dob')));
					}else{
						$dob = date('Y-m-d', strtotime('-18 years'));
					}
					$user_mobile	= $this->input->post('user_mobile');
					$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $user_mobile);
					$mobile			= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
					$user_name 		= $this->input->post('user_name');
					$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
					$lowercaseTitle = strtolower($new_string); 
					$ucTitleString 	= ucwords($lowercaseTitle);
					$consultArry = [
						'name'          => $ucTitleString,
						'account_type'  => $this->input->post('account_type'),
						'mobile'        => $mobile,
						'dob'           => $dob,
						'country_id'    => $this->input->post('user_country'),
						'state_id'      => $this->input->post('user_state'),
						'city_id'       => $this->input->post('user_city'),
						'address'       => $this->input->post('user_address'),
						'zip'           => $this->input->post('pin_code'),
						'gender'        => $this->input->post('user_gender'),
						'latitude'      => ($getGeoData !='') ? $getGeoData['lat']:'',
						'longitude'     => ($getGeoData !='') ? $getGeoData['long']:'',
						'modified'      => date('Y-m-d H:i:s')
					];
					$this->user_model->updateAgentById('user_id', $id, $consultArry, 'nw_agent_tbl');
					
					$user_data = array(
						'user_id'   => $id,
						'status'    => (int)$this->input->post('user_status'),
						'email'     => $this->input->post('user_email'),
						'modified'  => date('Y-m-d H:i:s')
						);
					if(!empty($this->input->post('password'))) {
						$user_data['password'] = md5($this->input->post('password'));
					}
					$responce = $this->user_model->updateUser($user_data);
					
					$wordpress_data = array(
							'user_login' => $this->input->post('user_email'),
							'user_email' => $this->input->post('user_email')
						);
					if(!empty($this->input->post('password'))) {
						$wordpress_data['user_pass'] = md5($this->input->post('password'));
					}
					//$this->user_model->update_wordpress_user($wordpress_data, $this->input->post('user_email'));
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Agent Step1 info has been created successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/agent/editagent_info/'.$id));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'agents/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/agent'));
		}
    }
    public function editagent_info() {
        $id = $this->uri->segment(3);
        if(empty($id)){
            redirect(base_url('/agent'));
        }
        $data['section_name']= "Agent Management";
        $data['page_title']  = $data['site_title'] = "Edit Agent";
        $data['pageUrl']     = $pageUrl = base_url('/agent/editagent_info/'.$id);
        $data['edit']        = $edit = base_url('/agent/editagent/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url('agent') . '">Agent</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['consultant'] = $agentdata = $this->user_model->getUserDetailsById($id,'4');
		if(!empty($data['consultant'])){
			$data['expertise']  = $this->expertise_model->listExpertise('1');
			$data['category']   = $this->category_model->getParentCategory('1');
			$data['countryList']= $this->user_model->getCountryList();
			$data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				//$this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
				//$this->form_validation->set_rules('subcategory_id', 'Subcategory Name', 'trim|required');
				$this->form_validation->set_rules('contact_number', 'Contact Number', 'trim');
			   // $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|numeric|exact_length[12]|is_unique[nw_consultant_tbl.aadhaar_card_number]');
			   // $this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|alpha_numeric|exact_length[10]|is_unique[nw_consultant_tbl.pan_card_number]');
				 $this->form_validation->set_rules('aadhar_no', 'Aadhar Card Number', 'trim|numeric|exact_length[12]');
				$this->form_validation->set_rules('pan_no', 'Pan Card Number', 'trim|alpha_numeric|exact_length[10]');
				//$this->form_validation->set_rules('expertise_text', 'Expertise', 'trim');
				$this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[30]');
				$this->form_validation->set_rules('education_text', 'Education', 'trim|max_lenght[30]');
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
					$experience_yr = $this->input->post('experience_yr');
					$experience_mn = $this->input->post('experience_mn');
					$experience    = $experience_yr.' ' .$experience_mn;
				   /* if (empty($this->input->post('subcategory_id'))) {
						$category = $this->input->post('category_id');
					} else {
						$category = $this->input->post('subcategory_id');
					} */
					if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
						$filename = $_FILES['user_photo']['name'];
						$tmp_path = $_FILES['user_photo']['tmp_name'];
						$profilephoto = uploadImage($filename, $tmp_path, 'profile', '140');
					}else{
						$profilephoto = $agentdata->photo;
					}
					if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
						$aadharname = $_FILES['aadhar_photo']['name'];
						$tmp_path1  = $_FILES['aadhar_photo']['tmp_name'];
						$aadharphoto= uploadImage($aadharname, $tmp_path1, 'consultant/agent', '140');
					}else{
						$aadharphoto= $agentdata->aadhaar_photo;
					}
					if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
						$panname = $_FILES['pan_photo']['name'];
						$tmp_path2  = $_FILES['pan_photo']['tmp_name'];
						$panphoto= uploadImage($panname, $tmp_path2, 'consultant/agent', '140');
					}else{
						$panphoto= $agentdata->pan_photo;
					}
					$sessionData 	= $this->session->userdata('users');
					$user_id 		= $sessionData['user_id'];
					$user_type 		= $sessionData['user_type'];
					$consultantData = $this->user_model->getUserDataById($user_id,$user_type);
					if(isset($consultantData)){
						$category_id 	= $consultantData->category_id;
						$subcategory_id = $consultantData->subcategory_id;
					}else{
						$category_id 	= 0;
						$subcategory_id = 0;
					}
					$contact_number	= $this->input->post('contact_number');
					$contactstr 	= preg_replace("/[^A-Za-z0-9 ]/", '', $contact_number);
					$mobilenumber	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $contactstr);
					
					$this->user_model->updateAgentById('user_id', $id, [
						'category_id'       	=> $category_id,
						'subcategory_id'    	=> $subcategory_id,
						'telephone'         	=> $mobilenumber,
						'photo'             	=> $profilephoto,
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
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Agent Step2 info has been edited successfully.'));
					redirect(base_url('/agent'));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'agents/edit_info', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url('/agent'));
		}
    }
	public function getMailData($name,$email,$password,$loginurl){
        $html = '';
        $html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
          $html .= '<tbody>';
            $html .= '<tr>';
              $html .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f8f8f8" style="font-family:helvetica, sans-serif;" class="MainContainer">';
                  $html .= '<tbody>';
                    $html .= '<tr>';
                      $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                          $html .= '<tbody>';
                            $html .= '<tr>';
                              $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                                  $html .= '<tbody>
                                    <tr>
                                      <td class="movableContentContainer"><div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody style="background-color:#222">
                                              <tr>
                                                <td height="15"></td>
                                              </tr>
                                              <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                      <tr>
                                                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                              <tr>
                                                                <td valign="top" width="" style="padding-left:15px;text-align: center;"><a href="'.FRONTEND_URL.'"><img src="'.FRONTEND_URL.'uploads/settings/logo.png" width="auto" height="45"></a></td>
                                                              </tr>
                                                            </tbody>
                                                          </table></td>
                                                      </tr>
                                                    </tbody>
                                                  </table></td>
                                              </tr>
                                              <tr>
                                                <td height="15"></td>
                                              </tr>
                                            </tbody>
                                          </table>';
                                        $html .= '</div>';
                                        $html .= '<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:0 15px; border:1px solid #b6b6b6">
                                            <tbody>
                                              <tr>
                                                <td height="18"></td>
                                              </tr>
                                              <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                      <tr>
                                                        <td class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                                            <div class="contentEditable" style="text-align: left;">';
                                                              $html .= '<h2 style="font-size: 20px;font-family:helvetica, sans-serif;">Dear '.$name.',</h2>';
                                                              $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000; margin-left:20px;"> <span style="font-family:helvetica, sans-serif;color:#000000;">Your new account has been created. Welcome to Filenotice.com</span><br /><span>For now, please login using given Password and change the password for security.</span><br/>';
                                                                $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Thanks for registration.</span><br />';
                                                                $html .= '<br/>';
                                                                
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;"> Your login details are </span> <br />';
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Email Id: '.$email.'</span> <br />';
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Password : '.$password.'</span> <br />';
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to login : <a href="'.$loginurl.'" target="_blank">'.$loginurl.'</a></span><br />';
																 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">For any help, please contact us at: <a href="mailto:coffee@hashtaglabs.biz">coffee@hashtaglabs.biz</a></span><br />';
																 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Hope you will have benefit from our services.</span><br />';
                                                                $html .= '<br/>';
                                                              $html .= '<br>
                                                            </div>
                                                          </div></td>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Regards,</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Administrator</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Filenotice</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle">&nbsp;</td>
                                                      </tr>
                                                    </tbody>
                                                  </table></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table style="background-color: #272727;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                              <tr>
                                                <td height="8"></td>
                                              </tr>
                                              <tr>
                                                <td height="8"><div class="contentEditableContainer contentTextEditable">
                                                    <div class="contentEditable" style="text-align: center;color:#AAAAAA;">
                                                      <p style="margin:2px 0; font-size:10px;"> &copy; '.date("Y").' Filenotice </p>
                                                    </div>
                                                  </div></td>
                                              </tr>
                                              <tr>
                                                <td height="8"></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table>';
        return  $html;
    }
	public function updateAgentRecords() {
        $id 	= $this->input->post('uid');
        $status = $this->input->post('status');
        $action = $this->input->post('action');
        $table 	= $this->input->post('table');
		$email 	= $this->input->post('email');
        $name 	= $this->input->post('name');
        if ($action == 'delete') {
           /*  $return = $this->user_model->deleteUsers($id, 'nw_consultant_tbl');
            $status = true;
            $message = 'Record has been Successfully deleted.';
            $style_color = 'green';
            $redirectURL = base_url($this->session->userdata('user_type') . '/consultant/consultant_list'); */
        } else {
            if($status=='1'){
                $statuss = 0;
                $emailstatus = 0;
            }else{
                $statuss = 1;
                $emailstatus = 1;
            }
			$userData 	= $this->user_model->getDataBykey('nw_user_tbl','id',$id,'email_status');
			$agentData 	= $this->ticket_model->getagenttabledata('agent_id',$id,'nw_agent_ticket_map_tbl','DISTINCT(consultant_id),ticket_id');
			$newagentdata = $agentData['data'];
			$email_status = $userData->email_status;
			if($email_status == 1){
				$url = FRONTEND_URL;       
				$link = $url."/login"; 
				$to = $email;
				$subject="File Notice- Account Approved";
				//$message='Hello '.$name.',<br><br>Welcome to Filenotice.com.<br><br>Your profile has been activated. Complete your profile by updating your information.Please click on the link given below:</br></br>
				$message = $this->getAproveMailData($name,'','',$link);
				$from 	= "Filenotice <coffee@filenotice.com>";
				$header = "From: $from\r\n";
				$header .= "Content-type: text/html; charset=utf-8";
				mail($to,$subject,$message,$header);
			}
            $return = $this->user_model->updateUser(array('user_id' => (int) $id, "status" => $statuss, "email_status" => $emailstatus));
			if($return){
				$returnagent = $this->user_model->updateAgentUser(array('user_id' => (int) $id, "status" => $statuss));
				if($returnagent){
					foreach($newagentdata as $agentdetail){
						$returndata = $this->ticket_model->updateAgentRecordsByticketid($agentdetail->ticket_id,$agentdetail->consultant_id,array('assign_agent_status' => '10'),'nw_ticket_map_tbl');
						if($returndata){
							$returndata = $this->ticket_model->updateAgentRecordsByticketid($agentdetail->ticket_id,$agentdetail->consultant_id,array('ticket_status' => '90'),'nw_agent_ticket_map_tbl');
						}
					}
				}
				$status 	 = true;
				$message 	 = 'Status has been updated successfully.';
				$style_color = 'green';
				$redirectURL = base_url('/agent');
			}
        }
        $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
        echo $ajaxResponse;
    }
	public function getAproveMailData($name,$email,$password,$loginurl){
        $html = '';
        $html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
          $html .= '<tbody>';
            $html .= '<tr>';
              $html .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f8f8f8" style="font-family:helvetica, sans-serif;" class="MainContainer">';
                  $html .= '<tbody>';
                    $html .= '<tr>';
                      $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                          $html .= '<tbody>';
                            $html .= '<tr>';
                              $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
                                  $html .= '<tbody>
                                    <tr>
                                      <td class="movableContentContainer"><div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tbody style="background-color:#222">
                                              <tr>
                                                <td height="15"></td>
                                              </tr>
                                              <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                      <tr>
                                                        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tbody>
                                                              <tr>
                                                               <td valign="top" width="" style="padding-left:15px;text-align: center;"><a href="'.FRONTEND_URL.'"><img src="'.FRONTEND_URL.'uploads/settings/logo.png" width="auto" height="45"></a></td>
                                                              </tr>
                                                            </tbody>
                                                          </table></td>
                                                      </tr>
                                                    </tbody>
                                                  </table></td>
                                              </tr>
                                              <tr>
                                                <td height="15"></td>
                                              </tr>
                                            </tbody>
                                          </table>';
                                        $html .= '</div>';
                                        $html .= '<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:0 15px; border:1px solid #b6b6b6">
                                            <tbody>
                                              <tr>
                                                <td height="18"></td>
                                              </tr>
                                              <tr>
                                                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                      <tr>
                                                        <td class="specbundle"><div class="contentEditableContainer contentTextEditable">
                                                            <div class="contentEditable" style="text-align: left;">';
                                                              $html .= '<h2 style="font-size: 20px;font-family:helvetica, sans-serif;">Dear '.$name.',</h2>';
                                                              $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000; margin-left:20px;"> <span style="font-family:helvetica, sans-serif;color:#000000;">Welcome to Filenotice.com</span><br /><span>Your request to access filenotice.com approved.</span><br/><span>Login with  the valid registered credentials.</span><br/>';
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to login : <a href="'.$loginurl.'" target="_blank">'.$loginurl.'</a></span><br />';
                                                              $html .= '<br>
                                                            </div>
                                                          </div></td>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Regards,</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Administrator</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Filenotice</td>
                                                      </tr>
                                                      <tr>
                                                        <td class="specbundle">&nbsp;</td>
                                                      </tr>
                                                    </tbody>
                                                  </table></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                        <div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                          <table style="background-color: #272727;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                              <tr>
                                                <td height="8"></td>
                                              </tr>
                                              <tr>
                                                <td height="8"><div class="contentEditableContainer contentTextEditable">
                                                    <div class="contentEditable" style="text-align: center;color:#AAAAAA;">
                                                      <p style="margin:2px 0; font-size:10px;"> &copy; '.date("Y").' Filenotice </p>
                                                    </div>
                                                  </div></td>
                                              </tr>
                                              <tr>
                                                <td height="8"></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div></td>
                                    </tr>
                                  </tbody>
                                </table></td>
                            </tr>
                          </tbody>
                        </table></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </tbody>
        </table>';
        return  $html;
    }
	public function assignagent() {
        $id = $this->uri->segment(3);
        if(empty($id)){
            redirect(base_url('ticket/servicelist/?status=20'));
        }
        $data['section_name'] 	= "Ticket Management";
        $data['ticket'] 		= $ticketdata = $this->ticket_model->getTicketById($id);
		if(!empty($ticketdata)){
			$data['customer_city'] 	= $customer_city 	= $ticketdata->customer_city;
			$data['customer_state'] = $customer_state 	= $ticketdata->customer_state;
			$data['agent'] 		= $this->user_model->getUserListbycitystate('4','','','','','','1',$customer_city,$customer_state);
			$data['pageUrl'] 	= $pageUrl = base_url('/ticket');
			$data['page_title'] = $data['site_title'] = "Assign Ticket";
			$data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
			. '<li class="breadcrumb-item"><a href="'.$pageUrl.'/servicelist/?status=20">Assign</a></li>'
			. '<li class="breadcrumb-item"><a href="'.$pageUrl.'/assignagent/'.$id.'">'.$data['page_title'].'</a></li></ol>';	
			$sessionData 	 = $this->session->userdata('users');
			$data['user_id'] = $user_id = $sessionData['user_id'];			
			if ($this->input->server('REQUEST_METHOD') === "POST"){
				$this->form_validation->set_rules('agent_id', 'Agent', 'trim|required');
				//$this->form_validation->set_rules('assign_date', 'Assign Date', 'trim|required');
				 if ($this->form_validation->run()) {
					//$assign_date = date('Y-m-d', strtotime($this->input->post('assign_date')));
					$assign_date = date('Y-m-d');
					$data = array(
						'ticket_id'    	=> $id,
						'consultant_id'	=> $user_id,
						'customer_id'  	=> $this->input->post('customer_id'),
						'agent_id'  	=> $this->input->post('agent_id'),
						'assign_date'  	=> $assign_date,
						'ticket_status'	=> '20',
						'status'       	=> '1',
						'created'      	=> date('Y-m-d H:i:s')
					);
					$response = $this->ticket_model->insertAgentTicketMap($data);
					if($response){
						$data = array(
							'assign_agent_status'=> '20',
						);
						$this->ticket_model->updateticketmaptblbyticketid($id,$data);
					}        
					/*=======Update Start Time=======*/
					
					//$this->ticket_model->UpdateTicketStartTime($id,$assign_date);
				   
					/*=======Update Start Time=======*/
					
					if ($response) {
						$agent_id 		= $this->input->post('agent_id');
						$agentDetail	= $this->user_model->getUserDetailsById($agent_id,'4');
						$name 	= '';
						$to 	= '';
						if(!empty($agentDetail)){
							$to 	= $agentDetail->email;
							$name 	= $agentDetail->name;
						}
						$loginlink  = FRONTEND_URL.'/login';
						$subject	= "File Notice- Ticket Assigned";
						//$message 	= 'Hello '.$name.',<br><br>Welcome to Filenotice.com.<br><br> You have assigned a ticket.<br><br><br>Thanks';
						$ticket_id 	 = $ticketdata->ticket_id;
						$description = $ticketdata->description;
						$msg 		= $this->getAgentAssignMailData($name,$ticket_id,$description,$loginlink);
						$from 		= "Filenotice <coffee@filenotice.com>";
						$header 	= "From: $from\r\n";
						$header 	.= "Content-type: text/html; charset=utf-8";
						$responsemail = mail($to,$subject,$msg,$header);
						if(isset($responsemail)){
							$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Ticket assigned successfully to agent.'));
							redirect($pageUrl.'/servicelist/?status=20');
						}
					}
				} 
			}
			_manage_template('templates/header', 'templates/footer', 'ticket/assign_agent', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'ERROR','message'=>'No Data Found.'));
			redirect('ticket/servicelist/?status=20');
		}
    }
	public function getAgentAssignMailData($name,$ticketid,$description,$loginlink){
		$html = '';
		$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
		  $html .= '<tbody>';
			$html .= '<tr>';
			  $html .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f8f8f8" style="font-family:helvetica, sans-serif;" class="MainContainer">';
				  $html .= '<tbody>';
					$html .= '<tr>';
					  $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
						  $html .= '<tbody>';
							$html .= '<tr>';
							  $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
								  $html .= '<tbody>
									<tr>
									  <td class="movableContentContainer"><div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
										  <table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tbody style="background-color:#222">
											  <tr>
												<td height="15"></td>
											  </tr>
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
													  <tr>
														<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tbody>
															  <tr>
																<td valign="top" width="" style="padding-left:15px;text-align: center;"><a href="'.FRONTEND_URL.'"><img src="'.FRONTEND_URL.'uploads/settings/logo.png" width="auto" height="45"></a></td>
															  </tr>
															</tbody>
														  </table></td>
													  </tr>
													</tbody>
												  </table></td>
											  </tr>
											  <tr>
												<td height="15"></td>
											  </tr>
											</tbody>
										  </table>';
										$html .= '</div>';
										$html .= '<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
										  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:0 15px; border:1px solid #b6b6b6">
											<tbody>
											  <tr>
												<td height="18"></td>
											  </tr>
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tbody>
													  <tr>
														<td class="specbundle"><div class="contentEditableContainer contentTextEditable">
															<div class="contentEditable" style="text-align: left;">';
															  $html .= '<h2 style="font-size: 20px;font-family:helvetica, sans-serif;">Dear '.$name.',</h2>';
															  $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000;"> <span style="font-family:helvetica, sans-serif;color:#000000;">Welcome to Filenotice.com.</span><br />';
																$html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">A ticket is assigned to you.</span><br />Ticket Id : '.$ticketid.'<br/>
																Description : '.$description.'';
																$html .= '<br />';
																
																 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;"> <a href="'.$loginlink.'">Login Link</a></span> <br/><br/>';
																 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;"> Hope you will have benefit from our services.</span><br/><span style="font-family:helvetica, sans-serif;color:#000000;"> For any help, please contact us at :<a href="mailto:coffee@hashtaglabs.biz" target="_blank"> coffee@hashtaglabs.biz</a></span> </p>';
															  $html .= '<br>
															</div>
														  </div></td>
													  <tr>
														<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Regards,</td>
													  </tr>
													  <tr>
														<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Administrator</td>
													  </tr>
													  <tr>
														<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Filenotice</td>
													  </tr>
													  <tr>
														<td class="specbundle">&nbsp;</td>
													  </tr>
													</tbody>
												  </table></td>
											  </tr>
											</tbody>
										  </table>
										</div>
										<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
										  <table style="background-color: #272727;" width="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
											  <tr>
												<td height="8"></td>
											  </tr>
											  <tr>
												<td height="8"><div class="contentEditableContainer contentTextEditable">
													<div class="contentEditable" style="text-align: center;color:#AAAAAA;">
													  <p style="margin:2px 0; font-size:10px;"> &copy; '.date("Y").' Filenotice </p>
													</div>
												  </div></td>
											  </tr>
											  <tr>
												<td height="8"></td>
											  </tr>
											</tbody>
										  </table>
										</div></td>
									</tr>
								  </tbody>
								</table></td>
							</tr>
						  </tbody>
						</table></td>
					</tr>
				  </tbody>
				</table></td>
			</tr>
		  </tbody>
		</table>';
		return  $html;
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
	public function deleteticketfile() {
		$rowid 		= $this->input->post('rowid');
		$ticketid 	= $this->input->post('ticketid');
		$ticketdata	= $this->ticket_model->getTicketById($ticketid);
		if(!empty($ticketdata)){
			$ticketfile 		= $ticketdata->file;
			$ticketfileArray 	= json_decode($ticketfile);
			if($rowid == '0'){
				array_splice($ticketfileArray,$rowid,'1');
			}else{	
				array_splice($ticketfileArray,$rowid,$rowid);
			}
			$newjson = json_encode($ticketfileArray);
			$return = $this->ticket_model->updateTicket(array("file" => $newjson), (int) $ticketid);
			if($return){
				$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Uploaded document has been deleted successfully.'));
			}
			echo $return;
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
						$userdata 			= $this->session->userdata('users');
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
							redirect(base_url('/ticket/servicelist/?status=20'));
						}
					}
				}
			}
		}
	}
	public function raiserequestwithremark($ticketid){
		$data['section_name'] = "Raise Request";
		$data['page_title'] = $data['site_title'] = "";
		//$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/agent');
		$data['pageUrl'] 	= $pageUrl = base_url('/ticket');
		$data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
				. '<li class="breadcrumb-item"><a href="' . $pageUrl . '/agent">' . $data['page_title'] . '</a></li>'
				. '</ol>';
		$sessionData 			= $this->session->userdata('users');
		$data['user_id']		= $user_id = $sessionData['user_id'];
		$data['user_type']		= $user_type = $sessionData['user_type'];
		$data['ticket'] 		= $this->ticket_model->getTicketById($ticketid);
        $data['ticketlogdata'] 	= $this->ticket_model->getthedata('ticket_id',$ticketid,'nw_ticketstatusremarklog_tbl');
		if($this->input->post('ticketstatusupdate')){
			$this->form_validation->set_rules('ticket_status', 'Status', 'required');
			if ($this->form_validation->run()) {
				$ticket_status 		= $this->input->post('ticket_status');
				$customer_remark  	= $this->input->post('customer_remark');
				$userdata 			= $this->session->userdata('users');
				$user_id			= $userdata['user_id'];
				$inserteddata		= array(
					'user_id' 			=> $user_id,
					'ticket_id' 		=> $ticketid,
					'request_status' 	=> $ticket_status,
					'customer_remark' 	=> $customer_remark,
					'admin_remark' 		=> '',
					'request_accepted' 	=> 0,
					'created_at' 		=> date('Y-m-d H:i:s'),
					'modified_at' 		=> date('Y-m-d H:i:s')							
				);
				$ticketlogdata = $this->ticket_model->getthedata('ticket_id',$ticketid,'nw_customer_request_tbl');
				//echo '<pre>'; print_r($ticketlogdata); echo '</pre>'; die(__FILE__ . " On  ". __LINE__);
				if(!empty($ticketlogdata)){
					$updateDataArray = array(
						'request_status' 	=> $ticket_status,
						'customer_remark' 	=> $customer_remark,
						'admin_remark' 		=> '',
						'request_accepted' 	=> 0,
						'modified_at' 		=> date('Y-m-d H:i:s')
					);
					$returndata 	= $this->ticket_model->updateTicketsTable('ticket_id',$ticketid,'nw_customer_request_tbl',$updateDataArray);
					if($returndata){
						$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Request updated successfully.'));
						redirect(base_url('/ticket/needhelp'));
					}
				}else{
					$insertedsuccess = $this->ticket_model->createTicket('nw_customer_request_tbl',$inserteddata);
					if($insertedsuccess){
						$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Request raised successfully.'));
						redirect(base_url('/ticket/needhelp'));
					}
				}
			}
		}
		if(!empty($data['ticket'])){
			_manage_template('templates/header', 'templates/footer', 'ticket/raiserequest', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'ERROR', 'message' => 'No data found.'));
			redirect(base_url() . 'ticket/needhelp');
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
	public function needhelp(){
		$data['section_name'] = "Need Help";
        $data['page_title'] = $data['site_title'] = "";
        //$data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/agent');
        $data['pageUrl'] 	= $pageUrl = base_url('/ticket');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/agent">' . $data['page_title'] . '</a></li>'
                . '</ol>';
		$sessionData 			= $this->session->userdata('users');
		$data['user_id']		= $user_id = $sessionData['user_id'];
		$data['user_type']		= $user_type = $sessionData['user_type'];
        $ignore_status_code 	= array(90,91);
		//$data['response'] 		= $this->ticket_model->getAssignTicket($user_id,$ignore_status_code,$user_type);
		$data['response'] 		= $this->ticket_model->getAssignTicket($user_id,'',$user_type);
        _manage_template('templates/header', 'templates/footer', 'ticket/needhelp', $data, 'templates/left_adminMenu');
	}
	public function getselectedcatsubcat($getids,$redirect_url){
		$catids			= [];
		$allsubcatids	= [];
		if(!empty($getids)){
			$allcatids 		= explode(',',$getids);
			foreach($allcatids as $catsid){
				$catdata = $this->category_model->get_category_data($catsid);
				if(!empty($catdata)){
					if($catdata->parent_id > 0){
						if(!in_array($catdata->parent_id, $catids)){
							array_push($catids,$catdata->parent_id);
						}
						$allsubcatids[] = $catdata->id;
					}else{
						array_push($catids,$catdata->id);
					}						
				}
			}
		}
		$selectedcatarray = [];
		foreach($allsubcatids as $subcatid){
			$getSubCat = $this->category_model->get_category_data($subcatid);
			$selectedcatarray[] = $getSubCat->parent_id;
		}
		foreach($catids as $categoryid){
			if(!in_array($categoryid,$selectedcatarray)){
				$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'Subcategory is manedatory for each category, please select subcategory.'));
				redirect($redirect_url); 
			}
		}
		$category_id 	= implode(',',$catids);
		$subcategory_id = implode(',',$allsubcatids);
		$selectcat = array(
			'category'		=> $category_id,
			'subcategory'	=> $subcategory_id,
		);
		return $selectcat;
	}
}