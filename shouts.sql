CREATE TABLE IF NOT EXISTS `shouts` (
  `shout_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `shout` text NOT NULL,
  `shout_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`shout_id`)
)