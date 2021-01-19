<?php 


	if(isset($_REQUEST['step']) == NULL):
		$step = 1;
	else:
		$step = mysql_real_escape_string($_REQUEST['step']) + 1;
		$step_prev = mysql_real_escape_string($_REQUEST['step']);
	
	endif;
	
	//current questions
	$DB_game_question = mysql_query(sprintf("SELECT * FROM question WHERE play_order = '%s' LIMIT 1 ", $step));
	$row_game_q = mysql_fetch_array($DB_game_question);
	mysql_free_result($DB_game_question);
	
	
	if(isset($step_prev) !=''):
		//answer to prev question
		$DB_game_question_prev = mysql_query(sprintf("SELECT * FROM question WHERE play_order = '%s' LIMIT 1 ", $step_prev));
		$row_game_q_prev = mysql_fetch_array($DB_game_question_prev);
		$last_game_id = $row_game_q_prev['id'];
		mysql_free_result($DB_game_question_prev);
		
	endif;
	
	//total questions
	$DB_question_total = mysql_query("SELECT count(*) FROM question");
	$total_question = mysql_fetch_array($DB_question_total);
	$question_total = $total_question[0];
	mysql_free_result($DB_question_total);


//was the last answer correct
if(isset($_POST['option'])):
	$requestOption = stripslashes(urldecode($_POST['option']));
else:
	$requestOption = '';
endif;

if(isset($row_game_q_prev['answer']) && $row_game_q_prev['answer'] == $requestOption):
	$correct = 1;
	$correctWord = 'correct '.$requestOption;

else:
	$correct = 0;
	$correctWord = 'incorrect '.$requestOption;
endif;


// sum up the current score
if(isset($_POST['score'])):
	$score = mysql_real_escape_string($_POST['score']);
else:
	$score = '';
endif;

if ($score == '') : $score = 0;
elseif($correct == 1): $score = $score +1;
endif;

if(isset($_POST['score']) && $question_total == $_POST['step'] - 1 && $rPlay != "highscores"):

	logEvent('gameFinished', isset($_REQUEST['extra'])?json_decode($_REQUEST['extra']):null, $score);


endif;

logEvent('answered question', $correctWord, isset($_POST['step'])?$_POST['step']:0);


if($user)
	$user_id = $user->id; 
?>

<div class="mainPane blocko">
 
 <div class="questionPane">


 	
    <div id="play1" data-gameid="<?php echo $row_game['id']; ?>" data-lastquestion="<?php if(!empty($last_game_id)){echo $last_game_id;} ?>" 
    data-userid="<?php echo $user->userId; ?>" data-correct="<?php echo $correct; ?>" data-score="<?php echo $score; ?>" data-end="<?php echo $question_total;?>">
   
    <h1 id="qtitle"><?php 
echo isset($row_game['id'])? "QUESTION ".$row_game_q['play_order']: "?";
?></h1>

    	<div id="qPane">
	        <div class="question"><?php echo $row_game_q['question'];?></div>
	        <form id="thegame" action="?play=game3" method="post" enctype="application/x-www-form-urlencoded" >
	        	<div id="buttonPane">
		        <?php 	

		$g_id = $row_game['id'];

		$options = explode(',',$row_game_q['options']);
		$lineBreaks = sizeof($options) > 2?2:1;
		$x = 1;
        foreach($options as $index => $part ){

			echo '<button  type="button" class="brownB floatB" onclick="selectA(this)">'.$part.'</button>'.
				(($x % $lineBreaks == 0)?"<br/>":"");
			
			$x++;
        }
        ?>
        </div>
        		<input type="hidden" name="option" id="theAnswer"/>
		        <input type="hidden" value="<?php echo $step;?>" name="step">
		        <input type="hidden" value="<?php echo $score;?>" name="score">
		        <input type="hidden" value="{}" name="extra" id="quizVals">
		        <div class="buttyPane" id="pressPane">
		        	<button class="brownB butty disabled" id="subButt" disabled="disabled">OK</button>
		        </div>
	        </form>
        </div>
        <div class="pane bigTick hide">
        </div>
        <div class="pane bigCross hide">
        </div>
        <div id="aPane" class="hide">
    	
    		<h2 id="a_is_true" class="hide">CORRECT</h2>
    		<h2 id="a_is_false" class="hide">INCORRECT</h2>
    		
    			<div class="dashed"><?php echo $row_game_q['answer'];?></div>
    		
    		<div class="left paddy">
	    	<?php 
	    	if(isset($row_game_q['description'])):
				echo $row_game_q['description'];
			endif;?>
	    	</div>
	    	 <div class="buttyPane">
		        
	    	 <button class="brownB butty" id="nextButt">NEXT</button>
	    	 </div>
    	</div>
    	
     </div> 
     <div id="summary">
    	 <br/><br/>
    	 <h1 style="font-size: 16pt;">YOUR SCORE:</h1>
     
    	 <h1 style="font-size: 40pt;" id="myScore">1 / 14</h1>
    	 
    	 <p id="scoreCap" class="center">
    	 	That's not bad, but you can do better.
    	 </p>
    	 
    	  <div class="bigButtyPane">
	    	 <button class="brownB butty" id="nextButt" onclick="document.location = './?play=game3&school_id=' + schoolId + '&uid=' + currentUserID;">TRY AGAIN</button>
	    	 
	
		    <br/>						
		    
		    
		    <button id="canHS" class="brownB butty" onclick="showHighScores($('#hsgameid').val(),$('#play1').attr('data-userid'),lastScore)">SUBMIT SCORE</button>
	     	<button id="cant" class="brownB butty" onclick="showHighScores('<?php echo $row_game['name'];?>')">VIEW LEADERBOARD</button>
	     
	      </div>
     </div>
        <?php if(isset($_REQUEST['play']) && $_REQUEST['play'] == 'game3' ): ?>
           
            <form id="userIdForm" class="form-signin" style="display:block;">
            
          	    <input type="hidden" name="gameid" value="<?php if(isset($_GET['play'])): echo mysql_real_escape_string($_GET['play']); endif;?>" />
          	    <br/>
            	 <h1 style="font-size: 24pt;">ALCOHOL TRIVIA</h1>
            	 <p>How well do you know your alcohol?<br/>
Take the quiz and test your knowledge.</p>
                <p>User ID:
                <input onpaste="checkId(this.value)" oninput="checkId(this.value)" onkeyup="checkId(this.value)" value="<?php echo isset($_REQUEST['uid'])?$_REQUEST['uid']:"";?>" id="entered-username" type="text" name="user" class="brownB left" autocomplete="off">
                </p>
                <?php if(isset($_REQUEST['uid'])){
               	 echo '<script>setTimeout(function(){checkId($("#entered-username").val());},100);</script>';
                	
                }?>
                <div id="errorID">
                	Enter a valid User id
                </div>
                <?php /* ?><input type="password" name="password" class="input-block-level" placeholder="Password"><?php */ ?>
                <input type="hidden" name="action" value="gameuser">
                <input type="hidden" name="verb" value="started">
               <?php /*?> <label class="checkbox">
                  <input type="checkbox" value="remember-me"> Remember me
                </label><?php */?>
                 <div class="buttyPane" id="pressPane2">
                <button class="brownB butty disabled" id="startButt" type="submit">START</button>
                </div>
            </form>
            <script>$('#userIdForm').show();$('#qPane').hide();$('#qtitle').hide();$('#summary').hide();</script>
           
            <?php endif;?>
</div>
		<div class="scorePane">
    		<?php 
    		$DB_game_question = mysql_query("SELECT * FROM question order by play_order");
    		
    		while($row_game_q = mysql_fetch_array($DB_game_question)){
    			echo '<div class="box boxB" id="question_'.$row_game_q['id'].'">'.$row_game_q['id'].'</div>';
    		}
    		
    		mysql_free_result($DB_game_question);
    		?>
		</div>
		<script type="text/javascript">
		

		$('.scorePane').hide();</script>
</div>              
    