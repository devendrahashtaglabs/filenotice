<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $last = end($this->uri->segments);
        if ($last != 'login') {
            $loggedin = $this->session->userdata('admins');
			if(empty($loggedin)){
				$redirect_url = FRONTEND_URL . 'admin/login';
				redirect($redirect_url);
			}
        }
		$this->load->model('setting_model');
        // $this->load->library(array('my_form_validation'));
        // $this->form_validation->run($this);
    }

    public function general_setting() {
        $data['section_name']= "System Configuration";
        $data['page_title']  = $data['site_title'] = "System Configuration";
        $data['pageUrl']= $pageUrl = base_url($this->session->userdata('user_type') . '/admin/setting/general_setting');
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            .'<li class="breadcrumb-item"><a href="'.$pageUrl.'">'.$data['page_title'].'</a></li></ol>';
        if ($this->input->server('REQUEST_METHOD') === "POST") {
            $this->form_validation->set_rules('site_title', 'Site Title', 'trim|required');
            $this->form_validation->set_rules('site_email', 'Site Email', 'trim|required');
            $this->form_validation->set_rules('site_phone', 'Site Contact Number', 'trim|required');
            $this->form_validation->set_rules('site_copyright', 'Copyright', 'trim|required');
            $this->form_validation->set_rules('site_address', 'Address', 'trim|required');
            $this->form_validation->set_rules('site_mode', 'SMTP Mode', 'trim|required');
            $this->form_validation->set_rules('paypal_mode', 'PayPal Name', 'trim|required');
            $this->form_validation->set_rules('paypal_user', 'PayPal User', 'trim|required');
            $this->form_validation->set_rules('paypal_password', 'PayPal Password', 'trim|required');
            $this->form_validation->set_rules('paypal_secretkey', 'PayPal Secret', 'trim|required');
            
            $this->form_validation->set_rules('paytm_id', 'Paytm Id', 'trim|required');
            $this->form_validation->set_rules('paytm_secret', 'Paytm Secret', 'trim|required');
            
            $this->form_validation->set_rules('payumoney_key', 'Payumoney Key', 'trim|required');
            $this->form_validation->set_rules('payumoney_salt', 'Payumoney Salt', 'trim|required');
            
            $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'trim|required');
            $this->form_validation->set_rules('min_ticket_amt', 'Minimum Ticket Amount', 'trim|required');
            
            $this->form_validation->set_rules('sms_gateway_user', 'SMS Gateway User', 'trim|required');
            $this->form_validation->set_rules('sms_gateway_password', 'SMS Gateway Password', 'trim|required');
            
            $this->form_validation->set_rules('gst_rate', 'GST Rate', 'trim|required');
            $this->form_validation->set_rules('tds', 'TDS', 'trim|required');
            
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required');
            $this->form_validation->set_rules('time_zone', 'Time-Zone', 'trim|required');
            
            $this->form_validation->set_rules('gstn', 'GSTN', 'trim|required');
            $this->form_validation->set_rules('google_map_api_key', 'Google Map Api Key', 'trim|required');
            
            $this->form_validation->set_rules('smtp_mode', 'SMTP Mode', 'trim|required');
            $this->form_validation->set_rules('smtp_title', 'SMTP Title', 'trim|required');
            $this->form_validation->set_rules('smtp_user', 'SMTP Email', 'trim|required|strip_tags|valid_email');
            $this->form_validation->set_rules('smtp_password', 'SMTP Password', 'trim|required|strip_tags');
            $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim|required|strip_tags');
            $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim|required|strip_tags|numeric|is_natural|greater_than[0]');
			$this->form_validation->set_rules('gr_sitekey', 'Site Key', 'trim|required');
			$this->form_validation->set_rules('gr_secretkey', 'Secret Key', 'trim|required');
            if ($this->form_validation->run()) {
                
                $this->form_validation->set_rules('logo', 'Logo', 'callback_image_upload');
                if ($this->form_validation->run()) {
                    if(!empty($this->upload_data['file']['file_name'])) {
                       $filename = $this->upload_data['file']['file_name'];
                    } else { 
						$filename = '';
					}
				$imagename 	= $_FILES['image']['name'];
				$allfile	= [];
				$oldfilejson = _settingBykey('bannerfilename');
				if(!empty($imagename)){
					$userdocuments = $this->image_uploads();
					if(!empty($userdocuments)){
						foreach($userdocuments as $userdocument){
							$allfile[] = $userdocument;
						}
					}
					$bannername 	= $this->input->post('bannername');
					$bannerlink 	= $this->input->post('bannerlink');
					$oldjsonarray 	= json_decode($oldfilejson);
					$oldbannernamelist =[];
					$oldbannerlinklist =[];
					if(!empty($oldjsonarray)){
						foreach($oldjsonarray as $oldjson){
							$oldbannernamelist[] = $oldjson->bannername;
							$oldbannerlinklist[] = $oldjson->bannerlink;
						}
					}
					$casefiledata =  [];
					$filearray 	  =  [];
					$filecounts	  = count($allfile);					
					for($i=0;$i<$filecounts;$i++){
						$filearray[$i]['banner'] 		= $allfile[$i];
						$bannernewname 					= ltrim($bannername[$i]);
						$bannernewlink 					= ltrim($bannerlink[$i]);
						$count 							= $i+1;
						if(!empty($oldbannernamelist)){
							if(!in_array($bannernewname,$oldbannernamelist)){
								$filearray[$i]['bannername'] 	= !empty($bannernewname)?$bannernewname:'banner '.$count;
							}else{
								$filearray[$i]['bannername'] 	= !empty($bannernewname)?$bannernewname:'banner '.$count;
							}
						}else{
							$filearray[$i]['bannername'] 	= !empty($bannernewname)?$bannernewname:'banner '.$count;
						}
						if(!empty($oldbannerlinklist)){
							if(!in_array($bannernewlink,$oldbannerlinklist)){
								$filearray[$i]['bannerlink'] 	= !empty($bannernewlink)?$bannernewlink:'banner '.$count;
							}else{
								$filearray[$i]['bannerlink'] 	= !empty($bannernewlink)?$bannernewlink:'banner '.$count;
							}
						}else{
							$filearray[$i]['bannerlink'] 	= !empty($bannernewlink)?$bannernewlink:'banner '.$count;
						}
					}
					
					if(!empty($oldfilejson) && $oldfilejson != 'N_A' && $oldfilejson != 'null'){
						$oldfilearray = json_decode($oldfilejson);
						$newfilearray = array_merge($oldfilearray,$filearray);
					}else{
						$newfilearray = $filearray;
					}
					$bannerfilename 	= json_encode($newfilearray);
				}else{
					$bannerfilename 	= $oldfilejson;
				}
                $data['config_details'] = array(
                    'site_title'      		=> $this->input->post('site_title'),
                    'site_logo'       		=> $filename,
                    'site_email'      		=> $this->input->post('site_email'),
                    'site_phone'      		=> $this->input->post('site_phone'),
                    'site_copyright'  		=> $this->input->post('site_copyright'),
                    'site_address'    		=> $this->input->post('site_address'),
                    'site_mode'       		=> $this->input->post('site_mode'),
                    'paypal_mode'     		=> $this->input->post('paypal_mode'),
                    'paypal_user'     		=> $this->input->post('paypal_user'),
                    'paypal_password' 		=> $this->input->post('paypal_password'),
                    'paypal_secretkey'		=> $this->input->post('paypal_secretkey'),
                    'smtp_mode'       		=> $this->input->post('smtp_mode'),
                    'smtp_title'      		=> $this->input->post('smtp_title'),
                    'smtp_user'       		=> $this->input->post('smtp_user'),
                    'smtp_password'   		=> $this->input->post('smtp_password'),
                    'smtp_host'       		=> $this->input->post('smtp_host'),
                    'smtp_port'       		=> $this->input->post('smtp_port'),
                    'date_format'     		=> $this->input->post('date_format'),
                    'time_format'     		=> $this->input->post('time_format'),
                    'paytm_id'        		=> $this->input->post('paytm_id'),
                    'paytm_secret'        	=> $this->input->post('paytm_secret'),
                    'payumoney_key'        	=> $this->input->post('payumoney_key'),
                    'payumoney_salt'        => $this->input->post('payumoney_salt'),
                    'meta_keywords'        	=> $this->input->post('meta_keywords'),
                    'min_ticket_amt'        => $this->input->post('min_ticket_amt'),
                    'sms_gateway_user'      => $this->input->post('sms_gateway_user'),
                    'sms_gateway_password'  => $this->input->post('sms_gateway_password'),
                    'gst_rate'        		=> $this->input->post('gst_rate'),
                    'currency'        		=> $this->input->post('currency'),
                    'time_zone'        		=> $this->input->post('time_zone'),
                    'tds'        			=> $this->input->post('tds'),
                    'gstn'        			=> $this->input->post('gstn'),
                    'google_map_api_key'   	=> $this->input->post('google_map_api_key'),
                    'gr_sitekey'        	=> $this->input->post('gr_sitekey'),
                    'gr_secretkey'        	=> $this->input->post('gr_secretkey'),
                    'bannerfilename'       	=> $bannerfilename,
                );
                $responce = $this->setting_model->save_configData($data['config_details']);

            if ($responce) {
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'System configurations have been updated successfully.'));
                redirect(base_url('admin/setting/general_setting'));
            } else {
                $this->session->set_flashdata('flash_msg', '');
            }
            }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'setting/create', $data, 'templates/left_adminMenu');
    }
    
    function image_upload(){
	  if($_FILES['logo']['size'] != 0){
		$upload_dir = './cosmatics/images/';
		if (!is_dir($upload_dir)) {
		     mkdir($upload_dir);
		}	
		$config['upload_path']   = $upload_dir;
		$config['allowed_types'] = "gif|jpg|png|jpeg";
                $config['max_size']      = 2048;
		$config['encrypt_name']  = TRUE;
                $new_name = time().$_FILES["logo"]['name'];
                $config['file_name']     = $new_name;
		$config['overwrite']     = false;

		$this->load->library('upload', $config);
                $this->upload->initialize($config);
		if (!$this->upload->do_upload('logo')){

			$this->form_validation->set_message('logo', $this->upload->display_errors());
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
			$upload_dir = './uploads/frontend/banner/';
			$config = array();
			if (!is_dir($upload_dir)) {
				 mkdir($upload_dir);
			}
			$config['upload_path']   = $upload_dir;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']      = '0';
			$config['overwrite']     = FALSE;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload');

			$files 		= $_FILES;	
			$filecount  = count($_FILES['image']['name']);
			$file 		= [];
			for($i=0; $i< $filecount; $i++)
			{           
				$rndstr 		= randomstring();
				$file_extension = _getExtension($files['image']['name'][$i]);
				$_FILES['image']['name']= time().$rndstr.'.'.$file_extension;
				$_FILES['image']['type']= $files['image']['type'][$i];
				$_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
				$_FILES['image']['error']= $files['image']['error'][$i];
				$_FILES['image']['size']= $files['image']['size'][$i]; 
				$this->upload->initialize($config);
				$targetpath = $config['upload_path'].$_FILES['image']['name'];
				if(!empty($_FILES['image']['name'])){
					if(move_uploaded_file($_FILES['image']['tmp_name'], $targetpath)){			
					//if (($this->upload->do_upload())){
						$file[] 	=  $_FILES['image']['name'];		
					}else{
						$this->form_validation->set_message('image_upload',$this->upload->display_errors());
						//return false;
					}
				}
				
			}	
			return $file;			
		}else{
			return true;
		}
    }
}
