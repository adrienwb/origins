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

}