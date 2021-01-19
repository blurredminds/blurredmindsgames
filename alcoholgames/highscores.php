<div class="container">
<div id="highscores">
	<a href="#" class="close-overlay">x</a>
	<p><?php echo $row_game['title'];?></p> 
	
	<div>
	<?php if($row_game['name'] == 'game1'){?>
		<img src="assets/img/dumbest.jpg"/><br/>
	<?php }else{?>
		<img src="assets/img/leaderboard.jpg"/><br/>
		
		<?php 
	}
		$swearing = (isset($_REQUEST['name']) && profanityFilter($_REQUEST['name']));
		
		if($swearing){
			echo '<script>alert("Please refrain from using any profanities in your name");</script>';
		}
		
		$conf = (isset($_REQUEST['conf']) && isset($_REQUEST['score']) && $_REQUEST['conf']);
		$game_id = $row_game['id'];
		$top10Matrix = array();
		
		
		if($conf && !$swearing){
			$user->name = $_REQUEST['name'];
			saveUser($user);
			
			insertGameInfo($game_id,'finished',$_REQUEST['score']);
		}
		
		
		$scores = getHighScores($row_game['id']);
		
		if($swearing){
			$conf = false;			
		}
		
		if(isset($_REQUEST['score']) && $user && !$conf){
			$score = $_REQUEST['score'];
			
			$bestScore = inTop10($game_id);
			
		}
		else{
			$bestScore = 0;
			$score = 0;
		}
		
		
		$x = 0;
		
		
		
		
			$added = false;
			foreach($scores as $t){
				
				// add the use into the matrix if his there
				if($score > $t['score'] && $score > 0 && $score > $bestScore && !$added){
					array_push($top10Matrix, array('isMe' => true, 'score' => $score));
					$x++;
					$added = true;
				}
				
				if($x < 10){
					// if this same user is in the top top, suppress him
					if($score > 0 && $t['user_id'] == $user->id && $score > $bestScore){
						
					}
					else{
						array_push($top10Matrix,$t);
						$x++;
					}
					
				}
				else{
					break;
				}
			}
			
			// if its an empty board or theres still gaps
			if($x < 10 && !$added && $score > 0 && !$added && $score > $bestScore){
				array_push($top10Matrix, array('isMe' => true, 'score' => $score));
			}
		
		
		
		?>
		  
		    <table>
		              
		              <tbody>
		              <?php
		$pos = 1; 
		$gameName = $row_game['name'];
		
		for($x = 0; $x < 10; $x++){
			echo '<tr>';
			echo '<td class="user-rank">'.$pos.'.</td>';
			if(isset($top10Matrix[$x])){

				$unit = "";
				$score = $top10Matrix[$x]['score'];
				if($gameName == 'game1'){
					$unit = "m";
					$score = sprintf("%.0f",$score);
				}
				else if($gameName == "game2"){
					$unit = "%";
					$score = sprintf("%.2f",$score);
				}
				else{
					$score = sprintf("%.0f",$score);
				}
				if(isset($top10Matrix[$x]['isMe'])){
					echo '<td class="user-name"><div class="bounds"><input type="text" name="highScoreName" id="highScoreName" placeholder="Enter your name" value="'.$user->name.'"/><button id="highScoreSub">OK</button><input type="hidden" id="scoreUid" value="'.$user->userId.'"/><input type="hidden" id="scoreVal" value="'.$score.'"/></div></td>';
				}
				else{
					echo '<td class="user-name">'.$top10Matrix[$x]['display_name'].'</td>';
				}
				echo '<td class="user-score">'.$score.' '.$unit.'</td>';
			}
			else{
				echo '<td class="user-name"><i>- empty -</i></td>';
				echo '<td class="user-score">&nbsp;</td>';
			}
			echo '</tr>';
			$pos ++;
			
		}
		              ?>
		              </tbody>
		            </table>
		<br/>
	</div>
	<p><?php echo $school->name;?></p>
	<script>
	$('#highScoreSub').click(function(e){
		e.stopPropagation();
		submitScore($('#scoreUid').val(),$('#scoreVal').val(),$('#highScoreName').val());
	});
	</script> 
</div>
</div>