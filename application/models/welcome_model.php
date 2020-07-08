<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function index() {
        
    }
	
	public function getcurrentcity($cityname) {
		$this->db->select('*');
		$this->db->from('nw_cities_tbl');
		$this->db->where('city_name',$cityname);
		$citydata = $this->db->get()->row(); 
		return $citydata;
    }
	public function getcurrentcitybyid($cityid) {
		$this->db->select('*');
		$this->db->from('nw_cities_tbl');
		$this->db->where('city_id',$cityid);
		$citydata = $this->db->get()->row(); 
		return $citydata;
    }
	public function getCityList($id=null,$stateId=null) {
		$this->db->cache_on();
        if(empty($stateId)){
            if($id==''){
                $query = $this->db->order_by('city_name','ASC')->get_Where('nw_cities_tbl', array('status'=>'1'))->result();
            }else{
                $query = $this->db->get_Where('nw_cities_tbl', array('city_id'=>$id))->row();
            }
        }else{
            $query = $this->db->order_by('city_name','ASC')->get_Where('nw_cities_tbl',array('status'=>'1','city_state'=>$stateId))->result();
        }
        return $query;
    }
	public function getParentCategory(){
        $this->db->where('parent_id',0);
		$this->db->where('status','1');
        $query = $this->db->order_by('name','asc')->get('nw_category_tbl');
        return $query->result();
    }
	public function getcategorybycity($cityid){
         $this->db->where("FIND_IN_SET('$cityid',mapped_city) !=", 0);
		$this->db->where('status','1');
        $query = $this->db->get('nw_category_tbl');
        return $query->result();
    }
	public function parentCategoryName($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->from('nw_category_tbl')->get()->row();
        return $query;
    }
	public function getsubcategorybyparentid($parentid){
        $this->db->select('*');
        $this->db->where('parent_id',$parentid);
		$this->db->from('nw_category_tbl');
		$this->db->order_by('amount','asc');
        $query = $this->db->get()->result();
        return $query;
    }
	public function getSettingDataByKey($key){
        $this->db->select('key_value');
        $query = $this->db->where('name_key',$key)->get('nw_setting_tbl');
        $responce = $query->row();
        return $responce;
    }
	public function getDataByKey($table,$key=null,$value=null,$status=null){
        $this->db->select('*');
		if(!empty($key)){
			$this->db->where($key,$value);
		}
		$this->db->from($table);
		if(!empty($status)){
			$this->db->where('status',$status);
		}else{
			$this->db->where('status','1');
		}
        $query = $this->db->get()->result();
        return $query;
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
        $data	= $query->result();
        return $data;
    }
	public function getCountOfUser($userType = "", $status = "", $responcetype = "") {
		$this->db->cache_on();
        if (empty($responcetype)) {
            $this->db->select('count(*) AS total');
        }
        if (!empty($status)) {
            $query = $this->db->where('status', $status);
        }
        if (!empty($userType)) {
            $query = $this->db->where('user_type', $userType);
        } else {
            $query = $this->db->where('login_status', '1')->where('id<>', '1', FALSE);
        }
        $result = $this->db->get('nw_user_tbl')->row_array();
        if (empty($responcetype)) {
            if (empty($result)) {
                return $result = 0;
            } else {
                return $result['total'];
            }
        } else {
            return $result;
        }
    }
}
