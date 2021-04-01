CREATE TABLE IF NOT EXISTS `otus_cinema`.`movie` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NULL COMMENT 'наименование фильма',
  `age_limit` VARCHAR(45) NULL COMMENT 'возрастное ограничение',
  `movie_genre_id` TINYINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `fk_movie_movie_genre1_idx` (`movie_genre_id` ASC),
  CONSTRAINT `fk_movie_movie_genre1`
    FOREIGN KEY (`movie_genre_id`)
    REFERENCES `otus_cinema`.`movie_genre` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB