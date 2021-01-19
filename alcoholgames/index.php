<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Dumb Driver</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Jeremy Larsen">
	<link rel="stylesheet" href="assets/css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="assets/js/swfobject.js"></script>
    <?php
    $fav='favicondd.ico';
	$ROOT = (isset($_SERVER['HTTPS'])?"https":"http")."://". $_SERVER['SERVER_NAME'].'/blurredmindsgames/alcoholgames';
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
<?php */?>
</head>
<body class="template">
	<script type="text/javascript">

	var flashyJ; 
	if (swfobject.hasFlashPlayerVersion("11.2")) {
		var fn = function() {
			var att = { data:"assets/swf/game1.swf", height:"570", width:"760" };
		    var par = { wmode:'direct', flashvars:'flashRoot=<?php echo $ROOT.'/assets/swf/'?>' };
		    var id = "gameHere";
		    flashyJ = swfobject.createSWF(att, par, id);
		};
	    swfobject.addDomLoadEvent(fn);
    }	
    </script>
	<div class="template-wrap clear">
		<div id="gameHere">In order to play, please <a href="http://get.adobe.com/flashplayer/">click here to enable or download</a> Abode flash player.</div>
	</div>		
</body>
</html>
