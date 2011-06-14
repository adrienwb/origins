<?php
require 'inc/global.php';

$action=isset($_POST['action'])?$_POST['action']:'';
$source=isset($_POST['source'])?$_POST['source']:'';
$target=isset($_POST['target'])?$_POST['target']:'';




switch($action){
    case 'combine': 
    	$element = new element($db);
    	$data['element1']=min($source,$target);
    	$data['element2']=max($source,$target);
		$isMatch=$element->checkCombination($data);
		if($isMatch) $result=json_encode($isMatch);
		else $result='';        
        break;
    default:
       $result= "";


}
echo $result;