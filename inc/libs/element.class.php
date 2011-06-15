<?php
class element{

	public $db;
	

	public function __construct($db) {
		$this->db=$db;
	}
	
	public function checkCombination($data){
		$result=false;
		$select=$this->db->select('combinations', 'starting_element1='.$data['element1'].' AND starting_element2='.$data['element2']);
		if(is_array($select)){
			return $this->getInfo($select['0']['ending_element']);
		}else{
			$result=false;
		}
	}
	
	public function getInfo($elementId){
		$select=$this->db->select('elements', "id=$elementId");
		return $select['0'];
	}

	public function giveToUser($id,$fbId){
		$savedElements=$this->db->select('users', "facebook_id=$fbId");
		$explodedElements=explode(',', $savedElements['0']['saved_elements']);
		
		if (!in_array($id, $explodedElements)) {
		    array_push($explodedElements, $id);
		    $implodedElements = implode(",", $explodedElements);
		    return $this->db->update('users',array('saved_elements'=>$implodedElements), "facebook_id=$fbId");
		}
		
	}
}