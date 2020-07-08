<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consultant extends MX_Controller {

    function __construct() {
        parent::__construct();
		$last = end($this->uri->segments);
        if ($last != 'login') {
            $loggedin = $this->session->userdata('admins');
			if(empty($loggedin)){
				$redirect_url = FRONTEND_URL . 'admin/login';
				redirect($redirect_url);
			}
        }
        $this->load->model('user_model');
        $this->load->model('expertise_model');
        $this->load->model('category_model');
        $this->load->model('ticket_model');
        // $this->load->library(array('my_form_validation'));
	    // $this->form_validation->run($this);
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
    
    public function validateEmail($str,$paramTwo) {
        $response = $this->user_model->validateEmail($str, $paramTwo);
        if (empty($response)) {
            return TRUE;
        }else{
            $this->form_validation->set_message('validateEmail', 'Email ID already registered!');
            return FALSE;
        }
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
    
    public function consultant_list() {
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "All Consultants";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/consultant_list">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['response']   = $this->user_model->getUserList('3', '', '', '', 'users.id', 'desc');
        $data['newt']       = $this->user_model->getCountOfticketstatus('3', '', '', '', 'users.id', 'desc');
       
        //$this->load->view('consultant_list', $data);
        // echo "<pre>";
        // print_r($data['newt']);
        // exit;

        _manage_template('templates/header', 'templates/footer', 'consultant/list', $data, 'templates/left_adminMenu');
    }
    
    public function create() {
        $data['section_name']   = "Consultant Management";
        $data['page_title']     = $data['site_title'] = "Create Consultant";
        $data['pageUrl']        = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create');
        $data['breadcrumb']     = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['countryList']    = $this->user_model->getCountryList();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			$data['postdata'] = $this->input->post();
            $this->form_validation->set_rules('user_name', 'First Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('sname', 'Last Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
            $this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|is_unique[nw_user_tbl.email]');
            //$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            //$this->form_validation->set_message('is_unique', 'Email ID already registered!');
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
            if ($this->form_validation->run()) {
				$user_email  = $this->input->post('user_email');
				$responce = $this->user_model->createNewUsers('nw_user_tbl', [
						'user_type'    => 3,
						'email'        => $this->input->post('user_email'),
						'password'     => md5($randompass),
						'status'       => $this->input->post('user_status'),
						'created'      => date('Y-m-d H:i:s'),
						'last_login'   => date('Y-m-d H:i:s'),
						'login_status' => 0,
						'activation_code'=> md5('test@123')
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
					$permitted_chars 	= '0123456789abcdefghijklmnopqrstuvwxyz';
					$randnum			= substr(str_shuffle($permitted_chars), 0, 10);
					$randtime 			= date('His');
					$randstring			= $randnum.$randtime;
					$user_country		= $this->input->post('user_country');
					$country_id			= !empty($user_country)?$user_country:'88';
					$user_mobile		= $this->input->post('user_mobile');
					$str 				= preg_replace("/[^A-Za-z0-9 ]/", '', $user_mobile);
					$mobile				= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
					$user_name			= $this->input->post('user_name');
					$surname			= $this->input->post('sname');
					$new_string 		= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
					$lowercaseTitle 	= strtolower($new_string); 
					$name 				= ucwords($lowercaseTitle);
					
					$new_stringsur 		= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $surname)));
					$lowercaseSname 	= strtolower($new_stringsur); 
					$sname 				= ucwords($lowercaseSname);
					$age				= '';
					if(empty($age)){
						$age 			= (date('Y') - date('Y',strtotime($dob)));
					}
					
					$consultantresponse = $this->user_model->createNewUsers('nw_consultant_tbl', [
							'user_id'   	=> $responce,
							'title'      	=> $this->input->post('title'),
							'name'      	=> $name,
							'sname'      	=> $sname,
							'age'       	=> $age,
							'dob'       	=> $dob,
							'gender'    	=> $this->input->post('user_gender'),
							'address'   	=> $this->input->post('user_address'),
							'country_id'	=> $country_id,
							'state_id'  	=> $this->input->post('user_state'),
							'city_id'   	=> $this->input->post('user_city'),
							'zip'       	=> $this->input->post('pin_code'),
							'mobile'    	=> $mobile,
							'photo'     	=> '',
							'latitude'  	=> ($getGeoData !='') ? $getGeoData['lat']:'',
							'longitude' 	=> ($getGeoData !='') ? $getGeoData['long']:'',
							'status'    	=> 1,
							'account_type'	=> $this->input->post('account_type'),
							'email_verify_code' => $randstring,
							'created'   	=> date('Y-m-d H:i:s')
						]
					);
					if(!empty($consultantresponse)){
						$subject="File Notice- Consultant Registration";
						$name   = ucfirst($this->input->post('user_name'));
						$email  = $this->input->post('user_email');
						/* $message='Hello '.$this->input->post('user_name').',<br><br>Welcome to Filenotice.com.<br><br> You have register on my portal.<br><br><br>Your login detail is <br><br> Username : '.$this->input->post('user_email').'<br>Password : '.$randompass.' Thanks'; */
						$verifyemaillink 	= FRONTEND_URL .'/verify-email/?verifycode='.$randstring;
						$loginurl 			= FRONTEND_URL .'login';
						
						$msg = $this->getMailData($name,$email,$randompass,$loginurl,$verifyemaillink);
						$from = "Filenotice <coffee@filenotice.com>";
						$header = "From: $from\r\n";
						$header .= "Content-type: text/html; charset=utf-8";

						$responsemail = mail($email,$subject,$msg,$header);
						
						$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step1 info has been created successfully.'));
						redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/create_info/' . $responce));
					}else {
						$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
					}
				}else {
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
				}
            }
        }
        _manage_template('templates/header', 'templates/footer', 'consultant/create', $data, 'templates/left_adminMenu');
    }

    public function create_info() {
        $data['id'] = $id = $this->uri->segment(4);
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "Create Consultant";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/create_info');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['expertise']  		= $this->expertise_model->listExpertise('1');
        $data['category']   		= $this->category_model->getParentCategory('1');
        $data['qualificationData']  = $qualificationData = $this->user_model->getallqualification();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			$data['postdata'] = $this->input->post();
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
                    $aadharphoto= uploadImage($aadharname, $tmp_path1, 'consultant', '140');
                }else{
                    $aadharphoto= '';
                }
                if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
                    $panname = $_FILES['pan_photo']['name'];
                    $tmp_path2  = $_FILES['pan_photo']['tmp_name'];
                    $panphoto= uploadImage($panname, $tmp_path2, 'consultant', '140');
                }else{
                    $panphoto= '';
                }
				
				$redirect_url	= base_url($this->session->userdata('user_type') . '/admin/consultant/create_info/'.$id);
				$getids 		= $this->input->post('getids');
				$allcatarray	= $this->getselectedcatsubcat($getids,$redirect_url);
				$category_id 	= $allcatarray['category'];
				$subcategory_id = $allcatarray['subcategory'];
				
                $experience_yr 	= $this->input->post('experience_yr');
                $experience_mn 	= $this->input->post('experience_mn');
                $experience    	= $experience_yr.' ' .$experience_mn;
				$contact_number	= $this->input->post('contact_number');
				$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $contact_number);
				$mobilenumber	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
                $this->user_model->updateConsultantById('user_id', $id, [
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
                ]);
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant has been created successfully.'));
                redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
            }
        }
        _manage_template('templates/header', 'templates/footer', 'consultant/create_info', $data, 'templates/left_adminMenu');
    }

    public function edit() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "Edit Consultant";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/edit/'.$id);
        $data['edit_info'] = $edit_info = base_url($this->session->userdata('user_type') . '/admin/consultant/edit_info/'.$id);
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['consultant']= $consultantdata = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['expertise'] = $this->expertise_model->listExpertise();
			$data['category']  = $this->category_model->getParentCategory('1');
			$data['countryList'] 	= $this->user_model->getCountryList();
			$data['stateList'] 		= $this->user_model->getStateList();
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$this->form_validation->set_rules('user_name', 'Consultant Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
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
					$user_country		= $this->input->post('user_country');
					$country_id			= !empty($user_country)?$user_country:'88';
					$user_mobile		= $this->input->post('user_mobile');
					$str 				= preg_replace("/[^A-Za-z0-9 ]/", '', $user_mobile);
					$mobile				= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
					$user_name			= $this->input->post('user_name');
					$surname			= $this->input->post('sname');
					$new_string 		= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
					$lowercaseTitle 	= strtolower($new_string); 
					$name 				= ucwords($lowercaseTitle);
					
					$new_stringsur 		= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $surname)));
					$lowercaseSname 	= strtolower($new_stringsur); 
					$sname 				= ucwords($lowercaseSname);
					$age				= '';
					if(empty($age)){
						$age 			= (date('Y') - date('Y',strtotime($dob)));
					}
					$consultArry = [
						'account_type'  => $this->input->post('account_type'),
						'title'      	=> $this->input->post('title'),
						'name'      	=> $name,
						'sname'      	=> $sname,
						'age'       	=> $age,
						'mobile'        => $mobile,
						'dob'           => $dob,
						'country_id'    => $country_id,
						'state_id'      => $this->input->post('user_state'),
						'city_id'       => $this->input->post('user_city'),
						'address'       => $this->input->post('user_address'),
						'zip'           => $this->input->post('pin_code'),
						'gender'        => $this->input->post('user_gender'),
						'latitude'      => ($getGeoData !='') ? $getGeoData['lat']:'',
						'longitude'     => ($getGeoData !='') ? $getGeoData['long']:'',
						'modified'      => date('Y-m-d H:i:s')
					];
					$this->user_model->updateConsultantById('user_id', $id, $consultArry);
					
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
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Customer Step1 info has been created successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/edit_info/'.$id));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
    }
    
    public function edit_info() {
      
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Edit Consultant";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/edit_info/'.$id);
        $data['edit']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/edit/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . 'consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['consultant'] = $consultant = $this->user_model->getConsultantById($id);
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
						$profilephoto = '';
					}
					if(!empty($_FILES) && !empty($_FILES['aadhar_photo']['name'])){
						$aadharname = $_FILES['aadhar_photo']['name'];
						$tmp_path1  = $_FILES['aadhar_photo']['tmp_name'];
						$aadharphoto= uploadImage($aadharname, $tmp_path1, 'consultant', '140');
					}else{
						$aadharphoto= '';
					}
					if(!empty($_FILES) && !empty($_FILES['pan_photo']['name'])){
						$panname = $_FILES['pan_photo']['name'];
						$tmp_path2  = $_FILES['pan_photo']['tmp_name'];
						$panphoto= uploadImage($panname, $tmp_path2, 'consultant', '140');
					}else{
						$panphoto= '';
					}
					if(empty($this->input->post('cropped_banner'))){
						if(!empty($_FILES) && !empty($_FILES['banner_image']['name'])){
							$bannername 	= $_FILES['banner_image']['name'];
							$tmp_path3  	= $_FILES['banner_image']['tmp_name'];
							$bannerphoto	= uploadImage($bannername, $tmp_path3, 'consultant/banners');
						}else{
							$bannerphoto	= $consultant->banner_image;
						}
					}else{
						$bannerphoto	= $this->input->post('cropped_banner');
					}
					
					$redirect_url	= base_url($this->session->userdata('user_type') . '/admin/consultant/edit_info/'.$id);
					$getids 		= $this->input->post('getids');
					$allcatarray	= $this->getselectedcatsubcat($getids,$redirect_url);
					$category_id 	= $allcatarray['category'];
					$subcategory_id = $allcatarray['subcategory'];
					$contact_number	= $this->input->post('contact_number');
					$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $contact_number);
					$mobilenumber	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
					$this->user_model->updateConsultantById('user_id', $id, [
						'category_id'       => $category_id,
						'subcategory_id'    => $subcategory_id,
						'telephone'         => $mobilenumber,
						'photo'             => $profilephoto,
						'banner_image'    	=> $bannerphoto,
						'about_consultant'  => $this->input->post('about_consultant'),
						'company_name'    	=> $this->input->post('company_name'),
						'company_address'   => $this->input->post('company_address'),
						'aadhaar_card_number'=> $this->input->post('aadhar_no'),
						'aadhaar_photo'     => $aadharphoto,
						'pan_card_number'   => $this->input->post('pan_no'),
						'pan_photo'         => $panphoto,
						'education'         => $this->input->post('qualification'),
						'sub_education'     => $this->input->post('sub_qualification'),
						'expertise'         => $expertise,
						'experience'        => $experience,
						'modified'          => date('Y-m-d H:i:s')
					]);
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step2 info has been edited successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/edit_info', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
    }

    public function view() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type').'/admin/consultant/consultant_list'));
        };
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Consultant Detail";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/view/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['row'] = $consultant= $this->user_model->getConsultantById($id);
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
			_manage_template('templates/header', 'templates/footer', 'consultant/view', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
    }

    public function updateRecords() {
        $id 	= $this->input->post('uid');
        $status = $this->input->post('status');
        $action = $this->input->post('action');
        $table 	= $this->input->post('table');
		$email 	= $this->input->post('email');
        $name 	= $this->input->post('name');
        if ($action == 'delete') {
            $return = $this->user_model->deleteUsers($id, 'nw_consultant_tbl');
            $status = true;
            $message = 'Record has been Successfully deleted.';
            $style_color = 'green';
            $redirectURL = base_url($this->session->userdata('user_type') . '/consultant/consultant_list');
        } else {
            if($status=='1'){
                $statuss = 0;
                $emailstatus = 0;
            }else{
                $statuss = 1;
                $emailstatus = 1;
            }
			if($emailstatus==1){
				$consultantdata = $this->user_model->getConsultantById($id);
				if($consultantdata->verify_email == '1'){
					$url 		= FRONTEND_URL;       
					$link 		= $url."login"; 
					$to 		= $email;
					$subject	= "File Notice- Account Active";
					$message = $this->getAproveMailData($name,'','',$link);
					$from = "Filenotice <coffee@filenotice.com>";
					$header = "From: $from\r\n";
					$header .= "Content-type: text/html; charset=utf-8";

					mail($to,$subject,$message,$header);
					$return = $this->user_model->updateUser(array('user_id' => (int) $id, "status" => $statuss));
					$status = true;
					$message = 'Status has been updated successfully.';
					$style_color = 'green';
					$redirectURL = base_url($this->session->userdata('user_type') . '/consultant/consultant_list');
				}else{
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'Consultant email not verified.'));
					echo 1;
					exit;
				}
			}else{
				$return 		= $this->user_model->updateUser(array('user_id' => (int) $id, "status" => $statuss));
				$status 		= true;
				$message 		= 'Status has been updated successfully.';
				$style_color 	= 'green';
				$redirectURL 	= base_url($this->session->userdata('user_type') . '/consultant/consultant_list');
			}
        }
        $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
        echo $ajaxResponse;
    }
    public function getMailData($name,$email,$password,$loginurl,$verifylink){
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
                                                                /*  $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to verify email : <a href="'.$verifylink.'" target="_blank">'.$verifylink.'</a></span><br />'; */
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
	public function getselectedcatsubcat($getids,$redirect_url){
		$catids			= [];
		$allsubcatids	= [];
		if(!empty($getids)){
			$allcatids 		= explode(',',$getids);
			foreach($allcatids as $catsid){
				$catdata = $this->category_model->getCategoryById($catsid);
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
			$getSubCat = $this->category_model->getCategoryById($subcatid);
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

	public function image_uploads(){
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
	public function consultantstep1() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name'] = "Consultant Management";
        $data['page_title'] = $data['site_title'] = "Verify Consultant";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id);
        $data['edit_info'] = $edit_info = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id);
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['consultant']= $consultantdata = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['expertise'] = $this->expertise_model->listExpertise();
			$data['category']  = $this->category_model->getParentCategory('1');
			$data['countryList']			= $this->user_model->getCountryList();
			$data['stateList'] 				= $this->user_model->getStateList();
			$data['expertise']  			= $this->expertise_model->listExpertise('1');
			$data['category']   			= $this->category_model->getParentCategory('1');
			$data['countryList']			= $this->user_model->getCountryList();
			$data['qualificationData']  	= $qualificationData = $this->user_model->getallqualification();
			$data['verifiedconsultantdata'] = $verifiedconsultantdata = $this->user_model->getDataBykey('nw_consultant_verify_tbl','user_id',$id);
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
				/* $this->form_validation->set_rules('user_name', 'Consultant Name', 'trim|required|min_length[2]|xss_clean|alpha_numeric_spaces');
				$this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|callback_validateEmail['.$id.']');
				$this->form_validation->set_rules('password', 'Password', 'min_length[6]');
				$this->form_validation->set_rules('account_type', 'Account Type', 'trim|required');
				$this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required|numeric|exact_lenght[10]');
				
				$this->form_validation->set_rules('user_dob', 'Date Of Birth', 'trim|callback_validateAge');
				$this->form_validation->set_rules('user_country', 'Country', 'trim');
				$this->form_validation->set_rules('user_state', 'State', 'trim');
				$this->form_validation->set_rules('user_city', 'City', 'trim||min_length[2]|xss_clean|alpha_numeric_spaces');
				$this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[100]');
				$this->form_validation->set_rules('pin_code', 'Pincode', 'trim|numeric|exact_length[6]');
				$this->form_validation->set_rules('user_gender', 'Gender', 'trim');
				$this->form_validation->set_rules('user_status', 'Status', 'trim'); */
				//if ($this->form_validation->run()) {
					/* $countrydata= $this->user_model->getCountryList($this->input->post('user_country'));
					$countryName= ($countrydata !='') ? $countrydata->name:'';
					$stateList  = $this->user_model->getStateList($this->input->post('user_state'));
					$stateName  = ($stateList !='') ? $stateList->name:'';
					$cityName   = $this->input->post('customer_city');
					$getGeoData = _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
					if(!empty($this->input->post('user_dob'))){
						$dob = date('Y-m-d', strtotime($this->input->post('user_dob')));
					}else{
						$dob = date('Y-m-d', strtotime('-18 years'));
					}
					$user_country		= $this->input->post('user_country');
					$country_id			= !empty($user_country)?$user_country:'88'; */
					$postdata 			= $this->input->post();
					$updateverifydata = [
						'v_account_type' 	=> $postdata['v_account_type'],
						'v_user_name' 		=> $postdata['v_user_name'],
						'v_user_email' 		=> $postdata['v_user_email'],
						'v_user_mobile' 	=> $postdata['v_user_mobile'],
						'v_user_dob' 		=> $postdata['v_user_dob'],
						'v_user_gender' 	=> $postdata['v_user_gender'],
						'v_user_state' 		=> $postdata['v_user_state'],
						'v_user_city' 		=> $postdata['v_user_city'],
						'v_pin_code' 		=> $postdata['v_pin_code'],
						'v_user_address' 	=> $postdata['v_user_address'],
						'v_profile_pic' 	=> $postdata['v_user_photo'],
						'v_expertise' 		=> $postdata['v_expertise'],
						'allverified_step1' => $postdata['allverified_step1'],
					];
					if(!empty($verifiedconsultantdata)){
						$updateresponse = $this->user_model->updaterecordbyuserid('nw_consultant_verify_tbl','user_id',$id,$updateverifydata);
					}else{
						$updateresponse = $this->user_model->createNewUsers('nw_consultant_verify_tbl',[
							'user_id' 			=> $id,
							'v_account_type' 	=> $postdata['v_account_type'],
							'v_user_name' 		=> $postdata['v_user_name'],
							'v_user_email' 		=> $postdata['v_user_email'],
							'v_user_mobile' 	=> $postdata['v_user_mobile'],
							'v_user_dob' 		=> $postdata['v_user_dob'],
							'v_user_gender' 	=> $postdata['v_user_gender'],
							'v_user_state' 		=> $postdata['v_user_state'],
							'v_user_city' 		=> $postdata['v_user_city'],
							'v_pin_code' 		=> $postdata['v_pin_code'],
							'v_user_address' 	=> $postdata['v_user_address'],
							'v_profile_pic' 	=> $postdata['v_user_photo'],
							'v_expertise' 		=> $postdata['v_expertise'],
							'allverified_step1' => $postdata['allverified_step1'],
						]);
					}
					if($updateresponse){
						$consultArry = [
							'step1_verify_time' => date('Y-m-d H:i:s'),
							'modified'      	=> date('Y-m-d H:i:s')
						];
						$this->user_model->updateConsultantById('user_id', $id, $consultArry);
						
						//echo "<pre>";print_r();echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
						if($consultantdata->verify_email == '1'){
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
							$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step1 info has been approved successfully.'));
							redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id));
						}else{
							$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'Consultant email not verified.'));
							redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id));
						}
					}
				//}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/step1', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
    }
    
    public function consultantstep2() {
      
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Verify Consultant";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id);
        $data['edit']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . 'consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['consultant'] = $consultant = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['category']   = $this->category_model->getParentCategory('1');
			$data['verifiedconsultantdata'] = $verifiedconsultantdata = $this->user_model->getDataBykey('nw_consultant_verify_tbl','user_id',$id);
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$postdata 			= $this->input->post();
				$updateverifydata = [
					'v_banner_image' 	=> $postdata['v_banner_image'],
					'v_company_name' 	=> $postdata['v_company_name'],
					'v_about_consultant'=> $postdata['v_about_consultant'],
					'v_company_address' => $postdata['v_company_address'],
					'allverified_step2' => $postdata['allverified_step2']
				];
				if(!empty($verifiedconsultantdata)){
					$updateresponse = $this->user_model->updaterecordbyuserid('nw_consultant_verify_tbl','user_id',$id,$updateverifydata);
				}
				if($updateresponse){
					$consultArry = [
						'step2_verify_time' => date('Y-m-d H:i:s'),
						'modified'      	=> date('Y-m-d H:i:s')
					];
					$this->user_model->updateConsultantById('user_id', $id, $consultArry);
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step2 info has been approved successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep3/'.$id));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/step2', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
    }
	
	public function consultantstep3() {
        
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Verify Consultant";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep3/'.$id);
        $data['step1']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id);
        $data['step2']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . 'consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
		$data['consultant'] = $consultant = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['verifiedconsultantdata'] = $verifiedconsultantdata = $this->user_model->getDataBykey('nw_consultant_verify_tbl','user_id',$id);
			if ($this->input->server('REQUEST_METHOD') === "POST") {
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
					$oldfilearray = json_decode($consultant->certificates);
					$newfilearray = array_merge($oldfilearray,$filearray);
					$filename 	  = json_encode($newfilearray);
					//$filename = $ticket->file .','. implode(',',$allfile);
				}else{
					$filename = $consultant->certificates;
				} 
				$postdata 			= $this->input->post();
				$updateverifydata = [
					'v_aadhar_no' 		=> $postdata['v_aadhar_no'],
					'v_aadhar_photo' 	=> $postdata['v_aadhar_photo'],
					'v_pan_no'			=> $postdata['v_pan_no'],
					'v_pan_photo' 		=> $postdata['v_pan_photo'],
					'allverified_step3' => $postdata['allverified_step3']
				];
				if(!empty($verifiedconsultantdata)){
					$updateresponse = $this->user_model->updaterecordbyuserid('nw_consultant_verify_tbl','user_id',$id,$updateverifydata);
				}
				if($updateresponse){
					$this->user_model->updateConsultantById('user_id', $id, [
							'certificates' 		=> $filename,
							'step3_verify_time' => date('Y-m-d H:i:s'),
							'modified'          => date('Y-m-d H:i:s')
						]);
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step4 info has been approved successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep4/'.$id));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/step3', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
	}
	public function consultantstep4() {
		$id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Verify Consultant";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep4/'.$id);
        $data['step1']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id);
        $data['step2']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id);
		$data['step3']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep3/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . 'consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
		$data['consultant'] = $consultant = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['verifiedconsultantdata'] = $verifiedconsultantdata = $this->user_model->getDataBykey('nw_consultant_verify_tbl','user_id',$id);
			$data['category']   = $this->category_model->getParentCategory('1');
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$postdata 		= $this->input->post();
				$updateverifydata = [
					'v_catsubcat' 		=> $postdata['v_catsubcat'],
					'allverified_step4' => $postdata['allverified_step4']
				];
				unset($postdata['v_catsubcat']);
				unset($postdata['allverified_step4']);
				unset($postdata['getids']);
				$insertedArray 	= [];
				$counter 		= 0;
				foreach($postdata as $key=>$value){
					$postarray 									= explode('_',$key);
					$insertedArray[$counter]['subcatid']  		= $postarray[1];
					$insertedArray[$counter]['margin_percent']  = $value;
					$counter++; 
				}
				$margindata = json_encode($insertedArray);
				if(!empty($verifiedconsultantdata)){
					$updateresponse = $this->user_model->updaterecordbyuserid('nw_consultant_verify_tbl','user_id',$id,$updateverifydata);
				}
				if($updateresponse){
					$this->user_model->updateConsultantById('user_id', $id, [
							'margin_percentage' => $margindata,
							'step4_verify_time' => date('Y-m-d H:i:s'),
							'modified'          => date('Y-m-d H:i:s')
						]);
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant Step3 info has been approved successfully.'));
					redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep5/'.$id));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/step4', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
	}
	public function consultantstep5() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
        }
        $data['section_name']= "Consultant Management";
        $data['page_title']  = $data['site_title'] = "Verify Consultant";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep5/'.$id);
        $data['step1']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep1/'.$id);
        $data['step2']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep2/'.$id);
        $data['step3']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep3/'.$id);
        $data['step4']        = $edit = base_url($this->session->userdata('user_type') . '/admin/consultant/consultantstep4/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . 'consultant/consultant_list') . '">Consultant</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
		$data['consultant'] = $consultant = $this->user_model->getConsultantById($id);
		if(!empty($data['consultant'])){
			$data['verifiedconsultantdata'] = $verifiedconsultantdata = $this->user_model->getDataBykey('nw_consultant_verify_tbl','user_id',$id);
			if ($this->input->server('REQUEST_METHOD') === "POST") {
				$postdata 			= $this->input->post();
				$updateverifydata = [
					'v_bank_name' 			=> $postdata['v_bank_name'],
					'v_account_no' 			=> $postdata['v_account_no'],
					'v_ifsc_code'			=> $postdata['v_ifsc_code'],
					'v_accountholdername' 	=> $postdata['v_accountholdername'],
					'allverified_step5' 	=> $postdata['allverified_step5']
				];
				if(!empty($verifiedconsultantdata)){
					$updateresponse = $this->user_model->updaterecordbyuserid('nw_consultant_verify_tbl','user_id',$id,$updateverifydata);
				}
				if($updateresponse){
					$response = $this->user_model->updateConsultantById('user_id', $id, [
							'bank_name' 			=> $this->input->post('bank_name'),
							'account_no' 			=> $this->input->post('account_no'),
							'ifsc_code' 			=> $this->input->post('ifsc_code'),
							'accountholdername'		=> $this->input->post('accountholdername'),
							'step5_verify_time' 	=> date('Y-m-d H:i:s'),
							'modified'          	=> date('Y-m-d H:i:s')
						]);
					if($response){
						$this->user_model->updateRecordsById('id', $id,[
							'status' 	=>'1',
							'modified'  => date('Y-m-d H:i:s')
						]);
						$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Consultant info has been approved successfully.'));
						redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
					}
				}
			}
			_manage_template('templates/header', 'templates/footer', 'consultant/step5', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/consultant/consultant_list'));
		}
	}
	public function removesubcat() {
		$user_id 		= $this->input->post('user_id');
		$subcatid 		= $this->input->post('subcatid');
		$subcatparentid	= $this->input->post('subcatparentid');
		$consultantdata = $this->user_model->getConsultantById($user_id);
		if(!empty($consultantdata)){
			$categoryids 	= $consultantdata->category_id;
			$subcategoryids	= $consultantdata->subcategory_id;
			$catidarray		= explode(',',$categoryids);
			$subcatidarray	= explode(',',$subcategoryids);
			$subcatbyparent = $this->category_model->listSubCategoryById($subcatparentid);
			$counter 		= 0;
			$subcatarray 	= [];
			foreach($subcatbyparent as $subcatdatabyparent){
				$subcatarray[$counter] = $subcatdatabyparent->id;
				$counter++;
			}
			if (($key = array_search($subcatid, $subcatidarray)) !== false) {
				unset($subcatidarray[$key]);
			}
			$newcats 	= implode(',',$catidarray); 
			$newsubcats = implode(',',$subcatidarray); 
			$updateresponse = $this->user_model->updateConsultantById('user_id',$user_id,[
					'category_id' 		=> $newcats,
					'subcategory_id' 	=> $newsubcats
			]);
			echo $updateresponse; 
		}
	}
}
