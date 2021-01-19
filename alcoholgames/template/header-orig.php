<?php 
$pagetitle ='';
//$user_id =  mysql_real_escape_string($_SESSION['loggedin']);

if(isset($_SESSION['loggedin'])):
 $user_id  = mysql_real_escape_string($_SESSION['loggedin']);
else:
 $user_id  = '';
endif;



if(isset($_SESSION['loggedin'])):
 $session_ID = $_SESSION['loggedin'];
else:
 $session_ID = '';
endif;


?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title><?php echo $row_game['title'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Steve Chan">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/js/swfobject.js"></script>
    <?php
    $fav='faviconpp.ico'; 
	if(isset($row_game) && $row_game['name'] == 'game3'){
    	echo '<link href="assets/css/bootstrap.css" rel="stylesheet">';
    	echo '<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">';
    	$fav='faviconaa.ico';
    	 
    }else if(isset($row_game) && $row_game['name'] == 'game1'){
		$fav='favicondd.ico';
	}
    ?>
    
    <link rel="shortcut icon" href="assets/img/<?php echo $fav;?>" type="image/x-icon">
	
    <link href="assets/css/global.css" rel="stylesheet">
        <link href="assets/css/quiz.css" rel="stylesheet">
        <?php /*?><!-- HTML5 shim, for IE6-8 support of HTML5 elements --><?php */?>
    
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <?php /*?><!-- Fav and touch icons if needed -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/img/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/img/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/img/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/img/ico/apple-touch-icon-57-precomposed.png">
<?php */?><link rel="shortcut icon" href="assets/img/ico/favicon.png">
</head>
<body data-user="<?php echo $user?$user->userId:"";?>" data-school="<?php echo $school?$school->id:"";?>">
<?php if($school): ?>

<script type="text/javascript">
var schoolId = <?php echo $school->id;?>;
 </script>
<!-- 
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
          <a class="brand" href="?"><?php echo $school->name; ?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
			<?php echo $gamesNav; ?>
          </div>
         
        </div>
      </div>
    </div>
      -->
<?php endif; ?>
<?php if($school && false){?>
	<div class="blacky">
		<span class="blacky_l" ><a href="#" onclick="showHighScores()">View today's top 10</a></span>
		<span class="blacky_r" ><?php echo $row_game['title'];?></span>
		<?php echo $school->name;?>
	</div>
<?php }?>

