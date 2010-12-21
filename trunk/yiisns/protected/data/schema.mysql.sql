SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `aspect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `contact` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_contact_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `contact_aspect` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`,`aspect_id`),
  KEY `FK_contact_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2;

CREATE TABLE IF NOT EXISTS `post_aspect` (
  `post_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`aspect_id`),
  KEY `FK_post_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `request` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_request_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `create_ip` varchar(39) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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

ALTER TABLE `post`
  ADD CONSTRAINT `FK_post_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `post_aspect`
  ADD CONSTRAINT `FK_post_aspect_aspect` FOREIGN KEY (`aspect_id`) REFERENCES `aspect` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_post_aspect_post` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `request`
  ADD CONSTRAINT `FK_request_contact` FOREIGN KEY (`contact_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_request_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
