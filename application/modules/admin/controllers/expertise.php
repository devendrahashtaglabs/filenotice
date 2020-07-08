<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class expertise extends CI_Controller {

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
        $this->load->model('expertise_model');
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
    
    public function uniquename($str,$paramTwo) {
        $response = $this->expertise_model->check_experties_unique($str, $paramTwo);
        if (empty($response)) {
            return TRUE;
        }else{
            $this->form_validation->set_message('uniquename', 'The Expertise Name already exists!');
            return FALSE;
        }
    }

    public function expertise_list() {
        $data['section_name'] = "Expertise Management";
        $data['page_title'] = $data['site_title'] = "All Expertise";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type').'/admin/expertise');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="'.$pageUrl.'/expertise_list">'.$data['page_title'].'</a></li></ol>';
        $data['responce'] = $this->expertise_model->listExpertise();
        _manage_template('templates/header', 'templates/footer', 'expertise/list', $data, 'templates/left_adminMenu');
    }

    public function expertise_del() {
        $id = $this->uri->segment(4);
        $this->expertise_model->deleteExpertise($id);
        redirect(base_url('/admin/expertise/expertise_list'));
    }

    public function create() {
        $data['section_name'] = "Expertise Management";
        $data['page_title'] = $data['site_title'] = "Create Expertise";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/expertise/create');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type').'/admin/expertise/expertise_list') . '">Expertise List</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        if($this->input->server('REQUEST_METHOD')==="POST"){
            $this->form_validation->set_rules('exp_name', 'Expertise Name', 'trim|required|alpha_space|max_length[15]|is_unique[nw_experties_tbl.name]');
            $this->form_validation->set_rules('exp_status', 'Status', 'required');
            if ($this->form_validation->run()) {
                $responce = $this->expertise_model->createExpertise(
                    [
                        'name' => $this->input->post('exp_name'),
                        'status' => $this->input->post('exp_status'),
                        'created' => date('Y-m-d H:i:s')
                    ]
                );
                if ($responce) {
                    $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Expertise created successfully.'));
                    redirect(base_url($this->session->userdata('user_type') . '/admin/expertise/expertise_list'));
                }else{
                    $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'Worning','message'=>'Something Went Wrong!.'));
                }
            }
        }
        _manage_template('templates/header', 'templates/footer', 'expertise/create', $data, 'templates/left_adminMenu');
    }

    public function edit() {
        $id = $this->uri->segment(4);
        if(empty($id)){
            redirect(base_url($this->session->userdata('user_type').'/expertise/expertise_list'));
        }
        $data['section_name']= "Expertise Management";
        $data['page_title']  = $data['site_title'] = "Edit Expertise";
        $data['pageUrl']     = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/expertise/edit/'.$id);
        $data['breadcrumb']  = '<ol class="breadcrumb float-sm-right">'
            . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type').'/admin/expertise/expertise_list') . '">Expertise</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
            . '</ol>';
        $data['row'] = $this->expertise_model->getExpertiseById($id);
		if(!empty($data['row'])){
			if($this->input->server('REQUEST_METHOD')==="POST"){
				// $this->form_validation->set_rules('exp_name', 'Expertise Name', 'trim|required|max_length[15]');
				$this->form_validation->set_rules('exp_name', 'Expertise Name', 'trim|required|callback__alpha_dash_space|max_length[30]|callback_uniquename['.$id.']');
				$this->form_validation->set_rules('exp_status', 'Status', 'required');
				if ($this->form_validation->run()) {
					$data = array(
						'id' => $id,
						'name' => $this->input->post('exp_name'),
						'status' => $this->input->post('exp_status'),
						'modified' => date('Y-m-d H:i:s')
					);
					$responce = $this->expertise_model->updateExpertise($data);
					if ($responce) {
						$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Expertise updated successfully.'));
						redirect(base_url('/admin/expertise/expertise_list'));
					} else {
						_manage_template('templates/header', 'templates/footer', 'expertise/edit', $data, 'templates/left_adminMenu');
					}
				}
			}
			_manage_template('templates/header', 'templates/footer', 'expertise/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'ERROR','message'=>'No data found.'));
			redirect(base_url('/admin/expertise/expertise_list'));
		}
    }

    public function expertise_changeStatus() {
        $status = false;
        $style_color = 'red';
        $redirectURL = "";
        $id = $this->input->post('uid');
        $data = $this->expertise_model->getExpertiseStatus($id);
        if ($data->status == 0) {
            $data = array('status' => 1);
        } else {
            $data = array('status' => 0);
        }

        $responce = $this->expertise_model->changeExpertiseStatus($id, $data);
        if (!empty($responce)) {
            $redirectURL = base_url() . '/expertise/expertise_list';
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
        }
        echo $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
    }

   
    
}