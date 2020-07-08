<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class State extends CI_Controller {

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
        $this->load->model('user_model');
        $this->load->model('category_model');
        $last = end($this->uri->segments);
        // $this->load->library(array('my_form_validation'));
        // $this->form_validation->run($this);
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

    public function state_list() {
        $data['section_name'] = "State Management";
        $data['page_title'] = $data['site_title'] = "All State";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/state/state_list');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['responce'] = $this->user_model->getfullStateList();
        _manage_template('templates/header', 'templates/footer', 'state/list', $data, 'templates/left_adminMenu');
    }

    public function state_del() {
        $id = $this->uri->segment(4);

        $this->user_model->deleteState($id);
        redirect(base_url('admin/state/state_list'));
    }

    public function create() {
        $data['section_name'] = "State Management";
        $data['page_title'] = $data['site_title'] = "Create state";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/state/create');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/state/state_list') . '">State List</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['countrys'] = $this->user_model->getCountryList();
        if ($this->input->server('REQUEST_METHOD') === "POST") {
        $this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');
        $this->form_validation->set_rules('state_name', 'State Name', 'trim|required|callback__alpha_dash_space|max_length[30]|is_unique[nw_states_tbl.name]');
        $this->form_validation->set_rules('state_status', 'Status', 'required');
        if ($this->form_validation->run()) {
            $responce = $this->user_model->createState(
                    [
                        'name' => ucfirst($this->input->post('state_name')),
                        'country_id' => $this->input->post('country_name'),
                        'status' => $this->input->post('state_status'),
                        'latitude' => '0.00',
                        'longitude' => '0.00',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
            );
                if ($responce) {
                    $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'State has been created successfully.'));
                    redirect(base_url('admin/state/state_list'));
                } 
             } 
        }
          _manage_template('templates/header', 'templates/footer', 'state/create', $data, 'templates/left_adminMenu');
    }

    public function edit() {
        $id = $this->uri->segment(4);
        
        $data['section_name'] = "State Management";
        $data['page_title'] = $data['site_title'] = "Edit State";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/state/edit');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/state/state_list') . '">State</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/'.$id.'">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['row'] = $this->user_model->getStateList($id, $country_id='');
        if(!empty($data['row'])){
			if ($this->input->server('REQUEST_METHOD') === "POST") {
			$this->form_validation->set_rules('country_name', 'Country Name', 'trim|required');
			$this->form_validation->set_rules('state_name', 'State Name', 'trim|required|callback__alpha_dash_space|max_length[30]');
			$this->form_validation->set_rules('state_status', 'Status', 'required');
			if ($this->form_validation->run()) {
				$data = array(
							'id' => $this->input->post('id'),
							'name' => ucfirst($this->input->post('state_name')),
							'country_id' => $this->input->post('country_name'),
							'status' => $this->input->post('state_status'),
							'latitude' => '0.00',
							'longitude' => '0.00',
							'updated_at' => date('Y-m-d H:i:s')
				);
				
				$responce = $this->user_model->updateState($data);
				if ($responce) {
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'State has been updated successfully.'));
					redirect(base_url('admin/state/state_list'));
				} 
			  }  
			}
				 _manage_template('templates/header', 'templates/footer', 'state/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'ERROR','message'=>'No data found.'));
			redirect(base_url('admin/state/state_list'));
		}
    }

    public function state_changeStatus() {
        $status = false;
        $style_color = 'red';
        $redirectURL = "";
        $id = $this->input->post('uid');
        $data = $this->user_model->getStateStatus($id);
        if ($data->status == 0) {
            $data = array('status' => 1);
        } else {
            $data = array('status' => 0);
        }
        $responce = $this->user_model->changeStateStatus($id, $data);
        if (!empty($responce)) {
            $redirectURL = base_url() . 'state/state_list';
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
        }
        echo $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
    }

}
