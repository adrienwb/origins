<?php
session_start();
require 'prod.php';
require 'conf.php';

if(!PROD){
	ini_set('display_errors',1);
}

#Create DB connection
$db=new db('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);

#Create Template
$m = new Mustache;

#Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => FB_APP_ID,
  'secret' => FB_SECRET,
  'cookie' => true,
));