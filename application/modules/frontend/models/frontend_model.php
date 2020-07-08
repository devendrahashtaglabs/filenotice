<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class frontend_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
		/* if ( !defined( 'TICKETTABLE')) {
			define('TICKETTABLE','nw_ticket_tbl');
		} */
    }
    public function getSettingDataByKey($key){
        $this->db->select('key_value');
        $query = $this->db->where('name_key',$key)->get('nw_setting_tbl');
        $responce = $query->row();
        return $responce;
    }
	public function getsubcategory($catid) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('parent_id'=>$catid));
        $query = $this->db->get('nw_category_tbl')->result();
        return $query;
    }
	public function get_category_data($id) {
		$this->db->cache_on();
        $this->db->select('*');
        $this->db->where(array('id'=>$id));
        $query = $this->db->get('nw_category_tbl')->row();
        return $query;
    }
	public function createTicket($table=null,$data) {
		$this->db->insert('nw_ticket_tbl', $data);			
		$insert_id = $this->db->insert_id();
        return $insert_id;
    }
	public function insertdata($table,$data) {
		$this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
        return $insert_id;
    }
	 public function getUserDetailsById($id, $userType) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.*,details.*,nw_countrys_tbl.name as countryName, '
                . 'nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        if($userType==2){
            $this->db->join('nw_customer_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }elseif($userType==3){
            $this->db->join('nw_consultant_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }else{
            $this->db->join('nw_agent_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
		}
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');
        $query = $this->db->get();
        return $query->row();
    }
	public function getDataBykey($tableName, $key, $value, $columns = "*") {
		$this->db->cache_on();
        $this->db->select($columns)->from($tableName)->where($key, $value);
        $query = $this->db->get()->row();
        return $query;
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
	public function updateanytable($column, $value, $data, $table) {
        $query = $this->db->where($column, $value)->update($table, $data);
        return $query;
    }
	public function getDataByTable($tableName, $columns = "*") {
		$this->db->cache_on();
        $this->db->select($columns)->from($tableName);
        $query = $this->db->get()->result();
        return $query;
	}
	public function getlastrowoftable($tablename){
		$this->db->select("*");
		$this->db->from($tablename);
		$this->db->limit(1);
		$this->db->order_by('id',"DESC");
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}
}

