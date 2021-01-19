<?php
class User {
	public $id;
	public $userId;
	public $name;
	public $school;
}

class School {
	public $id;
	public $code;
	public $name;
}

function getUserByUsername($uid){
	$DB_game = mysql_query(sprintf("SELECT * FROM user WHERE user_name = '%s' LIMIT 1 ", mysql_real_escape_string($uid)));
	$row_game = mysql_fetch_array($DB_game);
	mysql_free_result($DB_game);
	return loadUser($row_game);
}
function getUserById($uid){
	// Added mysql_real_escape_string to $uid
	$DB_game = mysql_query(sprintf("SELECT * FROM user WHERE id = %s LIMIT 1 ", mysql_real_escape_string($uid)));
	$row_game = mysql_fetch_array($DB_game);
	mysql_free_result($DB_game);
	return loadUser($row_game);
}
function getSchoolByKeyId($uid){
	$q = sprintf("SELECT * FROM school WHERE id = %s LIMIT 1 ", mysql_real_escape_string($uid));
	
	$DB_game = mysql_query($q);
	$row_game = mysql_fetch_array($DB_game);
	mysql_free_result($DB_game);
	return loadSchool($row_game);
}
function getSchoolById($uid){
	#$q = sprintf("SELECT * FROM school WHERE school_code = '%s' LIMIT 1 ", mysql_real_escape_string($uid));
	// Added mysql_real_escape_string to $uid
	$q = sprintf("SELECT * FROM school WHERE id = '%s' LIMIT 1 ", mysql_real_escape_string($uid));
	
	$DB_game = mysql_query($q);
	$row_game = mysql_fetch_array($DB_game);
	mysql_free_result($DB_game);
	return loadSchool($row_game);
}
function delSchool($s){
	
	$q = sprintf("DELETE FROM user WHERE school_id = %s LIMIT 1 ", $s->id);
	mysql_query($q);
	
	$q = sprintf("DELETE FROM school WHERE id = %s LIMIT 1 ", $s->id);
	mysql_query($q);
	
}
function saveSchool($s){
	global $datetime;
	if($s->id){
		$insert = sprintf(
				"UPDATE school SET name='%s', date_mod='%s', school_code='%s' WHERE id = %s"
				, $s->name,$datetime,$s->code,$s->id);
		mysql_query($insert);
	}
	else{
		$insert = sprintf(
				"INSERT INTO school (id, name, school_code, date_created, date_mod) VALUES (NULL,'%s','%s','%s','%s' )"
				, $s->name,$s->code,$datetime,$datetime);
		mysql_query($insert);
		$s->id = mysql_insert_id();
	}
	return $s;
}
function saveUser($s){
	global $datetime;
	if($s->id){
		$insert = sprintf(
				"UPDATE user SET user_name='%s', display_name= '%s', school_id=%s, date_mod='%s' WHERE id = %s"
				, $s->userId,$s->name,$s->school->id, $datetime,$s->id);
		
		mysql_query($insert);
	}
	else{
		$insert = sprintf(
				"INSERT INTO user (id,user_name, display_name, school_id, date_created, date_mod) VALUES (NULL,'%s','%s',%s,'%s','%s' )"
				, $s->userId,$s->name,$s->school->id, $datetime,$datetime);
		mysql_query($insert);
		$s->id = mysql_insert_id();
	}
	return $s;
}

function loadUser($row){
	if($row['id']){
		$u = new User();
		$u->id = $row['id'];
		$u->userId = $row['user_name'];
		$u->name = $row['display_name'];
		$u->school = getSchoolByKeyId($row['school_id']);
		return $u;
	}
	return null;
}

function loadSchool($row){
	if($row['id']){
		$u = new School();
		$u->id = $row['id'];
		$u->code = $row['school_code'];
		$u->name = $row['name'];
		return $u;
	}
	return null;
}
