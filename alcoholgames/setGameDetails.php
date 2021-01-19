<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 10 Oct 1981 10:10:10 GMT');
header('Content-type: application/json');

session_start();
require_once 'src/header.php';
$status = 0;
$msg = "OK";
$res = null;

// site only works if theres a school
if(!$school){
	$status=404;
	$msg = "no School";
}
// needs an action
else if(!isset($_REQUEST['action'])){
	$status=400;
	$msg = "no action";
	
}
else{

	$action = $_REQUEST['action'];
	
	if(isset($_REQUEST['gameid'])){
		$DB_game = mysql_query(sprintf("SELECT * FROM game WHERE name = '%s' LIMIT 1 ", mysql_real_escape_string($_REQUEST['gameid'])));
		$row_game = mysql_fetch_array($DB_game);
		$game_id  = $row_game['id'];
		mysql_free_result($DB_game);
	}
	
	
	// called by flash to indicate the users finished playing. Log the event, and send flash back details
	// flash can then get user in high scores if it wants to
	if ($action == 'endgame'):

		$score = $_POST['score'];
		$bestScore = inTop10($game_id);
		$top10 = getHighScores($game_id);
		
		$lowestTop10Score = -1;
		
		foreach($top10 as $t){
			if($t['score'] < $lowestTop10Score || $lowestTop10Score == -1){
				$lowestTop10Score = $t['score'];
			}
		}
		
		$res = array("eligableForLeaderboard" => ($score > 0 && 
				(($bestScore && $score > $bestScore && $score > $lowestTop10Score) 
						|| 
				(!$bestScore && ($score > $lowestTop10Score || sizeof($top10) < 9)))), "bestScore" => $bestScore, "lowsetTopTenScore" => $lowestTop10Score);
		
		$extra = null;
		if(isset($_REQUEST['extra'])){
			$extra = json_decode($_REQUEST['extra'],true);
			
			if(isset($extra['gameDuration'])){
				// Log the duration
				logEvent('flash_dur', $extra, $extra['gameDuration']);
			}
		}
		// Log the event
		logEvent('gameFinished', $extra, $_POST['score']);
	
	// Called by flash when the user has chosent to submit highscores
	elseif ($action == 'sendscore'):
	
		insertGameInfo($game_id,'finished',$_POST['score']);
		$user->name = $_POST['name'];
		saveUser($user);
	
	elseif ($action == 'gameuser'):
	
		logEvent($_POST['verb']);
	
			
	elseif ($action == 'log' && isset($_REQUEST['event'])):
		logEvent($_REQUEST['event'], isset($_REQUEST['extra'])?json_decode($_REQUEST['extra']):null, isset($_REQUEST['num'])?$_REQUEST['num']:-1);
		$msg ="Event Logged";
	else:
		$status=401;
		$msg = "Bad Action";
	endif;
}
if($res)
	echo json_encode(array('status'=>$status,"msg" => $msg, "res" => $res));
else
	echo json_encode(array('status'=>$status,"msg" => $msg));

mysql_close();

