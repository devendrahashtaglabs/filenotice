<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rating extends MX_Controller {

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
        $this->load->model('customer_model');
        // $this->load->library(array('my_form_validation'));
	    // $this->form_validation->run($this);
    }
    
	public function consultant_rating() {
        $data['section_name'] = "Consultant Rating";
        $data['page_title'] = $data['site_title'] = "All Consultant";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/rating');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '/consultant_rating">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['response'] = $this->user_model->getUserList('3', '', '', '', 'users.id', 'desc');
        _manage_template('templates/header', 'templates/footer', 'rating/list', $data, 'templates/left_adminMenu');
    }
	public function consultantremarkbyuserid() {
		$data['title'] = 'Consultant Remark';
		$userid  = $this->input->post('userid');
		$remarks = $this->user_model->getremarkbyconsultantid($userid);
		if(!empty($remarks)){
			$data['remarks'] = $remarks;
			$this->load->view('rating/remark_list',$data);
		}else{
			$data['remarks'] = '';
			$this->load->view('rating/remark_list',$data);
		}
    }
}