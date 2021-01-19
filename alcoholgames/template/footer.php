

    <!-- Javascript -->
    <script src="assets/js/global.js"></script>
    
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
	<?php /* UI Bootstraps ?>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
	<?php */?>
  <?php if(isset($_GET['play'])): ?> <script> $(document).ready(function(){
	  $('body').attr('data-gamename','<?php echo mysql_real_escape_string($_GET['play']); ?>');
	  });</script><?php endif;?>
    <div id="overlay">
        <div class="scorepane">
        <div id="score-card">
           	
        </div>
        </div>
       <input type="hidden" name="gameid" id="hsgameid" value="<?php echo $row_game['name'];?>"/>
	                    	
    </div>
   
    <script>
    function logEvent(gameId, event, extra, numb){
		$.post('./setGameDetails.php',({
			'action' : 'log',
			'gameid' : gameId,
			'event' : event,
			'num' : numb,
			'extra' : JSON.stringify(extra)
			}),function(){});
		
	}
	
    var startTime = new Date().getTime();
    window.onunload = function (e) {
        logEvent(<?php echo $row_game?"'".$row_game['name']."'":"null"; ?>,"leave_page",{time:(new Date().getTime() - startTime)},(new Date().getTime() - startTime));
        return "ACL";
    }
    $(document).ready(function() {
        logEvent(<?php echo $row_game?"'".$row_game['name']."'":"null"; ?>,"open_page",{
			screenW:window.screen.width,
			screenH:window.screen.height
        });
    });
    </script>
    
    	<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo $GOOGLE_A_ID; ?>']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script> 