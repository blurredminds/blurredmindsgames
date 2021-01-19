
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";



CREATE TABLE `game` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET utf8 NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `play_order` int(2) NOT NULL,
  `img` text NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `game`
--

INSERT INTO `game` VALUES(NULL, 'game1', 'Driving Game', 'Insert game description here.', 1, 'game.jpg', 'game1.swf');
INSERT INTO `game` VALUES(NULL, 'game2', 'Pouring', 'Insert game description here.', 2, 'game.jpg', 'game2.swf');
INSERT INTO `game` VALUES(NULL, 'game3', 'Alcohol Trivia', 'Insert game description here.', 3, 'game.jpg', '');

-- --------------------------------------------------------

--
-- Table structure for table `game_scores`
--

CREATE TABLE `game_scores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `score`  DECIMAL(10,4) NOT NULL,
  `status` varchar(20) CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `date_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;


-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `play_order` int(3) NOT NULL,
  `question` text CHARACTER SET utf8 NOT NULL,
  `description` text NOT NULL,
  `answer` varchar(200) NOT NULL,
  `options` varchar(255) NOT NULL DEFAULT 'yes,no',
  `date_created` datetime NOT NULL,
  `date_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` VALUES(1, 1, 'Most year 10 students drink alcohol regularly.', 'But 25% of 16-17 year olds across Australia are non-drinkers and 61% of Australians aged 14-25 years drink at low-risk levels.', 'false', 'true,false', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `question` VALUES(2, 2, 'There are things you can do to sober up faster.', 'The only thing you can do is WAIT. You can''t speed up the body''s ability to process alcohol.', 'false', 'true,false', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `question` VALUES(3, 3, 'A standard drink is often different to a<br/>typical serving of alcohol.', 'Most servings in bars or at home are not ''standard drinks''. For example, a standard drink of white white is 100mL, but a glass will often contain 150mL or more.', 'true', 'true,false', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `question` VALUES(4, 4, 'Alcohol is a drug.', 'Alcohol acts on the nervous system like many other drugs. It''s a depressant, which affects your brain.  High levels of alcohol in your blood steam are toxic and can lead to alcohol poisoning.', 'true', 'true,false', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(5, 5, 'Drinking black coffee helps you sober up.', 'Drinking coffee, exercise, taking a shower or sleeping have no effect on the level of alcohol in a person''s body. In fact, your blood alcohol level can continue to rise 3 hours after your last drink.', 'false', 'true,false', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(6, 6, 'There is more alcohol in a standard drink of beer than in a standard drink of spirits.', 'Trick question! One standard drink will always equal another standard drink, no matter what kind of drink it is. In Australia, one standard drink contains 10g of alcohol (equivalent to 12.5mL of pure alcohol).', 'false', 'true,false', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(7, 7, 'Females and males digest and break down alcohol differently.', 'On average, females are slower to digest and<br/> break down alcohol than males.', 'true', 'true,false', '0000-00-00 00:00:00', '2013-03-06 18:49:09');

INSERT INTO `question` VALUES(8, 8, 'Australian drinking guidelines suggest that people 18 years or younger should drink ___ standard drinks a day.', 'The National Health and Medical Research Council (NHMRC) recommends that it is safest for people under 18 years of age to not drink alcohol. Alcohol consumption during adolescence is more risky as the brain, just like your body, is still growing.', '0', '0,3,2,1', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(9, 9, 'To reduce the risk of harm from alcohol-related disease or injury, people over 18 should drink no more than ___ standard drinks a day.', 'The more alcohol you drink, the more harm you do to your body. For healthy men and women, drinking no more than two standard drinks on any day reduces the lifetime risk of harm from alcohol-related disease or injury.', '2', '0,3,2,1', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(10, 10, 'For healthy men and women, drinking no more than ___ standard drinks on a single occasion reduces the risk of injury.', 'The risk of alcohol-related injury increases with the amount you drink.', '4', '0,4,2,1', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(11, 11, 'A 30mL nip of spirits (40% Alc/Vol) equals ___ standard drink(s).', 'A 30mL nip of spirits is 1.0 standard drinks', '1.0', '1.0,1.2,2.0,0.7', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(12, 12, 'A 375mL can or stubbie of light beer (2.7% Alc/Vol) equals ___ standard drink(s).', 'A 375mL can or stubbie of light beer is 0.8 standard drinks.', '0.8', '1.0,0.8,0.5,1.2', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(13, 13, 'A 375mL full strength beer (4.8% Alc/Vol) equals ___ standard drink(s).', 'A 375mL full strength beer equals 1.4 standard drinks.', '1.4', '1.4,1.6,1.8,2.0', '0000-00-00 00:00:00', '2013-03-06 18:49:09');
INSERT INTO `question` VALUES(14, 14, 'A 750mL bottle of wine (14.5% Alc/Vol) equals ___ standard drink(s).', 'A 750mL bottle of wine equals 8.6 standard drinks', '8.6', '4.0,8.6,11.0,6.2', '0000-00-00 00:00:00', '2013-03-06 18:49:09');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `school_code` varchar(2) CHARACTER SET utf8 NOT NULL,
  `address` text CHARACTER SET utf8 NOT NULL,
  `date_created` datetime NOT NULL,
  `date_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`school_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` VALUES(1, 'Default School', 'zz', 'Two on the planet', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `school` VALUES(2, 'Test 2 primary', '02','here an there', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `school` VALUES(3, 'Big Primary', '03','Mars', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `school` VALUES(4, 'Tuscany Grammer', '04','Jupter', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(80) NOT NULL,
  `display_name` varchar(200) NOT NULL,
  `user_password` text,
  `school_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_mod` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;


-- --------------------------------------------------------

--
-- Table structure for table `user_events`
--


CREATE TABLE `user_events` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `game_id` int(200),
  `session_id` varchar(255) NOT NULL,
  `school_id` int(200) NOT NULL,
  `user_id` int(200),
  `milestone` text CHARACTER SET utf8 NOT NULL,
  `extra_data` text CHARACTER SET utf8,
  `number_metric1` DECIMAL(10,4),
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=362 ;

create index event_type on user_events (milestone(255));
create index event_date on user_events (date_created);
create index event_session on  user_events (session_id(255));
