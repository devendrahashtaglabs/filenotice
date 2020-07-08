<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MX_Controller {

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
        $this->load->library(array('form_validation'));
		$this->form_validation->run($this);
    }
    
    public function customer_list() {
        $data['section_name'] 	= "Customer Management";
        $data['page_title'] 	= $data['site_title'] = "All Customers";
        $data['pageUrl'] 		= $pageUrl = base_url($this->session->userdata('admins')['user_type'] . '/customer');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/customer_list">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['response'] 		= $this->user_model->getUserList('2','','','','users.id','desc');
        $data['newcustomer'] 	= $this->user_model->getCountOfticketstatusnew('2', '', '', '', 'users.id', 'desc');
        _manage_template('templates/header', 'templates/footer', 'customer/list', $data, 'templates/left_adminMenu');
    }
    
    function userProflephoto() {
        if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
            $filename = $_FILES['user_photo']['name'];
            $file_extension= _getExtension($filename);
            $allowed_size  = 1000000; //5000000;//5mb-2Mb
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
    
    function checkDateFormat($date) {
        if (preg_match("/[0-31]{2}/[0-12]{2}/[0-9]{4}/", $date)) {
            if(checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4)))
                return true;
            else
                return false;
        } else {
            return false;
        }
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

    public function create() {
        $data['section_name'] = "Customer Management";
        $data['page_title'] = $data['site_title'] = "Create Customer";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('admins')['user_type'] . '/customer/create');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list') . '">Customer</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['countryList'] = $this->user_model->getCountryList();
        if($this->input->server('REQUEST_METHOD')==="POST"){
            $this->form_validation->set_rules('user_name', 'Customer Name', 'trim|callback__alpha_dash_space|required|min_length[2]');
            $this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|is_unique[nw_user_tbl.email]');
            //$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            //$this->form_validation->set_message('is_unique', 'Email ID already registered!');
            $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required');
            $this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|callback_validateAge');
            $this->form_validation->set_rules('user_country', 'Country', 'trim');
            $this->form_validation->set_rules('user_state', 'State', 'trim');
            $this->form_validation->set_rules('customer_city', 'City', 'trim|min_length[2]|xss_clean|alpha_numeric');
            
            //$this->form_validation->set_rules('customer_city', 'City', '');
            
            $this->form_validation->set_rules('user_address', 'Address', 'trim|max_lenght[100]');
            $this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|exact_length[6]|numeric');
            $this->form_validation->set_rules('user_gender', 'Gender', 'trim');
            $this->form_validation->set_rules('user_status', 'Status', 'trim');
            $this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
			$randompass = randomPassword();
            if ($this->form_validation->run()) {
				$user_email  = $this->input->post('user_email');
				$responce = $this->user_model->createNewUsers('nw_user_tbl', [
					'user_type' => 2,
					'email'     => $this->input->post('user_email'),
					//'password'  => md5($this->input->post('password')),
					'password'  => md5($randompass),
					'status'    => (int)$this->input->post('user_status'),
					'created'   => date('Y-m-d H:i:s'),
					'last_login'=> date('Y-m-d H:i:s'),
					'login_status'=> 0,
					'activation_code'=> md5('test@123')
				]);
				if ($responce) {
					if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
						$filename = $_FILES['user_photo']['name'];
						$tmp_path = $_FILES['user_photo']['tmp_name'];
						$image_name = uploadImage($filename, $tmp_path, 'profile', '140');
					}else{
						$image_name = '';
					}
					$countrydata= $this->user_model->getCountryList($this->input->post('user_country'));
					$countryName= ($countrydata !='') ? $countrydata->name:'';
					$stateList  = $this->user_model->getStateList($this->input->post('user_state'));
					$stateName  = ($stateList !='') ? $stateList->name:'';
					$cityName   = $this->input->post('customer_city');
					$getGeoData = _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
					//$dob = date('Y-m-d',strtotime());
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
					
					$customerresponce = $this->user_model->createNewUsers('nw_customer_tbl', [
						'user_id'   => $responce,
						'title'     => $this->input->post('title'),
						'name'      => $name,
						'sname'     => $sname,
						'age'       => $age,
						'dob'       => $dob,
						'gender'    => $this->input->post('user_gender'),
						'address'   => $this->input->post('user_address'),
						'country_id'=> $country_id,
						'state_id'  => $this->input->post('user_state'),
						'city_id'   => $cityName,
						'zip'       => $this->input->post('pin_code'),
						'mobile'    => $mobile,
						'photo'     => $image_name,
						'latitude'  => ($getGeoData !='') ? $getGeoData['lat']:'',
						'longitude' => ($getGeoData !='') ? $getGeoData['long']:'',
						'status'    => 1,
						'created'   => date('Y-m-d H:i:s')
					]);
					if(!empty($customerresponce)){
						$subject="File Notice- Customer Registration";
							$name 	= $this->input->post('user_name');
							$email 	= $this->input->post('user_email');
							/* $message='Hello '.$this->input->post('user_name').',<br><br>Welcome to Filenotice.com.<br><br> You have register on my portal.<br><br><br>Your login detail is <br><br> Username : '.$this->input->post('user_email').'<br>Password : '.$randompass.' Thanks'; */
							$loginurl = FRONTEND_URL .'login';
							$msg = $this->getMailData($name,$email,$randompass,$loginurl);
							$from = "Filenotice <coffee@filenotice.com>";
							$header = "From: $from\r\n";
							$header .= "Content-type: text/html; charset=utf-8";

							$responsemail = mail($email,$subject,$msg,$header);
							
							$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Customer has been created successfully.'));
							redirect(base_url($this->session->userdata('admins')['user_type'].'/customer/customer_list'));
					}else {
						$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
					}
				}else {
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'WORNING','message'=>'Something went wrong.'));
				}
            }
        }
        _manage_template('templates/header', 'templates/footer', 'customer/create', $data, 'templates/left_adminMenu');
    }
        
    public function view() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('admins')['user_type'].'/customer/customer_list'));
        };
        $data['section_name'] = "Customer Management";
        $data['page_title'] = $data['site_title'] = "Customer View";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('admins')['user_type'].'/customer');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="'.$pageUrl.'/view/'.$id.'">' . $data['page_title'] . '</a></li></ol>';
        $data['row'] = $this->user_model->getCustomer($id);
		if(!empty($data['row'])){
			_manage_template('templates/header', 'templates/footer', 'customer/view', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/customer/customer_list'));
		}
    }

    public function edit() {
        $id = $this->uri->segment(4);

        if(empty($id)){
            redirect(base_url($this->session->userdata('admins')['user_type'].'/customer/customer_list'));
        };
        $data['section_name']= "Customer Management";
        $data['page_title']  = $data['site_title'] = "Edit Customer";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('admins')['user_type']. '/customer/edit/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list') . '">Customer</a></li>'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl.'">' . $data['page_title'] . '</a></li></ol>';
        $data['coustomer']   = $customerData = $this->user_model->getCustomer($id);
		if(!empty($data['coustomer'])){
			$data['countryList'] = $this->user_model->getCountryList();
			if($this->input->server('REQUEST_METHOD')==="POST"){
				$this->form_validation->set_rules('user_name', 'Customer Name', 'trim|required|min_length[2]|callback__alpha_dash_space');
				$this->form_validation->set_rules('user_email', 'Email address', 'trim|required|valid_email|callback_validateEmail['.$id.']');
				$this->form_validation->set_rules('password', 'Password', 'min_length[6]');
				$user_mobile = $this->input->post('user_mobile');
				$this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required');
				$this->form_validation->set_rules('user_dob', 'Date of Birth', 'trim|callback_validateAge');
				$this->form_validation->set_rules('user_country', 'Country', 'trim');
				$this->form_validation->set_rules('user_state', 'State', 'trim');
				$this->form_validation->set_rules('user_city', 'City', 'trim|min_length[2]|xss_clean|alpha_numeric');
				
				$this->form_validation->set_rules('user_address', 'Address', 'trim');
				$this->form_validation->set_rules('pin_code', 'Pin Code', 'trim|exact_length[6]|numeric');
				$this->form_validation->set_rules('user_gender', 'Gender', 'trim');
				$this->form_validation->set_rules('user_status', 'Status', 'trim');
				$this->form_validation->set_rules('user_photo', 'Profile Picture', 'callback_userProflephoto');
				if ($this->form_validation->run()) {
					$countrydata= $this->user_model->getCountryList($this->input->post('user_country'));
					$countryName= ($countrydata !='') ? $countrydata->name:'';
					$stateList  = $this->user_model->getStateList($this->input->post('user_state'));
					$stateName  = ($stateList !='') ? $stateList->name:'';
					$cityName   = $this->input->post('customer_city');
					$getGeoData = _getGEOLocationByAddress($countryName.','.$stateName.','.$this->input->post('user_address').','.$cityName);
					/* $dt = $this->input->post('user_dob');
					if($dt!=''){
						$dat = date('Y-m-d', strtotime($this->input->post('user_dob')));
					}else{
						$dat = Null;
					} */
					if(!empty($this->input->post('user_dob'))){
						$dat = date('Y-m-d', strtotime($this->input->post('user_dob')));
					}else{
						$dat = date('Y-m-d', strtotime('-18 years'));
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
					$updateArr = array(
						'id'        => $id,
						'title'     => $this->input->post('title'),
						'name'      => $name,
						'sname'     => $sname,
						'age'       => $age,
						'mobile'    => $mobile,
						'dob'       => $dat,
						'address'   => $this->input->post('user_address'),
						'country_id'=> $country_id,
						'state_id'  => $this->input->post('user_state'),
						'city_id'   => $this->input->post('user_city'),
						'zip'       => $this->input->post('pin_code'),
						'gender'    => $this->input->post('user_gender'),
						'latitude'  => ($getGeoData !='') ? $getGeoData['lat']:'',
						'longitude' => ($getGeoData !='') ? $getGeoData['long']:'',
						'modified'  => date('Y-m-d H:i:s')
					);
				   
					if(!empty($_FILES) && !empty($_FILES['user_photo']['name'])){
						$filename = $_FILES['user_photo']['name'];
						$tmp_path = $_FILES['user_photo']['tmp_name'];
						$image_name = uploadImage($filename, $tmp_path, 'profile', '140');
						$updateArr['photo'] = $image_name;
						unlinkImage('uploads/profile/',$customerData->photo);
					}
					$this->user_model->updateCustomer($updateArr);
					
					$user_data = array(
						'user_id'   => $id,
						'status'    => (int)$this->input->post('user_status'),
						'email'     => $this->input->post('user_email'),
						'modified'  => date('Y-m-d H:i:s')
						);
					 if(!empty($this->input->post('password'))) {
						$user_data['password'] = md5($this->input->post('password'));
					}

					if($this->input->post('user_status')==1 && $this->input->post('email_s')==0){
						 $user_data['email_status'] = 1;
					}
					  
					if($this->input->post('user_status')==0 && $this->input->post('email_s')==1){
						 $user_data['email_status'] = 0;
					}

					if($this->input->post('user_status')==0 && $this->input->post('email_s')==0){
						 $user_data['email_status'] = 0;
					}
						   
					if( $user_data['email_status'] == 1)
					{
						$url = FRONTEND_URL;       
						$link = $url."/login"; 
						$email = $this->input->post('user_email');
						$name = $this->input->post('user_name');
						$to=$email;
						$subject="File Notice- Account Approved";
						$message='Hello '.$name.',<br><br>Welcome to Filenotice.com.<br><br>Your profile has been activated. Complete your profile by updating your information.Please click on the link given below:</br></br>
						'.$link.'
						<br><br><br>Thanks';
						$from = "Filenotice <coffee@filenotice.com>";
						$header = "From: $from\r\n";
						$header .= "Content-type: text/html; charset=utf-8";

						mail($to,$subject,$message,$header);
						
					}
					$responce = $this->user_model->updateUser($user_data);
					
					$wordpress_data = array(
							'user_login' => $this->input->post('user_email'),
							'user_email' => $this->input->post('user_email')
						);
					 if(!empty($this->input->post('password'))) {
						$wordpress_data['user_pass'] = md5($this->input->post('password'));
						}

					   if($this->input->post('user_status')==1){
						   // echo "hi";
						   // exit;
					   }
						//$this->user_model->update_wordpress_user($wordpress_data, $this->input->post('user_email'));
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Customer record has been updated successfully.'));
					redirect(base_url($this->session->userdata('admins')['user_type'].'/customer/customer_list'));
				}
			}
			_manage_template('templates/header', 'templates/footer', 'customer/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'Error','message'=>'No data found.'));
			redirect(base_url($this->session->userdata('user_type') . '/admin/customer/customer_list'));
		}
    }

    public function updateRecords() {
        $id 	= $this->input->post('uid');
        $status = $this->input->post('status');
        $action = $this->input->post('action');
        $table 	= $this->input->post('table');
        $email 	= $this->input->post('email');
        $name 	= $this->input->post('name');
        if($action=='delete'){
            $return = $this->user_model->deleteUsers($id,'nw_customer_tbl');
            $status = true;
            $message = 'Record has been Successfully deleted.';
            $style_color = 'green';
            $redirectURL = base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list');
        }else{
         
            if($status=='1'){
                $statuss = 0;
                $emailstatus = 0;
            }else{
                $statuss = 1;
                $emailstatus = 1;
            }
			if($emailstatus==1){
				$url = FRONTEND_URL;       
				$link = $url."login"; 
				$to = $email;
				$subject="File Notice- Account Approved";
				//$message='Hello '.$name.',<br><br>Welcome to Filenotice.com.<br><br>Your profile has been activated. Complete your profile by updating your information.Please click on the link given below:</br></br>
				$message = $this->getAproveMailData($name,'','',$link);
				$from = "Filenotice <coffee@filenotice.com>";
				$header = "From: $from\r\n";
				$header .= "Content-type: text/html; charset=utf-8";

				mail($to,$subject,$message,$header);
			}   
            $return = $this->user_model->updateUser(array('user_id'=>(int)$id,"status"=>$statuss,"email_status"=>$emailstatus));
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
            $redirectURL = base_url($this->session->userdata('admins')['user_type']. '/customer/customer_list');
        }
        
        $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
        echo $ajaxResponse;
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
															$html .= '<h2 style="font-size: 20px;font-family:helvetica, sans-serif;">Dear &nbsp;&nbsp;'.$name.',</h2>';
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
	
}
