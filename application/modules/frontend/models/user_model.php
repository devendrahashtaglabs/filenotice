<?php 
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
		if ( ! defined( 'USERTABLE')) {
			define('USERTABLE', 'nw_user_tbl');
		}
    }
	public function _getUserByKeyValue($key, $value,$user_type){
		$this->db->cache_on();
        $this->db->select('*');
        $query = $this->db->where($key,$value);
        if(!empty($user_type)){
            $query = $this->db->where_in('user_type',$user_type);
        }
        $query = $this->db->get(USERTABLE);
        return $query ->row();
    }
    
	public function getActivationdetail($key, $value){
		$this->db->cache_on();
        $this->db->select('*');
        $query = $this->db->where($key,$value);
        $query = $this->db->where('reset_status','1');
        $query = $this->db->get(USERTABLE);
        return $query ->row();
    }
	
    public function getUserLogin($data) {
		$this->db->cache_on();
        $query = $this->db->get_Where('nw_user_tbl', $data)->row();
        return $query;
    }
    
    public function getDataBykey($tableName, $key, $value, $columns = "*") {
		$this->db->cache_on();
        $this->db->select($columns)->from($tableName)->where($key, $value);
        $query = $this->db->get()->row();
        return $query;
    }

    public function updateRecordsById($column, $value, $data) {
        $query = $this->db->where($column, $value)->update('nw_user_tbl', $data);
        return $query;
    }
	public function updatetableRecordsByColumn($table,$column, $value, $data) {
        $query = $this->db->where($column, $value)->update($table, $data);
        return $query;
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
	public function getCountryList($countryid='') {
		$this->db->cache_on();
        if(empty($countryid)){
            $query = $this->db->order_by('name','ASC')->get_Where('nw_countrys_tbl', array('status'=>'1'))->result();
        }else{
            $query = $this->db->get_Where('nw_countrys_tbl', array('id'=>$countryid))->row();
        }
        return $query;
    }
    
    public function getStateList($id=null,$countryId=null) {
		$this->db->cache_on();
        if(empty($countryId)){
            if($id==''){
                $query = $this->db->order_by('name','ASC')->get_Where('nw_states_tbl', array('status'=>'1'))->result();
            }else{
                $query = $this->db->get_Where('nw_states_tbl', array('id'=>$id))->row();
            }
        }else{
            $query = $this->db->order_by('name','ASC')->get_Where('nw_states_tbl',array('status'=>'1','country_id'=>$countryId))->result();
        }
        return $query;
    }
	public function createNewUsers($tableName, $data) {
        $this->db->insert($tableName, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
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
}