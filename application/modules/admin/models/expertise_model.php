<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class expertise_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function createExpertise($data) {
        $query = $this->db->insert('nw_experties_tbl', $data);
        return $query;
    }
    public function listExpertise($status=null) {
		if(!empty($status)){
			$this->db->where('status','1');
		}
        $query = $this->db->get('nw_experties_tbl');
        return $query->result();
    }
    public function deleteExpertise($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('nw_experties_tbl');
        return $query;
    }
    public function updateExpertise($data){
            
        $id = $data['id'];
        $this->db->where('id',$id);
        $query = $this->db->update('nw_experties_tbl',$data);
        return $query;
    }
      
    public function getExpertiseById($id){
        $this->db->where('id',$id);
        $query = $this->db->get('nw_experties_tbl');
        return $query->row();
    }
    public function getExpertiseStatus($id){
        
        $this->db->select('status');
        $this->db->where('id',$id);
        $query = $this->db->from('nw_experties_tbl')->get()->row();
//        echo $this->db->last_query();
//        exit;
        return $query;
    }
    public function changeExpertiseStatus($id,$data){
        
        $this->db->where('id',$id);
        $query = $this->db->update('nw_experties_tbl',$data);
        $this->db->last_query();
        return $query;
    }
    
    public function getExpertiseName($data){

        $this->db->select('*');
        $this->db->where_in('id',$data);
        $query = $this->db->from('nw_experties_tbl')->get()->result();
//        _printr($query);
//        echo $this->db->last_query();
        return $query;
        
        
    }
    public function check_experties_unique($name, $id) {
        $query = $this->db->get_where('nw_experties_tbl', array('name'=>$name,'id !='=>$id));
        return $query->row();
    }
    
}

?>
