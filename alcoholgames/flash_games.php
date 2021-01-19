

	<script type="text/javascript">

	var flashyJ; 
   if (swfobject.hasFlashPlayerVersion("11.2")) {
		      var fn = function() {
		        var att = { data:"assets/swf/<?php
			    	// file name for game 
			    	echo $row_game['file'];
			    ?>", <?php 
			    if($row_game['name'] == 'game1'){
					echo 'height:"570", width:"760"';
				}
				else{
					echo 'height:"466", width:"474"';
				}
			    ?> };
		        var par = {
		        	 wmode:'<?php echo ($row_game['name'] == 'game1')?"direct":"opaque";?>',
		        			 flashvars:'flashRoot=<?php echo $ROOT.'/assets/swf/'?>'
		        	 };
		        var id = "gameHere";
		        flashyJ = swfobject.createSWF(att, par, id);
	      };
	      swfobject.addDomLoadEvent(fn);
    }	
    </script>
    	<div id="gameHere" class="blocko">Please <a href="http://get.adobe.com/flashplayer/"">download</a> the latest version of the Abode flash player</div>
		
    <?php if($IS_STAGING){?>
    <a href="#" onclick="$('#stg_stuff').show()">#</a>
    <div id="stg_stuff" style="display: none">
    	<p>Staging helper:</p>
    	
    	 <div><br/> 
	    	<b>onTrackFlashEvent(userId,event,extra)</b><br/><br/>
	    	<i>Used to log any event</i><br/><br/>
	    	UserID: <input id="frm_uid2"/> <br/>
			Event: <input id="frm_event2"/> <br/>
			Extra: <input id="frm_extra2" value='{"foo" : "bah"}'/><br/> 
			<button id="testForm2">Test onFlashGameFinished</button>    
	    </div>
	    
	    <div>
	    	
	    	<b>onFlashGameFinished(userId,score,extra)</b><br/><br/>
	    	<i>Almost the same as onTrackFlashEvent, except it logs the score in a seperate field, has a fixed event 'finishedGame' and returns a JSON res.
	    	Will call flashDataSaved(obj) sample JSON : {status:0, msg"OK", res:{eligableForLeaderboard:0, bestScore:32}}</i><br/><br/>
	    	
	    	UserID: <input id="frm_uid"/> <br/>
			Score: <input id="frm_s"/> <br/>
			Extra: <input id="frm_extra" value='{"foo" : "bah"}'/><br/> 
			<button id="testForm">Test onFlashGameFinished</button>    <br/>
	    </div>
	   
	    
	    <div><br/> 
	    	<b>onSubmitToLeaderboard(userId,score)</b><br/><br/>
	    	UserID: <input id="frm_uid3"/> <br/>
	    	
			Score: <input id="frm_score3"/> <br/>
			<button id="testForm3">Test onSubmitToLeaderboard</button>    
	    </div>
	    
	    
	    <div><b>onShowLeaderboard()</b><br/><br/>
	    	<button onclick="onShowLeaderboard()">show Leaderboard</button>
	    </div>
	    <script type="text/javascript">
	    $(document).ready(function() {
	    	$('#testForm').on('click', function(){
	    		onFlashGameFinished($('#frm_uid').val(),$('#frm_s').val(),$('#frm_extra').val());
	    	});
	    	$('#testForm2').on('click', function(){
	    		onTrackFlashEvent($('#frm_uid2').val(),$('#frm_event2').val(),$('#frm_extra2').val());
	    	});
	    	$('#testForm3').on('click', function(){
	    		onSubmitToLeaderboard($('#frm_uid3').val(),$('#frm_score3').val());
	    	});
	    });
	    </script>
	    </div>
    <?php }?>
    <script>

    
    function onTrackFlashEvent(userId,event,extra){
		$.ajax('setGameDetails.php',
				{
					type:'POST',
					data:{
						'action' : 'log',
						'user' : userId,
						'event' : event,
						'extra' : JSON.stringify(extra),
						'school_id' : schoolId,
						'gameid': '<?php echo $row_game['name'];?>'
					},
					success : function (data, textStatus, jqXHR) {
//						flashyJ.flashEventSent(data);
					}
				}
				);
	}
    function onFlashGameFinished(userId,score,extra){
		$.ajax('setGameDetails.php',
				{
					type:'POST',
					data:{
						'action' : 'endgame',
						'user' : userId,
						'score' : score,
						'extra' : extra,
						'school_id' : schoolId,
						'gameid': '<?php echo $row_game['name'];?>'
					},
					success : function (data, textStatus, jqXHR) {
						flashyJ.flashDataSaved(JSON.stringify(data));
					}
				}
				);
	}
    function onSubmitToLeaderboard(userId,score){
    	showEnterScore(userId,score);
    }
    function onShowLeaderboard(){
    	this.showHighScores('<?php echo $row_game['name'];?>');
    } 
	</script>
    
