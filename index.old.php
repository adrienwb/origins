<?php
require 'inc/conf.php';


$session = $facebook->getSession();
$me = null;

$user = new user($db,$facebook);
$savedElements='';
if(!$userInfo=$user->exists()) $user->add();
else{
	$savedElements=$userInfo[0]['saved_elements'];	
}

// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}
// login or logout url will be needed depending on current user state.
if ($me) {
  $logoutUrl = $facebook->getLogoutUrl();
} else {
  $loginUrl = $facebook->getLoginUrl();
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
	'fbSession'=>json_encode($session),
	'gallery'=>$gallery,
	'loginButton'=>(!$me)?'<fb:login-button></fb:login-button>':''
);
echo $m->render($tpl, $tplReplace);

