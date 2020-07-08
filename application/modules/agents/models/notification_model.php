<?php
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
	private function getData($sqlQuery) {
		$this->db->cache_on();
		$data = $this->db->query($sqlQuery)->result();
		return $data;
	}
	public function listNotification(){
		$this->db->cache_on();
		$sqlQuery = 'SELECT * FROM '.$this->notifTable;
		return $this->getData($sqlQuery);
	}
	public function listNotificationUser($user){
		$this->db->cache_on();
		$sqlQuery = "SELECT * FROM ".$this->notifTable." WHERE username='$user' AND notif_loop > 0 AND notif_time <= CURRENT_TIMESTAMP()"; return $this->getData($sqlQuery);
	}
	public function listUsers(){
		$this->db->cache_on();
		$sqlQuery = "SELECT * FROM ".$this->userTable." WHERE username != 'admin'";
		return $this->getData($sqlQuery);
	}
	public function loginUsers($username, $password){
		$this->db->cache_on();
		$sqlQuery = "SELECT id as userid, username, password FROM ".$this->userTable." WHERE username='$username' AND password='$password'";
		return $this->getData($sqlQuery);
	}
	public function saveNotification($msg, $time, $loop, $loop_every, $user){
		$sqlQuery = "INSERT INTO ".$this->notifTable."(notif_msg, notif_time, notif_repeat, notif_loop, username) VALUES('$msg', '$time', '$loop', '$loop_every', '$user')";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
		return ('Error in query: '. mysqli_error());
		} else {
		return $result;
		}
	}
	public function updateNotification($id, $nextTime) {
		$sqlUpdate = "UPDATE ".$this->notifTable." SET notif_time = '$nextTime', publish_date=CURRENT_TIMESTAMP(), notif_loop = notif_loop-1 WHERE id='$id')";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}
}