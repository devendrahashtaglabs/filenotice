<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class expertise_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function listExpertise($status =null ) {
		if(!empty($status)){
			$this->db->where('status',$status);
		}
        $query = $this->db->get('nw_experties_tbl');
        return $query->result();
    }
    public function getExpertiseById($id,$status=null){
		$this->db->cache_on();
        $this->db->where('id',$id);
		if(!empty($status)){
			$this->db->where('status','1');
		}
        $query = $this->db->get('nw_experties_tbl');
        return $query->row();
    }
}

?>
