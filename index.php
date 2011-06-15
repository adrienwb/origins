<?php

require 'inc/global.php';

$uid = $facebook->getUser();

$me = null;

$user = new user($db,$facebook);
$savedElements='';

// Session based API call.
if ($uid) {
  try {
    $me = $facebook->api('/me');

    if(!$userInfo=$user->exists()) {
    	$user->create();
    }else{
		$savedElements=$userInfo[0]['saved_elements'];
	}
    
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}else{
//	$loginUrl = $facebook->getLoginUrl(array('scope'=>'email,user_birthday,publish_stream'));
//	echo("<script> top.location.href='$loginUrl'</script>");
//	exit;
}


$firstElements = $db->select('elements',"id IN ($savedElements)");
define('LI_ELEMENT','<li element="%1$s"><a onclick="selectElement(this); return false;" title="%2$s" href="#">
				<span style="background-image: url(&quot;img/elements/%1$s.png&quot;);" class="square"><span></span></span><strong>%2$s</strong></a>
			</li>');


$gallery='';

foreach($firstElements as $element){
	$gallery.=sprintf(LI_ELEMENT,$element['id'],$element['name']);
}

$tpl=file_get_contents('./tpl/index.html',FILE_USE_INCLUDE_PATH);
$tplReplace=array(
	'fbAppId'=>$facebook->getAppId(),
	'gallery'=>$gallery,
);
echo $m->render($tpl, $tplReplace);

