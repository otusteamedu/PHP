CREATE TABLE `hall` (
    `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(32) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uidx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `movie` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(120) NOT NULL,
    `description` varchar(320) NOT NULL,
    `duration` tinyint(4) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uidx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `showtime` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `hall_id` tinyint(4) unsigned NOT NULL,
    `movie_id` int(11) unsigned NOT NULL,
    `starts_in` datetime NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_showtime_hall_id` (`hall_id`),
    KEY `fk_showtime_movie_id` (`movie_id`),
    CONSTRAINT `fk_showtime_hall_id` FOREIGN KEY (`hall_id`) REFERENCES `hall` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
    CONSTRAINT `fk_showtime_movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ticket` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `showtime_id` int(11) unsigned NOT NULL,
    `price` decimal(8,2) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `fk_ticket_showtime_id` (`showtime_id`),
    CONSTRAINT `fk_ticket_showtime_id` FOREIGN KEY (`showtime_id`) REFERENCES `showtime` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
