CREATE TABLE `hall_types` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `type` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `status` int(11) NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci