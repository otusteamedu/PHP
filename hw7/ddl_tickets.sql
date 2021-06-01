CREATE TABLE `tickets` (
    `customer_id` int(11) unsigned NOT NULL,
    `session_id` int(11) unsigned NOT NULL,
    `status` tinyint(11) unsigned NOT NULL DEFAULT '1',
    PRIMARY KEY (`customer_id`,`session_id`) USING BTREE,
    KEY `session_id` (`session_id`),
    CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `viewers` (`id`),
    CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci