CREATE TABLE IF NOT EXISTS `otus_cinema`.`room_schema` (
  `id` TINYINT NOT NULL AUTO_INCREMENT,
  `row` TINYINT NULL COMMENT 'Ряд',
  `number` TINYINT NULL COMMENT 'Место',
  `room_id` TINYINT NOT NULL,
  `seat_id` TINYINT NOT NULL,
  PRIMARY KEY (`id`, `room_id`, `seat_id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_room_schema_room1_idx` (`room_id` ASC),
  INDEX `fk_room_schema_seat1_idx` (`seat_id` ASC),
  CONSTRAINT `fk_room_schema_room1`
    FOREIGN KEY (`room_id`)
    REFERENCES `otus_cinema`.`room` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_room_schema_seat1`
    FOREIGN KEY (`seat_id`)
    REFERENCES `otus_cinema`.`seat` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB