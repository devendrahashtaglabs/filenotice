<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function createCategory($data) {
        $query = $this->db->insert('nw_category_tbl', $data);
        return $query;
    }
    public function listCategory() {
        $this->db->select('*');
        $this->db->from('nw_category_tbl');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function deleteCategory($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('nw_category_tbl');
        return $query;
    }
    public function getCategoryById($id) {
		$this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('nw_category_tbl');
        return $query->row();
        
    }
    public function getParentCategory($status=null){
        $this->db->where('parent_id',0);
		if(!empty($status)){
			$this->db->where('status',$status);
		}
        $query = $this->db->get('nw_category_tbl');
        return $query->result();
    }
    public function updateCategory($data){
        $id = $data['id'];
        $this->db->where('id',$id);
        $query = $this->db->update('nw_category_tbl',$data);
        return $query;
    }
    public function createSubCategory($data){
        $query = $this->db->insert('nw_category_tbl',$data);
        return $query;
    }
    public function parentCategoryName($id){
        $this->db->select('name');
        $this->db->where('id',$id);
        $query = $this->db->from('nw_category_tbl')->get()->row();
        return $query;
    }
    public function listSubCategory(){
        $this->db->select('*');
        $this->db->where('parent_id !=',0,FALSE);
         $this->db->order_by('id', 'desc');
        $query = $this->db->get('nw_category_tbl');
        return $query->result();
    }
    public function listSubCategoryById($id){
        $this->db->select('*');
        $this->db->where('parent_id =',$id);
        $this->db->where('status','1');
        $query = $this->db->get('nw_category_tbl');
        return $query->result();
    }
    public function getCategoryStatus($id){
        
        $this->db->select('status');
        $this->db->where('id',$id);
        $query = $this->db->from('nw_category_tbl')->get()->row();
        return $query;
    }
    public function changeCategoryStatus($id,$data){
        
        $this->db->where('id',$id);
        $query = $this->db->update('nw_category_tbl',$data);
        $this->db->last_query();
        return $query;
    }
    public function check_category_unique($name, $id) {
        $query = $this->db->get_where('nw_category_tbl', array('name'=>$name,'id !='=>$id, 'parent_id'=>0));
        return $query->row();
    }
		
}