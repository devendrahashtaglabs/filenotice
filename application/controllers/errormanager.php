<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errormanager extends CI_Controller {
	public function __construct() {
        parent::__construct();
	}
	public function page404(){

		$data['heading'] = '404 Page';
		$data['message'] = 'This page is not available.';
		$this->load->view('error_404',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */