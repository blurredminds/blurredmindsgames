<?php


// Timezone to display dates in
$TZ = new DateTimeZone('Australia/Queensland');
// NOTE TO SELF 
// Live Google Analytics key: UA-38527910-1
// Staging key: UA-38527910-2

// put it in commons.php eg: $GOOGLE_A_ID = 'UA-38527910-2';
$DEFAULT_SCHOOL = 'zz';

$EXPORT_COLS = array(
		4 =>  array('gameDuration','drinkAmounts','finalBac','obstaclesHit'), // dumb driver
		5 =>  array('gameDuration','levelScores','overUnder'), // perfect pour
		6 =>  array('1','2','3','4','5','6','7','8','9','10','11','12','13','14') // quiz
);
?>
