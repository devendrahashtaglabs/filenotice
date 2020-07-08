<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ticketController extends MX_Controller {

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
	public function choose_category() {
		$data['section_name'] = "Service Management";
        $data['page_title'] = $data['site_title'] = "Choose Category";
        $data['pageUrl'] = $pageUrl = base_url('ticket/choose_category');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/create">' . $data['page_title'] . '</a></li></ol>';
        $data['usersession'] = $usersession = $this->session->userdata('users');
		
        $data['userdata'] 	= $userdata = $this->user_model->getUserDataById($usersession['user_id'],$usersession['user_type']);
        $data['categories'] = $this->category_model->getParentCategory();
        $data['allcity'] 	= $this->user_model->getCityList('','');		
		$data['currentcityid'] 	= $currentcityid = $userdata->city_id;
		if($this->input->post('user_city')){
			$data['currentcityid'] = $currentcityid = $this->input->post('user_city');
			$this->session->set_userdata('selectedcitydata',$currentcityid);
			$allsubcat 		= $this->ticket_model->getcategorybycity($currentcityid);
			$parentcatdata	= [];
			$counter		= 0;
			foreach($allsubcat as $subcat){
				$parentcatdata[$counter] = $subcat->parent_id;
				$counter++;
			}
			$data['showparentcategory'] = $parentcatdata;
		}else{
			$this->session->set_userdata('selectedcitydata',$currentcityid);
			$allsubcat 		= $this->ticket_model->getcategorybycity($currentcityid);
			$parentcatdata	= [];
			$counter		= 0;
			foreach($allsubcat as $subcat){
				$parentcatdata[$counter] = $subcat->parent_id;
				$counter++;
			}
			$data['showparentcategory'] = $parentcatdata;
		}
		$data['selectedcitydata'] = $this->user_model->getCityList($currentcityid,'');
		_manage_template('templates/header', 'templates/footer', 'ticket/choose_category', $data, 'templates/left_adminMenu');
	}
    public function create_ticket() {
        // $this->load->helper(array('form', 'url'));
        $data['section_name'] 	= "Service Management";
        $data['page_title'] 	= $data['site_title'] = "Create Ticket";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/create">' . $data['page_title'] . '</a></li></ol>';
        $data['categories'] 	= $this->category_model->getParentCategory();
		$data['countryList']	= $this->user_model->getCountryList();
        $data['stateList']		= $this->user_model->getStateList('','88');
		$data['catids']			= $catids = $this->input->get('catid');
		$catidarray 			= base64_decode($catids);
		$catidstr				= explode('/',$catidarray);
		$data['catid'] 			= $catid = $catidstr[1];
		$data['subcategorylist']= $this->category_model->getsubcategory($catid);
		$data['catdata']		= $this->category_model->get_category_data($catid);
		$user_id 				= $this->session->userdata('users')['user_id'];
		$data['customerData']	= $customerData = $this->user_model->getDataBykey('nw_customer_tbl','user_id',$user_id);
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $postdata 		= $this->input->post();
			$postsubcatid 	= $postdata['subcatid'];
			$postsubcatdata = $this->category_model->get_category_data($postsubcatid);
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
				$str 					= $this->input->post('categorytext');
				$len					= 3;
				$rndnumber 				= randomstring('2');
				$ticketname 			= substr(str_replace(" ", "", $str), 0, $len).'-'.date('mdh24is') . $rndnumber;
				$newticketname 			= strtoupper($ticketname);
				$postdata['ticketname'] = $newticketname;
				$imagename 				= $_FILES['image']['name'][0];
				$allfile				= [];
				$ticketformdata 		= $this->session->userdata('ticketformdata');
				
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
				}  */
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
					$filename 	= json_encode($newfilearray);
				}else{
					$filename 	= $ticketformdata['imagename'];
				}
				$postdata['imagename']		= $filename;
				$customer_mobile			= $postdata['customer_mobile'];
				$str 						= preg_replace("/[^A-Za-z0-9 ]/", '', $customer_mobile);
				$postdata['customer_mobile']= preg_replace('/(?<=\d)\s+(?=\d)/', '', $str);
				
				$this->session->set_userdata('ticketformdata',$postdata);
				$ticketformdata = $this->session->userdata('ticketformdata');
				if(!empty($ticketformdata)){
					$ticketlisturl = base_url().'ticket/getsubcatform';
					redirect($ticketlisturl);
				} 
			}
        }
        _manage_template('templates/header', 'templates/footer', 'ticket/create', $data, 'templates/left_adminMenu');
    }
	public function getsubcatform() {
		$usersession 			= $this->session->userdata('users');
		$short_msg 				= 'Failed';
        $class_name				= INFO_ALERT;
        $data['section_name']	= "Subcategory Form";
        $data['page_title']  	= $data['site_title'] = "Subcategory Form";
        $data['pageUrl']     	= $pageUrl = base_url('/getsubcatform');
        $data['breadcrumb']  	= '<ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li></ol>';
		$data['countryList']		= $this->user_model->getCountryList();
		$data['stateList']			= $this->user_model->getStateList('','88');
		$data['allcity']			= $citydata = $this->user_model->getCityList('','');
		$defaultState 				= '38'; //default Uttar Pradesh State  
		$data['defaultcitylist'] 	= $this->user_model->getCityList('',$defaultState); 
		$data['category'] 		 	= $this->category_model->getParentCategory();
		$data['catids']				= $catids = $this->input->get('catid');
		$ticketformdata 			= $this->session->userdata('ticketformdata');
		$data['catid'] 				= $catid 	= $ticketformdata['catid'];
		$data['subcatid'] 			= $subcatid = $ticketformdata['subcatid'];
		$data['subcategorylist']	= $this->category_model->getsubcategory($catid);
		$data['catdata']			= $this->category_model->get_category_data($catid);
		$data['subcatdata']			= $this->category_model->get_category_data($subcatid);
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
				$redirecturl = base_url().'ticket/payment';
				redirect($redirecturl);
			}
		}
		_manage_template('templates/header', 'templates/footer', 'ticket/subcatform', $data, 'templates/left_adminMenu');
	}
	public function payment(){
		$data['section_name']	= "Payment Form";
        $data['page_title']  	= $data['site_title'] = "Payment Form";
        $data['pageUrl']     	= $pageUrl = base_url('create_ticket');
		$data['countryList']	= $this->user_model->getCountryList();
        $data['stateList']		= $this->user_model->getStateList('','88');
		$usersession 			= $this->session->userdata('users');
		$ticketformdata 		= $this->session->userdata('ticketformdata');
		$user_id 				= $this->session->userdata('users')['user_id'];
		$data['userdata']		= $this->user_model->getUserDetailsById($user_id,'2');
		_manage_template('templates/header', 'templates/footer', 'payment/paymentform', $data, 'templates/left_adminMenu');
	}
	
	public function payment_response(){
		$data['section_name']	= "Payment Response";
        $data['page_title']  	= $data['site_title'] = "Payment Response";
        $data['pageUrl']     	= $pageUrl = base_url('ticket/create');
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
				if ($status == 'success'  && $resphash == $CalcHashString) {
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
			_manage_template('templates/header', 'templates/footer', 'payment/response', $data, 'templates/left_adminMenu');
		}		
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
				$paymentid = $this->ticket_model->insertdata('nw_payment_tbl',[
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
					$lastinvoicedata 	= $this->ticket_model->getlastrowoftable('nw_invoice_tbl');
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
					$invoiceinsertedid = $this->ticket_model->insertdata('nw_invoice_tbl',[
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
						$this->ticket_model->updateanytable('id',$ticketid,$ticketdata,'nw_ticket_tbl');
						$this->session->unset_userdata('ticketformdata');
						//$this->session->unset_userdata('payment_responce');
						unset($_SESSION['payment_responce']);
						$this->session->unset_userdata('selectedcitydata');
						$this->session->unset_userdata('ticketresponsedata');
						$this->session->set_userdata('createdticket','success');
						$this->session->set_flashdata('responce_msg', array('class' => SUCCESS_ALERT, 'short_msg' => 'SUCCESS', 'message' => 'Ticket has been created successfully.'));
						$ticketlisturl = base_url('ticket/servicelist/?status=10');
						redirect($ticketlisturl);
					}else{
						$this->session->set_flashdata('responce_msg', array('class' => DANGER_ALERT, 'short_msg' => 'FAILED', 'message' => 'Something went wrong.'));
						$ticketlisturl = base_url().'ticket/choose_category';
						redirect($ticketlisturl);
					}
				}
			}
		}
	}
	public function createticketonpaynow(){
		$usersession 		= $this->session->userdata('users');
		$user_id 			= $usersession['user_id'];
		$ticketformdata 	= $this->session->userdata('ticketformdata');
		$ticketid = $this->ticket_model->createticketonpay([
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
			'created'       	=> date('Y-m-d H:i:s'),
		]);
		return $ticketid;
	}
	public function getsubcatdetailbyid(){
		$subcatid 			= $this->input->post('subcatid');
		$subcategorydata 	= $this->category_model->get_category_data($subcatid);
		$subcatdetail 		= [];
		if(!empty($subcategorydata)){
			$subcatdetail['name'] = $subcategorydata->name;
			$subcatdetail['amount'] = $subcategorydata->amount;
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
				$faqdata = $this->user_model->getDataBykey('nw_faq_tbl','id',$faq);
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
	public function getinvoicebyticketid(){
		$ticketid 	= $this->input->post('ticketid');
		$ticketdata = $this->ticket_model->getTicketById($ticketid);
		if(!empty($ticketdata)){
			$data['ticketdata'] = $ticketdata;
			$this->load->view('ticket/show_invoice',$data);
		}else{
			$data['ticketdata'] = '';
			$this->load->view('ticket/show_invoice',$data);
		}
	}
	public function servicelist() {
        // $this->load->helper(array('form', 'url'));
        $data['section_name'] 	= "Service Management";
        $data['page_title'] 	= $data['site_title'] = "Service List";
        $data['pageUrl'] 		= $pageUrl = base_url('ticket');
        $data['breadcrumb'] 	= '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/list">Ticket</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/create">' . $data['page_title'] . '</a></li></ol>';
		$usersession 		= $this->session->userdata('users');
		$userid				= $usersession['user_id'];
		$usertype			= $usersession['user_type'];
		$data['status']		= $status = $this->input->get('status');
		if(!empty($status)){
			if($status == '10'){
				$ticket_status 		= array('10');
				$data['lastcreatedticket'] 	= $lastcreatedticket = $this->ticket_model->userticketdata($userid);
				$data['tickets'] 	= $this->ticket_model->getTickets($userid,'','id','desc',$ticket_status,'1');
			}elseif($status == '20'){
				$ticket_status 		= array('20','21','22','30','92','93');
				$data['tickets'] 	= $this->ticket_model->getTickets($userid,'','id','desc',$ticket_status,'1');
			}elseif($status == '90'){
				$ticket_status 		= array('90','91');
				$data['tickets'] 	= $this->ticket_model->getTickets($userid,'','id','desc',$ticket_status,'1');				
			}else{
				$data['tickets'] 	= $this->ticket_model->getTickets($userid,'','id','desc','','1');
			}
		}else{
			$data['tickets'] 	= $this->ticket_model->getTickets($userid,'','id','desc','','1');	
		}
        _manage_template('templates/header', 'templates/footer', 'ticket/ticket_list_page', $data, 'templates/left_adminMenu');
    }
}