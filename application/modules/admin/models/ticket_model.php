<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ticket_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        if ( ! defined( 'TICKETTABLE')) {
			define('TICKETTABLE','nw_ticket_tbl');
		}
    }

//    public function getTicketList() {
//        $this->db->select('nw_category_tbl.name as category_name, user_typeTwo.email AS typeTwoEmail,IF(nw_customer_tbl.id<>"",nw_customer_tbl.name,"'.DEFAULT_VALUE.'") As customer_name, nw_ticket_tbl.*', false);
//        $this->db->from('nw_ticket_tbl');
//        $this->db->join('nw_category_tbl', 'nw_ticket_tbl.category_id=nw_category_tbl.id', 'left');
//        $this->db->join('nw_user_tbl As user_typeTwo', 'nw_ticket_tbl.customer_id = user_typeTwo.id', 'left');
//        $this->db->join('nw_customer_tbl', 'nw_ticket_tbl.customer_id=nw_customer_tbl.id', 'left');
//        $this->db->order_by('nw_ticket_tbl.id', 'desc');
//        $query = $this->db->get();
//        return $query->result();
//    }
    
    public function createTicket($data) {
        $query = $this->db->insert('nw_ticket_tbl', $data);
        return $query;
    }


    public function getTicketById($id) {
		$this->db->cache_on();
        $this->db->select('nw_ticket_tbl.*,nw_ticket_tbl.id as ticketid,nw_ticket_tbl.ticket_id as custom_id,nw_customer_tbl.name as customername,nw_customer_tbl.sname as customersname,nw_customer_tbl.title as title,nw_category_tbl.name as category_name, IF(nw_category_tbl.parent_id="0",nw_category_tbl.id,nw_category_tbl.parent_id) as categoryid, nw_user_tbl.id as userid,nw_ticket_map_tbl.consultant_id,nw_ticket_map_tbl.assign_date', false);
        $this->db->where('nw_ticket_tbl.id', $id);
        $this->db->from('nw_ticket_tbl');
        $this->db->join('nw_category_tbl', 'nw_ticket_tbl.category_id=nw_category_tbl.id', 'left');
        $this->db->join('nw_user_tbl', 'nw_ticket_tbl.customer_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_ticket_map_tbl', 'nw_ticket_tbl.id=nw_ticket_map_tbl.ticket_id', 'left');
        $this->db->join('nw_customer_tbl', 'nw_ticket_tbl.customer_id=nw_customer_tbl.user_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }
    public function updateTicket($data,$id) {
        $this->db->where('id', $id);
        $query = $this->db->update('nw_ticket_tbl', $data);
        return $query;
    }
	/**** 21022020 created ****/
		public function updateTicketData($data,$table,$column_name,$column_value) {
			$this->db->where($column_name, $column_value);
			$query = $this->db->update($table, $data);
			return $query;
		}
	/**** 21022020 created ****/
    // 25 sep 2019
	public function updateTicketNew($new_status,$new_ticket_status,$id) {
		$this->db->set('status',$new_status);
		$this->db->set('ticket_status',$new_ticket_status);
		$this->db->where('ticket_id',$id);
		$this->db->update('nw_ticket_map_tbl');
		//echo $this->db->last_query();
		return true;
	}
    // public function updateTicketNew($new_status,$id){
    //     $sql = "UPDATE nw_ticket_map_tbl SET status = $new_status WHERE ticket_id= $id";
    // }
    
    public function update_ratingStatus($data,$id) {
        $this->db->where('id', $id);
        $query = $this->db->update('nw_rating_tbl', $data);
        return $query;
    }

    public function insertTicketMap($data) {
        $return = self::getMappedTicket($data['ticket_id']);
        if(empty($return)){
            // echo 'n';exit;
            $query = $this->db->insert('nw_ticket_map_tbl', $data);
            // echo $query;exit;
        }else{
            // echo 'p';exit;
            unset($data['created']);
            unset($data['ticket_id']);
            unset($data['customer_id']);
            $query = self::updateRecordsById($return->id, $data);
            // echo $query;exit;
        }
        return $query;
    }
	
    
    public function getMappedTicket($ticketid) {
		$this->db->cache_on();
        $this->db->where('ticket_id', $ticketid);
        $query = $this->db->get('nw_ticket_map_tbl')->row();
        return $query;
    }
    
    public function updateRecordsById($mapid, $data) {
        $query = $this->db->where('id', $mapid)->update('nw_ticket_map_tbl', $data);
        return $query;
    }
    
//    public function updateTicketMap($data){
//        $id = $data['id'];
//        $this->db->where('id',$id);
//        $query = $this->db->update('nw_ticket_map_tbl',$data);
//        return $query;
//    }
//
    public function getAssignTicket($ignore_status_code = null) {
		$this->db->cache_on();
        $this->db->select('tickets.id as ticketid, tickets.ticket_id AS customid,tickets.close_date,user_typeTwo.email AS typeTwoEmail,'
                . 'IF(nw_customer_tbl.id<>"",nw_customer_tbl.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'user_typethree.email AS typeThreeEmail,IF(nw_consultant_tbl.id<>"",nw_consultant_tbl.name,'
                . '"'.DEFAULT_VALUE.'") As consultant_name,maps.*,maps.status As mapstatue', false);
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl AS tickets', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_user_tbl As user_typeTwo', 'tickets.customer_id = user_typeTwo.id', 'left');
        $this->db->join('nw_customer_tbl', 'nw_customer_tbl.user_id = user_typeTwo.id', 'left');
        $this->db->join('nw_user_tbl As user_typethree', 'maps.consultant_id = user_typethree.id', 'left');
        $this->db->join('nw_consultant_tbl', 'user_typethree.id = nw_consultant_tbl.user_id', 'left');
        $this->db->where('tickets.status',1, false);
		if(!empty($ignore_status_code)){
			$this->db->where_not_in('tickets.ticket_status', $ignore_status_code);
		}
        $this->db->order_by('ticketid', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getCompletedTicket($completed_status = null) {
		$this->db->cache_on();
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,consultant.user_id,consultant.name,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from('nw_ticket_tbl AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->where('tickets.status',1, false); // parameter value 2 indicate status=0 and 1 indicate status = 1 .
        $this->db->where_in('tickets.ticket_status',$completed_status); // parameter value 2 indicate status=0 and 1 indicate status = 1 .
        $this->db->order_by('tickets.id', 'desc');
        $query  = $this->db->get();
        $data['data'] = $query->result();
        return $data;
    }
//
////    public function getAssignTicketById($id) {
////        $this->db->select('nw_ticket_tbl.close_date as close_date,nw_ticket_tbl.description as description,nw_customer_tbl.name as customer_name,nw_consultant_tbl.name as consultant_name,nw_ticket_map_tbl.*');
////        $this->db->where('nw_ticket_map_tbl.id', $id);
////        $this->db->from('nw_ticket_map_tbl');
////        $this->db->join('nw_consultant_tbl', 'nw_consultant_tbl.id = nw_ticket_map_tbl.consultant_id', 'left');
////        $this->db->join('nw_ticket_tbl', 'nw_ticket_tbl.id = nw_ticket_map_tbl.ticket_id', 'left');
////        $query = $this->db->join('nw_customer_tbl', 'nw_customer_tbl.id = nw_ticket_map_tbl.customer_id', 'left')->get();
////        return $query->row();
////    }
    public function delete($id) {
        $return = self::getMappedTicket($id);
        if(!empty($return)){
            self::deleteMapData($return->id);
        }
        $this->db->where('id', $id);
        $query = $this->db->delete('nw_ticket_tbl');
        return $query;
    }

    public function deleteMapData($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('nw_ticket_map_tbl');
        return $query;
    }
    
    public function getCountOfTicket($status){
		$this->db->cache_on();
        $this->db->where('ticket_status',$status);
        $result = $this->db->get(TICKETTABLE)->result_array();
        if(empty($result)){
            return $result['total'] = '0';
        }else{
            return $result['total'] = count($result);
        }
    }

    public function getTicketList($status=null,$column=null,$start=null,$limit=null,$orderBy=null){
        $this->db->cache_on();
		$data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id,'
                . 'user_customer.email AS customer_email,categorys.name as category_name,IF(customers.id<>"",customers.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As user_customer', 'tickets.customer_id = user_customer.id', 'left');
        $this->db->join('nw_customer_tbl As customers', 'user_customer.id=customers.user_id', 'left');
		if(!empty($status)){
            $this->db->where('tickets.status', $status, false);
        }
		$completed_status = array(90,91);
		$this->db->where_not_in('tickets.ticket_status', $completed_status);
        if($orderBy!=''){
            $this->db->order_by($orderBy, "desc");
        } else {
            $this->db->order_by('customId', 'desc');
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }
	public function getAllTicketList($status=null,$column=null,$start=null,$limit=null,$orderBy=null){
        $this->db->cache_on();
		$data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id,'
                . 'user_customer.email AS customer_email,categorys.name as category_name,IF(customers.id<>"",customers.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As user_customer', 'tickets.customer_id = user_customer.id', 'left');
        $this->db->join('nw_customer_tbl As customers', 'user_customer.id=customers.user_id', 'left');
		if(!empty($status)){
            $this->db->where('tickets.status', $status, false);
        }
		//$completed_status = array(90,91);
		//$this->db->where_not_in('tickets.ticket_status', $completed_status);
		$this->db->where('tickets.ticket_status', '10');
        if($orderBy!=''){
            $this->db->order_by($orderBy, "desc");
        } else {
            $this->db->order_by('customId', 'desc');
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }
	 public function getActiveTicketList($ticket_status=null,$status=null,$column=null,$start=null,$limit=null,$orderBy=null) {
        $this->db->cache_on();
		$data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id,'
                . 'user_customer.email AS customer_email,categorys.name as category_name,IF(customers.id<>"",customers.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As user_customer', 'tickets.customer_id = user_customer.id', 'left');
        $this->db->join('nw_customer_tbl As customers', 'user_customer.id=customers.user_id', 'left');
		if(!empty($status)){
            $this->db->where('tickets.status', $status, false);
        }
		/* if(!empty($ticket_status)){
            $this->db->where('tickets.ticket_status', $ticket_status, false);
        } */
        if($orderBy!=''){
            $this->db->order_by($orderBy, "desc");
        } else {
            $this->db->order_by('customId', 'desc');
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }

    function UpdateTicketStartTime($id,$Date){
        
        $this->db->set('start_date',$Date);
        $this->db->where('id',$id);
        $this->db->update('nw_ticket_tbl');        
        
    }
    
    
    public function getChatAgainstTicket($ticketid=null,$chatid=null,$customer=null,$consultant=null){
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->where('ticket_id',$ticketid);
        $this->db->where('status','1');
        $query = $this->db->order_by('id')->get('nw_conversation_tbl')->result();
        return $query;
    }
    
    public function getUsersChatAgainstTicket($chatid,$userid){
        $this->db->cache_on();
		$this->db->select('nw_conversation_tbl.chat_massege,nw_conversation_tbl.created_at,nw_conversation_tbl.chat_type,nw_user_tbl.user_type,
            nw_user_tbl.id as userid');
        $this->db->join('nw_user_tbl', 'nw_conversation_tbl.user_id = nw_user_tbl.id', 'left');
        $this->db->where(array('nw_conversation_tbl.id'=>$chatid,'nw_conversation_tbl.user_id'=>$userid));
        $query = $this->db->get('nw_conversation_tbl')->row();
        return $query;
    }
    
    public function getPaymentList(){
        $this->db->cache_on();
		$this->db->select('nw_payment_tbl.ticket_id, nw_payment_tbl.payer_email, nw_payment_tbl.payment_date,nw_payment_tbl.user_id,nw_payment_tbl.payment_amount,
            nw_payment_tbl.status, nw_user_tbl.email');
        $this->db->join('nw_user_tbl', 'nw_payment_tbl.user_id = nw_user_tbl.id', 'left');
         $this->db->join('nw_ticket_tbl', 'nw_payment_tbl.ticket_id = nw_ticket_tbl.ticket_id');
        $query = $this->db->get('nw_payment_tbl')->result();
        return $query;
    }
   /*  public function checkticketavailable($ticketid,$user_id) {
		$this->db->select('*');
        $this->db->where(array('ticket_id'=>$ticketid));
        $this->db->where(array('user_id'=>$user_id));
        $data['data'] = $this->db->get('nw_conversation_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	} */
	public function getticketstatuslist(){
        $this->db->select('*');
        $this->db->from('nw_master_ticket_status_tbl');
		//$this->db->where_not_in('status_code', $ignore_status_code);
        $query = $this->db->get()->result();
        return $query;
    }
	public function getActiveTicketListAdmin($ticket_status=null,$status=null,$column=null,$start=null,$limit=null,$orderBy=null) {
        $this->db->cache_on();
		$data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id,'
                . 'user_customer.email AS customer_email,categorys.name as category_name,IF(customers.id<>"",customers.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As user_customer', 'tickets.customer_id = user_customer.id', 'left');
        $this->db->join('nw_customer_tbl As customers', 'user_customer.id=customers.user_id', 'left');
		if(!empty($status)){
            $this->db->where('tickets.status', $status, false);
        }
		if(!empty($ticket_status)){
            $this->db->where_not_in('tickets.ticket_status', $ticket_status);
        }
        if($orderBy!=''){
            $this->db->order_by($orderBy, "desc");
        } else {
            $this->db->order_by('customId', 'desc');
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }
	public function getuserdatabyticketid($ticke_id) {
		$this->db->cache_on();
		$this->db->select('maps.customer_id,maps.consultant_id,tickets.ticket_id,consultant.name as consultantname,customer.name as customername,category.name as cname,consultant.subcategory_id as consultantsubcat');
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl As tickets', 'tickets.id = maps.ticket_id', 'left');
		$this->db->join('nw_consultant_tbl As consultant', 'consultant.user_id = maps.consultant_id', 'left');
		$this->db->join('nw_customer_tbl As customer', 'customer.user_id = maps.customer_id', 'left');	
		$this->db->join('nw_category_tbl As category', 'category.id = consultant.category_id', 'left');	
		$this->db->where('maps.ticket_id',$ticke_id);
		$this->db->where('maps.status','1');
		$completed_status = array(90,91);
		$this->db->where_not_in('maps.ticket_status',$completed_status);
		$data = $this->db->get()->row();
        return $data;
	}
	public function getticketidfrommaptable($mapid){
		$this->db->cache_on();
		$this->db->select('maps.ticket_id');
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl As tickets', 'tickets.id = maps.ticket_id', 'left');
		$this->db->where('maps.id',$mapid);
		//$this->db->where('maps.status','1');
		//$completed_status = array(90,91);
		//$this->db->where_not_in('maps.ticket_status',$completed_status);
		$data = $this->db->get()->row();
        return $data;
	}
	public function updateMapRecordsByTicketId($ticketid, $data) {
        $query = $this->db->where('ticket_id', $ticketid)->update('nw_ticket_map_tbl', $data);
        return $query;
    }
	public function getticketuserdatafrommaptable($mapid){
		$this->db->cache_on();
		$this->db->select('maps.ticket_id,tickets.ticket_id as customId,maps.consultant_id ,maps.customer_id,consultant.name as consultantname,customer.name as customername');
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl As tickets', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_customer_tbl As customer', 'maps.customer_id = customer.user_id', 'left');
		$this->db->where('maps.id',$mapid);
		$this->db->where('maps.status','1');
		//$completed_status = array(90,91);
		//$this->db->where_not_in('maps.ticket_status',$completed_status);
		$data = $this->db->get()->row();
        return $data;
	}
	public function getthedata($key,$value,$table) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($key,$value);
		$resultdata = $this->db->get()->result();
		return $resultdata; 
	}
	public function GetChatlastdatetime($ticket_id) {
		$resultdata = $this->db->query('SELECT  * FROM nw_conversation_tbl WHERE nw_conversation_tbl.ticket_id = "'.$ticket_id.'" ORDER BY nw_conversation_tbl.created_at DESC')->row();
		
		return $resultdata; 
	}
	public function getcustomerrequestdata($ticketid=null) {
		$this->db->cache_on();
		$this->db->select('customer_request.*,tickets.ticket_id as customId,users.email as customeremail,customer.*', false);
        $this->db->from('nw_customer_request_tbl AS customer_request');
        $this->db->join('nw_ticket_tbl As tickets', 'tickets.id = customer_request.ticket_id', 'left');
        $this->db->join('nw_user_tbl As users', 'customer_request.user_id = users.id', 'left');
        $this->db->join('nw_customer_tbl As customer', 'customer_request.user_id = customer.user_id', 'left');
        $this->db->where('tickets.status',1, false);
		if(!empty($ticketid)){
			$this->db->where('customer_request.ticket_id',$ticketid, false);
		}
        $query  = $this->db->get();
        $data = $query->result();
        return $data;
	}
	/**** 01-05-2020 ****/
	/* public function getCustomAssignTicket($ignore_status_code = null) {
		$this->db->cache_on();
        $this->db->select('tickets.id as ticketid, tickets.ticket_id AS customid,tickets.close_date,user_typeTwo.email AS typeTwoEmail,'
                . 'IF(nw_customer_tbl.id<>"",nw_customer_tbl.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'user_typethree.email AS typeThreeEmail,IF(nw_consultant_tbl.id<>"",nw_consultant_tbl.name,'
                . '"'.DEFAULT_VALUE.'") As consultant_name,maps.*,maps.status As mapstatue', false);
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl AS tickets', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_user_tbl As user_typeTwo', 'tickets.customer_id = user_typeTwo.id', 'left');
        $this->db->join('nw_customer_tbl', 'nw_customer_tbl.user_id = user_typeTwo.id', 'left');
        $this->db->join('nw_user_tbl As user_typethree', 'maps.consultant_id = user_typethree.id', 'left');
        $this->db->join('nw_consultant_tbl', 'user_typethree.id = nw_consultant_tbl.user_id', 'left');
        $this->db->where('tickets.status',1, false);
		if(!empty($ignore_status_code)){
			$this->db->where_not_in('tickets.ticket_status', $ignore_status_code);
		}
        $this->db->order_by('ticketid', 'DESC');
        $query = $this->db->get();
        return $query->result();
    } */
	/**** 06072020 *******/
	public function getTickets($limit=null,$orderBy=null,$orderType=null,$ticket_status=null,$status=null) {
		$this->db->cache_on();
        $data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,cusers.email AS consultant_email,customer.name AS customer_name,customer.sname AS customer_sname,consultant.user_id,consultant.name AS consultant_name,consultant.sname AS consultant_sname,consultant.mobile AS consultant_mobile,maps.assign_date,consultant.photo AS consultant_photo,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from('nw_ticket_tbl AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_customer_tbl As customer', 'tickets.customer_id = customer.user_id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_user_tbl As cusers', 'consultant.user_id = cusers.id', 'left');
		if(!empty($ticket_status)){
            $this->db->where_in('tickets.ticket_status',$ticket_status);
        }
         if($status!=''){
            $this->db->where('tickets.status',$status, false);
        }
        if($orderBy!=''){
            $this->db->order_by($orderBy, $orderType);
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }	
	
	/**** 06072020 *******/

}

