<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function getParentCategory(){
		$this->db->cache_on();
        $this->db->where('status','1');
        $this->db->where('parent_id','0');
        $query = $this->db->order_by('name','asc')->get('nw_category_tbl');
        return $query->result();
    }
	
	
    public function get_category_data($id) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('id'=>$id));
        $query = $this->db->get('nw_category_tbl')->row();
        return $query;
    }
	public function getsubcategory($catid) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('parent_id'=>$catid));
        $query = $this->db->get('nw_category_tbl')->result();
        return $query;
    }
	
}