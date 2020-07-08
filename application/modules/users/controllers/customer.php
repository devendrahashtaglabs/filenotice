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
        $last = end($this->uri->segments);
        if ($last != 'login') {
            is_logged_in();
        }
        $this->load->model('user_model');
        $this->load->model('ticket_model');
        $this->load->model('category_model');
        $this->load->model('expertise_model');
        $this->load->library(array('form_validation'));
        $this->form_validation->run($this);
    }
    
    function _alpha_dash_space($str_in = '')
	{
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
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Ticket List";
        $data['pageUrl'] = $pageUrl = base_url('ticket');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '/list">' . $data['page_title'] . '</a></li></ol>';
        $data['tickets'] = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','1');
        _manage_template('templates/header', 'templates/footer', 'ticket/ticket_list', $data, 'templates/left_adminMenu');
    }

function image_upload(){
    
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
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[10]');
            
            if ($this->form_validation->run()) {


$str = $this->input->post('categorytext');
$len=3;
$ticketname= substr(str_replace(" ", "", $str), 0, $len).'-'.randomstring(5);
$newticketname = strtoupper($ticketname);



$path1= "./uploads/ticket/".$_FILES['image']['name'][0];
$extension = substr(strrchr($path1, '.'), 1);

$imagename = $_FILES['image']['name'][0];

if($imagename!=''){
   if (($extension!= "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif") && ($extension != "bmp") && ($extension != "pdf") && ($extension != "doc") && ($extension != "docx") && ($extension != "xls") && ($extension != "xlsx") && ($_FILES["file"]["size"] < 1000000)) 
    {
     $this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WARNING','message'=>'File not supported!'));
     redirect($pageUrl . '/create');
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
     $filename = '';
}
                    $responce = $this->ticket_model->createTicket([
                    'ticket_id'     => $newticketname,
                    'customer_id'   => $this->session->userdata('users')['user_id'],
                    'description'   => $this->input->post('description'),
                    'file'          => $filename,
                    'start_date'    => date('Y-m-d'),
                    'category_id'   => $this->input->post('category_id'),
                    'status'        => $this->input->post('status'),
                    'created'       => date('Y-m-d'),
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
        $id = $this->uri->segment(3);
        $data['section_name']= "Ticket Management";
        $data['page_title']  = $data['site_title'] = "View Ticket";
        $data['pageUrl']     = $pageUrl = base_url('ticket');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item">'
                . '<a href="' . $pageUrl . '/view/' . $id . '">' . $data['page_title'] . '</a></li></ol>';
        $data['ticket'] = $this->ticket_model->getTicketById($id);
        _manage_template('templates/header', 'templates/footer', 'ticket/view_details', $data, 'templates/left_adminMenu');
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
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('category_id', 'Category Name', 'trim|required');
            $this->form_validation->set_rules('status', 'Status', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[10]');
            // $this->form_validation->set_rules('ticket_status', 'ticket status', 'trim|required');
            // $this->form_validation->set_rules('payment_status', 'Payment status', 'trim|required');
            // $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
            // $this->form_validation->set_rules('close_date', 'Cloase Date', 'trim|required|callback_validateDate');
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
                    'description' => $this->input->post('description'),
                    'category_id' => $this->input->post('category_id'),
                    'status' => $this->input->post('status'),                    
                );
                
            }else{

                $data = array(
                    'description' => $this->input->post('description'),
                    'category_id' => $this->input->post('category_id'),
                    'status' => $this->input->post('status'),
                    'file'          => $filename,
                );
           }     
                $responce = $this->ticket_model->updateTicket($data, $id);
                if ($responce) {
                    $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been updated successfully.'));
                    redirect($pageUrl . '/list');
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'ticket/edit', $data, 'templates/left_adminMenu');
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
        $read_status = $this->input->post('read_status');
echo $read_status;
exit;
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Assigned Ticket List";
        $data['pageUrl'] = $pageUrl = base_url('ticket/assign');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $data['response'] = $this->ticket_model->getAssignTicket($this->session->userdata('users')['user_id'],'1',$this->session->userdata('users')['user_type']);

        // echo "<pre>";
        // print_r($data['response']);
        // exit;

         // $ticket_id = 56;
         // $user_id   = 20;
         // $updateArr = array([
                    
         //            'read_status'   => 1,
         //        ]);
         // $this->ticket_model->updateTicketreadstatus($updateArr,$ticket_id,$user_id);

        _manage_template('templates/header', 'templates/footer', 'ticket/assign_list', $data, 'templates/left_adminMenu');
    }
    
    public function completed_list() {
        $data['section_name'] = "Ticket Management";
        $data['page_title'] = $data['site_title'] = "Completed List";
        $data['pageUrl'] = $pageUrl = base_url('ticket/completed');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $data['tickets'] = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','2');
        _manage_template('templates/header', 'templates/footer', 'ticket/completed_list', $data, 'templates/left_adminMenu');
    }
    
    public function feedback() {
        $data['section_name'] = "Feedback";
        $data['page_title'] = $data['site_title'] = "Feedback";
        $data['pageUrl'] = $pageUrl = base_url('ticket/feedback');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        
        
        
        if($this->session->userdata('users')['user_type'] == "consultant"){        
            $data['tickets'] = $this->ticket_model->getCustomerFeedBackList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','2');
        }else{
            $data['tickets'] = $this->ticket_model->getCustomerTicketList($this->session->userdata('users')['user_id'], '', 'tickets.id', 'desc','2');
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
        $data['page_title'] = $data['site_title'] = "Update Profile";
        $data['pageUrl'] = $pageUrl = base_url('profile');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item">'
                . '<a href="' . base_url('dashboard') . '">Dashboard</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
        $userid  = $this->session->userdata('users')['user_id'];
        $userType= $this->session->userdata('users')['user_type'];
        $data['usersData']  = $usersData = $this->user_model->getUserDetails($userid,($userType=='consultant') ? 3 : 2);
        $data['countryList']= $this->user_model->getCountryList();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            if($usersData->user_type=='3'){
                $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
            }
            $this->form_validation->set_rules('user_name', 'Name', 'trim|required|min_length[2]|callback__alpha_dash_space');
            $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email|callback_validateEmail[' . $userid . ']');
            $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|exact_length[10]|regex_match[/^[0-9]{10}$/]');

            $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required|callback_validateAge');
            // $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|required');

            $this->form_validation->set_rules('user_country', 'Country', 'trim|required');
            $this->form_validation->set_rules('user_state', 'State', 'trim|required');
            $this->form_validation->set_rules('user_city', 'City', 'trim|required');
            $this->form_validation->set_rules('user_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|required|exact_length[6]|numeric');
            $this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
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
    $dat = Null;
}                
                $updateArr = array(
                    'user_id'       => $userid,
                    'name'          => $this->input->post('user_name'),
                    'mobile'        => $this->input->post('user_mobile'),
                    'dob'           => $dat,
                    'country_id'    => $this->input->post('user_country'),
                    'state_id'      => $this->input->post('user_state'),
                    'city_id'       => $this->input->post('user_city'),
                    'zip'           => $this->input->post('pin_code'),
                    'gender'        => $this->input->post('user_gender'),
                    'latitude'      => ($getGeoData != '') ? $getGeoData['lat'] : '',
                    'longitude'     => ($getGeoData != '') ? $getGeoData['long'] : '',
                    'address'       =>$this->input->post('user_address'),
                    'modified'      => date('Y-m-d H:i:s')
                );
                
                if (!empty($_FILES) && !empty($_FILES['user_photo']['name'])) {
                    $filename = $_FILES['user_photo']['name'];
                    $tmp_path = $_FILES['user_photo']['tmp_name'];
                    $image_name = uploadImage($filename, $tmp_path, 'profile', '140');
                    $updateArr['photo'] = $image_name;
                    unlinkImage('uploads/profile/', $usersData->photo);
                }
                if($usersData->user_type=='3'){
                    $updateArr['account_type']=$this->input->post('account_type');
                    $updateArr['pan_photo']  = '';
                    $updateArr['expertise']  = '';
                }
                $this->user_model->updateUsersDetails($updateArr,($usersData->user_type=='3')?'nw_consultant_tbl':'nw_customer_tbl');
                $responce = $this->user_model->updateUser([
                    'user_id' => $userid,
                    'email'   => $this->input->post('user_email'),
                    'modified'=> date('Y-m-d H:i:s')
                ]);
                $this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Profile has been updated successfully.'));
                redirect(base_url('profile'));
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
        $data['section_name'] = "Update Password";
        $data['page_title'] = $data['site_title'] = "Update Password";
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
                     
                    $this->user_model->update_wordpress_password(array('user_pass' => md5($this->input->post('new_password'))), $this->session->userdata('users')['user_email']);
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
        $data['section_name']= "Ticket Management";
        $data['page_title']  = $data['site_title'] = "Conversation";
        $data['pageUrl']     = $pageUrl = base_url('/ticket');
        $data['ticketid']    = $ticketid= $this->uri->segment(3);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/assign">Assign List</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/conversation/' . $ticketid . '">' . $data['page_title'] . '</a></li></ol>';
        
        
        
        $ticketChat = $this->ticket_model->getChatAgainstTicket($ticketid);
        $html = '<div class="direct-chat-messages">';
        $userType = ($this->session->userdata('users')['user_type']=='consultant')?3:2;
        
        if(!empty($ticketChat)){
            foreach ($ticketChat as $key => $value) {
                $chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
                $details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
                
               // print_r($details);
               // exit;
                
                if($details->photo != ''){
                    $ImageUser = base_url('uploads/profile/'.$details->photo);
                   
                }else{
                    $ImageUser = base_url('uploads/profile/noimage.jpg');
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
                
                $html .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$details->name.'</span>
                        <span class="direct-chat-timestamp '.$floatdate.'">'.date('d-m-Y, h:i A', strtotime($chatData->created_at)).'</span>
                    </div><img class="direct-chat-img" src="'.$ImageUser.'" alt="message user image"/>
                    <div class="direct-chat-text">'.$chatType.'</div></div>';
            }
        }else{
            $html .= '<div class="direct-chat-msg right"><div class="direct-chat-info clearfix"><span class="direct-chat-name float-right"></span><span class="direct-chat-timestamp float-left"></span></div><div class="direct-chat-text">No Record Available.</div></div>';
        }
        
        if ($this->input->is_ajax_request() == true) {
            if(empty(trim($this->input->post('message'))) && (empty($_FILES) || empty($_FILES['upload_file']['name']))){
                $status     = false;
                $style_color= 'red';
                $chatList   = ''; 
                $massege    = 'Please enter Message.';
            }else {
                $status     = true;
                $massege    = 'Message Sent';
                $style_color= 'green';
                $chatList  =  '';
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
                        $ImageUser = base_url('uploads/profile/noimage.jpg');
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
                        $ImageUser = base_url('uploads/profile/noimage.jpg');
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
            $ajaxResponse=json_encode(array('datalist'=>$chatList,'status'=>$status,"massege"=>$massege,'style_color'=>$style_color));
            echo $ajaxResponse;
            exit();
        }
        $data['html'] = $html .='</div>';
        
        
        
        _manage_template('templates/header', 'templates/footer', 'ticket/conversation', $data, 'templates/left_adminMenu');
    }
    
    
    public function getChatDataByAjax($ticketid){
        
       // print_r($ticketid);
        
        $ticketChat = $this->ticket_model->getChatAgainstTicket($ticketid);
        
        
        $html = '<div class="direct-chat-messages">';
        $userType = ($this->session->userdata('users')['user_type']=='consultant')?3:2;        
        if(!empty($ticketChat)){
            
            foreach ($ticketChat as $key => $value) {
                $chatData = $this->ticket_model->getUsersChatAgainstTicket($value->id,$value->user_id);
                $details  = $this->user_model->getUserDetailsById($value->user_id,$chatData->user_type);
                
                if($details->photo != ''){
                    $ImageUser = base_url('uploads/profile/'.$details->photo);
                }else{
                    $ImageUser = base_url('uploads/profile/noimage.jpg');
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
                $html .= '<div class="direct-chat-msg '.$rightbox.'"><div class="direct-chat-info clearfix">
                        <span class="direct-chat-name '.$floatname.'">'.$details->name.'</span>
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
    
    
}