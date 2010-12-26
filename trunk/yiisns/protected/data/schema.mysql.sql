SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `aspect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `aspect` (`id`, `user_id`, `name`, `create_time`, `update_time`) VALUES
(1, 1, 'School', 1293221503, 0),
(2, 2, 'Pals', 1293221503, 0),
(3, 2, 'Home', 1293221503, 0),
(4, 1, 'Family', 1293222282, 0),
(5, 11, 'Xonica', 1293319741, 0);

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `post_id` int(11) unsigned NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_comment_user` (`user_id`),
  KEY `FK_comment_post` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `comment` (`id`, `user_id`, `post_id`, `content`, `create_time`, `update_time`) VALUES
(1, 1, 9, 'zeffdgvfegfegetrgre', 0, NULL),
(2, 1, 9, 'fgdbtyghvgefvertgfterg', 0, NULL),
(3, 1, 9, 'fhgdbgdfhvtdfhvgdfhvgdfhvg', 0, NULL),
(4, 1, 8, 'dhbtdfvhgdfterefr', 0, NULL),
(5, 1, 10, 'Test comment', 0, NULL);

CREATE TABLE IF NOT EXISTS `contact` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_contact_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact` (`user_id`, `contact_id`) VALUES
(2, 1),
(3, 1),
(4, 1),
(7, 1),
(8, 1),
(11, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 7),
(1, 8),
(1, 11);

CREATE TABLE IF NOT EXISTS `contact_aspect` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`,`aspect_id`),
  KEY `FK_contact_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact_aspect` (`user_id`, `contact_id`, `aspect_id`) VALUES
(1, 2, 1),
(1, 3, 1),
(1, 4, 1),
(1, 7, 1),
(1, 8, 1),
(2, 1, 2),
(11, 1, 5);

CREATE TABLE IF NOT EXISTS `notification` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_notification_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=ucs2;

INSERT INTO `post` (`id`, `user_id`, `content`, `create_time`, `update_time`) VALUES
(1, 1, 'This is a test post. Only my contacts who are in my aspect "School" should be able to see this.', 1293308074, NULL),
(2, 11, 'kjhgfkbghghhhhgv', 1293319323, NULL),
(3, 11, 'This is a post to Xonica, michael can see it.', 1293319855, NULL),
(4, 1, 'To school', 1293327169, NULL),
(5, 1, 'To all', 1293327193, NULL),
(6, 1, 'To all', 1293327245, NULL),
(7, 1, 'To school', 1293327257, NULL),
(8, 1, 'testing fuzzy time', 1293390785, NULL),
(9, 1, 'eeh', 1293390803, NULL),
(10, 1, 'Test Post', 1293397200, NULL);

CREATE TABLE IF NOT EXISTS `post_aspect` (
  `post_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`aspect_id`),
  KEY `FK_post_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `post_aspect` (`post_id`, `aspect_id`) VALUES
(1, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(5, 4),
(6, 4),
(8, 4),
(9, 4),
(10, 4),
(3, 5);

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) unsigned NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `request` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_request_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `request` (`user_id`, `contact_id`) VALUES
(13, 1);

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `create_ip` varchar(39) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `username`, `password`, `create_ip`, `create_time`, `update_time`) VALUES
(1, 'michael', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293221176, NULL),
(2, 'robert', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293221194, NULL),
(3, 'richie', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293229612, NULL),
(4, 'randy', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293830, NULL),
(5, 'james', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293845, NULL),
(6, 'adam', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293860, NULL),
(7, 'sabrina', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293874, NULL),
(8, 'audley', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293886, NULL),
(9, 'tyrone', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293910, NULL),
(10, 'william', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293920, NULL),
(11, 'archibald', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293929, NULL),
(12, 'maxwell', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293293946, NULL),
(13, 'jerry', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293397256, NULL);


ALTER TABLE `aspect`
  ADD CONSTRAINT `FK_aspect_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comment`
  ADD CONSTRAINT `FK_comment_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contact`
  ADD CONSTRAINT `FK_contact_contact` FOREIGN KEY (`contact_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_contact_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contact_aspect`
  ADD CONSTRAINT `FK_contact_aspect_aspect` FOREIGN KEY (`aspect_id`) REFERENCES `aspect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_contact_aspect_contact` FOREIGN KEY (`user_id`, `contact_id`) REFERENCES `contact` (`user_id`, `contact_id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `notification`
  ADD CONSTRAINT `FK_notification_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `post`
  ADD CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `post_aspect`
  ADD CONSTRAINT `FK_post_aspect_aspect` FOREIGN KEY (`aspect_id`) REFERENCES `aspect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_aspect_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `profile`
  ADD CONSTRAINT `FK_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `request`
  ADD CONSTRAINT `FK_request_contact` FOREIGN KEY (`contact_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_request_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
