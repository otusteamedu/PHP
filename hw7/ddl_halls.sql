CREATE TABLE `halls` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `cinema_id` int(11) unsigned NOT NULL,
    `type_id` int(11) unsigned NOT NULL,
    `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `rows` smallint(5) unsigned NOT NULL,
    `seats` smallint(5) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY `cinema_id` (`cinema_id`),
    KEY `type_id` (`type_id`),
    CONSTRAINT `halls_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinemas` (`id`),
    CONSTRAINT `halls_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `hall_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci