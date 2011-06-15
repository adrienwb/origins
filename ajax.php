<?php
require 'inc/global.php';

$action=isset($_POST['action'])?$_POST['action']:'';
$source=isset($_POST['source'])?$_POST['source']:'';
$target=isset($_POST['target'])?$_POST['target']:'';

$uid = $facebook->getUser();


switch($action){
    case 'combine': 
    	$element = new element($db);
    	$data['element1']=min($source,$target);
    	$data['element2']=max($source,$target);
		$isMatch=$element->checkCombination($data);
		if($isMatch) {
			if($element->giveToUser($isMatch['id'],$uid))$result=json_encode($isMatch);
			else $result='';
		}
		else $result='';        
        break;
    default:
       $result= "";


}
echo $result;