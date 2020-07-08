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
        $query = $this->db->where('user_type',1);
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

    public function updateRecordsById($column, $value, $data) {
        $query = $this->db->where($column, $value)->update('nw_user_tbl', $data);
        return $query;
    }

    public function createNewUsers($tableName, $data) {
        $this->db->insert($tableName, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    public function updateConsultantById($column, $value, $data) {
        $query = $this->db->where($column, $value)->update('nw_consultant_tbl', $data);
        return $query;
    }

    public function getDataBykey($tableName, $key, $value, $columns = "*") {
		$this->db->cache_on();
        $this->db->select($columns)->from($tableName)->where($key, $value);
        $query = $this->db->get()->row();
        return $query;
    }

    public function getCustomerList() {
		$this->db->cache_on();
        $query = $this->db->get('nw_customer_tbl');
        return $query->result();
    }

    public function deleteCustomer($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('nw_customer_tbl');
        return $query;
    }

    public function getCustomer($id) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as email,nw_user_tbl.status as userstatus,nw_user_tbl.email_status as emailstatus,nw_customer_tbl.*,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        $this->db->join('nw_customer_tbl', 'nw_customer_tbl.user_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_countrys_tbl', 'nw_customer_tbl.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'nw_customer_tbl.state_id=nw_states_tbl.id', 'left');
        $query = $this->db->get();
        return $query->row();
    }

    public function updateCustomer($data) {
        $id = $data['id'];
        $this->db->where('user_id', $id);
        unset($data['id']);
        $query = $this->db->update('nw_customer_tbl', $data);
        return $query;
    }
    
    /* public function deleteUsers($id, $tablename) {
        $this->db->where('id', $id);
        $query = $this->db->delete(USERTABLE);
        $this->db->where('user_id', $id);
        $query = $this->db->delete($tablename);
        return $query;
    } */
	public function deleteUsers($id, $tablename) {
        //$query = $this->db->delete(USERTABLE);
		$data = array(
			'status' => '3',
		);
        $this->db->where('id', $id);
		$query = $this->db->update(USERTABLE, $data);
        $this->db->where('user_id', $id);
        $query = $this->db->update($tablename, $data);;
        return $query;
    } 
    
    public function updateUser($data) {
        $id = $data['user_id'];
        $this->db->where('id', $id);
        unset($data['user_id']);
        $query = $this->db->update('nw_user_tbl', $data);
        // print_r($this->db->last_query());    
        // exit;
        return $query;
    }

    public function validateEmail($email, $id) {
        $query = $this->db->get_where('nw_user_tbl', array('email'=>$email,'id !='=>$id));
        return $query->row();
    }

    public function deleteConsultant($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('nw_consultant_tbl');
        return $query;
    }

    public function getConsultantById($id) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as email,'
        . 'nw_user_tbl.status as userstatus,nw_category_tbl.name as category_name,nw_consultant_tbl.*,'
        . 'nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName'
//. '(SELECT GROUP_CONCAT(DISTINCT nw_experties_tbl.name,"" ORDER BY nw_experties_tbl.name ASC) as expertiesList FROM `nw_experties_tbl` WHERE `id` IN (ASP)) As expertiesList,
        . '', false);
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        $this->db->join('nw_consultant_tbl', 'nw_consultant_tbl.user_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_category_tbl', 'nw_consultant_tbl.category_id=nw_category_tbl.id', 'left');
        $this->db->join('nw_countrys_tbl', 'nw_consultant_tbl.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'nw_consultant_tbl.state_id=nw_states_tbl.id', 'left');
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getExpertiseById($id){
		$this->db->cache_on();
		$this->db->where('nw_experties_tbl.status', 1);
		$this->db->where('nw_experties_tbl.id', $id);
		$query = $this->db->get('nw_experties_tbl');
		return $query->row();
    }


    public function getCourseids($id) {
		$this->db->cache_on();
        $this->db->select('nw_consultant_tbl.expertise AS ASP', false);
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_consultant_tbl');
        $this->db->join('', 'nw_consultant_tbl.user_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_experties_tbl', 'nw_consultant_tbl.expertise=nw_experties_tbl.id','INNER');
        $query = $this->db->get();
        return $query->row();
    }

    public function getConsultant() {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as consultant_email,nw_consultant_tbl.*');
        $this->db->from('nw_consultant_tbl');
        $query = $this->db->join('nw_user_tbl', 'nw_consultant_tbl.user_id=nw_user_tbl.id', 'left')->get();
        return $query->result();
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
        $result = $this->db->get(USERTABLE)->row_array();
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

    //for consuktant del property
     public function getCountOfticketstatus($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="ASC",$statue=null) {
      // $sql = "SELECT consultant_id,status,count(status) as c_status FROM `nw_ticket_map_tbl` group by consultant_id where status = 1";
      // $sql= "SELECT consultant_id,status,count(*) as c_status FROM `nw_ticket_map_tbl`  where status = 1";
         $this->db->select('consultant_id, COUNT(*) as c_status');
         $this->db->where('status', 1);
          $query =  $this->db->get('nw_ticket_map_tbl');
          return $query->result();
        //  print_r($sql);    
        // exit;
    }
    //for customer del property
     public function getCountOfticketstatusnew($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="ASC",$statue=null) {
         $this->db->select('customer_id, COUNT(*) as cus_status');
         $this->db->where('status', 1);
          $query =  $this->db->get('nw_ticket_map_tbl');
           return $query->result();
          // print_r($this->db->last_query());
    }

    public function getUserList($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="DESC",$statue=null) {
        $data['count'] = 0;
        $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName,nw_cities_tbl.city_name as cityName',FALSE);
             // $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName,nw_ticket_map_tbl.status as ticket_status',FALSE);
             // count(nw_ticket_map_tbl.status) AS ticket_status
        $this->db->where('user_type', $userType);
        if(!empty($statue)){
            $this->db->where('users.status', $statue,false);
        }
        $this->db->from(USERTABLE.' AS users');
        if($userType==2){
            $this->db->join('nw_customer_tbl as details', 'users.id=details.user_id', 'left');
        }else{
            $this->db->join('nw_consultant_tbl as details', 'users.id=details.user_id', 'left');
        }
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');
        $this->db->join('nw_cities_tbl', 'details.city_id=nw_cities_tbl.city_id', 'left');

        
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
	public function getAllUserList($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="DESC",$statue=null) {
		$this->db->cache_on();
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
        }else{
            $this->db->join('nw_consultant_tbl as details', 'users.id=details.user_id', 'left');
        }
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');

        
        if($orderBy!=''){
            $this->db->order_by($orderBy, $type);
        }
        if($limit!=''){
            $this->db->limit($limit);
        }
		$this->db->group_by('users.id');
		
        $query  = $this->db->get();

        $data['data'] = $query->result();
        
        if(!empty($data['data'])){
            $data['count'] = count($data['data']);
        }
		//echo "<pre>";print_r($this->db->last_query());echo "</pre>";die(" on file ". __FILE__ ." on line ". __LINE__ );
        return $data;
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
    
    public function createState($data) {
        $query = $this->db->insert('nw_states_tbl', $data);
        return $query;
    }
    
    public function updateState($data){
        $id = $data['id'];
        $this->db->where('id', $id);
        $query = $this->db->update('nw_states_tbl',$data);
        return $query;
    }
    
    public function getStateStatus($id){
        $this->db->cache_on();
        $this->db->select('status');
        $this->db->where('id',$id);
        $query = $this->db->from('nw_states_tbl')->get()->row();
        return $query;
    }
    
    public function changeStateStatus($id,$data){
        
        $this->db->where('id',$id);
        $query = $this->db->update('nw_states_tbl',$data);
        $this->db->last_query();
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
    
    public function getfullStateList() {
		$this->db->cache_on();
        $query = $this->db->order_by('id','DESC')->get('nw_states_tbl')->result();
        return $query;
    }
    
    public function deleteState($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('nw_states_tbl');
        return $query;
    }
    
    public function getUserDetailsById($id, $userType) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as email,nw_user_tbl.status as userstatus,nw_user_tbl.user_type as user_type,details.*,nw_countrys_tbl.name as countryName, '
                . 'nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        if($userType == 2){
            $this->db->join('nw_customer_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
        }elseif($userType==1){
            $this->db->join('nw_admin_tbl As details', 'details.user_id=nw_user_tbl.id', 'left');
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
    
    public function updateAdmin($data) {
        $id = $data['id'];
        $this->db->where('user_id', $id);
        unset($data['id']);
        $query = $this->db->update('nw_admin_tbl', $data);
        return $query;
    }
    
    public function getAdmin($id) {
		$this->db->cache_on();
        $this->db->select('nw_user_tbl.email as email,nw_user_tbl.status as userstatus,nw_admin_tbl.*,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName');
        $this->db->where('nw_user_tbl.id',$id);
        $this->db->from('nw_user_tbl');
        $this->db->join('nw_admin_tbl', 'nw_admin_tbl.user_id=nw_user_tbl.id', 'left');
        $this->db->join('nw_countrys_tbl', 'nw_admin_tbl.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'nw_admin_tbl.state_id=nw_states_tbl.id', 'left');
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
    
    public function update_wordpress_user($data, $email) {
        $this->db->where('user_email', $email);
        $this->db->update('wp_users', $data);
    } */
    
    public function add_token($data)
    {
        $results = $this->db->insert('nw_token_tbl', $data);
        return $results;
    }
    
    public function get_token($token)
    {
        $result = $this->db->get_where('nw_token_tbl', array('token' => $token))->row();
        return $result;
    }
    
    public function update_token($token) {
        $data = array(
                'status' => 1
                );
        $this->db->where('token', $token);
        $results = $this->db->update('nw_token_tbl', $data);
        return $results;
    }
    
    public function update_admin_password($data, $email) {
       
        $this->db->where('email', $email);
        $results = $this->db->update('nw_user_tbl', $data);
        return $results;
    }
	public function getconsultantbycategory($id,$category,$subcategory,$city=null,$state=null){
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_consultant_tbl');
        $this->db->where('user_id', $id);
        $this->db->where("FIND_IN_SET('$category',category_id) <>", 0);
        $this->db->where("FIND_IN_SET('$subcategory',subcategory_id) <>", 0);
		if(!empty($city)){
			$this->db->where('city_id', $city);
		}
		if(!empty($state)){
			$this->db->where('state_id', $state);
		}
		$query = $this->db->get();
        $results = $query->row();
        return $results;
    }
    public function getallqualification($qualid = null) {
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_master_qualification_tbl');
		if(!empty($qualid)){
			$this->db->where('qualification_id',$qualid);
		}
        $this->db->where('status', '1');
        $query = $this->db->get();
		if(!empty($qualid)){
			return $query->row();
		}else{
			return $query->result();
		}
    }
    public function getallsubqualification($subqualid = null) {
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_master_subqualification_tbl');
		if(!empty($subqualid)){
			$this->db->where('subqualification_id',$subqualid);
		}
        $this->db->where('status', '1');
        $query = $this->db->get();
        if(!empty($subqualid)){
			return $query->row();
		}else{
			return $query->result();
		}
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
	public function getremarkbyconsultantid($consultantid) {
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_rating_tbl');
        $this->db->where('consultant_id', $consultantid);
        //$this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }
	public function create_wp_user_meta($data) {
        $this->db->insert('wp_usermeta', $data);
		$insertId = $this->db->insert_id();
		return $insertId;
    }
	public function getagentbyconsultantid($consultantid) {
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_agent_tbl');
        $this->db->where('consultant_id', $consultantid);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->result();
    }
	
	public function getUserListbycitystate($userType=null,$column=null,$start=null,$limit=null,$orderBy=null, $type="DESC",$statue=null,$city,$state) {
        $data['count'] = 0;
        $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName',FALSE);
             // $this->db->select('users.*,users.status AS usersStatus,users.id as usersId, details.*,IF(details.name<>"",details.name,"'.DEFAULT_VALUE.'") As name,details.id as detail_id,details.status AS userStaus,,nw_countrys_tbl.name as countryName, nw_states_tbl.name as stateName,nw_ticket_map_tbl.status as ticket_status',FALSE);
             // count(nw_ticket_map_tbl.status) AS ticket_status
        $this->db->where('users.user_type', $userType);
        if(!empty($statue)){
            $this->db->where('users.status', $statue,false);
        }
        $this->db->from(USERTABLE.' AS users');
        if($userType==2){
            $this->db->join('nw_customer_tbl as details', 'users.id=details.user_id', 'left');
        }else{
            $this->db->join('nw_consultant_tbl as details', 'users.id=details.user_id', 'left');
        }
        $this->db->join('nw_countrys_tbl', 'details.country_id=nw_countrys_tbl.id', 'left');
        $this->db->join('nw_states_tbl', 'details.state_id=nw_states_tbl.id', 'left');
		
		$this->db->where('details.state_id', $state);
		$this->db->like('details.city_id', $city, 'both'); 
        
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
	public function updaterecordbyuserid($table,$column, $value, $data) {
        $query = $this->db->where($column, $value)->update($table, $data);
        return $query;
    }
	public function getDataByTable($tableName, $columns = "*") {
		$this->db->cache_on();
        $this->db->select($columns)->from($tableName);
        $query = $this->db->get()->result();
        return $query;
	}

	public function getUserListbycitystateCategory($category,$subcategory,$city=null,$state=null){
        $this->db->cache_on();
		$this->db->select('*');
        $this->db->from('nw_consultant_tbl');
        $this->db->where("FIND_IN_SET('$category',category_id) <>", 0);
        $this->db->where("FIND_IN_SET('$subcategory',subcategory_id) <>", 0);
		if(!empty($city)){
			$this->db->where('city_id', $city);
		}
		if(!empty($state)){
			$this->db->where('state_id', $state);
		}
		$query = $this->db->get();
        $results = $query->result();
        return $results;
    }
}
