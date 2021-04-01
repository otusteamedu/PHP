CREATE TABLE IF NOT EXISTS `otus_cinema`.`ticket` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `cost` DECIMAL(6,2) NULL COMMENT 'фактическая стоимость места',
  `schedule_id` INT NOT NULL  COMMENT 'на какой сеанс билет',
  `room_schema_id` TINYINT NOT NULL COMMENT 'номер места из схемы зала',
  PRIMARY KEY (`id`, `schedule_id`, `room_schema_id`),
  INDEX `fk_ticket_schedule1_idx` (`schedule_id` ASC),
  INDEX `fk_ticket_room_schema1_idx` (`room_schema_id` ASC),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_ticket_schedule1`
    FOREIGN KEY (`schedule_id`)
    REFERENCES `otus_cinema`.`schedule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticket_room_schema1`
    FOREIGN KEY (`room_schema_id`)
    REFERENCES `otus_cinema`.`room_schema` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB