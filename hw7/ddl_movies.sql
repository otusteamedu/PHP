CREATE TABLE `movies` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `imdb` decimal(2,1) NOT NULL,
    `premiere` date NOT NULL,
    `duration` time NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci