<?php

require_once 'src/objects.php';
require_once 'src/config.php';
require_once 'src/common_config.php';
require_once 'src/functions.php';

function setSchool($id){
	
	global $DEFAULT_SCHOOL;
	
	// spcial case for admin page only
	if($id == -1)
		return null;
	
	$school = getSchoolById($id);
	// if for whatever reason the school was not set, default
	if(!$school){
		$school = getSchoolById($DEFAULT_SCHOOL);
	}
	
	$_SESSION['school'] = serialize($school);
	
	return $school;
}
// Error connecting here. my_sql extention removed in php 7
mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
@mysql_select_db($DB_NAME) or die( "Unable to select database");

date_default_timezone_set("Australia/Brisbane");
$datetime = date('Y-m-d H:i:s', time()); 

// the school and the user are the 2 main things a session needs to remeber
$school = null;
$user = null;

// if user obj is supplied use its last 2 digits
if(isset($_REQUEST['user'])){
	$school = setSchool(substr($_REQUEST['user'],-2));
}
// else if school is supplied
else if(isset($_REQUEST['school_id'])){
	$school = setSchool($_REQUEST['school_id']);
}
// else if school is set in session
else if(isset($_SESSION['school'])){
	$school = unserialize($_SESSION['school']);
}
// otherwise just use default
else{
	$school = setSchool($DEFAULT_SCHOOL);
}

// make or lookup a user if one is supplied in a param
if(isset($_REQUEST['user'])):
$u = findOrMakeUser($_REQUEST['user']);
if($u)
	$_SESSION['user'] = serialize($u);
endif;

// load the user from the session if one exists
if(isset($_SESSION['user'])){
	$user = unserialize($_SESSION['user']);
}






