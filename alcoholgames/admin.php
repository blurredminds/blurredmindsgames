<?php
session_start();
include_once 'src/header.php';

function getAverageTimeOnPage($gameId, $where = null){
	
	$query = mysql_query("SELECT avg(number_metric1) as count FROM user_events e inner join user u on (u.id = e.user_id)  WHERE milestone = '".($gameId == 6?"html_dur":"flash_dur")."' AND game_id=". $gameId.' '.($where?$where:''));
	
	$row = mysql_fetch_array($query);
	$res = $row['count'];
	mysql_free_result($query);
	return $res;
}
function getAverageScore($gameId, $where = null){

	$query = mysql_query("SELECT avg(number_metric1) as count FROM user_events e inner join user u on (u.id = e.user_id) WHERE milestone = 'gameFinished' AND game_id=". $gameId.' '.($where?$where:''));

	$row = mysql_fetch_array($query);
	$res = $row['count'];
	mysql_free_result($query);
	return $res;
}
function getTotalUsersPlayed($gameId, $where = null){

	$query = mysql_query("SELECT count(distinct user_Id) as count FROM user_events e inner join user u on (u.id = e.user_id) WHERE milestone = 'gameFinished' AND game_id=". $gameId.' '.($where?$where:''));

	$row = mysql_fetch_array($query);
	$res = $row['count'];
	mysql_free_result($query);
	return $res;
}
function getTotalPlays($gameId, $where = null){
	$query = mysql_query("SELECT count(e.id) as count FROM user_events e inner join user u on (u.id = e.user_id) WHERE milestone = 'gameFinished' AND game_id=". $gameId.' '.($where?$where:''));
	
	$row = mysql_fetch_array($query);
	$res = $row['count'];
	mysql_free_result($query);
	return $res;
}

if(isset($_REQUEST['password']) && $_REQUEST['password'] == "upAndAtThem"){
	$_SESSION['loggedIn'] = true;
	header('Location: ./admin.php',true,302);
	return;
}

if(isset($_REQUEST['logout'])){
	$_SESSION['loggedIn'] = false;
	header('Location: ./admin.php',true,302);
}
?>
<html>
	<head>
	    <link href="assets/css/bootstrap.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		 
	</head>
	<body>
<?php 
if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']){?>

	
	<div class="container">
		
<div class="navbar">
		 <div class="navbar-inner">
			<a class="brand" href="#">Alcohol Game Admin</a>
			<ul class="nav">
				<li class="<?php echo isset($_REQUEST['mode'])?"":"active";?>"><a href="admin.php">Stats</a></li>
				<li class="<?php echo isset($_REQUEST['mode'])?"active":"";?>"><a href="admin.php?mode=setup">School Setup</a></li>
			</ul>
			
			<ul class="nav pull-right">
				<li><a href="admin.php?logout=true">Logout</a></li>
			</ul>
		</div>
		
	</div>
	
<?php
if(!isset($_REQUEST['mode'])) :
?>	
   
			 <div class="row-fluid">
				<H2 class="span3">Stats</H2>
				<div class="span3 pull-right">
				 <div class="btn-group pull-right">
			    <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			    		 <?php if($school){
					echo 'Filtered by '. $school->name;
				}
				else{
					echo 'Filter by school';

				}?>
			    	<span class="caret"></span>
			    </a>
			    <ul class="dropdown-menu">
			    <?php 
			    $query = mysql_query("SELECT * from school order by name");
			    
			    while($row = mysql_fetch_array($query)){
					?>
						<li><a tabindex="-1" href="admin.php?school_id=<?php echo $row['school_code'];?>"><?php echo $row['name']; ?></a></li>
					<?php 
			    }
			    mysql_free_result($query);
			    ?>
					<li class="divider"></li>
					<li><a tabindex="-1" href="admin.php?school_id=-1">All Schools</a></li>
			    </ul>
		   	 </div>
		   
		   	 </div>
		    </div>
		    
		<?php
		$games = array();

		$query = mysql_query("SELECT * from game order by id");
		
		while($row = mysql_fetch_array($query)){
			$games[$row['id']] = $row;
		}
		mysql_free_result($query);
		
		?>	
		<div class="row-fluid">
				<div class="span3">
					
				</div>
				<div class="span3">
					<h4>Dumb Driver</h4>
				</div>
				<div class="span3">
					<h4>Perfect pour</h4>
				</div>
				<div class="span3">
					<h4>Alcohol Trivia</h4>
				</div>
			</div>
		<div class="row-fluid">
			<div class="span3">
				Total Plays		
			</div>
	<?php 
	$whereClase = "";
	if($school){
		$whereClase = " AND u.school_id=".$school->id;
	}
	foreach($games as $k => $v){
	?>
			<div class="span3">
				<?php echo getTotalPlays($k,$whereClase); ?>		
			</div>		
	<?php }?>
		</div>	
		<div class="row-fluid">
			<div class="span3">
				Unique Plays		
			</div>
	<?php 
	foreach($games as $k => $v){
	?>
			<div class="span3">
				<?php echo getTotalUsersPlayed($k,$whereClase); ?>		
			</div>		
	<?php }?>
		</div>	
		
		<div class="row-fluid">
			<div class="span3">
				Average game duration
			</div>
	<?php 
	foreach($games as $k => $v){
	?>
			<div class="span3">
				<?php echo sprintf("%.1f",getAverageTimeOnPage($k,$whereClase)/60) ." mins"; ?>		
			</div>		
	<?php }?>
		</div>	
		
		
		<div class="row-fluid">
			<div class="span3">
				Average Score
			</div>
	<?php 
	foreach($games as $k => $v){
	?>
			<div class="span3">
				<?php echo sprintf("%.1f",getAverageScore($k,$whereClase)); ?>		
			</div>		
	<?php }?>
		</div>	
		
		
			
		
		<div class="row-fluid">
			<div class="span3">
				
			</div>
	<?php 
	foreach($games as $k => $v){
	?>
			<div class="span3">
				<a href="admin_cmd.php?cmd=dump&game_id=<?php echo $k.($school?'':'&school_id=-1');?>">Data Dump</a>
			</div>		
	<?php }?>
		</div>	
	
<?php
else :
?>	
<h2>Schools</h2>
<p>
Click the ID of a school to show the game access URLs.
</p>
	<div class="row-fluid">
	<div class="span8">
		<div class="span1">
			ID
		</div>
		<div class="span3">
			Name
		</div>
		<div class="span3">
			School Code
		</div>
		</div>
	</div>
	<div class="row-fluid">
	<div class="span8">
<?php 
$query = mysql_query("SELECT * from school order by name");

while($row = mysql_fetch_array($query)){
	$s = loadSchool($row);?>
		<div class="row-fluid">
			<form method="POST" action="admin_cmd.php" class="form-inline">
				<div class="span1">
					<a href="#" onclick="$('#urls').show();$('#sn').html('<?php echo $s->name; ?>');$('#dd').val('<?php echo $ROOT.'?play=game1&school_id='.$s->id;?>');$('#pp').val('<?php echo $ROOT.'?play=game2&school_id='.$s->id;?>');$('#aa').val('<?php echo $ROOT.'?play=game3&school_id='.$s->id;?>');"><?php echo $s->id; ?></a>
				</div>
				<div class="span3">
					<input type="text" name="name" class="span12" value="<?php echo $s->name; ?>"/>
				</div>
				<div class="span3">
					<input type="text" class="span12" name="code" value="<?php echo $s->code; ?>"/>
				</div>
				<div class="span4">
					<input type="hidden" name="school_id" value="<?php echo $s->id; ?>"/>
					<input type="submit" name="cmd" class="btn" value="Update" />
					<input type="submit" name="cmd" class="btn btn-danger" value="Delete" />
				</div>
			</form>
		</div>
<?php 
}

mysql_free_result($query);
?>	
			<div class="row-fluid">
				<form method="POST" action="admin_cmd.php" class="form-inline">
					<div class="span1">
						
					</div>
					<div class="span3">
						<input type="text" class="span12" name="name" value="" placeholder="New School Name"/>
					</div>
					<div class="span3">
						<input type="text" name="code" class="span12"  placeholder="New code (2 digits)"/>
					</div>
					<div class="span4">
						<input type="submit" name="cmd" class="btn btn-primary" value="Add" />
					</div>
				</form>
				
			</div>
		</div>
		<div class="span4" style="display: none;" id="urls">
			<h5><i id="sn"></i> URLs</h5>
			Dumb Driver
			<input type="text" class="span12" id="dd"/>
			Perfect Pour
			<input type="text" class="span12" id="pp"/>
			Alcohol Awareness
			<input type="text" class="span12" id="aa"/>
				
			</div>
	</div>
		<?php
endif;
?>	
		
		
<?php }
else{
?>
	<div class="container">
	<h2>Restricted</h2>
	<form method="POST">
		<input type="password" name="password"/><br/>
		<input type="submit" value="Login"/>
	</form>
	
	<?php 
	if(isset($_REQUEST['password'])){
		echo '<div class="alert"> Bad Password</div>';
	}
	if(isset($_REQUEST['logout'])){
		echo '<div class="alert"> Thank you come again.</div>';
	}?>
	 
	
	
<?php 
}
?>

</div>
</div>
	 	 <script src="http://code.jquery.com/jquery.js"></script>
		 <script src="assets/js/bootstrap.min.js" ></script>
	     <script src="assets/js/bootstrap-dropdown.js" ></script>
	     <script type="text/javascript">$('.dropdown-toggle').dropdown();</script>
	</body>
</html>
