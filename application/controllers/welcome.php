<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        $this->load->model('welcome_model');
		$this->load->database();
    }
	public function index(){
		//$this->load->view('welcome_message');
		$data['section_name']= "Filenotice";
        $data['page_title']  = $data['site_title'] = "Filenotice";
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
		$data['allcity']		= $citydata 		= $this->welcome_model->getCityList('','');
		$data['allcategory']	= $citydata 		= $this->welcome_model->getParentCategory();
		$completed_status 		= array(90,91);
		$data['completedticket']= $completedticket 	= $this->welcome_model->getCompletedTicket($completed_status);
		$data['customersList']  = $this->welcome_model->getCountOfUser('2','1');
        $data['consultList']    = $this->welcome_model->getCountOfUser('3','1');
		$PublicIP 			= $this->get_client_ip();
		$geourl 			= "http://ipinfo.io/$PublicIP/geo";
		$json     			= file_get_contents($geourl);
		$json     			= json_decode($json, true);
		$data['country'] 	= $country  = !empty($json['country'])?$json['country']:'';
		$data['region'] 	= $region   = !empty($json['region'])?$json['region']:'';
		$sessioncity 		= $this->session->userdata('currentcitydata');
		$data['faq'] 		= $this->welcome_model->getDataByKey('nw_faq_tbl','show_homepage','1');
		$data['partner'] 	= $this->welcome_model->getDataByKey('nw_partner_tbl','','');
		if(!empty($sessioncity)){
			$data['city'] = $city  = $sessioncity->city_name;
		}else{
			$data['city'] = $city  = !empty($json['city'])?$json['city']:'';
		}
		$currentcitydata 		= $this->welcome_model->getcurrentcity($city);
		$currentcityid			= '';
		$data['currentcityid']	= '';
		if(!empty($currentcitydata)){
			$data['currentcityid'] 	= $currentcityid = $currentcitydata->city_id;
		}else{
			$data['currentcityid'] 	= $currentcityid = DEFAULT_CITY;
		}
		if($this->input->post('user_city')){
			$data['currentcityid'] = $currentcityid = $this->input->post('user_city');
			$this->session->set_userdata('selectedcityid',$currentcityid);
			$allsubcat 		= $this->welcome_model->getcategorybycity($currentcityid);
			$parentcatdata	= [];
			$counter		= 0;
			foreach($allsubcat as $subcat){
				$parentcatdata[$counter] = $subcat->parent_id;
				$counter++;
			}
			$data['showparentcategory'] = $parentcatdata;
		}else{
			$this->session->set_userdata('selectedcityid',$currentcityid);
			$allsubcat 		= $this->welcome_model->getcategorybycity($currentcityid);
			$parentcatdata	= [];
			$counter		= 0;
			foreach($allsubcat as $subcat){
				$parentcatdata[$counter] = $subcat->parent_id;
				$counter++;
			}
			$data['showparentcategory'] = $parentcatdata;
		}
		$data['selectedcitydata'] = $currentcitydata = $this->welcome_model->getcurrentcitybyid($data['currentcityid']);
		if(!empty($currentcitydata)){
			$this->session->set_userdata('currentcitydata', $currentcitydata);
		}
		_manage_template('frontend/header', 'frontend/footer', 'frontend/index', $data);
	}
	public function get_client_ip(){
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if (isset($_SERVER['HTTP_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if (isset($_SERVER['REMOTE_ADDR'])) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */