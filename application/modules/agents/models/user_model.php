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
	
	public function getUserList($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="DESC",$statue=null) {
        $data['count'] = 0;
        $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName',FALSE);
             // $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName,nw_ticket_map_tbl.status as ticket_status',FALSE);
             // count(nw_ticket_map_tbl.status) AS ticket_status
        $this->db->where('user_type', $userType);
        if(!empty($statue)){
            $this->db->where('users.status', $statue,false);
        }
        $this->db->from(USERTABLE.' AS users');
        if($userType==2){
            $this->db->join('nw_customer_tbl as details', 'users.id=details.user_id', 'left');
        }elseif($userType == 3){
            $this->db->join('nw_consultant_tbl as details', 'users.id=details.user_id', 'left');
        }else{
            $this->db->join('nw_agent_tbl as details', 'users.id=details.user_id', 'left');
		}
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');

        
        if($orderBy!=''){
            $this->db->order_by($orderBy, $type);
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
	public function getUserDataById($id, $userType) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.id as user_tbl_id,nw_user_tbl.*,details.*,nw_countrys_tbl.name as countryName, '
                . 'nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        if($userType=='customer'){
            $this->db->join('nw_customer_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }elseif($userType=='consultant'){
            $this->db->join('nw_consultant_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }else{
            $this->db->join('nw_agent_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
		}
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getUserDetails($id,$userType) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as email,nw_user_tbl.status as userstatus,nw_user_tbl.user_type,details.*,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        if($userType == 2){
            $this->db->join('nw_customer_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }elseif($userType == 3){
            $this->db->join('nw_consultant_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }else{
            $this->db->join('nw_agent_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');			
		}
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');
        $query = $this->db->get();
        return $query->row();
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
    
    public function updateUsersDetails($data,$tableName) {
        $userid = $data['user_id'];
        $isEmpty = $this->db->get_where($tableName, array('user_id'=>$userid))->row();
        if(!empty($isEmpty)){
            unset($data['user_id']);
            $query = $this->db->where('user_id', $userid)->update($tableName, $data);
        }else{
            $query = self::createNewUsers($tableName,$data);
        }
        return $query;
    }
    
    public function createNewUsers($tableName, $data) {
        $this->db->insert($tableName, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    public function updateUser($data) {
        $id = $data['user_id'];
        $this->db->where('id', $id);
        unset($data['user_id']);
        $query = $this->db->update('nw_user_tbl', $data);
        return $query;
    }
    public function updateAgentUser($data) {
        $id = $data['user_id'];
        $this->db->where('user_id', $id);
        $query = $this->db->update('nw_agent_tbl', $data);
        return $query;
    }
	
	/* public function update_wordpress_user($data, $email) {
        $this->db->where('user_email', $email);
        $this->db->update('wp_users', $data);
    } */
	
    public function validateEmail($email, $id) {
        $query = $this->db->get_where('nw_user_tbl', array('email'=>$email,'id !='=>$id));
        return $query->row();
    }
    
   /*  public function update_wordpress_password($data, $email) {
        $this->db->where('user_email', $email);
        $this->db->update('wp_users', $data);
    } */
	public function updateConsultantById($column, $value, $data) {
        $query = $this->db->where($column, $value)->update('nw_consultant_tbl', $data);
        return $query;
    }
	public function updateAgentById($column, $value, $data, $table) {
        $query = $this->db->where($column, $value)->update($table, $data);
        return $query;
    }
	public function getallqualification() {
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('nw_master_qualification_tbl');
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result();
	}
	public function getallsubqualification() {
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('nw_master_subqualification_tbl');
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result();
	}
	public function getsubqualificationbyqualid($qualid) {
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('nw_master_subqualification_tbl');
		$this->db->where('qualification_id', $qualid);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->result();
	}
	public function getconsultantdetail($consultantid) {
		$this->db->cache_on();
		$this->db->select('*');
		$this->db->from('nw_consultant_tbl');
		$this->db->where('user_id', $consultantid);
		$this->db->where('status', '1');
		$query = $this->db->get();
		return $query->row();
	}
	public function getconsultantavgrating($consultantid) {
		$this->db->cache_on();
		$this->db->select_avg('rating');
		$this->db->from('nw_rating_tbl');
		$this->db->where('consultant_id', $consultantid);
		$query = $this->db->get();
		return $query->row();
	}
	/* public function checkwpusersexist($email){
		$this->db->select('user_email');
        $this->db->where('user_email',$email);
        $this->db->from('wp_users');
        $query = $this->db->get();
        return $query->row();
	}
    public function create_wordpress_user($data) {
        $this->db->insert('wp_users', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
    }
	public function create_wp_user_meta($data) {
        $this->db->insert('wp_usermeta', $data);
		$insertId = $this->db->insert_id();
		return $insertId;
    } */
	public function getExpertiseById($id){
		$this->db->cache_on();
		$this->db->where('nw_experties_tbl.status', 1);
		$this->db->where('nw_experties_tbl.id', $id);
		$query = $this->db->get('nw_experties_tbl');
		return $query->row();
    }
	public function getconsultantbycategory($id,$category) 
	{
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_agent_tbl');
        $this->db->where('user_id', $id);
        $this->db->where('category_id', $category);
		$query 		= $this->db->get();
        $results 	= $query->row();
        return $results;
    }
	public function getconsultantbyagent($agentid) 
	{
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_agent_tbl');
        $this->db->where('user_id', $agentid);
		$query 		= $this->db->get();
        $results 	= $query->row();
        return $results;
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
