<?php 
session_start();
//$_SESSION=array();$_SESSION['loggedin'] = ''; var_dump($_SESSION); exit(); //debug stuff!
require_once 'src/header.php';

mysql_connect($DB_HOST,$DB_USER,$DB_PASS);
@mysql_select_db($DB_NAME) or die( "Unable to select database");

if($_POST):
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 10 Oct 1981 10:10:10 GMT');
	header('Content-type: application/json');
	
	$output =array();
	if(isset($_SESSION['loggedin']) && !isset($_POST['action'])) :
		$output = array('status'=>'studentID');
		
	elseif (isset($_SESSION['loggedin']) && isset($_POST['action']) == 'logout'):
	
	$insert = sprintf("INSERT INTO `alco`.`user_events` (`id` ,`user_id` ,`milestone` ,`date_created` ,`date_mod`)VALUES (NULL , '%s', '%s', '%s', '%s');", $_SESSION['loggedin'],'logout',$datetime,'0000-00-00 00:00:00');
	   
	   mysql_query($insert);
		$_SESSION = array();
		$output = array('status'=>'loggedout');
		
		
	elseif (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['action']) == 'login'):
	   
	   $name = mysql_real_escape_string($_POST['username']); 
	   $pass = mysql_real_escape_string($_POST['password']); 
	   
	   $mysql = mysql_query("SELECT * FROM user WHERE user_name = '{$name}' AND user_password = '{$pass}' LIMIT 1");
	   $logged_user = mysql_fetch_array($mysql);
	   
	   if($logged_user['id']):
	   
	   session_regenerate_id();
	   $_SESSION['loggedin'] = $logged_user['id'];
	   
	   $insert = sprintf("INSERT INTO `alco`.`user_events` (`id` ,`user_id` ,`milestone` ,`date_created` ,`date_mod`)VALUES (NULL , '%s', '%s', '%s', '%s');", $logged_user['id'],'login',$datetime,'0000-00-00 00:00:00');
	   
	   mysql_query($insert);
		
	   
	   $output = array('status'=>'studentID');
	   
	   else:
	   $_SESSION = array();
	   $output = array('status'=>'loggederror');
	   
	   endif; 
	else:
		$_SESSION = array();
	   $output = array('status'=>'loggederror2');
	   
	endif;
		
	echo json_encode($output);
	
else:
header('Location: index.php');
endif;