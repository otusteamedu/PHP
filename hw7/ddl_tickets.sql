CREATE TABLE `tickets`
(
    `customer_id` int(11) unsigned NOT NULL,
    `session_id`  int(11) unsigned NOT NULL,
    `row`         smallint(5) unsigned NOT NULL,
    `seat`        smallint(5) unsigned NOT NULL,
    `total_price` decimal(6, 2) NOT NULL,
    `sale_date`   timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `status`      tinyint(11) unsigned NOT NULL DEFAULT ''1'',
    PRIMARY KEY (`customer_id`, `session_id`) USING BTREE,
    UNIQUE KEY `session_id_row_seat` (`session_id`,`row`,`seat`) USING BTREE,
    CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `viewers` (`id`),
    CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci