<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
//    public function getCustomerById($id){
//        $this->db->select('*');
//        $this->db->where('id',$id);
//        $query = $this->db->from('nw_customer_tbl')->get();
//        return $query->row();
//    }
    
    public function get_rating($id){
        $this->db->select('AVG(rating) as average');
        $this->db->where(array('consultant_id' => $id));
        $this->db->from('nw_rating_tbl');
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query ->row();
    }
    
    public function get_rating_by_ticketid($id){
        $this->db->select('*');
        $this->db->where('ticket_id', $id);
        $this->db->from('nw_rating_tbl');
        $query = $this->db->get();
        return $query ->row();
    }
    
}
