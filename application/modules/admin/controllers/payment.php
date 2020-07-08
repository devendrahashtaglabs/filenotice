<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
	class Payment extends MX_Controller {
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
	}
    
    public function paymentinfo_list() {
        $data['section_name'] = "Payment Information";
        $data['page_title'] = $data['site_title'] = "Payment Information";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('admins')['user_type'] . '/payment');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/paymentinfo_list">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['response'] = $this->ticket_model->getPaymentList('2','','','','users.id','desc');
        _manage_template('templates/header', 'templates/footer', 'payment/list', $data, 'templates/left_adminMenu');
    }
}