<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 10 Oct 1981 10:10:10 GMT');
header('Content-type: application/json');

session_start();
require_once 'src/header.php';

$status = 0;
$msg = "OK";
$res = null;

if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] && isset($_REQUEST['cmd'])):
	$cmd = $_REQUEST['cmd'];
	
	if ($cmd == 'Add'):
		
	$s = new School();
		$s->name = $_REQUEST['name'];
		$s->code = $_REQUEST['code'];
		saveSchool($s);
		header('Location: ./admin.php?mode=setup',true,302);
		
	elseif ($cmd == 'Update'):
		
		$school->name = $_REQUEST['name'];
		$school->code = $_REQUEST['code'];
		saveSchool($school);

		header('Location: ./admin.php?mode=setup',true,302);
		
	elseif($cmd == 'Delete'):
	
		delSchool($school);		
	
		header('Location: ./admin.php?mode=setup',true,302);

	elseif($cmd == 'dump'):
		$FILE_ALL = "/tmp/alco.csv";
		$sql = "SELECT s.name as School,g.title as GameName, u.user_name as UserId, u.display_name as StudentName, session_id, ".(isset($_REQUEST['milestone'])?'milestone as Event, ':'')."extra_data, number_metric1 as Score , e.date_created as EventDate  from user_events e ".
			" INNER JOIN user u ON (e.user_id = u.id) ".
			" INNER JOIN school s ON (s.id = u.school_id) ".
			" INNER JOIN game g ON (e.game_id = g.id) ".
			" WHERE game_id=".$_REQUEST['game_id'].($school?" AND u.school_id=".$school->id:"")." ".
			" AND e.milestone like '".(isset($_REQUEST['milestone'])?$_REQUEST['milestone']:'gameFinished')."'";
		
		$result = mysql_query($sql);
		// Try to open the file
		$handle = fopen($FILE_ALL, "w");
		if (!$handle) {
			$message  = 'Unable to open ' . $FILE_ALL . "\n";
			die($message);
		}
		
		$pos = 0;
		
		$extraCols = $EXPORT_COLS[$_REQUEST['game_id']];
		
		while ($res = mysql_fetch_assoc($result)) {
			// write column names
			if($pos == 0)
			{
				$d = new Datetime(null,$TZ);
				$headerS = 'Data Dump for '. $res['GameName'].($school?' '.$school->name:' All Schools. Run on '). $d->format("d-M-Y H:m");
				
				
				fwrite($handle, $headerS."\n\n");
				
				foreach($res as $cur => $val){
					
					if($cur == 'extra_data') continue;
					
					fwrite($handle, '"'.$cur.'",');
				}
				foreach($extraCols as $cur){
					fwrite($handle, '"'.$cur.'",');
				}
				fwrite($handle, "\n");
			}
			
			$json = @json_decode($res['extra_data'],true);
			
			unset($res['extra_data']);
			
			if($json){
				foreach($extraCols as $cur){
					$res[$cur] = isset($json[$cur])?json_encode($json[$cur]):'?';
				}
			}
			fputcsv($handle,$res);
			$pos ++;
		}
		mysql_free_result($result);
		
		
		// finish writing file
		fclose($handle);
		
		// Send the file
		header("Content-Disposition: attachment; filename=\"$FILE_ALL\"");
		header("Content-Type: application/vnd.ms-excel");
		readfile($FILE_ALL);
		
		return;
	else:
	
		$msg = "Bad cmd";
		$status = 400;
	
	endif;
	
	

else:

	$msg = "No session or cmd";
	$status = 400;
	
endif;


if($res)
	echo json_encode(array('status'=>$status,"msg" => $msg, "res" => $res));
else
	echo json_encode(array('status'=>$status,"msg" => $msg));

mysql_close();
