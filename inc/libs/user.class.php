<?php
class user{

	public $db;
	public $facebook;
	

	public function __construct($db, $facebook) {
		$this->db=$db;
		$this->facebook=$facebook;
	}
	
	public function exists(){
		$currentUser=$this->facebook->api('/me');
		$select=$this->db->select('users', 'facebook_id='.$currentUser['id']);
		if($select) return $select;
		else return false;	
	}
	
	public function add(){
		$currentUser=$this->facebook->api('/me');
		$currentUser['facebook_id']=$currentUser['id'];
		$currentUser['saved_elements']='1,2,3,4';
		unset($currentUser['id']);
		$this->db->insert('users',$currentUser);
	}

}