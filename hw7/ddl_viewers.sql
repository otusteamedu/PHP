CREATE TABLE `viewers` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `type_id` int(11) unsigned NOT NULL,
    `full_name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
    `birthday` date DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `type_id` (`type_id`),
    CONSTRAINT `viewers_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `viewer_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci