<?php 

function profanityFilter($str){
	
	$str = strtolower($str);
	$badwords = array("ahole","anus","ash0le","ash0les","asholes","ass","ass*", "ass monkey","assface","assh0le","assh0lez","asshole","assholes","assholz","asswipe","azzhole","bassterds","bastard","bastards","bastardz","basterds","basterdz","biatch","bitch","bitches","blow job","boffing","butthole","buttwipe","c0ck","c0cks","c0k","carpet muncher","cawk","cawks","clit","cnts","cntz","cock","cockhead","cock-head","cocks","cocksucker","cock-sucker","crap","cum", "cum*","cunt","cunts","cuntz","dick","dild0","dild0s","dildo","dildos","dilld0","dilld0s","dominatricks","dominatrics","dominatrix","dyke","enema","f u c k","f u c k e r","fag","fag1t","faget","fagg1t","faggit","faggot","fagit","fags","fagz","faig","faigs","fart","flipping the bird","fuck","fucker","fuckin","fucking","fucks","fudge packer","fuk","fukah","fuken","fuker","fukin","fukk","fukkah","fukken","fukker","fukkin","g00k","gay","gayboy","gaygirl","gays","gayz","god-damned","h00r","h0ar","h0re","hells","hoar","hoor","hoore","jackoff","jap","japs","jerk-off","jerkoff","jisim","jiss","jizm","jiz","jizz","knob","knobs","knobz","kunt","kunts","kuntz","lesbian","lezzian","lipshits","lipshitz","masochist","masokist","massterbait","masstrbait","masstrbate","masterbaiter","masterbate","masterbates","masterbation","masturbate","masturbation","motha fucker","motha fuker","motha fukkah","motha fukker","mother fucker","mother fukah","mother fuker","mother fukkah","mother fukker","mother-fucker","mutha fucker","mutha fukah","mutha fuker","mutha fukkah","mutha fukker","n1gr","nastt","nigger;","nigur;","niiger;","niigr;","orafis","orgasim;","orgasm","orgasum","oriface","orifice","orifiss","packi","packie","packy","paki","pakie","paky","pecker","peeenus","peeenusss","peenus","peinus","pen1s","penas","penis","penis-breath","penus","penuus","phuc","phuck","phuk","phuker","phukker","polac","polack","polak","poonani","pr1c","pr1ck","pr1k","pusse","pussee","pussy","puuke","puuker","queer","queers","queerz","qweers","qweerz","qweir","recktum","rectum","retard","sadist","scank","schlong","screwing","semen","sex","sexy","sh!t","sh1t","sh1ter","sh1ts","sh1tter","sh1tz","shit","shits","shitter","shitty","shity","shitz","shyt","shyte","shytty","shyty","skanck","skank","skankee","skankey","skanks","skanky","slut","sluts","slutty","slutz","son-of-a-bitch","tit","turd","va1jina","vag1na","vagiina","vagina","vaj1na","vajina","vullva","vulva","w0p","wh00r","wh0re","whore","xrated","xxx","b!+ch","bitch","blowjob","clit","arschloch","fuck","shit","ass","asshole","b!tch","b17ch","b1tch","bastard","bi+ch","boiolas","buceta","c0ck","cawk","chink","cipa","clits","cock","cum","cunt","dildo","dirsa","ejakulate","fatass","fcuk","fuk","fux0r","hoer","hore","jism","kawk","l3itch","l3i+ch","lesbian","masturbate","masterbat*","masterbat3","motherfucker","s.o.b.","mofo","nazi","nigga","nigger","nutsack","phuck","pimpis","pusse","pussy","scrotum","sh!t","shemale","shi+","sh!+","slut","smut","teets","tits","boobs","b00bs","teez","testical","testicle","titt","w00se","jackoff","wank","whoar","whore","*damn","*dyke","*fuck*","*shit*","*suck*","@$$","amcik","andskota","arse*","assrammer","ayir","bi7ch","bitch*","bollock*","breasts","butt-pirate","cabron","cazzo","chraa","chuj","cock*","cunt*","d4mn","daygo","dego","dick*","dike*","dupa","dziwka","ejackulate","ekrem*","ekto","enculer","faen","fag*","fanculo","fanny","feces","feg","felcher","ficken","fitt*","flikker","foreskin","fotze","fu(*","fuk*","futkretzn","gay","gook","guiena","h0r","h4x0r","hell","helvete","hoer*","honkey","huevon","hui","injun","jizz","kanker*","kike","klootzak","kraut","knulle","kuk","kuksuger","kurac","kurwa","kusi*","kyrpa*","lesbo","mamhoon","masturbat*","merd*","mibun","monkleigh","mouliewop","muie","mulkku","muschi","nazis","nepesaurio","nigger*","orospu","paska*","perse","picka","pierdol*","pillu*","pimmel","piss*","pizda","poontsee","poop","porn","p0rn","pr0n","preteen","pula","pule","puta","puto","qahbeh","queef*","rautenberg","schaffer","scheiss*","schlampe","schmuck","screw","sh!t*","sharmuta","sharmute","shipal","shiz","skribz","skurwysyn","sphencter","spic","spierdalaj","splooge","suka","b00b*","testicle*","titt*","twat","vittu","wank*","wetback*","wichser","wop*","yed","zabourah");

	foreach ($badwords as $cur){
		
		if(strpos($str,$cur) !== false){
			
			return true;
		}
	}
    return false;
}

function findOrMakeUser($uid){
	
	global $_SESSION;
	global $school;
	$requestUser = getUserByUsername($uid);
	
	if(!$requestUser){
		
		
		$requestUser = new User();
		$requestUser->userId = $uid;
		$requestUser->school = $school;
		$requestUser->name = "";
		saveUser($requestUser);
	}
	else if($requestUser->school->id != $school->id){
		$requestUser->school = $school;
		saveUser($requestUser);
	}
	
	return $requestUser;
}

function getMyHighestScoreToday(){
	global $game_id;
	global $user;
	global $TZ;
		
	$date = new DateTime(null,$TZ);
	$fromDate = $date->format("Y-m-d"). " 00:00.00";
	
	$sql = sprintf("SELECT * FROM user_events g ".
			"WHERE ".
			"g.game_id = ".$game_id." AND ".
			"g.user_id = ".$user->id." AND ".
			"g.milestone = 'gameFinished' AND ".
			"g.date_created > '".$fromDate."' ".
			" ORDER BY number_metric1 DESC LIMIT 1 ");
	//echo $sql;
	$DB_game = mysql_query($sql);
	$row = mysql_fetch_array($DB_game);
	mysql_free_result($DB_game);
	if(!$row) return 0;
	else return $row['number_metric1'];
}
function inTop10($gameId){
	global $user;

	foreach(getHighScores($gameId) as $cur){
		//echo $cur;
		if($cur['user_id'] == $user->id){
			return $cur['score'];
		}
	}
	return null;
}
function getHighScores($gameId){
	global $school;
	global $TZ;
	$date = new DateTime(null,$TZ);
	$fromDate = $date->format("Y-m-d"). " 00:00.00";

	$sql = sprintf("SELECT * FROM game_scores g ".
			"inner join user u on g.user_id = u.id ".
			"WHERE u.school_id = ".$school->id." AND ".
			"g.game_id = ".$gameId." AND ".
			"g.score > 0 AND ".
			"g.date_created > '".$fromDate."' ".
			" ORDER BY score DESC LIMIT 10 ");
	//echo $sql;
	$DB_game = mysql_query($sql);
	$res = array();
	while($row = mysql_fetch_array($DB_game)){
		array_push($res,$row);
	}
	mysql_free_result($DB_game);

	return $res;
}

function logEvent($desc, $extra=null, $num=-1.0){

	global $game_id;
	global $user;
	global $school;
	global $_SESSION;
	global $TZ;
	if($desc == 'startGame'){
		$dt = new DateTime(null,$TZ);
		$_SESSION['last_start'] = $dt->getTimestamp(); 
	}
	if($desc == 'gameFinished' && isset($_SESSION['last_start'])){
		$dt = new DateTime(null,$TZ);
		$duration = $dt->getTimestamp() - $_SESSION['last_start'];
		logEvent('html_dur',null,$duration);
	}
	
	$q = "INSERT INTO user_events 
	(id, 
	school_id,
	session_id, 
	game_id, 
	user_id, 
	milestone, 
	number_metric1, 
	extra_data) 
	VALUES (NULL,". 
	$school->id.",". 
	"'".mysql_real_escape_string(session_id())."',". 
	($game_id?$game_id:'NULL').",". 
	($user?$user->id:'NULL').",".
	"'".mysql_real_escape_string($desc)."',".
	$num.",".
	"'".($extra?mysql_real_escape_string(json_encode($extra)):'NULL')."')";
	
	
	mysql_query($q);
	
}

function getGameInfo($gameId){
	$DB_game = mysql_query(sprintf("SELECT * FROM game WHERE name = '%s' LIMIT 1 ", mysql_real_escape_string($gameId)));
	$row_game = mysql_fetch_array($DB_game);
	$game_id  = $row_game['id'];
		
	mysql_free_result($DB_game);
	return $row_game;
}
function insertGameInfo($gameId, $event, $score){
	
	global $user;
	$sql = "DELETE FROM game_scores WHERE user_id=".$user->id." AND game_id = ".$gameId;
	mysql_query($sql);
	
	$insert = sprintf("INSERT INTO game_scores ( `user_id`, `game_id`, `score`, `status`,
				`date_created`, `date_mod`) VALUES (%s,%s,%s,'%s',NOW(),NOW() )",
			$user->id,$gameId,$score,mysql_real_escape_string($event));
	
	//echo $insert;
	
	mysql_query($insert);
}