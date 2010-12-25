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

INSERT INTO `aspect` (`id`, `user_id`, `name`, `create_time`, `update_time`) VALUES
(1, 1, 'School', 1293221503, 0),
(2, 2, 'Pals', 1293221503, 0),
(3, 2, 'Home', 1293221503, 0),
(4, 1, 'Family', 1293222282, 0);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `contact` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`),
  KEY `FK_contact_contact` (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact` (`user_id`, `contact_id`) VALUES
(2, 1),
(1, 2);

CREATE TABLE `contact_aspect` (
  `user_id` int(11) unsigned NOT NULL,
  `contact_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`contact_id`,`aspect_id`),
  KEY `FK_contact_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `contact_aspect` (`user_id`, `contact_id`, `aspect_id`) VALUES
(1, 2, 1),
(2, 1, 2);

CREATE TABLE `post` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_post_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=ucs2;

INSERT INTO `post` (`id`, `user_id`, `content`, `create_time`, `update_time`) VALUES
(1, 2, 'Post to pals. michael should be able to see this.', 1293221684, NULL),
(2, 2, 'fghbgdfhvvvvvghghbgdfvhgf', 1293223836, NULL),
(3, 2, 'hjcnhgf', 1293223841, NULL),
(4, 1, 'This is a post to all aspects', 1293224729, NULL),
(5, 2, 'This is a post to all aspects', 1293224777, NULL),
(6, 1, 'fvrhtbrvjyeghdfytjtrvfhervtge', 1293225370, NULL),
(7, 1, 'Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. ', 1293239561, NULL),
(8, 1, 'Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all. Everyone should be able to see this. Post to all.', 1293239585, NULL);

CREATE TABLE `post_aspect` (
  `post_id` int(11) unsigned NOT NULL,
  `aspect_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`aspect_id`),
  KEY `FK_post_aspect_aspect` (`aspect_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `post_aspect` (`post_id`, `aspect_id`) VALUES
(6, 1),
(7, 1),
(8, 1),
(1, 2),
(6, 4),
(7, 4),
(8, 4);

CREATE TABLE `profile` (
  `user_id` int(11) unsigned NOT NULL,
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

INSERT INTO `user` (`id`, `username`, `password`, `create_ip`, `create_time`, `update_time`) VALUES
(1, 'michael', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293221176, NULL),
(2, 'robert', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293221194, NULL),
(3, 'richie', '25d55ad283aa400af464c76d713c07ad', '127.0.0.1', 1293229612, NULL);


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

ALTER TABLE `profile`
  ADD CONSTRAINT `FK_profile_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `request`
  ADD CONSTRAINT `FK_request_contact` FOREIGN KEY (`contact_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_request_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
