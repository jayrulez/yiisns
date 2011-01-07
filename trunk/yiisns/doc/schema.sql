
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";




CREATE TABLE `aspect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE `comment` (
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



CREATE TABLE `contact` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_contact_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `contact_aspect` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`,`aspect_id`),
  KEY `FK_contact_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `notification` (
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



CREATE TABLE `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `photo_album_id` int(11) unsigned DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_photo_user` (`user_id`),
  KEY `FK_photo_photo_album` (`photo_album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE `photo_album` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `cover_photo_id` int(11) unsigned DEFAULT NULL,
  `caption` tinytext NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`type`(1),`name`),
  KEY `FK_photo_album_cover_photo` (`cover_photo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;



CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=ucs2;



CREATE TABLE `post_aspect` (
  `post_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`aspect_id`),
  KEY `FK_post_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `profile` (
  `user_id` int(11) unsigned NOT NULL,
  `photo_id` int(11) DEFAULT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `gender` tinyint(1) unsigned NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `request` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_request_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `create_ip` varchar(39) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


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

ALTER TABLE `photo`
  ADD CONSTRAINT `FK_photo_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_photo_photo_album` FOREIGN KEY (`photo_album_id`) REFERENCES `photo_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `photo_album`
  ADD CONSTRAINT `FK_photo_album_cover_photo` FOREIGN KEY (`cover_photo_id`) REFERENCES `photo` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_photo_album_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
