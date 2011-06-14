<?php
require 'libs/facebook/facebook.php';
require 'libs/db.class.php';
require 'libs/user.class.php';
require 'libs/element.class.php';

//template
require 'libs/Mustache.php';

#DB conf
define('DB_HOST','localhost');
define('DB_NAME','elements');
define('DB_USER','wiesebro_element');
define('DB_PASS','element');

#FB conf
if(PROD){
	define('FB_CANVAS_URL','http://apps.facebook.com/origins_dev/');
	define('FB_APP_ID','163144683725338');
	define('FB_SECRET','cc748c6e3ffcffdb7adcdede67247aea');	
}else{
	define('FB_CANVAS_URL','http://apps.facebook.com/origins_dev/');
	define('FB_APP_ID','163144683725338');
	define('FB_SECRET','cc748c6e3ffcffdb7adcdede67247aea');
}

