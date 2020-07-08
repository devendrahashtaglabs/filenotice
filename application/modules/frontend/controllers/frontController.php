<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class frontController extends MX_Controller {

    public function __construct() {		
        parent::__construct();
		$this->load->library('session');
		$this->load->model('frontend_model');
		$usersession 	= $this->session->userdata('users');
		$adminsession 	= $this->session->userdata('admins');
		$agentsession	= $this->session->userdata('agents');
		$last = end($this->uri->segments); 
        if ($last == 'login') {	
			if(!empty($usersession) || !empty($adminsession) || !empty($agentsession)){
				if(!empty($usersession)){
					$redirect_url = FRONTEND_URL . 'dashboard';
					redirect($redirect_url);
				}elseif(!empty($adminsession)){
					$redirect_url = FRONTEND_URL . 'admin/dashboard';
					redirect($redirect_url);
				}else{
					$redirect_url = FRONTEND_URL . 'agent/dashboard';
					redirect($redirect_url);
				}
			}else{
				$redirect_url = FRONTEND_URL . 'login';
				/* echo '<pre>'; print_r($usersession); echo '</pre>'; //die(__FILE__ . " On  ". __LINE__);*/
				//redirect($redirect_url);
				//$this->login();
				//redirect(base_url().'login');
			}
		}
    }
	
	public function checklogin(){

		$usersession 	= $this->session->userdata('users');
		$adminsession 	= $this->session->userdata('admins');
		$agentsession	= $this->session->userdata('agents');
		
		if(empty($usersession) || empty($adminsession) || empty($agentsession)){
			redirect(base_url().'login');
		}else{
			if(!empty($usersession)){
					$redirect_url = FRONTEND_URL . 'dashboard';
					redirect($redirect_url);
				}elseif(!empty($adminsession)){
					$redirect_url = FRONTEND_URL . 'admin/dashboard';
					redirect($redirect_url);
				}else{
					$redirect_url = FRONTEND_URL . 'agent/dashboard';
					redirect($redirect_url);
				}
		}
	
	}
	
	public function index(){
		$last = end($this->uri->segments);  
        if ($last != 'login') {	
			redirect(base_url().'login');
		}
		$data['section_name']= "Filenotice";
        $data['page_title']  = $data['site_title'] = "Filenotice";
		_manage_template('templates/header', 'templates/footer', 'templates/index', $data);
	}
	public function login() {
        $short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']= "User Sign In";
        $data['page_title']  = $data['site_title'] = "User Sign In";
        $data['pageUrl']     = $pageUrl = base_url('/login');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$data['allcity']	= $citydata = $this->frontend_model->getCityList('','');
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run()) {
                if(!empty($this->input->post('username')) && !empty($this->input->post('password'))){
					$responce = $this->user_model->_getUserByKeyValue('email', $this->input->post('username'), array('2', '3', '4'));
					$email 		= $this->input->post('username');
					$password 	= $this->input->post('password');
					$enpass		= md5($password);
					if (empty($responce)) {
						$full_msg = 'The email id you entered is incorrect.';
						$redirect = $pageUrl;
					}elseif($responce->password == $enpass){
						if($responce->status !=1){
							if($responce->user_type == '2'){
								$class_name = DANGER_ALERT;
								$full_msg = 'Customer is inactive contact to Admin.';
								$redirect = $pageUrl;
							}elseif($responce->user_type == '3'){
								$class_name = DANGER_ALERT;
								$full_msg = 'Consultant is inactive contact to Admin.';
								$redirect = $pageUrl;
							}else{
								$class_name = DANGER_ALERT;
								$full_msg = 'Agent is inactive contact your consultant.';
								$redirect = $pageUrl;
							}
						}else{
							$sesresponce = $this->setDataIntoSession($responce);
							if ($sesresponce) {
								$this->updateLogin($responce->id, array('login_status' => 1, 'current_login' => date('Y-m-d H:i:s')));
								$class_name		= SUCCESS_ALERT;
								$short_msg 		= 'Success';
								if($responce->user_type == '3'){
									$consultantdata = $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$responce->id);
									if(!empty($consultantdata->certificates)){
										$full_msg  		= 'Successfully Login.';
									}else{
										$full_msg  		= 'Login successfully, Please update your profile for getting any case.';
									}
								}else{
									$full_msg  		= 'Successfully Login.';
								}
								$ticketformdata = $this->session->userdata('ticketformdata');
								if(empty($ticketformdata)){
									if($responce->user_type == '4'){
										$redirect  = base_url('agent/dashboard');
									}else{
										$redirect  = base_url('dashboard');
									}
								}else{
									$ticketurl = base_url().'payment';
									$redirect  = $ticketurl;
								}
							}else{
								$class_name = DANGER_ALERT;
								$full_msg  = 'Somwthing went wrong.';
								$redirect  = $pageUrl;
							}
						}
					}else{
						$class_name = DANGER_ALERT;
						$full_msg = 'The entered password is incorrect.';
						$redirect = $pageUrl;
					}
					$this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
					redirect($redirect);
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'templates/login', $data);
    }
	
	public function updateLogin($userId, $data) {
        $responce = $this->user_model->updateRecordsById('id', $userId, $data);
        return $responce;
    }

    public function setDataIntoSession($responce) {
        $return = false;
        $userData= $this->user_model->getUserDetailsById($responce->id,$responce->user_type);
        $roleType= $this->user_model->getDataBykey('nw_role_tbl', 'id', $responce->user_type, 'role_name')->role_name;
		if($responce->user_type == '4'){
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
		}else{
			$this->session->set_userdata('users',array(
					'user_id'     => $responce->id,
					'user_type'   => $roleType,
					'user_email'  => $responce->email,
					'user_name'   => $userData->name,
					'user_status' => $responce->status,
					'is_logged_in'=> true
				)
			);
			if (!empty($this->session->userdata('users'))) {
				$return = true;
			}
		}
        
        return $return;
    }
    public function registration() {
		$class_name= INFO_ALERT;
		$short_msg = 'Failed';
        $data['section_name']= "Customer Sign Up";
        $data['page_title']  = $data['site_title'] = "Customer Sign Up";
        $data['pageUrl']     = $pageUrl = base_url('/registration');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$defaultState 			= '38'; //default Uttar Pradesh State  
		$data['defaultcitylist'] = $this->user_model->getCityList('',$defaultState); 
		$data['category'] 		 = $this->user_model->getParentCategory(); 
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
        if ($this->input->server('REQUEST_METHOD') === "POST") {
			/***** google captcha ****/
				$secretKeydata  = $this->frontend_model->getSettingDataByKey('gr_secretkey');
				$secretKey		= !empty($secretKeydata)?$secretKeydata->key_value:'';
				$captcha_response = $this->input->post('g-recaptcha-response');
				if(!empty($captcha_response)){
					// Get verify response data
					$gr_url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$captcha_response;
					$verifyResponse = file_get_contents($gr_url);
					$responseData = json_decode($verifyResponse);
					if($responseData->success){
						//Contact form submission code goes here ...
						$statusMsg = 'Your contact request have submitted successfully.';
					}else{
						$class_name = DANGER_ALERT;
						$short_msg = 'Failed!';
						$full_msg = 'Robot verification failed, please try again.';
						$redirect = $pageUrl;
					}
				}else{
					$class_name = DANGER_ALERT;
					$short_msg = 'Failed!';
					$full_msg = 'Robot verification failed, please try again.';
					$redirect = $pageUrl;
				} 
			/***** google captcha ****/
            $this->form_validation->set_rules('fname', 'Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[nw_user_tbl.email]');
			$this->form_validation->set_message('is_unique', 'Email id is already registered, please use different email id.');
			$data['postdata'] = $this->input->post();
			if ($this->form_validation->run()) {
				
				$redirect_url	= base_url('registration');
				$getids 		= $this->input->post('getids');
				$allcatarray	= $this->getselectedcatsubcat($getids,$redirect_url);
				$category_id 	= $allcatarray['category'];
				$subcategory_id = $allcatarray['subcategory'];
				$userType 		= $this->input->post('user');
				$title 			= $this->input->post('title');
				$user_name 		= $this->input->post('fname');
				$surname 		= $this->input->post('sname');
				
				$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $user_name)));
				$lowercaseTitle = strtolower($new_string); 
				$name 			= ucwords($lowercaseTitle);
				
				$new_stringsur 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $surname)));
				$lowercaseSname = strtolower($new_stringsur); 
				$sname 			= ucwords($lowercaseSname);
				
				$email 			= $this->input->post('email');
				//$now 			= current_time('mysql', false);
				$logStatus 		= 0;
				$userphone 		= $this->input->post('phone');
				$str 			= preg_replace("/[^A-Za-z0-9 ]/", '', $userphone);
				$phone 			= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
				$pass 			= $this->input->post('c_password');
				$copass 		= $this->input->post('co_password');
				$gender 		= $this->input->post('gender');
				$age 			= $this->input->post('customer_age');
				if(!empty($this->input->post('c_dob'))){
					$dob 		= date('Y-m-d', strtotime($this->input->post('c_dob')));
				}else{
					$dob		= '';
				}
				if(!empty($this->input->post('co_dob'))){
					$co_dob 	= date('Y-m-d', strtotime($this->input->post('co_dob')));
				}else{
					$co_dob		= '';
				}
				$country 		= $this->input->post('c_country');
				$state 			= $this->input->post('c_state');
				$city 			= $this->input->post('c_city');
				$pin 			= $this->input->post('c_pin');
				$address 		= trim($this->input->post('c_address'));
				if(empty($copass)){
					$userpassword 	= md5($pass);
				}else{
					$userpassword 	= md5($copass);
				}
				$accountType  	= $this->input->post('acc_type');
				$category  		= $this->input->post('acc_cat');
				$subcategory  	= !empty($this->input->post('subcat_id'))?$this->input->post('subcat_id'):'0';
				if($userType == '2'){
					$status = '1';
				}else{
					$status = '0';
				}
				$responceid = $this->user_model->createNewUsers('nw_user_tbl', [
						'user_type'    		=> $userType,
						'email'        		=> $email,
						'password'     		=> $userpassword,
						'status'       		=> $status,
						'created'      		=> date('Y-m-d H:i:s'),
						'last_login'   		=> date('Y-m-d H:i:s'),
						'login_status' 		=> 0,
						'activation_code'	=> md5('test@123')
					]
				);
				$permitted_chars 	= '0123456789abcdefghijklmnopqrstuvwxyz';
				$randnum			= substr(str_shuffle($permitted_chars), 0, 10);
				$randtime 			= date('His');
				$randstring			= $randnum.$randtime;
				if(empty($age)){
					$age 			= (date('Y') - date('Y',strtotime($dob)));
				}
				if(!empty($responceid)){
					if($userType == 2){
						$customerid = $this->user_model->createNewUsers('nw_customer_tbl', [
								'user_id'   => $responceid,
								'title'     => $title,
								'name'      => $name,
								'sname'     => $sname,
								'age'    	=> $age,
								'dob'    	=> $dob,
								'gender'    => $gender,
								'mobile'    => $phone,
								'address'   => '',
								'country_id'=> '88',
								'state_id'	=> '',
								'city_id'	=> '',
								'zip'		=> '',
								'created'   => date('Y-m-d H:i:s'),
							]
						);
						if(!empty($customerid)){
							$class_name = SUCCESS_ALERT;
							$short_msg 	= 'Success';
							$full_msg 	= 'Customer created successfully.';
							$redirect 	= base_url().'login';
						}
					}else{
						$consultantid 		= $this->user_model->createNewUsers('nw_consultant_tbl',array(
								'user_id'       	=> $responceid,
								'title'     		=> $title,
								'name'      		=> $name,
								'sname'     		=> $sname,
								'dob'    			=> $co_dob,
								'gender'    		=> $gender,
								'address'   		=> $address,
								'country_id'		=> $country,
								'state_id'			=> $state,
								'city_id'			=> $city,
								'zip'				=> $pin,
								'mobile'        	=> $phone,
								'account_type'  	=> $accountType,
								'category_id'  		=> $category_id,
								'subcategory_id'	=> $subcategory_id,
								'email_verify_code' => $randstring, 
								'created'       	=> date('Y-m-d H:i:s'), 
							)
						);
						
						if(!empty($consultantid)){
							$class_name = SUCCESS_ALERT;
							$short_msg = 'Success';
							$full_msg = 'Consultant created successfully.';
							$redirect = base_url().'login';
						}
					}
				}else{
					$class_name = DANGER_ALERT;
					$full_msg = 'Something went wrong!';
					$redirect = $pageUrl;
				}
				$link    = base_url()."/login"; 
				$to		 = $email;
				$subject = "File Notice- User Registration";
				if($userType == 3){
					$verifyemaillink 	= base_url().'verify_email/?verifycode='.$randstring;
					$message 			= $this->getMailData($userType,$verifyemaillink);
				}else{
					$message 			= $this->getMailData($userType);
				}
				$from 	= "Filenotice <coffee@filenotice.com>";
				$header = "From: $from\r\n";
				$header .= "Content-type: text/html; charset=utf-8";
				mail($to,$subject,$message,$header);
				$this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
				redirect($redirect);
			}
		}
		_manage_template('templates/header', 'templates/footer', 'templates/registration', $data);
	}
	public function getsubcatbycatid(){
        $catId      = $this->input->post('catId');
        $html 		= "";
        $sections   = $this->user_model->getsubcategory($catId);
        if(isset($sections)){
            foreach($sections as $res){
                $html .= '<option value="'. $res->id .'">'. $res->name .'</option>'; 
            }
        }else{
            $html .= '<option value=" ">No category Mapped.</option>'; 
        }
        print_r($html);
    }
	
	public function forgetpassword(){
		$short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']= "Forget Password";
        $data['page_title']  = $data['site_title'] = "Forget Password";
        $data['pageUrl']     = $pageUrl = base_url('/forgetpassword');
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
		if ($this->input->server('REQUEST_METHOD') === "POST") {
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run()) {
				$email = $this->input->post('email');
                $responce = $this->user_model->_getUserByKeyValue('email', $email, array('2','3','4'));
                if (empty($responce)) {
					$class_name = DANGER_ALERT;
                    $full_msg = ' Email id not exits.';
                    $redirect = $pageUrl;
                }else if (!empty($responce) && $responce->status != '1') {
					$class_name = DANGER_ALERT;
                    $full_msg = ' Your account is under admin review process . Please contact to admin.';
                    $redirect = $pageUrl;
                }else{
					if(!empty($responce)){ 
						$user_id 		= $responce->id;
						$user_type 		= $responce->user_type;
						$userDetails 	= '';
						if($user_type == '2'){
							$userDetails = $this->user_model->getDataBykey('nw_customer_tbl','user_id',$user_id); 
						}elseif($user_type == '3'){				
							$userDetails = $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$user_id); 
						}else{
							$userDetails = $this->user_model->getDataBykey('nw_agent_tbl','user_id',$user_id); 
						}
						$activation_hash = md5(uniqid(mt_rand(), true));
						$link = base_url()."resetpassword/?activationid=".$activation_hash; 
						$updatedata	= array('activation_code' => $activation_hash,'reset_status' => 1);
						$success = $this->user_model->updateRecordsById('email',$email,$updatedata); 
						if($success){
							$name = isset($userDetails->name)?$userDetails->name:'';
							$to = $email;
							$subject="File Notice - Reset Your password";
							
							$message= $this->getforgetMailData($name,$link);

							$from 	= "Filenotice <coffee@filenotice.com>";
							$header = "From: $from\r\n";
							$header .= "Content-type: text/html; charset=utf-8";
							$sentmail = mail($to,$subject,$message,$header);
							if($sentmail){
								$class_name = SUCCESS_ALERT;
								$short_msg 	= 'Success';
								$full_msg 	= ' Password reset link sent to register email ID.';
								$redirect 	= $pageUrl;
							}
						}
					}
                }
                $this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
                redirect($redirect);
            } 
        }
		_manage_template('templates/header', 'templates/footer', 'templates/forgetpassword', $data);
	}
	public function resetpassword(){
		$short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']	= "Reset Password";
        $data['page_title']  	= $data['site_title'] = "Reset Password";
		$data['activationid'] 	= $activationid = $this->input->get('activationid');
        $data['pageUrl']     	= $pageUrl = base_url().'resetpassword/?activationid='.$activationid.'';
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
		if ($this->input->post('submitpassword')) {
			$newp 		= $this->input->post('newpassword');
			$confirmp 	= $this->input->post('confirmpassword');
			$pass 		= md5($confirmp);
			$userData	= $this->user_model->getActivationdetail('activation_code',$activationid); 
			$user 		= $this->user_model->getDataBykey('nw_user_tbl','email', $userData->email );
			$success_user = $this->user_model->updateRecordsById('activation_code',$activationid,array('password' =>  $pass, 'reset_status' => 0));
			if($success_user) {
				$class_name = SUCCESS_ALERT;
				$short_msg 	= 'Success';
				$full_msg 	= ' Password updated successfully.';
				$redirect 	= $pageUrl;
				
			} else {
				$class_name = DANGER_ALERT;
				$short_msg 	= 'Failed';
				$full_msg 	= ' You have made no changes to save.';
				$redirect 	= $pageUrl;
			}
			$this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
			redirect($redirect);
		}   
		_manage_template('templates/header', 'templates/footer', 'templates/resetpassword', $data);
	}
	public function getMailData($usertype,$verifylink = null){
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
                                                              $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000; margin-left:20px;"> <span style="font-family:helvetica, sans-serif;color:#000000;">Thank you for the registration..</span><br /><br/>';
															  if($usertype == 3){
															   $html .= '<span>Your Submission has been registered and waiting for approval from administration.</span><br/>';
															  }else{
																 $html .= '<span>Your Submission has been registered and you can login by clicking on <a href="'.FRONTEND_URL.'login" target="_blank">Login</a>.</span><br/>';  
															  }
															  if($usertype == 3){
																$html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to verify email : <a href="'.$verifylink.'" target="_blank">'.$verifylink.'</a></span><br />';
															  }
															  $html .='<span>For any help, please contact us at : <a href="mailto:coffee@hashtaglabs.biz">coffee@hashtaglabs.biz</a></span><br/><br/><span>Hope you will have benefit from our services.</span><br/><br/>';
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
	public function getforgetMailData($name,$loginurl){
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
                                                          </table>
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
                                                              $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000; margin-left:20px;"> <span style="font-family:helvetica, sans-serif;color:#000000;">It look you had requested for new password.</span><br /><span>If that sounds right, you can enter new password by clicking on below link.</span><br/>';
                                                                 $html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to reset password : <a href="'.$loginurl.'" target="_blank">'.$loginurl.'</a></span><br />';
                                                              $html .= '<p style="line-height:20px;font-family:helvetica, sans-serif;color:#000000; margin-left:20px;"> <span style="font-family:helvetica, sans-serif;color:#000000;">"This link will be valid for next 12 hours"</span><br /><span>For any help, please contact us at : coffee@hashtaglabs.biz</span><br/>';
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
	public function getCityListdata(){
		$stateId = $this->input->post('stateId');
		$allcitybystateid = $this->user_model->getCityList('',$stateId);
		if(isset($allcitybystateid)){
            foreach($allcitybystateid as $res){
                $html .= '<option value="'. $res->city_id .'">'. $res->city_name .'</option>'; 
            }
        }else{
            $html .= '<option value=" ">No City Mapped.</option>'; 
        }
        print_r($html);
	}
	public function about(){
		$data['section_name']	= "Filenotice";
        $data['page_title']  	= $data['site_title'] = "About Us";
		$data['banner_active'] 	= true;
		$data['banner_img'] 	= "img_bg_1.jpg";
		$data['allcity']		= $citydata 	= $this->frontend_model->getCityList('','');
		$data['allcategory']	= $categorydata = $this->user_model->getParentCategory();
		$usersession 			= $this->session->userdata('users');
		$adminsession 			= $this->session->userdata('admins');
		$agentsession			= $this->session->userdata('agents');
		if(!empty($usersession)){
			$data['logout'] 	= base_url().'logout';
			$data['dashboard'] 	= base_url().'dashboard';
		}elseif(!empty($adminsession)){
			$data['logout'] 	= base_url().'admin/logout';			
			$data['dashboard']	= base_url().'admin/dashboard';			
		}elseif(!empty($agentsession)){
			$data['logout'] 	= base_url().'agent/logout';			
			$data['dashboard'] 	= base_url().'agent/dashboard';			
		}else{
			$data['logout'] = '';
			$data['dashboard'] = '';
		}
		_manage_template('templates/header', 'templates/footer', 'templates/about', $data);
	}
	public function contact(){
		$data['section_name']	= "Filenotice";
        $data['page_title']  	= $data['site_title'] = "Contact Us";
		$data['banner_active'] 	= true;
		$data['banner_img'] 	= "img_bg_1.jpg";
		$usersession 			= $this->session->userdata('users');
		$adminsession 			= $this->session->userdata('admins');
		$agentsession			= $this->session->userdata('agents');
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
		$data['allcategory']	= $categorydata = $this->user_model->getParentCategory();
		if(!empty($usersession)){
			$data['logout'] = base_url().'logout';
			$data['dashboard'] = base_url().'dashboard';
		}elseif(!empty($adminsession)){
			$data['logout'] = base_url().'admin/logout';			
			$data['dashboard'] = base_url().'admin/dashboard';			
		}elseif(!empty($agentsession)){
			$data['logout'] = base_url().'agent/logout';			
			$data['dashboard'] = base_url().'agent/dashboard';			
		}else{
			$data['logout'] = '';
			$data['dashboard'] = '';
		}
		_manage_template('templates/header', 'templates/footer', 'templates/contact', $data);
	}
	public function getselectedcatsubcat($getids,$redirect_url){
		$catids			= [];
		$allsubcatids	= [];
		if(!empty($getids)){
			$allcatids 		= explode(',',$getids);
			foreach($allcatids as $catsid){
				$catdata = $this->user_model->get_category_data($catsid);
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
			$getSubCat = $this->user_model->get_category_data($subcatid);
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
	public function verify_email(){
		$verificationcode = $this->input->get('verifycode');
		$consultantdata = $this->user_model->getDataBykey('nw_consultant_tbl','email_verify_code',$verificationcode);
		if($consultantdata->verify_email == '0'){
			$response = $this->user_model->updatetableRecordsByColumn('nw_consultant_tbl','email_verify_code',$verificationcode,[
				'verify_email' => '1',
			]);
			if($response){
				$data['section_name']	= "Filenotice";
				$data['page_title']  	= $data['site_title'] = "Verify Email";
				$usersession 			= $this->session->userdata('users');
				$adminsession 			= $this->session->userdata('admins');
				$agentsession			= $this->session->userdata('agents');
				$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
				$data['allcategory']	= $categorydata = $this->user_model->getParentCategory();
				if(!empty($usersession)){
					$data['logout'] = base_url().'logout';
					$data['dashboard'] = base_url().'dashboard';
				}elseif(!empty($adminsession)){
					$data['logout'] = base_url().'admin/logout';			
					$data['dashboard'] = base_url().'admin/dashboard';			
				}elseif(!empty($agentsession)){
					$data['logout'] = base_url().'agent/logout';			
					$data['dashboard'] = base_url().'agent/dashboard';			
				}else{
					$data['logout'] = '';
					$data['dashboard'] = '';
				}
				$this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'Success!', 'message' => 'Your email verification is completed successfully.'));
				_manage_template('templates/header', 'templates/footer', 'templates/verify_email', $data);
			}
		}else{
			$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'Failed!', 'message' => 'Your email already verified.'));
			$redirectUrl = base_url().'login';
			redirect($redirectUrl);
		}
	}
	public function getsubcatdetailbyid(){
		$subcatid 			= $this->input->post('subcatid');
		$subcategorydata 	= $this->user_model->get_category_data($subcatid);
		$subcatdetail 		= [];
		if(!empty($subcategorydata)){
			$subcatdetail['name'] 		= $subcategorydata->name;
			$subcatdetail['amount'] 	= $subcategorydata->amount;
			//$json_form					= $subcategorydata->json_form;
			//$subcatdetail['json_form'] 	= '<script>$("#newjsonforms").jsonForm({'.$json_form.'}); </script>';
			$faqid 	= $subcategorydata->faq;
			$faqids = explode(',',$faqid);
			$count 	= 1;
			$html	= '';
			foreach($faqids as $faq){
				if($count == 1){
					$in = 'in';
				}else{
					$in = '';					
				}
				$faqdata = $this->frontend_model->getDataBykey('nw_faq_tbl','id',$faq);
				if(!empty($faqdata)){
				$html .= '<div class="panel panel-default">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$count.'"><span class="glyphicon glyphicon-menu-right"></span> '.$faqdata->faq_que.'</a>
								</h4>
							</div>
							<div id="collapse'.$count.'" class="panel-collapse collapse '.$in.'">
								<div class="panel-body">
									'.$faqdata->faq_ans .'<a href="'.$faqdata->read_more_link.'" target="_blank">Read more.</a>
								</div>
							</div>
						</div>';
					$count++; 
				}
			}
			$subcatdetail['faqhtml'] = $html;
		}
		echo json_encode($subcatdetail);
		exit(0);
	}
}	

?>