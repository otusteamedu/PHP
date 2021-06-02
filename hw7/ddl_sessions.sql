CREATE TABLE `sessions` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `hall_id` int(11) unsigned NOT NULL,
    `movie_id` int(11) unsigned NOT NULL,
    `price` decimal(6,2) NOT NULL,
    `time_start` datetime NOT NULL,
    `time_end` datetime NOT NULL,
    `max_viewers` smallint(5) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `hall_id` (`hall_id`),
    KEY `movie_id` (`movie_id`),
    CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`),
    CONSTRAINT `sessions_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci