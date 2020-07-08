<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ticketController extends MX_Controller {

    public function __construct() {		
        parent::__construct();
		$this->load->library('session');		
		$this->load->model('frontend_model');		
    }
	public function index(){
		
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
	public function create_ticket(){
		$usersession 	= $this->session->userdata('users');
		$adminsession 	= $this->session->userdata('admins');
		$agentsession	= $this->session->userdata('agents');
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
		$data['section_name']	= "Ticket";
        $data['page_title']  	= $data['site_title'] = "Ticket Create";
        $data['pageUrl']     	= $pageUrl = base_url('create_ticket');
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		//if(!empty($usersession) && $usersession['user_type'] == 'customer'){
			
			$data['countryList']	= $this->user_model->getCountryList();
			$data['stateList']		= $this->user_model->getStateList('','88');
			$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
			$defaultState 			= '38'; //default Uttar Pradesh State  
			$data['defaultcitylist'] = $this->user_model->getCityList('',$defaultState); 
			$data['category'] 		 = $this->user_model->getParentCategory();
			$data['catids']			= $catids = $this->input->get('catid');
			$catidarray 			= base64_decode($catids);
			$catidstr				= explode('/',$catidarray);
			$data['catid'] 			= $catid = $catidstr[1];
			$data['subcategorylist']= $this->frontend_model->getsubcategory($catid);
			$data['catdata']		= $this->frontend_model->get_category_data($catid);
			if ($this->input->server('REQUEST_METHOD') === "POST"){
				$postdata 		= $this->input->post();
				$postsubcatid 	= $postdata['subcatid'];
				$postsubcatdata = $this->frontend_model->get_category_data($postsubcatid);
				if(!empty($postsubcatdata)){
					$postdata['name'] 	= $postsubcatdata->name;
					$postdata['amount'] = $postsubcatdata->amount;
				}
				$this->form_validation->set_rules('description', 'Description', 'trim|required|min_length[10]');
				$this->form_validation->set_rules('customer_country', 'Country', 'trim|required');
				$this->form_validation->set_rules('customer_state', 'State', 'trim|required');
				$this->form_validation->set_rules('customer_city', 'City', 'trim|required|max_length[100]');
				$this->form_validation->set_rules('customer_address', 'Address', 'trim|required|max_length[200]');
				$this->form_validation->set_rules('customer_pincode', 'Pincode', 'trim|required|max_length[6]');
				$this->form_validation->set_rules('customer_mobile', 'Mobile Number', 'trim|required');
				if ($this->form_validation->run()) {					
					$email = $this->input->post('email');
					$userdata 	= $this->user_model->getDataBykey('nw_user_tbl','email',$email);
					if(!empty($userdata) && $userdata->user_type == 3){
						$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'','message'=>'You are not eligible to create ticket.Please try with other email!'));
						
						$currentURL 	= current_url();
						$params   		= $_SERVER['QUERY_STRING'];
						$redirect_url 	= $currentURL . '?' . $params; 
						redirect($redirect_url);
					}else{
					
						$str 					= $this->input->post('categorytext');
						$len					= 3;
						$rndnumber 				= randomstring('2');
						$ticketname 			= substr(str_replace(" ", "", $str), 0, $len).'-'.date('mdh24is') . $rndnumber;
						$newticketname 			= strtoupper($ticketname);
						$postdata['ticketname'] = $newticketname;
						$imagename 				= $_FILES['image']['name'][0];
						$allfile				= [];
						/* if(!empty($imagename)){
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
						} */
						$ticketformdata = $this->session->userdata('ticketformdata');
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
							if(!empty($ticketformdata['imagename'])){
								$oldfilearray = json_decode($ticketformdata['imagename']);
								$newfilearray = array_merge($oldfilearray,$filearray);
							}else{
								$newfilearray = $filearray;
							}
							$filename 	  = json_encode($newfilearray);
						}else{
							$filename = $ticketformdata['imagename'];
						}
						//$casefiledata = json_encode($filearray);
						$postdata['imagename']	= $filename;
						
						$new_string 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $postdata['fname'])));
						$lowercaseTitle = strtolower($new_string); 
						$name 			= ucwords($lowercaseTitle);
						$postdata['fname'] = $name;
						
						$new_stringsur 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $postdata['sname'])));
						$lowercaseSname = strtolower($new_stringsur); 
						$sname 			= ucwords($lowercaseSname);
						$postdata['sname'] = $sname;
						
						$new_stringaddress 	= trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $postdata['customer_address'])));
						$lowercaseAddress 	= strtolower($new_stringaddress); 
						$address 			= ucwords($lowercaseAddress);
						$postdata['customer_address'] 	= $address;
						$customer_mobile			 	= $postdata['customer_mobile'];
						$str 							= preg_replace("/[^A-Za-z0-9 ]/", '', $customer_mobile);
						$postdata['customer_mobile'] 	= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
						$this->session->set_userdata('ticketformdata',$postdata);
						redirect(base_url().'getsubcatform');
						/* if(!empty($usersession) && $usersession['user_type'] == 'customer'){
							//$this->payment(); 
						}else{
							$fullname 	= $postdata['fname'] .' '.$postdata['sname'];
							$email 		= $postdata['email'];
							$userdata 	= $this->user_model->getDataBykey('nw_user_tbl','email',$email);
							if(empty($userdata)){
								$this->session->set_userdata('customlogin','registration');
								$msg = 'Dear '.$fullname.', please set password for profile, for completing registration.';
								$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'','message'=>$msg));
								$redirect_url = base_url().'customlogin';
								redirect($redirect_url); 
							}else{
								$this->session->set_userdata('customlogin','login');
								$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'You are already registered with, please enter password.'));
								$redirect_url = base_url().'customlogin';
								redirect($redirect_url); 
							}
						} */
					}
				}
			}
		/* }else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'You are not authorised user to create ticket.'));
			redirect(base_url());
		} */	
		_manage_template('templates/header', 'templates/footer', 'templates/ticket', $data);
	}
	public function getsubcatform() {
		$usersession 	= $this->session->userdata('users');
		$adminsession 	= $this->session->userdata('admins');
		$agentsession	= $this->session->userdata('agents');
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
		$short_msg 				= 'Failed';
        $class_name				= INFO_ALERT;
        $data['section_name']	= "Subcategory Form";
        $data['page_title']  	= $data['site_title'] = "Subcategory Form";
        $data['pageUrl']     	= $pageUrl = base_url('/getsubcatform');
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$data['countryList']		= $this->user_model->getCountryList();
		$data['stateList']			= $this->user_model->getStateList('','88');
		$data['allcity']			= $citydata = $this->frontend_model->getCityList('','');
		$defaultState 				= '38'; //default Uttar Pradesh State  
		$data['defaultcitylist'] 	= $this->user_model->getCityList('',$defaultState); 
		$data['category'] 		 	= $this->user_model->getParentCategory();
		$data['catids']				= $catids = $this->input->get('catid');
		$ticketformdata 			= $this->session->userdata('ticketformdata');
		$data['catid'] 				= $catid 	= $ticketformdata['catid'];
		$data['subcatid'] 			= $subcatid = $ticketformdata['subcatid'];
		$data['subcategorylist']	= $this->frontend_model->getsubcategory($catid);
		$data['catdata']			= $this->frontend_model->get_category_data($catid);
		$data['subcatdata']			= $this->frontend_model->get_category_data($subcatid);
		$ticketformdata = $this->session->userdata('ticketformdata');
		if ($this->input->server('REQUEST_METHOD') === "POST"){
			$postdata 		= $this->input->post();
			$userprofile	= $_FILES['Upload_Document'];
			$image_name		= '';
			if(!empty($_FILES) && !empty($_FILES['Upload_Document']['name'])){
				$filename 	= $_FILES['Upload_Document']['name'];
				$tmp_path 	= $_FILES['Upload_Document']['tmp_name'];
				$image_name = uploadImage($filename, $tmp_path, 'ticket', '140');
			}
			$postdata['Upload_Document'] 	= $image_name;
			$postdatas['subcatdata']		= $postdata;
			$ticketformdata 				= array_merge($ticketformdata,$postdatas);
			$this->session->set_userdata('ticketformdata',$ticketformdata);
			if(!empty($usersession) && $usersession['user_type'] == 'customer'){
				//$this->payment(); 
				$returnTicketId = $this->createticketonpaynow();
				$this->session->set_userdata('ticketresponsedata',$returnTicketId);
				$redirecturl = base_url().'payment';
				redirect($redirecturl);
			}else{
				$fullname 	= $ticketformdata['fname'] .' '.$ticketformdata['sname'];
				$email 		= $ticketformdata['email'];
				$userdata 	= $this->user_model->getDataBykey('nw_user_tbl','email',$email);
				if(empty($userdata)){
					$this->session->set_userdata('customlogin','registration');
					$msg = 'Dear '.$fullname.', please set password for profile, for completing registration.';
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'','message'=>$msg));
					$redirect_url = base_url().'customlogin';
					redirect($redirect_url);
				}else{
					$this->session->set_userdata('customlogin','login');
					$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'FAILED','message'=>'You are already registered with, please enter password.'));
					$redirect_url = base_url().'customlogin';
					redirect($redirect_url);
				}
			}
		}
        _manage_template('templates/header', 'templates/footer', 'templates/subcatform', $data);
	}
	public function customlogin() {
        $short_msg = 'Failed';
        $class_name= INFO_ALERT;
        $data['section_name']= "User Login";
        $data['page_title']  = $data['site_title'] = "User Login";
        $data['pageUrl']     = $pageUrl = base_url('/customlogin');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$defaultState 		= '38'; //default Uttar Pradesh State  
		$data['defaultcitylist'] = $this->user_model->getCityList('',$defaultState); 
		$data['category'] 		 = $this->user_model->getParentCategory(); 
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
        if ($this->input->post('loginsubmit')) {
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
									$returnTicketId = $this->createticketonpaynow();
									$this->session->set_userdata('ticketresponsedata',$returnTicketId);
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
		if ($this->input->post('registersubmit')) {
			/***** google captcha ****/
				$secretKeydata  	= $this->frontend_model->getSettingDataByKey('gr_secretkey');
				$secretKey			= !empty($secretKeydata)?$secretKeydata->key_value:'';
				$captcha_response 	= $this->input->post('g-recaptcha-response');
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
				$userType 		= '2';
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
				$gender 		= $this->input->post('gender');
				$age 			= $this->input->post('customer_age');
				if(!empty($this->input->post('c_dob'))){
					$dob 		= date('Y-m-d', strtotime($this->input->post('c_dob')));
				}else{
					$dob 		= '';
				}
				$country 		= $this->input->post('c_country');
				$state 			= $this->input->post('c_state');
				$city 			= $this->input->post('c_city');
				$pin 			= $this->input->post('c_pin');
				$address 		= trim($this->input->post('c_address'));
				$userpassword 	= md5($pass);
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
					if(!empty($dob)){
						$age = (date('Y') - date('Y',strtotime($dob)));
					}else{
						$age = '';
					}
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
								'address'   => $address,
								'country_id'=> $country,
								'state_id'	=> $state,
								'city_id'	=> $city,
								'zip'		=> $pin,
								'mobile'    => $phone,
								'created'   => date('Y-m-d H:i:s'),
							]
						);
						if(!empty($customerid)){
							$class_name = SUCCESS_ALERT;
							$short_msg 	= 'Success';
							$full_msg 	= 'Customer created successfully.';
							$redirect 	= base_url().'customlogin';
							$registerdata = array(
								'email' 	=> $email,
								'password' 	=> $pass
							);
							$this->session->set_userdata('customregistration',$registerdata);
							$customloginsession = $this->session->userdata('customlogin');
							if(!empty($customloginsession)){
								$this->session->unset_userdata('customlogin');
							}
							$userresponce = $this->user_model->_getUserByKeyValue('email', $email, array('2', '3', '4'));
							$sesionresponce = $this->setDataIntoSession($userresponce);
							if(!empty($sesionresponce)){
								$this->updateLogin($userresponce->id, array('login_status' => 1, 'current_login' => date('Y-m-d H:i:s')));
								$returnTicketId = $this->createticketonpaynow();
								$this->session->set_userdata('ticketresponsedata',$returnTicketId);								
								$ticketurl = base_url().'payment';
								redirect($ticketurl);
							}
						}
					}
				}else{
					$class_name = DANGER_ALERT;
					$full_msg = 'Something went wrong!';
					$redirect = $pageUrl;
				}
				$to		 	= $email;
				$subject 	= "File Notice- User Registration";
				$message 	= $this->getMailData($userType);
				$from 		= "Filenotice <coffee@filenotice.com>";
				$header 	= "From: $from\r\n";
				$header 	.= "Content-type: text/html; charset=utf-8";
				//mail($to,$subject,$message,$header);
				
				$this->session->set_flashdata('responce_msg', array('class' => $class_name, 'short_msg' => $short_msg, 'message' => $full_msg));
				redirect($redirect);
			}
		}
		
        _manage_template('templates/header', 'templates/footer', 'templates/customlogin', $data);
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
															  /* if($usertype == 3){
																$html .= '<span style="font-family:helvetica, sans-serif;color:#000000;">Click here to verify email : <a href="'.$verifylink.'" target="_blank">'.$verifylink.'</a></span><br />';
															  } */
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
	public function payment(){
		$data['section_name']	= "Payment Form";
        $data['page_title']  	= $data['site_title'] = "Payment Form";
        $data['pageUrl']     	= $pageUrl = base_url('create_ticket');
		$usersession 			= $this->session->userdata('users');
		$adminsession 			= $this->session->userdata('admins');
		$agentsession			= $this->session->userdata('agents');
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
		$user_id 				= $usersession['user_id'];
		$ticketformdata 		= $this->session->userdata('ticketformdata');		
		$data['countryList']	= $this->user_model->getCountryList();
		$data['stateList']		= $this->user_model->getStateList('','88');
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
		$defaultState 			= '38'; //default Uttar Pradesh State  
		$data['defaultcitylist'] = $this->user_model->getCityList('',$defaultState); 
		$data['category'] 		 = $this->user_model->getParentCategory();
		/* $data['catids']			= $catids = $this->input->get('catid');
		$catidarray 			= base64_decode($catids);
		$catidstr				= explode('/',$catidarray); */
		$data['catid'] 			= $catid = $ticketformdata['catid'];
		$data['subcategorylist']= $this->frontend_model->getsubcategory($catid);
		$data['catdata']		= $this->frontend_model->get_category_data($catid);
		$data['userdata']		= $this->user_model->getUserDetailsById($user_id,'2');
		_manage_template('templates/header', 'templates/footer', 'payment/paymentform', $data);
	}
	public function payment_response(){
	    $usersession 			= $this->session->userdata('users');
		$adminsession 			= $this->session->userdata('admins');
		$agentsession			= $this->session->userdata('agents');
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
		$data['section_name']	= "Payment Response";
        $data['page_title']  	= $data['site_title'] = "Payment Response";
        $data['pageUrl']     	= $pageUrl = base_url('create_ticket');
		$data['allcity']		= $citydata = $this->frontend_model->getCityList('','');
		if ($this->input->server('REQUEST_METHOD') === "POST") {		
			$postdatas 	= $this->input->post();
			$msg 		= '';
			if (isset($postdatas['key'])) {
				$data['key'] 		= $key				=   $postdatas['key'];
				//$data['salt'] 		= $salt				=   $postdatas['salt'];
				$data['salt'] 		= $salt				=  'WrnjOdf2wu';
				$data['txnid']		= $txnid 			= 	$postdatas['txnid'];
				$data['amount'] 	= $amount      		= 	$postdatas['amount'];
				$data['productInfo']= $productInfo 		= 	$postdatas['productinfo'];
				$data['firstname'] 	= $firstname    	= 	$postdatas['firstname'];
				$data['email'] 		= $email        	=	$postdatas['email'];
				$data['udf5'] 		= $udf5				=   $postdatas['udf5'];
				$data['mihpayid'] 	= $mihpayid			=	$postdatas['mihpayid'];
				$data['status'] 	= $status			= 	$postdatas['status'];
				$data['resphash'] 	= $resphash			= 	$postdatas['hash'];
				//Calculate response hash to verify	
				$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productInfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
				$keyArray 	  		= 	explode("|",$keyString);
				$reverseKeyArray 	= 	array_reverse($keyArray);
				$reverseKeyString	=	implode("|",$reverseKeyArray);
				$data['CalcHashString'] = $CalcHashString = strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));
				//if ($status == 'success'  && $resphash == $CalcHashString) {
				 if ($status == 'success' ) {
					$data['msg'] = $msg = "Transaction Successful...";
					$payresponse = [];
					$payresponse['transaction_id'] 	= $postdatas['txnid'];
					$payresponse['discount'] 		= $postdatas['discount'];
					$payresponse['mode'] 			= $postdatas['mode'];
					$payresponse['bankcode'] 		= $postdatas['bankcode'];
					$payresponse['net_amount_debit']= $postdatas['net_amount_debit'];
					$payresponse['phone']			= $postdatas['phone'];
					$payresponse['productinfo']		= $postdatas['productinfo'];
					$payresponse['status']			= $postdatas['status'];
					$payresponse['name']			= $postdatas['firstname'];
					$payresponse['bank_ref_num']	= $postdatas['bank_ref_num'];
					$payresponse['email']			= $postdatas['email'];
					$payresponse['amount']			= $postdatas['amount'];
					$payresponse['payuMoneyId']		= $postdatas['payuMoneyId'];
					$payresponse['paymentdatetime']	= $postdatas['addedon'];
					session_start();
					$this->session->set_userdata('payment_responce',$payresponse);
					$_SESSION['payment_responce'] = $payresponse;
				}
				else {
					$data['msg'] = $msg = "Payment failed for Hash not verified...";
				} 
			}
			else exit(0);
		}
		_manage_template('templates/header', 'templates/footer', 'payment/response', $data);
	}
	public function create_hash(){
		if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
			//Request hash
			$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';	
			if(strcasecmp($contentType, 'application/json') == 0){
				$data = json_decode(file_get_contents('php://input'));
				$hash=hash('sha512', $data->key.'|'.$data->txnid.'|'.$data->amount.'|'.$data->pinfo.'|'.$data->fname.'|'.$data->email.'|||||'.$data->udf5.'||||||'.$data->salt);
				$json=array();
				$json['success'] = $hash;
				echo json_encode($json);
			}
			exit(0);
		}
	}
	public function createticketonpaynow(){
		$usersession 		= $this->session->userdata('users');
		$user_id 			= $usersession['user_id'];
		$ticketformdata 	= $this->session->userdata('ticketformdata');
		$jsonForm			= $ticketformdata['subcatdata'];
		/* $customer_mobile	= $jsonForm['Mobile'];
		$str 				= preg_replace("/[^A-Za-z0-9 ]/", '', $customer_mobile);
		$mobile				= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str); */
		$jsonFormData		= json_encode($jsonForm);
		$ticketid 			= $this->frontend_model->createTicket('',[
			'ticket_id'     	=> $ticketformdata['ticketname'],
			'customer_id'   	=> $user_id,
			'description'   	=> $ticketformdata['description'],
			'file'          	=> $ticketformdata['imagename'],
			'start_date'    	=> date('Y-m-d'),
			'category_id'   	=> $ticketformdata['catid'],
			'subcategory_id'   	=> $ticketformdata['subcatid'],
			'ticket_status' 	=> '5',
			'status'        	=> '0',
			'customer_mobile'  	=> $ticketformdata['customer_mobile'],
			'customer_country'  => $ticketformdata['customer_country'],
			'customer_state'    => $ticketformdata['customer_state'],
			'customer_city'     => $ticketformdata['customer_city'],
			'customer_pincode'  => $ticketformdata['customer_pincode'],
			'customer_address'  => $ticketformdata['customer_address'],
			'json_form_data'  	=> $jsonFormData,
			'created'       	=> date('Y-m-d H:i:s'),
		]);
		return $ticketid;
	}
	public function createnewticket(){
		session_start();
		$usersession 		= $this->session->userdata('users');
		$user_id 			= $usersession['user_id'];
		$ticketformdata 	= $this->session->userdata('ticketformdata');
		//$payment_responce 	= $this->session->userdata('payment_responce');
		$payment_responce 	= $_SESSION['payment_responce'];
		if(!empty($ticketformdata)){
			$ticketid = $this->session->userdata('ticketresponsedata');
			if(!empty($ticketid)){
				$paymentid = $this->frontend_model->insertdata('nw_payment_tbl',[
					'ticket_id'     	=> $ticketid,
					'payment_source'   	=> $payment_responce['bankcode'],
					'payer_email'   	=> $payment_responce['email'],
					'tarnsaction_id'    => $payment_responce['transaction_id'],
					'payment_date'    	=> $payment_responce['paymentdatetime'],
					'user_id'   		=> $user_id,
					'payment_amount'   	=> $payment_responce['net_amount_debit'],
					'payment_data' 		=> $payment_responce['amount'],
					'status'        	=> '1',
					'created'       	=> date('Y-m-d H:i:s'),
				]);
				if($paymentid){
					$year 				= ( date('m') > 6) ? date('Y') + 1 : date('Y');
					$month 				= date('m');
					$lastinvoicedata 	= $this->frontend_model->getlastrowoftable('nw_invoice_tbl');
					$invoiceid 			= '';
					if(!empty($lastinvoicedata)){
						$invoicearray 	= str_split($lastinvoicedata->invoice_id, 6);
						$increasingnum	= $invoicearray[1];
						$addedinvoiceid = $increasingnum +1;
						$newinvoiceid 	= sprintf('%04d',$addedinvoiceid);
						$invoiceid 		= $year.$month.$newinvoiceid;
					}else{
						$invoiceid 		= $year.$month.'0001';
					}
					$invoiceinsertedid = $this->frontend_model->insertdata('nw_invoice_tbl',[
						'invoice_id'     	=> $invoiceid,
						'payumoney_id'     	=> $payment_responce['payuMoneyId'],
						'user_id'   		=> $user_id,
						'amount'   			=> $payment_responce['amount'],
						'transaction_id'    => $payment_responce['transaction_id'],
						'ticket_id'    		=> $ticketid,
						'status'        	=> '1',
						'created'       	=> date('Y-m-d H:i:s'),
					]);
					if ($invoiceinsertedid) {
						$ticketdata = array(
							'payment_status' 	=> '1',
							'ticket_status' 	=> '10',
							'status' 			=> '1',
							'modified' 			=> date('Y-m-d H:i:s')
						);
						$this->frontend_model->updateanytable('id',$ticketid,$ticketdata,'nw_ticket_tbl');
						$this->session->unset_userdata('ticketformdata');
						unset($_SESSION['payment_responce']);
						//$this->session->unset_userdata('payment_responce');
						$this->session->unset_userdata('selectedcityid');
						$this->session->unset_userdata('ticketresponsedata');
						$this->session->set_userdata('createdticket','success');
						$this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been created successfully.'));
						$ticketlisturl = base_url('ticket/servicelist/?status=10');
						redirect($ticketlisturl);
					}else{
						$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'FAILED', 'message' => 'Something went wrong.'));
						$ticketlisturl = base_url();
						redirect($ticketlisturl);
					}
				}
			}
		}
	}
}	

?>