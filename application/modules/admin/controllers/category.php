<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('category_model');
        $last = end($this->uri->segments);
        if ($last != 'login') {
            $loggedin = $this->session->userdata('admins');
			if(empty($loggedin)){
				$redirect_url = FRONTEND_URL . 'admin/login';
				redirect($redirect_url);
			}
        }
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
        $response = $this->category_model->check_category_unique($str, $paramTwo);
        if (empty($response)) {
            return TRUE;
        }else{
            $this->form_validation->set_message('uniquename', 'Category already exists!');
            return FALSE;
        }
    }

    public function category_list() {
        $data['section_name'] = "Category Management";
        $data['page_title'] = $data['site_title'] = "All Category";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/category/category_list');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['responce'] = $this->category_model->getParentCategory();
        _manage_template('templates/header', 'templates/footer', 'category/list', $data, 'templates/left_adminMenu');
    }

    public function category_del() {
        $id = $this->uri->segment(4);
        $this->category_model->deleteCategory($id);
        redirect(base_url('admin/category/category_list'));
    }

    public function create() {
        $data['section_name'] = "Category Management";
        $data['page_title'] = $data['site_title'] = "Create category";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . 'admin/category/create');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/category/category_list') . '">category</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';

        $this->form_validation->set_rules('cat_name', 'Category Name', 'required|is_unique[nw_category_tbl.name]');
        $this->form_validation->set_message('is_unique', 'Category already exists!');
        //$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');
        $this->form_validation->set_rules('meta_tag', 'Meta_tag', 'trim|max_length[30]');
        $this->form_validation->set_rules('meta_keywd', 'Meta keyword', 'trim|max_length[30]');
        $this->form_validation->set_rules('meta_desc', 'Meta Description', 'trim|max_length[100]');
        $this->form_validation->set_rules('cat_status', 'Status', 'required');
        if ($this->form_validation->run()) {
            $this->input->post();
			$amount 	= $this->input->post('amount');
			$image_name ='';
			if(!empty($_FILES) && !empty($_FILES['banner']['name'])){
				$filename 	= $_FILES['banner']['name'];
				$tmp_path 	= $_FILES['banner']['tmp_name'];
				$image_name = uploadImage($filename, $tmp_path, 'category/banner', '140');
			}
			$featureimage_name ='';
			if(!empty($_FILES) && !empty($_FILES['cat_featureimage']['name'])){
				$featurefilename 	= $_FILES['cat_featureimage']['name'];
				$featuretmp_path 	= $_FILES['cat_featureimage']['tmp_name'];
				$featureimage_name 	= uploadImage($featurefilename, $featuretmp_path, 'category', '140');
			}
            $responce = $this->category_model->createCategory(
                    [
                        'parent_id' 		=> 0,
                        'name' 				=> ucfirst($this->input->post('cat_name')),
                        'amount' 			=> '',
                        'cat_description' 	=> $this->input->post('cat_desc'),
                        'cat_slogan' 		=> $this->input->post('cat_slogan'),
                        'headline' 			=> $this->input->post('headline'),
                        'cat_featureimage' 	=> $featureimage_name,
                        'cat_icon' 			=> $this->input->post('cat_icon'),
						'banner' 			=> $image_name,
                        'meta_tag' 			=> $this->input->post('meta_tag'),
                        'meta_keyword' 		=> $this->input->post('meta_keywd'),
                        'meta_description' 	=> $this->input->post('meta_desc'),
                        'status' 			=> $this->input->post('cat_status'),
                        'created' 			=> date('Y-m-d H:i:s')
                    ]
            );
            if ($responce) {
                $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Category has been created successfully.'));
                redirect(base_url('admin/category/category_list'));
            } else {
                _manage_template('templates/header', 'templates/footer', 'category/create', $data, 'templates/left_adminMenu');
            }
        } else {
            _manage_template('templates/header', 'templates/footer', 'category/create', $data, 'templates/left_adminMenu');
        }
    }

    public function edit() {
        $id = $this->uri->segment(4);
        
        $data['section_name'] = "Category Management";
        $data['page_title'] = $data['site_title'] = "Edit Category";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/category/edit/'.$id);
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/category/category_list') . '">Category</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';

        $data['row'] = $catdata = $this->category_model->getCategoryById($id);
		if(!empty($data['row'])){
			if ($this->input->post()) {
			$this->form_validation->set_rules('cat_name', 'Category Name', 'required|callback_uniquename['.$id.']');

			//$this->form_validation->set_rules('amount', 'amount', 'trim|required|numeric');
			$this->form_validation->set_rules('meta_tag', 'Meta_tag', 'trim|max_length[30]');
			$this->form_validation->set_rules('meta_keywd', 'Meta keyword', 'trim|max_length[30]');
			$this->form_validation->set_rules('meta_desc', 'Meta Description', 'trim|max_length[100]');
			$this->form_validation->set_rules('cat_status', 'Status', 'required');
			 if ($this->form_validation->run()) {
				if(!empty($_FILES) && !empty($_FILES['banner']['name'])){
					$filename = $_FILES['banner']['name'];
					$tmp_path = $_FILES['banner']['tmp_name'];
					$image_name = uploadImage($filename, $tmp_path, 'category/banner', '140');
				}else{
					$image_name = $catdata->banner;
				}
				if(!empty($_FILES) && !empty($_FILES['cat_featureimage']['name'])){
					$featurefilename 	= $_FILES['cat_featureimage']['name'];
					$featuretmp_path 	= $_FILES['cat_featureimage']['tmp_name'];
					$featureimage_name 	= uploadImage($featurefilename, $featuretmp_path, 'category', '140');
				}else{
					$featureimage_name = $catdata->cat_featureimage;
				}
				$data = array(
					'id' 				=> $this->input->post('id'),
					'name' 				=> ucfirst($this->input->post('cat_name')),
					'amount' 			=> '',
					'cat_description' 	=> $this->input->post('cat_desc'),
					'cat_slogan' 		=> $this->input->post('cat_slogan'),
					'headline' 			=> $this->input->post('headline'),
					'cat_featureimage' 	=> $featureimage_name,
					'cat_icon' 			=> $this->input->post('cat_icon'),
					'banner' 			=> $image_name,
					'meta_tag' 			=> $this->input->post('meta_tag'),
					'meta_keyword' 		=> $this->input->post('meta_keywd'),
					'meta_description' 	=> $this->input->post('meta_desc'),
					'status' 			=> $this->input->post('cat_status'),
					'modified' 			=> date('Y-m-d H:i:s')
				);

				$responce = $this->category_model->updateCategory($data);

				if ($responce) {
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Category has been updated successfully.'));
					redirect(base_url('admin/category/category_list'));
				} else {
					_manage_template('templates/header', 'templates/footer', 'category/edit', $data, 'templates/left_adminMenu');
				}
			 }
			}
			_manage_template('templates/header', 'templates/footer', 'category/edit', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'ERROR','message'=>'No data found.'));
			redirect(base_url('admin/category/category_list'));
		}
    }

    public function create_subcategory() {
        $data['section_name'] = "Subcategory Management";
        $data['page_title'] = $data['site_title'] = "Create Subcategory";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/category/create_subcategory');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/category/subcategory_list') . '">category</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['categories'] = $this->category_model->getParentCategory('1');
        $data['faq'] 		= $faq = $this->user_model->getDataByTable('nw_faq_tbl');
        if ($this->input->post()) {
            $this->form_validation->set_rules('cat_name', 'Name', 'required|max_length[100]');
            $this->form_validation->set_rules('pcat_name', 'Status', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('meta_tag', 'Meta Tag', 'trim|max_length[30]');
            $this->form_validation->set_rules('meta_keywd', 'Meta Keyword', 'trim|max_length[30]');
            $this->form_validation->set_rules('meta_desc', 'Meta Description', 'trim|max_length[100]');
            $this->form_validation->set_rules('cat_status', 'Status', 'required');
            if ($this->form_validation->run()) {
				$cat_city 	= $this->input->post('cat_city');
				$cities 	= '';
				if(!empty($cat_city)){
					$cities = implode(',',$cat_city);
				}else{
					$cityquery 		= $this->user_model->getCityList('','');
					$allcity		= [];
					$count			= 0;
					foreach($cityquery as $cityid){
						$allcity[$count] = $cityid->city_id;
						$count++;
					}
					$cities = implode(',',$allcity);
				}
				$image_name ='';
				if(!empty($_FILES) && !empty($_FILES['banner']['name'])){
					$filename = $_FILES['banner']['name'];
					$tmp_path = $_FILES['banner']['tmp_name'];
					$image_name = uploadImage($filename, $tmp_path, 'category/banner', '140');
				}
				$cat_faq 	= $this->input->post('cat_faq');
				$faqids 	= '';
				if(!empty($cat_faq)){
					$faqids = implode(',',$cat_faq);
				}
                $responce = $this->category_model->createSubCategory(
                        [
                            'name' 				=> ucfirst($this->input->post('cat_name')),
                            'parent_id' 		=> $this->input->post('pcat_name'),
                            'amount' 			=> $this->input->post('amount'),
							'cat_slogan' 		=> $this->input->post('cat_slogan'),
							'banner' 			=> $image_name,
                            'meta_tag' 			=> $this->input->post('meta_tag'),
                            'meta_keyword' 		=> $this->input->post('meta_keywd'),
                            'meta_description' 	=> $this->input->post('meta_desc'),
                            'status' 			=> $this->input->post('cat_status'),
                            'mapped_city' 		=> $cities,
                            'faq' 				=> $faqids,
                            'recurring_payment' => $this->input->post('recurring_payment'),
                            'created' 			=> date('Y-m-d H:i:s')
                        ]
                );
                if ($responce) {
                     $this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Subcategory has been created successfully.'));
                    redirect(base_url('admin/category/subcategory_list'));
                } else {
                    _manage_template('templates/header', 'templates/footer', 'category/create_subcategory', $data, 'templates/left_adminMenu');
                }
            } else {
                _manage_template('templates/header', 'templates/footer', 'category/create_subcategory', $data, 'templates/left_adminMenu');
            }
        } else {
            _manage_template('templates/header', 'templates/footer', 'category/create_subcategory', $data, 'templates/left_adminMenu');
        }
    }

    public function category_changeStatus() {
        $status = false;
        $style_color = 'red';
        $redirectURL = "";
        $id = $this->input->post('uid');
        $data = $this->category_model->getCategoryStatus($id);
        if ($data->status == 0) {
            $data = array('status' => 1);
        } else {
            $data = array('status' => 0);
        }

        $responce = $this->category_model->changeCategoryStatus($id, $data);
        if (!empty($responce)) {
            $redirectURL = base_url() . 'category/category_list';
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
        }
        echo $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
    }

    public function subcategory_list() {
        $data['section_name'] = "Subcategory Management";
        $data['page_title'] = $data['site_title'] = "All Subcategory";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/category/subcategory_list');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['responce'] = $this->category_model->listSubCategory();
        _manage_template('templates/header', 'templates/footer', 'category/subcategory_list', $data, 'templates/left_adminMenu');
    }

    public function subcategory_del() {
        $id = $this->uri->segment(4);

        $this->category_model->deleteCategory($id);
        redirect(base_url('admin/category/subcategory_list'));
    }

    public function subcategory_changeStatus() {
        $status = false;
        $style_color = 'red';
        $redirectURL = "";
        $id = $this->input->post('uid');
        $data = $this->category_model->getCategoryStatus($id);
        if ($data->status == 0) {
            $data = array('status' => 1);
        } else {
            $data = array('status' => 0);
        }

        $responce = $this->category_model->changeCategoryStatus($id, $data);
        if (!empty($responce)) {
            $redirectURL = base_url() . 'category/subcategory_list';
            $status = true;
            $message = 'Status has been updated successfully.';
            $style_color = 'green';
        }
        echo $ajaxResponse = json_encode(array('status' => $status, "message" => $message, 'style_color' => $style_color, 'redirectURL' => $redirectURL));
    }

    public function edit_subcategory() {
        $id = $this->uri->segment(4);

        $data['section_name'] = "Subcategory Management";
        $data['page_title'] = $data['site_title'] = "Edit Subcategory";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . '/admin/category/edit_subcategory/'.$id);
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/category/subcategory_list') . '">Category</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '/'.$id.'">' . $data['page_title'] . '</a></li>'
                . '</ol>';
        $data['categories'] = $this->category_model->getParentCategory();
        $data['row'] 		= $subcatdata = $this->category_model->getCategoryById($id);
		$data['faq'] 		= $faq = $this->user_model->getDataByTable('nw_faq_tbl');
		if(!empty($data['row'])){
			if ($this->input->post()) {
				$this->form_validation->set_rules('cat_name', 'Name', 'required|max_length[100]');
				$this->form_validation->set_rules('pcat_name', 'Status', 'required');
				$this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
				$this->form_validation->set_rules('meta_tag', 'Meta Tag', 'trim|max_length[30]');
				$this->form_validation->set_rules('meta_keywd', 'Meta Keyword', 'trim|max_length[30]');
				$this->form_validation->set_rules('meta_desc', 'Meta Description', 'trim|max_length[100]');
				$this->form_validation->set_rules('cat_status', 'Status', 'required');
				if ($this->form_validation->run()) {
					$cat_city 	= $this->input->post('cat_city');
					$cities 	= '';
					if(!empty($cat_city)){
						$cities = implode(',',$cat_city);
					}else{
						$cityquery 		= $this->user_model->getCityList('','');
						$allcity		= [];
						$count			= 0;
						foreach($cityquery as $cityid){
							$allcity[$count] = $cityid->city_id;
							$count++;
						}
						$cities = implode(',',$allcity);
					}
					if(!empty($_FILES) && !empty($_FILES['banner']['name'])){
						$filename = $_FILES['banner']['name'];
						$tmp_path = $_FILES['banner']['tmp_name'];
						$image_name = uploadImage($filename, $tmp_path, 'category/banner', '140');
					}else{
						$image_name = $subcatdata->banner;
					}
					$cat_faq 	= $this->input->post('cat_faq');
					$faqids 	= '';
					if(!empty($cat_faq)){
						$faqids = implode(',',$cat_faq);
					}else{
						$faqids = $subcatdata->faq;
					} 
				$data = array(
					'id' 				=> $this->input->post('id'),
					'parent_id' 		=> $this->input->post('pcat_name'),
					'name' 				=> ucfirst($this->input->post('cat_name')),
					'amount' 			=> $this->input->post('amount'),
					'cat_slogan' 		=> $this->input->post('cat_slogan'),
					'banner' 			=> $image_name,
					'meta_tag' 			=> $this->input->post('meta_tag'),
					'meta_keyword' 		=> $this->input->post('meta_keywd'),
					'meta_description' 	=> $this->input->post('meta_desc'),
					'status' 			=> $this->input->post('cat_status'),
					'mapped_city' 		=> $cities,
					'faq' 				=> $faqids,
					'recurring_payment' => $this->input->post('recurring_payment'),
					'modified' 			=> date('Y-m-d H:i:s')
				);

				$responce = $this->category_model->updateCategory($data);

				if ($responce) {
					$this->session->set_flashdata('responce_msg',array('class'=>SUCCESS_ALERT,'short_msg' =>'SUCCESS','message'=>'Subcategory has been updated successfully.'));
					redirect(base_url('admin/category/subcategory_list'));
				} else {
					_manage_template('templates/header', 'templates/footer', 'category/edit_subcategory', $data, 'templates/left_adminMenu');
				}
			}
		   }
			_manage_template('templates/header', 'templates/footer', 'category/edit_subcategory', $data, 'templates/left_adminMenu');
		}else{
			$this->session->set_flashdata('responce_msg',array('class'=>DANGER_ALERT,'short_msg' =>'ERROR','message'=>'No data found.'));
			redirect(base_url('admin/category/subcategory_list'));
		}
    }
	
	/* public function subcatform() {
        $data['section_name'] = "Category Management";
        $data['page_title'] = $data['site_title'] = "Create category";
        $data['pageUrl'] = $pageUrl = base_url($this->session->userdata('user_type') . 'admin/category/create');
        $data['breadcrumb'] = '<ol class="breadcrumb float-sm-right">'
                . '<li class="breadcrumb-item"><a href="' . base_url($this->session->userdata('user_type') . '/admin/category/category_list') . '">category</a></li><li class="breadcrumb-item"><a href="' . $pageUrl . '">' . $data['page_title'] . '</a></li>'
                . '</ol>';
         _manage_template('templates/header', 'templates/footer', 'subcategoryform/create', $data, 'templates/left_adminMenu');
    } */
}
