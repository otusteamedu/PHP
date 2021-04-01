CREATE TABLE IF NOT EXISTS `otus_cinema`.`schedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `room` TINYINT NULL COMMENT 'название зала',
  `session_start` DATETIME NULL COMMENT 'начало сеанса',
  `session_end` DATETIME NULL COMMENT 'конец сеанса',
  `cost_base` DECIMAL(6,2) NULL COMMENT 'базовая стоимость билета',
  `movie_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `fk_schedule_movie_idx` (`movie_id` ASC),
  CONSTRAINT `fk_schedule_movie`
    FOREIGN KEY (`movie_id`)
    REFERENCES `otus_cinema`.`movie` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB