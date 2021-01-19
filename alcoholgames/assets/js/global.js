// stringify
JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};


// General Functions
function error(text,target){
	target.before('<p class="error">'+text+'</p>');
}

//Profanity Filter



// DOM READY 
var doc = document;
$(doc).ready(function() {

// General UI actions	
//$(doc).on('click','.btn-login',function(){$('#overlay').fadeIn(333); $('#overlay .container').css('marginTop','-300px').animate({marginTop:'30px'},333);return false;});
	
$('.form-signin input').focus(function(){$('.form-signin .error').remove(); });



$(doc).on('click','.form-get-name .btn',function(){
	var gameID = $('body').attr('data-gameid');
	var uid = $('body').attr('data-userid');
	var name = $('#enter-name-change').val();
	$('.for-' + uid +' .user-name').html(name +' ');
	

	$.ajax('setGameDetails.php',
			{
				type:'POST',
				data: {
					'action' : 'sendscore',
					'name' : name,
					'score' : $('#score-card .text-info').text(),
					'user' : $('#hsuid').val(),
					'school_id' : schoolId,
					'gameid': $('#hsgameid').val()
				},
				success : function (data, textStatus, jqXHR) {
					console.log(data);
					$('#score-card').hide();
					showHighScores($('#hsgameid').val());
				},
				failure : function (a,b,c){
					alert("ERROR " + a);
				}
				
			}
			);
		
});
$('#viewScores').on('click',function(){
		$('#score-card').hide();
		showHighScores($('#hsgameid').val());
		
});

$('.form-signin').submit(function(){
	var s= $('#entered-username').val();
	if(!checkId(s)){
		$('#errorID').fadeIn(300);
		return false;
	}
	var uid = $('#entered-username').val();
	
	$('.form-signin .error').remove();
	var a = $(this).serializeArray();
	var b =$('#subButt');
	
	$('#pressPane2').html('<div class="loader"></div>');
	
	$.ajax("setGameDetails.php", 
		{
		type:'POST',
		data:{
			user:uid,
			action : 'log',
			school_id : schoolId,
			gameid : $('#hsgameid').val(),
			event: 'startGame'
		},
		cache:false,
		type:'post', 
		success: function (data, textStatus, jqXHR) {
					if(data.status == 0){
					
						$('.scorePane').fadeIn(300);
						$('#play1').attr('data-userid',uid);
						$('#qPane').fadeIn(300);
						$('.form-signin').hide();
						quizVals = {};
						$('#qtitle').show();
						$('#question_1').addClass('active');
					}
					else{
						error(data.msg, b);
					}
				}
		});
		
	return false;
	
	});


// Question Game Handles

$(doc).on('submit','#thegame', function(){
	
	var y = '#play1';
	
	currentUserID = $(y).attr('data-userid');
	
	var a = $(this).serializeArray();
	a['user'] = currentUserID;
	
	//var b = $('#thegame input[name=option]:checked').val();
	var c = $(this).children('#thegame input[name=step]').val();

	var where = '';
	
	end = $(y).attr('data-end');
	
	//if(end == c){ $('#overlay').fadeIn(333);}
	
	$.post(where,a,function(d){
		
		var z = $(d).find(y);
		var lastAnswer = $(z).attr('data-answer');
		lastAnswerID = $(z).attr('data-lastquestion');
		var lastCorrect = $(z).attr('data-correct') == "1";
		lastScore = $(z).attr('data-score');
		var gameID = $('#hsgameid').val();
		var currentUsername = $('#play1').attr('data-user');
		$('body').attr('data-gameid',gameID);
		var schoolID = $('body').attr('data-school');
		
		quizVals[lastAnswerID] = lastCorrect;
		
		$('#question_' + lastAnswerID).html('');
		$('#question_' + lastAnswerID).addClass(lastCorrect?'tick':'cross');
		$('#question_' + lastAnswerID).removeClass('active');
		
		
		//$('#qtitle').html("&nbsp;");
		$('#qtitle').hide();
		if(end == c){
			isEnd = true;
		}
		

		newQPayload = z;
		$('#play1').show();
		$('.loader').hide();

		$('#qPane').hide();
		
		$('#a_is_' + lastCorrect).show();
		if(lastCorrect){
			correct.play();
			$('.bigTick').fadeIn();
		}
		else{
			incorrect.play();
			$('.bigCross').fadeIn();
		}
		//if(lastCorrect == 0){ var status = '<div class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button><strong>Oh snap!</strong> that answer was incorrect.</div>';} else { var status = '<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button><strong>Oh yeah!</strong> that answer was correct.</div>';}
		//$(status).prependTo(y);
		setTimeout(function(){
			$('.bigTick').fadeOut();
			$('.bigCross').fadeOut();
			$('#aPane').fadeIn();
		},2000);
		$('.brownB').each(function(a){$(this).removeClass("disabled");});
		});
		$('#pressPane').html('<div class="loader"></div>');
		$('.brownB').each(function(a){$(this).addClass("disabled");});
	return false;
	});
	//next button on quiz
	$('#nextButt').on('click',function(){
		showNextQ();
		
	});
	
	
	//next button on quiz
	$('#overlay').on('click',function(){
		$(this).fadeOut(300);
	});
	
	
	
}); // end DOM Ready
function showEnterScore(uid, score){
	showHighScores($('#hsgameid').val(),uid,score);
}
function submitScore(uid, score, name){
	if(name == ""){
		alert("Please supply your name");
		return;
	}
	showHighScores($('#hsgameid').val(),uid,score, true, name);
}
function showAutoEnterScore(uid, score, extra){
	$('#form-get-name #appendedPrependedInput').val(uid);
	$('#score-card .text-info').text(score);
	$('#score-card').show();
	$('#hsuid').val(uid);
	

	$('#canHS').hide();
	$('#cant').hide();
	
	$.ajax('setGameDetails.php',
			{
				type:'POST',
				data: {
					'action' : 'endgame',
					'score' : score,
					'user' : uid,
					'school_id' : schoolId,
					'extra' : extra?JSON.stringify(extra):null,
					'gameid': $('#hsgameid').val()
				},
				success : function (data, textStatus, jqXHR) {
					if(data.res.eligableForLeaderboard){
						$('#canHS').show();
					}
					else{
						$('#cant').show();
						
					}
				}
			});
}
var quizVals = {};
function showHighScores(game, uid, score, defSub, name){
	$('#overlay').fadeIn(333);
	$('#score-card').show();
	
	
	$('#score-card').html( '<p id="scoreLoad"style="color:white;text-align: center;"><br/><br/>Loading...<br/><br/><br/><br/></p>');
	var dat = {
			'play' : $('#hsgameid').val(),
			'highscores' : true,
			'user' : uid,
			'score' : score,
			'conf' : defSub,
			'school_id' : schoolId,
			'name' : name
		};
	$.ajax('index.php',
			{
				type:'POST',
				data: dat,
				success : function (data, textStatus, jqXHR) {
					$('#score-card').html('<div id="highscores">' + $(data).find('#highscores').html() + "</div>");
					//next button on quiz
					$('#highscores').on('click',function(e){
						e.stopPropagation();
					});
					$('.close-overlay').on('click',function(){
						$('#overlay').fadeOut();
					});

				}
			});

	var args = {
			play:game,
			highscores:true
		};
	$.post('index.php', args, function(d){
			var z = $(d).find('#highscores');
			$('#scoreBB').html(z);
		});
	
}
var newQPayload;
var isEnd = false;
var lastScore;
var end;
var currentUserID;
var lastAnswerID;
function showNextQ(){
	
	if(isEnd){
		var finalScore = lastScore;
		var totalScore = end * 10;
		
		var score = parseInt(finalScore);
		$('#play1').hide(); $('#summary').fadeIn(300);
		
		$('#myScore').html(score + " / 14");
		$('#myScoreH').val(score);
		
		if(score == 14){
			$('#scoreCap').html("Perfect score! Well done.");
		}
		else if(score > 9){
			$('#scoreCap').html("Excellent score! Well done.");
		}
		else if(score > 6){
			$('#scoreCap').html("That's not bad, but you can do better.");
		}
		else if(score > 3){
			$('#scoreCap').html("There's definitely room for improvement.");
		}
		else{
			$('#scoreCap').html("That was terrible!");
			
		}
		showAutoEnterScore(currentUserID,finalScore,quizVals);
		
	}
	else{
		$('#play1').replaceWith(newQPayload);
		$('#quizVals').val(JSON.stringify(quizVals));
		// next button on quiz
		$('#nextButt').on('click',function(){
			showNextQ()
		});
		var curQ = $('#question_' + (parseInt(lastAnswerID) + 1));
		curQ.addClass('active');
	}
}

function selectA(but){
	if($(but).hasClass("disabled")) return;
	$('.floatB').each(function (a){
		$(this).removeClass("selected");
	});
	$(but).addClass("selected");
	$('#theAnswer').val($(but).html());
	$("#subButt").removeAttr("disabled");         
	$("#subButt").removeClass("disabled");
	
}
var r =new RegExp("[A-Z,a-z]{1}[0-9]{2}[A-Z,a-z]{1}[0-9]{2}");

function checkId(str){
	if(str.length == 6 && r.test(str)){
		$("#startButt").removeClass("disabled");
		$('#errorID').fadeOut();
		return true;
	}
	else{
		$("#startButt").addClass("disabled");
		return false;
	}
}

// sounds and stuff
var audio = document.createElement('audio');

var exnt = "wav";
if (audio.canPlayType('audio/mpeg;')) {
   exnt = "mp3";
} else 	if (audio.canPlayType('audio/ogg;')) {
	exnt = "ogg";
}
var correct = new Audio("assets/sounds/correct." + exnt);
var incorrect = new Audio("assets/sounds/incorrect." + exnt);
