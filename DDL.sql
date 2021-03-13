CREATE TABLE `films` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `year` tinyint DEFAULT NULL,
  `director` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `prices` (
  `id` tinyint NOT NULL AUTO_INCREMENT,
  `period` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Morning, Day, Evening, Night',
  `price` float NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `rooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `named` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'Именованное название зала',
  `seats` tinyint DEFAULT NULL COMMENT 'Количество мест в зале',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `sessions` (
  `price_id` tinyint NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `film_id` int NOT NULL,
  `beginning` datetime NOT NULL,
  `room_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sessions_FK` (`room_id`),
  KEY `sessions_FK_1` (`film_id`),
  KEY `sessions_FK_2` (`price_id`),
  CONSTRAINT `sessions_FK` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
  CONSTRAINT `sessions_FK_1` FOREIGN KEY (`film_id`) REFERENCES `films` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `sessions_FK_2` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8

CREATE TABLE `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` int NOT NULL,
  `price` float NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `tickets_FK` (`session_id`),
  CONSTRAINT `tickets_FK` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

