<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class ticket_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
		if ( !defined( 'TICKETTABLE')) {
			define('TICKETTABLE','nw_ticket_tbl');
		}
    }
    
    public function createTicket($data) {
        $query = $this->db->insert('nw_ticket_tbl', $data);
        return $query;
    }

    public function getTicketById($id) {
		$this->db->cache_on();
        $this->db->select('nw_ticket_tbl.*,nw_ticket_tbl.id as ticketid,nw_ticket_tbl.ticket_id as custom_id,nw_category_tbl.name as category_name, IF(nw_category_tbl.parent_id="0",nw_category_tbl.id,nw_category_tbl.parent_id) as categoryid, nw_user_tbl.id as userid,nw_ticket_map_tbl.consultant_id,nw_ticket_map_tbl.assign_date', false);
        $this->db->where('nw_ticket_tbl.id', $id);
        $this->db->from('nw_ticket_tbl');
        $this->db->join('nw_category_tbl', 'nw_ticket_tbl.category_id=nw_category_tbl.id', 'left');
        $this->db->join('nw_user_tbl', 'nw_ticket_tbl.customer_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_ticket_map_tbl', 'nw_ticket_tbl.id=nw_ticket_map_tbl.ticket_id', 'left');
        $query = $this->db->get();
        return $query->row();
    }
  
    public function updateTicket($data,$id) {
        $this->db->where('id', $id);
        $query = $this->db->update('nw_ticket_tbl', $data);
        return $query;
    }

    public function getMappedTicket($ticketid) {
		$this->db->cache_on();
        $this->db->where('ticket_id', $ticketid);
        $query = $this->db->get('nw_ticket_map_tbl')->row();
        return $query;
		echo "<pre>";print_r($return);echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
    }
  
    public function updateRecordsById($mapid, $data) {
        $query = $this->db->where('id', $mapid)->update('nw_ticket_map_tbl', $data);
        return $query;
    }
	
	public function updateticketmaptblbyticketid($ticketid, $data) {
        $query = $this->db->where('ticket_id', $ticketid)->update('nw_ticket_map_tbl', $data);
        return $query;
    }
	
	public function getAssignTicket($user_id,$ticket_status=null,$userType=null) {
		$this->db->cache_on();
        $this->db->select('tickets.id as ticketid, tickets.ticket_id AS customid,tickets.close_date,user_typeTwo.email AS typeTwoEmail,'
                . 'IF(nw_customer_tbl.id<>"",nw_customer_tbl.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'user_typethree.email AS typeThreeEmail,IF(nw_consultant_tbl.id<>"",nw_consultant_tbl.name,'
                . '"'.DEFAULT_VALUE.'") As consultant_name,user_typeTwo.user_type AS customeridentity,user_typethree.user_type AS consultantidentity,maps.*,maps.status As mapstatue', false);
        //$this->db->where('tickets.ticket_status',$ticket_status, false);
        $this->db->from('nw_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl AS tickets', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_user_tbl As user_typeTwo', 'tickets.customer_id = user_typeTwo.id', 'left');
        $this->db->join('nw_customer_tbl', 'nw_customer_tbl.user_id = user_typeTwo.id', 'left');
        $this->db->join('nw_user_tbl As user_typethree', 'maps.consultant_id = user_typethree.id', 'left');
        $this->db->join('nw_consultant_tbl', 'user_typethree.id = nw_consultant_tbl.user_id', 'left');
		if($userType=='consultant'){
            $this->db->where('maps.consultant_id',$user_id, false);
        }else{
            $this->db->where('maps.customer_id',$user_id, false);
        }
		if(!empty($ticket_status)){
			$this->db->where_not_in('maps.ticket_status', $ticket_status);
		}
		$this->db->where('maps.status','1', false);
        $this->db->order_by('maps.assign_date', 'DESC');
        $query = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }else{
            $data['count'] = '0';
        }
        return $data;
    }
	public function getAgentAssignTicket($user_id,$ticket_status=null,$userType=null) {
		$this->db->cache_on();
        $this->db->select('tickets.id as ticketid, tickets.ticket_id AS customid,tickets.close_date,user_typeTwo.email AS typeTwoEmail,'
                . 'IF(nw_customer_tbl.id<>"",nw_customer_tbl.name,"'.DEFAULT_VALUE.'") As customer_name,'
                . 'user_typethree.email AS typeThreeEmail,IF(nw_consultant_tbl.id<>"",nw_consultant_tbl.name,'
                . '"'.DEFAULT_VALUE.'") As consultant_name,user_typeTwo.user_type AS customeridentity,user_typethree.user_type AS consultantidentity,maps.*,maps.status As mapstatue', false);
        //$this->db->where('tickets.ticket_status',$ticket_status, false);
        $this->db->from('nw_agent_ticket_map_tbl As maps');
        $this->db->join('nw_ticket_tbl AS tickets', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_user_tbl As user_typeTwo', 'tickets.customer_id = user_typeTwo.id', 'left');
        $this->db->join('nw_customer_tbl', 'nw_customer_tbl.user_id = user_typeTwo.id', 'left');
        $this->db->join('nw_user_tbl As user_typethree', 'maps.consultant_id = user_typethree.id', 'left');
        $this->db->join('nw_consultant_tbl', 'user_typethree.id = nw_consultant_tbl.user_id', 'left');
		if($userType=='consultant'){
            $this->db->where('maps.consultant_id',$user_id, false);
        }elseif($userType=='customer'){
            $this->db->where('maps.customer_id',$user_id, false);
        }else{
            $this->db->where('maps.agent_id',$user_id, false);			
		}
		if(!empty($ticket_status)){
			$this->db->where_not_in('maps.ticket_status', $ticket_status);
		}
		$this->db->where('maps.status','1', false);
        $this->db->order_by('maps.assign_date', 'DESC');
        $query = $this->db->get();
        $data['data'] = $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }else{
            $data['count'] = '0';
        }
        return $data;
    }

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

    public function getCustomerTicketList($userId,$limit=null,$orderBy=null,$orderType=null,$ticket_status=null,$status=null,$type=null) {
		$this->db->cache_on();
        $data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,cusers.email AS consultant_email,consultant.user_id,consultant.name AS consultant_name,consultant.mobile AS consultant_mobile,consultant.photo AS consultant_photo,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_user_tbl As cusers', 'consultant.user_id = cusers.id', 'left');
        if($ticket_status!=''){
            $this->db->where('tickets.ticket_status',$ticket_status, false);
        }
         if($status!=''){
            $this->db->where('tickets.status',$status, false);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'customer'){
            $this->db->where('tickets.customer_id',$userId);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'consultant'){
            $this->db->where('maps.consultant_id',$userId);
        }
        /* if($type == 'new'){
            $this->db->where('date_format(tickets.created,"%Y-%m-%d")', 'CURDATE()', FALSE);
        } */
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
    
    /* public function getChatAgainstTicket($ticketid=null,$chatid=null,$customer=null,$consultant=null){
        $this->db->select('*');
        $this->db->where('ticket_id',$ticketid);
        $this->db->where('status','1');
        $query = $this->db->order_by('id')->get('nw_conversation_tbl')->result();
        return $query;
    } */
	public function getChatAgainstTicket($ticketid=null,$chatid=null,$customer=null,$consultant=null,$start=null,$limit=null,$last_id=NULL){
		$this->db->cache_on();
        $this->db->select('*');
		$this->db->from('nw_conversation_tbl');
        $this->db->where('ticket_id',$ticketid);
        $this->db->where('status','1');
		if($last_id!= NULL && $last_id!= ""){
			$this->db->where('id <',$last_id);
		}
		$this->db->order_by('id','desc');
		if(empty($limit) && empty($start)){
			$this->db->limit('10','0');
		}else{
			$this->db->limit($limit,$start);
		}
		$query = $this->db->get();
        $conversationdata = $query->result();
        return $conversationdata;
    }
	public function getNewChatAgainstTicket($ticketid=null,$chatid=null){
		$this->db->cache_on();
        $this->db->select('*');
		$this->db->from('nw_conversation_tbl');
        $this->db->where('ticket_id',$ticketid);
        $this->db->where('status','1');
		if($chatid!= NULL && $chatid!= ""){
			$this->db->where('id >',$chatid);
		}
		$this->db->order_by('id','desc');
		$query = $this->db->get();
        $conversationdata = $query->result();
        return $conversationdata;
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
    
    public function createChat($data) {
        $this->db->insert('nw_conversation_tbl', $data);
        $query = self::getUsersChatAgainstTicket($this->db->insert_id(),$data['user_id']);
        return $query;
    }
    
    public function createFeedback($data) {
        $query = $this->db->insert('nw_rating_tbl', $data);
        return $query;
    }
    
    public function get_rating($ticket_id, $customer_id, $consultant_id) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('ticket_id'=>$ticket_id, 'customer_id'=>$customer_id, 'consultant_id'=>$consultant_id));
        $query = $this->db->get('nw_rating_tbl')->result();
        return $query;
    }

    public function getCustomerFeedBackList($id){
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('consultant_id'=>$id));
        $query = $this->db->get('nw_rating_tbl')->result();
        return $query;
    }
    
    public function get_ticket_data($ticket_id) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('id'=>$ticket_id));
        $query = $this->db->get('nw_ticket_tbl')->row();
        return $query;
    }
    // public function updateTicketreadstatus($updateArr,$ticket_id,$user_id) {
    //     echo "<pre>";
    //     print_r($user_id);
    //     exit;

    //     $this->db->where('ticke_id', $ticket_id);
    //     $this->db->where('user_id', $user_id);
    //     $query = $this->db->update('nw_conversation_tbl', $updateArr);
    //     return $query;
    // }
    
    public function getConsultantTicketListCount($userId,$limit=null,$orderBy=null,$orderType=null,$ticket_status=null,$status=null,$type=null){ 
		$this->db->cache_on();
        $data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,cusers.email AS consultant_email,consultant.user_id,consultant.name AS consultant_name,consultant.mobile AS consultant_mobile,consultant.photo AS consultant_photo,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_user_tbl As cusers', 'consultant.user_id = cusers.id', 'left');
        if(!empty($ticket_status)){
            $this->db->where_not_in('maps.ticket_status',$ticket_status);
        }
        if($status!=''){
            $this->db->where('tickets.status',$status, false);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'customer'){
            $this->db->where('maps.customer_id',$userId);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'consultant'){
            $this->db->where('maps.consultant_id',$userId);
        }
        if($type == 'new'){
            $this->db->where('date_format(maps.created,"%Y-%m-%d")', 'CURDATE()', FALSE);
        }
        if($orderBy!=''){
            $this->db->order_by($orderBy, $orderType);
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
        $query  		= $this->db->get();
        $data['data'] 	= $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }
    public function getConsultTicketList($userId,$limit=null,$orderBy=null,$orderType=null,$ticket_status=null,$status=null) {
		$this->db->cache_on();
        $data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,cusers.email AS consultant_email,consultant.user_id,consultant.name AS consultant_name,consultant.mobile AS consultant_mobile,consultant.photo AS consultant_photo,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_user_tbl As cusers', 'consultant.user_id = cusers.id', 'left');
        if($ticket_status!=''){
            $this->db->where('maps.ticket_status',$ticket_status, false);
        }
         if($status!=''){
            $this->db->where('maps.status',$status, false);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'customer'){
            $this->db->where('tickets.customer_id',$userId);
        }
        if($userId!='' && $this->session->userdata('users')['user_type'] == 'consultant'){
            $this->db->where('maps.consultant_id',$userId);
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
	public function changereadstatus($data,$ticketid,$userid) {
        $this->db->where('ticket_id', $ticketid);
        $this->db->where_not_in('user_id', $userid);
        $query = $this->db->update('nw_conversation_tbl', $data);
        return $query;
    }
	public function getallnotification($ticketid,$userid) {
		$this->db->cache_on();
		$this->db->select('*');
        $this->db->where(array('ticket_id'=>$ticketid,'read_status'=>'0'));
        $this->db->where_not_in('user_id',$userid);
		$this->db->order_by('id','desc');
        $data['data'] = $this->db->get('nw_conversation_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	public function checkticketavailable($ticketid) {
		$this->db->select('*');
        $this->db->where(array('id'=>$ticketid));
		$ignore_status_code = array(90,91);
        $this->db->where_not_in('ticket_status',$ignore_status_code);
        $data['data'] = $this->db->get('nw_ticket_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	/* public function getnewnotification($ticketid) {
		$this->db->select('*');
        $this->db->where(array('id'=>$ticketid));
        $this->db->where(array('ticket_status'=>'1'));
        $data['data'] = $this->db->get('nw_ticket_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	} */
	public function getassignticketsconsultant($userid,$ignore_status_code = null) {
		$this->db->cache_on();
		$this->db->select('*');
        $this->db->where(array('consultant_id'=>$userid));
        if(!empty($ignore_status_code)){
			$this->db->where_not_in('tickets.ticket_status', $ignore_status_code);
		}
		$this->db->where(array('status'=>'1'));
        $data['data'] = $this->db->get('nw_ticket_map_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	public function getassignticketscustomer($userid) {
		$this->db->cache_on();
		$this->db->select('*');
        $this->db->where(array('customer_id'=>$userid));
        $this->db->where(array('ticket_status'=>'1'));
        $this->db->where(array('status'=>'1'));
        $data['data'] = $this->db->get('nw_ticket_tbl')->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	
	public function getallnewnotification($userid) {
		$this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_conversation_tbl As conversation');
        $this->db->join('nw_ticket_tbl As tickets', 'tickets.id = conversation.ticket_id', 'left');
        $this->db->where(array('conversation.msg_to'=>$userid,'conversation.read_status'=>'0','tickets.ticket_status'=>'20','tickets.status'=>'1'));
		$this->db->order_by('conversation.id','desc');
        $data['data'] = $this->db->get()->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	public function getnewticketdata($userid,$last_login){
		$this->db->cache_on();
		$data['count'] = 0;
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,cusers.email AS consultant_email,consultant.user_id,consultant.name AS consultant_name,consultant.mobile AS consultant_mobile,consultant.photo AS consultant_photo,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from(TICKETTABLE.' AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
        $this->db->join('nw_user_tbl As cusers', 'consultant.user_id = cusers.id', 'left');
        if($userid!='' && $this->session->userdata('users')['user_type'] == 'customer'){
			$this->db->where('tickets.customer_id',$userid);
			$this->db->where('tickets.ticket_status','20');
			$this->db->where('tickets.status','1');
        }
        if($userid!='' && $this->session->userdata('users')['user_type'] == 'consultant'){
			$this->db->where('maps.consultant_id',$userid);
			$this->db->where('maps.ticket_status','20');
			$this->db->where('maps.status','1');
        }
		/* if(!empty($last_login)){
			$this->db->where('date_format(maps.created,"%Y-%m-%d %H:%i:%s") >=', $last_login, FALSE);
		} */
        $query  		= $this->db->get();
        $data['data'] 	= $query->result();
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
	}
	public function getCompletedTicket($userId=null,$completed_status = null,$user_type=null) {
		$this->db->cache_on();
        $this->db->select('tickets.*,tickets.ticket_id as customId,maps.id as mapid, maps.ticket_id, maps.consultant_id,'
                . 'users.email AS customer_email,categorys.name as category_name,consultant.user_id,consultant.name,IF(maps.id<>"","true","false") As mapstatus', false);
        $this->db->from('nw_ticket_tbl AS tickets');
        $this->db->join('nw_ticket_map_tbl As maps', 'tickets.id = maps.ticket_id', 'left');
        $this->db->join('nw_category_tbl As categorys', 'tickets.category_id=categorys.id', 'left');
        $this->db->join('nw_user_tbl As users', 'tickets.customer_id = users.id', 'left');
        $this->db->join('nw_consultant_tbl As consultant', 'maps.consultant_id = consultant.user_id', 'left');
		if($userId!='' && $user_type == 'customer'){
            $this->db->where('tickets.customer_id',$userId);
        }
        if($userId!='' && $user_type == 'consultant'){
            $this->db->where('maps.consultant_id',$userId);
        }
        $this->db->where('tickets.status',1, false); // parameter value 2 indicate status=0 and 1 indicate status = 1 .
        $this->db->where_in('tickets.ticket_status',$completed_status); // parameter value 2 indicate status=0 and 1 indicate status = 1 .
        $this->db->order_by('tickets.id', 'desc');
        $query  = $this->db->get();
        $data['data'] = $query->result();
		if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
        return $data;
    }
	public function getuserdatabyticketid($ticke_id) {
		$this->db->cache_on();
		$this->db->select('maps.customer_id,maps.consultant_id,tickets.ticket_id,consultant.name as consultantname,customer.name as customername,category.name as cname');
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
	
	public function insertAgentTicketMap($data) {
        $return = self::getAgentMappedTicket($data['ticket_id']);
        if(empty($return)){
            // echo 'n';exit;
            $query = $this->db->insert('nw_agent_ticket_map_tbl', $data);
            // echo $query;exit;
        }else{
            // echo 'p';exit;
            unset($data['created']);
            unset($data['ticket_id']);
            unset($data['customer_id']);
            $query = self::updateAgentRecordsById($return->id, $data);
            // echo $query;exit;
        }
        return $query;
    }
	public function updateAgentRecordsById($mapid, $data) {
        $query = $this->db->where('id', $mapid)->update('nw_agent_ticket_map_tbl', $data);
        return $query;
    }
	
    public function getAgentMappedTicket($ticketid) {
		$this->db->cache_on();
        $this->db->where('ticket_id', $ticketid);
        $query = $this->db->get('nw_agent_ticket_map_tbl')->row();
        return $query;
    }
	
}

